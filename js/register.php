<?php
add_action('wp_enqueue_scripts', function () {
  if(is_front_page()) {
    wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/js/swiper.js', array(), null, true);
    wp_enqueue_script('homepage', get_stylesheet_directory_uri() . '/js/homepage.js', ['jquery', 'swiper'], time(), true); // 1.0.0
  }
});