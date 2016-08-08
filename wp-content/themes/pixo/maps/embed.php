<?php

// NO DASHES IN ATT NAMES
$pixo_map_params = array(
	array(
		'type'        => 'info',
		'heading'     => esc_html__('Note', 'pixo'),
		'param_name'  => 'info',
		'description' => esc_html__('', 'pixo'),
	),
	array(
		'type'       => 'textfield',
		'heading'    => esc_html__('Width', 'pixo'),
		'param_name' => 'width',
	), array(
		'type'       => 'textfield',
		'heading'    => esc_html__('Height', 'pixo'),
		'param_name' => 'height',
	),
	array(
		'type'       => 'textfield',
		'holder'     => 'div',
		'heading'    => esc_html__('Embed Url', 'pixo'),
		'param_name' => 'content', // No dashes!
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Disable Responsive', 'pixo'),
		'param_name'  => 'disable_responsive', // No dashes!
		'description' => esc_html__('By default the video will be the width of the container, to set a fixed with, disable this option', 'pixo'),
	),
);


$pixo_map = array(
	'name'        => esc_html__('Embed', 'pixo'),
	'base'        => 'zorbix_embed',
	'category'    => esc_html__('Zorbix', 'pixo'),
	'icon'        => 'fa fa-file-video-o',
	'params'      => $pixo_map_params,
	'description' => esc_html('Wrapper for the WordPress function https://codex.eddcoons_portfolio.org/Embeds')
);

$pixo_map_name = zorbix_builder::add_map($pixo_map);
zorbix_builder::add_to_map($pixo_map_name, zorbix_maps::margin());