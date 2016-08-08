<?php

$pixo_map = array(
	'name'     => esc_html__( 'Row', 'pixo' ),
	'base'     => 'row',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-bars',
	'params'   => array(
		array(
			'type'        => 'textfield',
			'holder'      => 'div',
			'heading'     => esc_html__( 'Margin Bottom', 'pixo' ),
			'param_name'  => 'margin_bottom', // No dashes!
		),
		array(
			'type'        => 'colorpicker',
			'holder'      => 'div',
			'heading'     => esc_html__('Background Color', 'pixo'),
			'param_name'  => 'bg_color',
			'description' => 'Choose a colored background',
			'group'       => esc_html__('Background', 'pixo'),
		),
	)
);

zorbix_builder::add_map( $pixo_map );