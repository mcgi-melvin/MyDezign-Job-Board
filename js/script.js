window.onload = function(){
  /* MOBILE NAV JS */
  if(window.innerWidth <= 780){
    var menu_btn = document.getElementById('mobile-nav');
    var close_btn = document.getElementById('mobile-nav-close');

    menu_btn.addEventListener('click',show_navigation);
    close_btn.addEventListener('click',hide_navigation);
    function show_navigation(){
      document.querySelector('.nav-overlay').style.width = "100%";
      document.querySelector('.nav-overlay').style.visibility = "visible";
      document.getElementById('mobile-nav-menu').style.display = "block";
    }

    function hide_navigation(){
      document.querySelector('.nav-overlay').style.width = "0";
      document.querySelector('.nav-overlay').style.visibility = "hidden";
      document.getElementById('mobile-nav-menu').style.display = "none";
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


  /* Google Analytics */
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-126698192-1');

}
