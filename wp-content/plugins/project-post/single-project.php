<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Wdb
 * @since Wdb 1.0
 */
get_header();
$queried_object = get_queried_object();
$pageId = get_locale() == 'vi' ? 154 : 23;
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail($pageId)) {
    $bannerUrl = get_the_post_thumbnail_url($pageId, 'full');
}
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <h2 class="page-title"><span>
                <?php echo get_the_title($pageId); ?>
            </span></h2>
    </div>
</div>
<main class="site-main site-main--single-project">
    <div class="container">
        <?php echo get_breadcrumb() ?>
        <?php
        // Start the loop.
        while (have_posts()):
            the_post();
            // Include the single post content template.
            get_template_part('template-parts/content-project-single');

            // End of the loop.
        endwhile;
        ?>
        <?php
        $similar_products = get_field('used_products');
        if ($similar_products) { ?>
            <div class="related-products-block">
                <h2>
                    <?php echo pll_e('Used products', 'winamco') ?>
                </h2>
                <div class="product-list product-list--related">
                    <?php
                    foreach ($similar_products as $post):
                        setup_postdata($post);
                        get_template_part('template-parts/content-product');
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>