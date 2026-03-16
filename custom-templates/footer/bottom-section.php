<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Footer - Bottom section
 */
$section_data = get_field('footer_bottom', 'company_info');
?>
<section class="footer__bottom">
  <div class="section__inner">
    <?php if( !empty( $section_data['title'] ) ): ?>
      <p class="footer__bottom-title"><?= esc_html( $section_data['title'] ); ?></p>
    <?php endif ?>
    <?php if( !empty( $section_data['logos'] ) ): ?>
      <div class="footer__bottom-logos">
      <?php foreach( $section_data['logos'] as $logo_id ) {
        echo wp_get_attachment_image( $logo_id, 'medium', false, ['class' => 'footer__bottom-logo'] );
      } ?>
      </div>
    <?php endif ?>
    <p class="footer__ownership">
      <span class="footer__copyright">&copy; <?= date('Y'); ?> - Bản quyền thuộc về <?= get_bloginfo('name') ?></span>
      <span class="footer__designed-by"><a href="https://giaiphapweb.vn/thiet-ke-web/">Thiết kế website</a> bởi <a href="https://giaiphapweb.vn">GiaiPhapWeb.vn</a></span>
    </p>
  </div>
</section>