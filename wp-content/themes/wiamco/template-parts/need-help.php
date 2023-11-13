<div class="help-form-block">
    <div class="inactive-box hide">
        <button type="button" class="btn btn-assistance">
            <img src="<?php echo get_template_directory_uri(); ?>/images/customer-support.png" alt="" />
            <h4>
                <?php echo pll_e('Require assistance', 'winamco') ?>?
            </h4>
            <span>
                <?php echo pll_e("Greetings, I'm Nguyen Tay Tai Nguyen, CEO of WINAM.", 'winamco') ?>
            </span>
        </button>
    </div>
    <div class="help-form hide" id="help-form-box">
        <div class="help-form__inner">
            <button type="button" class="btn btn-close" id="btn-close">&times;</button>
            <h2>
                <?php echo pll_e('Require assistance', 'winamco') ?>
            </h2>
            <p>
                <?php echo pll_e("Greetings, I'm Nguyen Tay Tai Nguyen, the General Director of WINAM. If you have any inquiries, please don't hesitate to contact me through this form. I commit to providing a personal response within a 24-hour timeframe.", 'winamco') ?>
            </p>
            <div id="help_form_status" class="help-form-status hidden" data-already-text="<?php echo pll_e("Contact information already sent", 'winamco'); ?>" data-invalid-list-text="<?php echo pll_e("Your list ID is invalid.", 'winamco'); ?>"></div>
            <form action="<?php echo get_template_directory_uri(); ?>/sendy/need-help.php" method="POST" accept-charset="utf-8" id="help-form">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" minlength="6" required class="form-control" placeholder="<?php echo pll_e('Name', 'winamco'); ?>" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">
                                <input type="email" name="email" id="email" required class="form-control" placeholder="<?php echo pll_e('Email', 'winamco'); ?>" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="tel" name="phone" id="phone" pattern="[0-9]{10,}" required class="form-control" placeholder="<?php echo pll_e('Phone number', 'winamco'); ?>" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="company" id="company" required class="form-control" placeholder="<?php echo pll_e('Company', 'winamco'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input type="text" name="city" id="city" required class="form-control" placeholder="<?php echo pll_e('City', 'winamco'); ?>" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <select id="region" name="region" class="form-control">
                                <option value="">
                                    <?php echo pll_e('Region', 'winamco'); ?>
                                </option>
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
                    <textarea name="message" id="message" minlength="11" required class="form-control" placeholder="<?php echo pll_e('Feel free to write your message or question here.', 'winamco'); ?>"></textarea>
                </div>
                <div style="display:none;">
                    <label for="hp">HP</label><br />
                    <input type="text" name="hp" id="hp" />
                </div>
                <input type="hidden" name="list" value="1oiV892xL9DC5HA251Q81fmw" />
                <input type="hidden" name="subform" value="yes" />
                <button type="submit" class="btn btn-primary btn-submit">
                    <?php echo pll_e('Submit', 'winamco'); ?>
                </button>
            </form>

        </div>
    </div>

    <div id="help-form__success" class="help-form__success hide">
        <button type="button" class="btn btn-close" id="btn-close-success">&times;</button>
        <h4>
            <?php echo pll_e("Thanks", 'winamco'); ?>
        </h4>
        <p>
            <?php echo pll_e("We'll be in touch soon", 'winamco'); ?>
        </p>
    </div>
</div>