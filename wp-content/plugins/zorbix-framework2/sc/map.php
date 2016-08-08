<?php

add_shortcode( 'map', 'zorbix_map' );
function zorbix_map( $atts, $content = null ) {
	$output = '';

	$default_atts = array(
		'heading' => '',
		'zoom'    => '',
		'address' => 'Kensington Gardens Square, London, UK',
		'markers' => '',
		'wrapper' => 'false',
	);

	// Not loaded on every page because of speed impact of loading API
	wp_enqueue_script('google_map_api');
	wp_enqueue_script('gmap');

	$atts = shortcode_atts( $default_atts, $atts );

	// Wrapper if enabled
	$output .= ( 'true' === $atts['wrapper'] ) ? '<div class="map-holder"><div class="close-btn"><i class="fa fa-times-circle-o"></i></div>' : '';

	$output .= sprintf( '<div class="google-map" data-zoom="%s" data-address="%s" data-markers="%s"></div>',
		$atts['zoom'],
		$atts['address'],
		$atts['markers']
	);

	// End wrapper if enabled
	$output .= ( 'true' === $atts['wrapper'] ) ? '<a href="#" class="map-overlay"><i class="fa fa-plus-circle"></i></a></div>' : '';

	return $output

	?>

<?php }
