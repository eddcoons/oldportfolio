<?php

// USAGE:
// Zorbix_Settings::$get['var name'];
// Zorbix_Settings::get_id();

class zorbix_img {

	private static $instance = null;
	static $get = null;

	public static $ids;

	static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new zorbix_img();
		}

	}

	public static function get( $setting ) {
		return self::$get[ $setting ];
	}

	# Return SRC FROM ID
	public static function get_src_from_id( $id, $size = 'full', $default = false ) {
		$img = wp_get_attachment_image_src( $id, $size );
		if ( 'placeholder' === $id || $default && empty( $img ) ) {
			return ZORBIX_NO_IMAGE;
		}

		return $img[0];
	}

	# Return SRC FROM ID
	public static function src_from_id( $id, $size = 'full', $default = false ) {
		echo esc_attr( self::get_src_from_id( $id, $size, $default) );
	}

	/**
	 * @param        $size
	 * @param string $class
	 *
	 * @return string
	 */
	static function get_thumb_src( $size, $class = '', $default = false ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
		$img = ( $default && $img[0] ) ?  $img[0] : ZORBIX_NO_IMAGE;
		return $img;
	}

	# Echo img tag from id
	static function tag_from_id( $id, $img_size = 'thumb', $default = false ) {
		$src = wp_get_attachment_image_src( $id, $img_size );
		$src = (  $default && empty( $src[0] ) ) ?  ZORBIX_NO_IMAGE : $src[0];
		printf( '<img src="%s" alt="image"/>', esc_url( $src ) );
	}

	# return img tag from id
	static function get_tag_from_id( $id, $img_size = 'thumb', $default = false, $class = '' ) {
		$src = wp_get_attachment_image_src( $id, $img_size );
		$src = (  $default && empty( $src[0] ) ) ?  ZORBIX_NO_IMAGE : $src[0];


		return sprintf( '<img src="%s" %s alt="image"/>',
				esc_url( $src ),
				zorbix_sc::escaped_class_attr( $class )
		);
	}

	static function get_thumb_tag( $size = 'thumb', $class = '' ) {
		$img   = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
		$class = ( $class ) ? 'class="' . esc_attr( $class ) . '"' : '';
		if ( $img[0] ) {
			$img = "<img $class src='" . esc_url( $img[0] ) . "' alt='image'/>";

			return $img;
		}
	}


	/**
	 * Output image tag without set sizes
	 *
	 * @param        $size
	 * @param string $class
	 */
	static function thumb_tag( $size = 'thumb', $class = '', $default = false ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );

		if ( $default ) {
			$img = zorbix::if_empty( $img[0], ZORBIX_NO_IMAGE );
		} else {
			$img = $img[0];
		}

		if ( $img ) {
			printf( '<img class="%s" src="%s" alt="image"/>',
				esc_attr( $class ),
				esc_url( $img )
			);
		}
	}

	# Get img tag from id or src
	static public function get_tag_from_id_or_src( $id_or_src, $img_size = 'thumb' ) {
		if ( is_numeric( $id_or_src ) ) {
			// Is id
			$img = wp_get_attachment_image( $id_or_src, $img_size );
		} else {
			// Is src
			$src = esc_url( $id_or_src );
			$img = "<img src='" . esc_url( $src ) . "' alt='image'/>";
		}

		return $img;
	}


}


add_action( 'wp_loaded', array( 'zorbix_img', 'get_instance' ) );