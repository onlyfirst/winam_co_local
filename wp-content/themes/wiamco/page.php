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

get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail()) {
    $bannerUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <?php the_title('<h2 class="page-title"><span>', '</span></h2>'); ?>
    </div>
</div>
<main id="main" class="site-main <?php echo get_field('page_class') ?>">

    <div class="container">
        <?php echo get_breadcrumb() ?>
        <div class="primary-area">
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

        </div><!-- .primary-area -->
    </div>
</main><!-- .site-main -->


<?php get_footer(); ?>