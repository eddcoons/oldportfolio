<?php
/*
 * >Footer
 */

zorbix_settings::add_panel(
	array(
		'name'     => 'footer',
		'title'    => esc_html__('Footer', 'pixo'),
		'priority' => 152,
	)
);

zorbix_settings::add_section(array(
	'name'  => 'footer_general',
	'title' => esc_html__('Footer General', 'pixo'),
	'panel' => 'footer',
));

zorbix_settings::set_section('footer_general', 'footer_');

if (is_customize_preview()) {
	zorbix_settings::add_field(array(
		'type'    => 'radio',
		'setting' => 'show',
		'label'   => esc_html__('Show Footer', 'pixo'),
		'default' => zorbix_helper::get_default('footer_show'),
			'choices'     => array(
			'on'              => esc_html__('On', 'pixo'),
			'hide-triangle' => esc_html__('Off', 'pixo'),
	),
	));

	zorbix_settings::add_field(array(
		'type'        => 'text',
		'setting'     => 'copy',
		'label'       => esc_html__('Footer Copy', 'pixo'),
		'description' => esc_html__('Set the footer copy notice', 'pixo'),
		'default'     => zorbix_helper::get_default('footer-copy'),
	));
}


zorbix_settings::add_field(
	array(
		'type'     => 'color',
		'setting'  => 'copy_color',
		'label'    => esc_html__('Copy Color', 'pixo'),
		'default'  => '#777',
		'priority' => 10,
		'output'   => array(
			array(
				'element'  => '.footer .copy',
				'property' => 'color',
			)
		),
	));


zorbix_settings::add_field(
	array(
		'type'     => 'color',
		'setting'  => 'text_color',
		'label'    => esc_html__('Text Color', 'pixo'),
		'default'  => '#777',
		'priority' => 10,
		'output'   => array(
			array(
				'element'  => '.footer',
				'property' => 'color',
			)
		),
	));


zorbix_settings::add_field(
	array(
		'type'     => 'color',
		'setting'  => 'heading_color',
		'label'    => esc_html__('Heading Color', 'pixo'),
		'default'  => '#ccc',
		'priority' => 10,
		'output'   => array(
			array(
				'element'  => '.footer .widget-title',
				'property' => 'color',
			)
		),
	));


zorbix_settings::add_field(array(
	'type'        => 'color',
	'setting'     => 'background',
	'label'       => esc_html__('Footer Background', 'pixo'),
	'description' => esc_html__('Choose a background color or image for the footer', 'pixo'),
	'priority'    => 1,
	'output'   => array(
			array(
				'element'  => '#footer',
				'property' => 'background-color',
			)
		),
	'units'       => '',
));