<?php

add_shortcode( 'sub-heading', 'zorbix_sub_heading' );
function zorbix_sub_heading( $atts, $content = null ) {

	return sprintf( '<span class="page-sub-heading">%s</span>', wp_kses_post( $content ) );

}