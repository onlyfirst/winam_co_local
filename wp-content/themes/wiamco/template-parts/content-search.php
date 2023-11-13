<?php
/**
 * The template part for displaying results in search pages
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
?>

<article class="search-item">
	<a href="<?php echo esc_url(get_permalink()); ?>" class="img">
		<?php
		if (has_post_thumbnail()):
			echo get_the_post_thumbnail(get_the_ID(), 'medium');
		else:
			echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" />';
		endif;
		?>
	</a>
	<div class="content">
		<h3 class="title"><a href="<?php echo esc_url(get_permalink()); ?>" title="<?php the_title(); ?>"><?php the_title(); ?><?php if (is_sticky()): ?>
					<span class="sticky-post">&nbsp;</span>
				<?php endif; ?>
			</a></h3>
		<div class="excerpt">
			<?php
			if (has_excerpt()):
				the_excerpt();
			else:
				echo wp_trim_words(get_the_content(), 25);
			endif;
			?>
		</div>
	</div>

	<?php if ('post' === get_post_type()): ?>

		<div class="entry-footer">
			<?php // winamco_entry_meta(); ?>
			<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__('Edit<span class="screen-reader-text"> "%s"</span>', 'winamco'),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</div><!-- .entry-footer -->

	<?php else: ?>

		<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				__('Edit<span class="screen-reader-text"> "%s"</span>', 'winamco'),
				get_the_title()
			),
			'<div class="entry-footer"><span class="edit-link">',
			'</span></div><!-- .entry-footer -->'
		);
		?>

	<?php endif; ?>
</article><!-- #post-## -->