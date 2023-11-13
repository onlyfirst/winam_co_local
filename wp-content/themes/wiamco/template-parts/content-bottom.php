<?php
$call_us_title = get_field('please_call_us__title', pll_current_language('slug'));
$call_us_tell = get_field('please_call_us_phone', pll_current_language('slug'));

if ($call_us_tell || $call_us_title):
    ?>
    <div class="content-bottom">
        <div class="container">
            <div class="content-bottom__inner">
                <h3 class="content-bottom__title">
                    <?php echo $call_us_title; ?>
                </h3>
                <div class="content-bottom__content">
                    <a class="btn btn--phone-call" href="tel:<?php echo $call_us_tell; ?>"><?php echo $call_us_tell; ?></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>