<?php defined( 'ABSPATH' ) || die; ?>
<!-- POST CONTENT -->
<div class="blog-content-wrap">
	<?php get_template_part( 'partials/blog', 'date' ); ?>

	<div class="post-container">

		<?php get_template_part( 'partials/blog', 'heading' ) ?>

		<?php get_template_part( 'partials/blog', 'meta' ) ?>

		<?php the_content( esc_html__('Read More', 'pixo') ); ?>
	</div>
	<!-- End .post-content -->

</div><!-- End .blog-conent -->
