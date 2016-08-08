<?php

add_shortcode( 'spacer', 'zorbix_spacer' );
function zorbix_spacer( $atts, $content = null ) {


	return sprintf( '<div style="margin-bottom:%spx"></div>',
		esc_attr( zorbix_sc::remove_px( $content ) )
	);

}