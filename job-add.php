<?php
/**
*   Template Name: Jobs - Add Job
*/
get_header();

$author_id = "";

if( is_user_logged_in() ) {
    $author_id = get_current_user_id();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<div id="page_job_add" class="page-job-add">
    <div class="container-fluid">
        <div class="container c-1400">
            <div class="row">
                <?php get_template_part('template-parts/desktop','ads'); ?>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-2">
                <?php get_template_part('template-parts/desktop','ads'); ?>
            </div>
            <div class="col-lg-8">
                <div class="container">
                    <div class="job-add-container">
                        <?php //do_shortcode('[submit_job_form]'); ?>
                        <?php if( isset( $_GET['job_submitted'] ) && $_GET['job_submitted'] == 'success' ): ?>
                        <div class="message-response message-success">
                            <div class="alert alert-success" role="alert">
                            <?= $_SESSION['message_response']; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if( isset( $_GET['job_submitted'] ) && $_GET['job_submitted'] == 'failed' ): ?>
                        <div class="message-response message-failed">
                            <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['message_response']; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <form id="form_add_job" action="/wp-admin/admin-ajax.php" method="POST" autocomplete="off">
                            <div>
                                <?php wp_nonce_field( 'jeph_add_job', 'submit_job' ); ?>
                                <input type="hidden" name="action" value="jeph_add_job" />
                                <input type="hidden" name="author" value="<?= Cryptor::encrypt( $author_id ); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="job_title">Job Title</label>
                                <input type="text" class="form-control field-input" id="job_title" name="job_title" aria-describedby="job_title" placeholder="Enter Job Title" required/>
                            </div>
                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <input type="text" class="form-control field-input" id="salary" name="salary" aria-describedby="salary" placeholder="Enter Salary" />
                            </div>
                            <div class="form-group">
                                <label for="job_location">Location</label>
                                <input type="text" class="form-control field-input" id="job_location" name="job_location" aria-describedby="job_location" placeholder="Enter Location" />
                            </div>
                            <div class="form-group">
                                <label for="job_type">Job Type</label>
                                <?php
                                $types = get_terms( array(
                                    'taxonomy' => 'job_listing_type',
                                    'hide_empty' => false,
                                ) );
                                ?>
                                <select class="form-control field-select" id="job_type" name="job_type">
                                    <option>Select Type</option>
                                    <?php if( $types ): ?>
                                        <?php foreach( $types as $type ): ?>
                                        <option value="<?= $type->term_id ?>"><?= $type->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="job_category">Job Category</label>
                                <?php
                                $categories = get_terms( array(
                                    'taxonomy' => 'job_listing_category',
                                    'hide_empty' => false,
                                ) );
                                ?>
                                <select multiple class="form-control field-select" id="job_category" name="job_category">
                                    <?php if( $categories ): ?>
                                        <?php foreach( $categories as $category ): ?>
                                        <option value="<?= $category->term_id ?>"><?= $category->name; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="job_description">Job Description</label>
                                <?php
                                wp_editor( '', 'job_description', array(
                                    'wpautop'       => true,
                                    'media_buttons' => false,
                                    'textarea_name' => 'job_description',
                                    'editor_class'  => 'job-description field-textarea',
                                    'textarea_rows' => 10
                                ) );
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="application_email">Application Email</label>
                                <input type="text" class="form-control field-input" id="application_email" name="application_email" aria-describedby="application_email" placeholder="" />
                                <small>Email where the application will be sent</small>
                            </div>
                            <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" class="form-control field-input" id="mobile_number" name="mobile_number" aria-describedby="mobile_number" placeholder="" pattern="^(09|\+639)\d{9}$">
                            </div>
                            <div class="form-group">
                                <label for="telephone_number">Telephone Number</label>
                                <input type="text" class="form-control field-input" id="telephone_number" name="telephone_number" aria-describedby="telephone_number" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="application_form">Application Form Link</label>
                                <input type="url" class="form-control field-input" id="application_form" name="application_form" aria-describedby="application_form" />
                            </div>
                            <!-- Should be hidden if user is logged in -->
                            <div class="company-details">
                                <h3>Company Details</h3>
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control field-input" id="company_name" name="company_name" aria-describedby="company_name" placeholder="Enter Company Name" />
                                </div>
                                <div class="form-group">
                                    <label for="company_website">Company Website</label>
                                    <input type="url" class="form-control field-input" id="company_website" name="company_website" aria-describedby="company_website" placeholder="Ex. www.example.com" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-callback="google_recaptcha_callback" data-sitekey="<?= get_field( 'google_recaptcha', 'option' ); ?>"></div>
                            </div>
                            <input class="button button-green" type="submit" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <?php get_template_part('template-parts/desktop','ads'); ?>
            </div>
    
        </div>
        <div class="container c-1400">
            <div class="row">
                <?php get_template_part('template-parts/desktop','ads'); ?>
            </div>
        </div>
    </div>
</div>



<?php
// remove all session variables
session_unset();
// destroy the session
session_destroy();
get_footer(); ?>