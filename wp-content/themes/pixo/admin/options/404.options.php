<?php

zorbix_settings::add_panel(
	array(
		'name' => '404',
		'title'    => esc_html__('404 Page', 'pixo'),
		'priority' => 152,
	));

zorbix_settings::add_section(
	array(
		'name' => '404_background',
		'title'    => esc_html__('background', 'pixo'),
		'panel'    => '404',
		'priority' => 152,
	));

zorbix_settings::add_section(
	array(
		'name' => '404_text',
		'title'    => esc_html__('Text / Translation', 'pixo'),
		'panel'    => '404',
		'priority' => 152,
	));

zorbix_settings::set_section('404_text');

zorbix_settings::add_translate_field(array(
	'label'   => esc_html__('404 Paragraph Text', 'pixo'),
	'setting' => '404_paragraph_text',
	'default' => zorbix_helper::get_default('404_paragraph_text'),
));

zorbix_settings::add_translate_field(array(
	'label'   => esc_html__('Not Found Heading', 'pixo'),
	'setting' => 'not-found-heading',
	'default' => zorbix_helper::get_default('not-found-heading'),
));

zorbix_settings::add_translate_field(array(
	'label'   => esc_html__('404 Sub Heading', 'pixo'),
	'setting' => '404-sub-heading',
	'default' => zorbix_helper::get_default('404-sub-heading'),
));

zorbix_settings::add_field(array(
	'type'     => 'select',
	'setting'  => 'not-found-tint',
	'label'    => esc_html__('Tint Background', 'pixo'),
	'section'  => '404_background',
	'priority' => 10,
	'choices'  => array(
		''                 => esc_html__('None', 'pixo'),
		'light-gray-wash'  => esc_html__('Light Gray Wash', 'pixo'),
		'tint-theme-color' => esc_html__('Theme Color', 'pixo'),
		'white-wash'       => esc_html__('White Wash', 'pixo'),
		'tint'             => esc_html__('Light Tint', 'pixo'),
		'tint-medium'      => esc_html__('Medium Tint', 'pixo'),
		'tint-dark'        => esc_html__('Dark Tint', 'pixo'),
		'tint-blue-black'  => esc_html__('Blue Black Tint', 'pixo'),
		'tint-black'       => esc_html__('Black Tint', 'pixo'),
	),
));

zorbix_settings::add_field(
	array(
		'type'     => 'color',
		'setting'  => '404_text_color',
		'label'    => esc_html__('Text Color', 'pixo'),
		'section'  => '404_text',
		'default'  => '#fff',
		'priority' => 10,
		'output'   => array(
			array(
				'element'  => '.not-found, .not-found',
				'property' => 'color',
			)
		),
	));

zorbix_settings::add_field(array(
		'type'        => 'background',
		'setting'     => '404',
		'label'       => esc_html__('404', 'pixo'),
		'description' => esc_html__('Choose a background color or image for the blog header', 'pixo'),
		'section'     => '404_background',
		'default'     => array(
				'color'    => '',
				'image'    => '',
				'repeat'   => 'repeat',
				'size'     => '',
				'attach'   => '',
				'position' => 'center center',
		),
		'priority'    => 1,
		'output'      => '.not-found',
		'units'       => '',
));