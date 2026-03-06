<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Product taxonomy template
 */
get_header(); 
?>
<div id="content">

  <?php get_template_part( 'custom-templates/woocommerce/category/products-section', null, ['title' => __('Khách sạn tiêu biểu', 'gpw'), 'is_featured' => true] ) ?>

</div>
<?php 
get_footer();