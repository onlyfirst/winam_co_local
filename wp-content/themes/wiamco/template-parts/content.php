<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
$class = 'col-sm-6 col-md-4 news-item-col';
if ($args['class']) {
  $class = $args['class'];
}
?>
<div class="news-item-col <?php echo $class; ?>">
  <div class="news-item" itemscope="" itemtype="http://schema.org/Article">
    <a class="news-item__img" href="<?php echo get_permalink(); ?>" title="<?php the_title() ?>" itemprop="image">
      <?php
      if (has_post_thumbnail()):
        the_post_thumbnail('large');
      else:
        echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" />';
      endif;
      ?>
    </a>
    <div class="news-item__content">
      <div class="news-item__inner">
        <?php the_title(sprintf('<h3 class="news-item__title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
        <div class="news-item__date">
          <?php echo get_the_date(); ?>
        </div>
        <div class="news-item__desc" itemprop="articleBody">
          <?php
          if (has_excerpt()):
            the_excerpt();
          else:
            echo wp_trim_words(get_the_content(), 25);
          endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</div>