<?php

register_nav_menu('header-menu',__( 'Not Logged In Header Menu', 'Menu for Logout User'));
register_nav_menu('login-header-menu',__( 'Login Header Menu', 'Menu for Logged in User' ));

add_theme_support( 'woocommerce' );
add_theme_support( 'custom-logo', array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array( 'site-title', 'site-description'),
    )
);

add_action( 'init', 'events_post_init' );
/**
 * Add Custom Post Type Events
 */
function events_post_init() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'hanap-buhay' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'hanap-buhay' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'hanap-buhay' ),
		'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'hanap-buhay' ),
		'add_new'            => _x( 'Add New', 'event', 'hanap-buhay' ),
		'add_new_item'       => __( 'Add New Event', 'hanap-buhay' ),
		'new_item'           => __( 'New Event', 'hanap-buhay' ),
		'edit_item'          => __( 'Edit Event', 'hanap-buhay' ),
		'view_item'          => __( 'View Event', 'hanap-buhay' ),
		'all_items'          => __( 'All Events', 'hanap-buhay' ),
		'search_items'       => __( 'Search Events', 'hanap-buhay' ),
		'parent_item_colon'  => __( 'Parent Events:', 'hanap-buhay' ),
		'not_found'          => __( 'No Events found.', 'hanap-buhay' ),
		'not_found_in_trash' => __( 'No Events found in Trash.', 'hanap-buhay' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'hanap-buhay' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'event', $args );
}

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
add_action( 'init', 'my_custom_post_type_rest_support', 25 );
function my_custom_post_type_rest_support() {
	global $wp_post_types;
	$post_type_name = 'job_listing';
	if( isset( $wp_post_types[ $post_type_name ] ) ) {
	$wp_post_types[$post_type_name]->show_in_rest = true;
	// Optionally customize the rest_base or controller class
	$wp_post_types[$post_type_name]->rest_base = $post_type_name;
	$wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
	}
}

add_action( 'rest_api_init', 'register_api_hooks' );
function register_api_hooks() {
  register_rest_route( 'myapp/v1', '/login/',
    array(
      'methods'  => 'GET', 'POST',
      'callback' => 'login',
    )
  );
  register_rest_route( 'myapp/v1', '/signup/',
    array(
      'methods'  => 'GET', 'POST',
      'callback' => 'signup',
    )
  );
}
/* ADDING ACF INTO REST API */
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

add_filter('show_admin_bar', '__return_false');
//remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );


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














?>
