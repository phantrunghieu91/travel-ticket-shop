<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail - surroundings block
 */
$surroundings = get_field('surroundings') ?? [];
if (empty($surroundings['place'])) {
  return;
}
$google_map_link = $args['google_map_link'] ?? false;
?>
<div class="product-detail__surrounding">
  <header class="block__header">
    <h2 class="block__title">
      <?php echo esc_html($surroundings['title'] ?: __('Xem xung quanh đây', 'gpw')) ?>
    </h2>
    <?php if( $google_map_link ) : ?>
      <a href="<?= esc_url($google_map_link) ?>" target="_blank" class="block__header-view-all">
        <?php esc_html_e('Xem bản đồ', 'gpw') ?>
        <span class="material-symbols-outlined">chevron_right</span>
      </a>
    <?php endif ?>
  </header>
  <ul class="product-detail__surrounding-list">
    <?php foreach ($surroundings['place'] as $place): ?>
      <li class="product-detail__place">
        <span class="product-detail__place-name">
          <?= esc_html($place['name']) ?>
        </span>
        <?php if (!empty($place['distance'])): ?>
          <span class="product-detail__place-distance">(
            <?= esc_html($place['distance']) ?>)
          </span>
        <?php endif ?>
      </li>
    <?php endforeach ?>
  </ul>
</div>
<?php
// ! Cleanup variables
unset($surroundings);