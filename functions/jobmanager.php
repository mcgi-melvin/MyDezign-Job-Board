<?php

add_filter( 'submit_job_form_fields', 'frontend_add_salary_field' );
function frontend_add_salary_field( $fields ) {
  $fields['job']['job_salary'] = array(
    'label'       => __( 'Salary ($)', 'job_manager' ),
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
    'label'       => __( 'Salary ($)', 'job_manager' ),
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
    echo '<li>' . __( 'Salary:' ) . ' $' . esc_html( $salary ) . '</li>';
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



?>
