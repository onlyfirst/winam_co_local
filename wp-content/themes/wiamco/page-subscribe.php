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
Template Name: Subscribe
*/
get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail()) {
    $bannerUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<div class="banner-page " style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <h2 class="page-title"><span>
                <?php echo pll_e('Subscribe', 'winamco') ?>
            </span></h2>
    </div>
</div>
<main id="main" class="site-main site-main--subscribe">
    <div class="container">
        <?php echo get_breadcrumb() ?>
        <div class="subscribe-content">
            <?php if (have_posts()): ?>
                <?php while (have_posts()):
                    the_post();
                    the_content();
                endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>