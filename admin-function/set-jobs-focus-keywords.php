<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$args = [
    'post_type'         =>  'job_listing',
    'posts_per_page'    =>  10
];
$jobs = get_posts( $args );

foreach( $jobs as $job ) {
    $keyword = wp_trim_words( $job->post_title, 3, '' );
    echo $job->ID . '<br />';
    global $wpdb;
    $results = $wpdb->query( $wpdb->prepare( 
        "UPDATE $wpdb->posts 
            SET primary_focus_keyword = %s
            WHERE `object_id` = %d
            AND `primary_focus_keyword` = ''",
            $keyword, $job->ID
    ) );
    /*
    $results = $wpdb->update( 
        "{$wpdb->prefix}yoast_indexable", 
        array( 
            'primary_focus_keyword' => $keyword,   // string
        ), 
        array( 'object_id' => $job->ID ), 
        array( 
            '%s'    // value1
        ), 
        array( '%d' ) 
    );
    */

    print_r( $results );
    echo '<br />';
}




?>