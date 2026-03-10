<?php
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script('theme-init', get_stylesheet_directory_uri() . '/js/theme-init.js', [], time(), true);
  if( is_front_page() || is_singular('product') || is_tax('product_cat') ) {
    wp_enqueue_script('swiper', get_stylesheet_directory_uri() . '/js/swiper.js', array(), null, true);
  }
  if(is_front_page()) {
    wp_enqueue_script('homepage', get_stylesheet_directory_uri() . '/js/homepage.js', ['jquery', 'swiper'], time(), true); // 1.0.0
  }

  if( is_singular('product') ) {
    wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/js/fancybox.min.js', [], null, true);
    wp_enqueue_script('gpw-single-product-page', get_stylesheet_directory_uri() . '/js/gpw-single-product-page.js', ['swiper', 'fancybox'], time(), true);
  }
  if( is_tax('product_cat') ) {
    wp_enqueue_script('gpw-category-product-page', get_stylesheet_directory_uri() . '/js/gpw-category-product-page.js', ['swiper'], time(), true);
  }
});