<?php
/**
 * The template for posts in loop
 * Default layout: Only have thumbnail and title, no excerpt. Thumbnail and title is separate link
 */
defined('ABSPATH') or exit;

$post_obj = isset($args['post_obj']) ? $args['post_obj'] : null;
$class = isset($args['class']) ? $args['class'] : 'post-in-loop';
$has_meta = isset($args['has_meta']) ? $args['has_meta'] : false;
$show_date = isset($args['show_date']) ? $args['show_date'] : false;
$show_date_time = isset($args['show_date_time']) ? $args['show_date_time'] : false;
$show_author = isset($args['show_author']) ? $args['show_author'] : false;
$show_excerpt = isset($args['show_excerpt']) ? $args['show_excerpt'] : false;
$show_category = isset($args['show_category']) ? $args['show_category'] : false;
$addition_classes = isset($args['addition_classes']) ? $args['addition_classes'] : null;

if (is_object($post_obj)): ?>

  <article class="<?= esc_attr($class) ?><?= $addition_classes ? ' ' . esc_attr($addition_classes) : '' ?>" data-post="<?= esc_attr($post_obj->ID) ?>">
    <a class="<?= esc_attr($class) ?>-image" href="<?= esc_url(get_permalink($post_obj->ID)) ?>">
      <?= get_the_post_thumbnail($post_obj->ID, 'medium') ?>
    </a>

    <?php if ($has_meta || $show_excerpt): ?>
      <div class="<?= esc_attr($class) ?>-header"> <?php endif; ?>

      <a href="<?= esc_url(get_permalink($post_obj->ID)) ?>"
        class="<?= esc_attr($class) ?>-title"><?= esc_html($post_obj->post_title) ?></a>

      <?php if ($has_meta): ?>
        <div class="<?= esc_attr($class) ?>-meta">
          <?php if ($show_date): ?>
            <span class="<?= esc_attr($class) ?>-date"><?= esc_html(get_the_date('F j, Y', $post_obj->ID)) ?></span>
          <?php endif; ?>
          <?php if ($show_date_time): ?>
            <span class="<?= esc_attr($class) ?>-date-time"><?= esc_html(get_the_date('H:i d/m/Y', $post_obj->ID)) ?></span>
          <?php endif; ?>
          <?php if ($show_author): ?>
            <a class="<?= esc_attr($class) ?>-author"
              href="<?= esc_url(get_author_posts_url($post_obj->post_author)) ?>"><?= esc_html(get_the_author_meta('display_name', $post_obj->post_author)) ?></a>
          <?php endif; ?>
          <?php if ($show_category): 
            // get the primary category using rankmath plugin if have, otherwise get the first category
            $category_id = get_post_meta($post_obj->ID, 'rank_math_primary_category', true);
            if (!$category_id) {
              $categories = get_the_category($post_obj->ID);
              $category = isset($categories[0]) ? $categories[0] : null;
            } else {
              $category = get_term($category_id);
            }
            ?>
            <div class="<?= esc_attr($class) ?>-categories">
              <a href="<?= esc_url(get_term_link($category->term_id)) ?>"
                class="<?= esc_attr($class) ?>-category"><?= esc_html($category->name) ?></a>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php if ($has_meta || $show_excerpt): ?>
      </div> <?php endif; ?>

    <?php if ($show_excerpt): ?>
      <p class="<?= esc_attr($class) ?>-excerpt"><?= esc_html($post_obj->post_excerpt) ?></p>
    <?php endif; ?>
  </article>

<?php endif; ?>