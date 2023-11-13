<?php
function get_breadcrumb()
{

	// Settings
	$breadcrums_id = 'breadcrumbs';
	$breadcrums_class = 'breadcrumbs';
	$home_title = __('Home', 'winamco');
	$prefix = '';
	$productListPageLink = get_field('product_listing_page', pll_current_language('slug'));
	$homePageLink = get_field('home_page_link', pll_current_language('slug'));
	$home_id = $homePageLink->ID;
	// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
	$custom_taxonomy = 'category_product_post';

	// Get the query & post information
	global $post, $wp_query;
	// Do not display on the homepage
	if (!is_front_page()) {

		// Build the breadcrums
		echo '<div id="' . $breadcrums_id . '" class="' . $breadcrums_class . '"><ul>';

		// Home page
		echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_page_link($home_id) . '" title="' . $home_title . '">' . $home_title . '</a></li>';

		if (is_archive() && !is_tax() && !is_category() && !is_tag()) {
			$archive_title = post_type_archive_title($prefix, false);
			echo '<li class="item-current item-archive"><span class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</span></li>';

		} else if (is_home()) {
			echo '<li class="item-current item-home"><span class="bread-current">' . get_the_title(get_option('page_for_posts')) . '</span></li>';
		} else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

			// If post is a custom post type
			$post_type = get_post_type();
			$product_page_link = get_page_link($productListPageLink->ID);
			// If it is a custom post type display name and link
			if ($post_type && $post_type != 'post' && is_tax('category_product_post')) {
				echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $product_page_link . '" title="' . __('Products', 'winamco') . '">' . __('Products', 'winamco') . '</a></li>';
			}
			$custom_tax_name = get_queried_object()->name;
			echo '<li class="item-current item-last"><span class="bread-current bread-last">' . $custom_tax_name . '</span></li>';

		} else if (is_single()) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if ($post_type == 'product_post') {
				$product_page_link = get_page_link($productListPageLink->ID);
				echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $product_page_link . '" title="' . __('Products', 'winamco') . '">' . __('Products', 'winamco') . '</a></li>';
			}
			if ($post_type == 'project_post') {
				$projectPage = get_field('project_page_linnk', pll_current_language('slug'));
				$project_page_link = get_page_link($projectPage->ID);
				echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $project_page_link . '" title="' . __('Projects', 'winamco') . '">' . __('Projects', 'winamco') . '</a></li>';
			}

			// Get post category info
			$category = get_the_category();

			if (!empty($category)) {
				$allCat = get_the_category();
				$lastCat = array_reverse($allCat);
				$last_category = $lastCat[0];
				// Get last category post is in
				//$last_category = end(array_values($category));

				// Get parent any categories and create array
				$get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
				$cat_parents = explode(',', $get_cat_parents);

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach ($cat_parents as $parents) {
					$cat_display .= '<li class="item-cat">' . $parents . '</li>';
				}

			}

			// If it's a custom post type within a custom taxonomy
			$taxonomy_exists = taxonomy_exists($custom_taxonomy);
			if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

				$taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
				$cat_id = $taxonomy_terms[0]->term_id;
				$cat_nicename = $taxonomy_terms[0]->slug;
				$cat_link = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
				$cat_name = $taxonomy_terms[0]->name;

			}

			// Check if the post is in a category
			if (!empty($last_category)) {
				echo $cat_display;
				echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

				// Else if post is in a custom taxonomy
			} else if (!empty($cat_id)) {

				echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . get_page_link($productListPageLink->ID) . '/?taxanomy=' . $cat_id . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
				echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

			} else {

				echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';

			}

		} else if (is_category()) {
			// Category page
			$category_page = single_cat_title('', false);
			echo '<li class="item-current item-cat"><span class="bread-current bread-cat">' . $category_page . '</span></li>';

		} else if (is_page()) {

			// Standard page
			if ($post->post_parent) {

				// If child page, get parents
				$anc = get_post_ancestors($post->ID);

				// Get parents in the right order
				$anc = array_reverse($anc);

				// Parent page loop
				if (!isset($parents))
					$parents = null;
				foreach ($anc as $ancestor) {
					$parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
				}

				// Display parent pages
				echo $parents;

				// Current page
				echo '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';

			} else {

				// Just display current page if not parents
				echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';

			}

		} else if (is_tag()) {

			// Tag page

			// Get tag information
			$term_id = get_query_var('tag_id');
			$taxonomy = 'post_tag';
			$args = 'include=' . $term_id;
			$terms = get_terms($taxonomy, $args);
			$get_term_id = $terms[0]->term_id;
			$get_term_slug = $terms[0]->slug;
			$get_term_name = $terms[0]->name;

			// Display the tag name
			echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><span class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</span></li>';

		} elseif (is_day()) {

			// Day archive

			// Year link
			echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

			// Month link
			echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';

			// Day display
			echo '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</span></li>';

		} else if (is_month()) {

			// Month Archive

			// Year link
			echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

			// Month display
			echo '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</span></li>';

		} else if (is_year()) {

			// Display year archive
			echo '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</span></li>';

		} else if (is_author()) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata($author);

			// Display author name
			echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</span></li>';

		} else if (get_query_var('paged')) {

			// Paginated archives
			echo '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">' . __('Page') . ' ' . get_query_var('paged') . '</span></li>';

		} else if (is_search()) {

			// Search results page
			echo '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">' . __('Search', 'winamco') . '</span></li>';

		} elseif (is_404()) {

			// 404 page
			echo '<li>' . 'Error 404' . '</li>';
		}

		echo '</ul></div>';
	}

}

?>