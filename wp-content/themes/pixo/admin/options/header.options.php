<?php

zorbix_settings::add_section(
	array(
		'name'  => 'header_general',
		'title' => esc_html__( 'Menu', 'pixo' ),
	) );
zorbix_settings::set_section( 'header_general' );

zorbix_settings::add_field( array(
	'type'        => 'radio',
	'setting'     => 'menu_overlay',
	'label'       => esc_attr__( 'Menu Overlay triangle', 'pixo' ),
	'default'     => '',
	'priority'    => 10,
	'description' => esc_html__( 'Triangle or solid menu background', 'pixo' ),
	'choices'     => array(
		''              => esc_html__( 'Triangle', 'pixo' ),
		'hide-triangle' => esc_html__( 'Solid', 'pixo' ),
	),
) );


zorbix_settings::add_section(
		array(
				'name'  => 'logo',
				'title' => esc_html__( 'Logo', 'pixo' ),
		) );
zorbix_settings::set_section( 'logo' );

zorbix_settings::add_field( array(
	'type'        => 'number',
	'setting'     => 'logo_height',
	'label'       => esc_html__( 'Logo Height', 'pixo' ),
	'description' => esc_html__( 'Will not extend original size of image', 'pixo' ),
	'default'     => '60',
	'output'      => array(
		array(
			'element'  => '.logo-triangle .logo',
			'property' => 'width',
			'units'    => 'px',
		),
	),
) );

zorbix_settings::add_field( array(
		'type'        => 'number',
		'setting'     => 'triangle_size',
		'label'       => esc_html__( 'Triangle Size', 'pixo' ),
		'description' => esc_html__( 'Size of the triangle the logo is in', 'pixo' ),
		'default'     => '300',
		'output'      => array(
				array(
						'element'  => '.logo-triangle svg',
						'property' => 'height',
						'units'    => 'px',
				),
		),
) );