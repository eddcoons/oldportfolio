<?php defined( 'ABSPATH' ) || die;
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package       TGM-Plugin-Activation
 * @subpackage    Example
 * @version       2.3.6
 * @author        Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author        Gary Jones <gamajo@gamajo.com>
 * @copyright     Copyright (c) 2012, Thomas Griffin
 * @license       http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link          https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

// Make plugins list globally availacle for vrsion checking script
zorbix_helper::$plugins = array(

		array(
				'name'     => 'Zorbix Framework', // The plugin name
				'version'     => '0.3.2',
				'slug'     => 'zorbix-framework2',
				'source'   => PIXO_PLUGINS_DIR . 'zorbix-framework.zip', // The plugin source
				'required' => true, // If false, the plugin is only 'recommended' instead of required
//				'force_activation' => true,
		),

		array(
				'name' => 'Envato Market',
				'slug' => 'envato-market',
				'source' => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
				'required' => true,
				'recommended' => true,
				'force_activation' => false,
		),

		array(
				'name'     => 'Revolution Slider',
				'slug'     => 'revslider',
				'version'  => '5.2.5.1',
				'source'   => PIXO_PLUGINS_DIR . 'revslider.zip', // The plugin source
				'required' => false,
		),

		array(
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'recommended' => true,
				'required' => false
		),

);

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once PIXO_ADMIN_DIR . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'pixo_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function pixo_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 *
	 * Slug must be name of the folder when installed, otherwise it wont know it's installed
	 */


	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
			'domain'       => 'pixo',            // Text domain - likely want to be the same as your theme.
			'default_path' => '',                            // Default absolute path to pre-packaged plugins
			'parent_slug'  => 'themes.php',                // Default parent URL slug
			'menu'         => 'install-required-plugins',    // Menu slug
			'has_notices'  => true,                        // Show admin notices or not
			'is_automatic' => true,                        // Automatically activate plugins after installation or not
			'message'      => '',                            // Message to output right before the plugins table
			'nag_type'     => 'updated',
	);

	tgmpa( zorbix_helper::$plugins, $config );

}
