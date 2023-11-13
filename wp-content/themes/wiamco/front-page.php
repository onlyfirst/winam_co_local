<?php
get_header(); ?>
<div class="slideshow">
    <?php
    $slider = get_field('home_banner');

    if ($slider) {
        echo do_shortcode('[ttslickslider cat="' . $slider->slug . '" posts_per_page="10"]');
    }
    ?>
    <div class="social-home">
        <ul>
            <?php if (get_theme_mod('site_email')): ?>
                <li class="tooltip"><a href="<?php echo get_theme_mod('site_email'); ?>" title="<?php echo get_theme_mod('site_email'); ?>" class="tooltip link-email"><em class="fa fa-envelope"></em></a><span class="tooltiptext">
                        <?php echo pll_e('Mail to', 'Mail to') ?>:
                        <?php echo get_theme_mod('site_email'); ?>
                    </span></li>
            <?php endif; ?>
            <?php if (get_theme_mod('site_hotline')): ?>
                <li class="tooltip"><a href="<?php echo get_theme_mod('site_hotline'); ?>" title="<?php echo get_theme_mod('site_hotline'); ?>" data-toggle="tooltip" class=" tooltip link-hotline"><em class="fa fa-phone"></em></a><span class="tooltiptext">
                        Hotline:
                        <?php echo get_theme_mod('site_hotline'); ?>
                    </span></li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php
get_template_part('template-parts/home-service');
get_template_part('template-parts/home-categories');
get_template_part('template-parts/home-about');
get_template_part('template-parts/home-products');
get_template_part('template-parts/home-news-block');

get_footer(); ?>