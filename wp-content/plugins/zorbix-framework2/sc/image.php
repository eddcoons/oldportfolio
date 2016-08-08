<?php

add_shortcode('image', 'zorbix_image');
function zorbix_image($atts, $content = null)
{

	$v = array(
		'image_id'       => '',
		'circle'         => '',
		'size'           => '',
		'full_width' => '',
		'padding'        => '',
		'padding_top'    => '',
		'padding_right'  => '',
		'padding_bottom' => '',
		'padding_left'   => '',
		'width' => '',
		'link' => '',
	);
	$v = shortcode_atts($v, $atts);


	$class = zorbix::join(
		zorbix_sc::class_from_key('circle', $v),
		zorbix_sc::class_from_key('full_width', $v)
	);

	$src = zorbix_img::get_src_from_id($v['image_id'], $v['size'], true, $class);

	$output = zorbix_sc::get_opening_anchor($v['link']);

	$output .= sprintf('<img src="%s" %s  %s alt="image"/>',
		esc_url($src),
		zorbix_sc::escaped_class_attr($class),
		zorbix_sc::get_format_style_esc_multi(array(
			'padding'        => $v['padding'],
			'padding-top'    => $v['padding_top'],
			'padding-right'  => $v['padding_right'],
			'padding-bottom' => $v['padding_bottom'],
			'padding-left'   => $v['padding_left'],
			'width' => $v['width'],
		))
	);

	$output .= zorbix_sc::get_closing_anchor($v['link']);

	return $output;
}