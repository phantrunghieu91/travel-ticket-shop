<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Airport transport page - Hero section
 */
$section_data = get_field( 'hero', get_the_ID() );
$form_sc = '[contact-form-7 id="d62d39b" title="AIRPORT TRANSPORT PAGE: Register form"]';
?>
<section class="hero">
  <div class="section__inner section__inner--full">
    <div class="hero__content">
      <div class="hero__content-left">
        <?php if( !empty($section_data['title']) ) : ?>
        <h2 class="hero__title"><?= esc_html( $section_data['title'] ) ?></h2>
        <?php endif ?>
        <?php if( !empty($section_data['description']) ) : ?>
        <div class="hero__description"><?= wp_kses_post( $section_data['description'] ) ?></div>
        <?php endif ?>
      </div>
      <div class="hero__content-right"><?= wp_get_attachment_image( $section_data['banner'], 'full', false, ['class' => 'hero__banner']) ?></div>
    </div>
    <div class="hero__form-wrapper"><?= do_shortcode( $form_sc ) ?></div>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $section_data, $form_sc );
