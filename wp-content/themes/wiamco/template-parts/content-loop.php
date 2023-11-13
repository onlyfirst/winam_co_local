<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
?>

<div class="project-item <?php echo is_sticky() ? 'project-item-sticky' : 'project-item-normal' ?>" id="post-<?php the_ID(); ?>">
  <a href="<?php echo esc_url(get_permalink()); ?>" class="img">
    <?php
    $size = is_sticky() ? 'full' : 'medium';
    if (has_post_thumbnail()):
      echo get_the_post_thumbnail(get_the_ID(), $size);
    else:
      echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" />';
    endif;
    ?>
  </a>
  <div class="content">
    <h3 class="title"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
    <?php
    if (has_excerpt()): ?>
      <div class="excerpt">
        <?php the_excerpt(); ?>
      </div>
    <?php endif;
    ?>
    <p class="link"><a class="btn btn-primary" href="<?php echo esc_url(get_permalink()); ?>"><?php echo __('Detail') ?></a></p>
  </div>
</div>