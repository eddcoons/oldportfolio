<?php

$zorbix_feature_list_map = array(
	'name'     => __( 'Icon with text', 'pixo' ),
	'base'     => 'feature-list',
	'category' => __( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-info',
	'params'   => array(

		array(
			'type'        => 'textfield',
			'holder'      => 'div',
			'heading'     => __( 'Heading', 'pixo' ),
			'param_name'  => 'heading',
			'description' => __( 'Title under icon', 'pixo' ),
		),

		array(
			'type'        => 'editor',
			'holder'      => 'div',
			'heading'     => __( 'Content', 'pixo' ),
			'param_name'  => 'content',
			'description' => __( 'Paragraph of text', 'pixo' ),
		),

		array(
			'type'       => 'textfield',
			'heading'    => __( 'Margin Bottom', 'pixo' ),
			'param_name' => 'mb',
		),

		array(
			'type'        => 'vc_link',
			'heading'     => __( 'Link', 'pixo' ),
			'param_name'  => 'link',
			'description' => __( 'Leave blank for none', 'pixo' ),
		),


		array(
			'type'        => 'dropdown',
			'heading'     => __( 'Align', 'pixo' ),
			// `-` breaks param_name
			'param_name'  => 'align',
			'group'       => __( 'Design', 'pixo' ),
			'description' => __( 'Align left for right', 'pixo' ),
			'value'       => array(
				'Left'   => 'left',
				'Center' => 'center',
			),
			// value is default
		),

		array(
			'type'       => 'dropdown',
			'holder'     => 'div',
			'group'      => __( 'Design', 'pixo' ),
			'heading'    => __( 'Size', 'pixo' ),
			'param_name' => 'size', // No dashes!
			'value'      => array(
				'Extra Large' => 'extra-large',
				'Large'       => 'large',
				'Medium'      => 'medium',
				'Small'       => 'small',
				'Extra Small' => 'extra-small',
			),
		),

	),
);

$zorbix_map_name = zorbix_builder::add_map( $zorbix_feature_list_map );

zorbix_builder::add_to_map( $zorbix_map_name,
	zorbix_maps::add_icon_map( array(
		'icon-border' => true
	) )
);