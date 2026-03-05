<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Product - Related Products
 */
$related_products = wc_get_related_products(get_the_ID(), 8);
if (empty($related_products)) {
  return;
}
?>
<section class="related-products">
  <div class="section__inner">
    <h2 class="block__title"><?php esc_html_e('Cơ sở lưu trú lân cận', 'gpw'); ?></h2>
    <div class="related-products__carousel">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach ($related_products as $post) {
            setup_postdata($post);
            echo '<div class="swiper-slide">';
            wc_get_template_part('content', 'product');
            echo '</div>';
          } ?>
        </div>
      </div>
      <a href="javascript:void(0);" class="carousel-btn carousel-btn__prev" aria-label="Carousel previous slide"
        role="button">
        <span class="material-symbols-outlined">chevron_left</span>
      </a>
      <a href="javascript:void(0);" class="carousel-btn carousel-btn__next" aria-label="Carousel next slide"
        role="button">
        <span class="material-symbols-outlined">chevron_right</span>
      </a>
    </div>
  </div>
</section>
<?php
// ! Cleanup variables
wp_reset_postdata();
unset($related_products);