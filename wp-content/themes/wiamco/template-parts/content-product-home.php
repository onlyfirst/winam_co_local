<?php
$pageCartId = get_locale() == 'vi' ? 233 : 25;
?>
<div class="single-product single-product--home">
    <div class="row">
        <div class="col-md-6">
            <?php
            $images = get_field('product_gallery');
            if ($images): ?>
                <div data-gallery-home="" class="gallery">
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
        <div class="col-md-6 col-right">
            <div class="single-product__right">
                <h2 class="single-product__title">
                    <?php the_title(); ?>
                </h2>
                <?php
                $product_features = get_field('product_features');
                ?>
                <?php if ($product_features): ?>
                    <div class="single-product__features">
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
                <?php the_content(); ?>
                <div class="single-product__actions">
                    <div class="action-top">
                        <button type="button" class="btn btn-warning btn-add-to-cart" data-cart-id="<?php echo get_the_ID() ?>" data-href="<?php echo get_page_link($pageCartId); ?>">
                            <?php echo pll_e('Add to cart', 'winamco') ?><span><img src="<?php echo get_template_directory_uri() . '/images/shopping-cart.png'; ?>" alt="shopping cart" /></span>
                        </button>
                    </div>
                    <div class="action-bottom">
                        <?php if (get_theme_mod('site_hotline')): ?>
                            <div class="action">
                                <a href="<?php echo get_theme_mod('site_hotline'); ?>" class="btn btn-primary btn-call-us">
                                    <?php echo pll_e('Call us now', 'winamco') ?><span><img src="<?php echo get_template_directory_uri() . '/images/phone-call-primary.png'; ?>" alt="Phone" /></span>
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
                                <a href="<?php echo $fileLink; ?>" class="btn btn-primary btn-download">
                                    <?php echo pll_e('Download PDF', 'winamco') ?><span><img src="<?php echo get_template_directory_uri() . '/images/arrow-right-primary.png'; ?>" alt="" /></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>