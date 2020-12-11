<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$application = get_post( 27705 );

$attachment  = [];

if( get_field( 'file', $application->ID ) ) {
    $file = get_field( 'file', $application->ID );
    $attachment = wp_upload_dir()['basedir'] . get_attached_file( $file['ID'] );
}

//print_r( get_field( 'file', $application->ID ) );

$param = [
    'name'      =>  get_field( 'name', $application->ID ),
    'email'     =>  get_field( 'email_address', $application->ID ),
    'phone'     =>  get_field( 'phone', $application->ID ),
    'job_title' =>  get_field( 'job_applied', $application->ID )->post_title,
    'subject'   =>  get_the_title( $application->ID ),
    'message'   =>  $application->post_content
];

$subscriber_args = [
    'post_type'         =>  'subscriber',
    'posts_per_page'    =>  1,
    'meta_key'          =>  'email',
    'meta_value'        =>  get_field( 'email_address', $application->ID )
];
$subscriber = get_posts( $subscriber_args );
echo '<pre>';
print_r( $subscriber );
echo '</pre>';
/*
$to = get_field( 'email_address', $application->ID );
$subject = 'Job Application';
$body = email_application_from_applicant_exec( $param );
$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>');
$result = wp_mail( $to, $subject, $body, $headers, $attachment );

$uploads  = wp_upload_dir( null, false );
$logs_dir = $uploads['basedir'] . '/cron_log';

if ( ! is_dir( $logs_dir ) ) {
    mkdir( $logs_dir, 0755, true );
}

$txt = date("F j, Y, g:i a") . ' : "applicant_application_to_applicant" result for {' . $application->ID . ' : '. get_field( 'name', $application->ID ) . ' : ' . get_field( 'email', $application->ID ) .'} = ' . $result . PHP_EOL;

$file = fopen( $logs_dir . '/' . 'log.log', 'a' );
fwrite($file, $txt);
fclose($file);
*/
?>