<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Hotel carousel section
 */
$hotels = get_posts([
  'post_type' => 'product',
  'posts_per_page' => 10,
  'orderby' => 'date',
  'order' => 'DESC',
]);
if( empty( $hotels ) )
  return;
$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
for( $i = 0; $i < 9; $i++) {
  $hotels[] = $hotels[0];
}
?>
<section class="hotel-carousel">
  <div class="section__inner">
    <header class="hotel-carousel__header">
      <h2 class="section__title"><?php esc_html_e('Khách sạn tuyển chọn', 'gpw') ?></h2>
      <a href="<?= esc_url( $shop_url) ?>" class="hotel-carousel__shop-link">
        <span><?php esc_html_e('Xem thêm', 'gpw') ?></span>
        <span class="material-symbols-outlined">chevron_right</span>
      </a>
    </header>
    <div class="hotel-carousel__swiper-wrapper">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php foreach( $hotels as $post ) {
            setup_postdata( $post );
            echo '<div class="swiper-slide">';
            get_template_part( 'custom-templates/woocommerce/product-in-loop' );
            echo '</div>';
          }
          wp_reset_postdata();
          ?>
        </div>
      </div>
      <a href="javascript:void(0);" class="hotel-carousel__prev">
        <span class="material-symbols-outlined">chevron_left</span>
      </a>
      <a href="javascript:void(0);" class="hotel-carousel__next">
        <span class="material-symbols-outlined">chevron_right</span>
      </a>
    </div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $hotels, $shop_url );