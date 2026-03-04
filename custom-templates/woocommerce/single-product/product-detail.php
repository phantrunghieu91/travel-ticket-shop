<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - product detail section
 */
$saved_highlights = get_post_meta(get_the_ID(), '_gpw_highlight', true) ?: [];
$highlights = get_field('highlights', 'gpw_product_data') ?: [];
$saved_amenities = get_post_meta(get_the_ID(), '_gpw_amenities', true) ?: [];
$amenities = get_field('amenities', 'gpw_product_data') ?: [];
$description = get_post_field( 'post_content', get_the_ID() );
$reviews = get_field('review') ?? [];
$surroundings = get_field('surroundings') ?? [];
?>
<section class="product-detail">
  <div class="section__inner">
    <div class="product-detail__left">
      <?php if ( ! empty( $saved_highlights ) ) : ?>
      <div class="product-detail__highlight">
        <h2 class="block__title"><?php esc_html_e('Điểm nổi bật', 'gpw') ?></h2>
        <ul class="product-detail__highlight-list">
        <?php foreach ( $saved_highlights as $highlight_idx ) : 
          $highlight = $highlights[$highlight_idx] ?? null;
          if ( ! $highlight ) continue;
          $tooltip_id = "highlight-tooltip-{$highlight_idx}";
        ?>

          <li class="product-detail__highlight-item">
            <?= wp_get_attachment_image( $highlight['icon'] ?: PLACEHOLDER_IMAGE_ID, 'thumbnail', false, [ 'class' => 'product-detail__highlight-icon']) ?>
            <p class="product-detail__highlight-label">
              <span><?= esc_html( $highlight['label'] ) ?></span>
              <?php if( !empty($highlight['description'])): ?>
                <button type="button" class="product-detail__highlight-tooltip-control"
                  popovertarget="<?= esc_attr( $tooltip_id) ?>"><span class="material-symbols-outlined">info</span></button>
              <?php endif ?>
            </p>
            <?php if( !empty($highlight['description'])): ?>
              <div class="product-detail__tooltip-description" popover id="<?= esc_attr( $tooltip_id) ?>">
                <?= wp_kses_post( $highlight['description']) ?>
              </div>
            <?php endif ?>
          </li>  

        <?php endforeach ?>
        </ul>
      </div>
      <?php endif; ?>
      <?php if ( ! empty( $saved_amenities ) ) : ?>
      <div class="product-detail__amenities">
        <h2 class="block__title"><?php esc_html_e('Tiện nghi', 'gpw') ?></h2>
        <ul class="product-detail__amenities-list">
        <?php foreach ( $saved_amenities as $amenity_idx ) : 
          $amenity = $amenities[$amenity_idx] ?? null;
          if ( ! $amenity ) continue;
        ?>
          <li class="product-detail__amenity-item">
            <?php if( !empty( $amenity['icon'])) echo wp_get_attachment_image( $amenity['icon'] ?: PLACEHOLDER_IMAGE_ID, 'thumbnail', false, [ 'class' => 'product-detail__amenity-icon']) ?>
            <span class="product-detail__amenity-label"><?= esc_html( $amenity['label'] ) ?></span>
          </li>
        <?php endforeach ?>
        </ul>
      </div>
      <?php endif ?>
      <?php if( !empty( $description ) ) : ?>
      <div class="product-detail__description-wrapper" id="product-detail-description">
        <h2 class="block__title"><?php esc_html_e('Mô tả cơ sở lưu trú', 'gpw') ?></h2>
        <div class="product-detail__description" aria-hidden="true"><?= wp_kses_post( $description ) ?></div>
        <a href="javascript:void(0);" class="product-detail__description-toggle" aria-controls="product-detail-description" aria-expanded="false"><?= esc_html_e('Xem thêm', 'gpw') ?></a>
      </div>
      <?php endif ?>
    </div>
    <aside class="product-detail__right">
    <?php if( !empty( $reviews['feedback'] ) ) : ?>
      <div class="product-detail__review">

      <?php if( !empty( $reviews['point'] ) && !empty( $reviews['title']) ): ?>
        <header class="product-detail__review-header">
        <?php if( !empty( $reviews['point'] ) ): ?>
          <span class="product-detail__review-point"><?php echo esc_html( $reviews['point'] ) ?></span>  
        <?php endif ?>
        <?php if( !empty( $reviews['title'] ) ): ?>
          <span class="product-detail__review-title"><?= esc_html( $reviews['title'] ) ?></span>
        <?php endif ?>
        </header>
      <?php endif ?>
        <div class="product-detail__feedback-carousel">
          <div class="swiper">
            <div class="swiper-wrapper">
            <?php foreach( $reviews['feedback'] as $feedback ) : ?>
              <div class="swiper-slide">
                <?= wp_kses_post( $feedback['quote'] ) ?>
              </div>
            <?php endforeach ?>
            </div>
          </div>
          <a href="javascript:void(0);" class="carousel-btn carousel-btn__prev" aria-label="Carousel previous slide" role="button">
            <span class="material-symbols-outlined">chevron_left</span>
          </a>
          <a href="javascript:void(0);" class="carousel-btn carousel-btn__next" aria-label="Carousel next slide" role="button">
            <span class="material-symbols-outlined">chevron_right</span>
          </a>
        </div>
      </div>
    <?php endif ?>
    <?php if( !empty( $surroundings['place'] ) ): ?>
      <div class="product-detail__surrounding">
        <h2 class="block__title"><?php echo esc_html( $surroundings['title'] ?: __('Xem xung quanh đây', 'gpw') ) ?></h2>
        <ul class="product-detail__surrounding-list">
        <?php foreach( $surroundings['place'] as $place ) : ?>
          <li class="product-detail__place">
            <span class="product-detail__place-name"><?= esc_html( $place['name']) ?></span>
            <?php if( !empty( $place['distance'] )) : ?>
              <span class="product-detail__place-distance">(<?= esc_html( $place['distance'] ) ?>)</span>
            <?php endif ?>
          </li>
        <?php endforeach ?>
        </ul>
      </div>
    <?php endif ?>
    </aside>
  </div>
</section>
<?php
// ! Cleanup variables
unset( $saved_highlights, $highlights );