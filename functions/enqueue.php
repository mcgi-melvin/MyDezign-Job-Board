<?php

add_action('wp_enqueue_scripts','front_scripts');
function front_scripts(){
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery') );
  wp_enqueue_script( 'google-analytics', 'https://www.googletagmanager.com/gtag/js?id=UA-126698192-1', array('jquery') );
  wp_enqueue_script( 'main-script', get_template_directory_uri() . '/assets/js/script.js', array(), '', true );
  wp_enqueue_style( 'default-style', get_stylesheet_uri() );
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css' );
  wp_enqueue_style( 'fontawesome-all', get_template_directory_uri() . '/assets/css/all.css' );
  wp_enqueue_style( 'woocommerce-custom', get_template_directory_uri() . '/assets/css/woocommerce.css' );

  if(is_plugin_active('wp-job-manager/wp-job-manager.php')){
    wp_enqueue_style( 'job-manager', get_template_directory_uri() . '/assets/css/frontend.css' );
  }

  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

}

?>
