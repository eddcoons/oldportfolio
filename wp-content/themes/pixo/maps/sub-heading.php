<?php

// NO DASHES IN ATT NAMES

$pixo_map = array(
		'name'     => esc_html__( 'Sub heading', 'pixo' ),
		'base'     => 'sub-heading',
		'category' => esc_html__( 'Zorbix', 'pixo' ),
		'icon'     => 'fa fa-header',
		'params'   => array(
				array(
						'type'       => 'editor',
						'heading'    => esc_html__( 'Heading', 'pixo' ),
						'param_name' => 'content',
				),
		),
);

# Clients Map
zorbix_builder::add_map( $pixo_map );