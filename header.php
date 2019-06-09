<?php

wp_head();
?>
<?php if(!wp_is_mobile()){
  get_template_part('template-parts/top','nav');
} ?>
<div class="navigation" style="background-color:#456672; padding: 10px 0;">
  <div class="container">
    <?php if(wp_is_mobile()):
        get_template_part('template-parts/mobile','nav');
    else:
        get_template_part('template-parts/desktop','nav');
    endif; ?>
  </div>
</div>
