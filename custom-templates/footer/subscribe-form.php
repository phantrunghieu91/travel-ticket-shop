<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Footer - Subscribe form
 */
$block_data = get_field('subscribe_form', 'company_info');
if( empty( $block_data['contact_form_7_sc'])) {
  return;
}
?>
<div class="subscribe-form">
  <?php if( !empty($block_data['title']) && !empty( $block_data['description'] ) ): ?>
  <div class="subscribe-form__content">
    <?php if( !empty($block_data['icon']) ) {
      echo wp_get_attachment_image( $block_data['icon'], 'medium', false, ['class' => 'subscribe-form__icon'] );
    } ?>
    <?php if( !empty($block_data['title']) ): ?>
      <h4 class="subscribe-form__title"><?= esc_html( $block_data['title'] ) ?></h4>
    <?php endif ?>
    <?php if( !empty($block_data['description']) ): ?>
      <p class="subscribe-form__description"><?= esc_html( $block_data['description'] ) ?></p>
    <?php endif ?>
  </div>
  <?php endif ?>
  <div class="subscribe-form__form">
    <?= do_shortcode( $block_data['contact_form_7_sc'] ) ?>
  </div>
</div>
<?php 
// ! Cleanup variables
unset( $block_data );