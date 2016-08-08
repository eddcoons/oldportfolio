<?php

zorbix_settings::add_panel(
		array(
			'name' => 'general',
				'title'    => esc_html__('General', 'pixo'),
				'priority' => 132,
		));

zorbix_settings::add_section(
		array(
				'name' => 'general',
				'title' => esc_html__('General', 'pixo'),
				'panel' => 'general',
		));

zorbix_settings::add_field(array(
	'type'     => 'checkbox',
	'setting'  => 'enable_preloader',
	'label'    => esc_html__('Enable Preloader', 'pixo'),
	'section'  => 'general',
	'help' => esc_html__('Enable or disable the preloader', 'pixo'),
	'default'  => 0,
	'priority' => 10,
));

zorbix_settings::add_field(array(
	'type'        => 'radio',
	'setting'     => 'enable_backtotop',
	'label'       => esc_html__('Enable back to top button', 'pixo'),
	'description' => esc_html__('Show back to top button', 'pixo'),
	'section'     => 'general',
	'default'     => zorbix_settings::get_default('enable_backtotop'),
	'priority'    => 10,
		'choices' => array(
			'on' => 'On',
				'off' => 'Off'
		)
));

zorbix_settings::add_field(array(
	'type'        => 'color',
	'setting'     => 'theme_color',
	'label'       => esc_html__('Theme Color', 'pixo'),
	'description' => esc_html__('Set the theme color', 'pixo'),
	'section'     => 'general',
	'priority'    => 10,
	'default'     => '#009EC6',
	'output'      => array(
		array(
			'element'  => '.btn-color, .contact-form .wpcf7-submit, .contact-button, .comment-form #submit, .zx-icon.style-circle, .portfolio-wrapper .load-more, .tint-theme-color:before',
			'property' => 'background-color',
		),
		array(
			'element'  => '.feature-list-item i, .feature .zx-icon, a, .milestone i, .blog-meta a',
			'property' => 'color'
		),
		array(
			'element'  => '.dash:after, .feature-list-item i, .portfolio-wrapper .load-more',
			'property' => 'border-color'
		),

	),
));


