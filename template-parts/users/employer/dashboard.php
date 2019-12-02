<?php
$cur_user = wp_get_current_user();
$user_meta = get_user_meta($cur_user->ID);
?>
<div class="employer-dashboard">
  <div class="row">
    <div class="col-xl-3 col-lg-6">
      <div class="employer-messages">
      </div>
    </div>
    <div class="col-xl-6 col-lg-6">
      <div class="employer-joblist">
        <ul class="nav nav-tabs" id="myListing" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="view-listing" data-toggle="tab" href="#job-listing" role="tab" aria-controls="job-listing" aria-selected="true">View Listing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="add-listing" data-toggle="tab" href="#job-add" role="tab" aria-controls="add-listing" aria-selected="false">Add Listing</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active show p-3" id="job-listing" role="tabpanel" aria-labelledby="view-listing">
            <?php
            $paged = get_query_var( 'paged' ) ? get_query_var( 'paged', 1 ) : 1;
            $args = array(
              'post_type' => 'job_listing',
              'author' => $cur_user->ID,
              'posts_per_page' => 5,
              'paged' => $paged,
              'orderby' => 'date',
              'order' => 'DESC'
            );
            $posts = new WP_Query( $args );
            if( $posts->have_posts() ):
            ?>
            <div class="listings-container">
              <?php while($posts->have_posts()): $posts->the_post(); ?>
                <div class="listing-container mb-4 job-<?= get_the_ID(); ?>">
                  <div class="d-flex justify-content-between mb-3">
                    <a href="<?= get_permalink(get_the_ID()); ?>">
                      <span><strong class="text-dark"><?= get_the_title(); ?></strong></span>
                    </a>
                    <div class="listing-action-btn">
                      <a href="#">Edit</a> |
                      <a href="<?= admin_url( 'admin-post.php' ); ?>/?action=delete_job&employer_listing_delete=<?= get_the_ID(); ?>">Delete</a>
                    </div>
                  </div>
                  <p><?= wp_trim_words(get_the_content()); ?></p>
                </div>
              <?php endwhile; ?>
            </div>
            <?php
            do_action('JEPH_pagination', $posts->max_num_pages, $paged);
            wp_reset_postdata();
            endif;
            ?>
          </div>
          <div class="tab-pane fade p-3" id="job-add" role="tabpanel" aria-labelledby="add-listing">
            <div class="tab-heading">
              <h4>Post a Job</h4>
            </div>
            <div class="tab-content">
              <form id="post_job" class="post-job px-2 py-4" action="<?= esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" name="addjob[title]" class="form-control" placeholder="Job Title">
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="addjob[salary]" placeholder="Salary">
                  </div>
                  <div class="col-md-6">
                    <select id="inputState" name="addjob[category]" class="form-control">
                      <option selected>Choose Category</option>
                      <?php
                      $categories = get_terms( array( 'taxonomy' => 'job_listing_category', 'hide_empty' => false ) );
                      foreach($categories as $category):?>
                        <option value="<?= $category->term_id ?>"><?= $category->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <select id="inputState" name="addjob[job_type]" class="form-control">
                      <?php
                      $categories = get_terms( array( 'taxonomy' => 'job_listing_type', 'hide_empty' => false ) );
                      foreach($categories as $category):?>
                        <option value="<?= $category->term_id ?>"><?= $category->name; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <input type="text" name="addjob[location]" class="form-control" placeholder="Location" />
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <h6>Description</h6>
                    <?php
                    $args = array(
                        'tinymce'       => array(
                            'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                            'toolbar2'      => '',
                            'toolbar3'      => '',
                        ),
                        'quicktags' => false,
                        'editor_height' => 425
                    );
                    wp_editor('',"job_description", $args); ?>
                  </div>
                </div>

                <input type="hidden" name="action" value="add_job">
                <input type="submit" value="Submit" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-12">
      <div class="employer-profiles">

        <ul class="nav nav-tabs" id="myProfile" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="owner-tab" data-toggle="tab" href="#owner-profile" role="tab" aria-controls="owner-profile" aria-selected="true">Employer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="company-tab" data-toggle="tab" href="#company-profile" role="tab" aria-controls="company-profile" aria-selected="false">Company</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="employees-tab" data-toggle="tab" href="#company-employees" role="tab" aria-controls="company-profile" aria-selected="false">Employees</a>
          </li>
        </ul>

        <div class="tab-content" id="profile">
          <div class="tab-pane fade show active p-3" id="owner-profile" role="tabpanel" aria-labelledby="owner-tab">
            <div class="tab-heading">
              <div class="d-flex justify-content-between">
                <h4>Employer Profile</h4>
                <div class="settings">
                  <a href="javascript:void(0);" onclick="editEmployer(<?= $cur_user->ID; ?>);">Edit</a>
                </div>
              </div>
            </div>
            <div class="tab-content">
              <table id="user-<?= $cur_user->ID; ?>" class="table">
                <tr>
                  <td class="text-uppercase table-heading">Name</td>
                  <td><span><?= $cur_user->display_name; ?></span></td>
                </tr>
                <tr>
                  <td class="text-uppercase table-heading">Email</td>
                  <td><span><?= $cur_user->user_email; ?></span></td>
                </tr>
                <tr>
                  <td class="text-uppercase table-heading">Phone</td>
                  <td><span><?= $cur_user->phone; ?></span></td>
                </tr>
                <tr>
                  <td class="text-uppercase table-heading">Bio</td>
                  <td><span><?= $cur_user->bio; ?></span></td>
                </tr>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="company-profile" role="tabpanel" aria-labelledby="company-tab">
            Business
          </div>
          <div class="tab-pane fade" id="company-employees" role="tabpanel" aria-labelledby="employees-tab">
            Soon
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
