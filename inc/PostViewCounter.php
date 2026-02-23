<?php
/**
 * Class PostViewCounter
 * 
 * This class handles the tracking and retrieval of post view counts.
 */
final class PostViewCounter
{
  private static $key_name;
  
  /**
   * Initializes the PostViewCounter class by setting the key name and adding necessary actions.
   */
  public static function init()
  {
    self::$key_name = 'post_views_count';
    add_action('template_redirect', [__CLASS__, 'trackPostViewCount']);
    add_action('save_post', [__CLASS__, 'initializePostViewCount']);
  }
  
  /**
   * Initializes the post view count for a post.
   *
   * @param int $post_id The ID of the post.
   */
  public static function initializePostViewCount($post_id)
  {
    // Check if this is a revision or an auto-save
    if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
      return;
    }
    // Only initialize for posts
    if (get_post_type($post_id) !== 'post') {
      return;
    }
    // Check if the post view count meta already exists
    $count = get_post_meta($post_id, self::$key_name, true);
    if ($count === '') {
      add_post_meta($post_id, self::$key_name, 0);
    }
  }
  
  /**
   * Sets the post view counter for a post.
   *
   * @param int $post_id The ID of the post.
   */
  public static function setPostViewCounter($post_id)
  {
    $count = get_post_meta($post_id, self::$key_name, true);
    if ($count == '') {
      $count = 1;
      delete_post_meta($post_id, self::$key_name);
      add_post_meta($post_id, self::$key_name, $count);
    } else {
      $count++;
      update_post_meta($post_id, self::$key_name, $count);
    }
  }
  
  /**
   * Retrieves the post view count for a post.
   *
   * @param int $post_id The ID of the post.
   * @return int The post view count.
   */
  public static function getPostViewCount($post_id)
  {
    return get_post_meta($post_id, self::$key_name, true);
  }
  
  /**
   * Tracks the post view count for a post.
   *
   * @param int $post_id The ID of the post.
   */
  public static function trackPostViewCount($post_id)
  {
    if (!is_single()) {
      return;
    }
    if (get_post_type($post_id) !== 'post') {
      return;
    }
    if (empty($post_id)) {
      global $post;
      $post_id = $post->ID;
    }
    $cookie_name = 'post_view_' . $post_id;
    $cookie_path = parse_url(get_permalink($post_id), PHP_URL_PATH);
    if (!isset($_COOKIE[$cookie_name])) {
      self::setPostViewCounter($post_id);
      setcookie($cookie_name, 1, time() + 3600, $cookie_path);
    }
  }
}

add_action('after_setup_theme', ['PostViewCounter', 'init']);