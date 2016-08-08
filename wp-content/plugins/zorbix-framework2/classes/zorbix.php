<?php


/**
 * Generic helper class to contain methods that don't belong
 * in another helper class. Preloaded. Needs to reside in both plugin and theme as very
 * heavily used in both.
 *
 * Only make changes to this version and copy to the theme after changes are made.
 *
 * @example Zorbix::ref('hello!);
 */
if ( ! class_exists( 'zorbix' ) ) {
	class zorbix {

		/**
		 * @var null
		 */
		static $get = null;
		/**
		 * @var null
		 */
		public static $vc_maps = null;
		/**
		 * @var null
		 */
		private static $instance = null;

		public static $debugging_output_strings = null;
		public static $debugging_output_arrays = null;

		private static $debugging = false;

		/**
		 *
		 */
		static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new zorbix();
			}
		}

		/**
		 * @param $setting
		 *
		 * @return mixed
		 */
		public static function get( $setting ) {
			return self::$get[ $setting ];
		}

		/**
		 * @param $value
		 * @param $format
		 *
		 * @return mixed|string
		 */
		public static function sprintf_if_exists( $format, $value ) {
			$result = '';
			if ( ! empty( $value ) ) {
				if ( is_array( $value ) ) {
					$value = implode( $value, ', ' );
				}
				$result = call_user_func( 'sprintf', $format, $value );
			}

			return $result;
		}

		public static function printf_if_exists( $format, $value ) {
			if ( ! empty( $value ) ) {
				if ( is_array( $value ) ) {
					$value = implode( $value, ', ' );
				}
				call_user_func( 'printf', $format, $value );
			}
		}

		public static function str_contains( $str, $contains ) {
			return ( strpos( $str, $contains ) !== false ) ? true : false;
		}


		/**
		 *
		 * Atts ability to pass atts to template as an array as WP function does not
		 *
		 * @param $file
		 * @param string $part2
		 * @param $atts
		 * @param bool|false $debug
		 */
		public static function load_template_part( $file, $part2 = '', $atts ) {

			$file = ( '' !== $part2 ) ? $file . '-' . $part2 : $file;

			$file = $file . '.php';

			if ( locate_template( $file ) ) {
				include locate_template( $file );
			} else {
				zorbix::debug( 'Could not find template', $file );
			}


		}




		public static function get_anchor_esc( $url, $link_text ) {
			if ( $url ) {
				return '<a href="' . esc_url( $url ) . '">' . esc_html( $link_text ) . '</a>';
			} else {
				return esc_html( $link_text );
			}
		}

		public static function startsWith( $haystack, $needle ) {
			// search backwards starting from haystack length characters from the end
			return $needle === "" || strrpos( $haystack, $needle, - strlen( $haystack ) ) !== false;
		}

		public static function if_true( $bool, $set_to_value, $else = '' ) {
			return ( $bool ) ? $set_to_value : $else;
		}

		public static function if_str_true( $bool, $set_to_value, $else = '' ) {
			return ( filter_var($bool, FILTER_VALIDATE_BOOLEAN) ) ? $set_to_value : $else;
		}

		public static function if_true_strict( $start_value, $set_to_value, $else = '' ) {
			return ( true === $start_value ) ? $set_to_value : $else;
		}

		public static function if_not_empty( $value, $do, $else = '' ) {
			return ( ! empty( $value ) ) ? $do : $else;
		}

		public static function if_empty( $value, $else ) {
			return ( empty( $value ) ) ? $else : $value;
		}

		public static function if_isset( $array, $key, $else = '' ) {
			return ( isset( $array[ $key ] ) ) ? $array[ $key ] : $else;
		}

		public static function if_not_isset( $array, $key, $else = '' ) {
			return ( ! isset( $array[ $key ] ) ) ? $array[ $key ] : $else;
		}

		public static function if_false( $start_value, $set_to_value, $default = '' ) {
			return ( $start_value ) ? $default : $set_to_value;
		}


		/**
		 * @param $log
		 */
		public static function log( $log, $ref = null ) {
			if ( true === WP_DEBUG ) {
				if ( is_array( $log ) || is_object( $log ) ) {
					error_log( print_r( $log, true ) );
				} else {
					if ( null !== $ref ) {
						$log = $ref . ': ' . $log;
					}
					error_log( $log );
				}
			}
		}

		/**
		 * @todo move to seperate class, add line numbers
		 *
		 * Outputs to the browser console
		 *
		 * @param        $to_output
		 * @param string $reference
		 */
		public static function debug( $to_output, $reference = null ) {

			if ( self::$debugging ) {
				if ( is_array( $to_output ) || is_object( $to_output ) ) {

					$reference = ( null === $reference ) ? 'Debug' : $reference;

					self::$debugging_output_arrays[ $reference ] = $to_output;

				} else {
					$to_output = ( $reference ) ? $to_output . ',' . $reference : $to_output;
					$to_output = esc_html( $to_output );

					self::$debugging_output_strings[] = $to_output;
				}
			}
		}


		/**
		 * Include a directory of php files
		 *
		 * @param $full_directory
		 */
		public static function autoload_directory( $full_directory, $debug = false ) {

			if ( true === $debug ) {
				zorbix::log( 'Loading Directory', $full_directory );
			}
			foreach ( glob( $full_directory . '*.php' ) as $filename ) {

				if ( true === $debug ) {
					zorbix::log( 'Loading File', $filename );
				}
				include_once $filename;
			}
		}


		/**
		 * @param $name
		 *
		 * @return string
		 */
		public static function name_to_id( $name ) {
			return strtolower( str_replace( ' ', '_', $name ) );
		}

		/**
		 *
		 * Formats a lower case id to an title with spaces
		 *
		 * @param $id
		 *
		 * @return string
		 */
		public static function id_to_name( $id ) {
			$id = ucwords( str_replace( '_', ' ', $id ) );
			return ucwords( str_replace( '-', ' ', $id ) );
		}


		public static function in_array_r( $needle, $haystack, $strict = false ) {
			foreach ( $haystack as $item ) {
				if ( ( $strict ? $item === $needle : $item === $needle )
				     || ( is_array( $item )
				          && self::in_array_r( $needle,
							$item,
							$strict ) )
				) {
					return true;
				}
			}

			return false;
		}


		/**
		 *
		 * Prints a nicer array
		 *
		 * @param $array
		 */
		public static function pretty_dump( $array ) {
			echo "<pre style='background: white;'>";
			print_r( $array );
			echo '</pre>';
		}

		/**
		 *
		 * If Even: Returns true if even
		 *
		 * @param $i
		 *
		 * @return bool
		 */

		public static function is_even( $i ) {
			return ( $i % 2 ) === 0;
		}


		/**
		 * Joins items with a space between.
		 * Seperate args with a comma
		 * @return string
		 */
		public static function join() {
			$args = func_get_args();

			return implode(  array_filter($args), ' ' );
		}

		public static function strip_to_numeric( $string ) {
			return preg_replace( '/[^0-9,.]/', '', $string );
		}

		static function fraction_to_words( $fraction ) {
			switch ( $fraction ) {
				case '1':
					return 'full';
					break;
				case '1/2':
					return 'one-half';
					break;
				case '1/3':
					return 'one-third';
					break;
				case '1/4':
					return 'one-fourth';
					break;
				default:
					return '';
					break;
			}
		}

	}
}


add_action( 'wp_loaded', array( 'zorbix', 'get_instance' ) );
