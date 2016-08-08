<?php

$pixo_params = array(
	array(
		'type'       => 'checkbox',
		'heading'    => esc_html__('Disable Images', 'pixo'),
		// `-` breaks param_name
		'param_name' => 'images',
		'value'      => array('' => 'true'),
		// value is default
	),

		array(
				'type'        => 'checkbox',
				'heading'     => esc_html__('Disable Media', 'pixo'),
			// `-` breaks param_name
				'param_name'  => 'disable_post_types',
				'description' => esc_html__("Don't show post type media - ie don't show quotes and links", 'pixo'),
				'value'       => array('' => 'true'),
			// value is default
		),
);

$pixo_map_name = 'latest_posts';

$pixo_params = array(
	'name'     => esc_html__('Latest Posts', 'pixo'),
	'base'     => $pixo_map_name,
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-file-text',
	'params'   => $pixo_params
);

zorbix_builder::add_map($pixo_params);

zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::get_tax_params('category'));

zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::get_column_params());
