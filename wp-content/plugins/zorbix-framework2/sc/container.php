<?php

add_shortcode( 'container', 'zorbix_container');
function zorbix_container($atts, $content = null ) {

	return sprintf( '<div class="container">%s</div>', do_shortcode( $content ) );

}