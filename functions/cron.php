<?php

date_default_timezone_set( "Asia/Manila" );

add_filter( 'cron_schedules', 'add_cron_interval' );
function add_cron_interval( $schedules ) {
    $schedules['every_one_minute'] = array(
        'interval' => 60,
        'display'  => esc_html__( 'Every One Minute' ),
    );
    $schedules['every_five_minutes'] = array(
        'interval' => 300,
        'display'  => esc_html__( 'Every Five Minutes' ),
    );
    $schedules['every_three_hours'] = array(
        'interval' => 10800,
        'display'  => esc_html__( 'Every Three Hours' ),
    );
    $schedules['every_six_hours'] = array(
        'interval' => 21600,
        'display'  => esc_html__( 'Every Six Hours' ),
    );
    return $schedules;
}


add_action( 'send_welcome_email_hook', 'send_welcome_email_exec' );
function send_welcome_email_exec() {
    $args = [
        'post_type'         =>  'subscriber',
        'order'             =>  'ASC',
        'meta_query'        =>  array(
            'relation'      =>  'OR',
            array(
                'key'       =>  'welcome_email',
                'compare'   =>  'NOT EXISTS'
            ),
            array(
                'key'       =>  'welcome_email',
                'value'     =>  ''
            )
        )
    ];
    $subscribers = get_posts( $args );
    foreach( $subscribers as $i => $subscriber ):
    if( empty( get_field( 'welcome_email', $subscriber->ID ) ) ) {
        $to = get_field( 'email', $subscriber->ID );
        $subject = 'Welcome to Hanap Buhay Philippines';
        $param = [
            'name'              =>  get_field( 'name', $subscriber->ID ),
            'unsubscribe_key'   =>  get_the_permalink( $subscriber->ID )
        ];
        $body = welcome_email_body( $param );
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>');
        $result = wp_mail( $to, $subject, $body, $headers );
        if( $result ):
            $uploads  = wp_upload_dir( null, false );
            $logs_dir = $uploads['basedir'] . '/cron_log';

            if ( ! is_dir( $logs_dir ) ) {
                mkdir( $logs_dir, 0755, true );
            }

            $txt = date("F j, Y, g:i a") . ' : "welcome_email" result for {' . $subscriber->ID . ' : '. get_field( 'name', $subscriber->ID ) . ' : ' . get_field( 'email', $subscriber->ID ) .'} = ' . $result . PHP_EOL;

            $file = fopen( $logs_dir . '/' . 'log.log', 'a+' );
            fwrite($file, $txt);
            fclose($file);
            update_field( 'welcome_email', 'sent', $subscriber->ID );
        endif;
    }
    endforeach;
}

add_action( 'send_application_to_applicant_hook', 'send_application_to_applicant_exec' );
function send_application_to_applicant_exec() {
    $args = [
        'post_type'         =>  'application',
        'order'             =>  'ASC',
        'posts_per_page'    =>  -1,
        'meta_query'        =>  array(
            array(
                'relation'  =>  'OR',
                array(
                    'key'       =>  'sent_to_applicant',
                    'compare'   =>  'NOT EXISTS'
                ),
                array(
                    'key'       =>  'sent_to_applicant',
                    'value'     =>  ''
                )
            ),
            array(
                'key'       =>  'email_address',
                'compare'   =>  'EXISTS'
            ),
            array(
                'key'       =>  'email_address',
                'value'     =>  '',
                'compare'   =>  '!='
            ),
        )
    ];
    $applications = get_posts( $args );
    foreach( $applications as $i => $application ):
    if( empty( get_field( 'sent_to_applicant', $application->ID ) ) ) {
        $attachment  = [];
        /**
         * Checking and processing file (Resume/CV) if available
         */
        if( get_field( 'file', $application->ID ) ) {
            $file = get_field( 'file', $application->ID );
            $attachment = wp_upload_dir()['basedir'] . get_attached_file( $file['ID'] );
        }

        /**
         * Getting Subscriber Information
         */
        $subscriber_args = [
            'post_type'         =>  'subscriber',
            'posts_per_page'    =>  1,
            'meta_key'          =>  'email',
            'meta_value'        =>  get_field( 'email_address', $application->ID )
        ];
        $subscriber = get_posts( $subscriber_args )[0];

        /**
         * Preparing param for email
         */
        $param = [
            'name'              =>  get_field( 'name', $application->ID ),
            'email'             =>  get_field( 'email_address', $application->ID ),
            'phone'             =>  get_field( 'phone', $application->ID ),
            'job_title'         =>  get_field( 'job_applied', $application->ID )->post_title,
            'subject'           =>  get_the_title( $application->ID ),
            'message'           =>  !empty( $application->post_content ) ? $application->post_content : 'No Message',
            'unsubscribe_key'   =>  get_field( 'email_address', $subscriber->ID )
        ];

        $to = get_field( 'email_address', $application->ID );
        $subject = 'Job Application';
        $body = email_application_from_applicant_exec( $param );
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>');
        $result = wp_mail( $to, $subject, $body, $headers, $attachment );
        if( $result ) :
            $uploads  = wp_upload_dir( null, false );
            $logs_dir = $uploads['basedir'] . '/cron_log';

            if ( ! is_dir( $logs_dir ) ) {
                mkdir( $logs_dir, 0755, true );
            }

            $txt = date("F j, Y, g:i a") . ' : "applicant_application_to_applicant" result for {' . $application->ID . ' : '. get_field( 'name', $application->ID ) . ' : ' . get_field( 'email_address', $application->ID ) .'} = ' . $result . PHP_EOL;

            $file = fopen( $logs_dir . '/' . 'log.log', 'a' );
            fwrite($file, $txt);
            fclose($file);

            update_field( 'sent_to_applicant', 'sent', $application->ID );
        endif;
    }
    endforeach;
}

add_action( 'read_subscriber_csv_hook', 'read_subscriber_csv_exec' );
function read_subscriber_csv_exec() {
    
    ini_set('auto_detect_line_endings', true);

    $file = fopen( get_template_directory() . '/assets/subscribers_mailchimp.csv' ,"r" );
    $header = fgetcsv($file);
    $count = 2;
    while ( ($row = fgetcsv($file, 0)) !== false ) :
        $email = sanitize_email( $row[0] );
        $name = $row[1] .' '. $row[2];

        add_subscriber( $email, $name, 'from_mailchimp' );
        $count++;
    endwhile;
    
}

add_action( 'send_daily_jobs_event', 'send_daily_jobs_exec' );
function send_daily_jobs_exec() {
    
    $to = 'daily-jobs@jobemployph.tk';
    $subject = 'Hanap Buhay Job Update';
    $body = email_job_updates();

    $args = [
        'post_type'         =>  'subscriber',
        'posts_per_page'    =>  -1,
        'post_status'       =>  'publish'
    ];
    $subscribers = get_posts( $args );

    foreach( $subscribers as $subscriber ) {
        $headers[] = 'Bcc: ' . get_field( 'email', $subscriber->ID );
    }

    $headers[] = 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>';
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    $result = wp_mail( $to, $subject, $body, $headers );
    if( $result ) {
        log_cron( date("F j, Y, g:i a") . ' : "send_job_update" result = ' . $result );
    }
    
}

if ( ! wp_next_scheduled( 'send_welcome_email_hook' ) ) {
    wp_schedule_event( time(), 'every_one_minute', 'send_welcome_email_hook' );
}

if ( ! wp_next_scheduled( 'send_application_to_applicant_hook' ) ) {
    wp_schedule_event( time(), 'every_five_minutes', 'send_application_to_applicant_hook' );
}

if ( ! wp_next_scheduled( 'send_daily_jobs_event' ) ) {
    wp_schedule_event( strtotime('09:00:00'), 'daily', 'send_daily_jobs_event' );
    wp_schedule_event( strtotime('16:00:00'), 'daily', 'send_daily_jobs_event' );
}


?>