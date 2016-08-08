<?php

/**
 *
 * Part of the zorbix framework. Provides needed theme functions for when the framework is turned off.
 *
 **/
class zorbix_helper
{

	private static $instance = null;
	public static $options_loaded = 'false';
	public static $classes = array();
	public static $theme_color = '#009EC6';
	static $get = null;

	public static $plugins;

	private static $defaults;

	static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new zorbix_helper();
		}
	}

	/**
	 *
	 * Use this to set defaults for items that need to be assesible even when framework isn't loaded.
	 * Overwise use kirki defaults.
	 *
	 * @param $defaults
	 */
	public static function set_defaults($defaults)
	{
		self::$defaults = $defaults;
	}


	public static function get_default($default)
	{
		if (isset(self::$defaults[$default])) {
			return self::$defaults[$default];
		} else {
			return '';
		}
	}


	public static function get_class_from_mb($meta_id, $class = null)
	{
		if (function_exists('zorbix_mb::get_class_from_mb')) {
			return zorbix_mb::get_class_from_mb($meta_id, $class);
		} else {
			return '';
		}
	}


	/*
	 * To keep template files clean.
	 * Not set in advance because metaboxes need the ID from the page loop
	 */

	private
	static function get_class_from_setting(
		$setting, $result
	)
	{
		$class_settings = array(
			'page_padding'  => 'page-padding',
			'solid_header'  => 'solid use-menu-fixer',
			'show_triangle' => 'show'
		);

		$returning = '';

		if (true === $result || 'on' === $result) {
			$returning = $class_settings[$setting];
		}

		return $returning;

	}

	public
	static function get_classes(
		$set, $class = ''
	)
	{

		switch ($set) {
			case 'body':
				$class = 'zorbix enable-transition';
				$class .= (function_exists('zorbix_mb::get_class_from_mb')) ? zorbix_mb::get_class_from_mb('page_padding') : '';
				break;
			case 'wrapper':
				$class = self::get_option('menu_type', '', true);
		}

		return $class;

	}

	public
	static function classes(
		$set, $class = ''
	)
	{
		echo esc_attr(self::get_classes($set, $class));
	}

	public
	static function class_from_setting(
		$setting
	)
	{
		echo esc_attr(get_class_from_setting($setting));
	}


	public
	static function get_footer_settings()
	{

		// Footer settings
		$settings['footer_animate_data_bottom'] = '';
		$settings['footer_animate_data_top'] = '';
		$settings['footer_animate'] = '';

		if (function_exists('zorbix_settings::get_option_if_true')) {
			$settings['footer_animate'] = zorbix_settings::get_option_if_true('footer_animate', 'animated');
		}

//		$settings['blog_heading_white'] = self::get_option_if_true( 'blog_heading_white', 'white-text' );

		if ($settings['footer_animate']) {
			$settings['footer_animate_data_top'] = 'fadeInDown';
			$settings['footer_animate_data_bottom'] = 'fadeInUp';
		}

		return $settings;
	}


	public
	static function get_post_meta(
		$id, $default = ''
	)
	{
		$option = get_post_meta(get_the_ID(), $id, true);

		return empty($option) ? $default : $option;
	}

	public
	static function video(
		$metabox_id
	)
	{
		if (class_exists( 'zorbix_blog' )) {
			return zorbix_blog::video($metabox_id);
		}
	}

	/* end page navi */


	/**
	 * Note: You cannot prepare metaboxes like the options, you won't be able to get the id until the page is
	 * run unless you create a loop which I think is a little messy
	 *
	 * @return string
	 */
	public
	static function header_classes()
	{

		$class = '';

		$menu_pos = self::get_option('menu_position');

		$menu_type = self::get_option('menu_type', 'top', true);

		$solid = zorbix_mb::get_class_from_mb('solid_header', '', true);


		if ('top' === $menu_type) {
			switch ($menu_pos) {
				case 'center':
					$class = ' menu-center';
					break;
				case 'left':
					$class = ' menu-left';
					break;
				default:
					$class = ' menu-right';
			}
		}

		$class = "$class $solid $menu_type";


		echo esc_attr($class);

	}


	/**
	 * @param $option_id
	 *
	 * @return mixed|string
	 */
	public
	static function get_option($option_id, $debug = false)
	{
		self::debug_option($option_id, $debug);

		return get_theme_mod($option_id);
	}

	private
	static function debug_option(
		$option_id, $debug
	)
	{
		if (class_exists( 'zorbix_settings' )) {
			zorbix_settings::debug_option($option_id, $debug);
		}
	}

	public static function get_mb_or_option( $option_id ) {

		// Get meta option and return if a value is set
		if( is_home() ) {
			$post_id = get_option('page_for_posts');
		} else {
			$post_id = get_queried_object_id();
		}
		$result = get_post_meta($post_id, $option_id, true);

		$default = self::get_default($option_id);

		// If metabox is set to global get option value instead
		if ('global' === $result || '' === $result ) {
			$result = get_theme_mod($option_id, $default);
		}
		return $result;

	}

	public static function get_option_or_default($option_id)
	{
		$value = get_theme_mod($option_id);
		$default = zorbix_helper::get_default($option_id);

		return (!empty($value)) ? $value : $default;
	}


	public
	static function join()
	{
		$args = func_get_args();

		return join($args, ' ');
	}

	public
	static function limit_extract(
		$limit = '200'
	)
	{
		if (function_exists('zorbix_limit_excerpt')) {
			pixo_limit_excerpt($limit);
		} else {
			the_excerpt();
		}
	}

	public
	static function next_arrow()
	{
		return (is_rtl()) ? '<i class="fa fa-chevron-left"></i>' : '<i class="fa fa-chevron-right"></i>';
	}

	public
	static function prev_arrow()
	{
		return (is_rtl()) ? '<i class="fa fa-chevron-right"></i>' : '<i class="fa fa-chevron-left"></i>';
	}

	/**
	 * Echo logo
	 */
	public
	static function logo()
	{
		if (zorbix_helper::get_option('logo')) {

			printf('<a href="%s" class="logo">', esc_url(home_url('/')));
			self::printf_if_exists('<img src="%s" alt="logo"/>', esc_url(zorbix_helper::get_option('logo')));
			self::printf_if_exists('<img src="%s" class="logo-light" alt="logo"/>',
				esc_url(zorbix_helper::get_option('logo-light')));
			printf('</a>');

		} elseif ($title = get_bloginfo('name')) {
			printf('<a href="%s" class="logo text">%s</a>',
				esc_url(home_url('/')),
				esc_html($title)
			);
		}
	}

	public
	static function if_true(
		$start_value, $set_to_value, $else = ''
	)
	{
		return (!$start_value) ? $else : $set_to_value;
	}

	public
	static function printf_if_exists(
		$format, $value
	)
	{
		if (!empty($value)) {
			if (is_array($value)) {
				$value = implode($value, ', ');
			}
			call_user_func('printf', $format, $value);
		}
	}

	public
	static function favicons_fallback()
	{

		if (!function_exists('has_site_icon')) {

			if ( class_exists( 'zorbix' ) && class_exists( 'zorbix_settings' )) {

				// Standard
				zorbix::printf_if_exists('<link rel="icon" href="%s" type="image/png" sizes="16x16" />',
					esc_url(zorbix_settings::get_option('favicon'))
				);

				// Generic Retina
				zorbix::printf_if_exists('<link rel="icon" type="image/png" href="%s" sizes="32x32">',
					esc_url(zorbix_settings::get_option('retina_favicon'))
				);

				// Apple Touch Icons

				// Regular iPhone
				zorbix::printf_if_exists('<link href="%s" rel="apple-touch-icon" sizes="60x60" />',
					esc_url(zorbix_settings::get_option('regular_iphone_favicon'))
				);

				// iPad non retina
				zorbix::printf_if_exists('<link href="%s" rel="apple-touch-icon" sizes="76x76" />',
					esc_url(zorbix_settings::get_option('regular_ipad_favicon'))
				);

				// iPhone Retina
				zorbix::printf_if_exists('<link href="%s" rel="apple-touch-icon" sizes="120x120" />',
					esc_url(zorbix_settings::get_option('retina_iphone_favicon'))
				);

				// iPad retina
				zorbix::printf_if_exists('<link href="%s" rel="apple-touch-icon" sizes="152x152" />',
					esc_url(zorbix_settings::get_option('retina_ipad_favicon'))
				);
			}
		}
	}

	public
	static function get_contact_info()
	{
		if (self::get_option('footer_contact1')) {
			$array[self::get_option('footer_contact1')]
				= self::get_option('footer_contact_icon1');
		}
		if (self::get_option('footer_contact2')) {
			$array[self::get_option('footer_contact2')]
				= self::get_option('footer_contact_icon2');
		}
		if (self::get_option('footer_contact3')) {
			$array[self::get_option('footer_contact3')]
				= self::get_option('footer_contact_icon3');
		}
		if (self::get_option('footer_contact4')) {
			$array[self::get_option('footer_contact4')]
				= self::get_option('footer_contact_icon4');
		}
		if (isset($array)) {
			return $array;
		}

		return '';
	}

	# Echo img tag from id
	static function tag_from_id( $id, $img_size = 'thumb', $default = false ) {
		$src = wp_get_attachment_image_src( $id, $img_size );
		$src = (  $default && empty( $src[0] ) ) ?  ZORBIX_NO_IMAGE : $src[0];
		printf( '<img src="%s" alt="image"/>', esc_url( $src ) );
	}

	static function get_tag_from_id( $id, $img_size = 'thumb', $default = false, $class = '' ) {
		$src = wp_get_attachment_image_src( $id, $img_size );
		$src = (  $default && empty( $src[0] ) ) ?  ZORBIX_NO_IMAGE : $src[0];


		return sprintf( '<img src="%s" %s alt="image"/>',
				esc_url( $src ),
				zorbix_sc::escaped_class_attr( $class )
		);
	}

}


add_action('wp_loaded', array('zorbix_helper', 'get_instance'));
