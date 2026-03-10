<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Airport Transport page - Experience section
 */
$section_data = get_field('experience', get_the_ID() );
if( empty( $section_data['experience_item'] ) ) {
  return;
}
$items = [];
foreach( $section_data['experience_item'] as $item ) {
  $id = sanitize_title( $item['label'] );
  $items[ $id ] = $item;
}
?>
<section class="experience">
  <div class="section__inner">
    <h2 class="experience__title"><?= esc_html( $section_data['title'] ); ?></h2>
    <main class="experience__tabs tabs">
      <nav class="tabs__nav">
        <ul class="tabs__nav-list">
          <?php $count = 0; foreach( $items as $id => $item ): ?>
            <li class="tabs__nav-item" id="nav-<?= esc_attr( $id ); ?>" aria-controls="panel-<?= esc_attr( $id ) ?>" 
              aria-selected="<?= $count == 0 ? 'true' : 'false' ?>"><?= esc_html( $item['label'] ); ?></li>
          <?php $count++; endforeach; ?>
        </ul>
      </nav>
      <div class="tabs__content">
        <?php $count = 0; foreach( $items as $id => $item ) : ?>
          <div class="tabs__panel" id="panel-<?= esc_attr( $id ) ?>" aria-labelledby="nav-<?= esc_attr( $id ) ?>" aria-hidden="<?= $count == 0 ? 'false' : 'true' ?>">
            <?= wp_kses_post( $item['description']) ?>
          </div>
        <?php $count++; endforeach ?>
      </div>
    </main>
  </div>
</section>
<?php 
// ! Cleanup variables
unset( $section_data, $items, $id, $item, $count );