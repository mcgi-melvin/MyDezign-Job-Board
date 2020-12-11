<?php

header('Access-Control-Allow-Origin: *');

function get_job_list_api( $request ) {
    // Get all the parameters:
    //$params = $request->get_params();

    $all = [];
    $jobs = [];

    $l = $request->get_param( 'limit' ) ?? 20;
    $cp = $request->get_param( 'paged' ) ?? 1;
    $args = [
        'post_type'         =>  'job_listing',
        'posts_per_page'    =>  $l,
        'paged'             =>  $cp,
        'post_status'       =>  'publish'
    ];
    if( $request->get_param( 'q' ) ) {
        $args['s'] = sanitize_text_field( $request->get_param( 'q' ) );
    }
    if( $request->get_param( 'location' ) ) {
        $args['meta_query'][] = array(
            'key'       =>  '_job_location',
            'value'     =>  sanitize_text_field( $request->get_param( 'location' ) ),
            'compare'   =>  'LIKE'
        );
    }
    if( $request->get_param( 'type' ) ) {
        $args['tax_query'][] = array(
            'taxonomy'  =>  'job_listing_type',
            'terms'     =>  (int)$request->get_param( 'type' )
        );
    }
    if( $request->get_param( 'category' ) ) {
        $args['tax_query'][] = array(
            'taxonomy'  =>  'job_listing_category',
            'field'     =>  'term_id',
            'terms'     =>  (int)$request->get_param( 'category' )
        );
    }
    $jobs_posts = get_posts( $args );
    if( $jobs_posts ):
        foreach( $jobs_posts as $job ):
            $job_type = wp_get_post_terms( $job->ID, 'job_listing_type' )[0];
            $a_job_type['id'] = $job_type->term_id;
            $a_job_type['name'] = $job_type->name;

            $a = [];
            $a['job_id'] = $job->ID;
            $a['title'] = html_entity_decode( get_the_title( $job->ID ) );
            $a['excerpt'] = wp_trim_words( get_the_content( null, false, $job->ID ), 50, '' );
            $a['date_posted'] = get_the_date( '', $job->ID );
            $a['job_salary'] = get_field( '_job_salary', $job->ID );
            $a['job_type'] = $a_job_type;
            $a['job_location'] = get_field( '_job_location', $job->ID );
            $a['company_name'] = get_field( '_company_name', $job->ID );
            $jobs[] = $a;
        endforeach;
    endif;

    $all['jobs'] = $jobs;
    $all['total_pages'] = wp_count_posts( 'job_listing' )->publish / $l;
    $all['args'] = $args;

    echo json_encode( $all );
}

function get_job_api( $request ) {
    
    if( !$request->get_param( 'id' ) ) {
        die();
    }

    $job_id = (int)$request->get_param( 'id' );
    $args = [
        'post_type'         =>  'job_listing',
        'posts_per_page'    =>  1,
        'p'                 =>  $job_id
    ];
    $job = get_posts( $args )[0];
    if( is_wp_error( $job ) ) {
        die();
    }
    $job_type = wp_get_post_terms( $job->ID, 'job_listing_type' )[0];
    $a_job_type['id'] = $job_type->term_id;
    $a_job_type['name'] = $job_type->name;

    $job_response = [
        'job_id'        =>  $job->ID,
        'title'         =>  html_entity_decode( get_the_title( $job->ID ) ),
        'content'       =>  $job->post_content,
        'date_posted'   =>  get_the_date( '', $job->ID ),
        'job_salary'    =>  get_field( '_job_salary', $job->ID ),
        'job_type'      =>  $a_job_type,
        'job_location'  =>  get_field( '_job_location', $job->ID ),
        'company_name'  =>  get_field( '_company_name', $job->ID ),
        'apply'         =>  array(
            'url'       =>  get_field( 'application_form_link', $job->ID ),
            'email'     =>  get_field( '_application', $job->ID ),
            'mobile'    =>  get_field( 'HB_mobile_number', $job->ID ),
            'tel'       =>  get_field( 'HB_telephone_number', $job->ID )
        )
    ];

    echo json_encode( $job_response );
}

function send_application_api( $request ) {

    $wp_upload_dir = wp_upload_dir();
    $attachment_id = 0;
    $attachment = [];
    $response = [
        'status'    =>  0,
        'message'   =>  'Something went wrong'
    ];

    if( empty( $request['key'] ) && decode_key( $request['key'] ) != 'jobemployph' ) {
        return $response;
    }
    
    if( empty( $request['job_id'] ) || $request['job_id'] == 0 ) {
        return $response;
    }
    
    if( !is_email( $request['email'] ) ) {
        $response['message'] = "Your email address is not valid";
        return $response;
    }

    if( empty( $request['name'] ) ) {
        $response['message'] = "Name field must be filled";
        return $response;
    }

    $job_id = (int)$request['job_id'];
    $applicant_email = $request['email'];
    $applicant_name = sanitize_text_field( $request['name'] );
    $applicant_phone = sanitize_text_field( $request['phone'] );
    $subject = sanitize_text_field( $request['subject'] );
    $message = sanitize_textarea_field( $request['message'] );

    if( isset( $_FILES['cv'] ) && !empty( $_FILES['cv']['name'] ) ) {
        $filename = $wp_upload_dir['basedir'] . '/' . date('Y') . '/' . date('m') . '/' . 'JOBEMPLOYPH_cv_' . uniqid() . '.' . strtolower( pathinfo( $_FILES["cv"]['name'], PATHINFO_EXTENSION ) );
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
   * Save Application to Database
   */

    $application_id = wp_insert_post(array(
        'post_type'     =>  'application',
        'post_title'    =>  $subject,
        'post_name'     =>  md5( $subject . uniqid() ),
        'post_content'  =>  $message,
        'post_status'   =>  'publish'

    ));
    if( is_wp_error( $application_id ) ){
        $response['message'] = "There's a problem on your application, please try again";
        return $response;
    }

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

    $response['data'] = [
        'job_id'        =>  $job_id,
        'email'         =>  $applicant_email,
        'name'          =>  $applicant_name,
        'phone'         =>  $applicant_phone,
        'subject'       =>  $subject,
        'message'       =>  $message,
        'cv'            =>  $_FILES['cv']['tmp'],
        'attachment'    =>  $attachment
    ];

    $response['status'] = 1;
    $response['message'] = "Application Submitted";
    
    echo json_encode( $response );
}

function post_job_api( $request ) {

    $response = [
        'status'    =>  0,
        'message'   =>  'Something went wrong'
    ];

    if( empty( $request['key'] ) && decode_key( $request['key'] ) != 'jobemployph_post_job' ) {
        $response['message'] = "Invalid Key";
        return $response;
    }

    $job_title = sanitize_text_field( $request['job_title'] );
    $job_salary = sanitize_text_field( $request['job_salary'] );
    $job_location = sanitize_text_field( $request['job_location'] );
    $job_type = (int)$request['job_type'];
    $job_category = (int)$request['job_category'];
    $job_description = wp_kses_post( $request['job_description'] );
    $company_name = sanitize_text_field( $request['company_name'] );
    $company_website = esc_url_raw( $request['company_website'] );
    $application_email = is_email( $request['application_email'] ) ? $request['application_email'] : '';
    $application_mobile = sanitize_text_field( $request['application_mobile'] );
    $application_tel = sanitize_text_field( $request['application_tel'] );
    $application_link = esc_url_raw( $request['application_link'] );

    $author_id = (int)$request['author'];

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
        update_field( 'HB_mobile_number', $application_mobile, $job_id );
        update_field( 'HB_telephone_number', $application_tel, $job_id );
        update_field( 'application_form_link', $application_link, $job_id );
        update_field( '_company_name', $company_name, $job_id );
        update_field( '_company_website', $company_website, $job_id );
        
        /**
         * Set Taxonomy for the post
         */
        wp_set_object_terms( $job_id, array( $job_type ), 'job_listing_type' );
        wp_set_object_terms( $job_id, $job_category, 'job_listing_category' );
    
        $response = [
            'status'    =>  1,
            'message'   =>  'Your Job post has been submitted. Wait up to 24 hours for your post to be approved'
        ];
    endif;
    return $response;
}

function get_job_taxonomies_api() {
    $all = [];
    $job_types = [];
    $job_categories = [];
    $terms_types = get_terms( array( 'taxonomy' => 'job_listing_type', 'hide_empty' => false ) );
    foreach( $terms_types as $type ) {
        $a = [];
        $a['id'] = $type->term_id;
        $a['name'] = $type->name;
        $job_types[] = $a;
    } 
    $terms_categories = get_terms( array( 'taxonomy' => 'job_listing_category', 'hide_empty' => false ) );
    foreach( $terms_categories as $category ) {
        $a = [];
        $a['id'] = $category->term_id;
        $a['name'] = $category->name;
        $job_categories[] = $a;
    } 
    $all['job_types'] = $job_types;
    $all['job_categories'] = $job_categories;

    echo json_encode( $all );
}

function decode_key( $encoded ) {
    $decoded = "";
    for( $i = 0; $i < strlen($encoded); $i++ ) {
        $b = ord($encoded[$i]);
        $a = $b ^ 123;  // <-- must be same number used to encode the character
        $decoded .= chr($a);
    }
    echo $decoded;
}

?>