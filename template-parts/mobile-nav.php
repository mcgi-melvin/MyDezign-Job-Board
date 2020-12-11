<div class="mobile-head">
  <div class="row">
    <div class="col-6">
      <div class="header-img-container">
      <?php
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
      if ( has_custom_logo() ) {
              echo '<a href="'.site_url().'"><img height="auto" src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '"></a>';
      } else {
              echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
      }
      ?>
      </div>
    </div>
    <div class="col-6 custom-v-align">

      <div class="mobile-nav text-right">
        <a href="/jobs/add">
          <span><i title="Start Hiring" class="fas fa-user-plus color-white"></i></span>
        </a>
        <a href="">
          <span><i title="My Account" class="fas fa-user color-white"></i></span>
        </a>
        <a id="mobile-nav" href="#">
          <span><i title="Open Navigation" class="fas fa-bars"></i></span>
        </a>
      </div>

      <div class="nav-overlay">
        <div class="row">
          <div class="col-offset-8 text-right">
            <span id="mobile-nav-close" class="text-white mobile-nav-close"><i class="fas fa-window-close"></i></span>
          </div>
          <div class="mobile-menu">
            <?php
              wp_nav_menu(array(
                'theme_location' => 'mobile-menu',
                'menu' => 'header-menu',
                'menu_id'=>'mobile-nav-menu'
              ));
             ?>
             <div class="mobile-nav-support random-show" style="display: none;">
               <?php get_template_part('template-parts/toggle/donation','toggle'); ?>
             </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
