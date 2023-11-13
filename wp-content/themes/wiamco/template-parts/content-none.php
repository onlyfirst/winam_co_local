<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
?>

<div class="no-results not-found">
    <h1 class="primary-title">
        <?php pll_e('Nothing Found', 'winamco'); ?>
    </h1>

    <div class="page-content">
        <?php if (is_home() && current_user_can('publish_posts')): ?>

            <p>
                <?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'winamco'), esc_url(admin_url('post-new.php'))); ?>
            </p>

        <?php elseif (is_search()): ?>

            <p>
                <?php pll_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'winamco'); ?>
            </p>
            <?php get_search_form(); ?>

        <?php endif; ?>
    </div><!-- .page-content -->
</div><!-- .no-results -->