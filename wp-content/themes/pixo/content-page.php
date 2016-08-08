<?php defined( 'ABSPATH' ) || die;
/**
 * To display a page in a search result so it doesn't show entire page
 */
?>
<!-- POST CONTENT -->
<div class="blog-content-wrap">
	<?php get_template_part( 'partials/blog', 'date' ); ?>

	<?php get_template_part( 'partials/blog', 'heading' ) ?>

	<div class="blog-content">
		<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
	</div><!-- End .post-content -->

</div><!-- End .blog-conent -->
