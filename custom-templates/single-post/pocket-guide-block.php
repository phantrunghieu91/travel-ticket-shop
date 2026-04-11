<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single post - Pocket guide block
 */
$pocket_guide_data = get_field('pocket_guide', get_the_ID());
if( empty( $pocket_guide_data['content'] ) ) {
  return;
}
$icon_id = 1673;
$title = $pocket_guide_data['title'] ?? __('Cẩm nang bỏ túi', 'gpw');
?>
<div class="pocket-guide">
  <div class="pocket-guide__legend">
    <div class="pocket-guide__icon-wrapper"><?= wp_get_attachment_image( $icon_id, 'medium', false, [ 'class' => 'pocket-guide__icon']) ?></div>
    <span><?= esc_html( $title ); ?></span>
  </div>
  <div class="pocket-guide__content"><?= wp_kses_post( $pocket_guide_data['content'] ); ?></div>
</div>