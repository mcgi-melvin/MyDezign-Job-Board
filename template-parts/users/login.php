<form id="user_login" method="POST" action="?user_page=login" autocomplete="off">
  <input type="text" name="login[user_login]" placeholder="Username or Email Address" required />
  <input type="password" name="login[user_password]" placeholder="Password" required />
  <div class="mt-3 mb-3">
    <input type="checkbox" name="login[remember]" value="true"><small><?php echo __('Remember Me','JEPH'); ?></small>
    <input type="hidden" name="JEPH_login_nonce" value="<?php echo wp_create_nonce('JEPH-login-nonce'); ?>"/>
  </div>
  <div class="mt-3 mb-3">
    <input type="submit" value="LOGIN" />
  </div>
  <div class="#login_error" class="text-center">
    <?php JEPH_show_error_messages(); ?>
  </div>
</form>
