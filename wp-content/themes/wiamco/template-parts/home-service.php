<?php
$service_listing = get_field('service_listing');
if ($service_listing): ?>
    <div class="services-home-block">
        <div class="container">
            <div class="services-home-list">
                <?php while (have_rows('service_listing')):
                    the_row();
                    $title = get_sub_field('service_item_title');
                    $color = get_sub_field('service_item_title_color');
                    $icon = get_sub_field('service_item_icon');
                    $content = get_sub_field('service_item_desc');
                    $link = get_sub_field('service_item_link');
                    if ($link) {
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    }
                    ?>
                    <div class="service-home-item">
                        <?php if ($link): ?>
                            <a href="<?php echo $link_url; ?>" class="service-home-item__inner">
                            <?php else: ?>
                                <div class="service-home-item__inner">
                                <?php endif; ?>
                                <div class="service-home-item__icon"><img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="<?php echo $icon['alt']; ?>" /></div>
                                <h3 class="service-home-item__title" data-color="<?php echo $color; ?>">
                                    <?php echo $title; ?>
                                </h3>
                                <div class="service-home-item__content">
                                    <?php echo $content; ?>
                                </div>
                                <?php if ($link): ?>
                                    <div class="service-home-item__link">
                                        <?php echo esc_html($link_title); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($link): ?>
                            </a>
                        <?php else: ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    </div>
<?php endif; ?>