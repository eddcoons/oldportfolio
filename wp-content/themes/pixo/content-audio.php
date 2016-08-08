<?php defined( 'ABSPATH' ) || die; ?>
<!-- Audio -->
<div class="audio blog-media">
	<?php zorbix_blog::post_audio(); ?>
</div>

<?php get_template_part( 'partials/blog', 'contents' );
