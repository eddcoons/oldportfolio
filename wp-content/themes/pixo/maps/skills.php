<?php

zorbix_builder::add_map( array(
	'name'     => esc_html__( 'Skill', 'pixo' ),
	'base'     => 'skill',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-bar-chart',
	'params'   => array(
		array(
			'type'       => 'textfield',
			'holder'     => 'div',
			'heading'    => esc_html__( 'Title', 'pixo' ),
			'param_name' => 'content',
		),
		array(
			'type'       => 'textfield',
			'holder'     => 'div',
			'heading'    => esc_html__( 'Percent', 'pixo' ),
			'param_name' => 'percent',
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Custom background color', 'pixo' ),
			'param_name'  => 'bar_color',
			'description' => esc_html__( 'Change the color to custom color', 'pixo' ),
			'dependency'  => array( 'element' => 'bar-color', 'value' => array( 'custom' ) )
		),

	)
), array( 'makewhite' ) );
