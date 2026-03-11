<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Override Woocommerce hook
 */
class WoocommerceOverride {
  private const STAR_RATINGS = [
    '1-sao' => 1,
    '2-sao' => 2,
    '3-sao' => 3,
    '4-sao' => 4,
    '5-sao' => 5,
  ];
  public function __construct() {
    add_filter( 'woocommerce_get_price_html', [ $this, 'change_price_display' ], 10, 2 );
    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'display_accommodation_type_and_star_rating_in_product_loop' ], 20, 1);
    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'display_category_in_product_loop' ], 30, 1 );
    add_action( 'woocommerce_shop_loop_item_title', [ $this, 'display_tags_in_product_loop' ], 40, 1 );
  }
  public function change_price_display( $price, $product ) {
    if( $price === '' ) {
      return __('Liên hệ', 'gpw');
    }
    return $price;
  }
  public function display_accommodation_type_and_star_rating_in_product_loop( $product ) {
    $accommodation_type = get_the_terms( $product->get_id(), 'accommodation-type' );
    $star_rating = get_the_terms( $product->get_id(), 'star-rating' );
    if( empty($accommodation_type) && empty($star_rating) ) {
      return;
    }
    echo '<div class="hotel-info">';
    if( $accommodation_type && ! is_wp_error($accommodation_type) ) {
      echo '<div class="hotel-info__accommodation-type"><span class="material-symbols-outlined">apartment</span>';
      $accommodation_type_name = reset( $accommodation_type )->name;
      echo sprintf( '<span>%s</span>', $accommodation_type_name );
      echo '</div>';
    }
    if( $star_rating && ! is_wp_error($star_rating) ) {
      $slug = reset( $star_rating )->slug;
      $stars = self::STAR_RATINGS[$slug] ?? 0;
      echo '<div class="hotel-info__star-rating">';
      for ( $i = 0; $i < $stars; $i++ ) {
        echo '<span class="material-symbols-outlined">star</span>';
      }
      echo '</div>';
    }
    echo '</div>';
  }
  public function display_category_in_product_loop( $product ) {
    $categories = get_the_terms( $product->get_id(), 'product_cat' );
    if ( $categories && ! is_wp_error( $categories ) ) {
      $category_name = reset( $categories )->name;
      echo sprintf( '<div class="product-category"><span class="material-symbols-outlined">location_on</span><span>%s</span></div>', $category_name );
    }
  }
  public function display_tags_in_product_loop( $product ) {
    $tags = get_the_terms( $product->get_id(), 'product_tag' );
    if( empty($tags) || is_wp_error($tags) ) {
      return;
    }
    echo '<ul class="product-tags">';
    foreach( $tags as $idx => $tag ) {
      if( $idx >= 2 ) {
        break;
      }
      echo sprintf('<li>%s</li>', $tag->name);
    }
    if( count($tags) > 2 ) {
      echo sprintf('<li class="product-tags__more">%d+</li>', count($tags) - 2);
    }
    echo '</ul>';
  }
}