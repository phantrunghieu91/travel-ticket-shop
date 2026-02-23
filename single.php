<?php
/**
 * The template for displaying all single posts
 */
get_header();
$current_post = get_post();
// get primary category using rankmath plugin
$category_id = get_post_meta($current_post->ID, 'rank_math_primary_category', true);
if (!$category_id) {
  $categories = get_the_category($current_post->ID);
  $category = isset($categories[0]) ? $categories[0] : null;
} else {
  $category = get_term($category_id, 'category');
}

// recommendation posts with same as primary category
$recommendation_posts = get_posts(
  array(
    'post_type' => 'post',
    'posts_per_page' => 6,
    'post__not_in' => array($current_post->ID),
    'tax_query' => array(
      array(
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => $category->term_id
      )
    )
  )
);

?>
<article class="single-post" data-post="<?= esc_attr($current_post->ID) ?>">
  <?php
  get_template_part('custom-templates/single-post/header', 'default', [
    'current_post' => $current_post,
    'category' => $category,
  ]);
  ?>
  <section class="single-post__main">
    <div class="section__inner">
      <?php
      get_template_part('custom-templates/single-post/body', 'default', [
        'current_post' => $current_post,
        'category' => $category,
      ]);
      ?>
    </div>
  </section>
  <section class="single-post__recommendation">
    <div class="section__inner">
      <div class="recommendation__title section__title">Bạn có thể quan tâm</div>
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
</article>
<?php
get_footer();