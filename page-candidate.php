<?php
/* Template Name: Candidate Page */
get_header();
?>

<div class="jobseeker-wrapper">
  <div class="page-title text-center">
    <h2>Job Seekers</h2>
  </div>
  <div class="container">
    <div class="jobseeker-container">
    <?php
      get_template_part('template-parts/candidate/candidate','loop');
    ?>
    </div>
  </div>
</div>






<?php get_footer(); ?>
