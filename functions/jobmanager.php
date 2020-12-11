<?php

add_action('wp_ajax_jeph_add_job','_jeph_add_job');
add_action('wp_ajax_nopriv_jeph_add_job','_jeph_add_job');
function _jeph_add_job(){
  if ( ! isset( $_POST['submit_job'] ) || ! wp_verify_nonce( $_POST['submit_job'], 'jeph_add_job' ) ) {
    print 'Something Went Wrong';
    exit;
  }

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  $_SESSION['message_response'] = 'Something Went Wrong!';

  $referrer = isset( $_POST['_wp_http_referer'] ) ? removeParam( sanitize_text_field( $_POST['_wp_http_referer'] ), 'job_submitted' ) : '' ;

  $job_title = sanitize_text_field( $_POST['job_title'] );
  $job_salary = sanitize_text_field( $_POST['salary'] );
  $job_location = sanitize_text_field( $_POST['job_location'] );
  $job_type = (int)$_POST['job_type'];
  $job_category = (int)$_POST['job_category'];
  $job_description = wp_kses_post( $_POST['job_description'] );

  $application_email = sanitize_email( $_POST['application_email'] );
  $mobile_number = sanitize_text_field( $_POST['mobile_number'] );
  $telephone_number = sanitize_text_field( $_POST['telephone_number'] );
  $application_form = esc_url_raw( $_POST['application_form'] );

  $company_name = sanitize_text_field( $_POST['company_name'] );
  $company_website = esc_url_raw( $_POST['company_website'] );

  $author_id = isset( $_POST['author'] ) ? (int)Cryptor::decrypt( $_POST['author'] ) : 0;

  $post_name = str_replace( '/[^a-zA-Z0-9]/', '-', strtolower( $job_title ) );
  
  if( !empty( $company_name ) ) {
    $post_name .= "-" . str_replace( '/[^a-zA-Z0-9]/', '-', strtolower( $company_name ) );
  }

  $job_id = wp_insert_post([
    'post_type'     =>  'job_listing',
    'post_title'    =>  $job_title,
    'post_name'     =>  $post_name . '-' . uniqid(),
    'post_author'   =>  $author_id,
    'post_content'  =>  $job_description,
    //'post_status'   =>  'publish'
  ]);
  if( !is_wp_error( $job_id ) ):

    update_field( '_job_location', $job_location, $job_id );
    update_field( '_application', $application_email, $job_id );
    update_field( '_job_salary', $job_salary, $job_id );
    update_field( 'HB_mobile_number', $mobile_number, $job_id );
    update_field( 'HB_telephone_number', $telephone_number, $job_id );
    update_field( 'application_form_link', $application_form, $job_id );
    update_field( '_company_name', $company_name, $job_id );
    update_field( '_company_website', $company_website, $job_id );
    
    /**
     * Set Taxonomy for the post
     */
    wp_set_object_terms( $job_id, array( $job_type ), 'job_listing_type' );
    wp_set_object_terms( $job_id, $job_category, 'job_listing_category' );

    if ( wp_redirect( $referrer . '/?job_submitted=success' ) ) {
      $_SESSION['message_response'] = 'Job Added Successfully';
      exit;
    }
  endif;

  if ( wp_redirect( $referrer . '/?job_submitted=failed' ) ) {
    exit;
  }

}


?>
