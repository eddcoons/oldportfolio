<?php

$pixo_map_params = array(
	array(
		'type'       => 'textfield',
		'heading'    => esc_html__('Count', 'pixo'),
		'param_name' => 'count',
	),
	array(
		'type'       => 'textfield',
		'holder'     => 'div',
		'heading'    => esc_html__('Heading', 'pixo'),
		'param_name' => 'heading',
	),
);


$pixo_map = array(
	'name'     => esc_html__('Milestone', 'pixo'),
	'base'     => 'milestone',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-trophy',
	'params'   => $pixo_map_params
);

$pixo_map_name = zorbix_builder::add_map($pixo_map);
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::add_icon_map());
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::margin());
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::padding());