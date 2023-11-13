<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Wdb
 * @since Wdb 1.0
 */
get_header();
$pageListing = get_locale() == 'vi' ? 340 : 338;
$productListPageLink = get_field('product_listing_page', pll_current_language('slug'));
$pageId = $productListPageLink->ID;
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail($pageId)) {
    $bannerUrl = get_the_post_thumbnail_url($pageId, 'full');
}
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <h2 class="page-title">
            <span>
                <?php echo get_the_title($pageId); ?>
            </span>
        </h2>
    </div>
</div>
<main class="site-main site-main--single-product">
    <div class="container">
        <?php echo get_breadcrumb() ?>

        <?php
        $terms = get_terms([
            'taxonomy' => 'category_product_post',
            'hide_empty' => false,
        ]);
        ?>
        <div class="project-categories">
            <h2 id="category-name">
                <?php echo pll_e('All Products', 'winamco') ?>
            </h2>
            <ul>
                <li><a href="<?php echo get_page_link($pageListing); ?>"><?php echo pll_e('All', 'winamco') ?></a></li>
                <?php
                foreach ($terms as $term):
                    ?>
                    <li><a href="<?php echo get_page_link($pageListing); ?>?taxanomy=<?php echo $term->term_id ?>"><?php echo $term->name; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>

        <?php
        // Start the loop.
        while (have_posts()):
            the_post();
            // Include the single post content template.
            get_template_part('template-parts/content-product-single');

            // End of the loop.
        endwhile;
        ?>

    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>