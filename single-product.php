<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product template
 */

get_header();
?>
<div id="content">

  <?php get_template_part( 'custom-templates/breadcrumbs-section' ) ?>

  <?php get_template_part( 'custom-templates/woocommerce/single-product/header' ) ?>

  <?php get_template_part( 'custom-templates/woocommerce/single-product/gallery-section' ) ?>

  <?php get_template_part( 'custom-templates/woocommerce/single-product/product-detail' ) ?>

  <?php get_template_part( 'custom-templates/woocommerce/single-product/feedback-section' ) ?>
  
  <?php get_template_part( 'custom-templates/woocommerce/single-product/related-products-section' ) ?>

</div>
<?php
get_footer();
