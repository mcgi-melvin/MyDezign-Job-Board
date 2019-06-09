<div class="top-bar" style="padding: 5px; background-color: #e7e7e7;">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="top-social">
          <ul class="top-icon social-icons">
            <li><a href="//www.facebook.com/ph.hanapbuhay"><i class="fab fa-facebook-square"></i></a></li>
            <li><a href="//twitter.com/HanapBuhayPH"><i class="fab fa-twitter-square"></i></a></li>
            <li><a href="//hanapbuhayPH.blogspot.com"><i class="fab fa-blogger"></i></a></li>
            <li><a href="//www.pinterest.ph/phhanapbuhay/"><i class="fab fa-pinterest-square"></i></i></a></li>
            <li><a href="//hanapbuhayph.tumblr.com/"><i class="fab fa-tumblr-square"></i></a></li>
            <li><a href="//hanapbuhayphilippines.weebly.com/"><i class="fab fa-weebly"></i></a></li>
            <li><a href="//getpocket.com/@hanapbuhayPH"><i class="fab fa-get-pocket"></i></a></li>
            <li><a href="//www.reddit.com/user/HanapBuhayPH"><i class="fab fa-reddit-square"></i></a></li>
            <li><a href="//hanapbuhayph.wordpress.com/"><i class="fab fa-wordpress"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col">
        <div class="top-action text-right">
            <a class="top-action-btn top-addjob" href="<?php echo site_url('/post-a-job/'); ?>">Submit Job</a>
          <?php if(is_user_logged_in()): ?>
            <a class="top-action-btn top-account" href="<?php echo site_url('/my-account/'); ?>">My Account</a>
            <a class="top-action-btn top-login" href="<?php echo wp_logout_url(site_url().'/my-account/'); ?>">Logout</a>
          <?php else: ?>
            <a class="top-action-btn top-login" href="<?php echo site_url('/my-account/'); ?>">Login</a>
            <a class="top-action-btn top-register" href="<?php echo site_url('/my-account/'); ?>">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
