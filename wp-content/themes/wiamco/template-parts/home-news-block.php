<?php
$featured_posts = get_field('news_event_listing');
$block_title = get_field('news_events_block_title');
if ($featured_posts):
    ?>
    <section class="home-news-block">
        <div class="container">
            <h2 class="primary-title">
                <?php echo $block_title; ?>
            </h2>
            <div class="home-news-slider">
                <?php foreach ($featured_posts as $post):
                    setup_postdata($post); ?>
                    <?php get_template_part('template-parts/content-news-home'); ?>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>