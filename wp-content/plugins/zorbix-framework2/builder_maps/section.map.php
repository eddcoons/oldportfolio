<?php

$zorbix_params = array(

	array(
		'type'        => 'dropdown',
		'holder'      => 'div',
		'heading'     => esc_html__('Row, Section or scroller', 'pixo'),
		'param_name'  => 'type',
		'default' => 'row',
		'description' => esc_html__('', 'pixo'),
		'value'       => array(
			esc_html__('Row', 'pixo')                => 'row',
			esc_html__('None ( Plain div )', 'pixo') => '',
			esc_html__('Section', 'pixo')            => 'sect',
			esc_html__('Page Scroller', 'pixo')      => 'page-scroller',
			esc_html__('Section small', 'pixo')            => 'sect small',
			esc_html__('Section large', 'pixo')            => 'sect large',
			esc_html__('Section 100px', 'pixo')            => 'sect pd-tb-100',
		)
	),

	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__('Cell', 'pixo'),
		'param_name' => 'cell',
		'description' => 'Set above to row',
		'value'      => array(
			'Disabled'                                => '',
			'Enable'                                  => 'cell',
			'For items with 20px margin-top & bottom' => 'cell-20',
		),
	),

	array(
		'type'        => 'checkbox',
		'holder'      => 'div',
		'heading'     => esc_html__('Dark Scheme', 'pixo'),
		'param_name'  => 'dark_scheme',
		'description' => esc_html__('Make text and element fit a dark background', 'pixo'),
		'value'       => '', // Default
	),
	array(
		'type'        => 'colorpicker',
		'holder'      => 'div',
		'heading'     => esc_html__('Background Color', 'pixo'),
		'param_name'  => 'bg_color',
		'description' => 'Choose a colored background',
		'group'       => esc_html__('Background', 'pixo'),
	),

	array(
		'type'       => 'media',
		'holder'     => 'div',
		'heading'    => esc_html__('Background Image', 'pixo'),
		'param_name' => 'bg_id',
		'group'      => esc_html__('Background', 'pixo'),
	),

	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__('Tint Background Image', 'pixo'),
		'value'      => array(
			esc_html__('None', 'pixo')            => '',
			esc_html__('Light Gray Wash', 'pixo') => 'light-gray-wash',
			esc_html__('Theme Color', 'pixo')     => 'tint-theme-color',
			esc_html__('White Wash', 'pixo')      => 'white-wash',
			esc_html__('Light Tint', 'pixo')      => 'tint',
			esc_html__('Medium Tint', 'pixo')     => 'tint-medium',
			esc_html__('Dark Tint', 'pixo')       => 'tint-dark',
			esc_html__('Blue Black Tint', 'pixo') => 'tint-blue-black',
			esc_html__('Black Tint', 'pixo')      => 'tint-black',
		),
		'param_name' => 'tint',
		'group'      => esc_html__('Background', 'pixo'),
	),

	array(
		'type'       => 'dropdown',
		'heading'    => esc_html__('Background Size', 'pixo'),
		'value'      => array(
			esc_html__('Cover', 'pixo')     => 'bg-size-cover',
			esc_html__('Auto', 'pixo')      => 'bg-size-auto',
			esc_html__('Contain', 'pixo')   => 'bg-size-contain',
			esc_html__('No Repeat', 'pixo') => 'bg-no-repeat',
			esc_html__('Repeat', 'pixo')    => 'bg-repeat',
		),
		'param_name' => 'bg_size',
		'group'      => esc_html__('Background', 'pixo'),
	),

	array(
		'type'       => 'checkbox',
		'heading'    => esc_html__('Center Text', 'pixo'),
		'param_name' => 'center_text',
		'value'      => array('' => 'true'),
	),

	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Center Contents', 'pixo'),
		'param_name'  => 'center_contents',
		'description' => esc_html__('Only for when the section is set to full height or is using the scroller', 'pixo'),
		'value'       => array('' => 'true'),
	),
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Add Container', 'pixo'),
		// `-` breaks param_name
		'param_name'  => 'container',
		'description' => esc_html__('Add a container to the Section ( boxed )', 'pixo'),
		'value'       => array('' => 'true'),
		// value is default
	),

	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Make fullscreen', 'pixo'),
		// `-` breaks param_name
		'param_name'  => 'full_height',
		'description' => esc_html__('Make section full screen', 'pixo'),
		'value'       => array('' => 'true'),
		// value is default
	),

	// ID
	array(
		'type'        => 'textfield',
		'holder'      => 'div',
		'heading'     => esc_html__('ID', 'pixo'),
		'param_name'  => 'id', // No dashes!
		'description' => esc_html__("Tag ID - don't include hash. Disabled when YouTube background enabled", 'pixo'),
		'value'       => '', // Default
	),

	// Columns - info
	array(
		'type'        => 'info',
		'heading'     => esc_html__('Info', 'pixo'),
		'param_name'  => 'info',
		'group'       => esc_html__('Columns', 'pixo'),
		'description' => esc_html__('These settings effect any columns inside this section.','pixo')
	),

	// Columns - Remove column padding
	array(
		'type'        => 'checkbox',
		'holder'      => 'div',
		'group'       => esc_html__('Columns', 'pixo'),
		'heading'     => esc_html__('Remove column padding', 'pixo'),
		'param_name'  => 'cols_no_padding', // No dashes!
		'description' => esc_html__('Any containing column will not have padding', 'pixo'),
		'value'       => array('' => 'true')
	),

	array(
		'type'        => 'dropdown',
		'group'       => esc_html__('Columns', 'pixo'),
		'heading'     => esc_html__('Column padding top', 'pixo'),
		'param_name'  => 'col_pt',
		'description' => esc_html__('Add a margin top to all contained columns', 'pixo'),
		'value'       => array(
			'None' => '',
			'10'   => 'col-pt-10',
			'20'   => 'col-pt-20',
			'30'   => 'col-pt-30',
			'40'   => 'col-pt-40',
			'50'   => 'col-pt-50',
		),
	),

	array(
		'type'        => 'dropdown',
		'heading'     => esc_html__('Column padding bottom', 'pixo'),
		'group'       => esc_html__('Columns', 'pixo'),
		'param_name'  => 'col_pb',
		'description' => esc_html__('Add a padding bottom to all contained columns', 'pixo'),
		'value'       => array(
			'None' => '',
			'10'   => 'col-pb-10',
			'20'   => 'col-pb-20',
			'30'   => 'col-pb-30',
			'40'   => 'col-pb-40',
			'50'   => 'col-pb-50',
		),
	),

	array(
		'type'        => 'checkbox',
		'group'       => esc_html__('Columns', 'pixo'),
		'heading'     => esc_html__('Equal Columns', 'pixo'),
		'param_name'  => 'cols_equal', // No dashes!
		'description' => esc_html__('Make inner columns the same height', 'pixo'),
		'value'       => 'false', // Default
	),

	// Inline Columns
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('Inline Columns', 'pixo'),
		'group'       => esc_html__('Columns', 'pixo'),
		'param_name'  => 'cols_inline',
		'description' => esc_html__('Good stacks of columns of different heights which are not separated by anything. Eg 6 1/3 columns ', 'pixo'),
	),

	// Columns - Auto Bottom
	array(
		'type'        => 'checkbox',
		'group'       => esc_html__('Columns', 'pixo'),
		'heading'     => esc_html__('Auto responsive margin bottom', 'pixo'),
		'param_name'  => 'auto_bottom', // No dashes!
		'description' => esc_html__('Attempts to automate the margin bottom on internal columns. Particularly suitable for rows of columns such as 3rds in 2 - 3 rows.', 'pixo'),
		'value'       => '', // Default
	),

	// No max width
	array(
		'type'        => 'checkbox',
		'heading'     => esc_html__('No max width', 'pixo'),
		'param_name'  => 'no_max_width', // No dashes!
		'description' => esc_html__('Remove the 1900 max section content width', 'pixo'),
		'value'       => '', // Default
	),
	// Video Type
	array(
		'type'                    => 'dropdown',
		'group'                   => esc_html__('Video', 'pixo'),
		'show_settings_on_create' => true,
		'heading'                 => esc_html__('Video Type', 'pixo'),
		'description'             => 'A background video for the section',
		'param_name'              => 'video_type',
		'value'                   => array(
			''                               => 'Select',
			esc_html__('YouTube', 'pixo') => 'youtube',
			esc_html__('Upload', 'pixo')  => 'upload',
		),
	),
	// YouTube Link
	array(
		'type'        => 'textfield',
		'group'       => esc_html__('Video', 'pixo'),
		'heading'     => esc_html__('YouTube Link', 'pixo'),
		'param_name'  => 'youtube_link',
		'description' => 'This is the the youtube url - not embed code',
		'dependency'  => array('element' => 'video_type', 'value' => array('youtube')),
	),
	array(
		'type'        => 'info',
		'group'       => esc_html__('Video', 'pixo'),
		'param_name'  => 'youtube_note',
		'heading'     => esc_html__('Important Info', 'pixo'),
		'description' => esc_html__(
			'Add a image in the background tab for a mobile fallback. YouTube backgrounds do not function correctly on mobile due to device restrictions on autoplay. 3 seconds at the end of the video removed due to the play button appearing. For more information see the docs',
			'pixo'
		),
		'dependency'  => array('element' => 'video_type', 'value' => array('youtube')),
	),
	// MP4
	array(
		'type'        => 'media',
		'group'       => esc_html__('Video', 'pixo'),
		'heading'     => esc_html__('MP4', 'pixo'),
		'param_name'  => 'mp4_url',
		'description' => 'Upload your video to the media library and copy and paste here',
		'dependency'  => array('element' => 'video_type', 'value' => array('upload')),
	),
	// Webm
	array(
		'type'        => 'media',
		'group'       => esc_html__('Video', 'pixo'),
		'heading'     => esc_html__('Webm', 'pixo'),
		'param_name'  => 'webm_url',
		'description' => 'Upload your video to the media library and copy and paste here',
		'dependency'  => array('element' => 'video_type', 'value' => array('upload')),
	),
	array(
		'type'        => 'zorbix_note',
		'group'       => esc_html__('Video', 'pixo'),
		'param_name'  => 'upload_note',
		'heading'     => esc_html__('Important Info', 'pixo'),
		'description' =>
			__('Background video do not function correctly on mobile due to device restrictions on autoplay. Add a fallback image in the design tab. For more information see the docs',
				'pixo'),
		'dependency'  => array('element' => 'video_type', 'value' => array('upload')),
	),
);


$zorbix_map_name = zorbix_builder::add_map(array(
	'name'     => esc_html__('Section', 'pixo'),
	'base'     => 'section',
	'category' => esc_html__('Zorbix', 'pixo'),
	'icon'     => 'fa fa-square-o',
	'params'   => $zorbix_params,
));

zorbix_builder::add_to_map($zorbix_map_name, zorbix_maps::margin());
zorbix_builder::add_to_map($zorbix_map_name, zorbix_maps::padding());

