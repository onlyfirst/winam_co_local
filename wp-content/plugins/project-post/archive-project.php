<?php
get_header();
$queried_object = get_queried_object();
$bannerImg = get_template_directory_uri() . '/images/bg-banner.png';
$pageId = get_locale() == 'vi' ? 154 : 23;
if (has_post_thumbnail($pageId)) {
    $bannerImg = get_the_post_thumbnail_url($pageId, 'full');
}
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerImg; ?>);">
    <div class="container">
        <h2 class="page-title">
            <?php echo __('Projects', 'wa'); ?>
        </h2>
    </div>
</div>
<main class="site-main">
    <div class="container">
        <?php echo get_breadcrumb() ?>

        <?php
        $terms = get_terms([
            'taxonomy' => 'category_project_post',
            'hide_empty' => false,
        ]);
        ?>
        <div class="project-categories">
            <h2 id="category-name">
                <?php echo $queried_object->name; ?>
            </h2>
            <ul>
                <li><a href="<?php echo get_page_link($pageId); ?>">
                        <?php echo pll_e('All', 'winamco') ?>
                    </a></li>
                <?php
                foreach ($terms as $term):
                    $activeClass = $term->term_id === $queried_object->term_id ? 'active' : '';
                    ?>
                    <li><a href="<?php echo get_term_link($term->slug, 'category_project_post'); ?>" data-filter="<?php echo $term->slug; ?>" class="<?php echo $activeClass ?>">
                            <?php echo $term->name; ?>
                        </a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>

        <?php if (has_term()): ?>
            <div class="term-description">
                <?php echo term_description(); ?>
            </div>
        <?php endif; ?>
        <?php
        if (have_posts()) {
            $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
            if (isset($_GET['page'])) {
                $paged = $_GET['page'];
            }
            $queried_object = get_queried_object();
            $args = array(
                'post_type' => 'project_post',
                'posts_per_page' => 12,
                'paged' => $paged,
            );

            $tax_query = array();
            if (is_tax()) {
                $cat_id = $queried_object->term_id;
                $taxonomy = $queried_object->taxonomy;
                $args_cat = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => $cat_id
                    )
                );
                array_push($tax_query, $args_cat);
            }
            if (count($tax_query) > 0) {
                $args = wp_parse_args(
                    array(
                        'relation' => 'AND',
                        'tax_query' => array($tax_query),
                    ),
                    $args
                );
            }
            // meta query
            $meta_query = array();

            if (count($meta_query) > 0) {
                $args = wp_parse_args(
                    array(
                        'meta_query' => array($meta_query),
                    ),
                    $args
                );
            }
            $loop = new WP_Query($args);
            $total = $loop->max_num_pages;

            echo '<div id="project-ajax-load-ajax-load">';
            echo '<div class="project-list">';
            while ($loop->have_posts()):
                $loop->the_post();
                get_template_part('template-parts/content-project');
            endwhile;
            echo '</div>';
            $big = 999999999;
            echo '<div class="footer-pagination"><div class="pagination">';
            echo paginate_links(
                array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big), 'wa')),
                    'format' => '?paged=%#%',
                    'current' => $paged,
                    'mid_size' => 4,
                    'type' => 'plain',
                    'total' => $total,
                    'before_page_number' => '',
                    'prev_next' => true,
                    'prev_text' => __('Prev', 'wa'),
                    'next_text' => __('Next', 'wa')
                )
            );
            echo '</div></div>';
            echo '</div>';
            wp_reset_postdata();
        } else {
            get_template_part('template-parts/content', 'none');
        }
        ?>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>