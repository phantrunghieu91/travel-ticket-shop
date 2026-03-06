<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Product category - Products
 */
$current_obj = get_queried_object();
if( !is_a( $current_obj, 'WP_Term' ) ) {
  return;
}
$title = isset( $args['title'] ) ? $args['title'] : __('Danh mục sản phẩm', 'gpw');
$is_featured = isset( $args['is_featured'] ) ? $args['is_featured'] : false;
$classes = ['gpw-products'];
$query_args = [
  'post_type' => 'product',
  'posts_per_page' => 6,
  'orderby' => 'date',
  'order' => 'DESC',
];
$meta_query = WC()->query->get_meta_query();
$tax_query = WC()->query->get_tax_query();
if( $is_featured ) {
  $classes[] = 'gpw-products--featured';
  $tax_query[] = [
    'taxonomy' => 'product_visibility',
    'field' => 'name',
    'terms' => 'featured',
    'operator' => 'IN',
  ];
  $tax_query[] = [
    'taxonomy' => 'product_cat',
    'field' => 'term_id',
    'terms' => $current_obj->term_id,
    'operator' => 'IN',
  ];
}
if( !empty( $meta_query ) ) {
  $query_args['meta_query'] = $meta_query;
}
if( !empty( $tax_query ) ) {
  $query_args['tax_query'] = $tax_query;
}
$products_query = new WP_Query( $query_args );
if( !$products_query->have_posts() ) {
  return;
}
$shop_url = get_permalink( wc_get_page_id( 'shop' ) );
?>
<section class="<?= esc_attr( implode( ' ', $classes ) ) ?>">
  <div class="section__inner">
    <header class="gpw-products__header">
      <h2 class="section__title"><?= esc_html( $title ) ?></h2>
      <a href="<?= esc_url( $shop_url ) ?>" class="gpw-products__view-all-btn"><?php esc_html_e('Xem tất cả', 'gpw') ?></a>
    </header>
    <main class="gpw-products__carousel">
      <div class="swiper">
        <div class="swiper-wrapper">
          <?php while( $products_query->have_posts() ) {
            $products_query->the_post();
            echo '<div class="swiper-slide">';
            wc_get_template_part( 'content', 'product' );
            echo '</div>';
          } ?>
        </div>
        <div class="swiper-scrollbar"></div>
      </div>
      <a href="javascript:void(0);" class="carousel-btn carousel-btn__prev" aria-label="Carousel previous slide"
        role="button">
        <span class="material-symbols-outlined">chevron_left</span>
      </a>
      <a href="javascript:void(0);" class="carousel-btn carousel-btn__next" aria-label="Carousel next slide"
        role="button">
        <span class="material-symbols-outlined">chevron_right</span>
      </a>
    </main>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $title, $is_featured, $classes, $query_args );