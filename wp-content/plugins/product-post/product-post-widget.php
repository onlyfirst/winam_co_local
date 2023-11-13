<?php
/*
Plugin Name: Products
Plugin URI: https://winam.com.vn
Description: Declares a plugin that will create a custom post type displaying aocuois.
Version: 3.1.8
Author: Onlyfirst
Author URI: https://winam.com.vn
License: GPLv1
*/

add_action('init', 'wa_create_post_type_product');

function compile_post_type_capabilities($singular = 'post', $plural = 'posts')
{
	return [
		'edit_post' => "edit_$singular",
		'read_post' => "read_$singular",
		'delete_post' => "delete_$singular",
		'edit_posts' => "edit_$plural",
		'edit_others_posts' => "edit_others_$plural",
		'publish_posts' => "publish_$plural",
		'read_private_posts' => "read_private_$plural",
		'read' => "read",
		'delete_posts' => "delete_$plural",
		'delete_private_posts' => "delete_private_$plural",
		'delete_published_posts' => "delete_published_$plural",
		'delete_others_posts' => "delete_others_$plural",
		'edit_private_posts' => "edit_private_$plural",
		'edit_published_posts' => "edit_published_$plural",
		'create_posts' => "edit_$plural",
	];
}

function wa_create_post_type_product()
{
	$infoLabelName = __('Products');
	$capabilities = compile_post_type_capabilities('custom_product', 'custom_products');
	register_post_type(
		'product_post',
		array(
			'labels' => array(
				'name' => $infoLabelName,
				'singular_name' => $infoLabelName
			),
			'public' => true,
			'menu_position' => 6,
			'has_archive' => false,
			'taxonomies' => array('category_product_post'),
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
			'rewrite' => array('slug' => 'product'),
			'capabilities' => $capabilities,
		)
	);

	// Add product category
	register_taxonomy(
		'category_product_post',
		'product_post',
		array(
			'has_archive' => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			// Needed for tax to appear in Gutenberg editor.
			'label' => _x('Product categories', 'admin menu', 'wa'),
			'singular_label' => _x('Product categories', 'admin menu', 'wa'),
			'query_var' => true,
			'public' => true,
			'show_ui' => true,
			'rewrite' => array('slug' => 'product-category'),
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'capabilities' => array(
				'manage_terms' => 'edit_category_products',
				'edit_terms' => 'edit_category_products',
				'delete_terms' => 'edit_category_products',
				'assign_terms' => 'edit_category_products'
			)
		)
	);
}

add_filter('template_include', 'include_template_function_product', 1);
function include_template_function_product($template_path)
{
	if (get_post_type() == 'product_post') {
		if (is_single()) {

			if ($theme_file = locate_template(array('single-product.php'))) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path(__FILE__) . 'single-product.php';
			}
		}
	}

	if (is_tax('category_product_post')) {
		if ($theme_file = locate_template(array('archive-product.php'))) {
			$template_path = $theme_file;
		} else {
			$template_path = plugin_dir_path(__FILE__) . 'archive-product.php';
		}
	}
	return $template_path;
}



/**
 * Remove default description column from category
 *
 */
function pr_remove_taxonomy_description($columns)
{
	if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category_product_post')
		return $columns;

	// unset the description columns
	if ($posts = $columns['description']) {
		unset($columns['description']);
	}
	return $columns;
}
add_filter('manage_edit-category_product_post_columns', 'pr_remove_taxonomy_description');

add_filter('map_meta_cap', 'custom_product_map_meta_cap', 10, 4);

function custom_product_map_meta_cap($caps, $cap, $user_id, $args)
{

	/* If editing, deleting, or reading a movie, get the post and post type object. */
	if ('edit_custom_product' == $cap || 'delete_custom_product' == $cap || 'read_custom_product' == $cap) {
		$post = get_post($args[0]);
		$post_type = get_post_type_object($post->post_type);

		/* Set an empty array for the caps. */
		$caps = array();
	}

	/* If editing a movie, assign the required capability. */
	if ('edit_custom_product' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	/* If deleting a movie, assign the required capability. */elseif ('delete_custom_product' == $cap) {
		if ($user_id == $post->post_author)
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	/* If reading a private movie, assign the required capability. */elseif ('read_custom_product' == $cap) {

		if ('private' != $post->post_status)
			$caps[] = 'read';
		elseif ($user_id == $post->post_author)
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;
}