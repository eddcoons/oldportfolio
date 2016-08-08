<?php

// NO DASHES IN ATT NAMES
$pixo_map_params = array(
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'height', 'pixo' ),
		'param_name' => 'height',
		'value'      => array(
			'Default' => '',
			'100%'    => '1',
			'1/2'     => '1/2',
			'1/3'     => '1/3',
			'1/4'     => '1/4',
		)
	),
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'width', 'pixo' ),
		'param_name' => 'width',
		'value'      => array(
			'Default' => '',
			'100%'    => '1',
			'1/2'     => '1/2',
			'1/3'     => '1/3',
			'1/4'     => '1/4',
		)
	),

	array(
		'type'        => 'image',
		'heading'     => esc_html__( 'Logo', 'pixo' ),
		'param_name'  => 'logo',
		'description' => esc_html__( '', 'pixo' ),
	),
);


$pixo_map = array(
	'name'     => esc_html__( 'Selector', 'pixo' ),
	'base'     => 'selector',
	'icon'     => 'fa fa-th',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'params'   => $pixo_map_params
);

$pixo_map_name = zorbix_builder::add_map( $pixo_map );
zorbix_builder::add_to_map( $pixo_map_name, zorbix_maps::margin() );
zorbix_builder::add_to_map( $pixo_map_name, zorbix_maps::padding() );