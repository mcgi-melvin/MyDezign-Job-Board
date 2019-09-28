<form id="user_signup" method="POST" action="?user_page=signup" autocomplete="off">
  <input type="email" name="register[user_email]" placeholder="Email Address" required />
  <input type="text" name="register[user_name]" placeholder="Username" required />
  <input type="password" name="register[user_pass]" placeholder="Password" required />
  <input type="password" name="register[user_repass]" placeholder="Retype Password" required />
  <select name="register[user_role]">
    <option value="iwj_candidate"><?php echo __('Job Seeker','JEPH'); ?></option>
    <option value="iwj_employer"><?php echo __('Employer','JEPH'); ?></option>
  </select>
  <div class="mt-3 mb-3">
    <input type="hidden" name="JEPH_register_nonce" value="<?php echo wp_create_nonce('JEPH-register-nonce'); ?>"/>
    <input type="submit" value="REGISTER" />
  </div>
  <div class="#signup_error" class="text-center">
    <?php JEPH_show_error_messages(); ?>
  </div>
</form>
