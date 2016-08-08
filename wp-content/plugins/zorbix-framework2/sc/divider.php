<?php

add_shortcode( 'divider', 'zorbix_divider' );
function zorbix_divider( $atts, $content = null ) {

	$default_atts = array(
		'white'     => '',
		'makewhite' => '',
	);

	$atts = shortcode_atts( $default_atts, $atts );

	return sprintf( '<hr class="divider %s"/>', esc_attr( $atts['makewhite'] ) );

}
