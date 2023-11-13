<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
?>

<li class="post-item" id="post-<?php the_ID(); ?>" <?php post_class(); ?>><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>