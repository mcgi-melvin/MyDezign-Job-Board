<?php


class Resources{
	public function __construct(){

		add_action('wp_enqueue_scripts','front_scripts');
    function front_scripts(){
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery') );
      wp_enqueue_script( 'main-script', get_template_directory_uri() . '/js/script.js', array(), '', true );
      wp_enqueue_style( 'default-style', get_stylesheet_uri() );
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
      wp_enqueue_style( 'fontawesome-all', get_template_directory_uri() . '/css/all.css' );
      wp_enqueue_style( 'woocommerce-custom', get_template_directory_uri() . '/css/woocommerce.css' );
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

 			if(is_plugin_active('wp-job-manager/wp-job-manager.php')){
				wp_enqueue_style( 'job-manager', get_template_directory_uri() . '/css/frontend.css' );
			}

    }

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

		add_filter( 'submit_job_form_fields', 'frontend_add_salary_field' );
		function frontend_add_salary_field( $fields ) {
		  $fields['job']['job_salary'] = array(
		    'label'       => __( 'Salary ($)', 'job_manager' ),
		    'type'        => 'text',
		    'required'    => true,
		    'placeholder' => 'e.g. 200',
		    'priority'    => 7
		  );
		  return $fields;
		}

		add_filter( 'job_manager_job_listing_data_fields', 'admin_add_salary_field' );
		function admin_add_salary_field( $fields ) {
		  $fields['_job_salary'] = array(
		    'label'       => __( 'Salary ($)', 'job_manager' ),
		    'type'        => 'text',
		    'placeholder' => 'e.g. 200',
		    'description' => ''
		  );
		  return $fields;
		}

		add_action( 'single_job_listing_meta_end', 'display_job_salary_data' );
		function display_job_salary_data() {
		  global $post;

		  $salary = get_post_meta( $post->ID, '_job_salary', true );

		  if ( $salary ) {
		    echo '<li>' . __( 'Salary:' ) . ' $' . esc_html( $salary ) . '</li>';
		  }
		}
		/*
		add_action( 'job_manager_job_filters_search_jobs_end', 'filter_by_salary_field' );
		function filter_by_salary_field() {
			?>
			<div class="search_categories">
				<label for="search_categories"><?php _e( 'Salary', 'wp-job-manager' ); ?></label>
				<select name="filter_by_salary" class="job-manager-filter">
					<option value=""><?php _e( 'Any Salary / Monthly', 'wp-job-manager' ); ?></option>
					<option value="upto20"><?php _e( 'Up to $200', 'wp-job-manager' ); ?></option>
					<option value="200-400"><?php _e( '$200 to $400', 'wp-job-manager' ); ?></option>
					<option value="400-600"><?php _e( '$400 to $600', 'wp-job-manager' ); ?></option>
					<option value="over60"><?php _e( '$600+', 'wp-job-manager' ); ?></option>
				</select>
			</div>
			<?php
		}*/

		// SALARY SEARCH FUNCTION
		add_filter( 'job_manager_get_listings', 'filter_by_salary_field_query_args', 10, 2 );
		function filter_by_salary_field_query_args( $query_args, $args ) {
			if ( isset( $_POST['form_data'] ) ) {
				parse_str( $_POST['form_data'], $form_data );
				// If this is set, we are filtering by salary
				if ( ! empty( $form_data['filter_by_salary'] ) ) {
					$selected_range = sanitize_text_field( $form_data['filter_by_salary'] );
					switch ( $selected_range ) {
						case 'upto20' :
							$query_args['meta_query'][] = array(
								'key'     => '_job_salary',
								'value'   => '200',
								'compare' => '<',
								'type'    => 'NUMERIC'
							);
						break;
						case 'over60' :
							$query_args['meta_query'][] = array(
								'key'     => '_job_salary',
								'value'   => '600',
								'compare' => '>=',
								'type'    => 'NUMERIC'
							);
						break;
						default :
							$query_args['meta_query'][] = array(
								'key'     => '_job_salary',
								'value'   => array_map( 'absint', explode( '-', $selected_range ) ),
								'compare' => 'BETWEEN',
								'type'    => 'NUMERIC'
							);
						break;
					}
					// This will show the 'reset' link
					add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
				}
			}
			return $query_args;
		}

	} // END __construct

	public function woocommerce_custom(){

		add_filter( 'woocommerce_get_price_html', 'bbloomer_price_free_zero_empty', 100, 2 );
		function bbloomer_price_free_zero_empty( $price, $product ){

		if ( '' === $product->get_price() || 0 == $product->get_price() ) {
		    $price = '<span class="woocommerce-Price-amount amount">FREE</span>';
		}

		return $price;
		}

		add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 10 );
		function new_loop_shop_per_page( $cols ) {
		  // $cols contains the current number of products per page based on the value stored on Options -> Reading
		  // Return the number of products you wanna show per page.
		  $cols = 9;
		  return $cols;
		}

	}


	public function meta_info(){
		add_action('wp_head','keywords_and_desc');
		function keywords_and_desc(){
				echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({
									google_ad_client: "ca-pub-3206044396168883",
									enable_page_level_ads: true
							});
							</script>';
		    global $post;
		    if (is_single()){
						$test = get_post_meta(get_the_ID());
						$get_post = get_post(get_the_ID());

		        if(get_post_meta(get_the_ID(),'_job_title', true) != ''){
							echo '<title>'. get_post_meta(get_the_ID(),'_company_name', true) .' - '. get_post_meta(get_the_ID(),'_job_title',true).'</title>';
							echo '<meta property="og:title"  content="'. get_post_meta(get_the_ID(),'_company_name',true) .' - '. get_post_meta(get_the_ID(),'_job_title',true).'" />';
							echo '<meta property="twitter:title"  content="'. get_post_meta(get_the_ID(),'_company_name',true) .' - '. get_post_meta(get_the_ID(),'_job_title',true).'" />';
						}else{
							echo '<title>'.get_bloginfo('name').' - '. $get_post->post_title .'</title>';
							echo '<meta property="og:title"  content="'.get_bloginfo('name').' - '. $get_post->post_title .'" />';
							echo '<meta property="twitter:title"  content="'.get_bloginfo('name').' - '. $get_post->post_title .'" />';
						}

		        if(get_post_meta(get_the_ID(),'_job_description',true) != ''){
							echo '<meta content="'.substr(get_post_meta(get_the_ID(),'_job_description',true), 0, 141).'" name="description">';
							echo '<meta content="'.substr(get_post_meta(get_the_ID(),'_job_description',true), 0, 141).'" property="og:description">';
							echo '<meta content="'.substr(get_post_meta(get_the_ID(),'_job_description',true), 0, 141).'" property="twitter:description">';
						}else{
							echo '<meta content="'.$get_post->post_excerpt.'" name="description">';
							echo '<meta content="'.$get_post->post_excerpt.'" property="og:description">';
							echo '<meta content="'.$get_post->post_excerpt.'" property="twitter:description">';
						}

						if(get_post_meta(get_the_ID(),'_application',true) != ''){
							echo '<meta name="contact" content="'.get_post_meta(get_the_ID(),'_application',true).'" />';
						}

						// FB and TWITTER META
						if(get_post_meta(get_the_ID(),'_company_twitter',true) != ""){
							echo '<meta name="twitter:creator" content="'.get_post_meta(get_the_ID(),'_company_twitter',true).'">';
						}else{
							echo '<meta name="twitter:creator" content="@hanapbuhayph">';
						}

						if(get_the_company_logo() != ""){
							echo '<meta property="og:image" content="'.get_the_company_logo().'" />
										<meta name="twitter:image" content="'.get_the_company_logo().'">';
						} else {
							echo '<meta property="og:image" content="'.site_url().'/wp-content/plugins/wp-job-manager/assets/images/company.png" />
										<meta name="twitter:image" content="'.site_url().'/wp-content/plugins/wp-job-manager/assets/images/company.png">';
						}

						echo '<meta property="og:type" content="article" />
									<meta name="robots" content="index, follow">
									';

		    }

				if(is_home() || is_front_page()){
					$custom_logo_id = get_theme_mod( 'custom_logo' );
		      $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
					echo '<title>'.get_bloginfo('name').' - '.get_the_title().'</title>
								<meta name="twitter:title" content="'.get_bloginfo('name').' - '.get_the_title().'">
								<meta content="Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment." name="description">
								<meta name="contact" content="ph.hanapbuhay@gmail.com" />
								<meta content="Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment." property="og:description">
								<meta content="Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment." property="twitter:description">
								<meta property="og:type" content="website" />
								<meta property="og:image" content="'.esc_url( $logo[0] ).'" />
								<meta name="robots" content="index, follow">
								<meta name=”twitter:creator” content=”@hanapbuhayph”>
								';
				}

				echo '<meta property="og:site_name" content="'.get_bloginfo('name').'" />
							<meta property="og:url" content="'.get_permalink().'" />
							<meta name="twitter:site" content="@hanapbuhayph">
							<meta name="twitter:card" content="summary_large_image">
							<meta name="copyright" content="Copyright (&copy;)2018-'.date("Y").' Hanap Buhay Philippines. All Rights Reserved." />';
		}
	}
}

$resource  = new Resources;
$woocommerce_resource = $resource->woocommerce_custom();
$meta_resource = $resource->meta_info();
