<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage winamco
 * @since winamco 1.0
 */
global $wp_query;
$queried_object = get_queried_object();
$slugTerm = '';
if ($queried_object) {
	$slugTerm = $queried_object->slug;
	$ancestors = get_ancestors($queried_object->term_id, 'category_product_post');
	if ($ancestors) {
		$root = end($ancestors);
		$term = get_term($root, 'category_product_post');
		$slugTerm = $term->slug;
	}
}
?>

<aside class="sidebar sidebar--product">
	<form class="search-form search-form--left" action="<?php echo get_site_url(); ?>" method="get" role="search">
		<input class="search-field" type="search" name="s" value="" placeholder="<?php echo pll_e('Search', 'winamco'); ?>">
		<input type="hidden" name="post_type" value="product_post" />
		<button class="search-submit" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
	</form>
	<!-- product category -->
	<?php
	get_template_part('template-parts/product-categories');
	?>

</aside><!-- .sidebar .widget-area -->