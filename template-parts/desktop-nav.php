<div class="desktop-nav">
  <div class="row">
    <div class="col-3 custom-v-align">
      <?php
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
      if ( has_custom_logo() ) {
              echo '<a href="'.site_url().'"><img width="100px" height="auto" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '"></a>';
      } else {
              echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
      }
      ?>
    </div>
    <div class="col text-right text-uppercase custom-v-align">
      <?php
      if(is_user_logged_in()){
        wp_nav_menu(array('theme_location' => 'login-header-menu','menu' => 'login-header-menu'));
      }else{
        wp_nav_menu(array('theme_location' => 'header-menu','menu' => 'header-menu'));
      }
       ?>
    </div>
  </div>
</div>
