<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

$to = 'techyprosolutions@gmail.com';

$subject = 'Application for SEO Designer';

$application = get_post( 27705 );

$attachment  = [];

if( get_field( 'file', $application->ID ) ) {
    $file = get_field( 'file', $application->ID );
    $attachment = wp_upload_dir()['basedir'] . get_attached_file( $file['ID'] );
}

$param = [
    'job_link'          =>  site_url('/job/joomla-seo-designer-client-based/'),
    'job_title'         =>  'Joomla SEO Designer (client based)',
    'phone'             =>  '061548949846',
    'email'             =>  'sample@sample.com',
    'applicant'    =>  'Arnold Bortunay',
    'subject'           =>  $subject,
    'message'           =>  'Id porta nibh venenatis cras sed felis. Eros donec ac odio tempor orci dapibus ultrices in iaculis. Egestas quis ipsum suspendisse ultrices gravida dictum fusce. Faucibus a pellentesque sit amet porttitor eget dolor. A erat nam at lectus urna duis convallis. Proin fermentum leo vel orci porta non. Placerat duis ultricies lacus sed turpis tincidunt. Viverra adipiscing at in tellus integer feugiat. Sit amet est placerat in egestas erat imperdiet. Et tortor consequat id porta nibh venenatis cras sed. Mauris rhoncus aenean vel elit scelerisque. Aliquet eget sit amet tellus cras adipiscing enim eu. In egestas erat imperdiet sed euismod nisi. Elit duis tristique sollicitudin nibh. Sit amet commodo nulla facilisi nullam vehicula ipsum. Suscipit tellus mauris a diam maecenas sed enim. Enim blandit volutpat maecenas volutpat. Posuere ac ut consequat semper viverra nam libero justo laoreet. Velit aliquet sagittis id consectetur purus ut. Diam in arcu cursus euismod quis viverra nibh cras pulvinar.'
];

$body = email_application_to_employer_exec( $param );

$headers = array('Content-Type: text/html; charset=UTF-8', 'From: Hanap Buhay Philippines <wordpress@jobemployph.tk>');
$result = wp_mail( $to, $subject, $body, $headers, $attachment );
echo $result;
?>