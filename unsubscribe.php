<?php
/**
 * Template Name: Subscriber - Unsubscribe
 */
get_header();

$response = [];
if( isset( $_GET['email'] ) ){
    $subscriber_args = [
        'post_type'         =>  'subscriber',
        'posts_per_page'    =>  1,
        'meta_key'          =>  'email',
        'meta_value'        =>  $_GET['email']
    ];
    $subscriber = get_posts( $subscriber_args )[0];
    if( $subscriber ) {
        wp_redirect( get_the_permalink( $subscriber->ID ) );
        $response = [
            'status'    =>  'Success',
            'message'   =>  "You will be redirected"    
        ];
    } else {
        $response = [
            'status'    =>  'danger',
            'message'   =>  'Your email is not listed in our mailing list'    
        ];
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <?php get_template_part('template-parts/side','ads'); ?>
        </div>
        <div class="col-md-8">
            <div class="container site-container-box">
                <div id="unsubscribe_form">
                    <?php if( !empty( $response ) ): ?>
                    <div class="alert alert-<?= $response['status'] ?>" role="alert">
                        <?= $response['message']; ?>
                    </div>
                    <?php endif; ?>
                    <form method="GET" action="">   
                        <div class="form-group">
                            <input class="field-input" type="email" name="email" placeholder="Enter your email address" />
                        </div>
                        <div class="form-group">
                            <input class="button button-orange" type="submit" value="Submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <?php get_template_part('template-parts/side','ads'); ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>