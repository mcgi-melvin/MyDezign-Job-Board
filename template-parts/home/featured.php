<div id="JEPH_featured">
  <div class="container">
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
    <h2 class="text-center mb-5">FEATURED JOBS</h2>
    <div class="row">

      <?php
      $args = array(
        'post_type'=>'job_listing',
        'posts_per_page'=>6,
        'meta_query' => array(
          array(
            'key' => '_featured',
            'value' => 1
          ),
        ),
        'paged' => 1
      );
      do_action('getJobList', $args, __( 'col-md-4 featured', 'textdomain' ), 0);
      ?>


    </div> <!-- END LOOP ROW -->
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
  </div>
</div>
