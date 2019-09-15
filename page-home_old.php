<?php
/*
  Template Name: Front Page
*/
get_header();
?>
<main>
<div class="body-content container">
  <div class="row">
    <?php get_template_part('template-parts/desktop','ads'); ?>
  </div>
    <?php echo do_shortcode('[jobs]'); ?>
  <div class="row">
    <?php get_template_part('template-parts/desktop','ads'); ?>
  </div>
</div>
</main>











<?php
get_footer();
