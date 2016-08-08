<?php
# Features Map
zorbix_builder::add_map(array(
	'name'     => esc_html__('Sharing', 'pixo'),
	'base'     => 'sharing',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-share-alt ',
	'params'   => array(
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__('Twitter', 'pixo'),
			'param_name'  => 'twitter',
			'description' => esc_html__('Share on Twitter', 'pixo'),
			'value'       => array('' => 'true'),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__('Facebook', 'pixo'),
			'param_name'  => 'facebook',
			'description' => esc_html__('Share on Facebook', 'pixo'),
			'value'       => array('' => 'true'),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__('Pinterest', 'pixo'),
			'param_name'  => 'pinterest',
			'description' => esc_html__('Share on Pinterest', 'pixo'),
			'value'       => array('' => 'true'),
		),
	),
));