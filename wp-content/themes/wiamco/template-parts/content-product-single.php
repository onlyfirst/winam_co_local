<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage playground
 * @since playground 1.0
 */
$pageCartId = get_locale() == 'vi' ? 233 : 25;
?>
<div class="single-product">
    <div class="row">
        <div class="col-sm-6 col-md-7">
            <?php
            $images = get_field('product_gallery');
            if ($images): ?>
                <div data-gallery="" class="gallery">
                    <div class="slider slider-nav">
                        <?php foreach ($images as $image): ?>
                            <div class="product-img"><img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="slider-thumb slider-for">
                        <?php foreach ($images as $image): ?>
                            <div><img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" /></div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
            elseif (has_post_thumbnail()):
                echo '<div class="single-product__img">' . the_post_thumbnail('large') . '</div>';
            else:
                echo '<div class="single-product__img"><img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" /></div>';
                ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-6 col-md-5">
            <div class="single-product__right">
                <?php $product_code = get_field("product_code", get_the_ID()); ?>
                <?php if ($product_code): ?>
                    <div class="single-product__code">
                        <?php echo $product_code; ?>
                    </div>
                <?php endif; ?>
                <h2 class="single-product__title">
                    <?php the_title(); ?>
                </h2>
                <?php
                $specifications = get_field('specifications');
                $safety = $specifications['safety'];
                $year = $specifications['year'];
                $size = $specifications['size'];
                ?>
                <?php if ($safety | $year | $size): ?>
                    <div class="product-specifications">
                        <ul>
                            <?php if ($year): ?>
                                <li>
                                    <div class="img"><img src="<?php echo get_template_directory_uri() . '/images/boy-icon.png'; ?>" alt=""></div>
                                    <div class="name">
                                        <?php echo $year; ?>
                                        <?php echo pll_e('Year', 'winamco') ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ($size): ?>
                                <li>
                                    <div class="img"><img src="<?php echo get_template_directory_uri() . '/images/accelerometer-sensor.png'; ?>" alt=""></div>
                                    <div class="name">
                                        <?php echo $size; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ($safety): ?>
                                <li>
                                    <div class="img"><img src="<?php echo get_template_directory_uri() . '/images/athlete.png'; ?>" alt=""></div>
                                    <div class="name">
                                        <?php echo pll_e('Safety', 'winamco') ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php the_content(); ?>
                <?php
                $product_features = get_field('product_features');
                ?>
                <?php if ($product_features): ?>
                    <div class="single-product__features">
                        <h3>
                            <?php echo pll_e('Product Features', 'winamco') ?>
                        </h3>
                        <ul>
                            <?php
                            while (have_rows('product_features', get_the_ID())):
                                the_row();
                                $product_feature = get_sub_field('product_feature');
                                ?>
                                <li class="single-product__feature">
                                    <?php echo $product_feature; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="single-product__actions">
                    <div class="action-top">
                        <button type="button" class="btn btn-warning btn-add-to-cart" data-cart-id="<?php echo get_the_ID() ?>" data-href="<?php echo get_page_link($pageCartId); ?>">
                            <?php echo pll_e('Add to cart', 'winamco') ?><span><img src="<?php echo get_template_directory_uri() . '/images/shopping-cart.png'; ?>" alt="shopping cart" /></span>
                        </button>
                    </div>
                    <div class="action-bottom">
                        <?php if (get_theme_mod('site_hotline')): ?>
                            <?php $phone = get_theme_mod('site_hotline'); ?>
                            <div class="action">
                                <a href="tel:<?php echo str_replace(' ', '', $phone); ?>" class="btn btn-primary btn-call-us">
                                    <img src="<?php echo get_template_directory_uri() . '/images/phone-call-primary.png'; ?>" alt="Phone" />&nbsp;<?php echo $phone ?><span></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php
                        $uploadType = get_field('pdf_upload_type');
                        $fileLink = get_field('file_url');
                        if ($uploadType == 'upload') {
                            $fileLink = get_field('upload_file')['url'];
                        }
                        if ($fileLink):
                            ?>
                            <div class="action">
                                <a href="<?php echo $fileLink; ?>" class="btn btn-primary btn-download" target="_blank">
                                    <?php echo pll_e('Download PDF', 'winamco') ?><span><img src="<?php echo get_template_directory_uri() . '/images/arrow-right-primary.png'; ?>" alt="" /></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $similar_products = get_field('similar_products');
    if ($similar_products) { ?>
        <div class="related-products-block">
            <h2>
                <?php echo pll_e('Similar products', 'winamco') ?>
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

    <?php
    $post_id = get_the_ID();
    $args = array(
        'post_type' => 'project_post',
        'posts_per_page' => 2
    );

    $loop = new WP_Query($args);

    if ($loop->have_posts()) { ?>
        <div class="recent-project-block">
            <h2>
                <?php echo pll_e('Recent projects', 'winamco') ?>
            </h2>
            <div class="recent-projects project-list">
                <?php
                while ($loop->have_posts()):
                    $loop->the_post();
                    get_template_part('template-parts/content-project');
                endwhile;
                wp_reset_query();
                ?>
            </div>
        </div>
    <?php } ?>
</div>