<?php

add_shortcode( 'bgvideo', 'zorbix_bgvideo');
function zorbix_bgvideo($atts, $content = null ) {

	$default_atts = array(
		'mp4'    => '',
		'webm'   => '',
		'ogv'    => '',
		'poster' => '',
		'height' => '',
		'width'  => '',
	);

	$atts = zorbix_sc::shortcode_atts( $default_atts, $atts, 'zorbix_video' );

	$atts['poster'] = zorbix_img::get_src_from_id( $atts['poster'] );

	return zorbix_sc::get_video_background( 'upload', '', $content, '' );

	//[video mp4="source.mp4" ogv="source.ogv" mov="source.mov"]


}
