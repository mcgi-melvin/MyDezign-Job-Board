<?php

add_filter( 'manage_subscriber_posts_columns', 'subscriber_filter_posts_columns' );
function subscriber_filter_posts_columns( $columns ) {
  //$columns['title'] = __( 'Title', 'JEPH' );
  $columns['email'] = __( 'Email', 'JEPH' );
  $columns['name'] = __( 'Name', 'JEPH' );
  $columns['source'] = __( 'Source', 'JEPH' );
  return $columns;
}

add_action( 'manage_subscriber_posts_custom_column', 'JEPH_subscriber_column', 10, 2);
function JEPH_subscriber_column( $column, $post_id ) {
    if ( 'email' === $column ) {
        echo get_field( 'email', $post_id );
    }
    if( 'name' === $column ) {
        echo get_field( 'name', $post_id );
    }
    if( 'source' === $column ) {
        if( get_field( 'from_mailchimp' ) === true ) {
            echo 'MailChimp';
        }
    }
}

?>