<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Latest news section
 */
// Latest news
$hotels = get_posts([
  'post_type' => 'product',
  'numberposts' => 10,
  'orderby' => 'post_date',
  'order' => 'DESC',
  'post_status' => 'publish'
]);
// Most read posts
$most_views_query = new WP_Query(
  array(
    'posts_per_page' => 5,
    'post_type' => 'post',
    'post_status' => 'publish',
    'meta_key' => 'post_views_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
  )
);
// Widget posts
// get category with term id 2
$widget_category = get_category(2);
if ($widget_category) {
  $widget_posts = get_posts(
    array(
      'numberposts' => 4,
      'orderby' => 'post_date',
      'order' => 'DESC',
      'post_type' => 'post',
      'post_status' => 'publish',
      'category' => $widget_category->term_id
    )
  );
}
?>
<section class="latest-news-section">
  <div class="section__inner">
    <div class="latest-news">
      <div class="latest-news__content">
        <?php foreach ($hotels as $post) {
          setup_postdata($post);
          get_template_part('custom-templates/woocommerce/product-in-loop', 'horizontal');
        };
        wp_reset_postdata(); ?>
      </div>
      <aside class="latest-news__side-bar">
        <div class="side-bar__inner">
          <div class="side-bar__most-read">
            <h3 class="sidebar__title"><?php esc_html_e('Đọc nhiều', 'gpw') ?></h3>
            <div class="most-read__list">
              <?php
              if ($most_views_query->have_posts()):
                foreach ($most_views_query->posts as $most_view):
                  $category = get_the_category($most_view->ID)[0];
                  ?>
                  <div class="most-read__item"
                    data-view-count="<?= class_exists('PostViewCounter') ? PostViewCounter::getPostViewCount($most_view->ID) : 0 ?>">
                    <a href="<?= esc_url(get_permalink($most_view->ID)) ?>" class="most-read__image">
                      <?= get_the_post_thumbnail($most_view->ID, 'thumbnail', ['alt' => $most_view->post_name]) ?>
                    </a>
                    <a href="<?= esc_url(get_term_link($category)) ?>" class="most-read__category">
                      <?= $category->name ?>
                    </a>
                    <a href="<?= esc_url(get_permalink($most_view->ID)) ?>" class="most-read__title">
                      <?= $most_view->post_title ?>
                    </a>
                  </div>
                <?php endforeach;
              endif; ?>
            </div>
          </div>
          <?php
          if (!empty($widget_posts)):
            ?>
            <div class="side-bar__podcast">
              <h3 class="sidebar__title">
                <?= $widget_category->name ?>
              </h3>
              <div class="podcast__list">
                <?php $widget_count = 0;
                foreach ($widget_posts as $widget_post): ?>
                  <a href="<?= get_permalink($widget_post->ID) ?>"
                    class="podcast__item<?= $widget_count == 0 ? ' podcast__item--big' : '' ?>">
                    <?= get_the_post_thumbnail($widget_post->ID, $widget_count++ == 0 ? 'medium' : 'thumbnail') ?>
                    <p class="podcast__title">
                      <?= $widget_post->post_title ?>
                    </p>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </aside>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset($hotels, $most_views_query, $widget_category, $widget_posts, $widget_count);