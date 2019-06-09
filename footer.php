<style>
  footer{
    padding: 30px 20px;
    background-color: #e7e7e7;
  }
  ul.quick-links li{
    list-style-type: none;
  }
</style>
<footer>
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4">
        <h3>About Us</h3>
        <div class="about footer-about">
          <p class="text-justify">Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment.</p>
        </div>
      </div>
      <div class="col-md-4">
        <h3>Quick Links</h3>
        <div class="q-links footer-qlinks">
          <ul class="quick-links" style="padding: 0;">
            <li><a href="<?php echo site_url('/privacy/'); ?>">Privacy Policy</a></li>
            <li><a href="<?php echo site_url('/terms-and-conditions/'); ?>">Terms and Conditions</a></li>
            <li><a href="<?php echo site_url('/cookie/'); ?>">Cookie Policy</a></li>
          </ul>
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
