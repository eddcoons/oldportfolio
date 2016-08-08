<?php defined( 'ABSPATH' ) || die; ?>

<div class="blog-content-wrap">

	<?php get_template_part( 'partials/blog', 'date' ); ?>

	<div class="post-container">

		<?php get_template_part( 'partials/blog', 'heading' ) ?>

		<?php get_template_part( 'partials/blog', 'meta' ) ?>

		<?php if ( get_the_content() ) {
			the_content();
		}
		?>

		<hr/>

		<div class="post-info">

			<div class="post-tags">
				<?php zorbix_blog::tags(); ?>
			</div>

			<div class="blog-arrows">
				<?php next_post_link( '%link', zorbix_helper::prev_arrow() ); ?>
				<?php previous_post_link( '%link', zorbix_helper::next_arrow() ); ?>
			</div>
		</div>


	</div>
</div><!-- End .blog-content-wrap -->
