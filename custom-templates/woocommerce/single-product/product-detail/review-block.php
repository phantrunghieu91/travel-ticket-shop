<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail - review block
 */
$reviews = get_field('review') ?? [];
if( empty($reviews['feedback']) ) {
  return;
}
$google_map_link = $args['google_map_link'] ?? false;
?>
<div class="product-detail__review">

  <?php if (!empty($reviews['point']) && !empty($reviews['title'])): ?>
    <header class="block__header product-detail__review-header">
      <?php if (!empty($reviews['point'])): ?>
        <p class="product-detail__review-point">
          <span>
            <?php echo esc_html($reviews['point']) ?>/
          </span>
          <span>10</span>
        </p>
      <?php endif ?>
      <?php if (!empty($reviews['title'])): ?>
        <span class="product-detail__review-title">
          <?= esc_html($reviews['title']) ?>
        </span>
      <?php endif ?>
      <?php if( $google_map_link ) : ?>
        <a href="<?= esc_url($google_map_link) ?>" target="_blank" class="block__header-view-all">
          <?php esc_html_e('Xem tất cả', 'gpw') ?>
          <span class="material-symbols-outlined">chevron_right</span>
        </a>
      <?php endif ?>
    </header>
  <?php endif ?>
  <div class="product-detail__feedback-carousel">
    <div class="swiper">
      <div class="swiper-wrapper">
        <?php foreach ($reviews['feedback'] as $feedback): ?>
          <div class="swiper-slide">
            <?= wp_kses_post($feedback['quote']) ?>
          </div>
        <?php endforeach ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</div>
<?php
// ! Cleanup variables
unset($reviews);