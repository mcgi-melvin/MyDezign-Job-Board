<?php

add_theme_support( 'woocommerce' );
add_theme_support( 'custom-logo', array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description'),
    )
);

add_action( 'widgets_init', '_widgets_init' );
function _widgets_init() {
  register_sidebar(
    array(
    'name'          => 'Primary Sidebar',
    'id'            => 'primary_sidebar',
    'before_widget' => '<div class="sidebar-primary">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
  ));

  register_sidebar(
    array(
    'name'          => 'Secondary Sidebar',
    'id'            => 'secondary_sidebar',
    'before_widget' => '<div class="sidebar-secondary">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
  ));

  register_sidebar(
    array(
    'name'          => 'Single Job List Sidebar',
    'id'            => 'single_job_list_1',
    'before_widget' => '<div class="sidebar-single">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="rounded">',
    'after_title'   => '</h2>',
  ));
}


add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {
  $plugins = array(
    array(
      'name'      => 'WP Job Manager',
      'slug'      => 'wp-job-manager',
      'required'  => true,
    ),
    array(
      'name'      => 'Advanced Custom Fields',
      'slug'      => 'advanced-custom-fields-pro',
      'required'  => true,
    ),
  );

  $config = array(
    'id'           => 'hbrp',                 // Unique ID for hashing notices for multiple instances of TGMPA.
    'default_path' => '',                      // Default absolute path to bundled plugins.
    'menu'         => 'hbrp-install-plugins', // Menu slug.
    'parent_slug'  => 'themes.php',            // Parent menu slug.
    'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    'has_notices'  => true,                    // Show admin notices or not.
    'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
    'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    'message'      => '',                      // Message to output right before the plugins table.
    /*
    'strings'      => array(
      'page_title'                      => __( 'Install Required Plugins', 'theme-slug' ),
      'menu_title'                      => __( 'Install Plugins', 'theme-slug' ),
      // <snip>...</snip>
      'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
    )
    */
  );

  tgmpa( $plugins, $config );
}

// Add custom post type to rest api
add_action( 'init', 'site_function_init', 25 );
function site_function_init() {
	global $wp_post_types;
  $post_type_name = 'job_listing';
  
	if( isset( $wp_post_types[ $post_type_name ] ) ) {
	$wp_post_types[$post_type_name]->show_in_rest = true;
	// Optionally customize the rest_base or controller class
	$wp_post_types[$post_type_name]->rest_base = $post_type_name;
	$wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
  }
  
  register_post_status( 'unsubscribe', array(
      'label'                     => _x( 'Unsubscribe', 'job_listing' ),
      'public'                    => true,
      'exclude_from_search'       => false,
      'show_in_admin_all_list'    => true,
      'show_in_admin_status_list' => true,
      'label_count'               => _n_noop( 'Unsubscribe <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
  ) );

  register_nav_menu( 'desktop-menu', __( 'Desktop Menu' ) );
  register_nav_menu( 'mobile-menu', __( 'Mobile Menu' ) );
  register_nav_menu( 'header-menu', __( 'Not Logged In Header Menu', 'Menu for Logout User') );
  register_nav_menu( 'login-header-menu', __( 'Login Header Menu', 'Menu for Logged in User' ) );

  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );

}


/* ADDING ACF INTO REST API 
add_action( 'rest_api_init', 'slug_register_acf' );
function slug_register_acf() {
  $post_types = get_post_types(['public'=>true], 'names');
  foreach ($post_types as $type) {
    register_rest_field( $type,
        'acf',
        array(
            'get_callback'    => 'slug_get_acf',
            'update_callback' => null,
            'schema'          => null,
        )
    );
  }
}
function slug_get_acf( $object, $field_name, $request ) {
    return get_fields($object[ 'id' ]);
}
*/

add_filter('show_admin_bar', '__return_false');
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );


add_action('get_template_url', '_get_template_url');
function _get_template_url($templateFileName){
  $pages = get_posts( array(
      'post_type' => 'page',
      'meta_key' => '_wp_page_template',
      'meta_value' => $templateFileName, // Change this to your template file name ex. page-joblist.php
      'hierarchical' => 0,
  ) );

  return $pages;
  //print_r($pages);
}

add_action('JEPH_pagination', '_JEPH_pagination', 10, 2);
function _JEPH_pagination( $total_pages, $paged){

  $posts_number = (int)get_option( 'job_manager_per_page' );
  $offset = ( $paged * 5 ) - ( ($paged * 5) - 2 );
  $total_pages = ( ($posts_number * $paged * 5) / $posts_number );
  ?>
  <div class="jobseeker-pagination-wrapper">
  <?php
  echo paginate_links( array(
      'base' => str_replace( 99999, '%#%', html_entity_decode( get_pagenum_link( 99999 ) ) ), // the base URL, including query arg
      'format' => '/%#%/', // this defines the query parameter that will be used, in this case "p"
      'prev_text' => __('&laquo; Previous'), // text for previous page
      'next_text' => __('Next &raquo;'), // text for next page
      'total' => $paged + 2, // the total number of pages we have
      'current' => $paged, // the current page
      'end_size' => 1,
      'mid_size' => 2,
      'type' => 'list'
  ));
  ?>
  
  </div>
  <?php
}

 /**
  * Filter function used to remove the tinymce emoji plugin.
  * 
  * @param array $plugins 
  * @return array Difference betwen the two arrays
  */
 function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
  return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
  return array();
  }
 }
 
 /**
  * Remove emoji CDN hostname from DNS prefetching hints.
  *
  * @param array $urls URLs to print for resource hints.
  * @param string $relation_type The relation type the URLs are printed for.
  * @return array Difference betwen the two arrays.
  */
 function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
  /** This filter is documented in wp-includes/formatting.php */
  $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
 
 $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
 
 return $urls;
 }








?>
