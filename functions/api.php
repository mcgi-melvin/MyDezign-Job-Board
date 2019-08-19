<?php



add_action( 'rest_api_init', 'register_api_hooks' );
function register_api_hooks() {
  register_rest_route( 'myapp/v1', '/login/',
    array(
      'methods'  => 'GET',
      'callback' => 'login',
    ),
  );
}


function login(){
    $creds = array();
    $creds['user_login'] = $request["username"];
    $creds['user_password'] =  $request["password"];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );

    if ( is_wp_error($user) )
      echo $user->get_error_message();

    return $user;
}






?>
