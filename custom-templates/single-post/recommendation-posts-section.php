<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single post - recommendation posts section
 */
$current_post = $args['current_post'] ?? null;
if( !$current_post ) {
  return;
}
$category = $args['category'] ?? null;
$recommendation_posts = get_posts(
  array(
    'post_type' => 'post',
    'posts_per_page' => 6,
    'post__not_in' => array($current_post->ID),
    'tax_query' => array(
      array(
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => $category ? $category->term_id : 0,
      )
    )
  )
);
?>
<section class="single-post__recommendation">
  <div class="section__inner">
    <h2 class="recommendation__title section__title"><?php _e('Bạn có thể quan tâm', 'gpw') ?></h2>
    <div class="recommendation__post-list">
      <?php foreach ($recommendation_posts as $post_obj):
        get_template_part('custom-templates/post-in-loop/layout', 'default', [
          'post_obj' => $post_obj,
          'class' => 'recommendation__post',
          'has_meta' => true,
          'show_date_time' => true,
          'show_category' => true,
        ]);
      endforeach; ?>
    </div>
  </div>
</section>