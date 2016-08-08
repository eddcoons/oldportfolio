<?php

class zorbix_maps
{

	private static $instance = null;
	static $get = null;

	static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new zorbix_maps();
		}
	}

	public static function get($setting)
	{
		return self::$get[$setting];
	}

	/**
	 * * @usage zorbix_builder::add_to_map($zorbix_map_name, zorbix_maps::margin() );
	 * @return array
	 */
	public static function margin()
	{

		return array(
			// Padding

			array(
				'type'       => 'info',
				'heading'    => esc_html__('Info', 'pixo'),
				'param_name' => 'info',
				'image'      => ZORBIX_IMG . 'padding-margin.svg',
				'group'      => esc_html__('margin', 'pixo'),
			),

			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Margin', 'pixo'),
				'param_name'  => 'margin',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('margin', 'zorbix'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__(' Top', 'pixo'),
				'param_name'  => 'margin_top',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('margin', 'zorbix'),
			),

			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__(' Right', 'pixo'),
				'param_name'  => 'margin_right',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('margin', 'zorbix'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__(' Bottom', 'pixo'),
				'param_name'  => 'margin_bottom',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('margin', 'zorbix'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__(' Left', 'pixo'),
				'param_name'  => 'margin_left',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('margin', 'zorbix'),
			)
		);
	}


	/**
	 * @usage zorbix_builder::add_to_map($zorbix_map_name, zorbix_maps::padding() );
	 * @return array
	 */
	public static function padding()
	{

		return array(
			array(
				'type'       => 'info',
				'heading'    => esc_html__('Info', 'pixo'),
				'param_name' => 'info',
				'image'      => ZORBIX_IMG . 'padding-margin.svg',
				'group'      => esc_html__('padding', 'pixo'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Padding', 'pixo'),
				'param_name'  => 'padding',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('padding', 'zorbix'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Padding Top', 'pixo'),
				'param_name'  => 'padding_top',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('padding', 'zorbix'),
			),

			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Padding Right', 'pixo'),
				'param_name'  => 'padding_right',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('padding', 'zorbix'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Padding Bottom', 'pixo'),
				'param_name'  => 'padding_bottom',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('padding', 'zorbix'),
			),
			array(
				'type'        => 'textfield',
				'holder'      => 'div',
				'heading'     => esc_html__('Padding Left', 'pixo'),
				'param_name'  => 'padding_left',
				'description' => esc_html__('Via inline style', 'pixo'),
				'group'       => esc_html__('padding', 'zorbix'),
			)
		);
	}

	public static function add_icon_map($options = array())
	{

		$default = array(
			'group'    => 'Icon',
			'postfix'  => '',
			'optional' => false,
			'icon-bg'  => false,
			'icon-border'  => false,
		);

		if (is_array($options)) {
			$options = array_merge(
				$default,
				$options
			);
		}

		return self::set_icon_fields($options);
	}

	public static function add_social_map($sc)
	{

		$params = array(
			array(
				'type'        => 'dropdown',
				'holder'      => 'div',
				'heading'     => esc_html__('Social', 'pixo'),
				'param_name'  => 'social',
				'description' => esc_html__('Choose social fields', 'pixo'),
				'value'       => '', // Default
			),
		);

		vc_add_params($sc, $params);
	}

	public static function  set_icon_fields($options = array())
	{

		$default = array(
			'group'    => 'Icon',
			'postfix'  => '',
			'optional' => false,
			'icon-bg'  => false,
			'icon-border'  => false,
		);

		if (!is_array($options)) {
			$options = array();
		}

		$options = array_merge(
			$default,
			$options
		);

		//$optional = false, $postfix = '', $group = 'Icon'l
		//
		$postfix = (!empty($options['postfix'])) ? '_' . $options['postfix'] : '';

		$dropdown = array(
			'type'       => 'colorpicker',
			'group'      => 'icon',
			'heading'    => esc_html__('Icon Color', 'pixo'),
			'param_name' => 'icon_color' . $postfix,
			'group'      => $options['group'],
		);

		$params[] = $dropdown;

//		$params[] = $dropdown;

		if (true === $options['icon-border']) {

			$params[] = array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__('Border Color', 'zorbix'),
					'param_name' => 'icon_border' . $postfix,
					'group'      => $options['group'],
					'std'        => '#009EC6'
			);

		}
		if (true === $options['icon-bg']) {

			$params[] = array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__('Background Color', 'zorbix'),
				'param_name' => 'icon_bg' . $postfix,
				'group'      => $options['group'],
				'std'        => '#009EC6'
			);

		}

		if (true === $options['optional']) {

			$params[] = array(
				'type'       => 'checkbox',
				'heading'    => esc_html__('Add Icon?', 'zorbix'),
				'param_name' => 'icon_enable' . $postfix,
				'value'      => array('Yes' => 'true'),
				'group'      => $options['group'],
			);

			$params[] = $dropdown;

		}

		$params[] = array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__('Icon', 'zorbix'),
			'param_name'  => 'icon_fontawesome' . $postfix,
			'value'       => self::get_fontawesome_icons(),
			'group'       => $options['group'],
			'holder'      => 'i',
			'description' => esc_html__('Select icon from library.', 'zorbix'),
		);

		return $params;
	}

	public static function get_fontawesome_icons()
	{

		// scrape list of icons from fontawesome css
		$transient = 'vp_fontawesome_icons_4.0.1';
		if (false === ($icons = get_transient($transient)) || true === ZORBIX_DEBUG) {
			$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
			$subject = wp_remote_retrieve_body(wp_remote_get(ZORBIX_CSS . 'font-awesome.min.css'));

			preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

			$icons['none'] = '';
			foreach ($matches as $match) {
				$icons['fa ' . $match[1]] = $match[1];
			}

			set_transient($transient, $icons, 60 * 60 * 24);
		}

		return $icons;
	}

	public static function get_tax_params($tax)
	{
		return array(
			array(
				'group'       => esc_html__('Sets', 'zorbix'),
				'type'        => 'textfield',
				'heading'     => esc_html__('Limit Number', 'zorbix'),
				'param_name'  => 'num',
				'description' => esc_html__('Leave blank for all', 'zorbix'),
			),

			array(
				'group'      => esc_html__('Sets', 'zorbix'),
				'type'       => 'taxonomy',
				'heading'    => esc_html__('Categories', 'zorbix'),
				'taxonomy'   => $tax,
				'param_name' => 'terms',
			),

			array(
				'group'       => esc_html__('Sets', 'zorbix'),
				'type'        => 'checkbox',
				'heading'     => esc_html__('Tick to reverse order', 'zorbix'),
				'param_name'  => 'order',
				'description' => 'IMPORTANT: Not compatible with ordering plugins like `order anything`',
				'value'       => array('' => 'asc'),
			)
		);

	}

	public static function get_column_params()
	{
		return array(
			array(
				'group'       => esc_html__('Columns', 'zorbix'),
				'type'        => 'checkbox',
				'heading'     => esc_html__('Center Columns', 'zorbix'),
				'param_name'  => 'center_columns',
				'description' => 'Forces to one column',
				'value'       => array('' => 'cols-centered'),
			),
			array(
				'group'      => esc_html__('Columns', 'zorbix'),
				'type'       => 'checkbox',
				'heading'    => esc_html__('Override Column Settings?', 'zorbix'),
				'param_name' => 'columns_check',
				'value'      => array('' => 'true'),
			),
			array(
				'group'      => esc_html__('Columns', 'zorbix'),
				'type'       => 'dropdown',
				'heading'    => esc_html__('Column Width', 'zorbix'),
				'param_name' => 'col_width',
				'value'      => array(
					'default'    => '',
					'one-half'   => 'col-md-6',
					'one-third'  => 'col-md-4',
					'one-fourth' => 'col-md-3',
					'one-sixth'  => 'col-md-2',
				),
				'dependency' => array('element' => 'columns_check', 'value' => array('true')),
			),
			array(
				'group'       => esc_html__('Columns', 'zorbix'),
				'type'        => 'columns_range',
				'heading'     => esc_html__('Number of Columns', 'zorbix'),
				'param_name'  => 'num_columns',
				'description' => esc_html__('Number of columns per row', 'zorbix'),
				'dependency'  => array('element' => 'columns_check', 'value' => array('true')),
				'value'       => '0',
				'min'         => '0',
				'max'         => '12',
			)
		);

	}


	/**
	 * @return array
	 */
	public static function zorbix_image_sizes()
	{
		$zorbix_image_sizes = get_intermediate_image_sizes();
		$zorbix_image_sizes[] = 'full';
		$zorbix_image_sizes = array_combine($zorbix_image_sizes, $zorbix_image_sizes);
		$zorbix_image_sizes = array_map(function ($key) {
			return zorbix::id_to_name($key);
		}, $zorbix_image_sizes);
		return array_flip($zorbix_image_sizes);
	}


	public static function get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
				$key = $_size . ' - ' . get_option("{$_size}_size_w") . ', ' . get_option("{$_size}_size_h");
				$sizes[$key] = $_size;
			} elseif (isset($_wp_additional_image_sizes[$_size])) {
				$key = $_size . ' - ' . $_wp_additional_image_sizes[$_size]['width'] . ', ' . $_wp_additional_image_sizes[$_size]['height'];
				$sizes[$key] = $_size;
			}
		}
		return $sizes;
	}

}


add_action('wp_loaded', array('zorbix_maps', 'get_instance'));
