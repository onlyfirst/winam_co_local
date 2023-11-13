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
Template Name: Services
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
    <?php
    $service_listing = get_field('service_listing');
    if ($service_listing): ?>
        <div class="services-block">
            <div class="container">
                <div class="services-list">
                    <?php while (have_rows('service_listing')):
                        the_row();
                        $title = get_sub_field('service_item_title');
                        $color = get_sub_field('service_item_title_color');
                        $icon = get_sub_field('service_item_icon');
                        $image = get_sub_field('service_item_image');
                        $content = get_sub_field('service_item_desc');
                        ?>
                        <div class="service-item">
                            <div class="row">
                                <div class="col-md-6 service-item__left">
                                    <div class="service-item__header">
                                        <div class="service-item__icon"><img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="<?php echo $icon['alt']; ?>" /></div>
                                        <h3 class="service-item__title" data-color="<?php echo $color; ?>">
                                            <?php echo $title; ?>
                                        </h3>
                                    </div>
                                    <div class="service-item__content">
                                        <?php echo $content; ?>
                                    </div>
                                </div>
                                <div class="col-md-6 service-item__image"><img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" /></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main><!-- .site-main -->
<?php get_footer(); ?>