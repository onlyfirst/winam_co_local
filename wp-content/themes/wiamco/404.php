<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage cos
 * @since cos 1.0
 */

get_header(); ?>

<main id="main" class="site-main" role="main">
	<div class="container">
		<section class="error-404 not-found">
			<p class="page-title font-large">404</p>
			<h1 class="error-text">
				<?php pll_e('Oh! This page could not be found.', 'teecoin'); ?>
			</h1>
		</section><!-- .error-404 -->
	</div>
</main><!-- .site-main -->
<?php get_footer(); ?>