<?php
$product_code = get_field('product_code');
$specifications = get_field('specifications');
$safety = $specifications['safety'];
$year = $specifications['year'];
$size = $specifications['size'];
if (has_post_thumbnail()):
    $thunbnail = get_the_post_thumbnail_url(get_the_ID(), 'medium');
else:
    $thunbnail = get_template_directory_uri() . '/images/no-image.png';
endif;
?>
<tr class="cart-item" data-id="<?php echo get_the_ID(); ?>">
    <td class="cart-item__col-product">
        <img src="<?php echo $thunbnail ?>" alt="" width="70px">
    </td>
    <td class="cart-item__col-code">
        <div class="code">
            <?php echo $product_code; ?>
        </div>
    </td>
    <td class="cart-item__col-name">
        <h3 class="title">
            <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
        </h3>
    </td>
    <td class="cart-item__col-details">
        <?php if ($safety | $year | $size): ?>
            <ul class="features">
                <?php if ($year): ?>
                    <li>
                        <div class="name">
                            <?php echo $year; ?>
                            <?php echo pll_e('Year', 'winamco') ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if ($size): ?>
                    <li>
                        <div class="name">
                            <?php echo $size; ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if ($safety): ?>
                    <li>
                        <div class="name">
                            <?php echo pll_e('Safety', 'winamco') ?>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </td>
    <td class="cart-item__col-qty"><button type="button" class="minus">-</button><span class="number">
            <?php echo $args['cartItems']['quantity']; ?>
        </span><button type="button" class="plus">+</button></td>
    <td class="cart-item__col-action">
        <button type="button" class="delete"> <img with="60" src="<?php echo get_template_directory_uri() . '/images/recycle-bin.png'; ?>" alt=" No image" /></button>
    </td>
</tr>