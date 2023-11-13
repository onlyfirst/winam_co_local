<!-- product category -->
<?php
$className = 'product-category-left';
if ($args['data']['className']) {
	$className = $args['data']['className'];
}
$terms = get_terms([
	'taxonomy' => 'category_product_post',
	'hide_empty' => false,
	'orderby' => 'term_order',
	'order' => 'ASC',
	'parent' => 0
]);
$queried_object = get_queried_object();
$termsId = isset($_GET["terms"]) ? $_GET['terms'] : null;
$termsIdArr = explode(",", $termsId);
$product_page_link = get_locale() == 'ms_MY' ? get_page_link(296) : get_page_link(51);
if ($terms):
	?>
	<div class="sidebar-box sidebar-box--product-category <?php echo $className; ?>">
		<h3>
			<?php echo pll_e('All our playgrounds', 'cos'); ?><span data-toggle="#product-category"></span>
		</h3>
		<ul class="filter-content product-category-list">
			<?php foreach ($terms as $term): ?>
				<?php $currentClass = $term->term_id === $queried_object->term_id ? 'active' : '';
				$checked = in_array($term->term_id, $termsIdArr) ? ' checked' : '';
				?>

				<li class="<?php echo is_single() ? '' : 'checkbox'; ?>">
					<?php if (is_single()): ?>
						<a class="<?php echo $currentClass; ?>" href="<?php echo $product_page_link; ?>?terms=<?php echo $term->term_id; ?>" title="<?php echo $term->name; ?>"><?php echo $term->name; ?></a>
					<?php else: ?>
						<input class="checkbox-filter" type="checkbox" name="terms" id="terms<?php echo $term->term_id; ?>" value="<?php echo $term->term_id; ?>" <?php echo $checked; ?>> <label for="terms<?php echo $term->term_id; ?>"><?php echo $term->name; ?></label>
					<?php endif; ?>
					<?php
					$subterms = get_terms([
						'taxonomy' => 'category_product_post',
						'hide_empty' => false,
						'orderby' => 'term_order',
						'order' => 'ASC',
						'child_of' => $term->term_id,
					]);

					if ($subterms):
						?>
						<ul class="sub-categories">
							<?php foreach ($subterms as $sterm): ?>
								<?php
								$currentCatsub = $sterm->term_id === $queried_object->term_id ? 'active' : '';
								$checkedS = in_array($sterm->term_id, $termsIdArr) ? ' checked' : '';
								?>
								<li class="<?php echo $currentCatsub; ?> <?php echo is_single() ? '' : 'checkbox'; ?>">
									<?php if (is_single()): ?>
										<a class="<?php echo $currentCatsub; ?>" href="<?php echo $product_page_link; ?>?terms=<?php echo $sterm->term_id; ?>" title="<?php echo $sterm->name; ?>"><?php echo $sterm->name; ?></a>
									<?php else: ?>
										<input class="checkbox-filter" type="checkbox" name="terms" id="terms<?php echo $sterm->term_id; ?>" value="<?php echo $sterm->term_id; ?>" <?php echo $checkedS; ?>> <label for="terms<?php echo $sterm->term_id; ?>"><?php echo $sterm->name; ?></label>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>