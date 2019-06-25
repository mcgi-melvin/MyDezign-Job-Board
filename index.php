<?php
get_header();
$post = get_post(get_the_ID());
$content = apply_filters('the_content', $post->post_content);
?>

<div class="index-main">
  <div class="container">
    <div class="content-wrapper">
      <div class="title">
        <h2><?php the_title(); ?></h2>
      </div>
      <div class="post-image">
        <?php the_post_thumbnail('large', array( 'class' => 'img-post' )); ?>
      </div>
      <div class="content">
        <?php echo $content; ?>
      </div>

    </div>
  </div>
</div>




<?php
get_footer();
