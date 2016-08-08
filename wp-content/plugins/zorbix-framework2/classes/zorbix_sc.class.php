<?php

/**
 * Class zorbix_sc
 *
 * Helper functions for shortcodes
 */
class zorbix_sc
{

	private static $instance = null;
	static $get = null;
	public static $vc_maps = null;

	static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new zorbix_sc();
		}
	}

	public static function get($setting)
	{
		return self::$get[$setting];
	}

	// If VC isn't loaded we need this function
	//    function build_link( $value ) {
	//        return zorbix_parse_multi_attribute( $value, array( 'url' => '', 'title' => '', 'target' => '' ) );
	//    }

	public static function parse_multi_attribute($value, $default = array())
	{
		$result = $default;
		$params_pairs = explode('||', $value);
		if (1 < count($params_pairs)) {
			foreach ($params_pairs as $pair) {
				$param = preg_split('/\:/', $pair);
				if (!empty($param[0]) && isset($param[1])) {
					$result[$param[0]] = rawurldecode($param[1]);
				}
			}
		} else {
			$result['url'] = $value;
		}

		return $result;
	}

	public static function class_from_key($key, $array)
	{
		$class = str_replace('_', '-', $key);

		return ('true' === $array[$key]) ? $class : '';
	}

	// Format VC link as link atts
	public static function vc_link_atts($link)
	{
		return self::parse_multi_attribute($link, array('url' => '', 'title' => '', 'target' => ''));
	}

	public static function attr_link_format($link_att_string)
	{
		$params = explode('||', $link_att_string);

		/* @todo what if params don't exist? */
		/* @todo what if the button results are formatted differently? from wplink? */
		return array(
			'url'    => $params[0],
			'target' => (isset($params[1]) ? $params[1] : ''),
			'title'  => (isset($params[2]) ? $params[2] : ''),
		);
	}


	public static function get_print_icon($atts, $postfix = '', $class = '')
	{
		$atts = self::icon($atts, $postfix);
		if (empty($atts['icon']) || 'fa ' === $atts['icon']) {
			return;
		}

		$postfix = (!empty($postfix)) ? '_' . $postfix : $postfix;

		$icon_bg = isset($atts['icon_bg' . $postfix]) ? $atts['icon_bg' . $postfix] : '';
		$icon_border_color = isset($atts['icon_border' . $postfix]) ? $atts['icon_border' . $postfix] : '';

		return sprintf('<i class="zx-icon %s %s %s" %s></i>',
//        return sprintf('<span class="zx-icon"><i class="%s %s %s" %s></i></span>',
			esc_attr('icon' . $postfix),
			esc_attr($atts['icon' . $postfix]),
			esc_attr($class),
			zorbix_sc::get_format_style_esc_multi(
				zorbix_sc::get_style_atts('spacing', $atts),
				array(
					'color'            => $atts['icon_color' . $postfix],
					'border-color'     => $icon_border_color,
					'background-color' => $icon_bg,
				))
		) . "\n";
	}

	public static function print_icon($atts, $postfix = '')
	{
		echo self::get_print_icon($atts, $postfix);
	}

	/**
	 * example: zorbix_sc::get_opening_anchor($atts['link']);
	 * @param $link
	 * @param string $class
	 * @param string $style
	 * @return string
	 *
	 */
	public static function get_opening_anchor($link, $class = '', $style = '')
	{

		// Format if hasn't been
		if (!isset($link['url'])) {
			$link = self::attr_link_format($link);
		}
		if ($link['url']) {
			return sprintf('<a href="%s" target="%s" %s %s %s>',
				esc_attr(urldecode($link['url'])),
				esc_attr(zorbix::if_empty($link['target'], '_self')),
				zorbix_esc_get_div_att('title', esc_attr($link['title'])),
				zorbix_esc_get_div_att('class', esc_attr($class)),
				zorbix_esc_get_div_att('style', esc_attr($style))
			) . "\n";
		}
	}

	public static function print_opening_anchor($link, $class = '', $style = '')
	{
		echo self::get_opening_anchor($link, $class, $style);
	}

	public static function print_closing_anchor($link)
	{
		$link = self::attr_link_format($link);
		if (!empty($link['url'])) {
			echo '</a>';
		}
	}

	public static function get_closing_anchor($link)
	{
		$link = self::attr_link_format($link);
		if (!empty($link['url'])) {
			return '</a>';
		}
	}

	/**
	 * Usage: zorbix_sc::anchor_or_div( $atts['link'] )
	 *
	 * @param        $link
	 * @param string $class
	 */
	public static function anchor_or_div($link, $class = '')
	{
		$link = self::vc_link_atts($link);
		if ($link['url']) {
			printf('<a href="%s" %s %s %s>',
				esc_attr($link['url']),
				esc_attr(zorbix::if_empty($link['target'], '_self')), // XXS OK
				zorbix_esc_get_div_att('title', esc_attr($link['title'])),
				zorbix_esc_get_div_att('class', esc_attr($class))
			);
		} else {
			printf('<div %s>', zorbix_esc_get_div_att('class', esc_attr($class)));
		}

	}

	/**
	 * @param $link
	 */
	public static function anchor_or_div_close($link)
	{
		$link = self::vc_link_atts($link);
		if (!empty($link['url'])) {
			echo '</a>';
		} else {
			echo '</div>';
		}
	}

	/**
	 * @param $atts
	 *
	 * @return string
	 */
	public static function animation_class($atts)
	{
		$class = '';
		if ($atts['animate_check'] && $atts['effect']) {
			$class = 'animated';
		}

		return $class;
	}


	/**
	 * Formats animation data strings from $atts
	 * Use zorbix_anim_data_esc($atts, $cpt_posts);
	 *
	 * @param      $atts
	 * @param null $cpt_posts
	 *
	 * @return string
	 */
	public static function animation_data_esc($atts, $cpt_posts = null)
	{
		$data = '';
		if ($atts['animate_check']) {
			if ($atts['effect']) {
				$data .= ' data-animate="' . esc_attr($atts['effect']) . '"';

				if ($atts['start_delay'] || $atts['delay']) {

					// If dealing with CPT shortcode animation
					// or a single shortcode
					if ($atts['delay'] && $cpt_posts) {
						if (is_numeric($cpt_posts)) {
							$count = $cpt_posts;
						} else {
							$count = $cpt_posts->current_post;

						}
						$count += 1;
						$delay = $atts['delay'] * ($count) + $atts['start_delay'];
					} else {
						$delay = (int)$atts['delay'] + (int)$atts['start_delay'];
					}
					$data .= zorbix::sprintf_if_exists(' data-animate-delay="%s"', esc_attr($delay));
				}

			}

		}

		return $data;
	}

	/**
	 * Setts the shortcode attributes for icons
	 *
	 * @usage $default_atts = zorbix_sc::get_icon_atts('', $default_atts);
	 * @param string $postfix
	 * @param array $default_atts
	 *
	 * @return array
	 */
	public static function get_icon_atts($postfix = '', $default_atts = array())
	{

		$postfix = (!empty ($postfix)) ? '_' . $postfix : '';

		$icon_atts = array(
			'icon' . $postfix             => '',
			'icon_type' . $postfix        => 'icon_fontawesome',
			'icon_fontawesome' . $postfix => '',
			'icon_openiconic' . $postfix  => '',
			'icon_typicons' . $postfix    => '',
			'icon_entypoicons' . $postfix => '',
			'icon_linecons' . $postfix    => '',
			'icon_entypo' . $postfix      => '',
			'icon_color' . $postfix       => '',
			'icon_bg' . $postfix          => ''
		);

		$atts = wp_parse_args($default_atts, $icon_atts);

		return $atts;

	}


	/**
	 * column, animation, cpt, icon, makewhite, tax
	 * <code>$default_atts = Zorbix_Sc::add_attr_set($default_atts, array('icon'));</code>
	 *
	 * @param $atts
	 * @param $sets
	 *
	 * @return array
	 */
	public static function get_attr_set($atts, $sets)
	{
		if (in_array('column', $sets)) {

			$column_atts = array(
				'columns_check'  => '',
				'col_width'      => 'col-md-4',
				'num_columns'    => '',
				'center_columns' => '',
			);
			$atts = array_merge($column_atts, $atts);
		}

		// Animation atts
		if (in_array('animation', $sets)) {
			$animation_atts = array(
				'animate_check' => '',
				'start_delay'   => '',
				'effect'        => '',
				'delay'         => '',
			);
			$atts = array_merge($animation_atts, $atts);
		}

		// CPT atts
		if (in_array('cpt', $sets)) {
			$cpt_atts = array(
				'num'      => '-1',
				'terms'    => '',
				'id'       => '',
				'class'    => '',
				'order'    => '',
				'taxonomy' => '',
			);
			$atts = array_merge($cpt_atts, $atts);
		}

		if (in_array('padding', $sets)) {
			$atts = array_merge(array(
				'padding'        => '',
				'padding_top'    => '',
				'padding_right'  => '',
				'padding_bottom' => '',
				'padding_left'   => '',
			), $atts);
		}

		if (in_array('margin', $sets)) {
			$atts = array_merge(array(
				'margin'        => '',
				'margin_top'    => '',
				'margin_right'  => '',
				'margin_bottom' => '',
				'margin_left'   => '',
			), $atts);
		}

		if (in_array('icon', $sets)) {

			$icon_atts = array(
				'icon'             => '',
				'icon_type'        => '',
				'icon_fontawesome' => '',
				'icon_openiconic'  => '',
				'icon_typicons'    => '',
				'icon_entypoicons' => '',
				'icon_linecons'    => '',
				'icon_entypo'      => '',
				'icon_color'       => ''
			);


			$atts = array_merge($icon_atts, $atts);
		}

		// Make White
		if (in_array('makewhite', $sets)) {
			$makewhite_atts = array(
				'makewhite' => '',
			);
			$atts = array_merge($makewhite_atts, $atts);
		}

		return $atts;
	}

	/**
	 *
	 * @param $options
	 * @param array $args
	 * @return WP_Query
	 */
	public static function cpt($options, $args = array())
	{
		$atts = $options['atts'];

		$terms = explode(',', $atts['terms']);

		# Get Posts
		$args = array_merge(
			array(
				'post_type'      => $options['post_type'],
				'posts_per_page' => $atts['num'],
					'order_by' => 'menu_order'
			),
			$args
		);

		/*
		 * When order is not default it is not compatible with order anything plugins
		 * Some plugins don't work at all with wp_query (nested pages)
		 */
		if( '' !== $atts['order'] ) {
			$args['order'] = $atts['order']; // dsc or asc
		}

		# Add taxonomy if given
		if (!empty($options['tax']) && $atts['terms']) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => $options['tax'],
					'field'    => 'slug',
					'terms'    => $terms,
				),
			);
		}

		# Query and return results
		$query = new WP_Query($args);

		return $query;
	}


	/**
	 * @param       $post_type
	 * @param       $num
	 * @param null $taxonomy
	 * @param array $args
	 *
	 * @return WP_Query
	 * @deprecated for Zorbix-sc::cpt
	 */
	public static function query_cpt($post_type, $num, $taxonomy = null, $args = array())
	{
		# Get Posts
		$args = array_merge(array('post_type' => $post_type, 'posts_per_page' => $num), $args);

		# Add taxonomy if given
		if (!empty($taxonomy)) {
			if (is_array($taxonomy)) {
				if (!empty($taxonomy[1])) {
					$terms = explode(', ', $taxonomy[1]);
					$args['tax_query'] = array(
						array(
							'taxonomy' => $taxonomy[0],
							'field'    => 'slug',
							'terms'    => $terms,
						),
					);
				}
			}
		}

		# Query and return results
		return new WP_Query($args);

	}

	public static function cpt_debug($cpt_posts)
	{
		var_dump('post_count ', $cpt_posts->post_count, 'posts', $cpt_posts->posts);
	}


	public static function col_seperator($post, $cols, $col_width = null, $class = '')
	{
		# If cols not set, set it according to the col_width
		if ($cols == 0) {
			$cols = self::class_to_num($col_width);
		}

		$current_post = $post->current_post + 1;
		$col_width = self::class_to_num($col_width);

// If cols less then col width add seperator to nth $col
		if ($current_post % $cols == 0 && $current_post != $post->post_count) {
			echo '<div class="seperator ' . esc_attr($class) . '"></div>';
		}
	}

	public static function get_col_seperator($post, $cols, $col_width = null, $class = '')
	{
		# If cols not set, set it according to the col_width
		if ($cols == 0) {
			$cols = self::class_to_num($col_width);
		}

		$current_post = $post->current_post + 1;
		$col_width = self::class_to_num($col_width);

// If cols less then col width add seperator to nth $col
		if ($current_post % $cols == 0 && $current_post != $post->post_count) {
			return '<div class="seperator ' . esc_attr($class) . '"></div>';
		}
	}

	public static function get_seperator($current_num, $num_cols, $total, $class = '')
	{
		if ($current_num % $num_cols == 0 && $current_num != $total) {
			return '<div class="seperator ' . $class . '"></div>';
		}
	}


	private static function class_to_num($num)
	{
		switch ($num) {
			case 'col-md-6':
				return 2;
				break;
			case 'col-md-4':
				return 3;
				break;
			case 'col-md-?':
				return 5;
				break;
			case 'col-mb-2':
				return 6;
				break;
			default:
				return 4;
				break;
		}
	}

	# MERGE MAPS AND CONVERT TO VAFPRESS
	public static function vc_to_vp($button_map)
	{

		# Change Title to name
		$button_map['title'] = $button_map['name'];
		unset($button_map['name']);

		# Remove Category
		unset($button_map['category']);

		# Change params to attributes
		$button_map['attributes'] = $button_map['params'];
		unset($button_map['params']);

		# Set the text inside shortcode
		if (isset($button_map['content_msg'])) {
			$content_msg = $button_map['content_msg'];
		} else {
			$content_msg = 'Your content here';
		}
		if (!zorbix::in_array_r('content', $button_map['attributes'])) {
			$content_msg = '';
		}

		$button_map['code'] = "[{$button_map['base']}]{$content_msg}[/{$button_map['base']}]";

		# Loop through each field
		foreach ($button_map['attributes'] as $key => $value) {

			$array = '';

			if ($value['param_name'] != 'content') { # Remove holder att
				unset($value['holder']);

				# Change Key from heading to label
				$value['label'] = $value['heading'];
				unset($value['heading']);

				# Convert VC field name to VP field names
				switch ($value['type']) {
					case 'vc_link':
						$value['type'] = 'textbox';

						$button_map['attributes'][] = array(
							'type'        => 'textbox',
							'name'        => 'target',
							'label'       => esc_html__('Target', 'zorbix'),
							'description' => esc_html__('eg _blank to open in a new window', 'zorbix'),
						);

						$button_map['attributes'][] = array(
							'type'  => 'textbox',
							'name'  => 'title',
							'label' => esc_html__('Link Title', 'zorbix'),
						);

						break;
					case 'textarea_html':
						$value ['type'] = 'wpeditor';
						break;
					case 'attach_images':
						$value['type'] = 'upload';
						break;
					case 'zorbix_note':
						$value['type'] = 'notebox';
						break;
					case 'dropdown':
						$value['type'] = 'select';
						break;
					case 'textfield':
						$value['type'] = 'textbox';
						break;
					case 'font_awesome':
						$value['type'] = 'fontawesome';
						break;
					case 'attach_image':
						$value['type'] = 'upload';
						break;
					case 'range':
						$value['type'] = 'range';
						break;
					case 'checkbox':
						$value['type'] = 'toggle';
						break;
					default:
						// None
						break;
				}

				# If dependencey is set delete its counterpart
				// if( isset($value['dependency']) ) {
				// # Get field name
				// 	$remove_fields[] = $value['dependency']['element'];
				// }

				# Change param_name to name
				$value['name'] = $value['param_name'];
				unset($value['param_name']);

				# change value labels
				if (isset($value['value']) && is_array($value['value'])) {
					foreach ($value['value'] as $key2 => $value2) {
						$array[] = array('label' => $key2, 'value' => $value2);
					}
					$value['items'] = $array;
					unset($value['value']);
				}

				# Convert dependency if set
				if (isset($value['dependency'])) {
					# Change element key to field
					$value['dependency']['field'] = $value['dependency']['element'];
					unset($value['dependency']['element']);
					# unset value key
					unset($value['dependency']['value']);
					# add function field that links to vp default check funtion.
					$value['dependency']['function'] = 'vp_dep_boolean';
				}

				# Asign changed values to map
				$button_map['attributes'][$key] = $value;
			} else {
				unset($button_map['attributes'][$key]);
			}

		} # End foreach;

		# Remove any fields with dependents if is a checkbox
		if (isset($remove_fields)) {
			foreach ($button_map['attributes'] as $key => $value) {
				if (in_array($value['name'], $remove_fields) && $value['type'] == 'checkbox') {
					unset($button_map['attributes'][$key]);
				}
			}
		}

//		$name       = $button_map['base'];
//		$button_map = array( $button_map['base'] => $button_map );
//		unset( $button_map[ $name ]['base'] );

		return $button_map;
	} # END: zorbix_convert_vc_map_to_vp


	/**
	 * Helper to add a shortcode to the vp shortcode menu
	 *
	 * <code>
	 * Zorbix_Sc::add_vp_map( 'Dashes', array(
	 * 'dash' => array(
	 *      "title"      => esc_html__( "Dash Left", 'zorbix' ),
	 *      "code"       => '<div class="dash"></dash>',
	 * ) ) );
	 * </code>
	 *
	 * @param $section
	 * @param $set
	 */
	static function add_vp_map($section, $name, $set)
	{
		zorbix_sc::$vc_maps[$section]['elements'][$name] = $set;
	}

	static public function div_atts($atts)
	{
		$html = '';
		foreach ($atts as $key => $value) {
			if ($value) {
				if (!is_array($value)) {
					$value = esc_attr($value);
					$html .= " $key='$value'";
				} elseif ($key == 'class') {
					$html .= ' class="';
					foreach ($value as $class) {
						$class = esc_attr($class);
						$html .= " $class";
					}
					$html .= '"';
				} elseif ($key == 'style') {
					$style = '';
					foreach ($value as $style_att => $style_value) {
						if ($style_value) {
							if ($style_att == 'bg-img') {
								$style .= 'background-image: url(' . esc_url($style_value) . ');';
							} else {
								$style_value = esc_attr($style_value);
								$style .= "$style_att: $style_value;";
							}
						}
					}
					if ($style) {
						$html .= ' style="';
						$html .= esc_attr($style);
						$html .= '"';
					}
				}
			}
		}

		return $html;
	}


	/**
	 *
	 * Removes empty user set attributes before running shortcode_atts. Useful for a page builder that sets
	 * empty atts.
	 *
	 * @param            $default_atts
	 * @param            $atts
	 * @param            $shortcode
	 * @param bool|false $debug
	 *
	 * @return array
	 */
	static function shortcode_atts($default_atts, $atts, $shortcode = '', $debug = false)
	{
		$filtered_atts = '';

		if ($debug) {

			var_dump($shortcode);
			var_dump('default');
			var_dump($default_atts);

			var_dump('set atts');
			var_dump($atts);
		}

		// if the change columns not checked we
		// Want default values
		if (isset($atts['column_check']) && !$atts['columns_check']) {
			$atts['col_width'] = $atts['num_columns'] = '';
		}
		if (is_array($atts)) {
			$filtered_atts = array_filter($atts);
		}

		if ($debug) {
			zorbix::debug(shortcode_atts($default_atts, $atts), 'returned Shortcode atts');
		}

		return shortcode_atts($default_atts, $filtered_atts);
	}

	public static function port_cats()
	{
		global $post;
		$terms = get_the_terms($post->ID, 'portfolio');
		$cats = array();
		if (is_array($terms) && '' !== $terms) {
			foreach ($terms as $term) {
				$cats[] = $term->slug;
			}
			echo esc_html(implode(', ', $cats));
		}
	}

	public static function port_list($all)
	{
		$terms = get_terms('portfolio');
		if ('' !== $terms) {
			echo '<li class="selected" data-cat="*">' . esc_html($all) . '</li>';
			foreach ($terms as $term) {
				$cat_title = $term->name;
				$cat_hook = $term->slug;
				echo '<li data-cat="' . esc_attr($cat_hook) . '">' . esc_attr($cat_title) . '</li>';
			}
		} else {
			echo 'no cats';
		}
	}


	public static function escaped_class_attr($class)
	{
		if (!empty($class)) {
			return sprintf('class="%s"',
				esc_attr($class)
			);
		} else {
			return '';
		}
	}

	public static function format_style_esc_multi($array)
	{
		echo self::get_format_style_esc_multi($array);
	}

	public
	static function get_format_style_esc_multi($array)
	{
		$array_arg = func_get_args();
		$str = '';
		foreach ($array_arg as $array) {
			if (is_array($array)) {
				foreach ($array as $att => $value) {
					if ('0' === $value || !empty($value)) {

						if ( zorbix::str_contains($att, 'padding-') || zorbix::str_contains($att, 'margin-')) {
							$value = (!zorbix::str_contains($value, 'px')) ? (int)$value . 'px' : $value;
						}


						$value = ($att === 'background-image') ? 'url(' . $value . ')' : $value;

						$str .= sprintf('%s: %s;', $att, $value);
					}
				}
			}
		}
		return 'style="' . esc_attr($str) . '"';
	}

	public
	static function get_format_style_esc($att, $value)
	{
		if ('0' === $value || !empty($value)) {
			$value = ($att === 'margin-bottom') ? (int)$value . 'px' : $value;

			$value = ($att === 'background-image') ? 'url(' . $value . ')' : $value;

			// Theses atts must be escapped
			return sprintf('style="%s: %s"', esc_attr($att), esc_attr($value));
		} else {
			return '';
		}
	}

	public
	static function format_style_esc($att, $value)
	{
		$value = ($att === 'margin-bottom') ? (int)$value . 'px' : $value;
		if (!empty($value)) {
			printf('style="%s: %s"', esc_attr($att), esc_attr($value));
		}
	}

	public
	static function remove_px($value)
	{
		return str_replace('px', '', $value);
	}

	public
	static function get_div_att_esc($div_att, $val)
	{
		if (!empty($val)) {
			return sprintf('%s="%s"', esc_attr($div_att), esc_attr($val));
		} else {
			return '';
		}
	}

	public static function get_social_array()
	{

		return array(
			'facebook',
			'twitter',
			'behance',
			'delicious',
			'deviantart',
			'digg',
			'dribbble',
			'dropbox',
			'envelope',
			'flickr',
			'foursquare',
			'github',
			'google',
			'instagram',
			'linkedin',
			'pinterest',
			'reddit',
			'rss',
			'skype',
			'soundcloud',
			'stumbleupon',
			'tumblr',
			'vimeo',
			'eddcoons_portfolio',
			'xing',
			'yahoo',
			'youtube'
		);
	}

	public
	static function esc_shortcode_tag($shortcode)
	{
		$shortcode = esc_html($shortcode);
		$shortcode = str_replace('&quot;', '"', $shortcode);
		$shortcode = str_replace('&quot;', '"', $shortcode);
		$shortcode = str_replace('&amp;', '&', $shortcode);

		return $shortcode;
	}


	public
	static function get_video_background($video_type, $youtube_link, $mp4_url, $webm_url)
	{

		// Video
		$video = '';
		if ($video_type != '' && $youtube_link != '' || $video_type != '' && $mp4_url != '') {

			// ID
			if (empty($el_id)) {
				$el_id = 'bngVideo';
			}

			// Youtube
			if ($video_type == 'youtube') {
				if (!is_ssl()) {
					$youtube_link = str_replace('https', 'http', $youtube_link);
				}
				$ytplayer_json = "{videoURL:'" . esc_url($youtube_link)
					. "',containment:'#" . esc_attr($el_id)
					. "', autoPlay:true, mute:true, startAt:0, opacity:1}";

				return '<a id="bgndVideo" class="player" data-property="' . esc_attr($ytplayer_json) . '"> </a> ';
			}
			// Upload
			if ($video_type == 'upload') {
				$html = "<video class='video-background' autoplay loop preload='auto' muted>";
				$html .= sprintf('<source src="%s" type="video/mp4">', esc_url($mp4_url));
				# Firefox 4
				$html .= zorbix::sprintf_if_exists("<source type='video/webm' src='%s' />", esc_url($webm_url));
				$html .= '</video>';

				return $html;
			}

		}
	}

	/**
	 * @param $video_type upload|bngVideo|youtube
	 * @param $youtube_link
	 * @param $video_type
	 * @param $mp4_url
	 * @param $webm_url
	 */
	public
	static function video_background($video_type, $youtube_link, $mp4_url, $webm_url)
	{
		echo self::get_video_background($video_type, $youtube_link, $mp4_url, $webm_url);
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
	public static function icon($atts, $postfix = '')
	{

		$postfix = (!empty($postfix)) ? '_' . $postfix : $postfix;

		if (function_exists('vc_icon_element_fonts_enqueue')) {
			vc_icon_element_fonts_enqueue($atts['icon_type' . $postfix]);
		}

		switch ($atts['icon_type' . $postfix]) {
			case 'openiconic':
				$atts['icon' . $postfix] = $atts['icon_openiconic' . $postfix];
				break;
			case 'typicons':
				$atts['icon' . $postfix] = $atts['icon_typicons' . $postfix];
				break;
			case 'entypoicons':
				$atts['icon' . $postfix] = $atts['icon_entypoicons' . $postfix];
				break;
			case 'linecons':
				$atts['icon' . $postfix] = $atts['icon_linecons' . $postfix];
				break;
			case 'entypoicons':
				$atts['icon' . $postfix] = $atts['icon_entypoicons' . $postfix];
				break;
			case 'entypo':
				$atts['icon' . $postfix] = $atts['icon_entypo' . $postfix];
				break;
			default:
				$atts['icon' . $postfix] = 'fa ' . $atts['icon_fontawesome' . $postfix];
		}

		if (empty($atts['icon' . $postfix])) {
			$atts['icon' . $postfix] = 'fa-info';
		}

		return $atts;
	}

	/**
	 *
	 * Prepends to a value if the value is not empty
	 *
	 * @param $value
	 * @param $prepend_value
	 *
	 * @return string
	 */
	public static function prepend($value, $prepend_value)
	{
		return (!empty($value)) ? $prepend_value . $value : '';
	}

	public static function get_style_atts($set, $atts)
	{
		if ('spacing' === $set) {
			if (isset($atts['padding']) && isset($atts['margin'])) {
				return array(
					'padding'        => $atts['padding'],
					'padding-top'    => $atts['padding_top'],
					'padding-right'  => $atts['padding_right'],
					'padding-bottom' => $atts['padding_bottom'],
					'padding-left'   => $atts['padding_left'],
					'margin'         => $atts['margin'],
					'margin-top'     => $atts['margin_top'],
					'margin-right'   => $atts['margin_right'],
					'margin-bottom'  => $atts['margin_bottom'],
					'margin-left'    => $atts['margin_left'],
				);
			}
		}
	}

	public static function video_bg($video_type, $youtube_link, $mp4_url, $webm_url)
	{
		// Video
		$video = '';
		$output = '';
		if ($video_type !== '' && $youtube_link !== '' || $video_type !== '' && $mp4_url !== '') {

			// ID
			if (empty($el_id)) {
				$el_id = 'bngVideo';
			}

			// Youtube
			if ($video_type === 'youtube') {
				if (!is_ssl()) {
					$youtube_link = str_replace('https', 'http', $youtube_link);
				}
				$ytplayer_json = "{videoURL:'" . esc_url($youtube_link)
					. "',containment:'#" . esc_attr($el_id)
					. "', autoPlay:true, mute:true, startAt:0, opacity:1}";
				$output .= '<a id="bgndVideo" class="player" data-property="' . esc_attr($ytplayer_json) . '"> </a> ';
			}
			// Upload
			if ($video_type === 'upload') {

				$mp4_url = wp_get_attachment_url($mp4_url);
				$webm_url = wp_get_attachment_url($webm_url);
				$output .= "<video class='video-background' autoplay loop preload='auto' muted>";
				$output .= sprintf('<source src="%s" type="video/mp4">', esc_url($mp4_url));
				# Firefox 4
				$output .= zorbix::sprintf_if_exists("<source type='video/webm' src='%s' />", esc_url($webm_url));
				$output .= '</video>';
				$output .= '<div class="video_controls"><a href="#" class="video_pause"><i class="fa fa-play"></i></a> <a href="#" class="video_mute"><i class="fa fa-volume-off"></i></a></div>';
			}

			return $output;

		}
	}
}

add_action('wp_loaded', array('zorbix_sc', 'get_instance'));


// Escaped functions

if (!(function_exists('zorbix_anim_data_esc'))) {
	/**
	 * @param      $atts
	 * @param null $cpt_posts
	 */
	function zorbix_anim_data_esc($atts, $cpt_posts = null)
	{
		return zorbix_sc::animation_data_esc($atts, $cpt_posts);
	}
}


if (!(function_exists('zorbix_esc_get_div_att'))) {
	/**
	 * @param $div_att
	 * @param $val
	 *
	 * @return string
	 */
	function zorbix_esc_get_div_att($div_att, $val)
	{
		return zorbix_sc::get_div_att_esc($div_att, $val);
	}
}

if (!(function_exists('zorbix_do_sc_autop'))) {
	function zorbix_do_sc_autop($content)
	{
		return wpautop(do_shortcode($content));
	}
}

if (!(function_exists('zorbix_get_format_style_esc'))) {
	function zorbix_get_format_style_esc($att, $value)
	{
		return zorbix_sc::get_format_style_esc($att, $value);
	}
}

