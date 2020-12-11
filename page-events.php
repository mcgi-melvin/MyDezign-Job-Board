<?php get_header(); ?>


<div id="events_page" class="events-page">
  <?php while(have_posts()): the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>
</div>






























<?php get_footer(); ?>
