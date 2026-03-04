<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Single product - Feedback section
 */
// check if comment is enabled
if (!comments_open()) {
  return;
}
?>
<section class="feedback">
  <div class="section__inner">
    <?php comments_template(); ?>
  </div>
</section>
<?php
