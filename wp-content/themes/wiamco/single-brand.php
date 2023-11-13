<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
get_header();
$page_for_posts = get_option('page_for_posts');
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail($page_for_posts)) {
	$bannerUrl = get_the_post_thumbnail_url($page_for_posts, 'full');
}
$queried_object = get_queried_object();
$logo = get_field('logo', $queried_object);
$content = get_field('brand_content', $queried_object);
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
	<div class="container">
		<h2 class="page-title">
			<?php echo pll_e('Brand distribution', 'winamco'); ?>
		</h2>
	</div>
</div>
<main class="site-main">
	<div class="container">
		<?php echo get_breadcrumb(); ?>
		<div class="row">
			<div class="col-md-8 col-md-push-4">
				<div class="brand-item">
					<?php if ($logo): ?>
						<div class="brand-item__img">
							<img src="<?php echo $logo['sizes']['large']; ?>" />
						</div>
					<?php endif; ?>
					<?php
					echo $content
						?>
				</div>
			</div>
			<div class="col-md-4 col-md-pull-8">
				<?php get_sidebar('brand'); ?>
			</div>
		</div>
	</div>
</main><!-- .site-main -->

<?php get_footer(); ?>