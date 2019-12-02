<?php

add_action('admin_post_nopriv_add_job','add_job_listing');
add_action('admin_post_add_job','add_job_listing');
function add_job_listing(){
  date_default_timezone_set("Asia/Manila");
  //^[0-9]{1,2}([,.][0-9]{1,2})?$
  $cur_user = wp_get_current_user();
  $user_meta = get_user_meta($cur_user->ID);
  if($_POST['addjob']):
    $title = sanitize_text_field($_POST['addjob']['title']);
    $description = sanitize_textarea_field($_POST['job_description']);
    $category = intval($_POST['addjob']['category']);
    $type = intval($_POST['addjob']['job_type']);
    $salary = sanitize_text_field($_POST['addjob']['salary']);
    $location = sanitize_text_field($_POST['addjob']['location']);
    echo 'Title: '.$title;
    echo 'Description: '.$description;
    echo 'Category: '.$category;
    echo 'Salary: '.$salary;
    echo 'Location: '.$location;
    print_r($cur_user);
    print_r($user_meta);

    $postarr = array(
      'post_type' => 'job_listing',
      'post_date' => date("Y-m-d H:i:s"),
      'post_title' => $title,
      'post_author' => $cur_user->ID,
      'post_content' => $description,
      'post_status' => 'publish',
      'meta_input' => array(
        '_job_location' => $location,
        '_company_name' => isset($user_meta->company_name) ? $user_meta->company_name : $cur_user->display_name,
        '_company_website' => isset($user_meta->company_website) ? $user_meta->company_website : get_author_posts_url($cur_user->ID),
        '_job_salary' => $salary,
      )
    );

    $post_id = wp_insert_post($postarr, true);
    wp_set_object_terms( $post_id, $category, 'job_listing_category' );
    $response = wp_set_object_terms( $post_id, $type, 'job_listing_type' );
    if ( !is_wp_error( $response ) ) {
      wp_safe_redirect(site_url('users'));
    }
  endif;


}

add_action('admin_post_nopriv_delete_job','delete_job');
add_action('admin_post_delete_job','delete_job');
function delete_job(){
  $cur_user = wp_get_current_user();
  $user_meta = get_user_meta($cur_user->ID);
  if($_GET['employer_listing_delete']):
    $post_id = intval($_GET['employer_listing_delete']);
    $post = get_post($post_id);
    if($cur_user->ID == $post->post_author){
      $response = wp_delete_post($post_id);
      if($response !== false){
        wp_safe_redirect(site_url('users'));
      }
    }

  endif;
}

add_action( 'wp_ajax_employer_ajax_request', 'employer_ajax_request' );
//add_action( 'wp_ajax_nopriv_employer_ajax_request', 'employer_ajax_request' );
function employer_ajax_request() {
  if($_GET['request'] == 'edit'){
    $employer_id = intval($_GET['employer_id']);
    $user = get_user_by( 'id', $employer_id );
    $user_meta = get_user_meta($employer_id);
    $user_info = [];
    foreach($user->data as $key => $data){
      $a = [];
      $user_info[$key] = $data;
    }
    foreach($user_meta as $key => $value){
      $a = [];
      $user_info[$key] = $value;
    }
  }
  echo json_encode($user_info, true);
  die();
}

add_action('admin_post_edit_employer','edit_employer');
function edit_employer(){
  $employer_id = intval($_POST['employer_id']);
  $args = array(
    'ID' => $employer_id,
    'user_email' => $_POST['user_email'],
    'display_name' => sanitize_text_field($_POST['user_nicename'])
  );

  $user_id = wp_update_user( $args );
  if ( is_wp_error( $user_id ) ) {
  	// There was an error, probably that user doesn't exist.
  } else {
    wp_safe_redirect(site_url('users'));
  	// Success!
  }
}


















?>
