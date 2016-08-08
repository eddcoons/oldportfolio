<?php

add_shortcode('section', 'zorbix_section' );
function zorbix_section($user_atts, $content = null)
{

	$atts = array(
		'heading'         => '',
		'id'              => '',
		'cols_no_padding' => '',
		'color'           => '',
		'bg_color'        => '',
		'bg_size'         => '',
		'size'            => '',
		'bg_id'           => '',
		'full_size'       => '',
		'full_height'     => '',
		'type'            => '',
		'cols_equal'      => 'false', // @todo look at how other themes do this, maybe a table?
		'cols_inline'     => 'false',
		'col_pb'          => '',
		'col_pt'          => '',
		'dark_scheme'     => 'false',
		'no_max_width'    => 'false',
		'padding'         => '',
		'padding_top'     => '',
		'padding_right'   => '',
		'padding_bottom'  => '',
		'padding_left'    => '',
		'margin'          => '',
		'margin_top'      => '',
		'margin_right'    => '',
		'margin_bottom'   => '',
		'margin_left'     => '',
		'container'       => '',
		'center_contents' => '',
		'center_text'     => '',
		'tint'            => '',
		'cell'            => '',
		'class'           => '',
		'auto_bottom'     => '',
		'video_type'      => '',
		'youtube_link'    => '',
		'mp4_url'         => '',
		'webm_url'        => '',
	);

	$atts = shortcode_atts($atts, $user_atts);

	$class = zorbix::join(
		'clearfix',
		zorbix_sc::class_from_key('cols_equal', $atts),
		zorbix_sc::class_from_key('center_text', $atts),
		zorbix_sc::class_from_key('no_max_width', $atts),
		zorbix::if_true($atts['cols_equal'], 'cols_equal'),
		$atts['cell'],
		zorbix_sc::class_from_key('cols_inline', $atts),
		zorbix_sc::class_from_key('dark_scheme', $atts),
		zorbix_sc::class_from_key('full_height', $atts),
		zorbix_sc::class_from_key('cols_no_padding', $atts),
		$atts['type'],
		$atts['tint'],
		$atts['bg_size'],
		$atts['class'],
		$atts['col_pt'],
		$atts['col_pb'],
		zorbix_sc::prepend($atts['color'], 'tx-'),
		zorbix::if_true($atts['full_size'], 'full-size'),
		zorbix::if_true($atts['auto_bottom'], 'auto-bottom')
	);

	if( 'youtube' === $atts['video_type'] ) {
		$atts['id'] = 'bngVideo';
	}

	$placeholder = ('placeholder' === $atts['bg_id']) ? true : false;
	$image_url = zorbix_img::get_src_from_id($atts['bg_id'], 'full');

	$output = sprintf('<section %s class="%s" %s>',
		zorbix::sprintf_if_exists('id="%s"', esc_attr($atts['id'])),
		esc_attr($class),
		zorbix_sc::get_format_style_esc_multi(
			zorbix_sc::get_style_atts('spacing', $atts),
			array(
				'background-color' => $atts['bg_color'],
				'background-image' => $image_url,
			)
		)
	);

	$output .= zorbix_sc::video_bg($atts['video_type'], $atts['youtube_link'], $atts['mp4_url'], $atts['webm_url']);

	$output .= ('true' === $atts['center_contents']) ? '<div class="centerer">' : '';

	$output .= ('true' === $atts['container']) ? '<div class="container">' : '<div class="contents">';

	$output .= do_shortcode($content);

	$output .= '</div>';

	$output .= ('true' === $atts['center_contents']) ? '</div>' : '';

	$output .= '</section>';

	return $output;

}
