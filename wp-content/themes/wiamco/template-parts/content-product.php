<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
$colunmClass = 'product-item__colunm';
$specifications = get_field('specifications');
$safety = $specifications['safety'];
$year = $specifications['year'];
$size = $specifications['size'];
$product_code = get_field('product_code');
if (has_post_thumbnail()):
    $thunbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
else:
    $thunbnail = get_template_directory_uri() . '/images/no-image.png';
endif;

?>
<div class="<?php echo $colunmClass; ?>">
    <div class="product-item" id="product-item-<?php the_ID(); ?>">
        <a href="<?php echo esc_url(get_permalink()); ?>" class="product-item__inner">
            <div class="product-item__img"><img src="<?php echo $thunbnail ?>" alt=""></div>
            <div class="product-item__content">
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
                <div class="product-item__code">
                    <?php echo $product_code; ?>
                </div>
                <h3 class="product-item__title">
                    <?php the_title(); ?>
                </h3>
            </div>
        </a>
    </div>
</div>