<?php
/**
 * Single job listing widget content.
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-widget-job_listing.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     WP Job Manager
 * @category    Template
 * @version     1.31.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$salary = get_post_meta( get_the_ID(), '_job_salary', true );
?>
<li <?php job_listing_class(); ?>>

	<a href="<?php the_job_permalink(); ?>">

		<table>
			<?php if ( isset( $show_logo ) && $show_logo ) { ?>
			<tr>
				<td>
					<div class="image">
						<?php the_company_logo(); ?>
					</div>
				</td>
				<td>
					<div class="widget-position">
						<h3 class="fs-14"><strong><?php wpjm_the_job_title(); ?></strong></h3>
					</div>
					<div class="widget-location">
						<small class="location"><i style="color: #ce2727;" class="fas fa-map-marker"></i> <?php the_job_location( false ); ?></small>
					</div>
					<div class="widget-salary">
						<?php
						if ( $salary ) {
							echo '<small>' . __( '<i class="fa fa-money-bill-wave" style="color:#ce2727;"></i>' ) . ' $' . esc_html( $salary ) . '</small>';
						}
						?>
					</div>
				</td>
			</tr>
			<?php } ?>
			<tr class="content">
				<td>
						<small class="company"><?php the_company_name(); ?></small>

				</td>
			</tr>
			<tr>
				<td>
					<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
						<?php $types = wpjm_get_the_job_types(); ?>
						<?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>
							<small class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>"><?php echo esc_html( $type->name ); ?></small>
						<?php endforeach; endif; ?>
					<?php } ?>
				</td>
			</tr>
		</table>



	</a>
</li>
