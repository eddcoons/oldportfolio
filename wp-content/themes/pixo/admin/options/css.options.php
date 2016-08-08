<?php
zorbix_settings::add_field(array(
	'type'        => 'background',
	'setting'     => 'blog_background',
	'label'       => esc_html__('Blog Heading Background', 'pixo'),
	'description' => esc_html__('Choose a background color or image for the blog banner background', 'pixo'),
	'section'     => 'blog-heading',
	'default'     => array(
		'color'    => '#f9f9f9',
		'image'    => '',
		'repeat'   => 'no-repeat',
		'size'     => 'cover',
		'attach'   => 'inherit',
		'position' => 'left-top',
	),
	'priority'    => 1,
	'output'      => '.blog-heading',
	'units'       => '',
));

zorbix_settings::add_field(array(
	'type'     => 'color',
	'setting'  => 'blog_heading_white',
	'label'    => esc_html__('Blog Header Color...', 'pixo'),
	'section'  => 'blog-heading',
	'default'  => '#444',
	'priority' => 10,
	'output'   => array(
		array(
			'element'  => '.blog-heading .section-title',
			'property' => 'color',
		),
	),
));