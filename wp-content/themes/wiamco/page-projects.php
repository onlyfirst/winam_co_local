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
Template Name: Projects
*/

get_header();
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail()) {
    $bannerUrl = get_the_post_thumbnail_url(get_the_ID(), 'full');
}

?>

<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
    <div class="container">
        <h2 class="page-title">
            <span>
                <?php echo get_the_title(); ?>
            </span>
        </h2>
    </div>
</div>
<main class="site-main">
    <div class="container">
        <?php echo get_breadcrumb() ?>
        <?php if (have_posts()): ?>
            <?php while (have_posts()):
                the_post(); ?>
                <div class="term-description">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php
        $terms = get_terms([
            'taxonomy' => 'category_project_post',
            'hide_empty' => false,
        ]);
        ?>
        <div class="project-categories">
            <h2 id="category-name">
                <?php echo pll_e('All Projects', 'winamco') ?>
            </h2>
            <ul>
                <li><a href="<?php echo get_page_link(); ?>" class="active">
                        <?php echo pll_e('All', 'winamco') ?>
                    </a></li>
                <?php
                foreach ($terms as $term):
                    ?>
                    <li><a href="<?php echo get_term_link($term->slug, 'category_project_post'); ?>" data-filter="<?php echo $term->slug; ?>">
                            <?php echo $term->name; ?>
                        </a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>

        <h2 class="project-heading">
            <?php echo pll_e('Recent projects', 'winamco'); ?>
        </h2>

        <div id="project-ajax-load-ajax-load">
            <div class="project-list">
                <?php
                $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
                $per_page = 12;
                $queried_object = get_queried_object();

                $args = array(
                    'post_type' => 'project_post',
                    'posts_per_page' => $per_page,
                    'paged' => $paged,
                    'lang' => pll_current_language(),
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                );
                $args_cat = array(
                    ''
                );
                $termIds = isset($_GET['terms']) ? $_GET['terms'] : null;
                if ($termIds) {

                    $args_cat = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category_project_post',
                                'field' => 'term_id',
                                'terms' => $termIds
                            )
                        )

                    );
                }
                $args = wp_parse_args($args_cat, $args);

                $args_tag = array(
                    ''
                );
                if (is_tag()) {
                    $args_tag = array(
                        'tag' => $queried_object->slug
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

                $args = wp_parse_args($args_tag, $args);

                $loop = new WP_Query($args);
                while ($loop->have_posts()):
                    $loop->the_post();
                    get_template_part('template-parts/content-project');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php
            $total_pages = $loop->max_num_pages;

            global $wp_query;
            $big = 999999999;
            $total = $loop->max_num_pages;
            echo '<div class="footer-pagination"><div class="pagination">';
            echo paginate_links(
                array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big), 'winamco')),
                    'format' => '?paged=%#%',
                    'current' => $paged,
                    'mid_size' => 4,
                    'type' => 'plain',
                    'total' => $total,
                    'before_page_number' => '',
                    'prev_next' => true,
                    'prev_text' => __('Prev', 'winamco'),
                    'next_text' => __('Next', 'winamco')
                )
            );
            echo '</div></div>';
            ?>
        </div>
    </div>
</main><!-- .site-main -->
<?php get_footer(); ?>