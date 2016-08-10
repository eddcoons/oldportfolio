<?php defined('ABSPATH') || die;

/**
 * Called via ajax to run importer
 */
function zorbix_importer_ajax_callback()
{
	// The $_REQUEST contains all the data sent via ajax
	if (isset($_REQUEST['file'])) {
		$file = esc_url(wp_unslash($_REQUEST['file']));
		Zorbix_Importer::demo_import($file);
	}
	// Always die in functions echoing ajax content
	die();
}

add_action('wp_ajax_zorbix_importer_ajax_callback', 'zorbix_importer_ajax_callback');

add_action('wp_loaded', array('Zorbix_Importer', 'get_instance'));

class Zorbix_Importer
{

	/**
	 * @var null
	 */
	private static $instance = null;

	/**
	 * Instance auto loaded
	 */
	static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new Zorbix_Importer();
		}
	}

	public static function demo_import($file)
	{

		// Include Custom Importer Class
		include(ZORBIX_PLUGIN_DIR . 'importer/wp-importer/wordpress-importer.php');

		// Import file
		$newimport = new zorbix_wp_importer();
		$content_file = $file;

		if (file_exists($content_file)) {
			$newimport->fetch_attachments = true;
			echo '<h2>' . esc_html__('WordPress Importer Message:', 'zorbix') . '</h2>';
			$newimport->import($content_file);
			echo '<h2>' . esc_html__('Theme Message:', 'zorbix') . '</h2>';
			echo '<p>' . esc_html__('Revolution Slider demo needs to be imported separately, see the docs. Refresh page to see changes.', 'zorbix') . '</p>';
			self::set_menu_location();
			self::set_pages();

		} else {
			esc_html_e('Cannot find file', 'zorbix');
		}
	}

	public static function set_menu_location()
	{
		$menu_name
			= 'Demo Menu Multi';
		$menu_location
			= 'main';

		$locations
			= get_theme_mod('nav_menu_locations');
		$menu_array
			= wp_get_nav_menus();

		# Get ID of the menu to assign
		if (is_array($menu_array)) {
			foreach ($menu_array as $menu) {
				if ($menu->name == $menu_name) {
					$locations[$menu_location]
						= $menu->term_id;
				}
			}
		}

# Assign the menu to the location
		set_theme_mod('nav_menu_locations', $locations);

	}

	public static function set_pages()
	{
		$front_page = get_page_by_title('Multi Homepage - Default');
		$blog = get_page_by_title('Blog');

		if (isset($front_page->ID) && isset($blog->ID)) {
			# set to static page
			update_option('show_on_front', 'page');
			# Set front page to Home
			update_option('page_on_front', $front_page->ID);
			# Set Posts Page to blog
			update_option('page_for_posts', $blog->ID);
		}
	}

}
