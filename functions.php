<?php
define('PLACEHOLDER_IMAGE_ID', 516);

// add post view counter class
require_once get_theme_file_path('inc/PostViewCounter.php');
// add featured post class
require_once get_theme_file_path('inc/FeaturedPost.php');
// add relative category class
require_once get_theme_file_path('inc/RelativeCategory.php');

// add Infinite Scroll class
require_once get_theme_file_path('inc/InfiniteScroll.php');
InfiniteScroll::registerAction();

// add Woocommerce override class
require_once get_theme_file_path('inc/WoocommerceOverride.php');
new WoocommerceOverride();

// Turn off auto gen <p> of contact form 7
add_filter('wpcf7_autop_or_not', false);

// add dashicons to normal page too
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('dashicons');
});

// Include other php
include get_theme_file_path('shortcodes/register.php');
include get_theme_file_path('js/register.php');
include get_theme_file_path('css/register.php');

function get_url_form_link_to( $link_to_data ) {
  $type = $link_to_data['type'];

    if($type === 'none') {
      return false;
    }
    
    $data = $link_to_data[$type];
    $url = '';

    switch ($type) {
      case 'custom':
        $url = $data;
        break;
      case 'post':
      case 'page':
      case 'product':
        $url = get_permalink($data);
        break;
      case 'category':
      case 'product_cat':
        $url = get_term_link($data, 'product_cat');
        break;
    }
    if( $url instanceof \WP_Error ) {
      $url = '';
    }
    $return = !empty($url) && $url != '' ? esc_url($url) : false;
    return $return;
}