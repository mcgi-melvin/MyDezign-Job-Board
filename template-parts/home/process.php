<div id="JEPH_process">
  <div class="container">
  <?php if( get_field('JEPH_process') ): ?>
    <div class="process-list">
      <div class="row align-items-center">
      <?php foreach( get_field( 'JEPH_process' ) as $i => $process ): ?>
        <div class="col-md-<?= 12 / count( get_field( 'JEPH_process' ) ) ?>">
          <div class="text-center">
            <?php if( $process['icon'] ): ?>
              <img src="<?= $process['icon'] ?>">
            <?php endif; ?>
            <?php if( $process['title'] ): ?>
              <h3><?= $process['title'] ?></h3>
            <?php endif; ?>
            <?php if( $process['description'] ): ?>
              <div><?= $process['description'] ?></div>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
  </div>
</div>
