<?php
get_header();
global $post;

if (have_posts()) : while (have_posts()) : the_post();
$meta = get_post_meta(get_the_ID());
$terms = wp_get_object_terms( get_the_ID(), 'job_listing_type' );
?>

<div id="banner_single" class="banner-single position-relative">
  <div class="banner-single-info text-center">
    <h2 class="text-white font-weight-bold"><?php the_title(); ?></h2>
  </div>
  <div class="banner-overlay position-absolute"></div>
</div>
<div class="single-wrapper">
  <div class="container">
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
    <div class="row">
      <div class="col d-flex align-self-stretch">
        <div class="single-description-container">


        </div>
      </div>
    </div>
    <div class="row">
      <div class="col d-flex align-self-stretch">
        <div class="single-container">
          <p><?= get_the_content(); ?></p>
        </div>
      </div>
    </div>
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
  </div>
</div>
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "JobPosting",
  "title": "<?php echo get_the_title(); ?>",
  "description": "<?php echo sanitize_text_field( get_the_content() ); ?>",
  "hiringOrganization" : {
    "@type": "Organization",
    "name": "<?php echo isset($meta['_company_name'][0]) && !empty($meta['_company_name'][0]) ? $meta['_company_name'][0] : get_bloginfo('name'); ?>",
    "sameAs": "<?php echo get_permalink(); ?>"
  },
  "datePosted": "<?php echo get_the_date(); ?>",
  "validThrough": "",
  "jobLocation": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "",
      "addressLocality": "<?php echo isset($meta['_job_location'][0]) && !empty($meta['_job_location'][0]) ? sanitize_text_field($meta['_job_location'][0]) : 'Manila'; ?>",
      "postalCode": "",
      "addressCountry": "Philippines"
    }
  },
  "employmentType": "<?php echo isset($terms[0]->name) && !empty($terms[0]->name) ? $terms[0]->name : 'Any'; ?>",
  "baseSalary": {
    "@type": "MonetaryAmount",
    "currency": "PHP",
    "value": {
      "@type": "QuantitativeValue",
      "value": "<?php echo isset($meta['_job_salary'][0]) && !empty($meta['_job_salary'][0]) ? $meta['_job_salary'][0] : '15,000 - 30,000' ?>",
      "unitText": "MONTH"
    }
  }
}
</script>




<?php
endwhile;
endif;

get_footer(); ?>
