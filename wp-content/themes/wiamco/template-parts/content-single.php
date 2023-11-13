<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content post-single">
        <div class="meta">
            <span class="date">
                <?php echo get_the_date(); ?>
            </span>
            <div class="share">
                <?php theShareSocial() ?>
            </div>
        </div>
        <?php
        the_title('<h1 class="news-detail__title">', '</h1>');
        the_content();
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->