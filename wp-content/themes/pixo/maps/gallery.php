<?php

/*
 * Portfolio Visual composer Map
 */
$pixo_map_name = zorbix_builder::add_map(array(
		'name'     => esc_html__('Gallery', 'pixo'),
		'base'     => 'zbx-gallery',
		'category' => esc_html__('Zorbix', 'pixo'),
		'icon'     => 'fa fa-image',
		'params'   => array(
			array(
				'type'       => 'image_multi',
				'holder'     => 'image',
				'heading'    => esc_html__('Images', 'pixo'),
				'param_name' => 'images',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Image Size', 'pixo'),
				'param_name' => 'port_height',
				'holder'     => 'div',
				'value'      => zorbix_maps::get_image_sizes()
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Aspect Ratio', 'pixo'),
				'param_name'  => 'ratio',
				'description' => esc_html__('Square or rectangle', 'pixo'),
					'value' => array(
						'Rectangle' => 'rectangle',
							'Square' => 'squares',
					)
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Columns', 'pixo'),
				'param_name'  => 'columns',
				'description' => esc_html__('How many in a row', 'pixo'),
				'value'       => array(
					'Default' => 'col-md-4',
					'Halfs'   => 'col-md-6',
					'Thirds'  => 'col-md-4',
					'Fourths' => 'col-md-3',
				),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Unique ID', 'pixo'),
				'param_name'  => 'unique_id', // No dashes!
				'description' => esc_html__('For individual galleries', 'pixo'),
				'value'       => 'gallery', // Default
			),
		),
	)
);

zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::padding());