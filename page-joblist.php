<?php
/*
  Template Name: Jobs
*/
get_header();
?>
<div id="JEPH_joblist">
  <div class="banner text-center" style="background-image: url(<?php echo get_template_directory_uri() .'/assets/images/joblist_banner.jpg'; ?>);">
    <h2 class="text-white"><?php echo get_the_title(); ?></h2>
    <div class="overlay"></div>
  </div>
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-3">
        <!-- FILTER SECTION -->
        <?php require get_template_directory() . '/template-parts/jobs/filter.php'; ?>
      </div>
      <div class="col-md-6">
        <!-- LOOP SECTION -->
        <?php require get_template_directory() . '/template-parts/jobs/tab.php'; ?>
        <?php require get_template_directory() . '/template-parts/jobs/list_loop.php'; ?>
      </div>
      <div class="col-md-3">
        <?php require get_template_directory() . '/template-parts/jobs/sidebar.php'; ?>
      </div>

    </div>
  </div>
</div>

<?php get_footer(); ?>
