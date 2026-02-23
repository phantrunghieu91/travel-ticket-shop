<?php
add_shortcode('home_videos', function () {
  if (!is_front_page())
    return;
  // get all post with post type video
  $video_posts = get_posts(
    array(
      'post_type' => 'video',
      'numberposts' => 10,
    )
  );
  if (empty($video_posts))
    return '<p>No videos found</p>';
  ob_start();
  ?>
  <div class="videos">
    <div class="videos__title section__title">Videos</div>
    <?php $count = 0;
    foreach ($video_posts as $video_post):
      // check if post have thumbnail
      $thumbnail = has_post_thumbnail($video_post->ID) ? get_the_post_thumbnail($video_post->ID, 'medium') : '<img src="https://via.placeholder.com/300x200" alt="placeholder image">';
      if ($count == 0)
        $video_url = get_field('select_video', $video_post->ID);
      // filter out category of post without video category if have more than 2 categories
      $categories = get_the_category($video_post->ID);
      if (count($categories) > 1) {
        $primary_category = array_filter($categories, function ($category) {
          return $category->slug !== 'video';
        });
        $primary_category = reset($primary_category);
      } else {
        $primary_category = $categories[0];
      }
      ?>
      <?php if ($count <= 1): ?>
        <div class="<?= $count == 0 ? 'videos__preview' : 'videos__list' ?>">
        <?php endif; ?>
        <div class="video">
          <?php if ($count !== 0): ?>
            <a class="video__thumbnail" href="<?= esc_url(get_permalink($video_post->ID)) ?>">
              <?= $thumbnail ?>
            </a>
            <div class="video__content">
              <a href="<?= esc_url(get_permalink($video_post->ID)) ?>" class="video__title">
                <?= esc_html($video_post->post_title) ?>
              </a>
              <a href="<?= esc_url(get_term_link($primary_category)) ?>"
                class="video__category <?= esc_attr($primary_category->slug) ?>">
                <?= esc_html($primary_category->name) ?>
              </a>
            </div>
          <?php else: ?>
            <video muted playsinline preload="metadata" poster="<?= esc_url(get_the_post_thumbnail_url($video_post, 'full')) ?>">
              <source src="<?= esc_url($video_url) ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>
            <span class="material-symbols-outlined">play_circle</span>
            <p class="video__autoplay-counter">Video sẽ chạy sau <span class="autoplay-counter__number">0</span> <a class="autoplay-counter__cancel" href="javascript:void(0);">Hủy</a></p>
          <?php endif; ?>
        </div>
        <?php if ($count == 0 || $count == count($video_posts) - 1): ?>
        </div>
      <?php endif;
        $count++; ?>
    <?php endforeach; ?>
  </div>
  <?php return ob_get_clean();
});