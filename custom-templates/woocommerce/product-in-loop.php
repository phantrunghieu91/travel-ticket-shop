<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Woocommerce - Product in loop
 */
$productID = get_the_ID();
$product = wc_get_product( $productID );
if( !$product || is_a( $product, 'WP_Error' ) ) {
  do_action( 'qm/debug', 'No product found for product in loop template' );
  return;
}
$main_class = 'hotel';
$classes = [$main_class, "{$main_class}-{$productID}"];
$thumbnail_id = $product->get_image_id() ?? PLACEHOLDER_IMAGE_ID;
$title = $product->get_name();
$permalink = get_permalink( $productID );
$category_ids = $product->get_category_ids();
$category_id = !empty( $category_ids ) ? $category_ids[0] : false;
$category = $category_id ? get_term( $category_id ) : false;
$price = $product->get_price();
$price_html = $price ? $product->get_price_html() : sprintf('<span class="price">%s</span>', __('Liên hệ', 'gpw'));
$review_count = $product->get_review_count();
$rating_html = wc_get_rating_html( $product->get_average_rating() );
?>
<article class="<?= esc_attr(implode(' ', $classes)); ?>">
  <a href="<?= esc_url( $permalink ) ?>" class="<?= esc_attr( "{$main_class}__thumbnail" ) ?>">
    <?= wp_get_attachment_image( $thumbnail_id, 'medium', false ) ?>
  </a>
  <div class="<?= esc_attr( "{$main_class}__content" ) ?>">
    <?php if( $category ) {
      echo sprintf('<a href="%s" class="%s">%s</a>',
      esc_url( get_term_link( $category ) ),
      esc_attr( "{$main_class}__category" ),
      esc_html( $category->name )
      );
    } ?>

    <h3 class="<?= esc_attr( "{$main_class}__title" ) ?>">
      <a href="<?= esc_url( $permalink ) ?>"><?= esc_html( $title ) ?></a>
    </h3>

    <?php if( $review_count || $rating_html ) : ?>
      <div class="<?= esc_attr( "{$main_class}__review-wrapper" ) ?>">
        <?php if( $rating_html ) {
          echo sprintf('<div class="%s">%s</div>',
          esc_attr( "{$main_class}__rating" ),
          $rating_html
          );
        } ?>
        <?php if( $review_count ) {
          echo sprintf('<span class="%s">(%d)</span>',
          esc_attr( "{$main_class}__review-count" ),
          $review_count
          );
        } ?>
      </div>
    <?php endif; ?>
    <div class="<?= esc_attr( "{$main_class}__price" ) ?>"><?= $price_html ?></div>
  </div>
</article>