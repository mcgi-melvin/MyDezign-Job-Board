<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

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

print_r( $applications );

?>