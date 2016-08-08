<?php

add_shortcode('zorbix_video', 'zorbix_video' );
/**
 * Identical to built in except adds a responsive video wrapper div
 *
 * @param $atts
 * @param null $content
 * @return string
 */
function zorbix_video($atts, $content = null)
{

	$default_atts = array(
		'mp4'      => '',
		'webm'     => '',
		'ogv'      => '',
		'poster'   => '',
		'loop'     => '',
		'autoplay' => '',
		'preload'  => '',
		'height'   => '',
		'width'    => '',
	);

	$default_atts = zorbix_sc::get_attr_set($default_atts, array('margin', 'padding'));
	$atts = zorbix_sc::shortcode_atts($default_atts, $atts, 'zorbix_video');

	$atts['poster'] = zorbix_img::get_src_from_id($atts['poster']);

	$atts['mp4'] = zorbix::if_true(is_numeric($atts['mp4']), zorbix_img::get_src_from_id($atts['mp4']));
	$atts['webm'] = zorbix::if_true(is_numeric($atts['webm']), zorbix_img::get_src_from_id($atts['webm']));
	$atts['ogv'] = zorbix::if_true(is_numeric($atts['ogv']), zorbix_img::get_src_from_id($atts['ogv']));


	$atts['mp4'] = esc_url($atts['mp4']);
	$atts['webm'] = esc_url($atts['webm']);
	$atts['ogv'] = esc_url($atts['ogv']);

	global $shortcode_tags;
	$func = $shortcode_tags['video'];

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

	$output .= call_user_func($func, $atts) . '</div>';

	return $output;

}
