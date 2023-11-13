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
Template Name: Catalog
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
    <div class="container">
        <?php echo get_breadcrumb() ?>
        <?php
        $catalog_listing = get_field('catalog_listing');
        if ($catalog_listing): ?>
            <div class="catalog-block">
                <div class="catalog-list">
                    <?php while (have_rows('catalog_listing')):
                        the_row();
                        $title = get_sub_field('catalog_item_title');
                        $image = get_sub_field('catalog_item_image');
                        $imageLink = $image ? $image['sizes']['large'] : get_template_directory_uri() . '/images/no-image.png';
                        $content = get_sub_field('catalog_item_desc');
                        $uploadType = get_sub_field('catalog_item_upload_type');
                        $fileLink = get_sub_field('file_url');
                        if ($uploadType == 'upload') {
                            $fileLink = get_sub_field('file_upload')['url'];
                        }
                        ?>
                        <div class="catalog-item">
                            <div class="catalog-item__inner">
                                <div class="catalog-item__img"><img src="<?php echo $imageLink; ?>" alt="<?php echo $image['alt']; ?>" /></div>
                                <h3 class="catalog-item__title">
                                    <?php echo $title; ?>
                                </h3>
                                <div class="catalog-item__content">
                                    <?php echo $content; ?>
                                </div>
                                <div class="catalog-item__link">
                                    <a href="<?php echo $fileLink; ?>" target="_blank" class="btn btn-warning">
                                        <?php echo pll_e('Download pdf', 'winamco'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>
        <?php endif; ?>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>