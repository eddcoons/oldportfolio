<?php


# Features Map
$pixo_map_name = 'feature';
zorbix_builder::add_map( array(
		'name'     => esc_html__( 'Feature', 'pixo' ),
		'base'     => $pixo_map_name,
		'category' => esc_html__( 'Zorbix', 'pixo' ),
		'icon'     => 'fa fa-info-circle',
		'params'   => array(
			array(
				'type'        => 'editor',
				'holder'      => 'div',
				'heading'     => esc_html__( 'Content', 'pixo' ),
				'param_name'  => 'content',
				'description' => esc_html__( 'Paragraph of text', 'pixo' ),
			),
		)
	)
);


zorbix_builder::add_to_map( $pixo_map_name, zorbix_maps::add_icon_map() );
