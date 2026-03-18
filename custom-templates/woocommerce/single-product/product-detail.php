<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail section
 */
$google_map_link = get_field('address') && get_field('address')['link_google_map'] ? get_field('address')['link_google_map'] : false;
?>
<section class="product-detail">
  <div class="section__inner">
       
    <?php get_template_part( 'custom-templates/woocommerce/single-product/product-detail/review-block', null, ['google_map_link' => $google_map_link] ) ?>

    <?php get_template_part( 'custom-templates/woocommerce/single-product/product-detail/amenities-block' ) ?> 
    
    <?php get_template_part( 'custom-templates/woocommerce/single-product/product-detail/surroundings-block', null, ['google_map_link' => $google_map_link] ) ?>     
    
  </div>
</section>
<?php
// ! Cleanup variables
unset( $saved_highlights, $highlights );