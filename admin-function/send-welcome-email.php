<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

function job_update_body( $name ){
    ob_start();
    include get_template_directory() . '/template-parts/email/email-welcome-message.php';
    return ob_get_clean();
}

$subscriber = get_post( 25980 );

if( empty( get_field( 'welcome_email', $subscriber->ID ) ) ) {
    $to = get_field( 'email', $subscriber->ID );
    $subject = 'Welcome to Hanap Buhay Philippines';
    $body = job_update_body( get_field( 'name', $subscriber->ID ) );
    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>');
    $result = wp_mail( $to, $subject, $body, $headers );
    print_r( $result );

    $uploads  = wp_upload_dir( null, false );
    $logs_dir = $uploads['basedir'] . '/cron_log';

    if ( ! is_dir( $logs_dir ) ) {
        mkdir( $logs_dir, 0755, true );
    }

    $txt = date("F j, Y, g:i a") . ' : "welcome_email" result for {' . $subscriber->ID . ' : '. get_field( 'name', $subscriber->ID ) . ' : ' . get_field( 'email', $subscriber->ID ) .'} = ' . $result . PHP_EOL;

    $file = fopen( $logs_dir . '/' . 'log.log', 'a' );
    fwrite($file, $txt);
    fclose($file);

    //update_field( 'welcome_email', 'sent', $subscriber->ID );
}

?>