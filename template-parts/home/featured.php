<div id="JEPH_featured">
  <div class="container">
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
    <h2 class="text-center mb-5">LATEST JOBS</h2>
    <div class="row">

      <?php
      $args = array(
        'post_type'       =>  'job_listing',
        'posts_per_page'  =>  6,
        /*
        'meta_query' => array(
          array(
            'key' => '_featured',
            'value' => 1
          ),
        ),
        */
        'paged'           => 1
      );
      $query = new WP_Query( $args );
      ?>
    <?php if( $query->have_posts() ): ?>
      <?php while( $query->have_posts() ): ?>
        <?php $query->the_post(); ?>
        <?php $meta = get_post_meta(get_the_ID()); ?>
        <div class="col-lg-4 col-md-6 featured mt-3">
          <div class="joblist-container">
            <a href="<?php echo get_the_permalink(); ?>">
              <h4 class="color-white"><?php echo get_the_title(); ?></h4>
            </a>
            <table class="table table-borderless">
              <tbody>
              <tr>
                <td>
                  <time><i class="fa fa-calendar" style="font-weight: 100;"></i> <?php echo get_the_date(); ?></time>
                </td>
                <?php if(!empty($meta['_job_salary'][0])): ?>
                <td>
                  <div class="salary"><i class="fa fa-coins"></i> <?php echo $meta['_job_salary'][0]; ?></div>
                </td>
                <?php endif; ?>
              </tr>
              <tr>
                <?php if(!empty($meta['_company_name'][0])): ?>
                <td>
                  <a href="<?php echo !empty($meta['_company_website'][0]) ? $meta['_company_website'][0] : '#'; ?>">
                    <div class="company"><i class="fa fa-building"></i> <?php echo $meta['_company_name'][0]; ?></div>
                  </a>
                </td>
                <?php endif ?>
                <?php if(!empty($meta['_job_location'][0])): ?>
                <td>
                  <div class="company"><i class="fa fa-globe-asia"></i> <?php echo $meta['_job_location'][0]; ?></div>
                </td>
                <?php endif ?>
              </tr>
              </tbody>
            </table>
            <p><?php echo substr(sanitize_text_field(get_the_content()), 0, 200); ?></p>
            <div class="ApplyNow text-center mt-5 mb-3">
              <a class="button button-white-bordered text-uppercase font-weight-bold" href="<?php echo !empty($meta['_company_website'][0]) ? $meta['_company_website'][0] : get_permalink(); ?>">Apply Now</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    </div> <!-- END LOOP ROW -->
    <div class="row">
      <?php get_template_part('template-parts/desktop','ads'); ?>
    </div>
  </div>
</div>
