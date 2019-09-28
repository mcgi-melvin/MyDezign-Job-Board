<div id="JEPH_joblist_loop">
  <?php
  $paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
  $q = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
  if(isset($_GET['job_salary']) && $_GET['job_salary'] !== ""){
    $salary_query = array(
          'key' => '_job_salary',
          'value' => sanitize_text_field($_GET['job_salary']),
          'compare' => 'BETWEEN',
          'type' => 'NUMERIC'
      );
  } else { $salary_query = array(); }
  if(isset($_GET['job_address'])){
    $location_query = array(
          'key' => '_job_location',
          'value' => sanitize_text_field($_GET['job_address']),
          'compare' => 'LIKE',
      );
  } else { $location_query = array(); }
  //$salary = $salary === "" ? array(0,999999999) : explode(',',$salary );
  $post_number = 10;
  $args = array(
    'post_type' => 'job_listing',
    'posts_per_page' => $post_number,
    'paged' => $paged,
    's' => $q,
    'meta_query' => array(
      $salary_query,
      $location_query,
    ),
    /*
    'tax_query' => array(
      'taxonomy'=> 'job_listing_category',
      'field' => 'slug',
      'terms' => 'call-center'
    ),
    */
  );
  do_action('getJobList', $args, __( 'joblist-wrapper mb-2', 'textdomain' ) ); ?>

</div>
