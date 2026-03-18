<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Product - Product detail - Highlight block
 */
$saved_highlights = get_post_meta(get_the_ID(), '_gpw_highlight', true) ?: [];
$highlights = get_field('highlights', 'gpw_product_data') ?: [];
if (empty($saved_highlights)) {
  return;
}
?>
<div class="product-detail__highlight">
  <h2 class="block__title">
    <?php esc_html_e('Điểm nổi bật', 'gpw') ?>
  </h2>
  <ul class="product-detail__highlight-list">
    <?php foreach ($saved_highlights as $highlight_idx):
      $highlight = $highlights[$highlight_idx] ?? null;
      if (!$highlight)
        continue;
      $tooltip_id = "highlight-tooltip-{$highlight_idx}";
      ?>

      <li class="product-detail__highlight-item">
        <?= wp_get_attachment_image($highlight['icon'] ?: PLACEHOLDER_IMAGE_ID, 'thumbnail', false, ['class' => 'product-detail__highlight-icon']) ?>
        <p class="product-detail__highlight-label">
          <span>
            <?= esc_html($highlight['label']) ?>
          </span>
          <?php if (!empty($highlight['description'])): ?>
            <button type="button" class="product-detail__highlight-tooltip-control"
              popovertarget="<?= esc_attr($tooltip_id) ?>"><span class="material-symbols-outlined">info</span></button>
          <?php endif ?>
        </p>
        <?php if (!empty($highlight['description'])): ?>
          <div class="product-detail__tooltip-description" popover id="<?= esc_attr($tooltip_id) ?>">
            <?= wp_kses_post($highlight['description']) ?>
          </div>
        <?php endif ?>
      </li>

    <?php endforeach ?>
  </ul>
</div>
<?php 
// ! Cleanup variables
unset($saved_highlights, $highlights);