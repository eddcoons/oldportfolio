<?php

$pixo_map = array(
	'name'     => esc_html__( 'Row', 'pixo' ),
	'base'     => 'row',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-bars',
	'params'   => array(
		array(
			'type'        => 'textfield',
			'holder'      => 'div',
			'heading'     => esc_html__( 'Margin Bottom', 'pixo' ),
			'param_name'  => 'margin_bottom', // No dashes!
		),
	)
);

zorbix_builder::add_map( $pixo_map );