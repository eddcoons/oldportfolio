<?php

$pixo_params = array(
	array(
		'type'        => 'dropdown',
		'holder'      => 'div',
		'heading'     => esc_html__('Width large', 'pixo'),
		'description' => esc_html__('Column width below (col-lg-*)', 'pixo'),
		'param_name'  => 'width_lg',
		'value'       => array(
			esc_html__('None', 'pixo')                  => '',
			esc_html__('1 or 1/12 cols', 'pixo')        => 'col-lg-1',
			esc_html__('2 or 2/12 cols', 'pixo')        => 'col-lg-2',
			esc_html__('3 or 1/4 cols', 'pixo')         => 'col-lg-3',
			esc_html__('4 or 1/3 cols', 'pixo')         => 'col-lg-4',
			esc_html__('5 cols', 'pixo')                => 'col-lg-5',
			esc_html__('6 or 1/2 cols', 'pixo')         => 'col-lg-6',
			esc_html__('7 cols', 'pixo')                => 'col-lg-7',
			esc_html__('8 cols or 2/3', 'pixo')         => 'col-lg-8',
			esc_html__('9 cols', 'pixo')                => 'col-lg-9',
			esc_html__('10 cols', 'pixo')               => 'col-lg-10',
			esc_html__('11 cols', 'pixo')               => 'col-lg-11',
			esc_html__('12 cols or full width', 'pixo') => 'col-lg-12',
		),
	),

	array(
		'type'       => 'checkbox',
		'heading'    => esc_html__('Cell', 'pixo'),
		'param_name' => 'cell',
		'value'      => array('' => 'true'),
	),

	array(
		'type'        => 'dropdown',
		'holder'      => 'div',
		'heading'     => esc_html__('Width medium', 'pixo'),
		'description' => esc_html__('Column width below (col-md-*)', 'pixo'),
		'param_name'  => 'size',
		'value'       => array(
			esc_html__('None', 'pixo')                  => '',
			esc_html__('1 or 1/12 cols', 'pixo')        => 'col-md-1',
			esc_html__('2 or 2/12 cols', 'pixo')        => 'col-md-2',
			esc_html__('3 or 1/4 cols', 'pixo')         => 'col-md-3',
			esc_html__('4 or 1/3 cols', 'pixo')         => 'col-md-4',
			esc_html__('5 cols', 'pixo')                => 'col-md-5',
			esc_html__('6 or 2/4 or 1/2 cols', 'pixo')  => 'col-md-6',
			esc_html__('7 cols', 'pixo')                => 'col-md-7',
			esc_html__('8 cols or 2/3', 'pixo')         => 'col-md-8',
			esc_html__('9 cols', 'pixo')                => 'col-md-9',
			esc_html__('10 cols', 'pixo')               => 'col-md-10',
			esc_html__('11 cols', 'pixo')               => 'col-md-11',
			esc_html__('12 cols or full width', 'pixo') => 'col-md-12',
		),
	),

	array(
		'type'        => 'dropdown',
		'holder'      => 'div',
		'heading'     => esc_html__('Width small', 'pixo'),
		'description' => esc_html__('Column width below (col-sm-*)', 'pixo'),
		'param_name'  => 'width_sm',
		'value'       => array(
			esc_html__('None', 'pixo')                  => '',
			esc_html__('1 or 1/12 cols', 'pixo')        => 'col-sm-1',
			esc_html__('2 or 2/12 cols', 'pixo')        => 'col-sm-2',
			esc_html__('3 or 1/4 cols', 'pixo')         => 'col-sm-3',
			esc_html__('4 or 1/3 cols', 'pixo')         => 'col-sm-4',
			esc_html__('5 cols', 'pixo')                => 'col-sm-5',
			esc_html__('6 or 2/4 or 1/2 cols', 'pixo')  => 'col-sm-6',
			esc_html__('7 cols', 'pixo')                => 'col-sm-7',
			esc_html__('8 cols or 2/3', 'pixo')         => 'col-sm-8',
			esc_html__('9 cols', 'pixo')                => 'col-sm-9',
			esc_html__('10 cols', 'pixo')               => 'col-sm-10',
			esc_html__('11 cols', 'pixo')               => 'col-sm-11',
			esc_html__('12 cols or full width', 'pixo') => 'col-sm-12',
		),
	),

	array(
		'type'        => 'dropdown',
		'holder'      => 'div',
		'heading'     => esc_html__('Width extra small', 'pixo'),
		'description' => esc_html__('Column width below (col-xs-*)', 'pixo'),
		'param_name'  => 'width_xs',
		'value'       => array(
			esc_html__('None', 'pixo')                  => '',
			esc_html__('1 or 1/12 cols', 'pixo')        => 'col-xs-1',
			esc_html__('2 or 2/12 cols', 'pixo')        => 'col-xs-2',
			esc_html__('3 or 1/4 cols', 'pixo')         => 'col-xs-3',
			esc_html__('4 or 1/3 cols', 'pixo')         => 'col-xs-4',
			esc_html__('5 cols', 'pixo')                => 'col-xs-5',
			esc_html__('6 or 2/4 or 1/2 cols', 'pixo')  => 'col-xs-6',
			esc_html__('7 cols', 'pixo')                => 'col-xs-7',
			esc_html__('8 cols or 2/3', 'pixo')         => 'col-xs-8',
			esc_html__('9 cols', 'pixo')                => 'col-xs-9',
			esc_html__('10 cols', 'pixo')               => 'col-xs-10',
			esc_html__('11 cols', 'pixo')               => 'col-xs-11',
			esc_html__('12 cols or full width', 'pixo') => 'col-xs-12',
		),
	),

	array(
		'type'        => 'colorpicker',
		'holder'      => 'div',
		'heading'     => esc_html__('Background Color', 'pixo'),
		'param_name'  => 'bg_color',
		'description' => 'Choose a pre set colored background',
	),

	array(
		'type'       => 'media',
		'holder'     => 'div',
		'heading'    => esc_html__('Image', 'pixo'),
		'param_name' => 'bg_id',
	),
//	array(
//		'type'        => 'checkbox',
//		'holder'      => 'div',
//		'heading'     => esc_html__('Equal Nested Columns', 'pixo'),
//		'param_name'  => 'cols_equal', // No dashes!
//		'description' => esc_html__('Make inner nested columns the same height', 'pixo'),
//		'value'       => 'false', // Default
//	),
	array(
		'type'       => 'checkbox',
		'holder'     => 'div',
		'heading'    => esc_html__('Center Text', 'pixo'),
		'param_name' => 'center_text', // No dashes!
	),
);


zorbix_builder::add_map(array(
	'name'     => esc_html__('Nested Column', 'pixo'),
	'base'     => 'nested-column',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-columns',
	'params'   => $pixo_params
));

zorbix_builder::add_map(array(
	'name'     => esc_html__('Column', 'pixo'),
	'base'     => 'column',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-columns',
	'params'   => $pixo_params
));

zorbix_builder::add_to_map('column', zorbix_maps::margin());
zorbix_builder::add_to_map('nested-column', zorbix_maps::margin());
zorbix_builder::add_to_map('column', zorbix_maps::padding());
zorbix_builder::add_to_map('nested-column', zorbix_maps::padding());

