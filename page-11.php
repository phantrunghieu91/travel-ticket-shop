<?php
/**
 * Template Name: Trang chủ
 * The template for displaying the home page. 
 */
get_header();


// get category for carousel
$carousel_cat_id = get_field('carousel_category', get_the_ID());
if (!$carousel_cat_id)
  return;
// get 10 posts from the category
$category_posts = get_posts(
  array(
    'numberposts' => 10,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'category' => $carousel_cat_id
  )
);
// Get entertainment categories
$entertainment_category_ids = get_field('entertainment_categories', get_the_ID());
if (!empty($entertainment_category_ids)) {
  $entertainment_categories = get_categories(
    array(
      'include' => $entertainment_category_ids,
    )
  );
}
// Get magazine posts
// get 10 posts as template first
$magazine_posts = get_posts(
  array(
    'post_type' => 'post',
    'publish_status' => 'publish',
    'numberposts' => 10,
  )
);
?>
<div id="content" class="home-page">

  <?php // get_template_part('custom-templates/homepage/featured-post', 'default'); ?>

  <?php get_template_part('custom-templates/homepage/hero-section') ?>

  <section class="category-carousel-section">
    <div class="section__inner">
      <div class="category-carousel">
        <a class="category-carousel__title section__title"
          href="<?= esc_url(get_term_link($carousel_cat_id)) ?>"><?= get_cat_name($carousel_cat_id) ?></a>
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
        <a href="javascript:void(0);" class="carousel-btn carousel-btn__prev" aria-label="Carousel previous slide"
          role="button">
          <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <a href="javascript:void(0);" class="carousel-btn carousel-btn__next" aria-label="Carousel next slide"
          role="button">
          <span class="material-symbols-outlined">chevron_right</span>
        </a>
      </div>
    </div>
  </section>

  <?php get_template_part('custom-templates/homepage/hotel-carousel-section') ?>

  <?php get_template_part('custom-templates/homepage/latest-news-section') ?>

  <?php get_template_part('custom-templates/homepage/featured-post', 'layout-2'); ?>

  <section class="entertainment-section">
    <div class="section__inner">
      <div class="entertainment-categories">
        <?php
        // get 3 posts per category
        foreach ($entertainment_categories as $entertainment_category):
          $cate_posts = get_posts(
            array(
              'post_type' => 'post',
              'publish_status' => 'publish',
              'category' => $entertainment_category->term_id,
              'numberposts' => 3,
            )
          );
          if (empty($cate_posts))
            continue;
          ?>
          <div class="entertainment-cat <?= esc_attr($entertainment_category->slug) ?>">
            <a class="entertainment-cat__title section__title"
              href="<?= esc_url(get_term_link($entertainment_category)) ?>"><?= esc_html($entertainment_category->name) ?></a>
            <div class="entertainment__cat-posts">
              <?php foreach ($cate_posts as $cat_post):
                get_template_part('custom-templates/post-in-loop/layout', 'default', ['post_obj' => $cat_post, 'class' => 'entertainment__post']);
              endforeach; ?>
            </div>
          </div> <!-- Close entertaiment_cat -->
        <?php endforeach; ?>
      </div> <!-- Close entertaiment_categories -->
    </div>
  </section>
  <section class="magazine-section">
    <div class="section__inner">
      <?php if (empty($magazine_posts)): ?>
        <p>No posts found</p>
      <?php endif; ?>
      <div class="magazines">
        <div class="magazines__title section__title">Magazine</div>
        <div class="magazines__posts swiper">
          <div class="swiper-wrapper">
            <?php foreach ($magazine_posts as $magazine_post):
              // get primary category of post using rankmath
              $magazine_category_id = get_post_meta($magazine_post->ID, 'rank_math_primary_category', true);
              $magazine_category = $magazine_category_id ? get_term($magazine_category_id) : get_the_category($magazine_post->ID)[0];
              ?>
              <article class="magazine__post swiper-slide">
                <div class="magazine__image">
                  <?= get_the_post_thumbnail($magazine_post->ID, 'medium') ?>
                </div>
                <a class="magazine__content" href="<?= esc_url(get_permalink($magazine_post->ID)) ?>">
                  <span class="magazine__category"><?= esc_html($magazine_category->name) ?></span>
                  <p class="magazine__title"><?= esc_html($magazine_post->post_title) ?></p>
                  <span class="material-symbols-outlined">news</span>
                </a>
              </article>
            <?php endforeach; ?>
          </div>
        </div>
        <a href="javascript:void(0);" class="carousel-btn carousel-btn__prev" aria-label="Carousel previous slide" role="button">
          <span class="material-symbols-outlined">chevron_left</span>
        </a>
        <a href="javascript:void(0);" class="carousel-btn carousel-btn__next" aria-label="Carousel next slide" role="button">
          <span class="material-symbols-outlined">chevron_right</span>
        </a>
      </div>
    </div>
  </section>
</div>
<?php
get_footer();