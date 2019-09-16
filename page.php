<?php
get_header();

if (have_posts()):
  while (have_posts()) : the_post();
?>

<div class="index-main">
  <div class="container">
    <div class="row">
	    <?php get_template_part('template-parts/desktop','ads'); ?>
	  </div>
    <div class="content-wrapper">
      <div class="title">
        <h2><?php the_title(); ?></h2>
      </div>
      <div class="post-image">
        <?php the_post_thumbnail('large', array( 'class' => 'img-post' )); ?>
      </div>
      <div class="content">
        <?php echo get_the_content(); ?>
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
get_footer();
