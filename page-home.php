<?php
/*
  Template Name: Job Employ Homepage
*/
get_header();
?>
<div id="home_container">
<!-- BANNER SECTION -->
<?php require get_template_directory() . '/template-parts/home/banner.php'; ?>

<!-- FEATURED SECTION -->
<?php require get_template_directory() . '/template-parts/home/featured.php'; ?>

<!-- PROCESS SECTION -->
<?php require get_template_directory() . '/template-parts/home/process.php'; ?>

<!-- PROCESS SECTION -->
<?php require get_template_directory() . '/template-parts/home/CTA.php'; ?>

</div>

<?php get_footer(); ?>
