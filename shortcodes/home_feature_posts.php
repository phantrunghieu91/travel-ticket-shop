<?php
add_shortcode('home_feature_posts', function ($atts) {
  // get shortcode attributes with santization
  extract(shortcode_atts(array(
    'layout' => 'default',
    'category_slug' => '',
  ), $atts));


  if (!is_front_page())
    return;
  // if (!$category_slug) {
  // get featured posts that have meta key 'featured_post' with value 1
    $feature_posts = get_posts(array(
      'post_type' => 'post',
      'posts_per_page' => 8,
      'meta_key' => 'featured_post',
      'meta_value' => '1',
    ));
  // } else {
  //   // get category id from slug then get posts from that category, limit 8 posts
    $category = get_category_by_slug($category_slug);
  //   $feature_posts = get_posts(array(
  //     'category' => $category->term_id,
  //     'numberposts' => 8,
  //   ));
  // }
  if (empty($feature_posts)):
    return '<p>No posts found</p>';
  else:
    ob_start();
    $param = ['featured_posts' => $feature_posts];
    if($category)
      $param['category_name'] = $category->name;
    get_template_part( 'custom-templates/homepage/featured-post', $layout, $param );
    return ob_get_clean();
  endif;
});