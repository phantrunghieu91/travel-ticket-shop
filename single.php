<?php
/**
 * The template for displaying all single posts
 */
$current_post = get_post();
// get primary category using rankmath plugin
$category_id = get_post_meta($current_post->ID, 'rank_math_primary_category', true);
if (!$category_id) {
  $categories = get_the_category($current_post->ID);
  $category = isset($categories[0]) ? $categories[0] : null;
} else {
  $category = get_term($category_id, 'category');
}

get_header();
?>
<?php get_template_part( 'custom-templates/breadcrumbs-section' ) ?>
<article class="single-post" data-post="<?= esc_attr($current_post->ID) ?>">
  <?php get_template_part('custom-templates/single-post/header', 'default', [
    'current_post' => $current_post,
    'category' => $category,
  ]); ?>
  <section class="single-post__main">
    <div class="section__inner">
      <?= do_shortcode('[ez-toc]') ?>
      <?php get_template_part('custom-templates/single-post/body', 'default', [
        'current_post' => $current_post,
        'category' => $category,
      ]); ?>
    </div>
  </section>
  <?php get_template_part( 'custom-templates/single-post/recommendation-posts-section', null, [ 'current_post' => $current_post, 'category' => $category ] ); ?>
  
</article>
<?php
get_footer();