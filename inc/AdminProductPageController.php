<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Controller: Handling product page in admin dashboard
 */
class AdminProductPageController {
  private $highlights = [];
  private $amenities = [];
  public function __construct() {
    $this->set_custom_fields();
    add_filter( 'woocommerce_product_data_tabs', [ $this, 'add_data_tabs' ] );
    add_action( 'woocommerce_product_data_panels', [ $this, 'add_data_panel_content' ] );
    add_action( 'woocommerce_process_product_meta', [ $this, 'save_custom_fields' ] );
  }
  private function set_custom_fields() {
    $highlight_data = get_field( 'highlights', 'gpw_product_data');
    $amenities_data = get_field( 'amenities', 'gpw_product_data');
    if( empty( $highlight_data ) ) {
      return;
    }
    foreach( $highlight_data as $idx => $highlight ) {
      $this->highlights[] = [
        'type' => 'checkbox',
        'label' => $highlight['label'] ?? sprintf( __('Điểm nổi bật %d', 'gpw'), $idx + 1 ),
        'cbvalue' => $idx,
        'default' => 0,
      ];
    }
    if( empty( $amenities_data ) ) {
      return;
    }
    foreach( $amenities_data as $idx => $amenity ) {
      $this->amenities[] = [
        'type' => 'checkbox',
        'label' => $amenity['label'] ?? sprintf( __('Tiện nghi %d', 'gpw'), $idx + 1 ),
        'cbvalue' => $idx,
        'default' => 0,
      ];
    }
  }
  public function add_data_tabs( $tabs ) {
    $tabs['gpw_hotel_info'] = [
      'label' => __('Điểm nổi bật', 'gpw'),
      'target' => 'hotel_highlight_data',
      'class' => ['show_if_simple', 'show_if_variable'],
      'priority' => 1
    ];
    $tabs['gpw_hotel_amenities'] = [
      'label' => __('Tiện nghi', 'gpw'),
      'target' => 'hotel_amenities_data',
      'class' => ['show_if_simple', 'show_if_variable'],
      'priority' => 2
    ];
    return $tabs;
  }
  public function add_data_panel_content() {
    $saved_highlights = get_post_meta( get_the_ID(), '_gpw_highlight', true ) ?: [];
    $saved_amenities = get_post_meta( get_the_ID(), '_gpw_amenities', true ) ?: [];
    ?>
    <div id="hotel_highlight_data" class="panel woocommerce_options_panel gpw-panel">
      <?php if( !empty( $this->highlights ) ): ?>
        <div class="options_group">
        
        <?php foreach($this->highlights as $highlight) {
          $is_checked = in_array( $highlight['cbvalue'], $saved_highlights );
          woocommerce_wp_checkbox( [
            'id' => 'gpw_highlight_' . $highlight['cbvalue'],
            'name' => 'gpw_highlight[]',
            'label' => $highlight['label'],
            'cbvalue' => $highlight['cbvalue'],
            'value' => $is_checked ? $highlight['cbvalue'] : '',
            'checked_value' => $highlight['cbvalue'],
          ]);
        } ?>

        </div>
      <?php else: ?>
        <p><?php esc_html_e( 'Không có điểm nổi bật nào để hiển thị', 'gpw' ) ?></p>
      <?php endif ?>
    </div>
    <div id="hotel_amenities_data" class="panel gpw-panel woocommerce_options_panel">
    <?php if( !empty( $this->amenities ) ): ?>
      <div class="options_group">
      <?php foreach($this->amenities as $amenity) {
        $is_checked = in_array( $amenity['cbvalue'], $saved_amenities );
        woocommerce_wp_checkbox( [
          'id' => 'gpw_amenity_' . $amenity['cbvalue'],
          'name' => 'gpw_amenities[]',
          'label' => $amenity['label'],
          'cbvalue' => $amenity['cbvalue'],
          'value' => $is_checked ? $amenity['cbvalue'] : '',
          'checked_value' => $amenity['cbvalue'],
        ]);
      } ?>
      </div>
    <?php else: ?>
      <p><?php esc_html_e( 'Không có tiện nghi nào để hiển thị', 'gpw' ) ?></p>
    <?php endif ?>
    </div>
    <style>
      .gpw-panel {
        container-type: inline-size;
      }
      .gpw-panel .options_group {
        padding-top: 1rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: .625rem;
      }
      .gpw-panel .options_group .form-field {
        margin-block: 0;
      }
    </style>
    <?php 
  }
  public function save_custom_fields( $post_id ) {
    if( isset( $_POST['gpw_highlight'] ) ) {
      $highlights = array_map( 'intval', $_POST['gpw_highlight'] );
      update_post_meta( $post_id, '_gpw_highlight', $highlights );
    }
    if( isset( $_POST['gpw_amenities'] ) ) {
      $amenities = array_map( 'intval', $_POST['gpw_amenities'] );
      update_post_meta( $post_id, '_gpw_amenities', $amenities );
    }
  }
}