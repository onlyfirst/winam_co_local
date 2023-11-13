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
Template Name: Products Listing
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
        <?php while (have_posts()): ?>
            <div class="term-description">
                <?php echo the_post(); ?>
            </div>
        <?php endwhile; ?>
        <?php
        $cat_id = '';
        if (isset($_GET['taxanomy'])) {
            $cat_id = $_GET['taxanomy'];
        }
        $terms = get_terms([
            'taxonomy' => 'category_product_post',
            'hide_empty' => false,
            'orderby' => 'term_order',
            'order' => 'ASC'
        ]);
        ?>
        <div class="project-categories">
            <h2 id="category-name">
                <?php echo __('Products', 'winamco'); ?>
            </h2>
            <ul>
                <li><a href="<?php echo get_page_link(get_the_ID()); ?>" class="<?php echo $cat_id == '' ? 'active' : '' ?>" data-product-filter="all">
                        <?php echo pll_e('All', 'winamco') ?>
                    </a></li>
                <?php
                foreach ($terms as $term):
                    $activeClass = $cat_id && $cat_id == $term->term_id ? 'active' : '';
                    ?>
                    <li><a href="#" data-product-filter="<?php echo $term->term_id; ?>" class="<?php echo $activeClass; ?>">
                            <?php echo $term->name; ?>
                        </a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>

        <?php
        if (have_posts()) {
            $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
            if (isset($_GET['page'])) {
                $paged = $_GET['page'];
            }

            $order = 'DESC';
            if (isset($_GET['sort']) === 'oldest') {
                $order = 'ASC';
            }
            $args = array(
                'post_type' => 'product_post',
                'posts_per_page' => 16,
                'paged' => $paged,
                'order' => $order,
                'orderby' => 'date'
            );
            $tax_query = array();
            if ($cat_id) {
                $args_cat = array(
                    array(
                        'taxonomy' => 'category_product_post',
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
            $loop = new WP_Query($args);
            $total = $loop->max_num_pages;
            ?>
            <div class="total_sort">
                <div class="total">
                    <span id="total-sort-number">
                        <?php echo $loop->post_count; ?>
                    </span>
                    <?php echo __('Product(s)', 'winamco') ?>
                </div>
                <div class="sort">
                    <label for="sortBy">
                        <?php echo pll_e('Sort by', 'winamco') ?>
                    </label>
                    <select name="sort" id="sortBy">
                        <option value="">
                            <?php echo pll_e('Default', 'winamco') ?>
                        </option>
                        <option value="newest">
                            <?php echo pll_e('Newest date', 'winamco') ?>
                        </option>
                        <option value="oldest">
                            <?php echo pll_e('Oldest date', 'winamco') ?>
                        </option>
                    </select>
                </div>
            </div>
            <?php

            echo '<div id="product-ajax-load">';
            echo '<div class="product-list">';
            while ($loop->have_posts()):
                $loop->the_post();
                get_template_part('template-parts/content-product');
            endwhile;
            echo '</div>';
            $big = 999999999;
            echo '<div class="footer-pagination"><div class="pagination" id="pagination" data-page="' . $page . '" data-max-page="' . $total . '">';
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