<?php
/**
 * The template for posts in loop
 * Default layout: Have thumbnail, title and excerpt. Only had 1 <a> tag
 */
defined('ABSPATH') or exit;
$post_obj = isset($args['post_obj']) ? $args['post_obj'] : null;
$class = isset($args['class']) ? $args['class'] : 'post-in-loop';
$is_first = isset($args['is_first']) ? $args['is_first'] : false;
if (is_object($post_obj)): ?>

  <a class="<?= esc_attr($class) ?>" data-post="<?= esc_attr($post_obj->ID) ?>" href="<?= esc_url(get_permalink($post_obj)) ?>">
    <div class="<?= esc_attr($class) ?>__thumbnail">
      <?= get_the_post_thumbnail($post_obj->ID, $is_first ? 'large' : 'medium') ?>
    </div>
    <div class="<?= esc_attr($class) ?>__content">
      <div class="<?= esc_attr($class) ?>__title"><?= esc_html($post_obj->post_title) ?></div>
      <?php if ($is_first): ?>
        <div class="<?= esc_attr($class) ?>__excerpt"><?= esc_html($post_obj->post_excerpt) ?></div>
      <?php endif; ?>
    </div>
  </a>

<?php endif; ?>