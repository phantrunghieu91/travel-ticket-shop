<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Page Airport transport - Why choose us
 */
$section_data = get_field( 'why_choose_us', get_the_ID() );
if( empty( $section_data['reason'] ) ) {
  return;
}
?>
<section class="why-choose-us">
  <div class="section__inner">
    <h2 class="why-choose-us__title"><?php esc_html_e( $section_data['title']) ?></h2>
    <ul class="why-choose-us__reasons">
      <?php foreach( $section_data['reason'] as $reason ): ?>
        <li class="why-choose-us__reason">
          <?= wp_get_attachment_image( $reason['icon'], 'medium', false, ['class' => 'why-choose-us__reason-icon']) ?>
          <div class="why-choose-us__reason-content">
            <h3 class="why-choose-us__reason-label"><?php esc_html_e( $reason['label'] ) ?></h3>
            <div class="why-choose-us__reason-desc"><?= wp_kses_post( $reason['description'] ) ?></div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $section_data );