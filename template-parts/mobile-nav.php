<div class="mobile-head">
  <div class="row">
    <div class="col-6">
      <div class="header-img-container">
      <?php
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
      if ( has_custom_logo() ) {
              echo '<a href="'.site_url().'"><img width="50px" height="auto" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '"></a>';
      } else {
              echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
      }
      ?>
      </div>
    </div>
    <div class="col-6 custom-v-align">
      <div class="mobile-nav text-right">
        <a id="mobile-nav" href="javascript:void(0);"><span>
          <i class="fas fa-bars"></i>
        </span></a>
      </div>
      <div class="nav-overlay">
        <div class="row">
          <div class="col-offset-8 text-right">
            <span id="mobile-nav-close" class="mobile-nav-close"><i class="fas fa-window-close"></i></span>
          </div>
          <div class="mobile-menu">
            <?php
            if(is_user_logged_in()){
              wp_nav_menu(array('theme_location' => 'login-header-menu','menu' => 'login-header-menu','menu_id'=>'mobile-nav-menu'));
            }else{
              wp_nav_menu(array('theme_location' => 'header-menu','menu' => 'header-menu','menu_id'=>'mobile-nav-menu'));
            }
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>