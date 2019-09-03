<footer>
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4">
        <h3>About Us</h3>
        <?php if( get_field('footer_about_us','option') ): ?>
        <div class="about footer-about">

          <p class="text-justify"><?php echo get_field('footer_about_us','option'); ?></p>

        </div>
        <?php endif; ?>
      </div>
      <div class="col-md-4">
        <h3>Quick Links</h3>
        <div class="q-links footer-qlinks">
          <?php if( get_field('footer_quick_links','option') ):
            $links = get_field('footer_quick_links','option');
          ?>
          <ul class="quick-links" style="padding: 0;">
            <?php foreach( $links as $link ): ?>
              <li><a href="<?php echo $link['footer_ql_page_link']; ?>"><?php echo $link['footer_ql_page_title']; ?></a></li>
            <?php
            endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-4">
        <h3>Make Donation</h3>
        <div class="donation">
            <?php get_template_part('template-parts/donation','foot'); ?>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php
wp_footer();
?>
