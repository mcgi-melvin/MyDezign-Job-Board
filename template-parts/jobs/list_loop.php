<div id="JEPH_joblist_loop">
  <?php
  $paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
  $q = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
  $address = isset($_GET['job_address']) ? sanitize_text_field($_GET['job_address']) : '';
  $salary = isset($_GET['job_salary']) ? sanitize_text_field($_GET['job_salary']) : '';
  $salary = $salary === "" ? array(0,999999999) : str_split( str_replace(',', '', $salary), strpos($salary, ',') );
  $post_number = 10;
  $args = array(
    'post_type' => 'job_listing',
    'posts_per_page' => $post_number,
    'paged' => $paged,
    's' => $q,
    'meta_query' => array(
      'relation' => 'AND',
      array(
        'key' => '_job_location',
        'value' => $address,
        'compare' => 'LIKE',
      ),
      array(
        'key' => '_job_salary',
        'value' => $salary,
        'compare' => 'BETWEEN',
        'type' => 'NUMERIC'
      ),
    ),
    'orderby' => '_job_salary',
  );
  do_action('getJobList', $args, __( 'joblist-wrapper mb-2', 'textdomain' ) ); ?>

</div>
