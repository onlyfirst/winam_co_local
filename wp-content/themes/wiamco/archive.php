<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage winamco
 * @since Base themes 1.0
 */

get_header();
$page_for_posts = get_option('page_for_posts');
$bannerUrl = get_template_directory_uri() . '/images/bg-banner.png';
if (has_post_thumbnail($page_for_posts)) {
  $bannerUrl = get_the_post_thumbnail_url($page_for_posts, 'full');
}
?>
<div class="banner-page" style="background-image: url(<?php echo $bannerUrl; ?>);">
  <div class="container">
    <h2 class="page-title">
      <span>
        <?php echo get_the_title($page_for_posts); ?>
      </span>
    </h2>
  </div>
</div>
<main class="site-main">
  <div class="news-page">
    <div class="container">
      <?php echo get_breadcrumb(); ?>
      <?php
      $sticky = get_option('sticky_posts');
      if (!empty($sticky)) {
        // optional: sort the newest IDs first
        rsort($sticky);
        // override the query
        $args = array(
          'post__in' => $sticky
        );
        $loopSticky = new WP_Query($args);
        if ($loopSticky->have_posts()):
          echo '<div class="news-stickies">';
          while ($loopSticky->have_posts()):
            $loopSticky->the_post();
            get_template_part('template-parts/content-sticky', get_post_format());
          endwhile;
          echo '</div>';
          wp_reset_postdata();
        endif;
      }
      ?>
      <?php

      $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
      $args = array(
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $paged,
        'post__not_in' => get_option('sticky_posts')
      );
      $loop = new WP_Query($args);
      if ($loop->have_posts()):
        // Start the loop.
        echo '<div class="news-list row">';
        while ($loop->have_posts()):
          $loop->the_post();
          get_template_part('template-parts/content');
          // End the loop.
        endwhile;
        echo '</div>';

        $total_pages = $loop->max_num_pages;
        $current_page = max(1, get_query_var('paged'));
        echo '<div class="footer-pagination"><div class="pagination">' . paginate_links(
          array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text' => __('&lt;&lt;'),
            'next_text' => __('&gt;&gt;')
          )
        ) . '</div></div>';
        wp_reset_postdata();
        // If no content, include the "No posts found" template.
      else:
        get_template_part('template-parts/content', 'none');
      endif;
      ?>
    </div>
  </div>
</main>
<?php get_footer(); ?>