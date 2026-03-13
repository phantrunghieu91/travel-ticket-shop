<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Footer - Menu block
 */
$menu_id = $args['menu_id'] ?: false;
if( !$menu_id ) {
  return;
}
$menu_obj = wp_get_nav_menu_object( $menu_id );
$menu_items = wp_get_nav_menu_items( $menu_id );
if( empty($menu_obj) || empty($menu_items) ) {
  return;
}
?>
<div class="footer__menu">
  <h3 class="footer__title"><?= esc_html( $menu_obj->name ) ?></h3>
  <ul class="footer__menu-list">
    <?php foreach( $menu_items as $menu_item ) : ?> 
      <li class="footer__menu-item">
        <a href="<?= esc_url( $menu_item->url ) ?>" class="footer__menu-link"><?= esc_html( $menu_item->title ) ?></a>
      </li>
    <?php endforeach ?>
  </ul>
</div>
<?php 
// ! Cleanup variables
unset( $menu_id, $menu_obj, $menu_items );