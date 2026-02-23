<?php
/**
 * The template for default layout of single post
 */
defined('ABSPATH') or exit;
$current_post = isset($args['current_post']) ? $args['current_post'] : null;
$categories = isset($args['categories']) ? $args['categories'] : [];
// setup $post variable
setup_postdata($current_post);
?>
<div class="single-post__body">
  <p class="single-post__summary">
    <?= $current_post->post_excerpt ?>
  </p>
  <div class="single-post__content">
    <?php the_content() ?>
  </div>
</div>
<?php
// reset $post variable
wp_reset_postdata();