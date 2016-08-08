<?php

// ----------------------------------
// --  Theme Support  --
// ----------------------------------

// var_dump( get_intermediate_image_sizes() );

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );

	/*
	 * Name, Width, Height, crop
	 * Crop - true - hard, false
	 */

	// Portfolio Images
	add_image_size( 'pixo_port_thumb    ', 700 ); // Full size screen
	add_image_size( 'pixo_port_thumb_square', 700, 700, true ); // Full size screen
	add_image_size( 'pixo_port_thumb_rectangle', 700, 500, true ); // Full size screen
	add_image_size( 'pixo_client_thumb', 300 ); // Full size screen

	// Blog Images
	add_image_size( 'pixo_blog_thumb', 1200 ); // Blog thumbnails

	// Hex Image
	add_image_size( 'pixo_200_square', 200, 200, true );
	add_image_size( 'pixo_300_square', 300, 300, true );
	add_image_size( 'pixo_400_square', 400, 400, true );

	// Theme Support
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
}

// maximum allowed width for any content in the theme
if ( ! isset( $content_width ) ) {
	$content_width = 900;
}