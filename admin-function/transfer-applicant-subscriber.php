<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

/*
include_once( WP_PLUGIN_DIR . '/advanced-custom-fields-pro/acf.php' );

echo WP_PLUGIN_DIR . '/advanced-custom-fields-pro/acf.php';
*/
$emails = [];
$args = [
    'post_type'         =>  'application',
    'posts_per_page'    =>  -1
];
$query = new WP_Query( $args );
if( $query->have_posts() ):
    
    while( $query->have_posts() ):
        $query->the_post();

        $a = [];
        $a['name'] = get_field( 'name' );
        $a['email'] = get_field( 'email_address' );
        $emails[] = $a;
        
    endwhile;
    wp_reset_postdata();
endif;
$unique_emails = unique_multidim_array($emails,'email');
echo count( $unique_emails ) . '<br /><br />';

foreach( $unique_emails as $i => $applicant ):

    if( empty($applicant['email']) ) {
        continue;
    }

    $args = [
        'post_type'         =>  'subscriber',
        'meta_key'          =>  'email',
        'meta_value'        =>  $applicant['email'],
        'posts_per_page'    =>  1
    ];
    $posts = get_posts( $args );
    if( empty( $posts ) ) {
        $subscriber_id = wp_insert_post(array(
            'post_type'     =>  'subscriber',
            'post_title'    =>  $applicant['email'] .' '. $applicant['name'],
            'post_status'   =>  'publish'
        ));
        
        if( !is_wp_error( $subscriber_id ) ):
            update_field( 'email', $applicant['email'], $subscriber_id );
            update_field( 'name', $applicant['name'], $subscriber_id );
            update_field( 'subscriber_type', 'applicant', $subscriber_id );
        endif;
    }

    echo $i .' '. $applicant['email'] .'<br />';

endforeach;

/*
$post_type = 'subscriber';
echo get_field( 'email_address' );
$args = [
    'post_type'         =>  $post_type,
    'meta_key'          =>  'email',
    'meta_value'        =>  get_field( 'email_address' ),
    'posts_per_page'    =>  1
];
$posts = get_posts( $args );
echo '<pre>';
print_r( $posts );
echo '</pre>';
if( empty( $posts ) ) {
    $subscriber_id = wp_insert_post(array(
        'post_type'     =>  $post_type,
        'post_title'    =>  get_field( 'email_address' ) .' '. get_field( 'name' ),
        //'post_status'   =>  'publish'
    ));
    
    if( !is_wp_error( $subscriber_id ) ):
        update_field( 'email', get_field( 'email_address' ), $subscriber_id );
        update_field( 'name', get_field( 'name' ), $subscriber_id );
        update_field( 'subscriber_type', 'applicant', $subscriber_id );
    endif;
}
*/
?>