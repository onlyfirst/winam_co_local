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
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
	<div class="container">
		<h2 class="page-title">
			<span>
				<?php echo get_the_title($page_for_posts); ?>
			</span>
		</h2>
	</div>
</div>
<main class="site-main">
	<div class="container">
		<?php echo get_breadcrumb(); ?>
		<div class="news-detail">
			<?php if (has_post_thumbnail()): ?>
				<div class="img">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<?php
			while (have_posts()):
				the_post();
				get_template_part('template-parts/content', 'single');
			endwhile;
			?>
		</div>
		<div class="like-this-post">
			<h3>
				<?php echo pll_e('Like this post?', 'winamco'); ?>
			</h3>
			<p>
				<?php echo pll_e('Click the \'Like\' button and let us know, or share with a friend.', 'winamco'); ?>
			</p>
			<ul>
				<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_post_permalink(); ?>" class="share-post-icon fb"></a></li>
				<?php if (get_theme_mod('site_youtube')): ?>
					<li><a href="<?php echo get_theme_mod('site_youtube'); ?>" title="Youtube" target="_blank" class="share-post-icon yt">&nbsp;</a></li>
				<?php endif; ?>
				<li><a href="https://www.instagram.com/?url=<?php echo get_post_permalink(); ?>" target="_blank" rel="noopener" class="share-post-icon ins"></a></li>
			</ul>
		</div>
	</div>
</main><!-- .site-main -->

<?php get_footer(); ?>