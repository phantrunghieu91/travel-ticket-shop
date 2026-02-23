<?php
add_shortcode('home_entertainment_categories', function () {
  if (!is_front_page())
    return;
  $category_ids = get_field('entertainment_categories', get_the_ID());
  if (empty($category_ids))
    return '<p>No categories found</p>';
  $categories = get_categories(
    array(
      'include' => $category_ids,
    )
  );
  ob_start();
  ?>
  <div class="entertainment-categories"> <?php
  // get 3 posts per category
  foreach ($categories as $category):
    $cate_posts = get_posts(
      array(
        'category' => $category->term_id,
        'numberposts' => 3,
      )
    );
    if (empty($cate_posts))
      continue;
    ?>
      <div class="entertainment-cat <?= esc_attr($category->slug) ?>">
        <h2 class="entertainment-cat__title section__title"><?= esc_html($category->name) ?></h2>
        <div class="entertainment__cat-posts">
          <?php foreach ($cate_posts as $cat_post): ?>
            <div class="entertainment__post">
              <a href="<?= esc_url(get_permalink($cat_post->ID)) ?>" class="entertainment__post-image">
                <?= get_the_post_thumbnail($cat_post->ID, 'medium') ?>
              </a>
              <div class="entertainment__post-content">
                <a href="<?= esc_url(get_permalink($cat_post->ID)) ?>" class="entertainment__post-title">
                  <?= esc_html($cat_post->post_title) ?>
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div> <!-- Close entertaiment_cat -->
    <?php endforeach; ?>
  </div> <!-- Close entertaiment_categories -->
  <?php
  return ob_get_clean();
});