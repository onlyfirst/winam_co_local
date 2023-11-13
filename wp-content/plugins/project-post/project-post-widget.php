<?php
/*
Plugin Name: Projects
Plugin URI: https://winam.com.vn
Description: Declares a plugin that will create a custom post type displaying aocuois.
Version: 3.1.8
Author: Onlyfirst
Author URI: https://winam.com.vn
License: GPLv1
*/

add_action('init', 'wa_create_post_type_project');

function wa_create_post_type_project()
{
	$infoLabelName = __('Projects');
	register_post_type(
		'project_post',
		array(
			'labels' => array(
				'name' => $infoLabelName,
				'singular_name' => $infoLabelName
			),
			'public' => true,
			'menu_position' => 6,
			'has_archive' => false,
			'taxonomies' => array('category_project_post'),
			'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
			'rewrite' => array('slug' => 'project')
		)
	);

	// Add Project category
	register_taxonomy(
		'category_project_post',
		'project_post',
		array(
			'has_archive' => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			// Needed for tax to appear in Gutenberg editor.
			'label' => _x('Project categories', 'admin menu', 'wa'),
			'singular_label' => _x('Project categories', 'admin menu', 'wa'),
			'query_var' => true,
			'public' => true,
			'show_ui' => true,
			'rewrite' => array('slug' => 'project-category'),
			'show_admin_column' => true,
			'show_in_nav_menus' => true,

		)
	);
}

add_filter('template_include', 'include_template_function_project', 1);
function include_template_function_project($template_path)
{
	if (get_post_type() == 'project_post') {
		if (is_single()) {

			if ($theme_file = locate_template(array('single-Project.php'))) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path(__FILE__) . 'single-project.php';
			}
		}
	}

	if (is_tax('category_project_post')) {
		if ($theme_file = locate_template(array('archive-project.php'))) {
			$template_path = $theme_file;
		} else {
			$template_path = plugin_dir_path(__FILE__) . 'archive-project.php';
		}
	}
	return $template_path;
}

function wpse288130_rewrite_rules()
{

	add_rewrite_rule('^(.?.+?)/page/(\d)$', 'index.php?pagename=$matches[1]&paged=$matches[2]', 'top');

}
add_action('init', 'wpse288130_rewrite_rules');


/**
 * Remove default description column from category
 *
 */
function jw_remove_taxonomy_description($columns)
{
	if (!isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category_project_post')
		return $columns;

	// unset the description columns
	if ($posts = $columns['description']) {
		unset($columns['description']);
	}
	return $columns;
}
add_filter('manage_edit-category_project_post_columns', 'jw_remove_taxonomy_description');