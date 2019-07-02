<?php
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
$offset = $paged != 1 ? "'offset' => ".$posts_per_page."" : "";
$posts_per_page = 12;
$args = array (
    'paged' => $paged,
    'number' => $posts_per_page,
    'role__in' => array('candidate','iwj_candidate','customer'),
    'orderby' => 'DESC',
    $offset
);
$wp_user_query = new WP_User_Query($args);
$authors = $wp_user_query->get_results();
$candidate_count = count($authors);
//print_r($authors);
$total_pages = ceil( $wp_user_query->get_total() / $posts_per_page );
?>
<div class="page-title text-center">
  <h2>Job Seekers</h2>
</div>
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

      if($candidate->first_name == "" && $candidate->last_name == ""){
        $name = $candidate->user_nicename;
      }else{
        $name = $candidate->first_name .' '.$candidate->last_name;
      }
      //print_r($candidate_profile);
    ?>
  <div class="col-md-3">
    <div class="single-loop-jobseeker">
      <div class="profile-image">
        <a href="?cid=<?php echo $candidate->ID; ?>">

          <div style="background-image: url(<?php echo $profile_image; ?>); background-position: center; background-size: cover; height: 200px;"></div>
        </a>
      </div>
      <div class="jobseeker-info card-body">
        <div class="name card-title"><strong><?php echo $name; ?></strong></div>
        <div class="bio card-text">
          <?php
          if($candidate_profile['bio']){
            echo substr($candidate_profile['bio'], 0, 150);
          }else{
            echo 'To know more about me visit my profile.';
          }
           ?>
        </div>
        <hr />
        <div class="skills card-text">
          <ul>
          <?php
            if(count($candidate_profile['skills']) != 1){
              $min_count = count($candidate_profile['pskills'])-1;
            }else{
              $min_count = count($candidate_profile['pskills']);
            }
            for($x = 0; $x <= min($min_count,4); $x++){
              echo '<li>'.$candidate_profile['pskills'][$x].'</li>';
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
        'mid_size' => 2,
        'type' => 'list'
    ));

     ?>
  </div>
</div>
