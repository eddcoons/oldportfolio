<?php

add_shortcode( 'clients', 'zorbix_client' );
function zorbix_client($atts, $content = null ) {

	$post_type = 'client';
	$taxonomy  = 'client_group';

	$default_atts = array(
		'link'         => '',
		'id'           => '',
		'hover_effect' => 'false',
		'height'       => '',
	);

	// Add a predefined set of attributes
	$default_atts = zorbix_sc::get_attr_set( $default_atts, array( 'animation' ) );
	$atts         = zorbix_sc::shortcode_atts( $default_atts, $atts, 'clients' );

	$class = zorbix::join(
		zorbix_sc::animation_class( $atts ),
		zorbix::if_true( 'true' === $atts['hover_effect'], 'hover-effect' )
	);

	$output = sprintf( '<div  class="client %s" %s>',
		esc_attr( $class ),
		zorbix_anim_data_esc( $atts ),
		zorbix_sc::format_style_esc( 'height', $atts['height'] )
	);

	$output .= zorbix_sc::get_opening_anchor( $atts['link'] );
	$output .= zorbix_img::get_tag_from_id( $atts['id'], 'pixo_client_thumb', true );
	$output .= zorbix_sc::get_closing_anchor( $atts['link'] );

	$output .= '</div>';

	return $output;
}
