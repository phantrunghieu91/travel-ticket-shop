<?php
if (!defined('ABSPATH'))
  exit;
$category_id = get_field('featured_category', get_the_ID());
$category = get_term($category_id, 'category');
if( !$category || is_wp_error($category) ) {
  return;
}
$feature_posts = get_posts(
  array(
    'numberposts' => 8,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'category' => $category_id
  )
);
if (empty($feature_posts)) {
  return;
}
$count = 0;
?>
<section class="popular-category-section">
  <div class="section__inner">
    <div class="feature-posts layout-2">
      <?php if ($category): ?>
        <a class="feature-posts__title section__title has-underline"
          href="<?= esc_url(get_term_link($category)) ?>"><?= esc_html($category->name) ?></a>
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
                $cats = get_the_category($feature_post->ID);
                $cat = $cats[0]; ?>
                <div class="feature-post__meta">
                  <span class="feature-post__date"><?= get_the_date('F j, Y', $feature_post->ID) ?></span>
                  <?php if( $cat ): ?>
                    <a href="<?= esc_url(get_term_link($cat)) ?>" class="feature-post__category"><?= esc_html($cat->name) ?></a>
                  <?php endif; ?>
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
  </div>
</section>
<?php 
// ! Cleanup variables
unset($feature_posts, $count, $category_id, $category);