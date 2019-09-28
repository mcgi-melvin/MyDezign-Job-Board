<?php

add_action('init', 'JEPH_frontend_login');
function JEPH_frontend_login(){
  if(isset($_POST['login']) && wp_verify_nonce($_POST['JEPH_login_nonce'], 'JEPH-login-nonce')) {
    $admin = get_user_by('login', $_POST['login']['user_login']);
    if($admin->roles[0] == 'administrator'){
      return false;
    }
    $user = wp_signon( $_POST['login'] );

    if ( is_wp_error($user) ){ // RETURN ERROR IF LOGIN IS FAILED
      foreach($user->errors as $key => $value){
        JEPH_errors()->add($key, __($value[0]));
      }
      return false;
    }


    //print_r($user);
    wp_clear_auth_cookie();
    wp_set_current_user( $user->ID, $user->user_login );
    if (wp_validate_auth_cookie()==FALSE){
      wp_set_auth_cookie($user_id);
    }
    do_action( 'wp_login', $user->user_login, $user );

    if(is_user_logged_in()){
      wp_safe_redirect($_SERVER['REQUEST_URI']);
    }

  }
}

add_shortcode('JEPH_login_form', 'JEPH_login_form');
function JEPH_login_form() {

	if(!is_user_logged_in()) {
		$output = JEPH_login_form_fields();
	}
	return $output;
}

// displays error messages from form submissions
function JEPH_show_error_messages() {
	if($codes = JEPH_errors()->get_error_codes()) {
	    // Loop error codes and display errors
    foreach($codes as $code){
        $message = JEPH_errors()->get_error_message($code);
        echo '<span class="error">' . $message . '</span><br/>';
    }
	}
}

// used for tracking error messages
function JEPH_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}


// register a new user
add_action('init', 'JEPH_frontend_signup');
function JEPH_frontend_signup() {
  	if (isset( $_POST["register"] ) && wp_verify_nonce($_POST['JEPH_register_nonce'], 'JEPH-register-nonce')) {
		$user_login		= $_POST["register"]['user_name'];
		$user_email		= $_POST["register"]['user_email'];
		$user_pass		= $_POST["register"]['user_pass'];
		$user_repass 	= $_POST["register"]['user_repass'];
    $user_role    = $_POST["register"]['user_role'];

		// this is required for username checks
		require_once(ABSPATH . WPINC . '/registration.php');
    $user = get_user_by('login',$user_login);
		if(username_exists($user_login)) {
			// Username already registered
			JEPH_errors()->add('username_unavailable', __('Username already taken'));
		}
		if(!validate_username($user_login)) {
			// invalid username
			JEPH_errors()->add('username_invalid', __('Invalid username'));
		}
		if($user_login == '') {
			// empty username
			JEPH_errors()->add('username_empty', __('Please enter a username'));
		}
		if(!is_email($user_email)) {
			//invalid email
			JEPH_errors()->add('email_invalid', __('Invalid email'));
		}
		if(email_exists($user_email)) {
			//Email address already registered
			JEPH_errors()->add('email_used', __('Email already registered'));
		}
		if($user_pass == '') {
			// passwords do not match
			JEPH_errors()->add('password_empty', __('Please enter a password'));
		}
		if($user_pass != $user_repass) {
			// passwords do not match
			JEPH_errors()->add('password_mismatch', __('Passwords do not match'));
		}
    if($user->roles[0] == 'administrator'){
      return false;
    }
		$errors = JEPH_errors()->get_error_messages();
		// only create the user in if there are no errors
		if(empty($errors)) {

			$new_user_id = wp_insert_user(array(
					'user_login'		=> $user_login,
					'user_pass'	 		=> $user_pass,
					'user_email'		=> $user_email,
					'first_name'		=> $user_login,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'role'				=> $user_role
				)
			);
			if($new_user_id) {
				// send an email to the admin alerting them of the registration
				wp_new_user_notification($new_user_id);

				// log the new user in
				wp_set_auth_cookie($user_login, $user_pass, true);
				wp_set_current_user($new_user_id, $user_login);
				do_action('wp_login', $user_login);

				// send the newly created user to the home page after logging them in
        if(is_user_logged_in()){
          wp_safe_redirect($_SERVER['REQUEST_URI']);
        }
			}

		} // END if empty errors

	}
}


















?>
