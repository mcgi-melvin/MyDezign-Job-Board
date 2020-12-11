<?php
/*
  Template Name: Jobs
*/
get_header();

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
$s = ""; // DEFAULT SEARCH KEYWORD
$location_query = array( 'key' => '_job_location' ); // DEFAULT META QUERY LOCATION
$tax_query = array( // DEFAULT TAX QUERY
  'taxonomy' => 'job_listing_category',
  'field'    => 'term_id',
  'terms'    => array( 1, 999999999 ),
  'operator' => 'BETWEEN',
);

//$salary = $salary === "" ? array(0,999999999) : explode(',',$salary );
$post_number = (int)get_option( 'job_manager_per_page' );
$args = array(
  'post_type'       => 'job_listing',
  'posts_per_page'  => $post_number,
  'paged'           => $paged,
  's'               => isset( $_GET['q'] ) ? $_GET['q'] : '' // Search this Keyword
);

if( isset( $_GET['job_category']) && !empty( $_GET['job_category'] ) ){
  $category_id = intval( $_GET['job_category'] );
  $args['tax_query'] = array(
    array(
      'taxonomy'=> 'job_listing_category',
      'field' => 'term_id',
      'terms' => $category_id
    )
  );
}

if( isset( $_GET['job_address'] ) && !empty( $_GET['job_address'] ) ){
    $args['meta_query'] = array(
      array(
        'key' => '_job_location',
        'value' => sanitize_text_field( $_GET['job_address'] ),
        'compare' => 'LIKE',
      )
    );
}

$query = new WP_Query( $args );

$categories = get_terms(
  array(
    'taxonomy' => 'job_listing_category',
    'hide_empty' => true,
  )
);
?>
<div id="JEPH_joblist" data-args="<?= json_encode( $args ); ?>">
  <div class="banner text-center" style="background-image: url(<?php echo get_template_directory_uri() .'/assets/images/joblist_banner.jpg'; ?>);">
    <h1 class="text-white"><?php echo get_the_title(); ?></h1>
    <div class="overlay"></div>
  </div>
  <div class="container c-1400">
    <?php get_template_part('template-parts/desktop','ads'); ?>
  </div>

  <div class="container-fluid">
    <div class="row">

      <div class="col-md-2">
        <?php get_template_part('template-parts/side','ads'); ?>
      </div>
      <div class="col-md-8">
        <!-- SEARCH AND FILTER SECTION -->
        <div class="filter-form-container container">

          <form class="row justify-content-between mx-0" action="<?php echo get_permalink(); ?>" method="GET" autocomplete="off">
            <input class="field-input" type="text" title="Job Title" placeholder="Job Title" name="q" />
            <input class="field-input" type="text" title="Address" placeholder="Address" name="job_address" />
            <select class="field-select w-100" name="job_category">
              <option value="" selected>Choose Category</option>
              <?php foreach($categories as $category): ?>
                <option value="<?= $category->term_id; ?>"><?= $category->name; ?></option>
              <?php endforeach; ?>
            <select>
            <input class="button button-green" type="submit" value="SUBMIT" />
          </form>
        
        </div>

        <div class="subscribe-box-container container">
          <div class="row justify-content-between mx-0">
            <a class="button button-orange" href="/jobs/add">Post a Job</a>
            <a class="button button-green" href="javascript:void(0)">Get Job Update</a>  
          </div>
        </div>

        <!-- LOOP SECTION -->
        <?php if( $query->have_posts() ): ?>

        <div id="JEPH_joblist_loop" class="container">
          <div class="joblist-container">
          <?php while( $query->have_posts() ): ?>
            <?php $query->the_post(); ?>
            <a href="<?= get_the_permalink() ?>" class="job-item item-<?= get_the_ID(); ?> d-block pb-4 mb-4">
              <div class="job-title mb-3">
                <h4 class="position-relative"><?= get_the_title(); ?></h4>
              </div>
              <div class="job-meta">
              <table class="table table-borderless">
                <tbody>
                <tr>
                  <td>
                    <time><i class="fa fa-calendar" style="font-weight: 100;"></i> <?php echo get_the_date(); ?></time>
                  </td>
                  <?php if( get_field( '_job_salary' ) ): ?>
                  <td>
                    <div class="salary"><i class="fa fa-coins"></i> <?php echo get_field( '_job_salary' ); ?></div>
                  </td>
                  <?php endif; ?>
                </tr>
                <tr>
                <?php if( get_field( '_company_name' ) ): ?>
                  <td>
                    <a href="<?php echo get_field( '_company_website' ) ? get_field( '_company_website' ) : 'javascript:void(0);'; ?>">
                      <div class="company"><i class="fa fa-building"></i> <?php echo get_field( '_company_name' ); ?></div>
                    </a>
                  </td>
                  <?php endif ?>
                  <?php if( get_field( '_job_location' ) ): ?>
                  <td>
                    <div class="company"><i class="fa fa-globe-asia"></i> <?php echo get_field( '_job_location' ); ?></div>
                  </td>
                  <?php endif ?>
                </tr>
                </tbody>
              </table>
              </div>
              <div class="job-description">
                <?= wp_trim_words( get_the_content() ); ?>
              </div>
            </a>
          <?php endwhile; ?>
          </div>
        </div>
        <?php $total_pages = ceil( $query->found_posts / $post_number ); ?>
        <?php do_action( 'JEPH_pagination', $total_pages, $paged ); ?>

        <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div> <!-- END COL-MD-8 -->
      <div class="col-md-2">
        <?php get_template_part('template-parts/side','ads'); ?>
      </div>

    </div>
  </div>

  <div class="container c-1400">
    <?php get_template_part('template-parts/footer','ads'); ?>
  </div>
</div>

<?php get_footer(); ?>
