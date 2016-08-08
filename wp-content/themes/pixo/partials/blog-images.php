<?php if ( is_single() ) {

	# SINGLE
	if ( has_post_thumbnail() ) {
		printf( '<span class="blog-media">%s</span>',
			zorbix_blog::get_thumb_tag( 'pixo_blog_thumb' )
		);
	}

} else {

	# BLOG ROLL
	if ( has_post_thumbnail( get_the_ID() ) ) {
		printf( '<a class="blog-media" href="%s">%s</a>',
			esc_url( get_the_permalink() ),
			zorbix_blog::get_thumb_tag( 'pixo_blog_thumb' )
		);
	}

}