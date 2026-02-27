<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Override Woocommerce hook
 */
class WoocommerceOverride {
  public function __construct() {
    add_filter( 'woocommerce_get_price_html', [ $this, 'change_price_display' ], 10, 2 );
  }
  public function change_price_display( $price, $product ) {
    if( $price === '' ) {
      return __('Liên hệ', 'gpw');
    }
    return $price;
  }
}