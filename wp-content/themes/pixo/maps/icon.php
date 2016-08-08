<?php

$pixo_map_name = zorbix_builder::add_map(array(
	'name'     => esc_html__('Icon', 'pixo'),
	'base'     => 'icon',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-info',
	'params'   => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__('Size', 'pixo'),
			'param_name' => 'size',
			'value'      => array(
				'Inherit' => '',
				'Small'   => 'small',
				'Medium'  => 'medium',
				'Large'   => 'large',
			),
		),

		array(
			'type'       => 'link',
			'holder'     => 'div',
			'heading'    => esc_html__('Link', 'pixo'),
			'param_name' => 'link', // No dashes!
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__('Style', 'pixo'),
			// `-` breaks param_name
			'param_name' => 'style',
			'value'      => array('Plain' => '', esc_html__('Circle', 'pixo') => 'style-circle'),
			// value is default
		),

		array(
			'type'        => 'dropdown',
			'holder'      => 'div',
			'heading'     => esc_html__('Spacing', 'pixo'),
			'param_name'  => 'spacing', // No dashes!
			'description' => esc_html__('Left and bottom spacing', 'pixo'),
			'value'       => array(
				'0'  => '0',
				'5'  => 'm-5',
				'10' => 'm-10',
				'15' => 'm-15',
				'20' => 'm-20',
			), // Default
		),
	),
));

zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::add_icon_map(array( 'icon-bg' => true)));
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::margin());
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::padding());

