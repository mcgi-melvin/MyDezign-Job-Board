<?php
/* Template Name: Candidate Page */
get_header();

?>

<div class="jobseeker-wrapper">
  <div class="container">
    <div class="jobseeker-container">
    <?php
      if(isset($_GET['cid'])){
        get_template_part('template-parts/candidate/candidate','single');
      }else{
        get_template_part('template-parts/candidate/candidate','loop');
      }
    ?>
    </div>
  </div>
</div>






<?php get_footer(); ?>
