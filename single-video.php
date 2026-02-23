<?php
/**
 * The template for displaying all single of video post type
 */
get_header();
$current_obj = get_post();
$posts_per_page = 2;
$videos_query = new WP_Query(
  array(
    'post_type' => 'video',
    'posts_per_page' => $posts_per_page,
    'publish_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => 1,
    'post__not_in' => array($current_obj->ID)
  )
);
if ($videos_query->have_posts()) {
  $videos = $videos_query->posts;
  $videos_current_page = $videos_query->query_vars['paged'] ?? 1;
  $videos_max_page = $videos_query->max_num_pages;
}

InfiniteScroll::enqueueScripts('video-list__item', $posts_per_page, null, 'video', 'H:i d/m/Y');

get_template_part('custom-templates/video-post-type/header', '', ['current_obj' => $current_obj, 'class' => 'preview-video']);

get_template_part('custom-templates/video-post-type/video-list', '', ['videos' => $videos, 'videos_max_page' => $videos_max_page]);

get_footer();