<div id="JEPH_joblist_loop">
  <?php
  $paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
  $s = ""; // DEFAULT SEARCH KEYWORD
  $location_query = array( 'key' => '_job_location' ); // DEFAULT META QUERY LOCATION
  $tax_query = array( // DEFAULT TAX QUERY
    'taxonomy' => 'job_listing_category',
    'field'    => 'term_id',
    'terms'    => array( 1, 999999999 ),
    'operator' => 'BETWEEN',
  );

  if( isset($_GET['q']) && $_GET['q'] !== "" ){
    $keyword = sanitize_text_field($_GET['q']);
    $s = "s => $keyword,";
  }
  if(isset($_GET['job_category']) && $_GET['job_category'] !== ""){
    $category_id = intval( $_GET['job_category'] );
    $tax_query = array(
      'taxonomy'=> 'job_listing_category',
      'field' => 'term_id',
      'terms' => $category_id
    );

  }

  if( isset($_GET['job_address']) && $_GET['job_address'] !== "" ){
    $location_query = array(
      'key' => '_job_location',
      'value' => sanitize_text_field($_GET['job_address']),
      'compare' => 'LIKE',
    );
  }
  //$salary = $salary === "" ? array(0,999999999) : explode(',',$salary );
  $post_number = 10;
  $args = array(
    'post_type' => 'job_listing',
    'posts_per_page' => $post_number,
    'paged' => $paged,
    'meta_query' => array(
      $location_query,
    ),
    'tax_query' => array(
      'relation' => 'OR',
      $tax_query
    ),
    $s // Search this Keyword


  );
  do_action('getJobList', $args, __( 'joblist-wrapper mb-2', 'textdomain' ) );


  ?>
</div>
