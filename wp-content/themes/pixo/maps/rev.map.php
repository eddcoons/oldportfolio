<?php

if (class_exists('RevSlider')) {
	$pixo_rev_class = new RevSlider();
	$pixo_sliders_array = $pixo_rev_class->getArrSliders();

	$pixo_rev_dropdown = array();
	if ($pixo_sliders_array) {
		foreach ($pixo_sliders_array as $pixo_rev_slider) {
			$pixo_rev_dropdown[$pixo_rev_slider->getTitle()] = $pixo_rev_slider->getAlias();
		}
	} else {
		$pixo_rev_dropdown[__('No sliders found', 'pixo')] = 0;
	}

} else {
	$pixo_rev_dropdown[__('No sliders found', 'pixo')] = 0;
}


// NO DASHES IN ATT NAMES
$pixo_map_params = array(
	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__('Select Slider', 'pixo'),
		'param_name' => 'alias',
		'value'      => $pixo_rev_dropdown
	),
);


$pixo_map = array(
	'name'     => esc_html__('Revolution slider', 'pixo'),
	'base'     => 'rev',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-refresh',
	'params'   => $pixo_map_params
);

$pixo_map_name = zorbix_builder::add_map($pixo_map);