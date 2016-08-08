<?php
/**/
/* Shortcode Buttons
/**/

/*
 * Add to the WPEditor style dropdown
 */

add_editor_style(PIXO_URI . 'admin/wpeditor/editor-style.css');

function pixo_wbs_buttons($buttons)
{
	array_unshift($buttons, 'styleselect');
	return $buttons;
}

add_filter('mce_buttons_2', 'pixo_wbs_buttons');


/*
* Callback function to filter the MCE settings
*/

function pixo_mce_before_init_insert_formats($init_array)
{

	/*
	 * Define the style_formats array
	 *
	 * hr's dont work
	 */


	$style_formats = array(
		// Each array child is a format with it's own settings

		array(
			'title'   => 'Heading',
			'block'   => 'span',
			'classes' => 'heading',
			'wrapper' => true,
		),
		array(
			'title'   => 'Dropcap',
			'block'   => 'span',
			'classes' => 'dropcap',
			'wrapper' => true,
		),

		array(
			'title'   => 'Selector Text',
			'block'   => 'h1',
			'classes' => 'selector-font',
			'wrapper' => false,
		),
		array(
			'title' => 'Heading sizes (to retain hierarchy)',
			'items' => array(
				array(
					'title'   => 'H1',
					'classes' => 'h1',
					'wrapper' => true,
				),
				array(
					'title'   => 'H2',
					'classes' => 'h2',
					'wrapper' => true,
				),
				array(
					'title'   => 'H3',
					'classes' => 'h3',
					'wrapper' => true,
				),
				array(
					'title'   => 'H4',
					'classes' => 'h4',
					'wrapper' => true,
				),
				array(
					'title'   => 'H5',
					'classes' => 'h5',
					'wrapper' => true,
				),
				array(
					'title'   => 'H6',
					'classes' => 'h6',
					'wrapper' => true,
				),
			),
		),
		array(
			'title' => 'Text Size',
			'items' => array(
				array(
					'title'   => 'Extra Small',
					'block'   => 'span',
					'classes' => 'txt-xs',
					'wrapper' => true,
				),
				array(
					'title'   => 'Small',
					'block'   => 'span',
					'classes' => 'txt-sm',
					'wrapper' => true,
				),
				array(
					'title'   => 'Medium',
					'block'   => 'span',
					'classes' => 'txt-md',
					'wrapper' => true,
				),
				array(
					'title'   => 'Big',
					'block'   => 'span',
					'classes' => 'txt-bg',
					'wrapper' => true,
				),
				array(
					'title'   => 'Large',
					'block'   => 'span',
					'classes' => 'txt-lg',
					'wrapper' => true,
				),
				array(
					'title'   => 'Extra Large',
					'block'   => 'span',
					'classes' => 'txt-xl',
					'wrapper' => true,
				),
				array(
					'title'   => 'XXL',
					'block'   => 'span',
					'classes' => 'txt-xxl',
					'wrapper' => true,
				),
			),
		),
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
//	$init_array['style_formats_merge'] = true;
	$init_array['style_formats'] = json_encode($style_formats);

	return $init_array;

}

// Attach callback to 'tiny_mce_before_init'
add_filter('tiny_mce_before_init', 'pixo_mce_before_init_insert_formats');


add_action('init', 'pixo_wptuts_buttons');
function pixo_wptuts_buttons()
{
	add_filter('mce_external_plugins', 'pixo_add_buttons');
	add_filter('mce_buttons', 'pixo_register_buttons');
}

function pixo_add_buttons($plugin_array)
{
	$plugin_array['zorbix_'] = PIXO_URI . 'admin/wpeditor/editor-buttons.js';

	return $plugin_array;
}

function pixo_register_buttons($buttons)
{
	array_push($buttons, 'shortcodes', 'sub-title');
	return $buttons;
}

// Add stylesheet for editor
add_editor_style(PIXO_URI . 'admin/wpeditor/editor-style.css');