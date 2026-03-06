<?php
add_action('wp_enqueue_scripts', function () {
  // import google icons
  wp_enqueue_style('google-icons', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0', array(), null, 'all');
  wp_enqueue_style('header-footer', get_stylesheet_directory_uri() . '/css/header-footer.css', array(), time(), 'all'); // 1.0.0
  wp_enqueue_style('theme-init', get_stylesheet_directory_uri() . '/css/theme-init.css', array(), time(), 'all'); // 1.0.0
  if( is_front_page() || is_singular('product') || is_tax('product_cat') ) {
    wp_enqueue_style('swiper', get_stylesheet_directory_uri() . '/css/swiper.css', array(), null, 'all');
  }
  if (is_front_page()) {
    wp_enqueue_style('homepage', get_stylesheet_directory_uri() . '/css/homepage.css', array(), time(), 'all');
    wp_enqueue_style('swiper', get_stylesheet_directory_uri() . '/css/swiper.css', array(), null, 'all');
  }
  // import custom-archive.css for archive page and not for archive-video.php, taxonomy-video-type.php
  if (is_archive() && !is_post_type_archive('video') && !is_tax('video-type')) {
    wp_enqueue_style('custom-archive', get_stylesheet_directory_uri() . '/css/custom-archive.css', array(), '1.0.2', 'all');
  }
  // import custom-single-post.css for single page with 'post' post type only
  if (is_single() && get_post_type() === 'post') {
    wp_enqueue_style('custom-single-post', get_stylesheet_directory_uri() . '/css/custom-single-post.css', array(), '1.0.0', 'all');
  }
  // import custom-search.css for search page
  if (is_search()) {
    wp_enqueue_style('custom-search', get_stylesheet_directory_uri() . '/css/custom-search.css', array(), '1.0.0', 'all');
  }
  // import video-post-type.css for archive, taxonomy and single page of video post type
  if (is_post_type_archive('video') || is_tax('video-type') || is_singular('video')) {
    wp_enqueue_style('video-post-type', get_stylesheet_directory_uri() . '/css/video-post-type.css', array(), '1.0.0', 'all');
  }
  if( is_singular('product') ) {
    wp_enqueue_style('fancybox', get_stylesheet_directory_uri() . '/css/fancybox.min.css', [], null, 'all');
    wp_enqueue_style('gpw-single-product-page', get_stylesheet_directory_uri() . '/css/gpw-single-product-page.css', array(), time(), 'all');
  }
  if( is_tax('product_cat') ) {
    wp_enqueue_style('gpw-category-product-page', get_stylesheet_directory_uri() . '/css/gpw-category-product-page.css', array(), time(), 'all');
  }
});