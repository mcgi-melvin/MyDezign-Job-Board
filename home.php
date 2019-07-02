<?php
$paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
$offset = $paged != 1 ? "'offset' => ".$posts_per_page."" : "";
get_header();
?>

<div class="blog-container">
	<div class="container">
		<div class="row">
	    <?php get_template_part('template-parts/desktop','ads'); ?>
	  </div>

<?php
$the_query = new WP_Query( array('order' => 'DESC', 'paged' => $paged ) );

if ( $the_query->have_posts() ) :
	$total_pages = ceil( $the_query->found_posts / 10 );
	echo '<div class="blog-loop-wrapper">';
	echo '<div class="page-title">';
		echo '<h2>'.single_post_title('',false).'</h2>';
	echo '</div>';
	echo '<hr />';
	echo '<div class="row">';
	echo '<div class="col-md-8 col-12">';
	while ( $the_query->have_posts() ) : $the_query->the_post();
?>

		<div class="loop-blog-single">
			<a href="<?php echo get_permalink(); ?>">
			<div class="featured-image">
				<?php if(has_post_thumbnail()): ?>
						<div style="background-image: url('<?php the_post_thumbnail_url(); ?>');"></div>
				<?php else: ?>
						<div style="background-image: url('<?php echo site_url('/wp-content/uploads/woocommerce-placeholder.png'); ?>'); "></div>
				<?php endif; ?>
			</div>
			</a>
			<div class="loop-blog-body">
				<a href="<?php echo get_permalink(); ?>">
				<div class="title">
					<h3><?php echo get_the_title(); ?></h3>
				</div>
				</a>
				<div class="desc">
					<p><?php echo get_the_excerpt(); ?></p>
				</div>
			</div>
		</div>


<?php
	wp_reset_postdata();
	endwhile;
	?>
	<div class="jobseeker-pagination-wrapper">

    <?php
    echo paginate_links( array(
        'base' => str_replace( 99999, '%#%', esc_url( get_pagenum_link( 99999 ) ) ), // the base URL, including query arg
        'format' => '/%#%/', // this defines the query parameter that will be used, in this case "p"
        'prev_text' => __('&laquo; Previous'), // text for previous page
        'next_text' => __('Next &raquo;'), // text for next page
        'total' => $total_pages, // the total number of pages we have
        'current' => $paged, // the current page
        'end_size' => 1,
        'mid_size' => 2,
        'type' => 'list'
    ));

     ?>
  </div>
	<?php
		echo '</div>
			<div class="col-md-4 col-12">';
				echo 	dynamic_sidebar('primary_sidebar');
			echo '</div>';
		echo '</div>';
	echo '</div>'; //end row
else:
	echo 'No Post';
endif;
?>


		<div class="row">
			<?php get_template_part('template-parts/desktop','ads'); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
