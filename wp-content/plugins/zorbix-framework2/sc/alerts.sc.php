<?php

add_shortcode('alert', 'zorbix_alerts' );
function zorbix_alerts($user_atts, $content = null)
{

	$atts = array(
		'type' => 'warning',
	);

	$atts = zorbix_sc::get_attr_set($atts, array('margin', 'padding'));

	$atts = shortcode_atts($atts, $user_atts);

	return sprintf(
		'<div class="alert %s" %s>%s<a href="#" class="alert-button"></a></div>',
		esc_attr($atts['type']),
		zorbix_sc::get_format_style_esc_multi(
			zorbix_sc::get_style_atts('spacing', $atts)
		),
		wp_kses_post($content)
	);


}