<?php

// NO DASHES IN ATT NAMES

$pixo_map = array(
	'name'     => esc_html__('Video', 'pixo'),
	'base'     => 'zorbix_video',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-video-camera',
	'params'   => array(
		array(
			'type'       => 'media',
			'heading'    => esc_html__('mp4', 'pixo'),
			'param_name' => 'mp4',
		),
		array(
			'type'       => 'media',
			'heading'    => esc_html__('webm', 'pixo'),
			'param_name' => 'webm',
		),
		array(
			'type'       => 'media',
			'heading'    => esc_html__('ogv', 'pixo'),
			'param_name' => 'ogv',
		),
		array(
			'type'       => 'media',
			'heading'    => esc_html__('poster', 'pixo'),
			'param_name' => 'poster',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__('height', 'pixo'),
			'param_name' => 'height',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__('width', 'pixo'),
			'param_name' => 'width',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__('ogv', 'pixo'),
			'param_name' => 'ogv',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__('Autoplay', 'pixo'),
			'param_name' => 'autoplay',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__('Preload', 'pixo'),
			'param_name' => 'preload',
		),
	),
);

$pixo_map_name = zorbix_builder::add_map($pixo_map);
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::margin());
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::padding());
