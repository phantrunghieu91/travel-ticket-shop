<?php
/**
 * The template for displaying header of archive, single page of video post type
 */
defined('ABSPATH') || exit;
$class = isset($args['class']) ? $args['class'] : '';
$current_obj = isset($args['current_obj']) ? $args['current_obj'] : null;
$is_tax = isset($args['is_tax']) ? $args['is_tax'] : false;
// $taxonomy = isset($args['taxonomy']) ? $args['taxonomy'] : null;

$current_obj_url = get_field('select_video', $current_obj);
$current_obj_short_desc = get_field('short_description', $current_obj);
// get custom taxonomy of current video
$current_obj_category = get_the_terms($current_obj, 'video-type')[0];
// get parent taxonomy of current obj category or taxonomy
$current_obj_parent_category = get_term($current_obj_category->parent, 'video-type');
?>
<section class="<?= esc_attr($class) ?>">
  <div class="section__inner">
    <?php if (!$current_obj): ?>
      <p>There is no video yet</p>
    <?php else: ?>
      <?php if ($is_tax || is_singular('video')):
        // get archive-video permalink
        $archive_video_url = get_post_type_archive_link('video');
        ?>
        <div class="<?= esc_attr($class) ?>__breadcrumbs">
          <a href="<?= esc_url($archive_video_url) ?>" class="<?= esc_attr($class) ?>__breadcrumbs-item">Video</a>
          <span class="<?= esc_attr($class) ?>__breadcrumbs-separator">/</span>
          <?php if ( !is_wp_error( $current_obj_parent_category ) && $current_obj_parent_category): ?>
            <a href="<?= esc_url(get_term_link($current_obj_parent_category)) ?>"
              class="<?= esc_attr($class) ?>__breadcrumbs-item parent"><?= esc_html($current_obj_parent_category->name) ?></a>
            <span class="<?= esc_attr($class) ?>__breadcrumbs-separator">/</span>
          <?php endif;
          if ($is_tax): ?>
            <span class="<?= esc_attr($class) ?>__breadcrumbs-item"><?= esc_html($current_obj_category->name) ?></span>
          <?php else: ?>
            <a class="<?= esc_attr($class) ?>__breadcrumbs-item"
              href="<?= esc_url(get_term_link($current_obj_category)) ?>"><?= esc_html($current_obj_category->name) ?></a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <video class="<?= esc_attr($class) ?>__player" controls muted>
        <source src="<?= esc_url($current_obj_url) ?>" type="video/mp4">
        Trình duyệt của bạn không hỗ trợ xem video
      </video>
      <div class="<?= esc_attr($class) ?>__info">
        <a href="<?= esc_url(get_term_link($current_obj_category)) ?>"
          class="<?= esc_attr($class) ?>__category"><?= esc_html($current_obj_category->name) ?></a>
        <a href="<?= esc_url(get_permalink($current_obj)) ?>"
          class="<?= esc_attr($class) ?>__title"><?= esc_html($current_obj->post_title) ?></a>
        <p class="<?= esc_attr($class) ?>__date-time"><?= esc_html(get_the_date('l, d/m/Y - H:i', $current_obj)) ?></p>
        <p class="<?= esc_attr($class) ?>__description"><?= esc_html($current_obj_short_desc) ?></p>
      </div>
    <?php endif; ?>
  </div>
</section>