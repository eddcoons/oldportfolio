<?php

/*
 * Option Tree fields
 *
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || die;


function zorbix_remove_admin_menu_entry() {
	remove_action( 'admin_bar_menu', 'ot_register_theme_options_admin_bar_menu', 999 );
}

if ( class_exists( 'zorbix_mb' ) ) {
	zorbix_page_settings();
} else {
	trigger_error('zorbix_mb not loaded');
}

function zorbix_page_settings() {

	$override_message = '<p>' . sprintf(
			__( 'Global Setting in %s Appearance > Customize%s. Set here to override for just this page. ', 'zorbix' ),
			'<a href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
			'</a>'
		) . '</p>';

	zorbix_mb::create( array(
			'id'       => 'page_options',
			'title'    => esc_html__( 'Page Options', 'zorbix' ),
			'desc'     => '',
			'pages'    => array( 'page' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'type'  => 'textblock',
					'id'    => 'notebox',
					'label' => '',
					'desc'  => sprintf(
						__( 'You\'ll find global settings in %s Appearance > Customize%s', 'zorbix' ),
						'<a href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
						'</a>'
					),
				),
				array(
					'label' => esc_html__( 'Page', 'zorbix' ),
					'id'    => 'page_tab',
					'type'  => 'tab',
				),


				array(
					'type'        => 'on-off',
					'id'          => 'solid_header',
					'label'       => esc_html__( 'Solid / overlay menu', 'zorbix' ),
					'std'         => 'off',
					'description' => 'Should the menu be a overlay or a solid menu',
					'choices'     => array(
						array(
							'label' => esc_html__( 'Global Setting', 'zorbix' ),
							'value' => 'global',
						),
						array(
							'label' => esc_html__( 'Solid', 'zorbix' ),
							'value' => 'on',
						),
						array(
							'label' => esc_html__( 'Transparent', 'zorbix' ),
							'value' => 'off',
						),
					),
				),

				array(
					'type'    => 'radio',
					'id'      => 'footer_show',
					'label'   => esc_html__( 'Footer', 'zorbix' ),
					'std'     => 'global',
					'choices' => array(
						array(
							'label' => esc_html__( 'Global Setting', 'zorbix' ),
							'value' => 'global',
						),
						array(
							'label' => esc_html__( 'On', 'zorbix' ),
							'value' => 'on',
						),
						array(
							'label' => esc_html__( 'Off', 'zorbix' ),
							'value' => 'off',
						),
					),
				),

				array(
					'label' => esc_html__( 'Blog', 'zorbix' ),
					'id'    => 'blog_tab',
					'type'  => 'tab',
				),

				/* array(
					'type'    => 'radio',
					'id'      => 'blog_sidebar',
					'label'   => esc_html__('Sidebar', 'zorbix'),
					'desc'    => $override_message . esc_html__('Not for use with masonry', 'zorbix'),
					'choices' => array(
						array(
							'label' => esc_html__('Global Setting', 'zorbix'),
							'value' => '',
						),
						array(
							'label' => esc_html__('None', 'zorbix'),
							'value' => 'none',
						),
						array(
							'label' => esc_html__('Left', 'zorbix'),
							'value' => 'left',
						),
						array(
							'label' => esc_html__('Right', 'zorbix'),
							'value' => 'right',
						),
					),
				),*/

				array(
					'type'    => 'radio',
					'id'      => 'blog-layout',
					'label'   => esc_html__( 'Blog Layout', 'zorbix' ),
					'desc'    => $override_message . esc_html__( 'Not for use with masonry', 'zorbix' ),
					'choices' => array(
						array(
							'label' => esc_html__( 'Global Setting', 'zorbix' ),
							'value' => '',
						),
						array(
							'label' => esc_html__( 'Classic', 'zorbix' ),
							'value' => 'classic',
						),
						array(
							'label' => esc_html__( 'Masonry', 'zorbix' ),
							'value' => 'masonry',
						),
						array(
							'label' => esc_html__( 'Medium', 'zorbix' ),
							'value' => 'medium',
						),
					),

				),

			)
		)
	);

	zorbix_mb::create( array(
			'id'       => 'video_post',
			'title'    => esc_html__( 'Video Post', 'zorbix' ),
			'desc'     => '',
			'pages'    => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array( // Mode
					'type'    => 'radio',
					'id'      => 'video_mode',
					'label'   => esc_html__( 'Video Type', 'zorbix' ),
					'std'     => 'embed',
					'choices' => array(
						array(
							'label' => 'Embed',
							'value' => 'embed',
						),
						array(
							'label' => 'Upload',
							'value' => 'upload',
						),
						array(
							'label' => 'Custom',
							'value' => 'custom',
						),
					),
				),
				array(
					'label' => esc_html__( 'Embed', 'zorbix' ),
					'id'    => 'embed_tab',
					'type'  => 'tab',
				),
				array( // Embed
					'type'  => 'text',
					'id'    => 'video_embed',
					'label' => esc_html__( 'Video embed', 'zorbix' ),
					'desc'  => sprintf(
						esc_html__(
							'Your embed Url here. This uses the WordPress embed shortcode, see here for list of embed types. %s Wordpress Codex: Embeds %s',
							'zorbix'
						),
						'<a href="https://codex.wordpress.org/Embeds">',
						'</a>'
					),
				),
				array(
					'label' => esc_html__( 'Upload', 'zorbix' ),
					'id'    => 'video_upload',
					'type'  => 'tab',
				),
				array(
					'type'  => 'upload',
					'id'    => 'video_upload',
					'label' => esc_html__( 'Main File', 'zorbix' ),
					'desc'  => esc_html__( 'mp4 recommended', 'zorbix' ),
				),
				array(
					'type'  => 'upload',
					'id'    => 'video_webm',
					'label' => esc_html__( 'WebM', 'zorbix' ),
					'desc'  => esc_html__( 'Fallback for Firefox and Opera', 'zorbix' ),
				),
				array(
					'type'  => 'upload',
					'id'    => 'video_poster',
					'label' => esc_html__( 'Poster Image', 'zorbix' ),
					'desc'  => esc_html__( 'png or jpg image', 'zorbix' ),
				),
				array(
					'label' => esc_html__( 'Custom Shortcode', 'zorbix' ),
					'id'    => 'video_shortcode',
					'type'  => 'tab',
				),
				array(
					'type'  => 'text',
					'id'    => 'video_custom',
					'label' => esc_html__( 'Custom Shortcode', 'zorbix' ),
					'desc'  => esc_html__( 'You custom shortcode', 'zorbix' ),
				),
			),
		)
	);

	zorbix_mb::create( array(
			'id'       => 'audio_post',
			'title'    => esc_html__( 'Audio Post', 'zorbix' ),
			'desc'     => '',
			'pages'    => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array( // Mode
					'type'    => 'radio',
					'id'      => 'audio_mode',
					'label'   => esc_html__( 'Audio Type', 'zorbix' ),
					'std'     => 'embed',
					'choices' => array(
						array(
							'label' => 'Embed',
							'value' => 'embed',
						),
						array(
							'label' => 'Upload',
							'value' => 'upload',
						),
						array(
							'label' => 'Custom',
							'value' => 'custom',
						),
					),
				),
				array(
					'label' => esc_html__( 'Embed', 'zorbix' ),
					'id'    => 'audio_embed_tab',
					'type'  => 'tab',
				),
				array( // Embed
					'type'  => 'text',
					'id'    => 'audio_embed',
					'label' => esc_html__( 'Audio Embed', 'zorbix' ),
					'desc'  => sprintf(
						esc_html__(
							'Your embed Url here. This uses the wordpress embed shortcode, see here for list of embed types. %s Wordpress Codex: Embeds %s',
							'zorbix'
						),
						'<a href="https://codex.wordpress.org/Embeds">',
						'</a>'
					),
				),
				array(
					'label' => esc_html__( 'Upload', 'zorbix' ),
					'id'    => 'audio_upload',
					'type'  => 'tab',
				),
				array(
					'type'  => 'upload',
					'id'    => 'audio_upload',
					'label' => esc_html__( 'Audio File', 'zorbix' ),
				),
				array(
					'label' => esc_html__( 'Custom Shortcode', 'zorbix' ),
					'id'    => 'audio_shortcode',
					'type'  => 'tab',
				),
				array(
					'type'  => 'text',
					'id'    => 'audio_custom',
					'label' => esc_html__( 'Custom Shortcode', 'zorbix' ),
					'desc'  => esc_html__( 'You custom shortcode', 'zorbix' ),
				),
			),
		)
	);
}

if ( class_exists( 'zorbix_mb' ) ) {
	add_action( 'admin_init', 'zorbix_gallery_post_meta_boxes' );
}
function zorbix_gallery_post_meta_boxes() {

	zorbix_mb::create( array(
			'id'       => 'gallery_post',
			'title'    => esc_html__( 'Gallery Post', 'zorbix' ),
			'pages'    => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'label' => esc_html__( 'Gallery', 'zorbix' ),
					'id'    => 'gallery_note',
					'type'  => 'textblock',
					'desc'  => esc_html__(
						'Use the `Add Media` button to create a gallery. The first gallery to be added will be used for the gallery slider.',
						'zorbix'
					),
				),
			),
		)
	);

	zorbix_mb::create( array(
			'id'       => 'quote_post',
			'title'    => esc_html__( 'Quote Post', 'zorbix' ),
			'pages'    => array( 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array( // Author
					'type'  => 'text',
					'id'    => 'author',
					'label' => esc_html__( 'Author', 'zorbix' ),
				),
				array( // Quote
					'type'  => 'textarea',
					'id'    => 'quote',
					'label' => esc_html__( 'Quote', 'zorbix' ),
				), // link
				array(
					'type'  => 'text',
					'id'    => 'quote_link',
					'label' => esc_html__( 'Link', 'zorbix' ),
				),
			),
		)
	);

	zorbix_mb::create( array(
		'id'       => 'link_post',
		'title'    => esc_html__( 'Link Post', 'zorbix' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array( // Link
				'type'        => 'text',
				'id'          => 'link',
				'label'       => esc_html__( 'Link', 'zorbix' ),
				'validation'  => 'url',
				'description' => esc_html__( 'Please start with http://', 'zorbix' ),
			),
			array( // Title
				'type'        => 'text',
				'id'          => 'title',
				'label'       => esc_html__( 'Title', 'zorbix' ),
				'description' => esc_html__( 'Optional', 'zorbix' ),
			),
			array( // Subtitle
				'type'        => 'text',
				'id'          => 'subtitle',
				'label'       => esc_html__( 'Subtitle', 'zorbix' ),
				'description' => esc_html__( 'Optional', 'zorbix' ),
			),
		)
	) );
}