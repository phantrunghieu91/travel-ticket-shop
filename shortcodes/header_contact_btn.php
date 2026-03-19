<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Shortcode - Header contact button
 */
add_shortcode( 'header_contact_btn', function() {
  $phone = get_field('phone_number', 'company_info');;
  if( !$phone ) {
    return '';
  }
  $link = sprintf('tel:%s', preg_replace('/\s+/', '', $phone) );
  return sprintf('<a href="%s" class="header__contact">
      <span class="material-symbols-outlined header__contact-icon">call</span>
      <span class="header__contact-phone">%s</span>
      <span class="header__contact-text">%s</span>
    </a>', esc_url($link), esc_html($phone), __('Cần hỗ trợ?', 'gpw') );
});