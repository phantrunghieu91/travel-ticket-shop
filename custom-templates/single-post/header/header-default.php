<?php
/**
 * The template for default header of single post
 */
?>
<header class="single-post__header">
  <div class="header__inner">
    <div class="single-post__categories">
      <?php foreach ($categories as $category): ?>
        <a href="<?= esc_url(get_term_link($category->term_id)) ?>"
          class="single-post__category"><?= esc_html($category->name) ?></a>
      <?php endforeach; ?>
    </div>
    <h1 class="single-post__title"><?= esc_html($current_post->post_title) ?></h1>
    <div class="single-post__meta">
      <a class="single-post__author"
        href="<?= esc_url(get_author_posts_url($current_post->post_author)) ?>"><?= esc_html(get_the_author_meta('display_name', $current_post->post_author)) ?></a>
      <span class="single-post__date-time"><?= esc_html(get_the_date('l, d/m/Y - H:i', $current_post->ID)) ?></span>
    </div>
  </div>
</header>