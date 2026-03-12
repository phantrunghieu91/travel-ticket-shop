<?php
add_shortcode('company_info', function($atts){
  extract(shortcode_atts([
    'type' => 'address',
    'class' => '',
  ], $atts));
  switch($type){
    case 'address':
      $address = get_field('address', 'company_info');
      return sprintf('<span class="%s">%s</span>', esc_attr($class), esc_html($address));
    case 'phone':
      $phone = get_field('phone_number', 'company_info');
      // replace all non-numeric characters
      $phone_link = preg_replace('/\D/', '', $phone);
      return sprintf('<a class="%s" href="tel:%s">%s</a>', esc_attr($class), $phone_link, esc_html($phone));
    case 'email':
      $email = get_field('email', 'company_info');
      // check if email is valid
      if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return sprintf('<a class="%s" href="mailto:%s">%s</a>', esc_attr($class), $email, esc_html($email));
      } else {
        return 'Invalid email';
      }
    default:
      return 'Invalid type';
  }
});