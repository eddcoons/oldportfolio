<?php defined( 'ABSPATH' ) || die;

if ( is_single() ) { // Single
	get_template_part( 'partials/blog', 'image-single' );
	get_template_part( 'partials/blog', 'link' );
	get_template_part( 'partials/blog', 'content-single' );
} else { // Roll
	get_template_part( 'partials/blog', 'image' );
	get_template_part( 'partials/blog', 'link' );
	get_template_part( 'partials/blog', 'content' );
}