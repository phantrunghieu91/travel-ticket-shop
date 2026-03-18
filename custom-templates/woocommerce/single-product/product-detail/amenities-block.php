<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail - amenities block
 */
$saved_amenities = get_post_meta(get_the_ID(), '_gpw_amenities', true) ?: [];
$amenities = get_field('amenities', 'gpw_product_data') ?: [];
if (empty($saved_amenities)) {
  return;
}
?>
<div class="product-detail__amenities">
  <header class="block__header">
    <h2 class="block__title">
      <?php esc_html_e('Tiện nghi', 'gpw') ?>
    </h2>
    <a href="javascript:void(0);" class="block__header-view-all">
      <?php esc_html_e('Xem tất cả', 'gpw') ?>
      <span class="material-symbols-outlined">chevron_right</span>
    </a>
  </header>
  <ul class="product-detail__amenities-list">
    <?php foreach ($saved_amenities as $amenity_idx):
      $amenity = $amenities[$amenity_idx] ?? null;
      if (!$amenity)
        continue;
      ?>
      <li class="product-detail__amenity-item">
        <?php if (!empty($amenity['icon']))
          echo wp_get_attachment_image($amenity['icon'] ?: PLACEHOLDER_IMAGE_ID, 'thumbnail', false, ['class' => 'product-detail__amenity-icon']) ?>
          <span class="product-detail__amenity-label">
          <?= esc_html($amenity['label']) ?>
        </span>
      </li>
    <?php endforeach ?>
  </ul>
</div>
<?php 
// ! Cleanup variables
unset($saved_amenities, $amenities);