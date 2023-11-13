<?php
$pageId = get_locale() == 'vi' ? 177 : 174;
?>
<tr class="cart-item">
    <td colspan="7" class="no-cart">
        <?php __('No items in cart', 'winamco'); ?> <a href="<?php echo get_page_link($pageId) ?>"><?php __('Continue shoppping', 'winamco'); ?></a>
    </td>
</tr>