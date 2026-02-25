<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Home page - Hero section
 */
$section_data = get_field('hero', get_the_ID());
if( empty( $section_data['banner_image'] ) ) {
  do_action( 'qm/debug', 'No banner image found for hero section' );
  return;
}
$url = get_url_form_link_to( $section_data['link_to'] );
$nav_items = [
  'sightseeing' => [
    'label' => __('Vé tham quan', 'gpw'),
    'icon' => 'festival'
  ],
  'hotel' => [
    'label' => __('Khách sạn', 'gpw'),
    'icon' => 'hotel',
    'link' => 'javascript:void(0);'
  ],
  'airport_shuttle' => [
    'label' => __('Đưa đón sân bay', 'gpw'),
    'icon' => 'airport_shuttle',
    'link' => 'javascript:void(0);'
  ],
  'bike_rental' => [
    'label' => __('Thuê xe máy', 'gpw'),
    'icon' => 'moped',
    'link' => 'javascript:void(0);'
  ],
]
?>
<section class="hero">
  <div class="section__inner section__inner--full">
    <a href="<?= esc_url( $url ); ?>" class="hero__banner-wrapper">
      <?= wp_get_attachment_image( $section_data['banner_image'], 'full', false, [ 'class' => 'hero__banner', 'alt' => 'Hero banner' ]) ?>
    </a>
    <div class="hero__tabs">
      <nav class="hero__tabs-nav tabs-nav">
        <ul class="tabs-nav__list" role="tablist">
        <?php foreach( $nav_items as $key => $item ) : ?>
          <?php if( !isset( $item['link'] ) ) : ?>
            <li class="tabs-nav__item" aria-controls="panel-<?= esc_attr( $key ) ?>" role="tab"
              aria-selected="<?= $key === 'sightseeing' ? 'true' : 'false' ?>" id="tab-<?= esc_attr( $key ) ?>">
              <span class="material-symbols-outlined"><?= esc_html( $item['icon']) ?></span>
              <span class="tabs-nav__item-label"><?= esc_html( $item['label']) ?></span>
            </li>
          <?php else : ?>
            <li class="tabs-nav__item">
              <a href="<?= $item['link'] ?>">
                <span class="material-symbols-outlined"><?= esc_html( $item['icon']) ?></span>
                <span class="tabs-nav__item-label"><?= esc_html( $item['label']) ?></span>
              </a>
            </li>
          <?php endif; ?>
        <?php endforeach ?>
        </ul>
      </nav>
      <div class="hero__form-wrapper" id="hero-form-wrapper">
        <header class="hero__popup-header">
          <h3 class="hero__popup-title">
            <?php esc_html_e('Tìm kiếm vé tham quan', 'gpw') ?>
          </h3>
          <button type="button" class="hero__close-btn" aria-controls="hero-form-wrapper" aria-label="<?= esc_attr('Đóng popup', 'gpw') ?>">
            <span class="material-symbols-outlined">close</span>
          </button>
        </header>
        <form action="POST" class="hero__form tabs__panel" id="panel-sightseeing" aria-labeledby="tab-sightseeing" aria-hidden="false">
          <fieldset>
            <input type="hidden" name="action" value="sightseeing">
          </fieldset>
          <div class="search-form__control-group">
            <label for="keyword" class="search-form__control-label">
              <span><?php esc_html_e('Bạn muốn đi đâu', 'gpw') ?></span>
              <span class="required"> *</span>
            </label>
            <input type="text" name="keyword" id="keyword" class="search-form__control" placeholder="<?php esc_attr_e('Chọn điểm đến...', 'gpw') ?>" required>
          </div>
          <div class="search-form__control-group">
            <button type="submit" class="search-form__submit-btn" disabled>
              <span class="material-symbols-outlined">search</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?php
// ! Cleanup variables
unset($section_data, $url);