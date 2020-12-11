<?php
get_header();
global $post;

if (have_posts()) : while (have_posts()) : the_post();
$meta = get_post_meta(get_the_ID());
$terms = wp_get_object_terms( get_the_ID(), 'job_listing_type' );
?>

<div id="banner_single" class="banner-single position-relative">
  <div class="banner-single-info text-center">
    <h1 class="text-white font-weight-bold"><?php the_title(); ?></h1>
  </div>
  <div class="banner-overlay position-absolute"></div>
</div>
<div class="single-wrapper">
  <div class="container-fluid">
    <div class="container c-1400">
        <div class="row">
          <?php get_template_part('template-parts/desktop','ads'); ?>
        </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        <?php get_template_part('template-parts/side','ads'); ?>
      </div>
      <div class="col-md-8">
        <div class="container">
            <div class="user-action-container">
              <div class="row">
                <div class="col-md-9">
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
                </div>
                <div class="col-md-3 text-md-right text-center">
                  <a class="button button-orange" href="#application_form">Apply</a>
                </div>
              </div>
            </div>

            <div class="single-container">
              <p><?php the_content(); ?></p>
              <a id="fb_share" class="button button-orange" href="http://www.facebook.com/share.php?u=<?= get_the_permalink(); ?>" target="facebook-share-dialog">
                Share it to your friends
              </a>
              
            </div>

            <div id="application_form" class="application-form">
              
              <?php if( isset( $_GET['application_submitted'] ) ): ?>
                <div class="application-form-response response-success mb-4">
                  Your application has been submitted.
                </div>
              <?php endif; ?>
                <div class="application-form-response response-error response-not-shared d-none mb-4">
                  You must share the job first.
                </div>
                <?php if( get_field( 'HB_mobile_number' ) ): ?>
                  <a class="button button-orange w-100 mb-5" href="tel:<?= get_field( 'HB_mobile_number' ) ?>">Call Now <?= get_field( 'HB_mobile_number' ) ?></a>
                <?php endif; ?>
                <?php if( get_field( 'application_form_link' ) ): ?>
                  <a class="button button-green w-100 mb-5" href="tel:<?= get_field( 'application_form_link' ) ?>">Fill Up the Application Form</a>
                <?php endif; ?>
                <?php if( get_field( '_application' ) ): ?>
                <h3 class="text-uppercase mb-4">Send Application</h3>
                <form action="/wp-admin/admin-ajax.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div>
                        <?php wp_nonce_field( 'application_form', 'application_id' ); ?>
                        <input type="hidden" name="mailto" value="<?= !empty( get_field( '_application' ) ) ? get_field( '_application' ) : 'employer'; ?>" />
                        <input type="hidden" name="action" value="submit_application" />
                        <input type="hidden" name="job_id" value="<?= get_the_ID(); ?>" />
                        <input type="hidden" name="job_title" value="<?= esc_html( get_the_title() ); ?>" />
                        <input id="share_input" type="hidden" name="shared" value="0" />
                    </div>
                    <div class="mb-3">
                      <input class="field-input" type="text" name="name" placeholder="Full Name" required/>
                    </div>
                    <div class="mb-3">
                      <input class="field-input" type="text" name="email" placeholder="Email" required/>
                    </div>
                    <div class="mb-3">
                      <input class="field-input" type="text" name="phone" placeholder="Phone" pattern="^(09|\+639)\d{9}$" required/>
                    </div>
                    <div class="mb-3">
                      <input class="field-input" type="text" name="subject" placeholder="Subject" required/>
                    </div>
                    <div class="mb-3">
                      <textarea class="field-textarea" name="message" rows="5" placeholder="Message" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label>File</label>
                      <input class="d-block" type="file" name="cv" />
                    </div>
                    <div class="form-check mb-3">
                      <input type="checkbox" class="form-check-input" id="form_checkbox" name="approve_mailing" value="true" checked>
                      <label class="form-check-label" for="form_checkbox">Subscribe to our mailing list. You'll receive latest jobs updates, tips, and other free services.</label>
                    </div>
                    <div class="mb-3">
                      <div class="g-recaptcha" data-callback="google_recaptcha_callback" data-sitekey="<?= get_field( 'google_recaptcha', 'option' ); ?>"></div>
                    </div>
                    <div class="mb-3">
                      <input class="button button-green" type="submit" value="Send Application" />
                    </div>
                </form>
                <?php endif; ?>
                <?php if( !get_field( 'HB_mobile_number' ) && !get_field( 'application_form_link' ) && !get_field( '_application' ) ): ?>
                  No way to apply on this job. Please find other job on the related jobs section
                <?php endif; ?>
            </div>


            <?php
            $categories = get_the_terms( get_the_ID(), 'job_listing_category' ); //as it's returning an array
            foreach( $categories as $category ) {
              $job_category[] = $category->term_id;
            }
            $args = [
              'post_type'       =>  'job_listing',
              'posts_per_page'  =>  3,
              'post__not_in'    =>  array( get_the_ID() ),
            ];
            if( $job_category ) {
              $args['tax_query'] = array(
                'relation'      =>  'OR',
                array(
                  'taxonomy'      =>  'job_listing_category',
                  'field'         =>  'term_id',
                  'terms'         =>  $job_category
                )
                
              );
            }

            $jobs = get_posts( $args );
            ?>
            <?php if( $jobs ): ?>
            <div id="related_jobs" data-categories="<?= json_encode( $job_category ); ?>">
              <h3 class="text-uppercase mb-4">Related Jobs</h3>
              <div class="related-jobs-container">
                <div class="row">
                  <?php foreach( $jobs as $i => $job ): ?>
                    <div class="col-lg-4 col-md-6 featured mt-3">
                      <div class="joblist-container">
                        <a href="<?php echo get_the_permalink( $job->ID ); ?>">
                          <h4 class="color-white"><?php echo get_the_title( $job->ID ); ?></h4>
                        </a>
                        <table class="table table-borderless">
                          <tbody>
                          <tr>
                            <td>
                              <time><i class="fa fa-calendar" style="font-weight: 100;"></i> <?php echo get_the_date( '', $job->ID ); ?></time>
                            </td>
                            <?php if( get_field( '_job_salary', $job->ID ) ): ?>
                            <td>
                              <div class="salary"><i class="fa fa-coins"></i> <?php echo get_field( '_job_salary', $job->ID ); ?></div>
                            </td>
                            <?php endif; ?>
                          </tr>
                          <tr>
                            <?php if( get_field( '_company_name', $job->ID ) ): ?>
                            <td>
                              <a href="<?php echo get_field( '_company_website', $job->ID ) ? get_field( '_company_website', $job->ID ) : '#'; ?>">
                                <div class="company"><i class="fa fa-building"></i> <?php echo get_field( '_company_name', $job->ID ); ?></div>
                              </a>
                            </td>
                            <?php endif ?>
                            <?php if( get_field( '_job_location', $job->ID ) ): ?>
                            <td>
                              <div class="company"><i class="fa fa-globe-asia"></i> <?php echo get_field( '_job_location', $job->ID ); ?></div>
                            </td>
                            <?php endif ?>
                          </tr>
                          </tbody>
                        </table>
                        <p><?php echo substr(sanitize_text_field( get_the_content( null, false, $job->ID ) ), 0, 200); ?></p>
                        <div class="ApplyNow text-center mt-5 mb-3">
                          <a class="button button-white-bordered text-uppercase font-weight-bold" href="<?php echo get_permalink( $job->ID ); ?>">Apply Now</a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <?php endif; ?>
        </div>
      </div>
      <div class="col-md-2">
        <?php get_template_part('template-parts/side','ads'); ?>
      </div>
    </div>
    <div class="container c-1400">
        <div class="row">
          <?php get_template_part('template-parts/footer','ads'); ?>
        </div>
    </div>
  </div>
</div>
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "JobPosting",
  "title": "<?php echo get_the_title(); ?>",
  "description": "<?php echo sanitize_textarea_field( get_the_content() ); ?>",
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
?>

<script>
jQuery(document).ready(function($) {
  var hashtags = ['HanapBuhayPH', 'JobEmployPH']
  $( '#application_form form' ).on( 'submit', function(e) {
    /*
    if( $(this).find('input[name="shared"]').val() == 0 ) {
      $('.response-not-shared').removeClass('d-none');
      console.log( 'Not Shared' );
      e.preventDefault();
      return false;
    }
    */
    $(this).find('input[type="submit"]').prop( 'disabled', true );
  } );
  /*
  $('#fb_share').click(function(e){
    e.preventDefault();
    FB.ui(
      {
        method: 'share',
        name: '<?= get_the_title(); ?>',
        href: '<?= get_the_permalink() ?>',
        redirect_uri: '<?= get_the_permalink() ?>/?shared=<?= Cryptor::encrypt(1); ?>',
        picture: 'https://jobemployph.tk/wp-content/uploads/2019/12/hiring.jpg',
        caption: 'Job Employ PH',
        description: '<?= wp_trim_words( get_the_content(), 20 ) ?>',
        message: 'Sample',
        hashtag: '#'+hashtags[Math.floor(Math.random() * hashtags.length)],
      }, function(response) {
        if( response ) {
          //$('#application_form').find('input[type="submit"]').prop( 'disabled', false );
          $('#application_form').find('input[type="submit"]').removeClass('no-share');
          $('#application_form').find('input#share_input').val( 1 );
        }
      }
    );
  });
  */
});

function google_recaptcha_callback( response ) {
  /*
  if( response ) {
    $.ajax({
      method: 'GET',
      url: "https://2captcha.com/in.php",
      data: {
        key: "<?= get_field( '2_captcha_key', 'option' ) ?>",
        method: "userrecaptcha",
        googlekey: '<?= get_field( 'google_recaptcha', 'option' ) ?>',
        pageurl: '<?= get_permalink() ?>'
      },
      beforeSend: function( xhr ) {
        xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
      }
    })
    .done(function( data ) {
      console.log( data );
    });
    
  }
  */
}
</script>

<?php get_footer(); ?>
