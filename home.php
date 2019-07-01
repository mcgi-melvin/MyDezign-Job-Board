<?php get_header(); ?>

<div class="blog-container">
	<div class="container">
		<div class="row">
	    <?php get_template_part('template-parts/desktop','ads'); ?>
	  </div>

<?php
$the_query = new WP_Query( array('order' => 'DESC' ) );
if ( $the_query->have_posts() ) :
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
