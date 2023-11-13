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
Template Name: Page - Sidebar
*/

get_header(); ?>
<main id="main" class="site-main">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="primary-area">
					<h1 class="screen-reader-text">
						<?php echo get_bloginfo(); ?>
					</h1>
					<?php
					// Start the loop.
					while (have_posts()):
						the_post();

						// Include the page content template.
						get_template_part('template-parts/content', 'page');

						// If comments are open or we have at least one comment, load up the comment template.
						if (comments_open() || get_comments_number()) {
							comments_template();
						}

						// End of the loop.
					endwhile;
					?>
				</div>
			</div>
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</main><!-- .site-main -->
<?php get_footer(); ?>