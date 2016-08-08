<?php defined( 'ABSPATH' ) || die; ?>

<!-- Meta -->
<div class="blog-meta">
	<?php
	if ( true === get_theme_mod('meta_author', true) ) {
		echo 'By ';
		the_author_posts_link();
		echo ' / ';
	}

	if ( get_theme_mod('meta_categories', true) ) {
		the_category( ', ' );
	}

	if ( get_theme_mod('meta_comments', true) ) {
		comments_number( '',
			' - <a class="smooth_jump" href="#comments">One Comment</a>',
			' - <a class="smooth_jump" href="#comments">% Comments</a>'
		);
	}
	?>
</div>

