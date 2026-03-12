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
$classes = [$main_class, "{$main_class}-{$productID}", "{$main_class}--horizontal"];
$thumbnail_id = $product->get_image_id() ?? PLACEHOLDER_IMAGE_ID;
$title = $product->get_name();
$permalink = get_permalink( $productID );
$category_ids = $product->get_category_ids();
$category_id = !empty( $category_ids ) ? $category_ids[0] : false;
$category = $category_id ? get_term( $category_id ) : false;
$accommodation_type = get_the_terms( $product->get_id(), 'accommodation-type' )[0] ?? false;
$star_rating = get_the_terms( $product->get_id(), 'star-rating' )[0] ?? false;
$tags = get_the_terms( $product->get_id(), 'product_tag' );
$price = $product->get_price();
$review_data = get_field('review') ?? [];
$price_html = $price ? $product->get_price_html() : sprintf('<span class="price">%s</span>', __('Liên hệ', 'gpw'));
?>
<article class="<?= esc_attr(implode(' ', $classes)); ?>">
  <a href="<?= esc_url( $permalink ) ?>" class="<?= esc_attr( "{$main_class}__thumbnail" ) ?>">
    <?= wp_get_attachment_image( $thumbnail_id, 'medium', false ) ?>
  </a>
  <div class="<?= esc_attr( "{$main_class}__content" ) ?>">
    <h3 class="<?= esc_attr( "{$main_class}__title" ) ?>">
      <a href="<?= esc_url( $permalink ) ?>"><?= esc_html( $title ) ?></a>
    </h3>

    <?php if( $accommodation_type || $star_rating ) : ?>
      <div class="<?= esc_attr( $main_class) ?>__info">

        <?php if( $accommodation_type && ! is_wp_error($accommodation_type) ) : ?>
          <div class="<?= esc_attr( "{$main_class}__accommodation-type" ) ?>">
            <span class="material-symbols-outlined">apartment</span>
            <span><?= esc_html( $accommodation_type->name ) ?></span>
          </div>
        <?php endif ?>

        <?php if( $star_rating && ! is_wp_error($star_rating) ) : ?>
          <div class="<?= esc_attr( "{$main_class}__star-rating" ) ?>">
            <?php
            $slug = $star_rating->slug;
            $star_count = intval(str_split( $slug, 1 )[0]);
            for ( $i = 0; $i < $star_count; $i++ ) {
              echo '<span class="material-symbols-outlined">star</span>';
            }
            ?>
          </div>
        <?php endif ?>
      </div>
    <?php endif ?>

    <?php if( $category ) {
      echo sprintf('<div class="%s"><span class="material-symbols-outlined">location_on</span><span>%s</span></div>',
      esc_attr( "{$main_class}__category" ),
      esc_html( $category->name )
      );
    } ?>

    <?php if( !empty($tags) && ! is_wp_error($tags) ) : ?>
      <ul class="<?= esc_attr( $main_class) ?>__tags">

        <?php foreach( $tags as $idx => $tag ) {
          if( $idx >= 3 ) {
            break;
          }
          echo sprintf('<li class="%s">%s</li>',
          esc_attr( "{$main_class}__tag" ),
          esc_html( $tag->name )
          );
        } ?>
        <?php if( count($tags) > 3 ) : ?>
          <li class="<?= esc_attr( "{$main_class}__tag {$main_class}__tag--more" ) ?>">
            <?= sprintf('+%d', count($tags) - 3) ?>
          </li>
        <?php endif ?>

      </ul>
    <?php endif ?>
  </div>
  <div class="<?= esc_attr( "{$main_class}__price" ) ?>"><?= $price_html ?></div>
</article>