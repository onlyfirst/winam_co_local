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
Template Name: Products
*/

get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail()) {
    $bannerUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <h2 class="page-title">
            <span>
                <?php echo get_the_title(); ?>
            </span>
        </h2>
    </div>
</div>
<main class="site-main">
    <div class="container">
        <?php echo get_breadcrumb(); ?>

        <?php
        echo ' <div class="product-categories-top">';
        echo get_the_content();
        echo '</div>';
        ?>
        <div class="product-categories">
            <?php
            $terms = get_terms([
                'taxonomy' => 'category_product_post',
                'hide_empty' => false,
                'orderby' => 'term_order',
                'order' => 'ASC'
            ]);
            ?>
            <div class="product-category__list">
                <?php
                foreach ($terms as $term):
                    $cateImage = get_field('category_image', $term)
                        ?>
                    <a href="<?php echo get_term_link($term->slug, 'category_product_post'); ?>" class="product-category">
                        <div class="product-category__image">
                            <?php
                            if ($cateImage):
                                echo '<img src="' . $cateImage['sizes']['large'] . '" alt="' . $cateImage['alt'] . '" />';
                            else:
                                echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" />';
                            endif;
                            ?>
                        </div>
                        <h3 class="product-category__title">
                            <?php echo $term->name; ?>
                        </h3>
                    </a>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>