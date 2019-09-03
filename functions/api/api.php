<?php
include_once dirname( __FILE__ ) . '/validate.php';

function login( WP_REST_Request $request){

  if(check_siteToken($request['tk'], $request['sk']) == 0){
    return 'Something Went Wrong';
  }

  $dataArray = [];
  $session_token = '';
  $nonce = '';
  $creds = array(
      'user_login'    => $request["username"],
      'user_password' => $request["password"],
      'remember'      => true,
  );
  $user = wp_signon( $creds, false );

  if ( is_wp_error($user) ){
    $dataArray['error'] = $user->get_error_message();
    //return str_replace( 'Lost your password?', '', substr( ($user->get_error_message()), strpos($user->get_error_message(), ' ') ) );
  } else {
    //$session_token = wp_get_session_token();
    $nonce = md5(uniqid($user->ID, true));
    $user_meta = get_user_meta($user->ID);
  }

  $dataArray['display_picture'] = wp_get_attachment_image_src(isset($user_meta['user_image'][0]) ? $user_meta['user_image'][0] : '', 'large' )[0];
  $dataArray['user_name'] = $user->user_login;
  $dataArray['full_name'] = $user_meta['first_name'][0].' '.$user_meta['last_name'][0];
  $dataArray['user_email'] = $user->user_email;
  $dataArray['token'] = $nonce;
  $dataArray['description'] = $user_meta['description'][0];
  $dataArray['role'] = $user->roles[0];
  $dataArray['job_experience'] = isset($user_meta['job_experience'][0]) ? $user_meta['job_experience'][0] : '';

  //echo '<pre>';
  //print_r($dataArray);
  return $dataArray;

}



function signup( WP_REST_Request $request ){
  if(check_siteToken($request['tk'], $request['sk']) == 0){
    return 'Something Went Wrong!';
  }

  $data = [];
  $email = cleanData($request['email']);
  $username = cleanData($request['username']);
  if(true == check_email($email)){
    return 'Email '.esc_html($email).' is already registered';
  }
  if(true == check_username($username)){
    return 'Username Already Registered';
  }

  $created = wp_create_user( $username, $request['password'], $email );

  if($created){
    $user = get_user_by('email', $email);
    /*
    $userData = array ( 'ID'=>$user->ID, 'role' => $request['role'] );
    user_update($userData);
    */

    $u = new WP_User( $user->ID );
    $u->set_role( $request['role'] );
    $nonce = md5(uniqid($user->ID, true));

    $data['user_name'] = $username;
    $data['password'] = $email;
    $data['role'] = $request['role'];
    $data['token'] = $nonce;


    return $data;
  }else{
    return 0;
  }

}


?>
