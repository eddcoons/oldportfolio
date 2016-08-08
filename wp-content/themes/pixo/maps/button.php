<?php

$pixo_map = array(
	'name'     => esc_html__( 'Button', 'pixo' ),
	'base'     => 'button',
	'category' => 'Zorbix',
	'class'    => 'inlineblock',
	'icon'     => 'fa fa-external-link-square',
	'params'   => array(
		array(
			'type'        => 'textfield',
			'holder'      => 'div',
			'heading'     => esc_html__( 'Text', 'pixo' ),
			'param_name'  => 'heading',
			'value'       => esc_html__( 'Buttons name', 'pixo' ),
			'description' => esc_html__( 'This is the buttons label', 'pixo' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Size', 'pixo' ),
			'param_name' => 'size',
			'value'      => array(
				esc_html__( 'Default', 'pixo' )     => '',
				esc_html__( 'Extra Small', 'pixo' ) => 'btn-xs',
				esc_html__( 'Small', 'pixo' )       => 'btn-sm',
				esc_html__( 'Medium', 'pixo' )      => 'btn-md',
				esc_html__( 'Large', 'pixo' )       => 'btn-lg',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Style', 'pixo' ),
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Outline Dark', 'pixo' )       => 'btn-outline-dark',
				esc_html__( 'Theme Color', 'pixo' )   => 'btn-color',
				esc_html__( 'Solid', 'pixo' )         => 'btn-solid',
				esc_html__( 'Solid Dark', 'pixo' )    => 'btn-dark',
				esc_html__( 'White Outline', 'pixo' ) => 'btn-white',
				esc_html__( 'Success', 'pixo' )       => 'btn-success',
				esc_html__( 'Info', 'pixo' )          => 'btn-info',
				esc_html__( 'Warning', 'pixo' )       => 'btn-warning',
				esc_html__( 'Danger', 'pixo' )        => 'btn-danger',
			),
		),
		array(
			'type'        => 'textfield',
			'param_name'  => 'margin',
			'heading'     => esc_html__( 'Margin', 'pixo' ),
			'description' => esc_html__( 'in the format `Top Right Bottom Left` Eg: `0 0 20px 15px`', 'pixo' ),
		),
		array(
			'type'       => 'link',
			'heading'    => esc_html__( 'Link ', 'pixo' ),
			'param_name' => 'link',
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Block', 'pixo' ),
			'param_name'  => 'block',
			'description' => esc_html__( 'Wraps in a div so it has it\'s own line', 'pixo' )
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Smooth Jump', 'pixo' ),
			'param_ name' => 'smooth_jump',
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Center button', 'pixo' ),
			'param_name' => 'center_text',
			'value'      => array( '' => 'center-text' ),
			'dependency' => Array( 'element' => 'block', 'value' => 'true' ),
		),
	),
);

$pixo_map_name = zorbix_builder::add_map( $pixo_map );
zorbix_builder::add_to_map( $pixo_map_name, zorbix_maps::add_icon_map() );
