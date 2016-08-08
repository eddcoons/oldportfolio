<?php

$pixo_panel_prefix = 'zorbix_-';

zorbix_settings::add_section(
	array(
		'name' => 'translate-portfolio',
		'title'    => esc_html__('Portfolio', 'pixo'),
		'priority' => 152,
	));

zorbix_settings::set_section('translate-portfolio');

zorbix_settings::add_translate_field(array(
	'label'       => esc_html__('Portfolio Custom Post Type', 'pixo'),
	'setting'     => 'portfolio_custom_post_type',
	'default'     => esc_html__('Project', 'pixo'),
	'description' => esc_html__('WARNING: If you change this, any existing projects will be hidden. Export before changing. You can change it back to the default `Project` to get hidden ones back or leave blank.',
		'pixo'),
));

zorbix_settings::add_field(array(
	'type'        => 'link',
	'setting'     => 'portfolio_link',
	'label'       => esc_html__('Link For main portfolio', 'pixo'),
	'description' => esc_html__('For page link', 'pixo'),
	'default'     => esc_url(get_admin_url() . 'portfolio'),
	'priority'    => 10,
));
