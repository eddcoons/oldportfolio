<?php

add_shortcode('heading', 'zorbix_heading');
function zorbix_heading($atts, $content = null)
{

	$v = array(
		'margin_bottom' => '',
		'pre'           => '',
		'heading'       => '',
		'dash'          => '',
		'align'         => '',
		'heading_size'  => '1',
		'color'         => '',
	);

	$v = zorbix_sc::get_attr_set($v,
		array('makewhite')
	);
	$v = zorbix_sc::shortcode_atts($v, $atts, 'section_title');

	$class = zorbix::join(
		zorbix::if_true($v['align'], 'center')
	);
	$output = sprintf('<div class="heading %s" %s>',
		esc_attr($class),
		zorbix_sc::get_format_style_esc('margin-bottom', $v['margin_bottom'])
	);
	$output .= zorbix::sprintf_if_exists('<p class="pre"><span>%s</span></p>', esc_html(strip_tags($v['pre'])));
	$output .= sprintf('<h%s class="title %s">%s</h%s>',
		esc_attr($v['heading_size']),
		zorbix_sc::class_from_key('dash', $v),
		esc_html(strip_tags($v['heading'])),
		esc_attr($v['heading_size'])
	);
	$output .= zorbix::sprintf_if_exists('<p class="desc" >%s </p >', esc_html(strip_tags($content)));
	$output .= '</div >';

	return $output;

}
