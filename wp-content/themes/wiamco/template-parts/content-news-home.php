<div class="news-home-col">
    <div class="news-home" itemscope="" itemtype="http://schema.org/Article">
        <a class="news-home__img" href="<?php echo get_permalink(); ?>" title="<?php the_title() ?>" itemprop="image">
            <?php
            if (has_post_thumbnail()):
                the_post_thumbnail('large');
            else:
                echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No image" />';
            endif;
            ?>
            <?php
            $dateArr = explode(',', get_the_date());
            $dayMonth = explode(' ', $dateArr[0]);
            ?>
            <div class="news-home__date">
                <span class="day">
                    <?php echo $dayMonth[0]; ?>
                </span>
                <span class="month">
                    <?php echo $dayMonth[1]; ?>
                </span>
            </div>
        </a>
        <div class="news-home__content">
            <?php the_title(sprintf('<h3 class="news-home__title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
            <div class="news-home__desc" itemprop="articleBody">
                <?php
                if (has_excerpt()):
                    the_excerpt();
                else:
                    echo wp_trim_words(get_the_content(), 25);
                endif;
                ?>
            </div>
            <div class="news-home__link">
                <a href="<?php echo get_permalink(); ?>"><?php pll_e("Read more", 'winamco'); ?></a>
            </div>
        </div>
    </div>
</div>