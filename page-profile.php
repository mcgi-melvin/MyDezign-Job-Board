<?php
/* Template Name: My Profile */
acf_form_head(); ?>
<?php get_header(); ?>

	<div id="primary">
		<div id="content" class="container" role="main">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
        <?php
				$fields = get_field_objects();
				//var_dump( $fields );
				?>

			<?php endwhile;
			if(is_user_logged_in()){
				$user_meta=get_userdata($current_user->ID);
				$user_roles=$user_meta->roles;
				if(in_array( 'candidate', $user_roles, true ) OR in_array( 'customer', $user_roles, true )){
					$options = array(
						'post_id' => 'user_'.$current_user->ID,
						'field_groups' => array(),
						'form' => true,
						'return' => add_query_arg( 'updated', 'true', get_permalink() ),
						'html_submit_button'	=> '<input type="submit" class="acf-button btn btn-info button-large" value="%s" />',
						'updated_message' => __("Profile Updated", 'acf'),
						'submit_value' => __("Save Changes", 'acf')
					);
					echo '<input type="hidden" name="user_id" id="user_id" value="'.$current_user->ID.'" />';
					acf_form($options);
				}
			}
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<div class="row">
		<?php get_template_part('template-parts/desktop','ads'); ?>
	</div>
<?php get_footer(); ?>
