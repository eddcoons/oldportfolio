<?php

add_shortcode( 'feature', 'zorbix_feature' );
function zorbix_feature( $atts, $content = null ) {

	$default_atts = array(
		'hexcolor'         => '#f5f5f5',
		'icon_color'       => '',
		'mb'               => '',
		// Animation atts
		'animate_check'    => '',
		'start_delay'      => '',
		'effect'           => '',
		'delay'            => '',
		'icon_bg_color' => '#009EC6',
	);

	$default_atts = array_merge($default_atts, zorbix_sc::get_icon_atts());

	$atts = shortcode_atts( $default_atts, $atts );

	$class = zorbix::join( 'feature', zorbix_sc::animation_class( $atts ) );


	# HTML

	ob_start();

	printf( '<div class="%s" %s >',
		esc_attr( $class ),
		zorbix_anim_data_esc( $atts )
	);

//	include( locate_template( 'partials/icon.php' ) );

	zorbix_sc::print_icon( $atts );

    echo wpautop( $content );

	echo '</div>';

	return ob_get_clean();
}
