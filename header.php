<!DOCTYPE html>
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= get_the_title(); ?> - <?= get_bloginfo('name'); ?></title>
  <?php wp_head(); ?>
  
  <link rel="preconnect" href="https://fonts.gstatic.com">

</head>
<header id="header">
  <?php
   global $job_manager;
    if( !wp_is_mobile() ){
      get_template_part('template-parts/top','nav');
    }
  ?>

  <div class="navigation">
    <div class="container">
      <?php if(wp_is_mobile()):
          get_template_part('template-parts/mobile','nav');
      else:
          get_template_part('template-parts/desktop','nav');
      endif; ?>
    </div>
  </div>
</header>
<main id="jobemployph_wrapper">
