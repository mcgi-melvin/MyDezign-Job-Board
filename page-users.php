<?php
/*
  Template Name: Users
*/
acf_form_head();
get_header();
?>


<div id="users_container" class="users-container">

  <div id="users_banner" class="users-banner" style="background-image: url(<?php echo get_template_directory_uri() .'/assets/images/Users-Banner.jpg'; ?>);">
    <canvas></canvas>
    <div class="users-image">
      <img src="http://localhost/mywordpress/wp-content/uploads/2019/09/hired.png" width="200" height="200"></img>
    </div>
  </div>
  <div class="users-section-info">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          Test
        </div>
        <div class="col-md-6">
        <?php
          if(is_user_logged_in()):
            require get_template_directory() . '/template-parts/users/dashboard.php';
          else:
            require get_template_directory() . '/template-parts/users/landing.php';
          endif;
        ?>
        </div>
        <div class="col-md-3">
          zxc
        </div>

      </div>
    </div>
  </div>

</div>














<?php get_footer(); ?>
