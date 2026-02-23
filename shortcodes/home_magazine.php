<?php
add_shortcode('home_magazine', function () {
  if (!is_front_page())
    return;
  // get 10 posts as template first
  $magazine_posts = get_posts(
    array(
      'numberposts' => 10,
    )
  );
  if (empty($magazine_posts))
    return '<p>No posts found</p>';
  ob_start();
  ?>
  <div class="magazines">
    <div class="magazines__title section__title">Magazine</div>
    <div class="magazines__posts swiper">
      <div class="swiper-wrapper">
        <?php foreach ($magazine_posts as $magazine_post): 
          $category = get_the_category( $magazine_post->ID )[0];
          ?>
          <article class="magazine__post swiper-slide">
            <a class="magazine__image" href="<?= esc_url(get_permalink($magazine_post->ID)) ?>">
              <?= get_the_post_thumbnail($magazine_post->ID, 'medium') ?>
            </a>
            <div class="magazine__content">
              <span class="magazine__category"><?= esc_html($category->name) ?></span>
              <p class="magazine__title"><?= esc_html($magazine_post->post_title) ?></p>
              <span class="material-symbols-outlined">news</span>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="magazines__prev">
        <span class="material-symbols-outlined">chevron_left</span>
      </div>
      <div class="magazines__next">
        <span class="material-symbols-outlined">chevron_right</span>
      </div>
  </div>
  <?php return ob_get_clean();
});