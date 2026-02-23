<?php
final class InfiniteScroll {
  public static function registerAction() {
    $instance = new self();
    add_action('wp_ajax_load_more_posts', [$instance, 'loadMorePosts']);
    add_action('wp_ajax_nopriv_load_more_posts', [$instance, 'loadMorePosts']);
  }
  public static function enqueueScripts($class = '.post', $posts_per_page = null, $obj_id = null, $type = 'category', $date_format = 'F j, Y') {
    wp_enqueue_script('infinite-scroll', get_stylesheet_directory_uri() . '/js/infinite-scroll.js', ['jquery'], rand(1,9999), true);
    wp_localize_script('infinite-scroll', 'infiniteScroll', [
      'fetchUrl' => admin_url('admin-ajax.php'),
      'observerClass' => $class,
      'postsPerPage' => $posts_per_page ? $posts_per_page : get_option('posts_per_page'),
      'objId' => $obj_id,
      'type' => $type,
      'dateFormat' => $date_format,
      // add nonce for security
      'nonce' => wp_create_nonce('load_more_posts_nonce'),
    ]);
  }
  
  public function loadMorePosts() {
    // Verify nonce
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'load_more_posts_nonce')) {
      wp_send_json_error('Invalid nonce!');
      wp_die();
    }

    // get type of object
    $type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'category';

    $posts_per_page = isset($_GET['posts_per_page']) ? intval($_GET['posts_per_page']) : get_option('posts_per_page');
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $obj_id = isset($_GET['obj_id']) ? intval($_GET['obj_id']) : null;
    $date_format = isset($_GET['date_format']) ? sanitize_text_field($_GET['date_format']) : 'F j, Y';

    $args = [
      'publish_status' => 'publish',
      'posts_per_page' => $posts_per_page,
      'paged' => $paged,
      'orderby' => 'date',
      'order' => 'DESC'
    ];

    // create a unique transient key base on type, obj_id, and page
    $transient_key = 'infinite_scroll_' . $type . '_' . $obj_id . '_' . $paged;

    // get posts from transient
    $posts = get_transient($transient_key);

    // if no posts in transient, get posts from database then save to transient
    if(!$posts) {
      if ($type == 'category' && $obj_id) {
        $args['post_type'] = ['post'];
        $args['tax_query'] = [
          [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $obj_id
          ]
        ];
      } elseif ($type == 'author' && $obj_id) {
        $args['post_type'] = ['post'];
        $args['author'] = $obj_id;
      } elseif ($type == 'search') {
        $args['post_type'] = ['post'];
        $args['s'] = $_GET['s'];
      } elseif ($type == 'video') {
        $args['post_type'] = ['video'];
      } else {
        wp_send_json_error('Invalid type');
        wp_die();
      }
  
      $query = new WP_Query($args);
      if ($query->have_posts()) {
        $posts = $query->posts;
        // save posts to transient, set expiration to 3 hours
        set_transient($transient_key, $posts, 3 * HOUR_IN_SECONDS);
      } 
    }

    if(count($posts) > 0) {
      // get needed data
      $response_data = [];
      foreach($posts as $post) {
        $response_data[] = [
          'id' => $post->ID,
          'title' => $post->post_title,
          'excerpt' => $post->post_excerpt,
          'permalink' => get_permalink($post->ID),
          'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium'),
          'date' => get_the_date($date_format, $post->ID),
        ];
      }
        
      wp_send_json_success( $response_data );
    } else {
      wp_send_json_error('No more posts');
    }
    wp_die();
  }
}