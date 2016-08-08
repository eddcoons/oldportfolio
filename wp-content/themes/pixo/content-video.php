<?php defined( 'ABSPATH' ) || die;

?>
	<!-- Video -->
	<div class="blog-media">
		<?php zorbix_helper::video( 'video_post' ); ?>
	</div>

<?php if ( is_single() ) : ?>

	<?php get_template_part( 'partials/blog', 'content-single' ); ?>

<?php else : ?>

	<?php get_template_part( 'partials/blog', 'content' ); ?>

<?php endif;
