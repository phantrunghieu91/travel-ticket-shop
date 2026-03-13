<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Footer - Main section
 */
$section_data = get_field('footer_main', 'company_info');
$logo_id = get_theme_mod('site_logo');
$policy_menu_id = 100;
$customer_menu_id = 101;
?>
<section class="footer__main">
  <div class="section__inner">
    <?php if( $logo_id ) {
      echo wp_get_attachment_image( $logo_id, 'medium', false, ['class' => 'footer__logo'] );
    } ?>
    <div class="footer__about">
      <h3 class="footer__title"><?= esc_html( $section_data['about_company_block_title']) ?></h3>
      <div class="footer__phone">Điện thoại: <?= do_shortcode('[company_info type="phone"]') ?></div>
      <div class="footer__email">Email: <?= do_shortcode('[company_info type="email"]') ?></div>
      <div class="footer__address">Địa chỉ: <?= do_shortcode('[company_info type="address"]') ?></div>
      <?php if( !empty( $section_data['certificates'] ) ): ?>
        <div class="footer__cert">
          <?php foreach( $section_data['certificates'] as $cert_id ) {
            echo wp_get_attachment_image( $cert_id, 'medium_large', false, ['class' => 'footer__cert-image'] );
          } ?>
        </div>
      <?php endif ?>
    </div>
    <?php get_template_part( 'custom-templates/footer/menu-block', null, ['menu_id' => $policy_menu_id] ) ?>
    <?php get_template_part( 'custom-templates/footer/menu-block', null, ['menu_id' => $customer_menu_id] ) ?>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $section_data, $logo_id, $policy_menu_id, $customer_menu_id );