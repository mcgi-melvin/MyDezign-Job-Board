<?php
if( get_field('home_banner') ){
  $bg_link = get_field('home_banner');
}
?>


<div id="JEPH_banner" class="banner" style="background-image: url(<?php echo $bg_link; ?>);">
    <div class="home-box text-center">
      <?php if( get_field('home_title_text') ): ?>
        <h1 class="text-uppercase"><?php echo get_field('home_title_text'); ?></h1>
      <?php endif; ?>
      <form method="POST" action="<?php echo site_url('/'.apply_filters('get_template_url', 'page-joblist.php')[0]->post_name); ?>" autocomplete="off">
        <input type="text" name="q" placeholder="Search Keyword" required />
        <input class="text-uppercase" type="submit" name="submit" value="Search" />
      </form>
      <a class="text-uppercase" href="<?php echo site_url('/'.apply_filters('get_template_url', 'page-joblist.php')[0]->post_name); ?>"><small>Browse All Jobs</small></a>
    </div>
    <div class="overlay">
  </div>
</div>
