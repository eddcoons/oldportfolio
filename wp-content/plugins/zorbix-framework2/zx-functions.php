<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || die;

if ( ! ( function_exists( 'zorbix_autoload_directories' ) ) ) {
	function zorbix_autoload_directories( $directory_array ) {
		foreach ( $directory_array as $directory ) {
			zorbix_autoload_directory( $directory );
		}
	}
}

if ( ! ( function_exists( 'zorbix_autoload_directory' ) ) ) {
	function zorbix_autoload_directory( $full_directory ) {
		if ( file_exists( $full_directory ) ) {
			foreach ( glob( $full_directory . '*.php' ) as $filename ) {
				include_once $filename;
			}
		} else {
			error_log( 'Could not find directory ' . $full_directory );
		}
	}
}

if ( ! ( function_exists( 'zorbix_esc_get_div_att' ) ) ) {
	function zorbix_esc_get_div_att( $div_att, $val ) {
		if ( ! empty( $val ) ) {
			return sprintf( '%s="%s"', esc_attr( $div_att ), esc_attr( $val ) );
		} else {
			return '';
		}
	}
}


# Return anchor html from $url and $link_text
if ( ! ( function_exists( 'zorbix_get_anchor_esc' ) ) ) {
	/**
	 * @param      $url
	 * @param      $link_text
	 * @param null $class
	 *
	 * @return string
	 */
	function zorbix_get_anchor_esc( $url, $link_text, $class = null ) {
		return zorbix::get_anchor_esc( $url, $link_text, $class );
	}
}

// ----------------------------------
// --  FEATURE IMAGE HELPERS  --
// ----------------------------------

# ECHO SRC FOR CURRENT POST FEATURED IMAGE
if ( ! ( function_exists( 'zorbix_get_thumb_src' ) ) ) {
	/**
	 * @param $size
	 */
	function zorbix_get_thumb_src( $size ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
		echo esc_url( $img[0] );
	}
}

# GET SRC FOR CURRENT POST FEATURED IMAGE
if ( ! ( function_exists( 'zorbix_the_thumb_src' ) ) ) {
	/**
	 * @param $size
	 *
	 * @return mixed
	 */
	function zorbix_the_thumb_src( $size ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );

		return $img[0];
	}
}


