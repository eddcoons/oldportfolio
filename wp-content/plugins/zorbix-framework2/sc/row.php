<?php

add_shortcode( 'row', 'zorbix_row' );
function zorbix_row($set_atts, $content = null ) {

	$atts = array(
		'margin_bottom' => '',

	);

	$atts = zorbix_sc::shortcode_atts( $atts, $set_atts, 'row' );

	$html = '<div class="row" ' . zorbix_sc::get_format_style_esc( 'margin-bottom', $atts['margin_bottom'] ) . '>';
	$html .= do_shortcode( $content );
	$html .= '</div>';

	return $html;
}