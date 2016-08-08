<?php


$pixo__image_sizes = zorbix_maps::get_image_sizes();

$pixo_params = array(
	array(
		'type'       => 'media',
		'heading'    => esc_html__('Image', 'pixo'),
		'param_name' => 'image_id',
	),
	array(
		'type'        => 'dropdown',
		'holder'      => 'div',
		'heading'     => esc_html__('Size', 'pixo'),
		'param_name'  => 'size', // No dashes!
		'description' => esc_html__('', 'pixo'),
		'value'       => $pixo__image_sizes, // Default
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Make circle', 'pixo'),
		'param_name'  => 'circle',
		'description' => esc_html__('Adds border radious to a image', 'pixo'),
		'value'       => array('' => 'true'),
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Make 100%', 'pixo'),
		'param_name'  => 'full_width',
		'description' => esc_html__('Make the image stretch to 100% of it\'s container', 'pixo'),
		'value'       => array('' => 'true'),
	),
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__('width', 'pixo'),
		'param_name'  => 'width',
		'description' => esc_html__('Leave blank for original width (has max width of container', 'pixo'),
	),

		array(
				'type'        => 'link',
				'heading'     => esc_html__('Link', 'pixo'),
				'param_name'  => 'link',
				'description' => esc_html__('Add a link', 'pixo'),
		),
);

$pixo_map = array(
	'name'     => esc_html__('Image', 'pixo'),
	'base'     => 'image',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-image',
	'params'   => $pixo_params
);

zorbix_builder::add_map($pixo_map);

zorbix_builder::add_to_map('image', zorbix_maps::padding());