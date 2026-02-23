<?php
/**
 * Default header template for archive pages
 */
defined('ABSPATH') or exit;
$obj_name = isset($args['obj_name']) ? $args['obj_name'] : null;
$obj_children = isset($args['obj_children']) ? $args['obj_children'] : [];
?>
<section class="category-header">
  <div class="section__inner">
    <div class="category-header__content">
      <h1 class="category-header__title"><?= esc_html($obj_name) ?></h1>
    </div>
    <?php if (!empty($obj_children)): ?>
      <nav class="category-header__children">
        <?php foreach ($obj_children as $child): ?>
          <a href="<?= esc_url(get_term_link($child->term_id)) ?>"
            class="category-header__child"><?= esc_html($child->name) ?></a>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>
  </div>
</section>