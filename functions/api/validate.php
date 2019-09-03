<?php
/*
* RETURNING VALUE 0 = Failed/Existing | 1 = Success/Available
*
*
*/
function check_email($email){
  if ( email_exists( $email ) ) {
    return true; // Email Existing
  }
  return false;
}

function check_username( $username ){
  if ( username_exists( $username ) ){
    return true; // Username Existing
  }
  return false;
}

function user_update($data){
  wp_insert_user($data);
}


function cleanData($data){
    $data=esc_sql($data);
    $data=trim($data);
    $data=stripcslashes($data);
    $data=htmlspecialchars($data);
    $data=strip_tags($data);
    return $data;
}

function check_siteToken($token, $secret){
  if( $token == get_field('api_token','option') && $secret == get_field('api_secret','option') ){
    return 1;
  } else {
    return 0;
  }

}

?>
