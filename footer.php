</main>
<footer>
  <div class="container">
    <div class="row text-center">
      <div class="col-md-4 mb-md-0 mb-4">
        <h3 class="mb-4">About Us</h3>
        <?php if( get_field('footer_about_us','option') ): ?>
        <div class="about footer-about">

          <p class="text-justify"><?php echo get_field('footer_about_us','option'); ?></p>

        </div>
        <?php endif; ?>
      </div>
      <div class="col-md-4 mb-md-0 mb-4">
        <h3 class="mb-4">Quick Links</h3>
        <div class="q-links footer-qlinks">
          <?php if( get_field('footer_quick_links','option') ):
            $links = get_field('footer_quick_links','option');
          ?>
          <ul class="quick-links" style="padding: 0;">
            <?php foreach( $links as $link ): ?>
              <li><a href="<?php echo $link['footer_ql_page_link']; ?>"><?php echo $link['footer_ql_page_title']; ?></a></li>
            <?php
            endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-4 mb-md-0 mb-4">
        <h3 class="mb-4">Support Us</h3>
        <div class="donation">
            <?php //get_template_part('template-parts/donation','foot'); ?>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php
wp_footer();
?>
<script>
window.onload = function(){


/* MOBILE NAV JS */

  var menu_btn = document.getElementById('mobile-nav');
  var close_btn = document.getElementById('mobile-nav-close');
if(typeof(menu_btn) != 'undefined' && menu_btn != null){
  menu_btn.addEventListener('click',show_navigation);
  close_btn.addEventListener('click',hide_navigation);
  function show_navigation(){
    //document.querySelector('.nav-overlay').style.width = "100%";
    document.querySelector('.nav-overlay').style.visibility = "visible";
    document.querySelector('.nav-overlay').style.opacity = 1;
    document.getElementById('mobile-nav-menu').style.display = "block";
  }

  function hide_navigation(){
    //document.querySelector('.nav-overlay').style.width = "0";
    document.querySelector('.nav-overlay').style.visibility = "hidden";
    document.querySelector('.nav-overlay').style.opacity = 0;
    document.getElementById('mobile-nav-menu').style.display = "none";
    document.querySelector('.random-show').style.display = "none";
  }
}

/* END MOBILE NAV JS */

var show_company =  document.getElementById('show_company_info');
if(show_company != null){
  show_company.addEventListener('click', show_company_details);
  function show_company_details(){
    document.querySelector('.job-submit').style.display = "block";
  }
}

/* RANDOM SHOW OF ELEMENTS */
if(typeof(menu_btn) != 'undefined' && menu_btn != null){
  var timeArray = new Array(10000, 15000, 20000, 25000, 30000);
  // do stuff, happens to use jQuery here (nothing else does)
  timer = setInterval(toggleSomething, randRange(timeArray));
}

if(document.getElementById('message') != null){
  hide = setInterval(hide_profile_update, 2000);

  function hide_profile_update(){
    if(getComputedStyle(document.getElementById('message'))['visibility'] != "hidden"){
      document.getElementById('message').style.visibility="hidden"
    }
    clearInterval(hide);
  }
}

if(document.getElementById('woo-profile') != null){
  document.getElementById('custom-reg-form').style.display = "block";
}

function randRange(data) {
   var newTime = data[Math.floor(data.length * Math.random())];
   console.log(newTime);
   return newTime;
}

function toggleSomething(){
  document.querySelector('.random-show').style.display = "block";
  clearInterval(timer);
}



/* END RANDOM SHOW OF ELEMENTS */

/* Google Analytics */
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'UA-126698192-1');


}

/**
* Facebook SDK
*/
window.fbAsyncInit = function() {
FB.init({
    appId            : '1466169070084828',
    autoLogAppEvents : true,
    xfbml            : true,
    version          : 'v9.0'
});
};

$(document).ready(function() {
$(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    // Do something
    $('#header').removeClass('fixed');
    if( scroll > 100 ) {
      $('#header').addClass('fixed');
    }
});
});
</script>
