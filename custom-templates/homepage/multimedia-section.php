<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Multimedia section
 */
// get multimedia post
// get all categories that is children of category with slug multimedia
$multimedia = get_category_by_slug('multimedia');
if (!$multimedia)
  return;
$categories = get_categories(
  array(
    'child_of' => $multimedia->term_id,
    'hide_empty' => false,
  )
);
// Get all posts from multimedia category and its children
$multimedia_posts = get_posts(
  array(
    'numberposts' => 5,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'publish',
    'category' => $multimedia->term_id
  )
);
if( empty( $multimedia_posts ) )
  return;
?>
<section class="multimedia-section">
  <div class="section__inner">
    <div class="multimedia">
      <header class="multimedia__header">
        <a class="multimedia__title section__title"
          href="<?= esc_url(get_term_link($multimedia)) ?>"><?= esc_html($multimedia->name) ?></a>
        <div class="multimedia__children">
          <?php foreach ($categories as $category): ?>
            <a href="<?= get_category_link($category->term_id) ?>" class="multimedia__child"><?= $category->name ?></a>
          <?php endforeach; ?>
        </div>
      </header>
      <div class="multimedia__posts">
        <?php $multimedia_count = 0;
        foreach ($multimedia_posts as $multimedia_post):
          $params = ['class' => 'multimedia__post', 'post_obj' => $multimedia_post];
          if ($multimedia_count === 0) {
            $params['show_excerpt'] = true;
            $params['addition_classes'] = 'multimedia__post--big';
          }
          get_template_part('custom-templates/post-in-loop/layout', 'default', $params);
          $multimedia_count++;
          ?>
        <?php endforeach; ?>
      </div>
    </div>
</section>
<style>
.multimedia-section {
  background-color: var(--secondary-medium);
  padding-block: 3em;
}

.multimedia__header {
  display: flex;
  align-items: center;
  gap: 2em;
  margin-bottom: 2em;
}

.multimedia__title.section__title {
  width: fit-content;
  margin-bottom: 0;
}

.multimedia__children {
  display: flex;
  gap: 1em;
}

.multimedia__child {
  font-weight: 700;
  text-transform: uppercase;
}

.multimedia__posts {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 1fr);
  gap: 1em;
}

.multimedia__post--big {
  grid-column: span 2;
  grid-row: span 2;

  & .multimedia__post-title {
    font-size: 1.2em;
  }
}

.multimedia__post-image {
  display: block;
  margin-bottom: .625em;
}

.multimedia__post-image img {
  width: 100%;
  height: auto;
  aspect-ratio: 4/3;
  object-fit: cover;
}

.multimedia__post-title {
  font-weight: 700;
}

@container content (width < 850px) {
  .multimedia__posts {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(3, auto);
  }

  .multimedia__post--big {
    grid-row: 1 / span 1;
  }
}
</style>
<?php 
// ! Cleanup variables
unset( $multimedia, $categories, $multimedia_posts, $multimedia_count, $params );