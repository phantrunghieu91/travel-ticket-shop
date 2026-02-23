<?php
/**
 * The FeaturedPost class is responsible for adding a custom field to posts that marks them as featured posts.
 */
final class FeaturedPost
{
  private $scriptRendered = false;
  /**
   * Initializes the FeaturedPost class by adding necessary hooks and filters.
   */
  public function init()
  {
    // add meta box to post editor screen
    add_action('add_meta_boxes', [$this, 'addFeaturedPostMetaBox']);
    // save the featured post meta when a post is saved
    add_action('save_post', [$this, 'saveFeaturedPostMeta']);
    // add the featured post column to the posts list table
    add_filter('manage_posts_columns', [$this, 'addFeaturedPostColumn']);
    // display the content of the featured post column
    add_action('manage_posts_custom_column', [$this, 'displayFeaturedPostColumn'], 10, 2);
    // toggle the featured post status of a post
    add_action('wp_ajax_toggle_featured_post', [$this, 'toggleFeaturedPost']);
  }

  /**
   * Adds the featured post meta box to the post editor screen.
   */
  public function addFeaturedPostMetaBox()
  {
    add_meta_box('featured_post', 'Featured Post', function ($post) {
      $featured = get_post_meta($post->ID, 'featured_post', true);
      ?>
      <label for="featured_post">Make this post featured post</label>
      <input type="checkbox" name="featured_post" id="featured_post" <?= $featured ? 'checked' : '' ?>>
    <?php
    }, 'post', 'side', 'default');
  }

  /**
   * Saves the featured post meta when a post is saved.
   *
   * @param int $post_id The ID of the post being saved.
   */
  public function saveFeaturedPostMeta($post_id)
  {
    if (array_key_exists('featured_post', $_POST)) {
      update_post_meta($post_id, 'featured_post', '1');
    } else {
      delete_post_meta($post_id, 'featured_post');
    }
  }

  /**
   * Adds the featured post column to the posts list table.
   *
   * @param array $columns The existing columns in the posts list table.
   * @return array The modified columns array with the featured post column added.
   */
  public function addFeaturedPostColumn($columns)
  {
    $columns = array_slice($columns, 0, 2, true) + ['featured_post' => 'Featured'] + array_slice($columns, 2, count($columns) - 2, true);
    $columns['featured_post'] = 'Featured';
    return $columns;
  }

  /**
   * Displays the content of the featured post column in the posts list table.
   *
   * @param string $column The name of the current column being displayed.
   * @param int $post_id The ID of the current post being displayed.
   */
  public function displayFeaturedPostColumn($column, $post_id)
  {
    if ($column === 'featured_post') :
      $featured = get_post_meta($post_id, 'featured_post', true);
      ?>
      <input type="checkbox" name="featured-post" <?= $featured ? 'checked' : '' ?>>
      <?php if (!$this->scriptRendered) : ?>
        <script>
          jQuery(document).ready(function ($) {
            $(`input[name="featured-post"]`).change(function () {
              const post_id = $(this).closest('tr').attr('id').replace('post-', '');
              console.log('toggle featured post ' + post_id)
              $.post(ajaxurl, {
                action: 'toggle_featured_post',
                post_id
              });
            });
          });
        </script>
  <?php
        $this->scriptRendered = true;
        endif;
        endif;
    }
  /**
   * Toggles the featured post status of a post.
   */
  public function toggleFeaturedPost()
  {
    $post_id = $_POST['post_id'];
    $featured = get_post_meta($post_id, 'featured_post', true);
    if ($featured) {
      delete_post_meta($post_id, 'featured_post');
    } else {
      update_post_meta($post_id, 'featured_post', '1');
    }
    wp_die();
  }
}

// initialize the class when the theme is loaded
$featured_post = new FeaturedPost();
$featured_post->init();