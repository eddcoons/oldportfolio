<?php

add_shortcode( 'process', 'zorbix_process' );
function zorbix_process( $atts, $content = null ) {

	$default_atts = array(
		'num' => '1',
		'heading' => 'HEADING',
	);

	$atts = shortcode_atts( $default_atts, $atts );

	return sprintf(
		'<div class="process">
			<span class="num">%s</span>
			<h4 class="title">%s</h4>
			<p>%s</p>
		</div>',
		esc_html( $atts['num'] ),
		esc_html( $atts['heading'] ),
		esc_html( strip_tags( $content ) )
		);


}
