<?php

// NO DASHES IN ATT NAMES
$pixo_map_params = array(
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__('Type', 'pixo'),
		'param_name' => 'type',
		'value'      => array(
			'Notice'  => 'notice',
			'Warning' => 'warning',
			'Success' => 'success',
			'Error'   => 'error'
		)
	),

	// Content
	array(
		'type'       => 'editor',
		'holder'     => 'div',
		'heading'    => esc_html__('Content', 'pixo'),
		'param_name' => 'content', // No dashes!
	),
);


$pixo_map = array(
	'name'     => esc_html__('Alerts', 'pixo'),
	'base'     => 'alert',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-warning',
	'params'   => $pixo_map_params
);

$pixo_map_name = zorbix_builder::add_map($pixo_map);
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::margin());
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::padding());