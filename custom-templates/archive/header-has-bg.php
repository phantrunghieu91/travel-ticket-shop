<?php
/**
 * Default header template for archive pages
 */
defined('ABSPATH') or exit;
$obj = isset($args['obj']) ? $args['obj'] : null;
$obj_name = isset($args['obj_name']) ? $args['obj_name'] : null;
$obj_children = isset($args['obj_children']) ? $args['obj_children'] : [];
$obj_bg_url = RelativeCategory::getCategoryBGImage($obj->term_id);
$relate_cat_id = RelativeCategory::getRelativeCategory($obj->term_id);
$relate_cat = get_term($relate_cat_id);
?>
<section class="category-header has-background<?= !empty($obj_children) ? ' has-children' : '' ?>">
  <div class="category-header__background">
    <img src="<?= esc_url($obj_bg_url) ?>" alt="Category Background">
  </div>
  <div class="section__inner">
    <div class="category-header__content">
      <span class="category-header__title"><?= esc_html($obj_name) ?></span>
      <a href="<?= esc_url(get_term_link($relate_cat)) ?>" class="category-header__relate-category">
        <?= esc_html($relate_cat->name) ?>
      </a>
    </div>
  </div>
  <?php if (!empty($obj_children)): ?>
    <nav class="category-header__children">
      <?php foreach ($obj_children as $child): ?>
        <a href="<?= esc_url(get_term_link($child->term_id)) ?>"
          class="category-header__child"><?= esc_html($child->name) ?></a>
      <?php endforeach; ?>
    </nav>
  <?php endif; ?>
</section>