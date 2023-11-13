<div class="sticky-toolbar">
	<?php if( get_theme_mod('site_hotline') || get_theme_mod('site_email') || get_theme_mod('site_facebook') || get_theme_mod('site_youtube') ): ?>
		<ul>
		<?php if(get_theme_mod('site_email')): ?>
			<li class="tooltip"><a href="mailto:<?php echo get_theme_mod('site_email');?>" title="Email" target="_blank"><em class="fa fa-envelope"></em></a><span class="tooltiptext">Mail to: <?php echo get_theme_mod('site_email');?></span></li>
		<?php endif; ?>
		<?php
		$site_hotline = get_theme_mod('site_hotline');
		$hotline = preg_replace("/[\s|+]/", "", $site_hotline);
		?>
		<?php if($hotline): ?>
		<li class="tooltip"><a href="tel:<?php echo $hotline;?>" title="hotline" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/telephone-call.png" /></a><span class="tooltiptext"><?php echo get_theme_mod('site_hotline');?></span></li>
		<?php endif; ?>
		<?php if(get_theme_mod('site_facebook')): ?>
		<li class="tooltip"><a href="<?php echo get_theme_mod('site_facebook');?>" title="Facebook" target="_blank"><em class="fa fa-facebook-square"></em></a><span class="tooltiptext">Facebook</span></li>
		<?php endif; ?>			
		<?php if(get_theme_mod('site_youtube')): ?>
				<li class="tooltip"><a href="<?php echo get_theme_mod('site_youtube');?>" title="Youtube" target="_blank"><em class="fa fa-youtube-play"></em></a><span class="tooltiptext">Youtube</span></li>
		<?php endif; ?>
		<?php if(get_theme_mod('site_twitter')): ?>
				<li class="tooltip"><a href="<?php echo get_theme_mod('site_twitter');?>" title="Twitter" target="_blank"><em class="fa fa-twitter"></em></a><span class="tooltiptext">Twitter</span></li>
		<?php endif; ?>
		</ul> 
	<?php endif; ?>				
</div>