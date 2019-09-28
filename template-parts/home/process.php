<div id="JEPH_process">

  <div class="row text-center no-ads">
    <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: white;">
      <a href="#">
      <div class="icon-container">
        <?php if( get_field('JEPH_process')['JEPH_process_1']['icon'] ): ?>
          <img width="150" src="<?php echo get_field('JEPH_process')['JEPH_process_1']['icon']; ?>">
        <?php endif; ?>
      </div>
      </a>
    </div>
    <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #dd8041;">
      <div class="info-container text-white">
        <?php if( get_field('JEPH_process')['JEPH_process_1']['title'] ): ?>
          <h3><?php echo get_field('JEPH_process')['JEPH_process_1']['title']; ?></h3>
        <?php endif; ?>
        <?php if( get_field('JEPH_process')['JEPH_process_1']['description'] ): ?>
          <?php echo get_field('JEPH_process')['JEPH_process_1']['description']; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="row text-center no-ads">
    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column-reverse" style="background-color: #183c40;">
      <div class="info-container text-white">
        <?php if( get_field('JEPH_process')['JEPH_process_2']['title'] ): ?>
          <h3><?php echo get_field('JEPH_process')['JEPH_process_2']['title']; ?></h3>
        <?php endif; ?>
        <?php if( get_field('JEPH_process')['JEPH_process_2']['description'] ): ?>
          <?php echo get_field('JEPH_process')['JEPH_process_2']['description']; ?>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column-reverse">
      <a href="#">
      <div class="icon-container">
        <?php if( get_field('JEPH_process')['JEPH_process_2']['icon'] ): ?>
          <img width="150" src="<?php echo get_field('JEPH_process')['JEPH_process_2']['icon']; ?>">
        <?php endif; ?>
      </div>
      </a>
    </div>
  </div>

  <div class="row text-center no-ads">
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <a href="#">
      <div class="icon-container">
        <?php if( get_field('JEPH_process')['JEPH_process_3']['icon'] ): ?>
          <img width="150" src="<?php echo get_field('JEPH_process')['JEPH_process_3']['icon']; ?>">
        <?php endif; ?>
      </div>
      </a>
    </div>
    <div class="col-md-6 d-flex align-items-center justify-content-center" style="background-color: #78c9e6;">
      <div class="info-container">
        <?php if( get_field('JEPH_process')['JEPH_process_3']['title'] ): ?>
          <h3><?php echo get_field('JEPH_process')['JEPH_process_3']['title']; ?></h3>
        <?php endif; ?>
        <?php if( get_field('JEPH_process')['JEPH_process_3']['description'] ): ?>
          <?php echo get_field('JEPH_process')['JEPH_process_3']['description']; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>
