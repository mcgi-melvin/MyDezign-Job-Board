<?php

/**
 * NOT WORRKIINNNGGGGG!!!!
 */

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
/*
require_once get_template_directory() . '/inc/vendor/autoload.php';
use Mailgun\Mailgun;
$body = email_job_updates();

$mg = Mailgun::create('key-example'); // For US servers
$mg->messages()->send('example.com', [
    'from'      =>  'wordpress@jobemployph.tk',
    'to'        =>  'ph.hanapbuhay@gmail.com',
    'bcc'       =>  'techyprosolutions@gmail.com',
    'subject'   =>  'Hanap Buhay Sample Email',
    'html'      =>  $body
]);
*/


?>