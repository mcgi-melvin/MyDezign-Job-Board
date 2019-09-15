<?php

add_shortcode( 'JEPH_subscribe_form', '_subscribe_form' );
function _subscribe_form(){
  $form = "";
  $form .= '<div class="cta-form">';
  $form .= '<form method="post" action="#">';
  $form .= '<input type="text" placeholder="Full Name" />';
  $form .= '<input type="email" placeholder="Email Address" />';
  $form .= '<input type="submit" value="SUBMIT" />';
  $form .= '</form>';
  $form .= '</div>';

  return $form;
}

?>
