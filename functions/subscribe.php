<?php

add_action('wp_ajax_submit_application','_submit_application');
add_action('wp_ajax_nopriv_submit_application','_submit_application');
function _submit_application(){
  if ( ! isset( $_POST['application_id'] ) || ! wp_verify_nonce( $_POST['application_id'], 'application_form' ) ) {
    print 'Something Went Wrong';
    exit;
  }

  $wp_upload_dir = wp_upload_dir();

  $job_id = (int)$_POST['job_id'];
  $job_title  = sanitize_text_field( $_POST['job_title'] );
  $referrer = isset( $_POST['_wp_http_referer'] ) ? removeParam( sanitize_text_field( $_POST['_wp_http_referer'] ), 'application_submitted' ) : '' ;
  $applicant_name = sanitize_text_field( $_POST['name'] );
  $applicant_email = sanitize_email( $_POST['email'] );
  $applicant_phone = $_POST['phone'];
  $subject = sanitize_text_field( $_POST['subject'] );
  $message = sanitize_textarea_field( $_POST['message'] );

  /**
   * Processed File to Upload
   */
  
  $attachment_id = 0;
  $attachment = [];

  if( isset( $_FILES['cv'] ) && !empty( $_FILES['cv']["name"] ) ) {
    $filename = $wp_upload_dir['basedir'] . '/' . date('Y') . '/' . date('m') . '/' . 'JOBEMPLOYPH_cv_' . uniqid() . '.' . strtolower( pathinfo( $_FILES["cv"]["name"], PATHINFO_EXTENSION ) );
    $upload = wp_upload_bits( basename( $filename ), null, file_get_contents( $_FILES['cv']['tmp_name'] ) );
    $filetype = wp_check_filetype( basename( $filename ), null );

    $attachment_args = array(
        'guid'           => $filename,
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );
    $attachment_id = wp_insert_attachment( $attachment_args, $filename );
    $attachment = get_attached_file( $attachment_id );
  }

  /**
   * Log Applicant inputted data
   */

  $logs_dir = $wp_upload_dir['basedir'] . '/application_log';
  if ( ! is_dir( $logs_dir ) ) {
      mkdir( $logs_dir, 0755, true );
  }
  $txt = date("F j, Y, g:i a") . ' : "submit_application" result for {' . $_POST['name'] . ' : '. $_POST['email'] . ' : ' . $_POST['phone'] . ' : Attachment ID ' . $attachment_id . ' : ' . $attachment . ' } = ' . PHP_EOL;
  $file = fopen( $logs_dir . '/' . 'log_' . date("F-j-Y") . '.log', 'a' );
  fwrite($file, $txt);
  fclose($file);

  /**
   * Save Application to Database
   */

  $application_id = wp_insert_post(array(
    'post_type'     =>  'application',
    'post_title'    =>  $subject,
    'post_name'     =>  md5( $subject . uniqid() ),
    'post_content'  =>  $message,
    'post_status'   =>  'publish'

  ));
  if( !is_wp_error( $application_id ) ){
    
    /**
     * Update Fields
     */
    update_field( 'name', $applicant_name, $application_id );
    update_field( 'phone', $applicant_phone, $application_id );
    update_field( 'email_address', $applicant_email, $application_id );
    update_field( 'job_applied', $job_id, $application_id );
    if( $attachment_id !== 0 ) {
      update_field( 'file', $attachment_id, $application_id );
    }
    /**
     * Save Subscriber if the checkbox is checked
     */
    if( isset( $_POST['approve_mailing'] ) && $_POST['approve_mailing'] ) {
      add_subscriber( $applicant_email, $applicant_name );
    }
    
  }

  /**
   * Send Application to Employer
   */

  if( is_email( $_POST['mailto'] ) ):
    $employer_email = sanitize_email( $_POST['mailto'] );
    $param = [
        'job_link'          =>  site_url( $referrer ),
        'job_title'         =>  $job_title,
        'phone'             =>  $applicant_phone,
        'email'             =>  $applicant_email,
        'applicant'         =>  $applicant_name,
        'subject'           =>  $subject,
        'message'           =>  $message
    ];
    
    $body = email_application_to_employer_exec( $param );
    
    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>', 'Bcc: employer-application@jobemployph.tk');
    $result = wp_mail( $employer_email, $subject, $body, $headers, $attachment );
    if( $result ) {
      log_cron( date("F j, Y, g:i a") . ' : "send_application_to_employer" result for {' . $application_id . ' : '. get_field( 'name', $application_id ) . ' : ' . get_field( 'email', $application_id ) .'} = ' . $result );
      update_field( 'sent_to_employer', 'sent', $application_id );
    }
  endif;

  if ( wp_redirect( $referrer . '/?application_submitted=1' ) ) {
    exit;
  }
}

/**
 * Add Subscriber Function
 * It will save the subscriber to Database
 */

function add_subscriber( $email, $name, $source = "" ) {

  if( !is_email( $email ) ) {
    return false;
  }

  $post_type = 'subscriber';

  $args = [
    'post_type'       =>  $post_type,
    'meta_key'        =>  'email',
    'meta_value'      =>  $email,
    'posts_per_page'  => 1
  ];
  $posts = get_posts( $args );

  if( count( $posts ) > 0 ) {
    return false;
  }

  $subscriber_id = wp_insert_post(array(
    'post_type'     =>  $post_type,
    'post_title'    =>  $email .' '.$name,
    'post_name'     =>  md5( $email . ' ' . $name . uniqid() ),
    'post_content'  =>  '',
    'post_status'   =>  'publish'
  ));

  if( !is_wp_error( $subscriber_id ) ):
    update_field( 'email', $email, $subscriber_id );
    update_field( 'name', $name, $subscriber_id );
    update_field( 'subscriber_type', 'applicant', $subscriber_id );
    if( !empty( $source ) ) {
      update_field( $source, 'yes', $subscriber_id );
      update_field( 'welcome_email', 'sent', $subscriber_id );
    }
  endif;

}

add_action('wp_ajax_update_subscriber','update_subscriber_exec');
add_action('wp_ajax_nopriv_update_subscriber','update_subscriber_exec');
function update_subscriber_exec(){
  if ( ! isset( $_POST['subscriber_update'] ) || ! wp_verify_nonce( $_POST['subscriber_update'], 'subscriber_form' ) ) {
    print 'Something Went Wrong';
    exit;
  }

  $referrer = isset( $_POST['_wp_http_referer'] ) ? removeParam( sanitize_text_field( $_POST['_wp_http_referer'] ), 'i' ) : '' ;

  $subscriber_id = (int)$_POST['subscriber_id'];
  $desired_salary = preg_replace( '/\D/', '', sanitize_text_field( $_POST['desired_salary'] ) );
  $location = sanitize_text_field( $_POST['location'] );
  $skills = $_POST['skills'];

  update_field( 'desired_salary', $desired_salary, $subscriber_id );
  update_field( 'location', $location, $subscriber_id );
  update_field( 'skills', $skills, $subscriber_id );

  if ( wp_redirect( site_url() ) ) {
    exit;
  }
}

?>
