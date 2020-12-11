<?php

add_action('wp_head','keywords_and_desc');
function keywords_and_desc(){
  global $post;
  /* GOOGLE ADS & ANALYTICS */
  
  echo "<script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'UA-126698192-1');
        </script>";
      /*
      echo '<script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-3206044396168883",
            enable_page_level_ads: true
        });
        </script>';
      
      MAILCHIMP POPUP FORM
      echo '<script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/unique-methods/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script>
      <script type="text/javascript">
      window.dojoRequire(["mojo/signup-forms/Loader"], function(L) {
        L.start({
          "baseUrl":"mc.us18.list-manage.com",
          "uuid":"862c320d356bc193d90253597",
          "lid":"93de7c249c",
          "uniqueMethods":true})
        });
      </script>';
       

    if (is_single()){
        $test = get_post_meta(get_the_ID());
        $get_post = get_post(get_the_ID());

        if(get_post_meta(get_the_ID(),'_job_title', true) != ''){
          echo '<title>'. get_post_meta(get_the_ID(),'_company_name', true) .' - '. get_post_meta(get_the_ID(),'_job_title',true).'</title>';
          echo '<meta property="og:title"  content="'. get_post_meta(get_the_ID(),'_company_name',true) .' - '. get_post_meta(get_the_ID(),'_job_title',true).'" />';
          echo '<meta property="twitter:title"  content="'. get_post_meta(get_the_ID(),'_company_name',true) .' - '. get_post_meta(get_the_ID(),'_job_title',true).'" />';
        }else{
          echo '<title>'.get_bloginfo('name').' - '. $get_post->post_title .'</title>';
          echo '<meta property="og:title"  content="'.get_bloginfo('name').' - '. $get_post->post_title .'" />';
          echo '<meta property="twitter:title"  content="'.get_bloginfo('name').' - '. $get_post->post_title .'" />';
        }





        if(get_post_meta(get_the_ID(),'_application',true) != ''){
          echo '<meta name="contact" content="'.get_post_meta(get_the_ID(),'_application',true).'" />';
        }

        // FB and TWITTER META
        if(get_post_meta(get_the_ID(),'_company_twitter',true) != ""){
          echo '<meta name="twitter:creator" content="'.get_post_meta(get_the_ID(),'_company_twitter',true).'">';
        }else{
          echo '<meta name="twitter:creator" content="@hanapbuhayph">';
        }



        echo '<meta property="og:type" content="article" />
              <meta name="robots" content="index, follow">
              <meta content="'.substr(strip_tags(get_the_content()), 0, 141).'" name="description">
              <meta property="og:description" content="'.substr(strip_tags(get_the_content()), 0, 141).'">
              <meta property="twitter:description" content="'.substr(strip_tags(get_the_content()), 0, 141).'">
              <meta property="og:image" content="'.site_url().'/wp-content/uploads/2019/12/hiring.jpg" />
              <meta name="twitter:image" content="'.site_url().'/wp-content/uploads/2019/12/hiring.jpg">';
    }

    if(is_home() || is_front_page()){
      $custom_logo_id = get_theme_mod( 'custom_logo' );
      $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
      echo '<title>'.get_bloginfo('name').' - '.get_the_title().'</title>
            <meta name="twitter:title" content="'.get_bloginfo('name').' - '.get_the_title().'">
            <meta content="Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment." name="description">
            <meta name="contact" content="ph.hanapbuhay@gmail.com" />
            <meta content="Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment." property="og:description">
            <meta content="Hanap Buhay is a complete solution for recruiting agencies and human resources. It’s a perfect website to offer your clients career evolving, new projects for freelancers or just great chances of employment." property="twitter:description">
            <meta property="og:type" content="website" />
            <meta property="og:image" content="'.esc_url( $logo[0] ).'" />
            <meta name="robots" content="index, follow">
            <meta name=”twitter:creator” content=”@hanapbuhayph”>
            ';
    }

    echo '<meta property="fb:app_id" content="1468692359850697" />
          <meta property="og:image:width" content="200" />
          <meta property="og:image:height" content="200" />
          <meta property="og:site_name" content="'.get_bloginfo('name').'" />
          <meta property="og:url" content="'.get_permalink().'" />
          <meta name="twitter:site" content="@hanapbuhayph">
          <meta name="twitter:card" content="summary_large_image">
          <meta name="copyright" content="Copyright (&copy;)2018-'.date("Y").' Hanap Buhay Philippines. All Rights Reserved." />';
    */

}

?>
