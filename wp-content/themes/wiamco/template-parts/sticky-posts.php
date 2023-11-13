<?php
$sticky = get_option( 'sticky_posts' );
$args = array(
  'posts_per_page' => 1,
  'post__in' => $sticky,
  'ignore_sticky_posts' => 1
);
$loop = new WP_Query($args);
if ( $loop->have_posts() && isset( $sticky[0] )) :  
?>
<div class="news-sticky">
  <?php
  while ( $loop->have_posts() ) : $loop->the_post(); 
  get_template_part( 'template-parts/content', null, array( 
    'size' => 'large'
    )); 
  endwhile;
  wp_reset_postdata() 
  ?>
</div>
<?php endif; ?>