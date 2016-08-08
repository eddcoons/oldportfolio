<?php

function pixo_get_cf7_forms() {
	$args           = array( 'post_type' => 'wpcf7_contact_form', 'posts_per_page' => - 1 );
	$cf7_array = array();
	if ( $cf7Forms = get_posts( $args ) ) {
		foreach ( $cf7Forms as $cf7Form ) {
			$cf7_array[$cf7Form->post_title] = $cf7Form->ID;
		}
		return $cf7_array;
	}
}

$pixo_params = array(
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__( 'Form ID', 'pixo' ),
		'param_name' => 'id',
		'value'      => pixo_get_cf7_forms()
	),
);

$pixo_ContactFormMap = array(
	'name'     => esc_html__( 'Contact Form', 'pixo' ),
	'base'     => 'contact-form-7',
	'category' => esc_html__( 'Zorbix', 'pixo' ),
	'icon'     => 'fa fa-envelope',
	'params'   => $pixo_params,
);


zorbix_builder::add_map( $pixo_ContactFormMap );


