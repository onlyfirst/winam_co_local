<?php
/**
 * Custom winamco template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */

if (!function_exists('winamco_entry_meta')):
	/**
	 * Prints HTML with meta information for the categories, tags.
	 *
	 * Create your own winamco_entry_meta() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 */
	function winamco_entry_meta()
	{
		$format = get_post_format();
		echo '<div class="entry_meta"><ul>';
		if (current_theme_supports('post-formats', $format)) {
			echo '<li>';
			printf(
				'<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
				sprintf('<span class="screen-reader-text">%s </span>', _x('Format', 'Used before post format.', 'winamco')),
				esc_url(get_post_format_link($format)),
				get_post_format_string($format)
			);
			echo '</li>';
		}

		if (in_array(get_post_type(), array('post', 'attachment', 'aocuoi', 'dich-vu', 'makeup', 'bang-gia', 'hinh-anh'))) {
			echo '<li><em class="fa fa-clock-o"></em>' . get_the_date() . '</li>';
		}

		if (in_array(get_post_type(), array('post', 'attachment', 'aocuoi', 'dich-vu', 'makeup', 'bang-gia', 'hinh-anh'))) {
			echo '<li>';
			$author_avatar_size = apply_filters('winamco_author_avatar_size', 49);
			printf(
				'<span class="byline"><span class="author vcard">%1$s<span class="lb">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
				'',
				_x('Đăng bởi', 'Used before post author name.', 'winamco'),
				esc_url(get_author_posts_url(get_the_author_meta('ID'))),
				get_the_author()
			);
			echo '</li>';
		}


		if (in_array(get_post_type(), array('post'))) {
			echo '<li><span class="lb">Danh mục:</span>';
			winamco_entry_taxonomies();
			echo '</li>';
		}

		if (in_array(get_post_type(), array('makeup'))) {
			echo '<li><span class="lb">Danh mục:</span>';
			echo get_the_term_list(get_the_ID(), 'trang-diem', '', ', ');
			echo '</li>';
		}

		if (!is_singular() && !post_password_required() && (comments_open() || get_comments_number()) && 'post' === get_post_type()) {
			echo '<li>';
			echo '<span class="comments-link">';
			comments_popup_link(sprintf(__('Leave a comment<span class="screen-reader-text"> on %s</span>', 'winamco'), get_the_title()));
			echo '</span>';
			echo '</li>';
		}
		if ('post' === get_post_type()) {
			echo '<li><em class="fa fa-comments-o"></em>';
			echo '<a href="<?php the_permalink(); ?>#comments">' . comments_number('No Comments', '1 Comment', '% Comments') . '</a>';
			echo '</li>';
		}
		echo '</ul></div>';
	}
endif;

if (!function_exists('winamco_entry_date')):
	/**
	 * Prints HTML with date information for current post.
	 *
	 * Create your own winamco_entry_date() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 */
	function winamco_entry_date()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date('c')),
			get_the_date(),
			esc_attr(get_the_modified_date('c')),
			get_the_modified_date()
		);

		printf(
			'<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x('Posted on', 'Used before publish date.', 'winamco'),
			esc_url(get_permalink()),
			$time_string
		);
	}
endif;

if (!function_exists('winamco_entry_taxonomies')):
	/**
	 * Prints HTML with category and tags for current post.
	 *
	 * Create your own winamco_entry_taxonomies() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 */
	function winamco_entry_taxonomies()
	{
		$categories_list = get_the_category_list(_x(', ', 'Used between list items, there is a space after the comma.', 'winamco'));
		if ($categories_list && winamco_categorized_blog()) {
			printf(
				'<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x('Categories', 'Used before category names.', 'winamco'),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list('', _x(', ', 'Used between list items, there is a space after the comma.', 'winamco'));
		if ($tags_list) {
			printf(
				'<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x('Tags', 'Used before tag names.', 'winamco'),
				$tags_list
			);
		}
	}
endif;

if (!function_exists('winamco_post_thumbnail')):
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * Create your own winamco_post_thumbnail() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 */
	function winamco_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()):
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else: ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php the_post_thumbnail('post-thumbnail', array('alt' => the_title_attribute('echo=0'))); ?>
			</a>

		<?php endif; // End is_singular()
	}
endif;

if (!function_exists('winamco_excerpt')):
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own winamco_excerpt() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function winamco_excerpt($class = 'entry-summary')
	{
		$class = esc_attr($class);

		if (has_excerpt() || is_search()): ?>
			<div class="<?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
		<?php endif;
	}
endif;

if (!function_exists('winamco_excerpt_more') && !is_admin()):
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own winamco_excerpt_more() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function winamco_excerpt_more()
	{
		$link = sprintf(
			'<a href="%1$s" class="more-link">%2$s</a>',
			esc_url(get_permalink(get_the_ID())),
			/* translators: %s: Name of current post */
			sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'winamco'), get_the_title(get_the_ID()))
		);
		return ' &hellip; ' . $link;
	}
	add_filter('excerpt_more', 'winamco_excerpt_more');
endif;

if (!function_exists('winamco_categorized_blog')):
	/**
	 * Determines whether blog/site has more than one category.
	 *
	 * Create your own winamco_categorized_blog() function to override in a child theme.
	 *
	 * @since winamco 1.0
	 *
	 * @return bool True if there is more than one category, false otherwise.
	 */
	function winamco_categorized_blog()
	{
		if (false === ($all_the_cool_cats = get_transient('winamco_categories'))) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields' => 'ids',
					// We only need to know if there is more than one category.
					'number' => 2,
				));

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count($all_the_cool_cats);

			set_transient('winamco_categories', $all_the_cool_cats);
		}

		if ($all_the_cool_cats > 1) {
			// This blog has more than 1 category so winamco_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so winamco_categorized_blog should return false.
			return false;
		}
	}
endif;

/**
 * Flushes out the transients used in winamco_categorized_blog().
 *
 * @since winamco 1.0
 */
function winamco_category_transient_flusher()
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient('winamco_categories');
}
add_action('edit_category', 'winamco_category_transient_flusher');
add_action('save_post', 'winamco_category_transient_flusher');

if (!function_exists('winamco_the_custom_logo')):
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since winamco 1.2
	 */
	function winamco_the_custom_logo()
	{
		if (function_exists('the_custom_logo')) {
			the_custom_logo();
		}
	}
endif;

function getBannerTop()
{
	$banner_url = get_theme_mod('winamco_banner_url');
	$banner_img = get_theme_mod('winamco_banner_image');
	$image_alt = image_alt_by_url($banner_img);
	if ($banner_url) {
		echo '<a href="' . $banner_url . '" title="' . $image_alt . '" rel="home">';
	}
	echo '<img src="' . $banner_img . '" alt="' . $image_alt . '" />';
	if ($banner_url) {
		echo '</a>';
	}
}

function image_alt_by_url($image_url)
{
	global $wpdb;

	if (empty($image_url)) {
		return false;
	}

	$query_arr = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", strtolower($image_url)));
	$image_id = (!empty($query_arr)) ? $query_arr[0] : 0;

	return get_post_meta($image_id, '_wp_attachment_image_alt', true);
}

function theShareSocial()
{
	$shareIcon = is_single() ? 'share-icon.png' : 'share-icon-w.png';
	$content = '<div class="share-box">';
	$content .= '<div class="share-link" data-share="#share-popup"><img src="' . get_template_directory_uri() . '/images/' . $shareIcon . '" alt="Share" />' . __('Share', 'winamco') . '</div>';
	$content .= '<ul id="share-popup" class="share-popup">';
	$content .= '<li><a href="http://www.facebook.com/sharer.php?u=' . esc_url(get_permalink()) . '" target="_blank"><em class="fa fa-facebook-official"></em>FaceBook</a></li>';
	$content .= '<li><a href="http://twitter.com/share?url=' . esc_url(get_permalink()) . '&text=' . get_the_title() . '&hashtags=simplesharebuttons" target="_blank"><em class="fa fa-twitter"></em>Twitter</a></li>';
	$content .= '<li><a href="https://plus.google.com/share?url=' . esc_url(get_permalink()) . '" target="_blank"><em class="fa fa-google-plus"></em>Google+</a></li>';
	$content .= '<li><a href="http://www.digg.com/submit?url=' . esc_url(get_permalink()) . '" target="_blank"><em class="fa fa-digg"></em>Digg</a></li>';
	$content .= '<li><a href="http://reddit.com/submit?url=' . esc_url(get_permalink()) . '&title=' . get_the_title() . '" target="_blank"><em class="fa fa-reddit"></em>Reddit</a></li>';
	$content .= '<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . esc_url(get_permalink()) . '" target="_blank"><em class="fa fa-linkedin"></em>LinkedIn</a></li>';
	$content .= '<li><a href="http://www.stumbleupon.com/submit?url=' . esc_url(get_permalink()) . '&title=Simple Share Buttons" target="_blank"><em class="fa fa-stumbleupon"></em>StumbleUpon</a></li>';
	$content .= '</ul>';
	$content .= '</div>';
	echo $content;
}

function changeMonthNumberToString($m)
{
	switch ($m) {
		case '01':
			return 'Jan';
			break;
		case '02':
			return 'Feb';
			break;
		case '03':
			return 'Mar';
			break;
		case '04':
			return 'Apr';
			break;
		case '05':
			return 'May';
			break;
		case '06':
			return 'Jul';
			break;
		case '07':
			return 'July';
			break;
		case '08':
			return 'Aug';
			break;
		case '09':
			return 'Agu';
			break;
		case '10':
			return 'Oct';
			break;
		case '11':
			return 'Nov';
			break;
		case '12':
			return 'Dec';
			break;
		default:
			return null;
			break;
	}
}