<?php

add_action('wp_enqueue_scripts','run_last_scripts',999);
function run_last_scripts(){
  wp_enqueue_style( 'font-google', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Open+Sans:wght@300;400&display=swap' );
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css' );
  wp_enqueue_style( 'style-new', get_template_directory_uri() . '/assets/css/style.css' );
}

add_action('wp_enqueue_scripts','front_scripts');
function front_scripts(){
  
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-job-manager-frontend' );
  wp_dequeue_style( 'select2' );

  wp_enqueue_script( 'fontawesome', 'https://kit.fontawesome.com/016ae96b36.js', array(), null, true );
  wp_script_add_data( 'fontawesome', 'async', true );
  wp_enqueue_script( 'jquery-new', get_template_directory_uri() . '/assets/js/jquery-3.3.1.min.js', array(), '3.3.1', true );
  wp_script_add_data( 'jquery-new', 'async', true );

  if( !isBotDetected() ):
    wp_enqueue_script( 'google-tag', 'https://www.googletagmanager.com/gtag/js?id=UA-126698192-1', array(), null, true );
    wp_script_add_data( 'google-tag', 'async', true );
    if( is_single() OR is_page(25584) ) {
      wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true );
      wp_script_add_data( 'google-recaptcha', 'async', true );
      wp_script_add_data( 'google-recaptcha', 'defer', true );
    }
    
    wp_enqueue_script( 'google-adsense', 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', array(), null, true );
    wp_script_add_data( 'google-adsense', 'async', true );
  endif;
  //wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/script.js', array('jquery-new'), null, true );
  
  /*
  //wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/css/all.css' );
  //wp_enqueue_style( 'default-style', get_stylesheet_uri() );
  //wp_enqueue_style( 'woocommerce-custom', get_template_directory_uri() . '/assets/css/woocommerce.css' );
  //wp_enqueue_style( 'calendar-css', get_template_directory_uri() . '/assets/css/calendar.css' );
  //wp_enqueue_style( 'users-css', get_template_directory_uri() . '/assets/css/users.css' );
  //wp_enqueue_style( 'main-css', get_template_directory_uri() . '/assets/css/style.css' );
  /*
  if(is_plugin_active('wp-job-manager/wp-job-manager.php')){
    wp_enqueue_style( 'job-manager', get_template_directory_uri() . '/assets/css/frontend.css' );
  }
  //wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery-new'), null, true );
  //wp_enqueue_script( 'facebook-sdk', 'https://connect.facebook.net/en_US/sdk.js', array(), null );
  //wp_enqueue_script( 'header', get_template_directory_uri() . '/assets/js/header.js', array('jquery-new') );
  wp_enqueue_script( 'user', get_template_directory_uri() . '/assets/js/users.js', array('jquery-new'), '', true );
  wp_enqueue_script( 'users-canvas', get_template_directory_uri() . '/assets/js/users-canvas.js', array('jquery'), '', true );
  wp_enqueue_script( 'calendar-js', get_template_directory_uri() . '/assets/js/calendar.js', array('jquery'), '', true );
  wp_enqueue_script( 'solve-media', 'https://api-secure.solvemedia.com/papi/challenge.script?k=nC0Y01l2yH7r8fcqDXJ4cnTAZMZks36H"', array(), null );
  
  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

  wp_localize_script( 'user-script', 'myAjax',
    array(
        'ajaxurl' => admin_url( 'admin-ajax.php'),
        'site_url' => site_url(),
        'adminpost' => admin_url( 'admin-post.php' )
      )
    );
  wp_enqueue_script( 'user-script' );

  wp_enqueue_script( 'wp-api', get_template_directory_uri() . '/assets/js/api.js' );
  wp_localize_script( 'wp-api', 'wpApiSettings', array(
    'root' => esc_url_raw( rest_url() ),
    'nonce' => wp_create_nonce( 'wp_rest' )
  ) );
  */


}

?>
