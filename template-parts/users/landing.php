<div class="container">
  <div id="user_landing" class="user-landing">

    <nav class="nav nav-pills nav-justified">
      <a class="nav-item user-button active" id="nav-menu-login" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true"><?php echo __('Login','JEPH') ?></a>
      <a class="nav-item user-button" id="nav-menu-signup" data-toggle="tab" href="#nav-signup" role="tab" aria-controls="nav-signup" aria-selected="true"><?php echo __('Signup','JEPH') ?></a>
    </nav>
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="v-pills-home-tab">
        <div class="mb-3 mt-5">
          <h3 class="text-center"><?php echo __('Login Your Account','JEPH') ?></h3>
          <?php require get_template_directory() . '/template-parts/users/login.php'; ?>
        </div>
      </div>
      <div class="tab-pane fade" id="nav-signup" role="tabpanel" aria-labelledby="v-pills-profile-tab">
        <div class="mb-3 mt-5">
          <h3 class="text-center"><?php echo __('Register Account','JEPH') ?></h3>
          <?php require get_template_directory() . '/template-parts/users/signup.php'; ?>
        </div>
      </div>
    </div>

  </div>
</div>
