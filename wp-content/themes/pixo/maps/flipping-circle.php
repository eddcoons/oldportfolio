<?php

// NO DASHES IN ATT NAMES
$pixo_map_params = array(
	array(
		'type'       => 'media',
		'heading'    => esc_html__('Image ID', 'pixo'),
		'param_name' => 'image_id',
	),
	array(
		'type'        => 'editor',
		'heading'     => esc_html__('Content', 'pixo'),
		'param_name'  => 'content', // No dashes!
		'description' => esc_html__('Text for the flip side', 'pixo'),
	),
);


$pixo_map = array(
	'name'     => esc_html__('Flipping Circle', 'pixo'),
	'base'     => 'flipping-circle',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-circle-o',
	'params'   => $pixo_map_params
);
