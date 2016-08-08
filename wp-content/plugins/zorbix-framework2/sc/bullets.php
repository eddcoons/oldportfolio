<?php

add_shortcode( 'bullets', 'zorbix_bullets' );
function zorbix_bullets( $atts, $content = null ) {

	$default_atts = array(
		'heading'     => '',
		'circle_list' => '',
	);

	$default_atts = array_merge($default_atts, zorbix_sc::get_icon_atts());

	$atts = shortcode_atts( $default_atts, $atts );


//	$replace = sprintf( '<li><i class="fa %s"></i>', esc_attr( $atts['icon'] ) );
	$atts = zorbix_sc::icon($atts);
	$replace = sprintf('<li><i class="zx-icon %s" %s></i>',
		esc_attr($atts['icon']),
		zorbix_sc::get_format_style_esc('color', $atts['icon_color'])
	);

	$content = str_replace( '<li>', $replace, $content );

	$replace = sprintf( '<ul class="bullet-list %s">', $atts['circle_list'], $content );
	$content = str_replace( '<ul>', $replace, $content );

	return $content;

}
