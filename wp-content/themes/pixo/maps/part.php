<?php

$pixo_params = array(
	array(
		'type'       => 'media',
		'heading'    => esc_html__( 'Image ID', 'pixo' ),
		'param_name' => 'image_id',
	),

	// link
	array(
		'type'       => 'link',
		'holder'     => 'div',
		'heading'    => esc_html__( 'Link', 'pixo' ),
		'param_name' => 'link', // No dashes!
	),

	// Overlay Text
	array(
		'type'        => 'textfield',
		'heading'     => esc_html__( 'Overlay Text', 'pixo' ),
		'param_name'  => 'overlay_text', // No dashes!
		'description' => esc_html__( "Hover text", 'pixo' ),
	),

	// Jump number
	array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'heading'     => esc_html__( 'Jump To Number', 'pixo' ),
		'param_name'  => 'jump_num', // No dashes!
		'description' => esc_html__( "Number of section to jump to - only for scroller. Don't set link as well.", 'pixo' ),
		'value'       => '', // Default
	),

	// Background Color
	array(
		'type'       => 'colorpicker',
		'holder'     => 'div',
		'heading'    => esc_html__( 'Background Color', 'pixo' ),
		'param_name' => 'bg_color', // No dashes!
	),
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

	// Caption
	array(
		'type'        => 'editor',
		'group' => esc_html__( 'Text' , 'pixo' ),
		'heading'     => __( 'Text', 'pixo' ),
		'param_name'  => 'content',
		'description' => __( 'Add text over the image', 'pixo' ),
	),
);

$pixo_params = array(
	'name'     => esc_html__( 'Part', 'pixo' ),
	'base'     => 'part',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-image',
	'params'   => $pixo_params
);

zorbix_builder::add_map( $pixo_params );
