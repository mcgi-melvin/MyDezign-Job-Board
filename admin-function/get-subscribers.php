<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
/*
$args = [
    'post_type'         =>  'subscriber',
    'order'             =>  'ASC',
    'posts_per_page'    =>  -1,
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

print_r( $subscribers );
*/

$args = [
    'post_type'         =>  'subscriber',
    'posts_per_page'    =>  -1
];
$subscribers = get_posts( $args );

foreach( $subscribers as $subscriber ) {
    $headers[] = 'Bcc: ' . get_field( 'email', $subscriber->ID );
}

echo '<pre>';
print_r( $headers );

?>