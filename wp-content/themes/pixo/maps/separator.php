<?php

function zorbix_get_preset_colors()
{
	return array(
		'Black'     => 'bd-black',
		'Dark Gray' => 'bd-dark-gray',
		'White'     => 'bd-white'
	);
}

$pixo_map = array(

	'name'     => esc_html__('Separator', 'pixo'),
	'base'     => 'separator',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-arrows-v',
	'params'   => array(
		array(
			'type'        => 'dropdown',
			'holder'      => 'div',
			'heading'     => esc_html__('Preset Colors', 'pixo'),
			'param_name'  => 'color_class', // No dashes!
			'description' => esc_html__('Color added via class', 'pixo'),
			'value'       => zorbix_get_preset_colors(), // Default
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__('Color', 'pixo'),
			'param_name'  => 'color',
			'description' => esc_html__('Custom color added via inline style', 'pixo'),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__('Line', 'pixo'),
			'param_name'  => 'line',
			'description' => esc_html__('No padding', 'pixo'),
			'value'       => array('' => 'true'),
		),
	),
);

zorbix_builder::add_map($pixo_map);