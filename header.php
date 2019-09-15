<header id="header">
  <?php
   global $job_manager;
    wp_head();
    if(!wp_is_mobile()){
      get_template_part('template-parts/top','nav');
    }
  ?>

  <div class="navigation">
    <div class="nav-container">
      <?php if(wp_is_mobile()):
          get_template_part('template-parts/mobile','nav');
      else:
          get_template_part('template-parts/desktop','nav');
      endif; ?>
    </div>
  </div>
</header>
<main id="jobemployph_wrapper">
