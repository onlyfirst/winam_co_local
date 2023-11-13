<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
/*
Template Name: Contact us
*/

get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail()) {
    $bannerUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
$bg_main_contact = get_field('background_contact_form');
?>

<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <?php the_title('<h2 class="page-title"><span>', '</span></h2>'); ?>
    </div>
</div>
<main class="site-main site-main--contact">
    <div class="container">
        <?php echo get_breadcrumb() ?>
        <?php
        $contactMap = get_field('contact_map');
        if ($contactMap):
            ?>
            <div class="contact-map">
                <?php echo $contactMap; ?>
            </div>
        <?php endif; ?>
        <div class="form-contact">
            <form action="<?php echo get_template_directory_uri(); ?>/sendy/contact.php" method="POST" accept-charset="utf-8" id="contact-form">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">
                                <?php echo pll_e('Name', 'winamco'); ?><span class="required-label" aria-hidden="true">*</span>
                            </label>
                            <input type="text" name="name" id="name" minlength="6" required class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="Mobile">
                                <?php echo pll_e('Phone number', 'winamco'); ?><span class="required-label" aria-hidden="true">*</span>
                            </label>
                            <input type="tel" name="Mobile" id="Mobile" pattern="[0-9]{10,}" required class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">
                                <?php echo pll_e('Email', 'winamco'); ?><span class="required-label" aria-hidden="true">*</span>
                            </label>
                            <input type="email" name="email" id="email" required class="form-control" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="REGION">
                                <?php echo pll_e('Region', 'winamco'); ?><span class="required-label" aria-hidden="true">*</span>
                            </label>
                            <select id="REGION" name="REGION" class="form-control">
                                <option value="North America">North America</option>
                                <option value="Europe">Europe</option>
                                <option value="Asia">Asia</option>
                                <option value="South America">South America</option>
                                <option value="Africa">Africa</option>
                                <option value="Australia">Australia</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Middle East">Middle East</option>
                                <option value="Pacific Islands">Pacific Islands</option>
                                <option value="Caribbean">Caribbean</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="MESSAGE">
                        <?php echo pll_e('Message', 'winamco'); ?><span class="required-label" aria-hidden="true">*</span>
                    </label>
                    <textarea name="MESSAGE" id="MESSAGE" minlength="11" required class="form-control"></textarea>
                </div>
                <div style="display:none;">
                    <label for="hp">HP</label><br />
                    <input type="text" name="hp" id="hp" />
                </div>
                <input type="hidden" name="list" value="9yIZ892zcMV763HRigmnn86ikg" />
                <input type="hidden" name="subform" value="yes" />
                <button type="submit" class="btn btn-primary">
                    <?php echo pll_e('Submit', 'winamco'); ?>
                </button>
            </form>
            <div id="contact_form_status" class="form-status" data-success-text="<?php echo pll_e("Contact information has been sent. Thank you!", 'winamco'); ?>" data-already-text="<?php echo pll_e("Contact information already sent", 'winamco'); ?>" data-invalid-list-text="<?php echo pll_e("Your list ID is invalid.", 'winamco'); ?>"></div>
        </div>
        <div class="contact-content">
            <?php
            while (have_posts()):
                the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</main>
<?php get_footer(); ?>