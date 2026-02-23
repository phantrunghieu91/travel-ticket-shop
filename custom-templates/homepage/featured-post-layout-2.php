<?php
if (!defined('ABSPATH'))
  exit;
$feature_posts = isset($args['featured_posts']) ? $args['featured_posts'] : [];
$category = isset($args['category']) ? $args['category'] : '';
$count = 0;
?>
<div class="feature-posts layout-2">
  <?php if ($category): ?>
    <a class="feature-posts__title section__title has-underline" href="<?= esc_url(get_term_link($category)) ?>"><?= esc_html($category->name) ?></a>
  <?php endif;
  foreach ($feature_posts as $feature_post_id):
    $feature_post = get_post($feature_post_id);
    $img_size = 'medium';
    $post_position = '';
    if ($count == 0):
      $post_position = 'feature-posts__left';
      $img_size = 'large';
    elseif ($count < 3):
      $post_position = 'feature-posts__center';
    else:
      $post_position = 'feature-posts__right';
      $img_size = 'thumbnail';
    endif;
    if ($count == 0 || $count == 1 || $count == 3):
      ?>
      <div class="<?= $post_position ?>">
      <?php endif; ?>
      <article class="feature-post">
        <a class="feature-post__image" href="<?= esc_url(get_permalink($feature_post->ID)) ?>">
          <?= get_the_post_thumbnail($feature_post->ID, $img_size) ?>
        </a>
        <div class="feature-post__content">
          <a href="<?= esc_url(get_permalink($feature_post->ID)) ?>"
            class="feature-post__title"><?= esc_html($feature_post->post_title) ?></a>
          <?php if ($count >= 3): 
            $cat = get_categories($feature_post)[0]; ?>
            <div class="feature-post__meta">
              <span class="feature-post__date"><?= get_the_date('F j, Y', $feature_post->ID) ?></span>
              <a href="<?= esc_url(get_term_link($cat)) ?>" class="feature-post__category"><?= esc_html($cat->name) ?></a>
            </div>
          <?php endif;
          if ($count == 0): ?>
            <p class="feature-post__excerpt"><?= esc_html($feature_post->post_excerpt) ?></p>
          <?php endif; ?>
        </div>
      </article>
      <?php if ($count == 0 || $count == 2 || $count == 7): ?>
      </div>
    <?php endif; ?>
    <?php $count++; endforeach; ?>
</div>