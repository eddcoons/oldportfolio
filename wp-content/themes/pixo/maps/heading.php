<?php

zorbix_builder::add_map(
	array(
		'name'     => esc_html__('Section Heading', 'pixo'),
		'base'     => 'heading',
		'category' => esc_html__('Zorbix', 'pixo'),
		'icon'     => 'fa fa-header',
		'params'   => array(
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Sub Heading', 'pixo'),
				'param_name' => 'pre',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Heading', 'pixo'),
				'param_name' => 'heading',
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Description', 'pixo'),
				'param_name' => 'content',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Margin Bottom', 'pixo'),
				'param_name' => 'margin_bottom',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__('Align center', 'pixo'),
				'param_name' => 'align',
				'value'      => array('' => 'true'),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__('Add Dash', 'pixo'),
				'param_name'  => 'dash',
				'description' => esc_html__('Add a small underline under heading', 'pixo'),
				'value'       => array('' => 'true'),
			),
			array(
				'type'        => 'dropdown',
				'holder'      => 'div',
				'heading'     => esc_html__('Heading Size', 'pixo'),
				'param_name'  => 'heading_size', // No dashes!
				'description' => esc_html__('H1, H2 etc', 'pixo'),
				'value'       => array(
					'Heading 1' => '1',
					'Heading 2' => '2',
					'Heading 3' => '3',
					'Heading 4' => '4',
					'Heading 5' => '5',
					'Heading 6' => '6',
				),
			),
		),
	),
	array('makewhite', 'margin_bottom')
);