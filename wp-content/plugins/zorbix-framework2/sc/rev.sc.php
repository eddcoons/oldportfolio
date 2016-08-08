<?php

add_shortcode('rev', 'zorbix_rev' );
function zorbix_rev($user_atts, $content = null)
{

	$atts = array(
		'alias' => '',
	);

	$atts = shortcode_atts($atts, $user_atts);

	if (class_exists('RevSlider')) {
		$rev = new RevSlider();
		if ($rev->isAliasExists($atts['alias'])) {
			return do_shortcode('[rev_slider ' . $atts['alias'] . ']');
		} else {
			return sprintf('<div class="rev-disabled-msg"><h1>%s</h1><p>%s</p></div>',
				esc_html__('Slider Not Found', 'pixo'),
				esc_html__('If your starting from a demo - you need to import the slider', 'pixo')
			);
		}
	}
}

