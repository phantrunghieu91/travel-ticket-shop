<?php
if (!defined('ABSPATH'))
  exit;
$feature_posts = get_posts(
  array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'meta_key' => 'featured_post',
    'meta_value' => '1',
  )
);
if (empty($feature_posts)) {
  return;
}
$count = 0;
?>
<section class="feature-posts-section">
  <div class="section__inner">
    <div class="feature-posts default">
      <?php foreach ($feature_posts as $feature_post_id):
        $feature_post = get_post($feature_post_id);
        $img_size = 'medium';
        $post_position = '';
        if ($count < 5):
          $post_position = 'feature-posts__left';
        elseif ($count > 5):
          $post_position = 'feature-posts__right';
        else:
          $img_size = 'large';
          $post_position = 'feature-posts__center';
        endif;
        if ($count == 0 || $count == 5 || $count == 6):
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
              <?php if ($count == 5): ?>
                <p class="feature-post__excerpt"><?= esc_html($feature_post->post_excerpt) ?></p>
              <?php endif; ?>
            </div>
          </article>
          <?php if ($count == 4 || $count == 5 || $count == 7): ?>
          </div>
        <?php endif; ?>
        <?php $count++; endforeach; ?>
    </div>
  </div>
</section>
<?php
// ! Cleanup variables
unset($feature_posts);