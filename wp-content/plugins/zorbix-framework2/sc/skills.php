<?php

add_shortcode( 'skill', 'zorbix_skill_sc' );
function zorbix_skill_sc( $atts, $content = null ) {
	$default_atts = array(
		'percent'            => '',
		'icon'               => '',
		'makewhite'          => '',
		'track_color'        => '#f5f5f5',
		'bar_color'          => zorbix_helper::$theme_color,
	);

	$atts = zorbix_sc::shortcode_atts( $default_atts, $atts, 'skill' );

	$atts['percent'] = zorbix::strip_to_numeric( $atts['percent'] );

	$class = zorbix::join( 'skill', $atts['makewhite'] );

	// Skill wrapper
	$output = sprintf( '<div class="%s">', esc_attr( $class ) );

	// Bar
	$output .= sprintf( '<div class="skill-bar" data-track-color="%s" data-bar-color="%s" data-percent="%s"></div>',
		esc_html( $atts['track_color'] ),
		esc_html( $atts['bar_color'] ),
		esc_html( $atts['percent'] )
	);

	// Percentage
	$output .= '<div class="skills-inner">';
	$output .= sprintf( '<span class="skill-percent">%s</span>', esc_attr( $atts['percent'] ) );

	// Title
	$output .= sprintf( '<h2 class="skill-title">%s</h2>', esc_html( $content ) );
	$output .= '</div>'; // Skills inner

	$output .= '</div>';
	return $output;
}