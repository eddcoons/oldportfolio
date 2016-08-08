<?php

add_shortcode('icon_bullet', 'zorbix_icon_bullet');
function zorbix_icon_bullet($atts, $content = null)
{

	$default_atts = array(
		'heading' => '',
		'circle'  => '',
		'mb'      => '',
		'size'    => '',
	);

	$default_atts = array_merge($default_atts, zorbix_sc::get_icon_atts());

	$atts = shortcode_atts($default_atts, $atts);

	$atts = zorbix_sc::icon($atts);

	$class = zorbix::join($atts['circle'], $atts['size']);

	return sprintf('<div %s class="bullet %s"><i class="zx-icon %s" %s></i>%s</div>',
		zorbix_sc::get_format_style_esc('margin-bottom', esc_attr((int)$atts['mb'])),
		esc_attr($class),
		esc_attr($atts['icon']),
		zorbix_sc::get_format_style_esc( 'color', $atts['icon_color'] ),
		wp_kses_post($content)
	);
}
