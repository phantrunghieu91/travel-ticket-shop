<?php
add_shortcode('home_multimedia', function () {
  if (!is_front_page())
    return;
  // get all categories that is children of category with slug multimedia
  $multimedia = get_category_by_slug('multimedia');
  if (!$multimedia)
    return;
  $args = array(
    'child_of' => $multimedia->term_id,
    'hide_empty' => false,
  );
  $categories = get_categories($args);
  // Get all posts from multimedia category and its children
  $args = array(
    'numberposts' => 5,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'category' => $multimedia->term_id
  );
  $multimedia_posts = get_posts($args);
  if (empty($multimedia_posts))
    return;
  $count = 0;
  ob_start();
  ?>
  <div class="multimedia">
    <header class="multimedia__header">
      <a class="multimedia__title section__title" href="<?= esc_url(get_term_link($multimedia)) ?>"><?= esc_html($multimedia->name) ?></a>
      <div class="multimedia__children">
        <?php foreach ($categories as $category): ?>
          <a href="<?= get_category_link($category->term_id) ?>" class="multimedia__child"><?= $category->name ?></a>
        <?php endforeach; ?>
      </div>
    </header>
    <div class="multimedia__posts">
      <?php foreach ($multimedia_posts as $multimedia_post): ?>
        <article class="multimedia__post <?= $count == 0 ? 'multimedia__post--big' : ''?>">
          <a class="multimedia__post-image" href="<?= get_permalink($multimedia_post->ID) ?>">
            <?= get_the_post_thumbnail($multimedia_post->ID, $count == 0 ? 'large' : 'medium') ?>
          </a>
          <div class="multimedia__post-content">
            <a href="<?= get_permalink($multimedia_post->ID) ?>"
              class="multimedia__post-title"><?= $multimedia_post->post_title ?></a>
            <?php if ($count == 0) : ?>
              <p class="multimedia__post-excerpt"><?= $multimedia_post->post_excerpt ?></p>
            <?php endif; $count++; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
});