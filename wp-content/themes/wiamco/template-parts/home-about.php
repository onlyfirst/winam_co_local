<?php
$subtitle = get_field('about_block_sub_title');
$title = get_field('about_home_title');
$home_about_images = get_field('about_home_image');
$home_about_description = get_field('about_home_content');
$home_about_link = get_field('about_home_link');
if ($subtitle || $title || $home_about_images || $home_about_description || $home_about_link):
	?>

	<div class="home-about-block">
		<div class="container">
			<div class="home-about-main">
				<?php if ($home_about_images): ?>
					<div class="home-about-main__img"><img src="<?php echo $home_about_images['sizes']['large']; ?>" alt="<?php echo $home_about_images['alt']; ?>" /></div>
				<?php endif; ?>
				<div class="home-about-main__content">
					<h3 class="sub-title">
						<?php echo $subtitle; ?>
					</h3>
					<h2 class="title">
						<?php echo $title; ?>
					</h2>
					<div class="description">
						<?php echo $home_about_description; ?>
					</div>
					<?php if ($home_about_link): ?>
						<div class="link"><a class="btn btn-warning" href="<?php echo $home_about_link['url']; ?>">
								<?php echo $home_about_link['title']; ?>
							</a></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>