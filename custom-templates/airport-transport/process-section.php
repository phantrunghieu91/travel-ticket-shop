<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Airport transport page - Process section
 */
$section_data = get_field('process', get_the_ID());
if( empty( $section_data['step'] ) ) {
  return;
}
?>
<section class="process">
  <div class="section__inner">
    <h2 class="process__title"><?= esc_html( $section_data['title']) ?></h2>
    <ul class="process__steps">
      <?php foreach( $section_data['step'] as $step ) : ?>

        <li class="process__step">
          <?= wp_get_attachment_image( $step['image'], 'medium_large', false, ['class' => 'process__step-img']) ?>
          <div class="process__step-content">
            <h3 class="process__step-label"><?= esc_html( $step['label']) ?></h3>
            <div class="process__step-desc"><?= wp_kses_post( $step['content']) ?></div>
          </div>
        </li>

      <?php endforeach ?>
    </ul>
  </div>
</section>
<?php 
// ! Cleanup variables
unset($section_data, $step);