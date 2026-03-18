<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Footer - Socials block
 */
$socials = get_field('socials', 'company_info') ?: [];
if( empty($socials) ) {
  return;
}
?>
<ul class="gpw-socials">
  <?php foreach( $socials as $social ) {
    $link = $social['link'] ? esc_url( $social['link'] ) : 'javascript:void(0);';
    $icon_id = $social['icon'] ?: PLACEHOLDER_IMAGE_ID;
    echo sprintf('<li class="gpw-socials__item"><a href="%s" target="blank">%s</a></li>', 
      $link,
      wp_get_attachment_image( $icon_id, 'full', false, ['class' => 'gpw-socials__icon', 'alt' => $social['name']] )
    );
  } ?>
</ul>
<?php 
// ! Cleanup variables
unset( $socials );