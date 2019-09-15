<?php

add_filter( 'submit_job_form_fields', 'frontend_add_salary_field' );
function frontend_add_salary_field( $fields ) {
  $fields['job']['job_salary'] = array(
    'label'       => __( 'Salary (PHP)', 'job_manager' ),
    'type'        => 'text',
    'required'    => true,
    'placeholder' => 'e.g. 200',
    'priority'    => 7
  );
  return $fields;
}

add_filter( 'job_manager_job_listing_data_fields', 'admin_add_salary_field' );
function admin_add_salary_field( $fields ) {
  $fields['_job_salary'] = array(
    'label'       => __( 'Salary (PHP)', 'job_manager' ),
    'type'        => 'text',
    'placeholder' => 'e.g. 200',
    'description' => ''
  );
  return $fields;
}

add_action( 'single_job_listing_meta_end', 'display_job_salary_data' );
function display_job_salary_data() {
  global $post;

  $salary = get_post_meta( $post->ID, '_job_salary', true );

  if ( $salary ) {
    echo '<li>' . __( 'Salary:' ) . ' PHP' . esc_html( $salary ) . '</li>';
  }
}

// SALARY SEARCH FUNCTION
add_filter( 'job_manager_get_listings', 'filter_by_salary_field_query_args', 10, 2 );
function filter_by_salary_field_query_args( $query_args, $args ) {
  if ( isset( $_POST['form_data'] ) ) {
    parse_str( $_POST['form_data'], $form_data );
    // If this is set, we are filtering by salary
    if ( ! empty( $form_data['filter_by_salary'] ) ) {
      $selected_range = sanitize_text_field( $form_data['filter_by_salary'] );
      switch ( $selected_range ) {
        case 'upto20' :
          $query_args['meta_query'][] = array(
            'key'     => '_job_salary',
            'value'   => '200',
            'compare' => '<',
            'type'    => 'NUMERIC'
          );
        break;
        case 'over60' :
          $query_args['meta_query'][] = array(
            'key'     => '_job_salary',
            'value'   => '600',
            'compare' => '>=',
            'type'    => 'NUMERIC'
          );
        break;
        default :
          $query_args['meta_query'][] = array(
            'key'     => '_job_salary',
            'value'   => array_map( 'absint', explode( '-', $selected_range ) ),
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC'
          );
        break;
      }
      // This will show the 'reset' link
      add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
    }
  }
  return $query_args;
}

add_action('joblist_loop','_joblist_loop');
function _joblist_loop(){
  $meta = get_post_meta(get_the_ID());
?>
<div class="joblist-container">
  <a href="<?php echo get_the_permalink(); ?>">
    <h3><?php echo get_the_title(); ?></h3>
  </a>
  <table class="table table-borderless">
    <tbody>
    <tr>
      <td>
        <time><i class="fa fa-calendar" style="font-weight: 100;"></i> <?php echo get_the_date(); ?></time>
      </td>
      <td>
        <?php if(!empty($meta['_job_salary'][0])): ?>
          <div class="salary"><i class="fa fa-coins"></i> <?php echo $meta['_job_salary'][0]; ?></div>
        <?php endif; ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php if(!empty($meta['_company_name'][0])): ?>
          <a href="<?php echo !empty($meta['_company_website'][0]) ? $meta['_company_website'][0] : '#'; ?>">
            <div class="company"><i class="fa fa-building"></i> <?php echo $meta['_company_name'][0]; ?></div>
          </a>
        <?php endif ?>
      </td>
      <td>
        <?php if(!empty($meta['_job_location'][0])): ?>
          <div class="company"><i class="fa fa-globe-asia"></i> <?php echo $meta['_job_location'][0]; ?></div>
        <?php endif ?>
      </td>
    </tr>
    </tbody>
  </table>
  <p><?php echo substr(get_the_content(), 0, 200); ?></p>
  <div class="ApplyNow text-center mt-5 mb-3">
    <a class="theme_button text-uppercase" href="<?php echo !empty($meta['_company_website'][0]) ? $meta['_company_website'][0] : get_permalink(); ?>">Apply Now</a>
  </div>
</div>
<?php
}

add_action('getJobList','_getJobList', 10, 2);
function _getJobList($args = [], $class){

  $the_query = new WP_Query( $args );
  if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) :
      $the_query->the_post();
      do_action('JEPH_loop_start',__( $class, 'jobemployph' ));
      do_action('joblist_loop');
      do_action('JEPH_loop_end');
    endwhile;
    wp_reset_postdata();
  else:
    echo 'No Results Found';
  endif;
}

add_action('JEPH_loop_start','_loop_start');
function _loop_start($class){
  echo '<div class="'.$class.'">';
}

add_action('JEPH_loop_end','_loop_end');
function _loop_end(){
  echo '</div>';
}


?>
