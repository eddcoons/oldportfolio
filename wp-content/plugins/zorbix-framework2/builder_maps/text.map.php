<?php

# Map
zorbix_builder::add_map(array(
	'name' => esc_html__('Text', 'pixo'),
	'base' => 'text',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon' => 'fa fa-align-justify',
	"as_parent" => array('except' => ''),
	'content_element' => true,
	'params' => array(
		array(
			'type' => 'editor',
			'holder' => 'h1',
			'heading' => esc_html__('Content', 'pixo'),
			'param_name' => 'content',
		),

		// Padding
		array(
			'type' => 'textfield',
			'holder' => 'div',
			'heading' => esc_html__('Padding', 'pixo'),
			'param_name' => 'padding',
			'group' => esc_html__('padding', 'pixo'),
		),
		array(
			'type' => 'textfield',
			'holder' => 'div',
			'heading' => esc_html__('Padding Top', 'pixo'),
			'param_name' => 'padding_top',
			'group' => esc_html__('padding', 'pixo'),
		),

		array(
			'type' => 'textfield',
			'holder' => 'div',
			'heading' => esc_html__('Padding Right', 'pixo'),
			'param_name' => 'padding_right',
			'group' => esc_html__('padding', 'pixo'),
		),
		array(
			'type' => 'textfield',
			'holder' => 'div',
			'heading' => esc_html__('Padding Bottom', 'pixo'),
			'param_name' => 'padding_bottom',
			'group' => esc_html__('padding', 'pixo'),
		),
		array(
			'type' => 'textfield',
			'holder' => 'div',
			'heading' => esc_html__('Padding Left', 'pixo'),
			'param_name' => 'padding_left',
			'group' => esc_html__('padding', 'pixo'),
		),
	)
),
	array('animation', 'makewhite', 'image', 'icon')
);
