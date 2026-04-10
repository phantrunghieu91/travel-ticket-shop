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
$author_url = get_author_posts_url($current_post->post_author);
$author_name = get_the_author_meta('display_name', $current_post->post_author);
?>
<header class="single-post__header">
  <div class="header__inner">
    <h1 class="single-post__title"><?= esc_html($current_post->post_title) ?></h1>
    <ul class="single-post__meta">
      <li class="single-post__meta-item single-post__author">
        <span class="material-symbols-outlined">sell</span>
        <a href="<?= esc_url($author_url) ?>"><?= esc_html($author_name) ?></a>
      </li>
      <li class="single-post__meta-item single-post__date-time">
        <span class="material-symbols-outlined">calendar_today</span>
        <span><?= esc_html(get_the_date('l, d/m/Y - H:i', $current_post->ID)) ?></span>
      </li>
      <li class="single-post__meta-item single-post__share-btns">
        <?= do_shortcode('[share]') ?>
      </li>
    </ul>
  </div>
</header>