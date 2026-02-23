<?php
add_shortcode('home_category_carousel', function () {
  if (!is_front_page())
    return;
  $cate_id = get_field('carousel_category', get_the_ID());
  if (!$cate_id)
    return;
  // get 10 posts from the category
  $args = array(
    'numberposts' => 10,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'category' => $cate_id
  );
  $category_posts = get_posts($args);
  if (empty($category_posts))
    return;
  ob_start();
  ?>
  <div class="category-carousel">
    <h2 class="category-carousel__title section__title"><?= get_cat_name($cate_id) ?></h2>
    <div class="category-carousel__posts swiper">
      <div class="swiper-wrapper">
        <?php foreach ($category_posts as $category_post): ?>
          <a class="category-carousel__post swiper-slide" href="<?= get_permalink($category_post->ID) ?>">
            <?= get_the_post_thumbnail($category_post->ID, 'medium') ?>
            <p class="category-carousel__post-title"><?= $category_post->post_title ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="category-carousel__prev">
      <span class="material-symbols-outlined">chevron_left</span>
    </div>
    <div class="category-carousel__next">
      <span class="material-symbols-outlined">chevron_right</span>
    </div>
  </div>
  <?php
  return ob_get_clean();

});