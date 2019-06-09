<?php
/**
 * Job listing in the loop.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @since       1.0.0
 * @version     1.27.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$salary = get_post_meta( $post->ID, '_job_salary', true );
?>
<li <?php job_listing_class(); ?> data-longitude="<?php echo esc_attr( $post->geolocation_lat ); ?>" data-latitude="<?php echo esc_attr( $post->geolocation_long ); ?>">
	<a style="color:#456672;" href="<?php the_job_permalink(); ?>">
		<div class="row">
			<div class="company col-md-1 col-5">
			<?php
						the_company_logo();
						if(wp_is_mobile()){
							the_company_name( '<p class="mobile-company-name"><strong class="text-danger">', '</strong></p>' );
							if ( $salary ) {
								echo '<p style="font-size: 10px;">' . __( '<i class="fa fa-money-bill-wave" style="color:#ce2727;"></i>' ) . ' $' . esc_html( $salary ) . '</p>';
						  }
						}

			?>
			</div>
			<div class="position col-md-8 col">
				<h3><strong class="text-info"><?php echo wpjm_get_the_job_title(); ?></strong></h3>
				<p class="job-desc fs-14"><?php echo substr(strip_tags(wpjm_get_the_job_description()), 0, 100) .'...'; ?></p>
				<div class="company fs-14">
					<?php
					if(!wp_is_mobile()){
						the_company_name( '<strong class="text-danger">', '</strong> ' );
						if(get_the_company_tagline() != ""){
							the_company_tagline( '<span class="tagline">', '</span>' );
						}else{
							echo 'No Company Tagline';
						}

					}
					?>
				</div>
			</div>

			<div class="description col-md-3 fs-14 text-right" style="float:right; padding: 0 20px;">
				<?php
						if(!wp_is_mobile()){

						  if ( $salary ) {
								echo '<p>' . __( '<i class="fa fa-money-bill-wave" style="color:#ce2727;"></i>' ) . ' $' . esc_html( $salary ) . '</p>';
						  }

							echo '<p class="location">'. the_job_location( false ) .'</p>';
							do_action( 'job_listing_meta_start' );
							if ( get_option( 'job_manager_enable_types' ) ) {
								$types = wpjm_get_the_job_types();
								if ( ! empty( $types ) ) :
									foreach ( $types as $type ) : ?>

						<p class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><?php echo esc_html( $type->name ); ?></p>
						<?php endforeach;
								endif;
					 		}
							?>
						<p class="date fs-14"><?php the_job_publish_date(); ?></p>
				<?php
						} // END WP_IS_MOBILE()
				do_action( 'job_listing_meta_end' ); ?>
			</div>
		</div>
	</a>
</li>
