<?php
/**
 * RelativeCategory: A class to create a relative category field in the admin panel of Post category page.
 */
final class RelativeCategory
{
  public static function init()
  {
    add_action('admin_init', [__CLASS__, 'createRelativeField']);
    add_action('created_category', [__CLASS__, 'saveRelativeCategoryAndBGImage']);
    add_action('edited_category', [__CLASS__, 'saveRelativeCategoryAndBGImage']);
  }
  // method to add a relative category field in the admin panel of Post category page.
  // This field will be used to select a relative category for the current category.
  public static function createRelativeField()
  {
    add_action('category_add_form_fields', function () {
      ?>
      <div class="form-field">
        <label for="relative_category"><?php _e('Relative Category', 'textdomain'); ?></label>
        <select name="relative_category" id="relative_category">
          <option value=""><?php _e('Select a relative category', 'textdomain'); ?></option>
          <?php
          $categories = get_categories();
          foreach ($categories as $category): ?>
            <option value="<?= esc_attr($category->term_id) ?>"><?= esc_html($category->name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <!-- a field to choose background image for category
       use wordpress image choose metabox -->
      <div class="form-field">
        <label for="category_bg_image"><?php _e('Category Background Image', 'textdomain'); ?></label>
        <input type="hidden" name="category_bg_image" id="category_bg_image" class="regular-text" value="">
        <img src="" alt="" id="category_bg_image_preview" style="max-width: 200px; max-height: 200px;">
        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
      </div>
      <script>
        jQuery(document).ready(function ($) {
          $('#upload-btn').click(function (e) {
            e.preventDefault();
            const image = wp.media({
              title: 'Upload Image',
              multiple: false
            }).open().on('select', function (e) {
              const uploaded_image = image.state().get('selection').first();
              const image_url = uploaded_image.toJSON().url;
              const image_preview = uploaded_image.toJSON().sizes.thumbnail.url;
              $('#category_bg_image').val(image_url);
              $('#category_bg_image_preview').attr('src', image_preview);
            });
          });
        });
      </script>
      <?php
    });

    add_action('category_edit_form_fields', function ($tag) {
      $relative_category = get_term_meta($tag->term_id, 'relative_category', true);
      ?>
      <tr class="form-field">
        <th scope="row" valign="top">
          <label for="relative_category"><?php _e('Relative Category', 'textdomain'); ?></label>
        </th>
        <td>
          <select name="relative_category" id="relative_category">
            <option value=""><?php _e('Select a relative category', 'textdomain'); ?></option>
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
              // make sure the current category is not in the list of relative categories
              if ($category->term_id == $tag->term_id) {
                continue;
              }
              $selected = $relative_category == $category->term_id ? 'selected' : '';
              echo '<option value="' . $category->term_id . '" ' . $selected . '>' . $category->name . '</option>';
            }
            ?>
          </select>
        </td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top">
          <label for="category_bg_image"><?php _e('Category Background Image', 'textdomain'); ?></label>
        </th>
        <td>
          <input type="hidden" name="category_bg_image" id="category_bg_image" class="regular-text"
            value="<?= get_term_meta($tag->term_id, 'category_bg_image', true); ?>">
          <img src="<?= get_term_meta($tag->term_id, 'category_bg_image', true); ?>" alt="" id="category_bg_image_preview"
            style="max-width: 200px; max-height: 200px;">
          <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">
        </td>
      </tr>
      <script>
        jQuery(document).ready(function ($) {
          $('#upload-btn').click(function (e) {
            e.preventDefault();
            const image = wp.media({
              title: 'Upload Image',
              multiple: false
            }).open().on('select', function (e) {
              const uploaded_image = image.state().get('selection').first();
              const image_url = uploaded_image.toJSON().url;
              const image_preview = uploaded_image.toJSON().sizes.thumbnail.url;
              $('#category_bg_image').val(image_url);
              $('#category_bg_image_preview').attr('src', image_preview);
            });
          });
        });
      </script>
        <?php
    });
  }

  // method to save the relative category field value and background image in the database.
  // Make sure the relative category also refers to the current category. An one to one relationship.
  public static function saveRelativeCategoryAndBGImage($term_id)
  {
    $prev_relative_category = get_term_meta($term_id, 'relative_category', true);
    // only save if the relative category is selected and not the same as previous relative category if have any
    if (isset($_POST['relative_category']) && $_POST['relative_category'] != $prev_relative_category) {
      // Save the relative category for the current category
      update_term_meta($term_id, 'relative_category', $_POST['relative_category']);
      // Also update the relative category of the selected relative category
      update_term_meta($_POST['relative_category'], 'relative_category', $term_id);

      // set value category of the previous relative category to empty if have any
      if ($prev_relative_category) {
        update_term_meta($prev_relative_category, 'relative_category', '');
      }
    }
    // save background image into database
    if (isset($_POST['category_bg_image'])) {
      update_term_meta($term_id, 'category_bg_image', $_POST['category_bg_image']);
    }
  }

  // method to get the relative category of the current category.
  public static function getRelativeCategory($term_id)
  {
    return get_term_meta($term_id, 'relative_category', true);
  }
  // method to get the background image of the current category.
  public static function getCategoryBGImage($term_id)
  {
    return get_term_meta($term_id, 'category_bg_image', true);
  }
}

// Initialize the RelativeCategory class
RelativeCategory::init();