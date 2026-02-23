<?php
/**
 * Display video list for archive, single page of video post type
 */
defined('ABSPATH') || exit;
$videos = isset($args['videos']) ? $args['videos'] : [];
$videos_max_page = isset($args['videos_max_page']) ? $args['videos_max_page'] : 1;
?>
<section class="video-list">
  <div class="section__inner">
    <div class="video-list__title">
      <h2 class="section__title">Video mới</h2>
    </div>
    <div class="video-list__list" data-max-page="<?= esc_attr($videos_max_page) ?>">
      <?php foreach($videos as $video) : 
        $video_short_desc = get_field('short_description', $video);
      ?>
        <article class="video-list__item" data-post="<?= esc_attr($video->ID) ?>">
          <a href="<?= esc_url(get_permalink($video)) ?>" class="video-list__item-image">
            <?= has_post_thumbnail($video->ID) ? get_the_post_thumbnail($video, 'medium') : '<img src="https://via.placeholder.com/300x200" alt="placeholder image">'?>
          </a>
          <header class="video-list__item-header">
            <a href="<?= esc_url(get_permalink($video)) ?>" class="video-list__item-title"><?=  esc_html($video->post_title) ?></a>
            <div class="video-list__item-meta">
              <p class="video-list__item-date"><?= esc_html(get_the_date('H:i d/m/Y', $video)) ?></p>
            </div>
            <p class="video-list__item-description"><?= esc_html($video_short_desc) ?></p>
          </header>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>