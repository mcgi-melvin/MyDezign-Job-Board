<?php
$cur_user = wp_get_current_user();
$user_meta = get_user_meta($cur_user->ID);
?>
<div class="user-<?= __($cur_user->roles[0], 'JEPH') ?>">
  <?php
    if($cur_user->roles[0] === "iwj_employer"){
       require get_template_directory() . '/template-parts/users/employer/dashboard.php';
    }elseif($cur_user->roles[0] === "iwj_candidate"){
      require get_template_directory() . '/template-parts/users/candidate/dashboard.php';
    }else{
      echo 'Coming Soon';
    }

  ?>
</div>
