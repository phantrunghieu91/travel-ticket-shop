<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail - amenities block
 */
$saved_amenities = get_post_meta(get_the_ID(), '_gpw_amenities', true) ?: [];
$amenities = get_field('amenities_group', 'gpw_product_data') ?: [];
if (empty($saved_amenities)) {
  return;
}
?>
<div class="product-detail__amenities">
  <header class="block__header">
    <h2 class="block__title">
      <?php esc_html_e('Tiện nghi', 'gpw') ?>
    </h2>
    <a href="javascript:void(0);" class="block__header-view-all" aria-controls="amenities-details">
      <?php esc_html_e('Xem tất cả', 'gpw') ?>
      <span class="material-symbols-outlined">chevron_right</span>
    </a>
  </header>
  <ul class="product-detail__amenities-list">
    <?php foreach ($saved_amenities as $amenity_idx):
      $ids = explode('_', $amenity_idx);
      $amenity = $amenities[$ids[0]]['amenities'][$ids[1]] ?? null;
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
  <dialog class="amenities-details" id="amenities-details">
    <header class="amenities-details__header">
      <h2 class="amenities-details__title"><?php esc_html_e('Tiện nghi khách sạn', 'gpw') ?></h2>
      <button class="amenities-details__close" aria-label="<?php esc_attr_e('Đóng', 'gpw') ?>">
        <span class="material-symbols-outlined">close</span>
      </button>
    </header>
    <main class="amenities-details__main">
      <?php foreach( $amenities as $group ): ?>
        <div class="amenities-details__group">
          <h3 class="amenities-details__group-name"><?= esc_html( $group['name'] ) ?></h3>
          <ul class="amenities-details__group-list">
          <?php foreach( $group['amenities'] as $amenity ): ?>
            <li class="amenities-details__group-item">
              <?php if ( !empty( $amenity['icon'] ) ) {
                echo wp_get_attachment_image( $amenity['icon'] ?: PLACEHOLDER_IMAGE_ID, 'thumbnail', false, [ 'class' => 'amenities-details__group-item-icon' ] );
              } ?>
              <span class="amenities-details__group-item-label"><?= esc_html( $amenity['label'] ) ?></span>
            </li>
          <?php endforeach ?>
          </ul>
        </div>    
      <?php endforeach ?>
      </ul>
    </main>
  </dialog>
</div>
<?php 
// ! Cleanup variables
unset($saved_amenities, $amenities);