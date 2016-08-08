<?php

add_shortcode('sharing', 'zorbix_sharing' );
function zorbix_sharing($user_atts, $content = null)
{

	$atts = array(
		'facebook'     => '',
		'twitter'      => '',
		'pinterest'    => '',
		'custom1_name' => '',
		'custom1_link' => '',
		'custom2_name' => '',
		'custom2_link' => '',
		'custom3_name' => '',
		'custom3_link' => '',
	);

	# Set Attributes
	$atts = zorbix_sc::shortcode_atts($atts, $user_atts, 'sharing');

	$links = array(
		'facebook'  => 'https://www.facebook.com/sharer/sharer.php?u=' . get_permalink(),
		'twitter'   => 'https://twitter.com/intent/tweet?text=&url=' . get_the_permalink(),
		'pinterest' => 'http://pinterest.com/pin/create/button/?url=' . get_the_permalink(),
	);

	$output = '<div class="sharing">' . esc_html__( 'SHARE: ', 'pixo');

	foreach ($links as $share_name => $link) {
		if (true === $atts[$share_name] || !empty($atts[$share_name])) {
			$output .= sprintf('<a href="%s">%s</a>',
				esc_attr($link),
				esc_html($share_name)
			);
		}
	}

	if( '' !== $atts['custom1_name'] && '' !== $atts['custom1_link'] ) {
		$output .= sprintf('<a href="%s" %s>%s</a>',
				esc_attr($atts['custom1_name']),
				esc_html($atts['custom1_link'])
		);
	}

	if( '' !== $atts['custom2_name'] && '' !== $atts['custom2_link'] ) {
		$output .= sprintf('<a href="%s" %s>%s</a>',
				esc_attr($atts['custom2_name']),
				esc_html($atts['custom2_link'])
		);
	}

	$output .= '</div>';

	return $output;

}