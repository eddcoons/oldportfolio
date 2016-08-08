<?php

add_shortcode('nested-column', 'zorbix_nested_column');
function zorbix_nested_column($user_atts, $content = null)
{

	$v = array(
			'size'        => '', // col-md-3
			'width_lg'    => '', // col-lg-3
			'width_sm'    => '', // col-sm-3
			'width_xs'    => '', // col-sm-3
			'mb_lg'         => '',
			'mb_md'         => '',
			'mb_sm'         => '',
			'mb_xs'         => '',
			'bg_color'    => '',
			'bg_id'       => '',
			'inline'      => 'false',
			'bg_pos'      => '',
			'bg_size'     => '',
			'cols_equal'  => 'false',
			'center_text' => '',
			'cell'        => ''

	);

	$v = zorbix_sc::get_attr_set($v, array('margin', 'padding'));
	$v = shortcode_atts($v, $user_atts);

	$image_url = zorbix_img::get_src_from_id($v['bg_id']);

	$class = zorbix::join(
			'col',
			zorbix_sc::class_from_key('center_text', $v),
			zorbix_sc::class_from_key('cols_equal', $v),
			zorbix_sc::prepend($v['bg_size'], 'bg-'),
			zorbix_sc::prepend($v['bg_pos'], 'bg-'),
			zorbix_sc::prepend($v['mb_xs'], 'mb-xs-'),
			zorbix_sc::prepend($v['mb_sm'], 'mb-sm-'),
			zorbix_sc::prepend($v['mb_md'], 'mb-md-'),
			zorbix_sc::prepend($v['mb_lg'], 'mb-lg-'),
			zorbix::if_true($v['cell'], 'cell'),
			$v['size'],
			$v['width_lg'],
			$v['width_sm'],
			$v['width_xs']
	);

	return sprintf('<div class="%s" %s>%s</div>',
			$class,
			zorbix_sc::get_format_style_esc_multi(
					zorbix_sc::get_style_atts('spacing', $v),
					array(
							'background-color' => $v['bg_color'],
							'background-image' => $image_url,
					)),
			do_shortcode($content)
	);
}
