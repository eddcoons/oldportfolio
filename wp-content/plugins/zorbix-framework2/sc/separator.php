<?php

add_shortcode('separator', 'zorbix_separator' );
function zorbix_separator($user_atts, $content = null)
{

	$atts = array(
		'color'       => '',
		'color_class' => '',
		'line'        => ''
	);

	$atts = shortcode_atts($atts, $user_atts);

	$class = zorbix::join(
		'separator',
		$atts['color_class'],
		zorbix::if_true($atts['line'], 'line')
	);

	return sprintf(
		'<hr class="%s" %s/>',
		esc_attr($class),
		zorbix_sc::get_format_style_esc('border-color', $atts['color'])
	);

}
