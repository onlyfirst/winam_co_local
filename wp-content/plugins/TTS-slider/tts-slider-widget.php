<?php
/*
Plugin Name: TTS Slider
Plugin URI: http://nepbean.com/
Description: Declares a plugin that will create a custom post type displaying slick-sliders.
Version: 1.0.0
Author: WDS
Author URI: http://nepbean.com/
License: GPLv1
*/

add_action('init', 'nb_create_post_type_image');

function nb_create_post_type_image()
{
	$infoLabelName = __('TTS Slider', 'tts-slider');
	register_post_type(
		'slick-slider',
		array(
			'labels' => array(
				'name' => $infoLabelName,
				'singular_name' => $infoLabelName
			),
			'public' => true,
			'menu_position' => 6,
			'has_archive' => true,
			'taxonomies' => array('slick_slider_category'),
			'supports' => array('title', 'thumbnail', 'excerpt'),

		)
	);

	register_taxonomy(
		'slick_slider_category',
		'slick-slider',
		array(
			'hierarchical' => true,
			'parent_item' => null,
			'parent_item_colon' => null,
			'label' => _x('TTS Slider', 'admin menu', 'tts-slider') . ' Categories',
			'singular_label' => $infoLabelName . _x('Image slider', 'admin menu', 'tts-slider'),
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true,
		)
	);
}
//add_action( 'slick_slider_category_add_form_fields', 'edit_slick_slider_category', 10, 2 );
add_action('slick_slider_category_edit_form_fields', 'edit_slick_slider_category', 10, 2);

function edit_slick_slider_category($tag)
{
	$t_id = ($tag) ? $tag->term_id : 0;
	$term_meta = get_option("taxonomy_$t_id");
	$nav_for_class = isset($term_meta['as-nav-for']) ? esc_attr($term_meta['as-nav-for']) : '';
	$selected = isset($term_meta['autoplay']) ? esc_attr($term_meta['autoplay']) : true;
	$selected2 = isset($term_meta['arrows']) ? esc_attr($term_meta['arrows']) : true;
	$selected3 = isset($term_meta['dots']) ? esc_attr($term_meta['dots']) : true;
	$pause_on_hover = isset($term_meta['pause-on-hover']) ? esc_attr($term_meta['pause-on-hover']) : true;
	$slides_to_show = isset($term_meta['slides-to-show']) ? esc_attr($term_meta['slides-to-show']) : 1;
	$slides_to_scroll = isset($term_meta['slides-to-scroll']) ? esc_attr($term_meta['slides-to-scroll']) : 1;
	$center_mode = isset($term_meta['center-mode']) ? esc_attr($term_meta['center-mode']) : false;
	$center_padding = isset($term_meta['center-padding']) ? esc_attr($term_meta['center-padding']) : '50px';

	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<h2>
				<?php _e('Short Code', 'tts-slider'); ?>
			</h2>
		</th>
		<td><code>[ttslickslider cat="<?php echo $tag->slug; ?>" posts_per_page="INPUT_YOUR_NUMBER"]</code></td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top" colspan="2">
			<h2>
				<?php _e('Slider Settings', 'tts-slider'); ?>
			</h2>
		</th>
	</tr>
	<tr class="form-field" colspan="2">
		<th scope="row" valign="top">
			<label for="nav_for_class_meta_box_select"><strong>
					<?php _e('Slider class', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<input type="text" id="nav_for_class_meta_box_select" class="small-text" placeholder="slider-nav" name="term_meta[as-nav-for]" value="<?php echo $nav_for_class; ?>" />
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<td style="vertical-align: top;">
			<table class="form-table">
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="autoplay_meta_box_select"><strong>
								<?php _e('Auto Play', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<select name="term_meta[autoplay]" id="autoplay_meta_box_select">
							<option value="true" <?php selected($selected, 'true'); ?>>Yes</option>
							<option value="false" <?php selected($selected, 'false'); ?>>No</option>
						</select>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="arrows_meta_box_select"><strong>
								<?php _e('Show navigation', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<select name="term_meta[arrows]" id="arrows_meta_box_select">
								<option value="true" <?php selected($selected2, 'true'); ?>>Yes</option>
								<option value="false" <?php selected($selected2, 'false'); ?>>No</option>
							</select>
						</div>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="dots_meta_box_select"><strong>
								<?php _e('Show Panigation', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<select name="term_meta[dots]" id="dots_meta_box_select">
								<option value="true" <?php selected($selected3, 'true'); ?>>Yes</option>
								<option value="false" <?php selected($selected3, 'false'); ?>>No</option>
							</select>
						</div>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" valign="top">
						<label for="pause_on_hover_meta_box_select"><strong>
								<?php _e('Pause on Hover', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<select name="term_meta[pause-on-hover]" id="pause_on_hover_meta_box_select">
								<option value="true" <?php selected($pause_on_hover, 'true'); ?>>Yes</option>
								<option value="false" <?php selected($pause_on_hover, 'false'); ?>>No</option>
							</select>
						</div>
					</td>
				</tr>
			</table>
		</td>
		<td style="vertical-align: top;">
			<table class="form-table">
				<tr class="form-field">
					<th scope="row" style="text-align: right;">
						<label for="slides_to_show_meta_box"><strong>
								<?php _e('Slides to show', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<input type="text" id="slides_to_show_meta_box" class="small-text" name="term_meta[slides-to-show]" value="<?php echo $slides_to_show; ?>" style="width: 50px" />
						</div>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" style="text-align: right;">
						<label for="slides_to_scroll_meta_box"><strong>
								<?php _e('Slides to scroll', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<input type="text" id="slides_to_scroll_meta_box" class="small-text" name="term_meta[slides-to-scroll]" value="<?php echo $slides_to_scroll; ?>" style="width: 50px" />
						</div>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" style="text-align: right;">
						<label for="center_mode_meta_box_select"><strong>
								<?php _e('Center mode', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<select name="term_meta[center-mode]" id="center_mode_meta_box_select">
								<option value="false" <?php selected($center_mode, 'false'); ?>>No</option>
								<option value="true" <?php selected($center_mode, 'true'); ?>>Yes</option>
							</select>
						</div>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" style="text-align: right;">
						<label for="center_padding_meta_box"><strong>
								<?php _e('Center mode padding', 'tts-slider'); ?>
							</strong></label>
					</th>
					<td>
						<div class="form-field">
							<input type="text" id="center_padding_meta_box" class="small-text" name="term_meta[center-padding]" value="<?php echo $center_padding; ?>" style="width: 50px" />
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top" colspan="4">
			<h2>
				<?php _e('Thumbnails Settings', 'tts-slider'); ?>
			</h2>
		</th>
	</tr>
	<?php
	$show_thumbnails = isset($term_meta['show-thumbs']) ? esc_attr($term_meta['show-thumbs']) : 0;
	$thumbnails_class = isset($term_meta['thumbnails-class']) ? esc_attr($term_meta['thumbnails-class']) : '';
	$slides_to_show_thumb = isset($term_meta['slides-to-show-thumb']) ? esc_attr($term_meta['slides-to-show-thumb']) : 3;
	$slides_to_scroll_thumb = isset($term_meta['slides-to-scroll-thumb']) ? esc_attr($term_meta['slides-to-scroll-thumb']) : 1;
	$dots_thumb = isset($term_meta['dots-thumb']) ? esc_attr($term_meta['dots-thumb']) : false;
	$center_mode_thumb = isset($term_meta['center-mode-thumb']) ? esc_attr($term_meta['center-mode-thumb']) : false;
	?>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="show_thumbnails_meta_box_select"><strong>
					<?php _e('Show thumbnails', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<select name="term_meta[show-thumbs]" id="show_thumbnails_meta_box_select">
					<option value="1" <?php selected($show_thumbnails, 1); ?>>Yes</option>
					<option value="0" <?php selected($show_thumbnails, 0); ?>>No</option>
				</select>
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="thumbnails_class_meta_box_select"><strong>
					<?php _e('Thumbnails class', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<input type="text" id="thumbnails_class_meta_box_select" class="small-text" placeholder="slider-for" name="term_meta[thumbnails-class]" value="<?php echo $thumbnails_class; ?>" />
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row">
			<label for="slides_to_show_thumb"><strong>
					<?php _e('Slides to show', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<input type="text" id="slides_to_show_thumb" class="small-text" name="term_meta[slides-to-show-thumb]" value="<?php echo $slides_to_show_thumb; ?>" style="width: 50px" />
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row">
			<label for="slides_to_scroll_thumb"><strong>
					<?php _e('Slides to scroll', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<input type="text" id="slides_to_scroll_thumb" class="small-text" name="term_meta[slides-to-scroll-thumb]" value="<?php echo $slides_to_scroll_thumb; ?>" style="width: 50px" />
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="dots_thumb_meta_box_select"><strong>
					<?php _e('Show Panigation', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<select name="term_meta[dots-thumb]" id="dots_thumb_meta_box_select">
					<option value="false" <?php selected($dots_thumb, 'false'); ?>>No</option>
					<option value="true" <?php selected($dots_thumb, 'true'); ?>>Yes</option>
				</select>
			</div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row">
			<label for="center_mode_thumb_meta_box_select"><strong>
					<?php _e('Center mode', 'tts-slider'); ?>
				</strong></label>
		</th>
		<td>
			<div class="form-field">
				<select name="term_meta[center-mode-thumb]" id="center_mode_thumb_meta_box_select">
					<option value="false" <?php selected($center_mode_thumb, 'false'); ?>>No</option>
					<option value="true" <?php selected($center_mode_thumb, 'true'); ?>>Yes</option>
				</select>
			</div>
		</td>
	</tr>
	<?php
}
add_action('edited_slick_slider_category', 'save_slick_slider_category', 10, 2);
add_action('created_slick_slider_category', 'save_slick_slider_category', 10, 2);
function save_slick_slider_category($term_id)
{
	if (isset($_POST['term_meta'])) {
		$t_id = $term_id;
		$term_meta = get_option("taxonomy_$t_id");
		$cat_keys = array_keys($_POST['term_meta']);
		foreach ($cat_keys as $key) {
			if (isset($_POST['term_meta'][$key])) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option("taxonomy_$t_id", $term_meta);
	}

}

// add style and script
function tts_slider_add_javascript_files()
{
	if (!is_admin()) {
		wp_register_script('jquery-slick', plugins_url() . '/TTS-slider/js/slick.min.js', array('jquery'), '1.0.9', true);
		wp_enqueue_script('jquery-slick');
		wp_register_script('jquery-slick-scripts', plugins_url() . '/TTS-slider/js/slick-script.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jquery-slick-scripts');
		wp_enqueue_style('slick-style', plugins_url() . '/TTS-slider/style/tts-style.css', array(), '1.0.9', 'all');
	}
}
add_action('wp_enqueue_scripts', 'tts_slider_add_javascript_files');

// add languages
function tts_slider_textdomain()
{
	load_plugin_textdomain('tts-slider', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'tts_slider_textdomain');

// add short code
// use: [ttslickslider cat="cate-slug" posts_per_page="5"]
add_shortcode('ttslickslider', 'tts_slider_show');

function tts_slider_show($atts)
{
	if (isset($atts['cat'])) {
		$cats = $atts['cat'];
	} else {
		return;
	}
	$category = get_term_by('slug', $cats, 'slick_slider_category');
	if (isset($atts['posts_per_page'])) {
		$posts_per_page = $atts['posts_per_page'];
	} else {
		$posts_per_page = 1;
	}
	if (!is_object($category)) {
		return;
	}
	$t_id = $category->term_id;
	$term_meta = get_option("taxonomy_$t_id");

	$slider_class = '';
	$thumbnail_class = '';
	$opts = '';
	$opts_nav = '';
	$output = '';

	$term_meta = get_option("taxonomy_$t_id");
	$arr_slide_nav = array('thumbnails-class', 'dots-thumb', 'as-nav-for', 'slides-to-show-thumb', 'slides-to-scroll-thumb', 'center-mode-thumb');
	$slider_class = $term_meta['as-nav-for'];
	if ($term_meta) {
		foreach ($term_meta as $key => $value) {
			if (!in_array($key, $arr_slide_nav)) {
				$opts .= 'data-' . $key . '="' . $value . '" ';
			}
		}
		foreach ($term_meta as $key => $value) {
			if (in_array($key, $arr_slide_nav)) {
				$key = str_replace('-thumb', '', $key);
				if ($key == 'as-nav-for') {
					$value = '.' . $value;
				}
				$opts_nav .= 'data-' . $key . '="' . $value . '" ';
			}
		}
	}

	$thumbnail_class = $term_meta['thumbnails-class'];
	if ($term_meta['show-thumbs'] && $thumbnail_class != '') {
		$opts .= 'data-as-nav-for=".' . $thumbnail_class . '" ';
		$opts_nav .= 'data-focus-on-select="true" ';
	}

	$args = array(
		'post_type' => 'slick-slider',
		'orderby' => 'date',
		'order' => 'ASC',
		'posts_per_page' => $posts_per_page,
		'tax_query' => array(
			array(
				'taxonomy' => 'slick_slider_category',
				'field' => 'term_id',
				'terms' => $t_id,
				'tag' => $cats,
			)
		)
	);

	$posts = get_posts($args);

	if (count($posts)) {

		$output = '<div class="slider ' . $slider_class . '" data-infinite="false" data-slick-slider="" ' . $opts . ' data-rows="false">';
		foreach ($posts as $post) {
			setup_postdata($post);
			$title = $post->post_title;
			$img_url = get_the_post_thumbnail_url($post->ID, 'full');
			$output .= '<div class="banner">';
			$output .= '<div class="banner-wraper"><div class="container">';
			$output .= '<div class="banner__content">';
			$output .= '<h2 class="title"><span class="sub-title">' . get_field('sub_title', $post->ID) . '</span><span>' . get_the_title($post->ID) . '</span></h2>';
			$output .= '<div class="banner__text">';
			$excerpt = get_the_excerpt($post->ID);
			if ($excerpt) {
				$output .= '<div class="text">' . $excerpt . '</div>';
			}
			$url = get_field('slider_link', $post->ID);
			if ($url) {
				$output .= '<div class="link"><a class="btn btn-primary" href="' . $url['url'] . '" target="' . $url['target'] . '">';
				$output .= $url['title'];
				$output .= "</a></div>";
			}
			$output .= "</div></div></div>";
			$output .= '<div class="banner__image"><span class="line line-1"></span><span class="line line-2"></span><img src="' . $img_url . '" alt="" /></div>';
			$output .= "</div>";
			$output .= "</div>";

		}
		$output .= '</div>';
		if ($term_meta['show-thumbs']) {
			$output .= '<div class="slider-thumb ' . $thumbnail_class . '" data-slick-slider="" ' . $opts_nav . '>';
			foreach ($posts as $post) {
				setup_postdata($post);
				$imagethumb = get_the_post_thumbnail($post->ID, 'thumbnail');
				$output .= '<div class="img-thumb">' . $imagethumb . "</div>";
			}
			$output .= '</div>';
		}
	}
	return $output;
}
function aaa_columns_head($defaults)
{
	$defaults['shortcode_column'] = 'ShortCode';
	unset($defaults['description']);
	unset($defaults['slug']);
	return $defaults;
}
function aaa_columns_content_taxonomy($value, $column_name, $term_id)
{
	$term = get_term($term_id, 'slick_slider_category');
	$svalue = '<code>[ttslickslider cat="' . $term->slug . '" posts_per_page="INPUT_YOUR_NUMBER"]</code>';
	switch ($column_name) {
		case 'shortcode_column':
			$value = $svalue;
			break;
		default:
			break;
	}
	return $value;
}
add_filter('manage_edit-slick_slider_category_columns', 'aaa_columns_head');
add_filter('manage_slick_slider_category_custom_column', 'aaa_columns_content_taxonomy', 10, 3);

?>