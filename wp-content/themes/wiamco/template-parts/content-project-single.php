<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
// $class = '';
// if ($args['class']) {
// 	$class = $args['class'];
// }
// $id = $args['id'] ? $args['id'] : '';
?>

<div class="single-project">
	<div class="single-project__inner">
		<?php
		$first_image = '';
		if (has_post_thumbnail()):
			$first_image = get_the_post_thumbnail_url(get_the_ID());
			?>
			<div class="single-project__img"><img src="<?php echo $first_image; ?>" /></div>
		<?php endif; ?>
		<?php the_title('<h2 class="single-project__title">', '</h2>'); ?>
		<div class="single-project__content">
			<?php the_content(); ?>
		</div>
		<?php
		$images = get_field('gallery');
		if ($images): ?>
			<div class="single-project__gallery row">
				<?php foreach ($images as $image): ?>
					<div class="col-xs-6 col-sm-4">
						<a data-lightbox="project-gallery" href="<?php echo esc_url($image['sizes']['large']); ?>" class="img"><img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div>