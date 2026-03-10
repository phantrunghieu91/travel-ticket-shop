<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Page airport transport
 */
get_header(); ?>
<div id="content">

  <?php 
  get_template_part( 'custom-templates/airport-transport/hero-section' );

  get_template_part( 'custom-templates/airport-transport/why-choose-us-section' );

  get_template_part( 'custom-templates/airport-transport/partners-section' );

  get_template_part( 'custom-templates/airport-transport/experience-section' );

  get_template_part( 'custom-templates/airport-transport/process-section' );
  ?>
</div>
<?php get_footer();