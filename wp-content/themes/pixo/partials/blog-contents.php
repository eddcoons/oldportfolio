<?php defined( 'ABSPATH' ) || die;

if( is_single() ) {
	get_template_part( 'partials/blog', 'content-single' );
} else {
	get_template_part( 'partials/blog', 'content' );
}