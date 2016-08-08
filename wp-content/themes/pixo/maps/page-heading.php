<?php

// NO DASHES IN ATT NAMES

$pixo_map = array(
		'name'     => esc_html__( 'page-heading', 'pixo' ),
		'base'     => 'page-heading',
		'category' => esc_html__( 'Zorbix', 'pixo' ),
		'icon'     => 'fa fa-header',
		'params'   => array(
				array(
						'type'       => 'textfield',
						'heading'    => esc_html__( 'Heading', 'pixo' ),
						'param_name' => 'content',
				),
				array(
						'type'        => 'colorpicker',
						'heading'     => esc_html__('Text Color', 'pixo'),
						'param_name'  => 'color',
						'description' => esc_html__('Change the text color', 'pixo'),
				),

				array(
						'type'        => 'dropdown',
						'heading'     => esc_html__('Size', 'pixo'),
						'param_name'  => 'size',
						'description' => esc_html__('Set the font size', 'pixo'),
						'value'       => array(
								'Default' => '',
								'Small' => 'small',
								'Medium' => 'medium',
								'Large' => 'large',
						), // Default
				),
		),
);

# Clients Map
zorbix_builder::add_map( $pixo_map );