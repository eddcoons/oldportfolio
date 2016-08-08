<?php

$pixo_map = array(
		'name'     => esc_html__( 'Testimonials', 'pixo' ),
		'base'     => 'testimonials',
		'category' => esc_html__( 'Zorbix', 'pixo' ),
		'icon'     => 'fa fa-user',
		'params'   => array(
				array(
						'type'        => 'checkbox',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Center Text', 'pixo' ),
						'param_name'  => 'center_text', // No dashes!
						'description' => esc_html__( '', 'pixo' ),
						'value'       => '', // Default
				),
				array(
						'type'        => 'textfield',
						'holder'      => 'div',
						'heading'     => esc_html__( 'Margin Bottom', 'pixo' ),
						'param_name'  => 'margin-bottom', // No dashes!
				),
		),
);

zorbix_builder::add_map( $pixo_map  );