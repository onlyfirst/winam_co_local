<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage eurotramp
 * @since eurotramp 1.0
 */
?>
<div class="project-item__col">
  <div class="project-item">
    <div class="project-item__img">
      <?php
      $size = 'large';
      if (has_post_thumbnail()):
        echo get_the_post_thumbnail(get_the_ID(), $size);
      else:
        echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" />';
      endif;
      ?>
    </div>
    <div class="project-item__content">
      <?php
      $term_list = get_the_terms($post->ID, 'category_project_post');
      ?>
      <div class="project-item__categories">
        <?php foreach ($term_list as $term): ?>
          <div class="categrory"><a class="btn btn-white" href="<?php echo get_term_link($term->slug, 'category_project_post'); ?>"><?php echo $term->name; ?></a></div>
        <?php endforeach; ?>
      </div>
      <h3 class="project-item__title"><a href="<?php echo esc_url(get_permalink()); ?>">
          <?php the_title(); ?>
        </a>
      </h3>
    </div>
  </div>
</div>