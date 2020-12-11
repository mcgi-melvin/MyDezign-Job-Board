<?php get_header(); ?>


<?php if( have_posts() ): ?>
    <?php while( have_posts() ): ?>
        <?php the_post(); ?>

        <div>
            <?php the_title(); ?>

            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>
<?php endif; ?>



<?php get_footer(); ?>