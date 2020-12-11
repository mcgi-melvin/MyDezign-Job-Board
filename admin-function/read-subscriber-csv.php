<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

ini_set('auto_detect_line_endings', true);


$file = fopen( get_template_directory() . '/assets/subscribers_mailchimp.csv' ,"r" );
$header = fgetcsv($file);
$count = 2;
while ( ($row = fgetcsv($file, 0)) !== false ) :
    $email = sanitize_email( $row[0] );
    $name = $row[1] .' '. $row[2];
    echo $count .' - '.$email .' '. $name . '<br /><br />';
    wp_defer_term_counting( true );
    wp_defer_comment_counting( true );
    add_subscriber( $email, $name, 'from_mailchimp' );
    wp_defer_term_counting( false );
    wp_defer_comment_counting( false );
    $count++;
endwhile;


?>