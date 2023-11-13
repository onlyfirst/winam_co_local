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
Template Name: Cart
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
<main id="main" class="site-main">
    <div class="container">
        <?php echo get_breadcrumb() ?>
        <div class="primary-area">
            <?php
            // Start the loop.
            while (have_posts()):
                the_post();
                echo get_the_content();
                // End of the loop.
            endwhile;
            ?>
            <div class="responsive-table">
                <div id="cart-table">

                </div>
            </div>
            <div class="contact-from-cart">
                <?php echo do_shortcode('[cart_form]'); ?>

                <div id="cart-message" data-invalid-captcha="<?php echo __('Invalid captcha!', 'winamco'); ?>" data-empty-captcha="<?php echo __('Please fill up captcha field!', 'winamco'); ?>" data-invalid-list-text="<?php echo pll_e("Your list ID is invalid.", 'winamco'); ?>" data-already-text="<?php echo pll_e("Contact information already sent", 'winamco'); ?>" data-success-text="<?php echo pll_e("Order information has been sent. Thank you!", 'winamco'); ?>"></div>
            </div>
        </div><!-- .primary-area -->
    </div>
</main><!-- .site-main -->


<?php get_footer(); ?>