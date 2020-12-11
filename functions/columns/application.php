<?php

add_filter( 'manage_application_posts_columns', 'application_filter_posts_columns' );
function application_filter_posts_columns( $columns ) {
  //$columns['title'] = __( 'Title', 'JEPH' );
  $columns['name'] = __( 'Name', 'JEPH' );
  $columns['contact'] = __( 'Contact', 'JEPH' );
  $columns['have_resume'] = __( 'have resume?', 'JEPH' );
  $columns['job_applied'] = __( 'Applied Job', 'JEPH' );
  return $columns;
}

add_action( 'manage_application_posts_custom_column', 'JEPH_application_column', 10, 2);
function JEPH_application_column( $column, $post_id ) {
    if( 'name' === $column ) {
        echo get_field( 'name', $post_id );
    }
    if( 'contact' === $column ) {
        echo get_field( 'email_address', $post_id ) . '<br />' . get_field( 'phone', $post_id );
    }
    if( 'have_resume' === $column ) {
        echo get_field( 'file', $post_id ) ? 'Yes' : 'No';
    }
    if( 'job_applied' === $column ) {
        echo '<a href=" ' . get_the_permalink( get_field( 'job_applied', $post_id )->ID ) . ' ">' . get_field( 'job_applied', $post_id )->post_title . '</a>';
    }
}

?>