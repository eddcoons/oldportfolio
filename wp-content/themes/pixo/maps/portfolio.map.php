<?php
/*
 * Portfolio Visual composer Map
 */
zorbix_builder::add_map(array(
		'name'     => esc_html__('Portfolio', 'pixo'),
		'base'     => 'portfolio',
		'category' => esc_html__('Zorbix', 'pixo'),
		'icon'     => 'fa fa-th',
		'params'   => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'div',
				'heading'    => esc_html__('Number visible on load', 'pixo'),
				'description' => esc_html('Default 4'),
				'param_name' => 'show',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__('Hide load button', 'pixo'),
				'param_name' => 'loadbutton',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Load More Button Text', 'pixo'),
				'param_name' => 'load_more_text',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('All Text', 'pixo'),
				'param_name' => 'all_text',
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__('Disable Filter Menu?', 'pixo'),
				'param_name' => 'filter_menu',
			),
//			array(
//				'type'       => 'checkbox',
//				'heading'    => esc_html__( 'Disable In page load?', 'pixo' ),
//				'param_name' => 'disable_ajax',
//			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Thumb Height', 'pixo'),
				'param_name'  => 'port_height',
				'holder'      => 'div',
				'description' => 'Portfolio will never ',
				'value'       => array(
					'Original height (masonry)' => 'pixo_port_thumb',
					'Squares'                   => 'pixo_port_thumb_square',
					'Rectangles'                => 'pixo_port_thumb_rectangle',
				),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__('Gutter', 'pixo'),
				'param_name' => 'gutter',
				'value'      => array(esc_html__('Remove the gutter border', 'pixo') => 'port-no-gutter'),
			),
//			array(
//				'type'       => 'checkbox',
//				'heading'    => esc_html__( 'Port Tiles', 'pixo' ),
//				'param_name' => 'porttiles',
//				'value'      => array( esc_html__( 'Tiles variation', 'pixo' ) => 'port-tiles' ),
//			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__('Disable Large', 'pixo'),
				'param_name'  => 'disable_large',
				'description' => esc_html__('Disable the large size as set in the project - Makes images all the same width. Only relevant to rectangles', 'pixo'),
				'value'       => array('' => 'true'),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Columns', 'pixo'),
				'param_name'  => 'columns',
				'description' => esc_html__('How many in a row', 'pixo'),
				'value'       => array(
					'Default' => '',
					'Halfs'   => 'port-2',
					'Thirds'  => 'port-3',
					'Fourths' => 'port-4',
//					'Fifths'  => 'port-5',
				),
			),
		),
	)
);