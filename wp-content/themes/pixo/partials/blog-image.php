<!-- POST MEDIA -->
<?php if ( has_post_thumbnail() && class_exists( 'zorbix_img' ) ) : ?>
	<a class="blog-media" href="<?php the_permalink() ?>">
		<?php zorbix_img::thumb_tag( 'pixo_blog_thumb' ); ?>
	</a>
<?php endif; ?>
