<?php
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
$offset = $paged != 1 ? "'offset' => ".$posts_per_page."" : "";
$posts_per_page = 9;
$args = array (
    'paged' => $paged,
    'number' => $posts_per_page,
    'role__in' => array('candidate','iwj_candidate'),
    'orderby' => 'DESC',
    $offset
);
$wp_user_query = new WP_User_Query($args);
$authors = $wp_user_query->get_results();
$candidate_count = count($authors);
//print_r($authors);
$total_pages = ceil( $wp_user_query->get_total() / $posts_per_page );
?>

<style>
  .profile-image img{ display: block; margin: 0 auto; max-width: 100%; max-height: auto;}
  .jobseeker-wrapper{margin: 30px 0;}
  .single-loop-jobseeker{box-shadow: 0px 0px 3px #456672;}
  .jobseeker-info{padding: 10px;}
  .skills ul{padding: 0;}
  .skills li{display: inline-block; background-color: #d7d7d7; font-size: 13px; margin:2px; padding: 2px; border-radius: 2px; cursor:default;}
  .jobseeker-pagination-wrapper{margin-top: 30px; margin-bottom: 30px;}
  .page-numbers{padding: 0; text-align: center;}
  .page-numbers li{display: inline-block;}
</style>
<div class="loop-jobseeker">
  <div class="row">
  <?php
    foreach($authors as $candidate){
      $candidate_profile = get_field('my_profile', 'user_'.$candidate->ID);
      if($candidate_profile['profile_image'] == ""){
        $profile_image = get_template_directory_uri() .'/images/image-none.png';
      }else{
        $profile_image = $candidate_profile['profile_image'];
      }
      //print_r($candidate_profile);
    ?>
  <div class="col-md-3">
    <div class="single-loop-jobseeker card">
      <div class="profile-image">
        <img class="img-circle card-img-top" src="<?php echo $profile_image; ?>">
      </div>
      <div class="jobseeker-info card-body">
        <div class="name card-title"><strong><?php echo $candidate->first_name .' '.$candidate->last_name; ?></strong></div>
        <div class="bio card-text">
          <?php
          if($candidate->description){
            echo substr($candidate->description, 0, 150);
          }else{
            echo 'No Bio';
          }
           ?>
        </div>
        <hr />
        <div class="skills card-text">
          <ul>
          <?php
            if(count($candidate_profile['skills']) != 1){
              $min_count = count($candidate_profile['skills'])-1;
            }else{
              $min_count = count($candidate_profile['skills']);
            }
            for($x = 0; $x <= min($min_count,4); $x++){
              echo '<li>'.$candidate_profile['skills'][$x].'</li>';
            }
          ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php } // END FOREACH ?>
  </div> <!--END ROW-->
  <div class="jobseeker-pagination-wrapper">

    <?php
    echo paginate_links( array(
        'base' => str_replace( 99999, '%#%', esc_url( get_pagenum_link( 99999 ) ) ), // the base URL, including query arg
        'format' => '/%#%/', // this defines the query parameter that will be used, in this case "p"
        'prev_text' => __('&laquo; Previous'), // text for previous page
        'next_text' => __('Next &raquo;'), // text for next page
        'total' => $total_pages, // the total number of pages we have
        'current' => $paged, // the current page
        'end_size' => 1,
        'mid_size' => 5,
        'type' => 'list'
    ));

     ?>
  </div>
</div>
