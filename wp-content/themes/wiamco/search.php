<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */

get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
	<div class="container">
		<h2 class="page-title">
			<span>
				<?php echo pll_e('Search', 'winamco'); ?>
			</span>
		</h2>
	</div>
</div>
<main id="main" class="site-main">
	<div class="container">
		<?php echo get_breadcrumb() ?>
		<div class="primary-area search-area">
			<?php if (have_posts()): ?>

				<div class="page-header">
					<h1 class="page-title">
						<?php printf(__('Search Results for: %s', 'winamco'), '<span>' . esc_html(get_search_query()) . '</span>'); ?>
					</h1>
				</div><!-- .page-header -->
				<div class="search-list">
					<?php
					// Start the loop.
					while (have_posts()):
						the_post();

						get_template_part('template-parts/content', 'search');
					endwhile; ?>
				</div>
				<?php
				// Previous/next page navigation.
				echo '<div class="footer-pagination"><div class="pagination">';
				the_posts_pagination(
					array(
						'prev_text' => __('Previous page', 'winamco'),
						'next_text' => __('Next page', 'winamco'),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'winamco') . ' </span>',
					)
				);
				echo '</div></div>';

			// If no content, include the "No posts found" template.
		else:
			get_template_part('template-parts/content', 'none');

		endif;
		?>
		</div><!-- .primary-area -->
	</div>
</main><!-- .site-main -->

<?php get_footer(); ?>