<div class="desktop-nav">
  <div class="row">
    <div class="col-3 d-flex align-items-center">
      <a href="<?php echo site_url(); ?>">
      <?php
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
      if ( has_custom_logo() ) {
        echo '<img height="auto" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
      } else {
        echo '<h1 class="site_title">'. get_bloginfo( 'name' ) .'</h1>';
      }
      ?>
      </a>
    </div>
    <div class="col text-right text-uppercase d-flex align-items-center justify-content-end">
      <?php
      if(is_user_logged_in()){
        wp_nav_menu(array('theme_location' => 'login-header-menu','menu' => 'login-header-menu'));
      }else{
        wp_nav_menu(array('theme_location' => 'header-menu','menu' => 'header-menu'));
      }
       ?>
       <div class="d-flex align-items-center page-users-hover page-<?php echo strtolower(get_the_title()); ?>" style="height: 100%;">
       <a class="user-btn" href="<?php echo site_url('/'.apply_filters('get_template_url', 'page-users.php')[0]->post_name); ?>" title="My Account">
         <div class="text-center" style="padding: 20px;">
           <i class="fa fa-user" style="font-weight: 100;"></i>
         </div>
       </a>
      </div>
    </div>
  </div>
</div>
