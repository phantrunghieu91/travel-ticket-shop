<?php
/**
 * The template for default header of single post
 */
if (!defined('ABSPATH'))
  exit;
$current_post = isset($args['current_post']) ? $args['current_post'] : null;
$category = isset($args['category']) ? $args['category'] : null;
if (!$current_post || !$category) {
  return;
}
// an array to store all parent categories
$breadcrumbs = [$category];
// get nested parent categories
$parent_category = $category->parent;
while ($parent_category) {
  $parent_category = get_term($parent_category, 'category');
  $breadcrumbs[] = $parent_category;
  $parent_category = $parent_category->parent;
}
// reverse the array to get the correct order
$breadcrumbs = array_reverse($breadcrumbs);
?>
<header class="single-post__header">
  <div class="header__inner">
    <div class="single-post__breadcrumbs">
      <?php for ($i = 0; $i < count($breadcrumbs); $i++):
        $item = $breadcrumbs[$i];
        ?>
        <a href="<?= esc_url(get_term_link($item->term_id)) ?>" class="breadcrumbs__item"><?= esc_html($item->name) ?></a>
        <?php if ($i < count($breadcrumbs) - 1): ?>
          <span class="dashicons dashicons-arrow-right-alt2 breadcrumbs__separator"></span>
        <?php endif;
      endfor; ?>
    </div>
    <h1 class="single-post__title"><?= esc_html($current_post->post_title) ?></h1>
    <div class="single-post__meta">
      <a class="single-post__author"
        href="<?= esc_url(get_author_posts_url($current_post->post_author)) ?>"><?= esc_html(get_the_author_meta('display_name', $current_post->post_author)) ?></a>
      <span class="single-post__date-time"><?= esc_html(get_the_date('l, d/m/Y - H:i', $current_post->ID)) ?></span>
    </div>
  </div>
</header>