<?php

add_action('wp_head','keywords_and_desc');
function keywords_and_desc(){
    echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({
              google_ad_client: "ca-pub-3206044396168883",
              enable_page_level_ads: true
          });
          </script>';
    global $post;
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

        if(get_post_meta(get_the_ID(),'_job_description',true) != ''){
          echo '<meta content="'.substr(get_post_meta(get_the_ID(),'_job_description',true), 0, 141).'" name="description">';
          echo '<meta content="'.substr(get_post_meta(get_the_ID(),'_job_description',true), 0, 141).'" property="og:description">';
          echo '<meta content="'.substr(get_post_meta(get_the_ID(),'_job_description',true), 0, 141).'" property="twitter:description">';
        }else{
          echo '<meta content="'.$get_post->post_excerpt.'" name="description">';
          echo '<meta content="'.$get_post->post_excerpt.'" property="og:description">';
          echo '<meta content="'.$get_post->post_excerpt.'" property="twitter:description">';
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

        if(get_the_company_logo() != ""){
          echo '<meta property="og:image" content="'.get_the_post_thumbnail_url(get_the_ID(), 'full').'" />
                <meta name="twitter:image" content="'.get_the_post_thumbnail_url(get_the_ID(), 'full').'">';
        } else {
          echo '<meta property="og:image" content="'.site_url().'/wp-content/plugins/wp-job-manager/assets/images/company.png" />
                <meta name="twitter:image" content="'.site_url().'/wp-content/plugins/wp-job-manager/assets/images/company.png">';
        }

        echo '<meta property="og:type" content="article" />
              <meta name="robots" content="index, follow">
              ';

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
          <meta property="og:image:width" content="200px" />
          <meta property="og:image:height" content="200px" />
          <meta property="og:site_name" content="'.get_bloginfo('name').'" />
          <meta property="og:url" content="'.get_permalink().'" />
          <meta name="twitter:site" content="@hanapbuhayph">
          <meta name="twitter:card" content="summary_large_image">
          <meta name="copyright" content="Copyright (&copy;)2018-'.date("Y").' Hanap Buhay Philippines. All Rights Reserved." />';
}

?>
