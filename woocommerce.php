<?php
/**
 * The template for displaying Category pages
 * @package inhost
 */
get_header();
if(is_shop()){
    $post_id = get_option('woocommerce_shop_page_id');
}
?>

<div class="page-content page-content-product" style="margin: 30px 0;">
    <div class="main-content">
        <div class="container">
            <div class="product-content">
                <?php
                if ( is_singular( 'product' ) ) {
                    while ( have_posts() ) : the_post();
                        wc_get_template_part( 'content', 'single-product' );
                    endwhile;
                    ?>
                <?php } else { ?>
                <div class="row">
                  <div class="col">
                    <?php woocommerce_content(); ?>
                  </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
