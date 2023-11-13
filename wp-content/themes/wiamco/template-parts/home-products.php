<?php
$featured_posts = get_field('related_product');
$featured_posts2 = get_field('related_product');
if ($featured_posts):
    ?>
    <section id="home-products-block" class="home-products-block">
        <div class="container-full">
            <div id="home-product-ajax">
                <div class="home-product-nav">
                    <?php $i = 0; ?>
                    <?php foreach ($featured_posts as $post):
                        setup_postdata($post);
                        if ($i === 0):
                            ?>
                            <?php get_template_part('template-parts/content-product-home'); ?>
                        <?php endif; ?>
                        <?php $i++; endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <div class="related-product-slider">
                <h3 class="related-product-slider__title">
                    <?php echo pll_e('Related Product', 'winamco'); ?>
                </h3>
                <div class="home-product-controls">
                    <?php $j = 0; ?>
                    <?php foreach ($featured_posts2 as $post2):
                        setup_postdata($post2);
                        $productImg = has_post_thumbnail($post2) ? get_the_post_thumbnail_url($post2, 'post-thumbnail') : get_template_directory_uri() . '/images/no-image.png';
                        $activeClass = $j === 0 ? ' active' : '';
                        ?>
                        <div data-id="<?php echo $post2->ID; ?>" class="img<?php echo $activeClass; ?>">
                            <img src="<?php echo $productImg; ?>" alt="" />
                        </div>
                        <?php $j++; endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>

    </section>
<?php endif; ?>