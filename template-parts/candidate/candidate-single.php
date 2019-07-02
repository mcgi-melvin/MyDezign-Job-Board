<?php
$cid = $_GET['cid'];
$user = get_user_by( 'ID', $cid );
$candidate_profile = get_field('my_profile', 'user_'.$user->ID);
if($candidate_profile['profile_image'] == ""){
  $profile_image = get_template_directory_uri() .'/images/image-none.png';
}else{
  $profile_image = $candidate_profile['profile_image'];
}

if($user->first_name == "" && $user->last_name == ""){
  $name = $user->user_nicename;
}else{
  $name = $user->first_name .' '.$user->last_name;
}

?>
<div class="candidate-single-wrapper">
  <div class="row">
    <div class="col-md-4">
      <img class="single-img-circle" src="<?php echo $profile_image; ?>">
    </div>
    <div class="col-md-8 custom-valign">
      <div class="single-profile-info">
          <h3><strong><?php echo $name; ?></strong></h3>
          <div class="single-bio">
            <?php if($candidate_profile['bio']){
              echo $candidate_profile['bio'];
            }else{
              echo '<p>Welcome to my profile</p>';
              echo '<p>Contact me to know more about me</p>';
            } ?>
          </div>
      </div>
    </div>
  </div>
  <hr />
  <div class="row flex-column-reverse flex-sm-row">
    <div class="col-md-4">
      <div class="single-skills skills">
        <div class="section-title">
          <h5>Personal Skills</h5>
        </div>
        <ul>
        <?php
        if($candidate_profile['pskills']){
          for($x = 0; $x <= count($candidate_profile['pskills'])-1; $x++){
            echo '<li>'.$candidate_profile['pskills'][$x].'</li>';
          }
        }else{
          echo '<li>No skills selected.</li>';
        }

        ?>
        </ul>
      </div>
      <div class="single-skills skills">
        <div class="section-title">
          <h5>Professional Skills</h5>
        </div>
        <ul>
        <?php
        //print_r($candidate_profile);
        if($candidate_profile['prskills']){
          foreach($candidate_profile['prskills'] as $profskills ){
            //print_r($profskills);
            echo '<li>'.$profskills->name.'</li>';
          }
        }else{
          echo '<li>No skills selected.</li>';
        }

        ?>
        </ul>
      </div>
    </div>
    <div class="col-md-8">
      <div class="single-basic-info">
        <div class="section-title">
          <h5>Basic Information</h5>
        </div>
        <table class="table">
          <tr>
            <td class="info-table-label"><i title="Birthdate" class="fas fa-birthday-cake"></i></td>
            <td><?php
             echo $candidate_profile['birthdate'];
            //echo floor((time() - strtotime($candidate_profile['birthdate'])) / 31536000); ?></td>
          </tr>
          <tr>
            <td class="info-table-label"><i title="Gender" class="fas fa-venus-mars"></i></td>
            <td><?php echo $candidate_profile['gender']; ?></td>
          </tr>
          <tr>
            <td class="info-table-label"><i title="Address" class="fas fa-map-marker-alt"></i></td>
            <td><?php echo $candidate_profile['address']; ?></td>
          </tr>
          <tr>
            <td class="info-table-label"><i title="Email Address" class="fas fa-envelope"></i></td>
            <td><?php echo $user->user_email; ?></td>
          </tr>

        </table>
      </div>
    </div>
  </div>
  <hr />

  <div class="row">
      <div class="col-12">
        <div class="single-education-container text-center">
        </div>
      </div>

      <?php if($candidate_profile['has_work_experience'] == 'Yes'):
        $we_count = count($candidate_profile['work_experience']);
        if($we_count == 1){
          $col_size = "4 offset-md-4";
        }elseif($we_count == 2){
          $col_size = "6";
        } else {
            $col_size = "4";
          }
        ?>
      <div class="col-12">
        <div class="single-experience-container text-center">
          <div class="section-title">
            <h5>Work Experience</h5>
          </div>

          <div class="row">
              <?php foreach($candidate_profile['work_experience'] as $we){ ?>
              <div class="col-md-<?php echo $col_size; ?>">
                <div class="single-prev-experience">
                  <div class="company_name">
                    <a href="<?php echo $we['company_website']; ?>">
                      <h5><?php echo $we['prev_company']; ?></h5>
                    </a>
                  </div>
                  <div class="title">
                    <small><?php echo $we['title']; ?></small><br />
                    <small><?php echo $we['role']; ?></small>
                  </div>
                  <div class="period">
                    <small><?php echo $we['period']['period_from']; ?> - <?php echo $we['period']['period_to']; ?></small>
                  </div>
                  <div class="Description">
                    <p><?php echo $we['description']; ?></p>
                  </div>

                </div>
              </div>
            <?php } ?>
          </div>

        </div>
        <hr />
      </div>

    <?php endif; ?>

    <?php if($candidate_profile['has_portfolio'] == 'Yes'):
      //print_r($candidate_profile['portfolio']);
      ?>
    <div class="col-12">
      <div class="section-title">
        <h5>Portfolio</h5>
      </div>
      <div class="row">
        <?php foreach($candidate_profile['portfolio'] as $portfolio){ ?>
          <div class="col-md-4">
            <div class="single-portfolio-container">
              <div class="cover-img">
                <div style="background-image: url('<?php echo $portfolio['cover_image'] ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 250px;"></div>
              </div>
              <div class="project-title">
                <h5><?php echo $portfolio['project_title']; ?></h5>
              </div>
              <div class="project-description">
                <p><?php echo $portfolio['project_overview']; ?></p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  <?php endif; ?>
  </div>



</div>
