<?php

// NO DASHES IN ATT NAMES
$pixo_map_params = array(

	array(
		'type'        => 'range',
		'holder'      => 'div',
		'heading'     => esc_html__('Zoom', 'pixo'),
		'param_name'  => 'zoom',
		'description' => esc_html__('How far to zoom in to the map', 'pixo'),
		'value'       => '10',
		'min'         => '1',
		'max'         => '16',
	),
	array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'heading'     => esc_html__('Address', 'pixo'),
		'param_name'  => 'address',
		'description' => esc_html__(
			'Center of map. Lines of address or lat and lang separated by commas',
			'pixo'
		),
		'value'       => 'Kensington Gardens Square, London, UK',
	),
	array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'heading'     => esc_html__('Optional: Markers', 'pixo'),
		'param_name'  => 'markers',
		'description' => esc_html__(
			'Leave blank to use above. List of markers in this format `{54.236107, -4.548056}, {43, Kensington, London}',
			'pixo'
		),
	),
	array(
		'type'        => 'checkbox',
		'holder'      => 'div',
		'heading'     => esc_html__('Enable collapsible map', 'pixo'),
		'param_name'  => 'wrapper',
		'description' => esc_html__('Just map or map in collapsible container', 'pixo'),
		'value'       => array('' => 'true'),
	),
);


$pixo_map = array(
	'name'     => esc_html__('map', 'pixo'),
	'base'     => 'map',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-location-arrow',
	'params'   => $pixo_map_params
);

$pixo_map_name = zorbix_builder::add_map($pixo_map);