<?php

add_action('wp_enqueue_scripts','front_scripts');
function front_scripts(){
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery') );
  wp_enqueue_script( 'google-analytics', 'https://www.googletagmanager.com/gtag/js?id=UA-126698192-1', array('jquery') );
  wp_enqueue_script( 'google-adsense', 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', array('jquery') );
  wp_enqueue_script( 'main-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '', true );
  wp_enqueue_script( 'users-canvas', get_template_directory_uri() . '/assets/js/users-canvas.js', array('jquery'), '', true );
  //wp_enqueue_script( 'react', 'https://unpkg.com/react@16/umd/react.production.min.js', array('jquery'), '', true );
  //wp_enqueue_script( 'react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array('jquery'), '', true );

  //wp_enqueue_script( 'calendar-js', get_template_directory_uri() . '/assets/js/calendar.js', array('jquery'), '', true );
  wp_enqueue_style( 'default-style', get_stylesheet_uri() );
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css' );
  wp_enqueue_style( 'fontawesome-all', get_template_directory_uri() . '/assets/css/all.css' );
  wp_enqueue_style( 'woocommerce-custom', get_template_directory_uri() . '/assets/css/woocommerce.css' );
  wp_enqueue_style( 'calendar-css', get_template_directory_uri() . '/assets/css/calendar.css' );
  wp_enqueue_style( 'users-css', get_template_directory_uri() . '/assets/css/users.css' );
  //wp_enqueue_style( 'main-css', get_template_directory_uri() . '/assets/css/style.css' );

  if(is_plugin_active('wp-job-manager/wp-job-manager.php')){
    wp_enqueue_style( 'job-manager', get_template_directory_uri() . '/assets/css/frontend.css' );
  }

  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

  wp_enqueue_script( 'wp-api', get_template_directory_uri() . '/assets/js/api.js' );
  wp_localize_script( 'wp-api', 'wpApiSettings', array(
    'root' => esc_url_raw( rest_url() ),
    'nonce' => wp_create_nonce( 'wp_rest' )
  ) );



}

?>
