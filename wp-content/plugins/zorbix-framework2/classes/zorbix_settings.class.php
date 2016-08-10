<?php

include ZORBIX_PLUGIN_DIR . 'customizer_controls/radio-image.php';
// USAGE:
// Zorbix_Settings::$get['var name'];
// Zorbix_Settings::get_id();

/**
 * Class Zorbix_Settings
 */
class zorbix_settings
{

	/**
	 * @var null
	 */
	static $get = null;
	/**
	 * @var
	 */
	static $post_ID;
	public static $solid_header;
	private static $dev = false;
	/**
	 * @var
	 */
	private static $fields;
	/**
	 * @var array
	 */
	private static $settings = array();
	/**
	 * @var array
	 */
	private static $panels = array();
	/**
	 * @var
	 */
	private static $section;
	/**
	 * @var
	 */
	private static $sections;
	/**
	 * @var
	 */
	private static $prefix;
	/**
	 * @var null
	 */
	private static $instance = null;

	private static $defaults;

	/**
	 *
	 */
	static function get_instance()
	{

		if (!self::$instance) {
			self::$instance = new zorbix_settings();
			add_action('customize_register', array(self::$instance, 'build'), 15);
			add_action('wp_head', array(self::$instance, 'customize_css'));

			if (self::$dev && class_exists( 'zorbix' )) {
				zorbix::debug(self::$get, 'GET');
			}

		}
	}

	function customize_css()
	{ ?>
		<style type="text/css" id="pixo-generated-options">

			<?php
			foreach( zorbix_settings::$fields as $field ) {

			if( isset($field['output'])) {
			$value = get_theme_mod( $field['setting']);
				if( !empty($value) ) {
				foreach( $field['output'] as $item ) {
				echo esc_html($item['element']) . '{';
				if( 'background-image' === $item['property'] ) {
					echo esc_html($item['property']) . ': ' . 'url("' . esc_url($value) . '")';
				} else {
					echo esc_html($item['property']) . ': ' . esc_html($value);
					echo esc_html(isset($item['units']) ? $item['units'] : '');
				}
										echo '}';

				}
				}
			}

			} ?>

		</style>
		<?php
	}

	public static function set_defaults($defaults)
	{
		self::$defaults = $defaults;
	}


	public static function get_default($default, $debug = false)
	{
		if (isset(self::$defaults[$default])) {
			return self::$defaults[$default];
		} else {
			return '';
		}
	}

	public function add_setting($type, $name, $title, $section, $default = '', $priority = '', $options = array())
	{
		$this->settings[] = array(
			'type'     => $type,
			'name'     => $name,
			'title'    => $title,
			'section'  => $section,
			'default'  => $default,
			'priority' => $priority,
			'options'  => $options
		);
	}

	public static function build($wp_customize)
	{

		if (is_array(self::$panels)) {
			foreach (self::$panels as $panel) {

				$default = array(
					'setting'     => 'test',
					'default'     => '',
					'priority'    => '',
					'title'       => '',
					'description' => '',
				);

				$panel = array_merge($default, $panel);

				$wp_customize->add_panel(
					$panel['name'], array(
						'title'       => $panel['title'],
						'description' => $panel['description'],
					)
				);

			}
		}

		if (is_array(self::$sections)) {
			foreach (self::$sections as $section) {

				$default_section = array(
						'title'       => '',
						'panel' => '',
						'description' => ''
				);

				$section = array_merge($default_section, $section);

				$wp_customize->add_section(
					$section['name'], array(
						'title' => $section['title'],
								'description'    => $section['description'],
//								'priority'       => $priority,
						'panel' => $section['panel']
					)
				);

			}
		}

		if (is_array(self::$fields)) {
			foreach (self::$fields as $field) {

				$default = array(
					'setting'  => 'test',
					'default'  => '',
					'priority' => '',
					'label'    => '',
					'section'  => '',
						'choices' => '',
						'transport' => '',
						'description' => ''
				);

				$field = array_merge($default, $field);
				$field['type'] = 'toggle' === $field['type'] ? 'checkbox' : $field['type'];

				$wp_customize->add_setting(
					$field['setting'], array(
						'default' => $field['default'],
						'transport' => $field['transport']
					)
				);
				$setting = array(
					'label'    => $field['label'],
					'section'  => $field['section'],
					'priority' => $field['priority'],
					'settings' => $field['setting'],
					'choices'  => $field['choices'],
					'description'  => $field['description'],
				);

				switch ($field['type']) {
					case 'select':
						$setting['choices'] = $field['choices'];
						break;
				}


				switch ($field['type']) {
					case 'color':
						$wp_customize->add_control(
							new WP_Customize_Color_Control(
								$wp_customize, $field['setting'], $setting
							)
						);
						break;
					case 'radio-image':
						$setting['choices'] = $field['choices'];
						$wp_customize->add_control(
							new zorbix_Custom_Radio_Image_Control($wp_customize, $field['setting'], $setting
							)
						);
						break;

					case 'image':
						$wp_customize->add_control(
							new WP_Customize_Image_Control(
								$wp_customize, $field['setting'], $setting
							)
						);
						break;

					default:

						$setting['type'] = $field['type'];
						$wp_customize->add_control(
							$field['setting'], $setting
						);

						break;
				}


			}

		}

	}

	/**
	 *
	 * If the parameter is true set to ...
	 *
	 * @param $name
	 * @param $set
	 */
	public static function get_option_if_true($name, $set)
	{
		$option_result = self::get_option($name);

		return ($option_result) ? $set : '';
	}

	/**
	 *
	 */
	public static function zorbix_set_id_back()
	{
		global $post;
		if ($post) {
			$post->ID = (self::$get['post_id']) ? self::$get['post_id'] : '';
		}
	}


	/**
	 * @param        $section
	 * @param string $prefix
	 */
	public static function set_section($section, $prefix = '')
	{
		self::$section = $section;
		self::$prefix = $prefix;
	}

	/**
	 * Will be set to default setting if user has not set. If no default text provided this will be the label text.
	 *
	 * @param $settings_array
	 */
	public static function add_translate_field($settings_array)
	{

		if (!is_array($settings_array)) {
			$new_settings_array['default'] = $settings_array;
			$new_settings_array['label'] = $settings_array;
			$settings_array = $new_settings_array;

		} else {
			if (!isset($settings_array['default'])) {
				$settings_array['default'] = $settings_array['label'];
			}
		}

		if (!isset($settings_array['setting'])) {
			$settings_array['setting'] = zorbix::name_to_id($settings_array['label']);
		}
		if (self::$prefix) {
			$settings_array['setting'] = self::$prefix . $settings_array['setting'];
		}

//		self::$settings[] = $settings_array['settings'];

		self::add_field(
			array(
				'type'        => 'textbox',
				'setting'     => $settings_array['setting'],
				'label'       => $settings_array['label'],
				'section'     => self::$section,
				'default'     => $settings_array['default'],
				'description' => zorbix::if_isset($settings_array, 'description'),
			));
	}

	/**
	 * footer_social
	 * header_social
	 * social_vimeo
	 */
	public static function generate_social_fields()
	{

		$choices = array(
			'facebook'    => esc_html__('Facebook', 'zorbix'),
			'twitter'     => esc_html__('Twitter', 'zorbix'),
			'behance'     => esc_html__('Behance', 'zorbix'),
			'delicious'   => esc_html__('Delicious', 'zorbix'),
			'deviantart'  => esc_html__('DeviantArt', 'zorbix'),
			'digg'        => esc_html__('Digg', 'zorbix'),
			'dribbble'    => esc_html__('Dribbble', 'zorbix'),
			'dropbox'     => esc_html__('Dropbox', 'zorbix'),
			'envelope'    => esc_html__('Email', 'zorbix'),
			'flickr'      => esc_html__('Flickr', 'zorbix'),
			'foursquare'  => esc_html__('Foursquare', 'zorbix'),
			'github'      => esc_html__('Github', 'zorbix'),
			'google'      => esc_html__('Google+', 'zorbix'),
			'instagram'   => esc_html__('Instagram', 'zorbix'),
			'linkedin'    => esc_html__('LinkedIn', 'zorbix'),
			'pinterest'   => esc_html__('Pinterest', 'zorbix'),
			'reddit'      => esc_html__('Reddit', 'zorbix'),
			'rss'         => esc_html__('RSS', 'zorbix'),
			'skype'       => esc_html__('Skype', 'zorbix'),
			'soundcloud'  => esc_html__('SoundCloud', 'zorbix'),
			'stumbleupon' => esc_html__('StumbleUpon', 'zorbix'),
			'tumblr'      => esc_html__('Tumblr', 'zorbix'),
			'vimeo'       => esc_html__('Vimeo', 'zorbix'),
			'wordpress'   => esc_html__('WordPress', 'zorbix'),
			'xing'        => esc_html__('Xing', 'zorbix'),
			'yahoo'       => esc_html__('Yahoo', 'zorbix'),
			'youtube'     => esc_html__('Youtube', 'zorbix')
		);

		self::$fields[] = array(
			'type'        => 'sortable',
			'setting'     => 'footer_social',
			'label'       => esc_html__('Social icons', 'zorbix'),
			'description' => esc_html__('Choose and sort your social icons', 'zorbix'),
			'help'        =>
				__('Select none to disable, set your social links under the social section',
					'zorbix'),
			'section'     => 'footer_social',
			'default'     => array(
				'facebook',
				'twitter',
				'behance',
			),
			'choices'     => $choices,
			'priority'    => 10,
		);

		self::$fields[] = array(
			'type'        => 'sortable',
			'setting'     => 'header_social',
			'label'       => esc_html__('Social icons', 'zorbix'),
			'description' => esc_html__('Choose and sort your social icons', 'zorbix'),
			'help'        =>
				__('Select none to disable, set your social links under the social section',
					'zorbix'),
			'section'     => 'header_social',
			'default'     => array(
				'facebook',
				'twitter',
				'behance',
			),
			'choices'     => $choices,
			'priority'    => 10,
		);

		foreach ($choices as $setting => $label) {

			self::$fields[] = array(
				'type'    => 'textbox',
				'section' => 'social',
				'default' => '',
				'setting' => 'social_' . $setting,
				'label'   => $label,
			);

		}
	}


	public static function add_icon_field($setting)
	{
		$items = self::get_fontawesome_icons();
		$choices = array();
		// BUILD SELECT FIELD
		foreach ($items as $item) {
			$choices[$item['label']] = $item['label'];
		}

		$setting['type'] = 'selecticon';
		$setting['choices'] = $choices;
		$setting['default'] = 'test';

		self::add_field($setting);

	}

	public static function get_fontawesome_icons()
	{
		// scrape list of icons from fontawesome css
		if (false === ($icons = get_transient('vp_fontawesome_icons_4.2.0'))) {
			$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
			$subject = wp_remote_retrieve_body(wp_remote_get(ZORBIX_CSS . 'font-awesome.min.css'));

			preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

			$icons = array();

			foreach ($matches as $match) {
				$icons[] = array('value' => $match[1], 'label' => $match[1]);
			}
			set_transient('vp_fontawesome_icons', $icons, 60 * 60 * 24);
		}

		return $icons;
	}

	private static function background_fields($settings_array)
	{

		self::add_field(
			array(
				'type'     => 'color',
				'setting'  => $settings_array['setting'] . '_bg_color',
				'label'    => esc_html__('background color', 'pixo'),
				'section'  => $settings_array['section'],
				'default'  => $settings_array['default']['color'],
				'priority' => 10,
				'output'   => array(
					array(
						'element'  => $settings_array['output'],
						'property' => 'background-color',
					)
				),
			));

		self::add_field(
			array(
				'type'     => 'image',
				'setting'  => $settings_array['setting'] . '_image',
				'label'    => esc_html__('Background Image', 'pixo'),
				'section'  => $settings_array['section'],
				'priority' => 10,
				'output'   => array(
					array(
						'element'  => $settings_array['output'],
						'property' => 'background-image',
					)
				),
			));


	}

	/**
	 * Types: checkbox, color-alpha, color, custom, dropdown-pages, editor, image, multicheck, number, palette, radio-buttonset, radio-image, radio, select, slider, sortable, switch, text, textarea, toggle, upload
	 *
	 * @param $settings_array
	 */
	public static function add_field($settings_array)
	{

		if ('background' === $settings_array['type']) {
			$settings_array = self::background_fields($settings_array);
		} else {

			if (is_array($settings_array)) {

//		 = self::$section;
				if (!isset($settings_array['section'])) {
					$settings_array['section'] = self::$section;
					if (self::$prefix) {
						$settings_array['setting'] = self::$prefix . $settings_array['setting'];
					}
				}

//			if (!isset($settings_array['help'])) {
//				$settings_array['help'] = 'test';
//			}

				// Make sure there is always a default setting
//			if (!isset($settings_array['default'])) {
//				$settings_array['default'] = '';
//			}

				if (isset($settings_array['settings'])) {
					self::$settings[] = $settings_array['settings'];
				} else {
					self::$settings[] = $settings_array['setting'];
				}

				self::$fields[] = $settings_array;


//			Kirki::add_field('', $settings_array);
			} else {
				trigger_error('add_field only wants an array');
			}
		}
	}

	public static function add_section($settings)
	{
		self::$sections[] = $settings;
	}

	public static function add_panel($settings)
	{
		self::$panels[] = $settings;
	}

	public static function get_settings()
	{
		return self::$settings;
	}


	/**
	 * @return mixed
	 */
	public static function get_fields()
	{
		if (self::$dev && class_exists( 'zorbix' )) {
			zorbix::debug(self::$settings, 'SETTINGS');
		}

		return self::$fields;
	}


	/**
	 * So can get a theme default for a page type
	 */
	public static function set_solid_header()
	{
		zorbix_settings::$solid_header = true;
	}

	/**
	 *
	 * Formats a lower case id to an title with spaces
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function id_to_name($id)
	{
		return ucwords(str_replace('_', ' ', $id));
	}


	/**
	 * @param $option_id
	 *
	 * @return mixed|string
	 */
	public static function get_option($option_id, $debug = false)
	{

		// Debug helper
		if ($debug == true) {
			if (class_exists( 'zorbix' )) {
				$result = Kirki::get_option($option_id);
				$result = ($result) ? $result : 'NOTHING';
				zorbix::log( 'Looing for ' . $option_id . ' Got ' . $result);
				if ('NOTHING' === $result) {

					$all = get_theme_mods();

					if (array_key_exists($option_id, $all)) {
						$debug_info['DEBUG METABOX']['Option ID'] = $option_id;
						$debug_info['DEBUG METABOX']['Exists?'] = 'Yes!';
					} else {
						$debug_info['DEBUG METABOX']['Option ID'] = $option_id;
						$debug_info['DEBUG METABOX']['Exists?'] = 'NO!!!';
						$debug_info['DEBUG METABOX']['All'] = $all;
					}
					$debug_info['DEBUG METABOX']['get_theme_mod'] = get_theme_mod($option_id);
					if (class_exists( 'zorbix_helper' )) {
						$debug_info['DEBUG METABOX']['Options'] = ( false === zorbix_helper::$options_loaded) ? 'Options not yet loaded' : 'Options have been loaded';
					} else {
						$debug_info['DEBUG METABOX']['Zorbix heloer'] = 'Does not exist';
					}
					$debug_info['DEBUG METABOX']['Zorbix heloer'] = class_exists('Kirki') ? 'Kirki class exists' : 'kirki class does not exist';
					zorbix::log($debug_info);
				}
			} else {
				error_log('debugging class zbx does not exist');
			}
		}

		return get_theme_mod($option_id);

	}

	public static function get_option_or_default($option_id, $debug = false)
	{
		$value = get_theme_mod($option_id);
		$default = self::get_default($option_id, $debug);
		return (!empty($value)) ? $value : $default;
	}

	public static function get_mb_or_option($option_id, $debug = false)
	{

		// Get meta option and return if a value is set
		$result = get_post_meta(get_the_ID(), $option_id, true);

		// If metabox is set to global get option value instead
		if ('global' === $result) {
			self::debug_option($option_id, $debug);
			$result = get_theme_mod($option_id);
		}

		if (true === $debug) {
			zorbix::debug(var_export($result, true), $option_id);
		}

		//$result = filter_var($result, FILTER_VALIDATE_BOOLEAN);

		return $result;

	}


	public static function join()
	{
		$args = func_get_args();

		return join($args, ' ');
	}


	/**
	 * Needed because the default parametor for get_theme_mod did not show default when empty
	 *
	 * @param $id
	 * @param $default
	 */
	public static function get_theme_mod_or_default($id, $default = '')
	{
		$value = get_theme_mod($id);

		return ($value) ? $value : $default;
	}

	public static function get_menu_type()
	{
		if (zorbix_mb::get('')) {
			;
		}
	}

	public static function debug_option($option_id, $debug)
	{
		if (true === $debug) {
			if (class_exists( 'zorbix' )) {
				$result = Kirki::get_option($option_id);
				$result = ($result) ? $result : 'NOTHING';
				zorbix::log( 'Looing for ' . $option_id . ' Got ' . $result);
				if ('NOTHING' === $result) {

					$all = get_theme_mods();

					if (array_key_exists($option_id, $all)) {
						$debug_info['DEBUG METABOX']['Option ID'] = $option_id;
						$debug_info['DEBUG METABOX']['Exists?'] = 'Yes!';
					} else {
						$debug_info['DEBUG METABOX']['Option ID'] = $option_id;
						$debug_info['DEBUG METABOX']['Exists?'] = 'NO!!!';
						$debug_info['DEBUG METABOX']['All'] = $all;
					}
					$debug_info['DEBUG METABOX']['get_theme_mod'] = get_theme_mod($option_id);
					if (class_exists( 'zorbix_helper' )) {
						$debug_info['DEBUG METABOX']['Options'] = ( false === zorbix_helper::$options_loaded) ? 'Options not yet loaded' : 'Options have been loaded';
					} else {
						$debug_info['DEBUG METABOX']['Zorbix heloer'] = 'Does not exist';
					}
					$debug_info['DEBUG METABOX']['Zorbix heloer'] = class_exists('Kirki') ? 'Kirki class exists' : 'kirki class does not exist';
					zorbix::log($debug_info);
				}
			} else {
				error_log('debugging class zbx does not exist');
			}
		}
	}


	static public function color($heading, $element, $default_color)
	{
		self::add_field(array(
			'type'     => 'color',
			'settings' => zorbix::name_to_id($heading),
			'label'    => $heading,
			'default'  => $default_color,
			'priority' => 10,
			'output'   => array(
				array(
					'element'  => $element,
					'property' => 'color'
				),
			),
		));
	}


	static public function typography($settings)
	{

		$default = array(
			'font-style'  => '',
//			'font-size'   => '14',
			'font-weight' => '100',
			'line-height' => '1.5',
		);

		$settings = array_merge($default, $settings);

		self::add_field(array(
			'type'     => 'typography',
			'settings' => zorbix::name_to_id($settings['heading']) . '_typography',
			'label'    => $settings['heading'],
			'priority' => 10,
			'default'  => '',
			'choices'  => array(
				'font-style'  => true,
				'font-size'   => true,
				'font-weight' => true,
				'line-height' => true,
//				'letter-spacing' => true,
				'units'       => array('px', 'rem', 'em'),
			),
			'output'   => array(
				array(
					'element' => $settings['element'],
				),
			),
		));

		self::add_field(array(
			'type'     => 'color',
			'settings' => zorbix::name_to_id($settings['heading']) . '_color',
			'label'    => $settings['heading'],
			'default'  => $settings['color'],
			'priority' => 10,
			'output'   => array(
				array(
					'element'  => $settings['element'],
					'property' => 'color'
				),
			),
		));
	}
}

add_action('setup_theme', array('zorbix_settings', 'get_instance'));

