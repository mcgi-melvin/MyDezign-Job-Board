<?php
/**
 * Template Name: Template - Job Update
 */

 get_header();
?>
<?php
    function job_update_body(){
    ob_start();
    include get_template_directory() . '/template-parts/email/email-job-update.php';
    return ob_get_clean();
}
?>

<?php
$to = 'ph.hanapbuhay@gmail.com';
$subject = 'Sample Template';
$body = job_update_body();
$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>');
$result = wp_mail( $to, $subject, $body, $headers );
print_r( $result );
?>