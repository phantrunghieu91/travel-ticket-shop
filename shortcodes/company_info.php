<?php
add_shortcode('company_info', function($atts){
  extract(shortcode_atts(array(
    'type' => '') , $atts));
  switch($type){
    case 'address':
      return get_field('address', 'company_info');
    case 'phone':
      $phone = get_field('phone_number', 'company_info');
      // replace all non-numeric characters
      $phone_link = preg_replace('/\D/', '', $phone);
      return '<a href="tel:' . $phone_link . '">' . esc_html($phone) . '</a>';
    case 'email':
      $email = get_field('email', 'company_info');
      // check if email is valid
      if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return '<a href="mailto:' . $email . '">' . esc_html($email) . '</a>';
      } else {
        return 'Invalid email';
      }
    default:
      return 'Invalid type';
  }
});