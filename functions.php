<?php
// add post view counter class
require_once get_theme_file_path('inc/PostViewCounter.php');
// add featured post class
require_once get_theme_file_path('inc/FeaturedPost.php');
// add relative category class
require_once get_theme_file_path('inc/RelativeCategory.php');

// add Infinite Scroll class
require_once get_theme_file_path('inc/InfiniteScroll.php');
InfiniteScroll::registerAction();

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

function dumpDie($var)
{
  ini_set("highlight.keyword", "#a50000;  font-weight: bolder");
  ini_set("highlight.string", "#5825b6; font-weight: lighter; ");

  ob_start();
  highlight_string("<?php\n" . var_export($var, true) . "?>");
  $highlighted_output = ob_get_clean();

  $highlighted_output = str_replace(["&lt;?php", "?&gt;"], '', $highlighted_output);

  echo $highlighted_output;
  die();
}