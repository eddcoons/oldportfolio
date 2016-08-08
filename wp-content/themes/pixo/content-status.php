<?php defined( 'ABSPATH' ) || die;

if ( is_single() ) : ?>

<!-- POST MEDIA -->
<?php if ( has_post_thumbnail() ) : ?>
		<img src="<?php esc_url( zorbix_get_thumb_src( 'pixo_blog_thumb' ) ) ?>">
<?php endif; ?>

<?php get_template_part( 'partials/blog', 'content-single' ); ?>

<?php else : ?>

	<!-- POST MEDIA -->
	<a class="blog-media" href="<?php echo esc_url( get_the_permalink() ) ?>">
		<?php if ( has_post_thumbnail() ) : ?>
			<img src="<?php esc_url( zorbix_get_thumb_src( 'pixo_blog_thumb' ) ) ?>">
		<?php endif; ?>
	</a>

	<?php get_template_part( 'partials/blog', 'content' ); ?>

<?php endif;
