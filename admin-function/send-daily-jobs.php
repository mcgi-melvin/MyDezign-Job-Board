<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$attachment = [];
$to = 'daily-jobs@jobemployph.tk';
//$to = 'ph.hanapbuhay@gmail.com';
$subject = 'Hanap Buhay Job Update';
$body = email_job_updates();


$headers[] = 'Bcc: melvximbaness@gmail.com';
$headers[] = 'Bcc: techyprosolutions@gmail.com';


/*
$args = [
    'post_type'         =>  'subscriber',
    'posts_per_page'    =>  10
];
$subscribers = get_posts( $args );

foreach( $subscribers as $subscriber ) {
    $headers[] = 'Bcc: ' . get_field( 'email', $subscriber->ID );
}
*/

$headers[] = 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>';
$headers[] = 'Content-Type: text/html; charset=UTF-8';

print_r( $headers );

$result = wp_mail( $to, $subject, $body, $headers, $attachment );
echo $result;

?>