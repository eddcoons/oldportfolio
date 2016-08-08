
<?php # Icon for a sticky post
if ( is_sticky() ) {
echo '<i class="sticky-icon fa fa-thumb-tack"></i>';
} ?>

<h4 class="blog-title">
	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
</h4>
