<?php
get_header();
/*
if( !is_user_logged_in() ) {
    die();
}
*/
?>

<?php if( have_posts() ): ?>
<div id="archive_subscriber" class="subscriber-container container-fluid">
    <div class="container c-1400">
        <?php get_template_part('template-parts/desktop','ads'); ?>    
    </div>
    <div class="row">
        <div class="col-md-2">
            <?php get_template_part('template-parts/desktop','ads'); ?>
        </div>
        <div class="col-md-8">
            <div class="container">
                <div class="subscriber-container">
                <?php while( have_posts() ): ?>
                    <?php the_post(); ?>
                    
                    <a href="<?= get_the_permalink(); ?>" class="d-block subscriber-item item-<?= get_the_ID(); ?>">
                        
                        <h6 class="subscriber-name"><?= get_field('name'); ?></h6>
                        <h6 class="subscriber-email"><?= get_field( 'email' ); ?></h6>
                        

                    </a>

                <?php endwhile; ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <?php get_template_part('template-parts/desktop','ads'); ?>
        </div>
    </div>
    <div class="container c-1400">
        <?php get_template_part('template-parts/desktop','ads'); ?>    
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>