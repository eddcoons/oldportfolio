<?php

add_shortcode( 'feature-list', 'zorbix_feature_list' );
function zorbix_feature_list( $atts, $content = null ) {

	$default_atts = array(
		'link'             => '',
		'heading'          => '',
		'hexcolor'         => '#f5f5f5',
		'icon_color'       => '',
		'content'          => '',
		'align'            => 'left',
		'mb'               => '',
		'size'             => '',
		// Animation atts
		'animate_check'    => '',
		'start_delay'      => '',
		'effect'           => '',
		'delay'            => '',
		'style'            => '',
		// Icon atts
		'icon'             => '',
		'icon_type'        => 'font-awesome',
		'icon_fontawesome' => 'fa-rocket',
		'icon_openiconic'  => '',
		'icon_typicons'    => '',
		'icon_entypoicons' => '',
		'icon_linecons'    => '',
		'icon_entypo'      => '',
		'icon_border'      => '',
	);

	$atts = shortcode_atts( $default_atts, $atts );

	$animation_class = zorbix_sc::animation_class( $atts );
	$class           = zorbix::join(
		'feature-list-item',
		$animation_class,
		$atts['align'],
		$atts['size'],
		$atts['style']
	);

	# HTML
	$mb            = (int) $atts['mb'];
	$atts['style'] = ( $atts['mb'] ) ? "margin-bottom: {$mb}px" : '';

	ob_start();

	printf( '<div class="%s" style="%s" %s >',
		esc_attr( $class ),
		esc_attr( $atts['style'] ),
		zorbix_anim_data_esc( $atts )
	);

	zorbix_sc::print_icon( $atts );

	echo '<h4 class="title">';
	zorbix_sc::print_opening_anchor( $atts['link'] );
	echo esc_html( $atts['heading'] );
	zorbix_sc::print_closing_anchor( $atts['link'] );
	echo '</h4>';

	echo wpautop( $content );
	echo '</div>';

	return ob_get_clean();
}
