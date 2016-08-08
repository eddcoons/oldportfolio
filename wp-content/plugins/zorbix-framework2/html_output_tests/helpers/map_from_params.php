<?php

/*
 * USAGE
 *  wp eval-file zorbix-framework/html_output_tests/helpers/map_from_params.php | pbcopy
 */

$atts = array(
		'columns'     => '',
		'port_height' => '',
		'images'      => '',
		'layout'      => '',
		'height'      => '',
		'width'       => '',
);

$textdomain = 'pixo';

generate_map_from_params($atts, $textdomain);
