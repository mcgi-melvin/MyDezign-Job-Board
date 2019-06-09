<?php
get_header();





$post = get_post(get_the_ID());
$content = apply_filters('the_content', $post->post_content);
?>
<div class="index-main">
<?php echo $content; ?>
</div>




<?php
get_footer();
