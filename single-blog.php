<?php
get_header();

if (have_posts()):
  while (have_posts()) : the_post();
?>


<div class="single-wrapper">
  <div class="container">
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
    <div class="row">
      <div class="col-12 col-md-12 col-lg-8 d-flex align-self-stretch">
        <div class="single-container">
          <h2><?php the_title(); ?></h2>
          <p><?php the_content(); ?></p>
        </div>
      </div>
      <div class="col-12 col-md-12 col-lg-4">
        <div class="single-sidebar">
          <?php dynamic_sidebar('primary_sidebar'); ?>
        </div>
      </div>
    </div>
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
  </div>
</div>





<?php
  endwhile;
  wp_reset_postdata();
endif;

get_footer(); ?>
