<?php

// Set Option Tree theme mode
add_filter('ot_theme_mode', '__return_false');
// Remove Option tree from main menu entry
add_filter('ot_show_pages', '__return_false');
// Remove Option Tree from appearance menu
add_action('admin_menu', 'remove_ot_theme_options_page', 999);
function remove_ot_theme_options_page()
{
	// Make sure that the page isn't being used by a theme
	if (!has_filter('ot_theme_mode', '__return_true') && has_filter('ot_show_pages', '__return_false')) {
		remove_submenu_page('themes.php', 'ot-theme-options');
	}
}

// Include optiontree for metaboxes
require(ZORBIX_PLUGIN_DIR . 'vendor/option-tree/ot-loader.php');