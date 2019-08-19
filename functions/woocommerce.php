<?php

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

add_filter ( 'woocommerce_account_menu_items', 'misha_log_history_link', 40 );
function misha_log_history_link( $menu_links ){

  $menu_links = array_slice( $menu_links, 0, 5, true )
  + array( 'profile' => 'My Profile' )
  + array_slice( $menu_links, 5, NULL, true );

  return $menu_links;

}
/*
 * Step 2. Register Permalink Endpoint
 */
add_action( 'init', 'misha_add_endpoint' );
function misha_add_endpoint() {

  // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
  add_rewrite_endpoint( 'profile', EP_PAGES );

}
/*
 * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_profile_endpoint', 'misha_my_account_endpoint_content' );
function misha_my_account_endpoint_content() {
  echo '<div id="woo-profile">'.get_template_part('template-parts/desktop','ads').'</div>';
}



?>
