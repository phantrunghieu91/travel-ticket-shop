<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single Product - Header
 */
$address = get_field('address', get_the_ID());
?>
<header class="single-product__header">
  <div class="section__inner">
    <h1 class="single-product__title">
      <?= get_the_title() ?>
    </h1>
    <?php if( isset($address['text']) && !empty( $address['text']) ) : ?>
      <p class="single-product__address"><?= esc_html( $address['text'] ) ?></p>
      <?php if( isset( $address['link_google_map'] ) && !empty( $address['link_google_map'] ) ) : ?>
        <a href="<?= esc_url( $address['link_google_map'] ) ?>" target="_blank"><?php esc_html_e( 'Xem trên bản đồ', 'gpw' ) ?></a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</header>
<?php 
// ! Cleanup variables
unset( $address );