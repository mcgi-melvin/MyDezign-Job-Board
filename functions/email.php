<?php
//$mailData['api_key'] = '7a1c109ae792a8602b8db8e05ce1c158-us18'; // DUMMY API
$mailData = [];
$mailData['data'] = [];
$mailData['api_key'] = get_field('MC_api_key','option');
$mailData['server'] = substr($mailData['api_key'],strpos($mailData['api_key'],'-')+1);
$mailData['request'] = ''; // POST, GET, PUT, DELETE
$mailData['errors'] = ['400','401','403','404','405','414','422','429','500'];

/* CRON JOBS */
add_action( 'init', function () {
	if (! wp_next_scheduled ( 'daily_jobs' )) {
	   wp_schedule_event(time(), 'daily', 'daily_jobs');
	}
	add_action('daily_jobs', 'createCampaign');
});

function genericMCCurl($mailData){
  // send a HTTP POST request with curl
  $data = json_encode($mailData['data']);
  $api_endpoint = 'https://'.$mailData['server'].'.api.mailchimp.com/3.0/' . $mailData['url'];
  $curl = curl_init();
  curl_setopt_array($curl, array(
     CURLOPT_URL => $api_endpoint,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_CUSTOMREQUEST => $mailData['request'],
     CURLOPT_POSTFIELDS => $data,
     CURLOPT_HTTPHEADER => array(
          "Content-Type: application/json",
          "authorization: apikey ". $mailData['api_key']
     ),
  ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  if ($err) {
     $response = $err;
  }
  $response = json_decode($response, true);
  foreach($response as $d){
	  $data .= $d. "\n";
  }
  file_put_contents('logs.txt', '['.date().']: '. $data.PHP_EOL , FILE_APPEND | LOCK_EX);
  return $response;
}

function getLastCampaignID(){
  global $mailData;
  $mailData['url'] = 'campaigns?status=save&sort_field=create_time&sort_dir=DESC&count=1';
  $mailData['request'] = 'GET';
  $mailData['data'] = array(
    'list_id' => get_field('MC_candidate_list_id','option'),
  );
  $response = genericMCCurl($mailData);
  $mailData['campaignID'] = $response['campaigns'][0]['id'];
  $mailData['campaignWebID'] =  $response['campaigns'][0]['web_id'];
  return $mailData;
}

function createCampaign(){
  global $mailData;
  $subject = !empty( get_field('MC_subject_line','option') ) ? get_field('MC_subject_line','option') : 'No Subject';
  $title = !empty( get_field('MC_email_title','option') ) ? get_field('MC_email_title','option') : 'No Title';
  $mailData['url'] = 'campaigns';
  $mailData['request'] = 'POST';
  $mailData['data'] = array(
    "recipients" => array(
      "list_id" => get_field('MC_candidate_list_id','option')
      ),
    "type" => "regular",
    "settings" => array(
      "subject_line" => $subject,
      "title" => $title,
      "reply_to" => get_field('MC_reply_to','option'),
      "from_name" => get_field('MC_from_name','option'),
      "template_id" => intval(get_field('MC_template_id','option'))
    ),
  );

  $response = genericMCCurl($mailData);
  if($response){
    updateTemplate();
  }
}

function sendCampaign(){
  global $mailData;
  $campaign_id = getLastCampaignID();
  $mailData['request'] = 'POST';
  $mailData['url'] = 'campaigns/'.$campaign_id['campaignID'].'/actions/send';

  genericMCCurl($mailData);
}

function updateTemplate(){
  global $mailData;
  $campaign_id = getLastCampaignID();
  $jobs = '';
	if(empty($jobs)){
		$jobs = getLatestJob();
	}
  $mailData['request'] = 'PUT';
  $mailData['url'] = 'campaigns/'.$campaign_id['campaignID'].'/content';
  $mailData['data'] = [
    'template' => [
      'id' => intval(get_field('MC_template_id','option')),
      'sections' => $jobs
    ],
  ];
  $response = genericMCCurl($mailData);
  if($response){
    sendCampaign();
  }
}

function getTemplateID(){
  global $mailData;
  $mailData['request'] = 'GET';
  $mailData['url'] = 'templates?type=user&count=1';

  $response = genericMCCurl($mailData);
  return $response['templates'][0]['id'];
}

function createTemplate(){
  global $mailData;
  $mailData['request'] = 'POST';
  $mailData['url'] = 'templates';
  $mailData['data'] = array(
    'name' => 'Daily Job Update',
    'html' => file_get_contents(get_template_directory_uri() . '/template-parts/email/email-job-update.html'),
  );
  genericMCCurl($mailData);
}

function getLatestJob(){
  $jobData = [];
  $args = array(
		'post_type'=>'job_listing',
		'posts_per_page'=>5,
		'meta_query' => array(
			array(
				'key' => '_featured',
				'value' => 1
			),
		),
	);
  $query = new WP_Query($args);
  if ( $query->have_posts() ) {
    $i = 1;
    while ( $query->have_posts() ) {
			$query->the_post();
			$jobData['list_'.$i] = '<h2>'.get_the_title().'</h2><p>'.substr(strip_tags(get_the_content()), 0, 250).'</p><div style="text-align: center;"><a href="'. get_permalink() .'" style="background-color:#0e88a7;padding:10px 20px;color:#FFFFFF;text-decoration:none;">Learn More</a></div>';
			$i++;

    }
  }
	if (!empty($jobData)){
		return $jobData;
	}
}


add_action('wp_head','test_header');
function test_header(){

  if(isset($_GET['create_campaign'])){
    createCampaign();
  }

  if(isset($_GET['get_campaign'])){
    echo getLastCampaignID();
  }

  if(isset($_GET['create_template'])){
    createTemplate();
  }

  if(isset($_GET['get_template'])){
    getTemplateID();
  }

  if(isset($_GET['update_template'])){
    updateTemplate();
  }

	if(isset($_GET['get_latest_job'])){
		getLatestJob();
	}
}














?>
