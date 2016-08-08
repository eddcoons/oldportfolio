<?php

add_shortcode('zbx_embed', 'zorbix_embed');
/**
 * Identical to built in except adds a responsive video wrapper div
 *
 * @param $atts
 * @param null $content
 * @return string
 */
function zorbix_embed($atts, $content = null)
{

	$default_atts = array(
		'height' => '',
		'width'  => '',
			'disable_responsive' => ''
	);
	$default_atts = zorbix_sc::get_attr_set($default_atts, array('margin', 'padding'));
	$atts = zorbix_sc::shortcode_atts($default_atts, $atts, 'zorbix_embed');

	// Embed is an exception to being able to use a callback
	global $wp_embed;

	if( 'true' !== $atts['disable_responsive']) {
		$output = sprintf('<div class="responsive-video" %s>',
				zorbix_sc::get_format_style_esc_multi(array(
						'padding'        => $atts['padding'],
						'padding-top'    => $atts['padding_top'],
						'padding-right'  => $atts['padding_right'],
						'padding-bottom' => $atts['padding_bottom'],
						'padding-left'   => $atts['padding_left'],
						'margin'         => $atts['margin'],
						'margin-top'     => $atts['margin_top'],
						'margin-right'   => $atts['margin_right'],
						'margin-bottom'  => $atts['margin_bottom'],
						'margin-left'    => $atts['margin_left'],
				))
		);

	}

	// Embed needs to be run with this command, it cannot be done directly
	$shortcode = sprintf('[embed width="%s" height="%s"]%s[/embed]',
			esc_html($atts['height']),
			esc_html($atts['width']),
			esc_url($content)
	);
	$output .= balanceTags($wp_embed->run_shortcode($shortcode));

	if( 'true' !== $atts['disable_responsive']) {
		$output .= '</div>';
	}

	return $output;
}
