<?php
/**
 * The template for displaying search results pages
 */
get_header();
$search_query = get_search_query();
$search_results = new WP_Query(
  array(
    // post type are post, video
    'post_type' => 'post',
    'posts_per_page' => 5,
    's' => $search_query,
    'paged' => 1
  )
);
// enqueue infinite scroll script
InfiniteScroll::enqueueScripts('search__post', 5, null, 'search');
?>

<div id="content" class="search-page">
  <section class="search__header">
    <div class="section__inner">
      <h1 class="search__title">Kết quả tìm kiếm cho: <span class="search__query"><?= esc_html($search_query) ?></span></h1>
      <?= get_search_form() ?>
    </div>
  </section>
  <section class="search__results">
    <div class="section__inner">
      <?php if($search_results->have_posts()): ?>
        <div class="results__post-list"  data-current-page="1" data-max-page="<?= esc_attr($search_results->max_num_pages) ?>">
          <?php for($i = 0; $i < count($search_results->posts); $i++) : $result_item = $search_results->posts[$i]; 
            get_template_part('custom-templates/post-in-loop/layout', 'default', [
              'post_obj' => $result_item,
              'class' => 'search__post',
              'has_meta' => true,
              'show_date_time' => true,
              'show_excerpt' => true,
            ]);
        endfor; ?>
        </div>
      <?php else: ?>
        <div class="search__no-result">Không tìm thấy kết quả nào</div>
      <?php endif; ?>
    </div>
  </section>
</div>

<?php
get_footer();