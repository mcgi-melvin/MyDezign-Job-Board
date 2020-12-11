<?php

add_action( 'rest_api_init', 'register_api_hooks' );
function register_api_hooks() {
  register_rest_route( 'myapp/v1', '/login/',
    array(
      'methods'  => 'GET',
      'callback' => 'login',
    )
  );
  register_rest_route( 'myapp/v1', '/signup/',
    array(
      'methods'  => 'POST',
      'callback' => 'signup',
    )
  );
  register_rest_route( 'fb_chat/v1', '/messenger/',
    array(
      'methods'  => 'GET',
      'callback' => 'chat',
    )
  );
  register_rest_route( 'fb_chat/v1', '/messenger/',
    array(
      'methods'  => 'POST',
      'callback' => 'chat',
    )
  );

  register_rest_route( 'jobs/v1', '/list/',
    array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'get_job_list_api',
    )
  );
  register_rest_route( 'jobs/v1', '/taxonomies/',
    array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'get_job_taxonomies_api',
    )
  );
  register_rest_route( 'jobs/v1', '/single/',
    array(
      'methods'  => WP_REST_Server::READABLE,
      'callback' => 'get_job_api',
    )
  );
  register_rest_route( 'jobs/v1', '/send_application/',
    array(
      'methods'  => 'POST',
      'callback' => 'send_application_api',
    )
  );
  register_rest_route( 'jobs/v1', '/post_job/',
    array(
      'methods'  => 'POST',
      'callback' => 'post_job_api',
    )
  );

}

?>