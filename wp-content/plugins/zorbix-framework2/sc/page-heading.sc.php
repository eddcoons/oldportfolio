<?php

add_shortcode('page-heading', 'zorbix_page_heading');
function zorbix_page_heading($atts, $content = null)
{
	$v = array(
		'color' => '',
		'size'  => 'large',
	);

	$v = zorbix_sc::shortcode_atts($v, $atts, 'page-heading');

	return sprintf(
		'<h1 class="page-heading %s" %s>%s</h1>',
		esc_attr($v['size']),
		zorbix_sc::get_format_style_esc('color', $v['color']),
		esc_html($content)
	);
}