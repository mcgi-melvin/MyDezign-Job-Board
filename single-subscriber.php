<?php get_header();

if( isset( $_GET['action'] ) && $_GET['action'] == 'unsubscribe' ) {
    wp_update_post(array(
        'ID'    =>  get_the_ID(),
        'post_status'   =>  'unsubscribe'
    ));
}
if( get_post_status() == 'unsubscribe' ) {
    if ( wp_redirect( site_url() ) ) {
        exit;
    }
}
?>

<div id="single_subscriber" class="subscriber-container container-fluid" data-subscriber="<?= Cryptor::encrypt( 'edit' ); ?>">
    <div class="container c-1400">
        <?php get_template_part('template-parts/desktop','ads'); ?>    
    </div>
    <div class="row">
        <div class="col-md-2">
            <?php get_template_part('template-parts/side','ads'); ?>
        </div>
        <div class="col-md-8">
            <div class="container">
                <div class="subscriber-container">
                    <div class="row justify-content-between mx-0">
                        <div class="personal-field">
                            <div class="subscriber-field mb-4">
                                <h6>Name</h6>
                                <p><?= get_field( 'name' ) ? get_field( 'name' ) : ''; ?></p>
                            </div>
                            <div class="subscriber-field">
                                <h6>Email</h6>
                                <p><?= get_field( 'email' ) ? get_field( 'email' ) : ''; ?></p>
                            </div>
                        </div>
                        <div class="job-field">
                            <div class="subscriber-field mb-4">
                                <h6>Desired Salary</h6>
                                <p><?= get_field( 'desired_salary' ) ? get_field( 'desired_salary' ) : ''; ?></p>
                            </div>
                            <div class="subscriber-field">
                                <h6>Preferred Jobs</h6>
                                <?php if( get_field( 'skills' ) ): ?>
                                    <p>
                                    <?php foreach( get_field( 'skills' ) as $i => $skill ): ?>
                                        <span class="d-block skill-item item-<?= $skill->term_id ?>"><?= $skill->name; ?></span>
                                    <?php endforeach; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="extra-field">
                            <div class="subscriber-field">
                                <h6>Location</h6>
                                <p><?= get_field( 'location' ) ? get_field( 'location' ) : ''; ?></p>
                            </div>
                        </div>
                        <a class="button button-orange w-100" href="javascript:void(0);" onclick="toggleModal();">Unsubscribe</a>
                    </div>
                
                </div>
                <?php if( $_GET['i'] && Cryptor::decrypt( $_GET['i'] ) == 'edit' ): ?>
                <div id="subscriber-update-form" class="subscriber-update-form">
                    <form action="/wp-admin/admin-ajax.php" method="POST" autocomplete="off">
                        <?php wp_nonce_field( 'subscriber_form', 'subscriber_update' ); ?>
                        
                        <input type="hidden" name="action" value="update_subscriber" />
                        <input type="hidden" name="subscriber_id" value="<?= get_the_ID(); ?>" />
                        <div class="mb-3">
                            <input type="text" placeholder="Name" value="<?= get_field( 'name' ) ?>" disabled required/>
                        </div>
                        <div class="mb-3">
                            <input type="text" placeholder="Email Address" value="<?= get_field( 'email' ) ?>" disabled required/>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="desired_salary" placeholder="Desired Salary Per Month" value="<?= get_field( 'desired_salary' ) ? get_field( 'desired_salary' ) : ''; ?>" required/>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="location" placeholder="Location" value="<?= get_field( 'location' ) ?>" required/>
                        </div>
                        <div class="mb-3">
                            <h4>Preferred Job</h4>
                            <div class="skill-list">
                            <?php
                            $terms = get_terms( array(
                                'taxonomy' => 'job_listing_category',
                                'hide_empty' => false,
                            ) );
                            ?>
                            <?php if( $terms ): ?>
                                <?php foreach( $terms as $term ): ?>
                                    <div>
                                        <input type="checkbox" name="skills[]" value="<?= $term->term_id ?>"/> <?= $term->name ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="button button-green" type="submit" value="Submit" />
                        </div>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-2">
            <?php get_template_part('template-parts/side','ads'); ?>
        </div>
    </div>
    <div class="container c-1400">
        <?php get_template_part('template-parts/footer','ads'); ?>    
    </div>
</div>

<div id="modal_unsubscribe">
    <div class="">
        <h4>Are you sure you want to unsubscribe?</h4>
        <h6>You will no longer receive latest jobs update</h6>
    </div>
    <a class="button button-orange" href="<?= get_the_permalink(); ?>?action=unsubscribe" >Yes</a>
    <a class="button button-green" href="javascript:void(0);" onclick="toggleModal();">No</a>
</div>

<script>
jQuery(document).ready(function($) {

});
function toggleModal() {
    $('#modal_unsubscribe').toggleClass('show');
}
</script>
<?php get_footer(); ?>