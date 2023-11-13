<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <!-- autdesk -->
    <link rel="stylesheet" href="https://developer.api.autodesk.com/modelderivative/v2/viewers/7.0.0/style.min.css" type="text/css">
    <script src="https://developer.api.autodesk.com/modelderivative/v2/viewers/7.0.0/viewer3D.min.js"></script>
    <!-- end auto desk -->
    <?php if (is_singular() && pings_open(get_queried_object())): ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">
        <div id="sidebar">
            <div class="block-mainnav-mobile">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'mobile-menu',
                        'menu_class' => 'mobile-menu',
                        'container_class' => 'mobile-menu',
                    )
                );
                ?>
            </div>
        </div>
        <div class="mainsite <?php echo !is_front_page() ? 'child-page' : '' ?>" id="mainsite">
            <div class="toolbar" id="toolbar">
                <div class="container">
                    <div id="toolbar__inner" class="toolbar__inner">
                        <div class="toolbar-left">
                            <?php
                            $i = 0;
                            if (have_rows('supporter_list', pll_current_language('slug'))): ?>
                                <?php while (have_rows('supporter_list', pll_current_language('slug'))):
                                    the_row();
                                    $user = get_sub_field('user_name');
                                    $email = get_sub_field('user_email');
                                    $phone = get_sub_field('user_phone');
                                    $telegram = get_sub_field('user_telegram');
                                    $whatapp = get_sub_field('user_whats_app');
                                    $zalo = get_sub_field('user_zalo');
                                    $viber = get_sub_field('user_viber');
                                    $class = $i == 0 ? ' active' : '';
                                    ?>
                                    <div class="people-support<?php echo $class; ?>" id="people-support-<?php echo $i; ?>" data-id="<?php echo $i; ?>">
                                        <div class="people-support__title">
                                            <?php echo sprintf(__('Contact %1s for support: %2s', 'winamco'), '<a href="mailto:' . $email . '">' . $user . '</a>', '<a href="tel:' . $phone . '">' . trim($phone, ' ') . '</a>') ?>
                                        </div>
                                        <ul class="people-support__socials">
                                            <?php if ($phone): ?>
                                                <li><a href="tel:<?php echo trim($phone, ' '); ?>" title="Hotline" target="_blank" class="tooltip"><span class="support-icon support-icon--call">&nbsp;</span><span class="tooltiptext">Hotline</span>
                                                    </a></li>
                                            <?php endif; ?>
                                            <?php if ($telegram): ?>
                                                <li><a href="<?php echo $telegram; ?>" title="Hotline" target="_blank" class="tooltip"><span class="support-icon support-icon--telegram">&nbsp;</span><span class="tooltiptext">Telegram</span>
                                                    </a></li>
                                            <?php endif; ?>
                                            <?php if ($whatapp): ?>
                                                <li><a href="<?php echo $whatapp; ?>" title="Whatsapp" target="_blank" class="tooltip"><span class="support-icon support-icon--whatsapp">&nbsp;</span><span class="tooltiptext">Whatsapp</span>
                                                    </a></li>
                                            <?php endif; ?>
                                            <?php if ($zalo): ?>
                                                <li><a href="<?php echo $zalo; ?>" title="Zalo" target="_blank" class="tooltip"><span class="support-icon support-icon--zalo">&nbsp;</span><span class="tooltiptext">Zalo</span>
                                                    </a></li>
                                            <?php endif; ?>
                                            <?php if ($viber): ?>
                                                <li><a href="<?php echo $viber; ?>" title="Viber" target="_blank" class="tooltip"><span class="support-icon support-icon--viber">&nbsp;</span><span class="tooltiptext">Viber</span>
                                                    </a></li>
                                            <?php endif; ?>
                                            <?php if ($email): ?>
                                                <li><a href="mailto:<?php echo $email; ?>" title="Email" target="_blank" class="tooltip"><span class="support-icon support-icon--email">&nbsp;</span><span class="tooltiptext">Email</span>
                                                    </a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                    <?php $i++; endwhile; ?>
                            <?php endif; ?>
                        </div>
                        <div class="toolbar-right">
                            <div class="toolbar-right__socials">
                                <ul class="social-top">
                                    <?php if (get_theme_mod('site_facebook')): ?>
                                        <li><a href="<?php echo get_theme_mod('site_facebook'); ?>" title="Facebook" target="_blank" class="social-icon circle link-facebook">&nbsp;</a></li>
                                    <?php endif; ?>
                                    <?php if (get_theme_mod('site_youtube')): ?>
                                        <li><a href="<?php echo get_theme_mod('site_youtube'); ?>" title="Youtube" target="_blank" class="social-icon circle link-youtube">&nbsp;</a></li>
                                    <?php endif; ?>
                                    <?php if (get_theme_mod('site_instagram')): ?>
                                        <li><a href="<?php echo get_theme_mod('site_instagram'); ?>" title="Instagram" target="_blank" class="social-icon circle link-instagram">&nbsp;</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="toolbar__languages">
                    <div data-language="" class="box-language">
                        <div class="box-language__placeholder" id="language-placeholder">
                            <?php echo pll_current_language('name'); ?>
                        </div>
                        <ul>
                            <?php pll_the_languages(array('show_flags' => 1, 'show_names' => 1)); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <header class="header">
                <div class="container-fluid">
                    <div class="header__inner">
                        <div class="header-left">
                            <button class="flexMenuToggle mMenu" type="button"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                            <div class="logo" itemscope="" itemtype="https://schema.org/Brand">
                                <?php winamco_the_custom_logo(); ?>
                            </div>
                            <?php $pageCartID = get_locale() == 'vi' ? 233 : 25; ?>
                            <a href="<?php echo get_page_link($pageCartID); ?>" class="mobile-cart">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/shopping-cart-g.png" alt="" />
                                <span class="cart-icon"><i class="cart-number"></i></span>
                            </a>
                        </div>
                        <div class="header-right">
                            <nav class="nav" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
                                <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'menu_class' => 'primary-menu',
                                        'container_class' => 'nav-main'
                                    )
                                );
                                ?>
                            </nav>
                            <div class="header-right__search">
                                <?php echo get_search_form() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header><!-- .site-header -->