<?php

/*
 * v0.3
 */

class Zorbix_support
{

	private static $instance = null;
	static $get = NULL;

	static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new Zorbix_support();
			self::add_page();
		}
	}

	public static function get($setting)
	{
		return self::$get[$setting];
	}

	public static function page_callback()
	{
		add_menu_page('Theme Help', 'Theme Help', 'manage_options', 'zorbix-help', array('zorbix_support', 'help_page'), 'dashicons-editor-help');

		add_menu_page('Theme Options', 'Theme Options', 'manage_options', 'customize.php');
	}

	private static function add_page()
	{

		add_action('admin_menu', array('zorbix_support', 'page_callback'));
	}

	public static function get_activated_plugins()
	{
		$loaded_plugins = get_plugins();
		$activated_plugins = array();
		foreach ($loaded_plugins as $key => $plugin) {
			if (is_plugin_active($key)) {
				$name = $plugin['Name'];
				$activated_plugins[$name] = $plugin['Version'];
			}
		}
		return $activated_plugins;
	}

	public static function help_page()
	{
		global $wp_version;
		echo '<div class="support-page">';

		include locate_template('admin/main-help.php');
		echo ob_get_clean();

		$info_array = array(
				'Wordpress Version'  => $wp_version,
				'PHP Version'        => phpversion(),
				'Theme Version'      => wp_get_theme()->version,
				'Theme Url'          => admin_url(),
				'Server Software'    => $_SERVER['SERVER_SOFTWARE'],
				'Active Theme'       => wp_get_theme()->name,
				'Child Theme'        => var_export( is_child_theme(), true ),
				'Post Max Size'      => ini_get('post_max_size'),
				'Max execution time' => ini_get('max_execution_time'),
				'Memory Limit ( WP sets as 256M by default )'       => ini_get('memory_limit'), // WordPress defaults that are higher then php_ini. 256M
				'Display Errors'     => ini_get('display_errors'),
				'Log Errors'         => ini_get('log_errors'),
		);

		$loaded_plugins = get_plugins();
		$required_plugins = array('PIXO');

//		var_dump(self::get_activated_plugins());
		$activated_plugin_names = array_keys(self::get_activated_plugins());



		GLOBAL $tgmpa;

		foreach ($tgmpa->plugins as $slug => $plugin) {
			if (false === $tgmpa->is_plugin_active($slug)) {
				if (true === $plugin['required']) {
					$messages_required[] = esc_html__("A required plugin is not activated: ", 'pixo') . $slug;
				} else {
					$messages_not_required[] = esc_html__("A recommended plugin is not activated: ", 'pixo') . $slug;
				}
			} else {
				if ($tgmpa->does_plugin_require_update($slug)) {
					$messages_required[] = esc_html__("A plugin is not the most current version: ", 'pixo') . $slug;
				}
			}

		}

		if (is_child_theme()) {
			$messages_required[] = esc_html__("Please test your issue with the child theme turned off", 'pixo');
		}

		if (true === zorbix_update_checker::compare_versions()) {
			$messages_required[] = esc_html__('Your not running the latest version on the theme.', 'pixo');
		}

		if (isset($messages_required)) {
			echo '<h2>' . esc_html__('Issues that must be resolved', 'pixo') . '</h2><ul class="list">';
			foreach ($messages_required as $message) {
				echo '<li>' . esc_html($message) . "</br>";
			}
		}
		echo '</ul>';

		if (isset($messages_not_required)) {
			echo '<h2>' . esc_html__('Potental Issues that may need to be resolved', 'pixo') . '</h2><ul>';
			foreach ($messages_not_required as $message) {
				echo '<li>' . esc_html($message);
			}
		}

		echo '</ul>';


//		foreach ($required_plugins as $name) {
//			if (!in_array($name, $activated_plugin_names)) {
//				echo esc_html__('Please activate and install the required plugin: ', 'pixo') . $name;
//			}
//		}

		echo '<h2>' . esc_html__('Info For support', 'pixo') . '</h2>';
		echo '<textarea>';

		if (isset($messages_required)) {
			echo "Messages Required \n";
			echo "---------------------\n";
			foreach ($messages_required as $message) {
				echo esc_html($message) . "\n";
			}
		}
		if (isset($messages_not_required)) {
			echo "Messages Recommended \n";
			echo "---------------------\n";
			foreach ($messages_not_required as $message) {
				echo esc_html($message) . "\n";
			}
		}

		echo "\nInfo \n";
		echo "---------------------\n";
		foreach ($info_array as $title => $value) {
			echo esc_html($title) . ': ' . esc_html($value) . "\n";
		}
		echo "\nActive Plugins:\n";
		echo "---------------------\n";
		foreach ($loaded_plugins as $key => $plugin) {
			if (is_plugin_active($key)) {

				$activated_plugin_names[] = $plugin['Title'];

				printf("%s: %s\n",
						esc_html($plugin['Title']),
						esc_html($plugin['Version'])
				);
			}
		}
		echo '</textarea>';

		echo '<h2>Info</h2>';
		echo '<table>';
		foreach ($info_array as $title => $value) {
			echo '<tr><th>';
			echo esc_html($title);
			echo '</th>';
			echo '<td>';
			echo esc_html($value);
			echo '</td></tr>';
		}
		echo '</table>';

		echo '<h2>Plugins</h2>';
		echo '<table>';
		foreach ($loaded_plugins as $key => $plugin) {
			$active_class = (is_plugin_active($key)) ? 'active' : 'not-active';
			printf('<tr><th class="%s" >', esc_html($active_class));
			echo esc_html($plugin['Title']);
			echo '</th>';
			echo '<td>';
			echo esc_html($plugin['Version']);
			echo '</td></tr>';
		}
		echo '</table>';
		echo '</div>'; // End .support-page


	}
}


add_action('wp_loaded', array('Zorbix_support', 'get_instance'));
