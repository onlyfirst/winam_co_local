<?php
$title = get_field('product_categories_title');
$desc = get_field('product_categories_description');
?>

<div class="product-categories-home-block">
    <div class="container">
        <h2 class="primary-title">
            <?php echo $title; ?>
        </h2>
        <p class="description">
            <?php echo $desc; ?>
        </p>
        <?php
        $pageListing = get_locale() == 'vi' ? 340 : 338;
        $terms = get_field('product_categories_listing');
        if ($terms): ?>
            <div class="product-category-home__list">
                <?php foreach ($terms as $term):
                    $cateImage = get_field('category_image', $term)
                        ?>
                    <a href="<?php echo get_page_link($pageListing); ?>?taxanomy=<?php echo $term->term_id ?>" class="product-category">
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
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>