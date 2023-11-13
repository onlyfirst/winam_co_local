<?php
$logo_footer = get_field('logo_footer', pll_current_language('slug'));
$contact_us_title = get_field('contact_us_title', pll_current_language('slug'));
$contact_us_content = get_field('contact_us_content', pll_current_language('slug'));

$subscribe_title = get_field('subscribe_title', pll_current_language('slug'));
$subscribe_description = get_field('subscribe_description', pll_current_language('slug'));
$quckSupport = get_field('quick_support_content', pll_current_language('slug'));
?>
<?php get_template_part('template-parts/content-bottom'); ?>
<footer class="site-footer">
    <div class="content-footer">
        <div class="container">
            <div class="footer-logo"><img src="<?php echo $logo_footer['sizes']['medium']; ?>" alt="" /></div>
            <div class="row">
                <div class="col-md-3 col-sm-6 content-footer__about">
                    <div class="bottom-box__title">
                        <?php echo $contact_us_title; ?>
                    </div>
                    <div class="bottom-box__content">
                        <?php echo $contact_us_content; ?>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 content-footer__follow-us">
                    <div class="bottom-box__title">
                        <?php echo pll_e('Follow us', 'winamco'); ?>
                    </div>
                    <ul class="social-footer">
                        <?php if (get_theme_mod('site_facebook')): ?>
                            <li><a href="<?php echo get_theme_mod('site_facebook'); ?>" title="Facebook" target="_blank"><em class="social-icon circle link-facebook"></em>
                                    <?php echo pll_e('Like on Facebook', 'winamco') ?>
                                </a></li>
                        <?php endif; ?>
                        <?php if (get_theme_mod('site_twitter')): ?>
                            <li><a href="<?php echo get_theme_mod('site_twitter'); ?>" title="Twitter" target="_blank"><em class="social-icon circle link-twitter"></em>
                                    <?php echo pll_e('Follow on Twitter', 'winamco') ?>
                                </a></li>
                        <?php endif; ?>
                        <?php if (get_theme_mod('site_instagram')): ?>
                            <li><a href="<?php echo get_theme_mod('site_instagram'); ?>" title="Instagram" target="_blank"><em class="social-icon circle link-instagram"></em>
                                    <?php echo pll_e('Watch on Instagram', 'winamco') ?>
                                </a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 content-footer__menu">
                    <div class="bottom-box__title">
                        <?php echo pll_e('Usefull Link', 'winamco') ?>
                    </div>
                    <div class="bottom-box__list">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer-menu',
                                'menu_class' => 'bottom-menu',
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 content-footer__subscribe">
                    <div class="newsletter" id="newsletter">
                        <div class="bottom-box__title">
                            <?php echo $subscribe_title; ?>
                        </div>
                        <div class="bottom-box__content">
                            <?php echo $subscribe_description; ?>
                        </div>
                        <div class="emaillist">
                            <!-- <iframe src="<?php echo get_template_directory_uri(); ?>/subscribe.html" style="border: 0; height: 190px;"></iframe> -->
                            <form action="<?php echo get_template_directory_uri(); ?>/sendy/signup.php" method="POST" accept-charset="utf-8" id="subscription_form" class="subscription_form" target="_blank">
                                <div class="form-group">
                                    <input type="text" placeholder="<?php echo pll_e('Name', 'winamco') ?>" name="name" id="name" class="subscription_form__control" />
                                </div>
                                <div class="form-group">
                                    <input type="email" placeholder="<?php echo pll_e('Email', 'winamco') ?>" name="email" id="email" class="subscription_form__control" />
                                </div>
                                <div class="form-group">
                                    <input type="tel" name="Mobile" id="Mobile" placeholder="<?php echo pll_e('Mobile', 'winamco') ?>" class="subscription_form__control" />
                                </div>
                                <div style="display:none;">
                                    <label for="hp">HP</label><br />
                                    <input type="text" name="hp" id="hp" />
                                </div>
                                <input type="hidden" name="list" value="3XvH6m8ZpwH2dHKQhOvvYg" />
                                <input type="hidden" name="subform" value="yes" />
                                <button type="submit" class="btn btn-primary subscription_form__control_sunmit">
                                    <span>
                                        <?php echo pll_e('Subscribe', 'winamco') ?>
                                    </span>
                                </button>
                            </form>
                            <div id="subscription_form_status" data-success-text="<?php echo pll_e("Thank you for subscribing!", 'winamco'); ?>" data-already-text="<?php echo pll_e("Already subscribed.", 'winamco'); ?>" data-invalid-list-text="<?php echo pll_e("Your list ID is invalid.", 'winamco'); ?>" data-success-sub-text="<?php echo pll_e("Thank you Your subscription has now been successfully confirmed", 'winamco'); ?>" data-image="<?php echo get_template_directory_uri(); ?>/images/thumbs-up.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($quckSupport): ?>
                <div id="quick-support" class="quick-support">
                    <div class="quick-support__icon"><button type="button" class="btn-support" id="btn-support"></button></div>
                    <div class="quick-support__content">
                        <button type="button" class="btn-close" id="btn-close">&times;</button>
                        <?php echo $quckSupport; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <?php echo get_theme_mod('site_copyright'); ?>
        </div>
    </div>
    </div>
</footer>
<?php get_template_part('template-parts/need-help'); ?>
</div><!-- /.mainsite -->
</div><!-- /.wrapper -->
<?php wp_footer(); ?>
</body>

</html>