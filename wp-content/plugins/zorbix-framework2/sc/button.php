<?php
# Features Map

add_shortcode( 'button', 'zorbix_button' );
function zorbix_button( $atts, $content = null ) {

	$default_atts = array(
		'style'            => 'btn-default',
		'heading' => '',
		'backbtn'          => '',
		'link'             => '',
		'target'           => '',
		'title'            => '',
		'size'             => '',
		'margin'           => '',
		'block'            => '',
		'center_text'      => '',
		'icon_type'        => '',
		'icon_fontawesome' => '',
		'icon_openiconic'  => '',
		'icon_typicons'    => '',
		'icon_entypoicons' => '',
			'icon_color' => '',
		'icon_linecons'    => '',
		'icon_entypo'      => '',
		'smooth_jump'      => '',
	);

	$atts = zorbix_sc::shortcode_atts( $default_atts, $atts, 'button' );

//	$link_atts = zorbix_sc::sc_link( $atts );

	// Set class
	$class = zorbix::join(
		'btn',
		$atts['style'],
		$atts['size'],
		zorbix::if_true( $atts['backbtn'], ' btn-back' ),
		zorbix::if_true( $atts['smooth_jump'], ' smooth-jump' )
	);
	$style = ( $atts['margin'] ) ? 'margin: ' . $atts['margin'] : '';

	$atts['center_text'] = zorbix_sc::class_from_key( 'center_text', $atts );

	/* Opening Block */
	$output = zorbix::if_str_true( $atts['block'], '<div class="' . $atts['center_text'] . '">' );

		/* Opening Anchor */
	$link        = zorbix_sc::attr_link_format( $atts['link'] );
	$link['url'] = zorbix::if_empty( $link['url'], '#' );
	$output .= zorbix_sc::get_opening_anchor( $link, $class, $style );

	/* Icon */
	$output.= zorbix_sc::get_print_icon( $atts );

	/* Content */
	$output .= esc_html( $atts['heading'] );

	/* Closing Anchor */
	$output .=  '</a>';

	/* Closing block */
	$output .= zorbix::if_true( $atts['block'], '</div>' );

	return $output;
	?>

<?php }
