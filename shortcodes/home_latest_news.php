<?php
add_shortcode('home_latest_news', function () {
  if (!is_front_page())
    return;
  $args = array(
    'numberposts' => 10,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish'
  );
  $latest_news = get_posts($args);
  if (empty($latest_news))
    return '<p>No posts found</p>';
  ob_start();
  ?>
  <div class="latest-news">
    <div class="latest-news__content">
      <?php foreach ($latest_news as $latest_new): ?>
        <article class="latest-news__post">
          <a class="latest-news__image" href="<?= get_permalink($latest_new->ID) ?>">
            <?= get_the_post_thumbnail($latest_new->ID, 'medium') ?>
          </a>
          <div class="latest-news__info">
            <a href="<?= get_permalink($latest_new->ID) ?>" class="latest-news__title"><?= $latest_new->post_title ?></a>
            <p class="latest-news__excerpt"><?= $latest_new->post_excerpt ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <aside class="latest-news__side-bar">
      <div class="side-bar__inner">
        <div class="side-bar__most-read">
          <h3 class="sidebar__title">Đọc nhiều</h3>
          <div class="most-read__list">
            <?php
            $most_views = new WP_Query(
              array(
                'posts_per_page' => 5,
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
              )
            );
            if ($most_views->have_posts()):
              foreach ($most_views->posts as $most_view):
                $category = get_the_category($most_view->ID)[0];
                ?>
                <div class="most-read__item"
                  data-view-count="<?= PostViewCounter::getPostViewCount($most_view->ID) ?>">
                  <a href="<?= esc_url(get_permalink($most_view->ID)) ?>" class="most-read__image">
                    <?= get_the_post_thumbnail($most_view->ID, 'thumbnail', ['alt' => $most_view->post_name]) ?>
                  </a>
                  <a href="<?= esc_url(get_term_link($category)) ?>" class="most-read__category"><?= $category->name ?></a>
                  <a href="<?= esc_url(get_permalink($most_view->ID)) ?>" class="most-read__title"><?= $most_view->post_title ?></a>
                </div>
              <?php endforeach;
            endif; ?>
          </div>
        </div>
        <?php
        // get category with slug doi-song
        $category = get_category_by_slug('doi-song');
        if ($category):
          $args = array(
            'numberposts' => 4,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish',
            'category' => $category->term_id
          );
          $widget_posts = get_posts($args);
          if (!empty($widget_posts)):
            ?>
              <div class="side-bar__podcast">
              <h3 class="sidebar__title"><?= $category->name ?></h3>
              <div class="podcast__list">
                <?php $widget_count = 0;
                foreach ($widget_posts as $widget_post): ?>
                  <a href="<?= get_permalink($widget_post->ID) ?>" class="podcast__item<?= $widget_count == 0 ? ' podcast__item--big' : '' ?>">
                    <?= get_the_post_thumbnail($widget_post->ID, $widget_count++ == 0 ? 'medium' : 'thumbnail') ?>
                    <p class="podcast__title"><?= $widget_post->post_title ?></p>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif;
        endif; ?>
      </div>
    </aside>
  </div>
  <?php
  return ob_get_clean();
});