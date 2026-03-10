<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Airport transport page - partners section
 */
$section_data = get_field( 'partners', get_the_ID() );
if( empty( $section_data['partner' ] ) ) {
  return;
}
?>
<section class="partners">
  <div class="section__inner">
    <aside class="partners__aside">
      <h2 class="partners__title"><?= esc_html( $section_data['title'] ) ?></h2>
      <?php if( !empty( $section_data['description'] ) ) : ?>
        <div class="partners__description"><?= wp_kses_post( $section_data['description'] ) ?></d>
      <?php endif; ?>
    </aside>
    <main class="partners__main">
      <ul class="partners__list">
        <?php foreach( $section_data['partner'] as $partner ) {
          $url = get_url_form_link_to( $partner['link_to'] );
          $alt_text = $partner['label'] ?: '';
          $icon_html = wp_get_attachment_image( $partner['logo'], 'medium', false, ['class' => 'partners__item-logo', 'alt' => esc_attr( $alt_text )] );
          echo '<li class="partners__item">';
          if( $url ) {
            echo sprintf( '<a href="%s" class="partners__item-link" target="_blank" rel="noopener noreferrer">%s</a>', esc_url( $url ), $icon_html );
          } else {
            echo sprintf( '<div class="partners__item-link">%s</div>', $icon_html );
          }
          echo '</li>';
        } ?>          
      </ul>
    </main>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $section_data );