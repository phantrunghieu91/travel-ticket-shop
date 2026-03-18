<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail - description block
 */
global $product;
if (empty($product) || !$product instanceof WC_Product || $product->get_description() === '') {
  return;
}
?>
<section class="product-description">
  <div class="section__inner" id="product-description">
    <h2 class="block__title">
      <?php esc_html_e('Mô tả cơ sở lưu trú', 'gpw') ?>
    </h2>
    <div class="product-description__content" aria-hidden="true">
      <?= wp_kses_post($product->get_description()) ?>
    </div>
    <a href="javascript:void(0);" class="product-description__toggle" aria-controls="product-description" aria-expanded="false">
      <?= esc_html_e('Xem thêm', 'gpw') ?>
    </a>
  </div>
</section>