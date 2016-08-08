<?php
/**
 * Framework class for creating metaboxes
 */
class zorbix_mb {

	private static $instance = null;
	static $get = null;
	static $dev = true;
	static $metaboxes;

	static function get_instance() {

		if ( ! self::$instance ) {
			self::$instance = new zorbix_mb();
		}

		add_action( 'admin_init', array('zorbix_mb', 'register' ), 1 );

	}

	/**
	 * Piroity: 'high', 'core', 'default' or 'low'
	 * @param $tuff
	 */
	static public function create( $tuff ) {
		self::$metaboxes[$tuff['id']] = $tuff;
	}

	static public function add_to_metabox( $metabox, $fields ) {
		self::$metaboxes[$metabox]['fields'] = array_merge( self::$metaboxes[$metabox]['fields'], $fields );
	}

	static public function register() {

		if( !empty( zorbix_mb::$metaboxes ) ) {
			foreach( zorbix_mb::$metaboxes as $metabox ) {
				if ( ( function_exists( 'ot_register_meta_box' ) ) ) {
					ot_register_meta_box( $metabox );
				} else {
					zorbix::log('Option tree not loaded. Cannot create metaboxes');
				}
			}
		} else {
			trigger_error('No metaboxes to register');
		}
	}

	public static function get_fontawesome_icons() {
		// scrape list of icons from fontawesome css
		if ( false === ( $icons = get_transient( 'vp_fontawesome_icons_4.2.0' ) ) ) {
			$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
			$subject = wp_remote_retrieve_body( wp_remote_get( ZORBIX_PLUGIN_URI . 'css/font-awesome.min.css' ) );

			preg_match_all( $pattern, $subject, $matches, PREG_SET_ORDER );

			$icons = array();

			foreach ( $matches as $match ) {
				$icons[] = array( 'value' => $match[1], 'label' => $match[1] );
			}
			set_transient( 'vp_fontawesome_icons', $icons, 60 * 60 * 24 );
		}

		return $icons;
	}


	public static function get( $id, $default = '' ) {
		$option = get_post_meta( get_the_ID(), $id, true );

		return empty( $option ) ? $default : $option;
	}


	/**
	 * Sets the icon data from vc icon fields. $atts['icon'] will become available.
	 *
	 * <code>$atts = Zorbix_VC::icon($atts);</code>
	 *
	 * @param $atts
	 *
	 * @return array $atts
	 */
	public static function icon( $atts ) {
		if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
			vc_icon_element_fonts_enqueue( $atts['icon_type'] );
		}

		switch ( $atts['icon_type'] ) {
			case 'openiconic':
				$atts['icon'] = $atts['icon_openiconic'];
				break;
			case 'typicons':
				$atts['icon'] = $atts['icon_typicons'];
				break;
			case 'entypoicons':
				$atts['icon'] = $atts['icon_entypoicons'];
				break;
			case 'linecons':
				$atts['icon'] = $atts['icon_linecons'];
				break;
			case 'entypoicons':
				$atts['icon'] = $atts['icon_entypoicons'];
				break;
			case 'entypo':
				$atts['icon'] = $atts['icon_entypo'];
				break;
			default:
				$atts['icon'] = $atts['icon_fontawesome'];

				return $atts;

		}

		if ( empty( $atts['icon'] ) ) {
			$atts['icon'] = 'fa-info';
		}

		return $atts;
	}

	public static function get_class_from_mb( $setting, $class = null ) {
		$result = self::get( $setting );
		if( null === $class ) {
			$class = str_replace( '_', '-', $setting );
		}
		return ( 'on' === $result ) ? $class : '';
	}

	public static function debug_show_all_page_meta( $page_id ) {
		get_post_meta( $page_id );
	}
}

add_action( 'wp_loaded', array( 'zorbix_mb', 'get_instance' ) );
