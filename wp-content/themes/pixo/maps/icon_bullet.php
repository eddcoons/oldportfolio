<?php

$pixo_map = array(
	'name'     => esc_html__( 'Bullet Icon', 'pixo' ),
	'base'     => 'icon_bullet',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-list-ul',
	'description' => esc_html__('Adds a icon with after like a bullet list but a single line.', 'pixo'),
	'params'   => array(
		array(
			'type'        => 'editor',
			'holder'      => 'div',
			'heading'     => esc_html__( 'Heading', 'pixo' ),
			'param_name'  => 'content',
			'description' => esc_html__( 'Title under icon', 'pixo' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Size', 'pixo' ),
			'param_name'  => 'size',
			'value'       => array(
				'Small' => 'small',
				'Medium' => 'medium',
				'Large' => 'large',
			),
		),
		array(
			'type'       => 'textfield',
			'holder'     => 'div',
			'heading'    => esc_html__( 'Margin Bottom', 'pixo' ),
			'param_name' => 'mb',
		),
	),
);

$pixo_map_name = zorbix_builder::add_map( $pixo_map );
zorbix_builder::add_to_map( $pixo_map_name, zorbix_maps::add_icon_map() );