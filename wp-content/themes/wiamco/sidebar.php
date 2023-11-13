<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
$pageId = get_locale() == 'ms-MY' ? 420 : 16;
$args = array(
	'post_type' => 'page',
	'posts_per_page' => -1,
	'post_parent' => $pageId,
	'order' => 'ASC',
	'orderby' => 'menu_order'
);
$parent = new WP_Query($args);
$curentId = $post->ID;
?>
<aside class="about-sidebar">
	<?php
	if ($parent->have_posts()): ?>
		<ul>
			<?php while ($parent->have_posts()):
				$parent->the_post(); ?>
				<?php
				$currentClass = $curentId == get_the_ID() ? 'current' : '';
				?>
				<li><a class="<?php echo $currentClass; ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			<?php unset($parent); endif; ?>
	</ul>
</aside><!-- .sidebar .widget-area -->
<?php wp_reset_postdata(); ?>