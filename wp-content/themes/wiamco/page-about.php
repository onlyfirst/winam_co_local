<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
/*
Template Name: About Us
*/
get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail()) {
	$bannerUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<div class="banner-page " style="background-image: url(<?php echo $bannerUrl; ?>);">
	<div class="container">
		<?php the_title('<h2 class="page-title"><span>', '</span></h2>'); ?>
	</div>
</div>
<main id="main" class="site-main">
	<div class="about-top">
		<div class="container">
			<?php echo get_breadcrumb() ?>
			<div class="row">
				<?php
				$about_top_image = get_field('about_top_image');
				$about_top_image_caption = $about_top_image['about_top_image_caption'];
				$about_top_image_img = $about_top_image['about_top_image_img'];
				?>
				<div class="col-md-4">
					<div class="about-top__image">
						<figure>
							<figcaption>
								<?php echo $about_top_image_caption; ?>
							</figcaption>
							<img src="<?php echo $about_top_image_img['sizes']['large']; ?>" alt="<?php echo $about_top_image_img['alt']; ?>">
						</figure>
					</div>
				</div>
				<div class="col-md-8">
					<div class="page-content">
						<?php
						// Start the loop.
						while (have_posts()):
							the_post();
							the_content();
						endwhile;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	$block_title = get_field('what_we_do_title');
	$block_desc = get_field('what_we_do_description');
	$what_we_do_listing = get_field('what_we_do_listing');
	if ($what_we_do_listing): ?>
		<div class="what-we-do-block">
			<div class="container">
				<h2 class="what-we-do-block__title">
					<?php echo $block_title; ?>
				</h2>
				<p class="what-we-do-block__lead">
					<?php echo $block_desc; ?>
				</p>
				<div class="what-we-do-list">
					<?php while (have_rows('what_we_do_listing')):
						the_row();
						$title = get_sub_field('what_we_do_item_title');
						$image = get_sub_field('what_we_do_item_icon');
						$content = get_sub_field('what_we_do_item_desc');
						?>
						<div class="what-we-do">
							<div class="what-we-do__box">
								<div class="what-we-do__image"><img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo $image['alt']; ?>" /></div>
								<h3 class="what-we-do__title">
									<?php echo $title; ?>
								</h3>
								<div class="what-we-do__content">
									<?php echo $content; ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php
	$service_listing = get_field('service_listing');
	if ($service_listing): ?>
		<div class="service-block">
			<div class="service-list">
				<?php while (have_rows('service_listing')):
					the_row();
					$title = get_sub_field('service_item_title');
					$image = get_sub_field('service_item_image');
					$content = get_sub_field('service_item_description');
					?>
					<div class="service-about-item">
						<div class="service-about-item__image"><img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" /></div>
						<div class="service-about-item__right">
							<div class="container">
								<div class="service-about-item__inner">
									<h3 class="service-about-item__title">
										<?php echo $title; ?>
									</h3>
									<div class="service-about-item__content">
										<?php echo $content; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>
</main><!-- .site-main -->
<?php get_footer(); ?>