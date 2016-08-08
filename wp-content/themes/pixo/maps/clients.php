<?php

$clients_map = array(
		'name'     => esc_html__( 'Clients', 'pixo' ),
		'base'     => 'clients',
		'category' => esc_html__( 'Zorbix', 'pixo' ),
		'icon'     => 'fa fa-user',
		'params'   => array(
				array(
						'holder'     => 'id',
						'type'       => 'image',
						'heading'    => esc_html__( 'Image ID', 'pixo' ),
						'param_name' => 'id',
				),
				array(
						'type'        => 'link',
						'heading'     => esc_html__( 'Link', 'pixo' ),
						'param_name'  => 'link',
						'description' => esc_html__( 'Optional link', 'pixo' ),
				),
				array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Add Hover effect', 'pixo' ),
						'param_name'  => 'hover_effect',
						'description' => esc_html__( 'Adds a light up effect (starts dimmed', 'pixo' ),
						'value'       => array( '' => 'true' ),
				),
		),
);

# Clients Map
zorbix_builder::add_map( $clients_map );