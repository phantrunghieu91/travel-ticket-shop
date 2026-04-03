<?php
/**
 * The template for displaying category archive pages
 * 
 */

get_header();
$current_obj = get_queried_object();
$post_per_page = 5;
if (is_a($current_obj, 'WP_Term')) {
  $obj_id = $current_obj->term_id;
  $obj_name = $current_obj->name;
  $obj_description = $current_obj->description;
  $obj_thumbnail_url = RelativeCategory::getCategoryBgImage($obj_id);
  $obj_latest_posts_query = new WP_Query(
    array(
      'post_type' => 'post',
      'posts_per_page' => $post_per_page,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
      'paged' => 1,
      'tax_query' => array(
        array(
          'taxonomy' => 'category',
          'field' => 'term_id',
          'terms' => $obj_id
        )
      )
    )
  );
  if ($obj_latest_posts_query->have_posts()) {
    $obj_latest_posts = $obj_latest_posts_query->posts;
    $latest_posts_current_page = $obj_latest_posts_query->query_vars['paged'] ?? 1;
    $latest_posts_max_page = $obj_latest_posts_query->max_num_pages;
  }
  // get child terms if has any
  $obj_children = get_terms(
    array(
      'taxonomy' => 'category',
      'parent' => $obj_id,
      'hide_empty' => false
    )
  );
  // get parent term if has any
  $obj_parent = get_term($current_obj->parent, 'category');
  // Get Featured post of current term with meta key 'featured_post'
  $featured_posts = get_posts(
    array(
      'post_type' => 'post',
      'posts_per_page' => 7,
      'meta_key' => 'featured_post',
      'meta_value' => '1',
      'tax_query' => array(
        array(
          'taxonomy' => 'category',
          'field' => 'term_id',
          'terms' => $obj_id
        )
      )
    )
  );
  // Register custom js
  InfiniteScroll::enqueueScripts('latest__post', $post_per_page, $obj_id);

} elseif (is_a($current_obj, 'WP_User')) {
  $obj_id = $current_obj->ID;
  $obj_name = $current_obj->display_name;
  $obj_description = $current_obj->description;
  $obj_thumbnail_url = wp_get_attachment_url(get_user_meta($obj_id, 'thumbnail_id', true));
  $obj_latest_posts_query = new WP_Query(
    array(
      'post_type' => 'post',
      'posts_per_page' => $post_per_page,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
      'paged' => 1,
      'author' => $obj_id
    )
  );
  if ($obj_latest_posts_query->have_posts()) {
    $obj_latest_posts = $obj_latest_posts_query->posts;
    $latest_posts_current_page = $obj_latest_posts_query->query_vars['paged'] ?? 1;
    $latest_posts_max_page = $obj_latest_posts_query->max_num_pages;
  }
  $featured_posts = get_posts(
    array(
      'post_type' => 'post',
      'posts_per_page' => 7,
      'meta_key' => 'featured_post',
      'meta_value' => '1',
      'author' => $obj_id
    )
  );

  // Register custom js
  InfiniteScroll::enqueueScripts('latest__post', $post_per_page, $obj_id, 'author');
}

// Get spotlight category with slug 'tieu-diem'
$spotlight_cat = get_term(2, 'category');

$type = '';
switch (get_class($current_obj)) {
  case 'WP_Term':
    $type = 'category';
    break;
  case 'WP_User':
    $type = 'author';
    break;
}
?>
<div class="archive <?= esc_attr($type) ?>" data-type="<?= esc_attr($type) ?>">
  <?php
  if ($type == 'category' && !empty($obj_thumbnail_url)) {
    get_template_part('custom-templates/archive/header', 'has-bg', ['obj' => $current_obj, 'obj_name' => $obj_name, 'obj_children' => $obj_children]);
  } else {
    get_template_part('custom-templates/archive/header', 'default', ['obj_name' => $obj_name]);
  }
  if (!empty($featured_posts)): ?>
    <section class="category-featured-post">
      <div class="section__inner">
        <div class="featured-posts__list">
          <?php $featured_count = 0;
          foreach ($featured_posts as $post_obj) {
            get_template_part('custom-templates/post-in-loop/layout', 'one-link', ['post_obj' => $post_obj, 'class' => 'featured-post', 'is_first' => $featured_count++ === 0]);
          } ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <section class="category-latest">
    <div class="section__inner">
      <div class="section__title has-underline">Tin mới</div>
      <div class="latest__content">
        <?php if (!empty($obj_latest_posts)): ?>
          <div class="latest__posts" data-current-page="<?= esc_attr($latest_posts_current_page) ?>"
            data-max-page="<?= esc_attr($latest_posts_max_page) ?>">
            <?php foreach ($obj_latest_posts as $latest_post):
              get_template_part('custom-templates/post-in-loop/layout', 'default', ['post_obj' => $latest_post, 'class' => 'latest__post', 'has_meta' => true, 'show_date' => true, 'show_excerpt' => true]);
            endforeach; ?>
          </div>
        <?php else: ?>
          <div class="latest__posts">
            <p>Không có bài viết nào</p>
          </div>
        <?php endif; ?>
      </div>
      <aside class="latest__sidebar">
        <?php
        if (!empty($spotlight_cat) && !is_wp_error($spotlight_cat)) :
            // Get 3 posts of each spotlight category
            $spotlight_posts = get_posts(
              array(
                'category' => $spotlight_cat->term_id,
                'numberposts' => 3,
                'orderby' => 'date',
                'order' => 'DESC'
              )
            );
            ?>
            <section class="sidebar__spotlight cat-<?= esc_attr($spotlight_cat->slug) ?>">
              <header class="spotlight__header">
                <div class="spotlight__title"><?= esc_html($spotlight_cat->name) ?></div>
              </header>
              <main class="spotlight__posts">
                <?php $spotlight_post_count = 0;
                foreach ($spotlight_posts as $post_obj): ?>
                  <article class="spotlight__post" data-post="<?= esc_attr($post_obj->ID) ?>">
                    <a href="<?= esc_url(get_permalink($post_obj->ID)) ?>" class="spotlight__post-title">
                      <?= esc_html($post_obj->post_title) ?>
                    </a>
                    <?php if ($spotlight_post_count++ === 0): ?>
                      <a class="spotlight__post-image" href="<?= esc_url(get_permalink($post_obj->ID)) ?>">
                        <?= get_the_post_thumbnail($post_obj->ID, 'medium') ?>
                      </a>
                    <?php endif; ?>
                  </article>
                <?php endforeach; ?>
              </main>
            </section>
          <?php endif; ?>
      </aside>
    </div>
  </section>
</div>
<?php
get_footer();