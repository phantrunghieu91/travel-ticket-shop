<?php
get_header();
$current_obj = get_queried_object();
$is_taxonomy = is_a($current_obj, 'WP_Term');
$posts_per_page = 2;
// get 5 videos from current 'video' post type
$args = [
  'post_type' => 'video',
  'posts_per_page' => $posts_per_page,
  'publish_status' => 'publish',
  'orderby' => 'date',
  'order' => 'DESC',
  'paged' => 1
];
if ($is_taxonomy) {
  $args['tax_query'] = [
    [
      'taxonomy' => 'video-type',
      'field' => 'slug',
      'terms' => $current_obj->slug
    ]
  ];
}
$videos_query = new WP_Query($args);
if ($videos_query->have_posts()) {
  $videos = $videos_query->posts;
  $videos_current_page = $videos_query->query_vars['paged'] ?? 1;
  $videos_max_page = $videos_query->max_num_pages;
  $latest_video = array_shift($videos);
}
// Import infinite-scroll script
InfiniteScroll::enqueueScripts('video-list__item', $posts_per_page, null, 'video', 'H:i d/m/Y');
?>
<!-- Latest Video Section -->
<?php
$latest_video_params = ['current_obj' => $latest_video, 'class' => 'preview-video', 'is_tax' => $is_taxonomy];
get_template_part('custom-templates/video-post-type/header', '', $latest_video_params);
?>
<!-- List video section -->
<?php get_template_part('custom-templates/video-post-type/video-list', '', ['videos' => $videos, 'videos_max_page' => $videos_max_page]) ?>

<?php
get_footer();