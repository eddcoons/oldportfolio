<?php


include PIXO_ADMIN_DIR . 'options/footer.options.php';
include PIXO_ADMIN_DIR . 'options/blog.options.php';
include PIXO_ADMIN_DIR . 'options/404.options.php';
include PIXO_ADMIN_DIR . 'options/general.options.php';
include PIXO_ADMIN_DIR . 'options/header.options.php';
include PIXO_ADMIN_DIR . 'options/portfolio.options.php';


$pixo_importer_notice = '<strong>' . esc_html__('IMPORTANT:', 'pixo') . '</strong>';
$pixo_importer_notice .= '<p>' . esc_html__('Homepage templates are provided by the page builder. These demo\'s are provided for those who would like them.', 'pixo') . '</p>';
$pixo_importer_notice .= '<strong>' . esc_html__('Images not included:', 'pixo') . '</strong>';
$pixo_importer_notice .= '<p>' . esc_html__('Images are placeholders due to licensing restrictions, simply replace with your own.', 'pixo') . '</p>';
$pixo_importer_notice .= '<strong>' . esc_html__('Might take a while:', 'pixo') . '</strong>';
$pixo_importer_notice .= '<p>' . esc_html__('On slower network this could be a while. If it fails this is usually because it\'s timed out. You can run it a few times to get it to complete if this is the case. ', 'pixo') . '</p>';
$pixo_importer_notice .= '<p>' . esc_html__('The importer uses the WordPress Importer plugin this can be used directly. The XMLs are inside the theme folder in the demo_content folder ', 'pixo') . '</p>';


zorbix_settings::add_section(
	array(
		'name' => 'demo-importer',
		'title'       => esc_html__('Demo Importer', 'pixo'),
		'priority'    => 151,
		'description' => $pixo_importer_notice,
	));

zorbix_settings::set_section('demo-importer');

function pixo_get_demos()
{
	$choices[''] = esc_html__('Select Content', 'pixo');
	foreach (glob(PIXO_DEMOS_DIR . '*.xml') as $path) {
		$demo_name_for_options = basename($path, '.xml'); // This isn't being used to include a file. Only used to get the name of the demo.
		$demo_name_for_options = str_replace('pixo', '', $demo_name_for_options);
		$path .= '~' . admin_url('admin-ajax.php');
		$choices[$path] = zorbix_settings::id_to_name($demo_name_for_options);
	}

	return $choices;
}

/*
 * Theme Importer
 */
zorbix_settings::add_field(
	array(
		'type'      => 'select',
		'setting'   => 'demo_select',
		'label'     => esc_html__('Select a demo', 'pixo'),
		'default'   => 'col-md-4',
		'choices'   => pixo_get_demos(),
		'transport' => 'postMessage',
		//			'active_callback' => 'zorbix_import_callback'
	)
);
