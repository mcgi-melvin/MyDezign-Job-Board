<?php if( get_field( 'cta_title' ) OR get_field( 'cta_content' ) OR get_field( 'cta_button' ) ): ?>
<div id="JEPH_CTA">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-6">
        <div class="cta-text">
          <?php if( get_field( 'cta_title' ) ): ?>
            <h3><?= get_field( 'cta_title' ); ?></h3>
          <?php endif; ?>
          <?php if( get_field( 'cta_content' ) ): ?>
            <div><?= get_field( 'cta_content' ); ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-6">
        <a href=""></a>
      </div>

    </div>
  </div>
</div>
<?php endif; ?>