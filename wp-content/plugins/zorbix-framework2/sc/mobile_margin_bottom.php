<?php

add_shortcode( 'mobile_margins', 'zorbix_mobile_margins' );
function zorbix_mobile_margins( $atts, $content = null ) {

	$default_atts = array(
		'margin_bottom' => '20',
		'breakpoint'    => 'sm',
	);

	$atts = shortcode_atts( $default_atts, $atts );

	return sprintf( '<div class="mb-%s-%s"></div>',
		esc_attr( zorbix_sc::remove_px( $atts['margin_bottom'] ) ),
		esc_attr( $atts['breakpoint'] ) );

}