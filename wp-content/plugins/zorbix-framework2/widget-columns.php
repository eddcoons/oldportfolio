<?php
/*
 * @Adapted By: Zackary Allnutt
 *
 * Adapted for use with modern bootstrap classes by Zorbix.
 *
 * Author:		Jory Hogeveen
 * Author URI:	http://www.keraweb.nl
 * License:		GPLv2
*/

!defined('ABSPATH') and die('You shall not pass!');

$zorbix_widget_column_classes = new zorbix_widget_classes();

class zorbix_widget_classes
{

	/**
	 * Init function to register plugin hook
	 *
	 * @since   1.1
	 * @return    void
	 */
	function __construct()
	{

		// Lets start!
		add_action('init', array($this, 'init'));
	}

	/**
	 * Init function/action and register all used hooks
	 *
	 * @since   1.1
	 * @return    void
	 */
	function init()
	{
		add_filter('widget_form_callback', array($this, 'widget_form_extend'), 10, 2);
		add_filter('widget_update_callback', array($this, 'widget_update'), 10, 2);
		add_filter('dynamic_sidebar_params', array($this, 'sidebar_params'));
	}


	/**
	 * Add options to the widgets
	 *
	 * @param    array $instance
	 * @param    object $widget
	 *
	 * @since   0.1
	 * @return    array $instance
	 */
	function widget_form_extend($instance, $widget)
	{
		if (!isset($instance['column-classes']))
			$instance['column-classes'] = null;


		$columnClasses = array('',
			'col-md-2',
			'col-md-3',
			'col-md-4',
			'col-md-5',
			'col-md-6',
			'col-md-7',
			'col-md-8',
			'col-md-9',
			'col-md-10',
			'col-md-11',
			'col-md-12'
		);

		echo '<p style="border: 1px solid #eee; padding: 5px; background: #f5f5f5;">';
		echo '<label for="widget-' . esc_attr($widget->id_base) . '-' . esc_attr($widget->number) . '-column-classes">' . esc_html__('Width') . ':</label> ';
		echo '<select name="widget-' . esc_attr($widget->id_base) . '[' . esc_attr($widget->number) . '][column-classes]" id="widget-' . esc_html($widget->id_base) . '-' . esc_attr($widget->number) . '-column-classes">';


		foreach ($columnClasses as $className) {
			if ($className !== '') {
				$classLabel = $className;
			} else {
				$classLabel = esc_html__('none', 'pixo');
			}
			$selected = '';
			if (isset($instance['column-classes']) && $instance['column-classes'] === $className) {
				$selected = ' selected="selected"';
			}
			echo '<option value="' . esc_attr($className) . '"' . esc_attr($selected) . '>' . esc_html($classLabel) . '</option>';
		}

		echo '</select>';
		echo '</p>';


		return $instance;
	}

	/**
	 * Add the new fields to the update instance
	 *
	 * @param    array $instance
	 * @param    array $new_instance
	 *
	 * @since   0.1
	 * @return    array $instance
	 */
	function widget_update($instance, $new_instance)
	{
		if (isset($new_instance['column-classes'])) {
			$instance['column-classes'] = strip_tags($new_instance['column-classes']);
		} else {
			$instance['column-classes'] = '';
		}
		return $instance;
	}

	/**
	 * Add classes to the widget
	 *
	 * @param    array $params
	 *
	 * @since   0.1
	 * @return    array    $params
	 */
	function sidebar_params($params)
	{
		global $wp_registered_widgets;
		$widget_id = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[$widget_id];
		$widget_opt = get_option($widget_obj['callback'][0]->option_name);
		$widget_num = $widget_obj['params'][0]['number'];

		$widget_extra_classes = '';
		if (isset($widget_opt[$widget_num]['column-classes']) && !empty($widget_opt[$widget_num]['column-classes'])) {
			$widget_extra_classes .= $widget_opt[$widget_num]['column-classes'] . ' ';
		}

		$params[0]['before_widget'] = preg_replace('/class="/', 'class="' . $widget_extra_classes, $params[0]['before_widget'], 1);

		return $params;
	}

}
