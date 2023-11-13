<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
?>
<article class="row page-item">
  <div class="col-md-6">
    <h3 class="page-item__title">
      <?php the_title() ?>
    </h3>
    <div class="page-item__content">
      <?php the_excerpt() ?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="page-item__link">
      <a class="btn btn-border" href="<?php echo get_permalink(); ?>" title="<?php the_title() ?>">Learn more about the <?php the_title() ?></a>
    </div>
  </div>
</article><!-- #post-## -->