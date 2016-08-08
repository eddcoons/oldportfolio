<?php
{
	zorbix_settings::add_panel(
		array(
			'name'     => 'blog',
			'title'    => esc_html__( 'Blog', 'pixo' ),
			'priority' => 152,
		) );

	zorbix_settings::add_section(
		array(
			'name'  => 'blog_meta',
			'title' => esc_html__( 'Meta', 'pixo' ),
			'panel' => 'blog',
		) );

	zorbix_settings::add_section(
		array(
			'name'        => 'blog-general',
			'title'       => esc_html__( 'Blog General', 'pixo' ),
			'panel'       => 'blog',
			'description' => esc_html__( 'IMPORTANT: These settings can be over ridden on page template. If these settings aren\'t working check the page settings', 'pixo' )
		) );

	zorbix_settings::add_section(
		array(
			'name'        => 'blog-heading',
			'title'       => esc_html__( 'Blog Heading', 'pixo' ),
			'panel'       => 'blog',
			'description' => esc_html__( 'Heading text for blog pages', 'pixo' )
		) );


	zorbix_settings::add_section(
		array(
			'name'  => 'blog_heading_translations',
			'title' => esc_html__( 'Heading Translations', 'pixo' ),
			'panel' => 'blog',
		) );

	zorbix_settings::add_section(
		array(
			'name'  => 'blog_comment_translations',
			'title' => esc_html__( 'Comment Translations', 'pixo' ),
			'panel' => 'blog',
		) );

	zorbix_settings::add_field(
		array(
			'type'     => 'color',
			'setting'  => 'blog-heading-text-color',
			'label'    => esc_html__( 'Heading Text Color', 'pixo' ),
			'section'  => 'blog-heading',
			'default'  => '#fff',
			'priority' => 1,
			'output'   => array(
				array(
					'element'  => '.blog-heading h1',
					'property' => 'color',
				)
			),
		) );


	zorbix_settings::add_field( array(
		'type'     => 'select',
		'setting'  => 'blog_heading_tint',
		'label'    => esc_html__( 'Blog Heading Tint', 'pixo' ),
		'section'  => 'blog-heading',
		'priority' => 10,
		'choices'  => array(
			''            => 'None',
			'tint-light'  => 'Light',
			'tint-medium' => 'Medium',
			'tint-dark'   => 'Dark',
		),
	) );

	zorbix_settings::add_field( array(
		'type'        => 'background',
		'setting'     => 'blog-heading-background',
		'label'       => esc_html__( 'Blog header Background', 'pixo' ),
		'description' => esc_html__( 'Choose a background color or image for the blog header', 'pixo' ),
		'section'     => 'blog-heading',
		'default'     => array(
			'color'    => '#272727',
			'image'    => '',
			'repeat'   => 'repeat',
			'size'     => '',
			'attach'   => '',
			'position' => 'center center',
		),
		'priority'    => 1,
		'output'      => '.blog-heading',
		'units'       => '',
	) );

	zorbix_settings::add_field( array(
		'type'     => 'radio',
		'setting'  => 'blog-layout',
		'label'    => esc_html__( 'Blog Layout', 'pixo' ),
		'section'  => 'blog-general',
		'priority' => 10,
		'default'  => 'classic',
		'choices'  => array(
			'classic' => esc_html__( 'Classic', 'pixo' ),
			'medium'  => esc_html__( 'Medium', 'pixo' ),
			'masonry' => esc_html__( 'Masonry', 'pixo' ),
		),
	) );

	zorbix_settings::add_field( array(
		'type'        => 'radio-image',
		'setting'     => 'blog_sidebar',
		'label'       => esc_html__( 'Side bar', 'pixo' ),
		'section'     => 'blog-general',
		'default'     => 'right',
		'priority'    => 10,
		'description' => esc_html__( 'Not for masonry', 'pixo' ),
		'choices'     => array(
			''      => esc_url( ZORBIX_IMG . 'layout-btns/none.jpg' ),
			'left'  => esc_url( ZORBIX_IMG . 'layout-btns/sidebar_left.jpg' ),
			'right' => esc_url( ZORBIX_IMG . 'layout-btns/sidebar_right.jpg' ),
		),
	) );

	zorbix_settings::add_field( array(
		'type'        => 'textfield',
		'setting'     => 'blog-images-width',
		'label'       => esc_html__( 'Image Width', 'pixo' ),
		'description' => esc_html__( 'Add image size here. Set to 100% if you would like full width images. Set to auto for images to retain there orginal size.', 'pixo' ),
		'section'     => 'blog-general',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => '.blog-media img, .blog-img img',
				'property' => 'width',
			),
		),
	) );

	zorbix_settings::add_field( array(
		'type'     => 'textfield',
		'setting'  => 'blog-images-height',
		'label'    => esc_html__( 'Blog Image Height', 'pixo' ),
		'section'  => 'blog-general',
		'priority' => 10,
		'output'   => array(
			array(
				'element'  => '.blog-media img, .blog-img img',
				'property' => 'height',
			),
		),
	) );

	zorbix_settings::add_field( array(
		'type'     => 'textfield',
		'setting'  => 'blog-images-max-height',
		'label'    => esc_html__( 'Blog Image Max Height', 'pixo' ),
		'section'  => 'blog-general',
		'default' => '500px',
		'description' => 'Set to `none` for no max height.',
		'priority' => 10,
		'output'   => array(
			array(
				'element'  => '.blog-media img, .blog-img img',
				'property' => 'max-height',
			),
		),
	) );

	zorbix_settings::add_field( array(
		'type'        => 'textfield',
		'setting'     => 'blog-images-max-width',
		'label'       => esc_html__( 'Blog Image Max Width', 'pixo' ),
		'section'     => 'blog-general',
		'description' => 'Set to `none` for no max width.',
		'priority'    => 10,
		'output'      => array(
			array(
				'element'  => '.blog-media img, .blog-img img',
				'property' => 'max-width',
			),
		),
	) );

	zorbix_settings::add_field( array(
		'type'    => 'switch',
		'setting' => 'meta_date',
		'label'   => esc_html__( 'Show meta date', 'pixo' ),
		'section' => 'blog-meta',
		'default' => '1',
	) );

	zorbix_settings::add_field( array(
		'type'    => 'switch',
		'setting' => 'meta_author',
		'label'   => esc_html__( 'Show meta author', 'pixo' ),
		'section' => 'blog-meta',
		'default' => '1',
	) );

	zorbix_settings::add_field( array(
		'type'    => 'switch',
		'setting' => 'meta_categories',
		'label'   => esc_html__( 'Show meta categories', 'pixo' ),
		'section' => 'blog-meta',
		'default' => '1',
	) );

	zorbix_settings::add_field( array(
		'type'    => 'switch',
		'setting' => 'meta_comments',
		'label'   => esc_html__( 'Show meta comments', 'pixo' ),
		'section' => 'blog-meta',
		'default' => '1',
	) );

	zorbix_settings::add_field( array(
		'type'    => 'switch',
		'setting' => 'meta_tags',
		'label'   => esc_html__( 'Show meta comments', 'pixo' ),
		'section' => 'blog-meta',
		'default' => '1',
	) );

	/*
	 * Translations
	 */
	zorbix_settings::set_section( 'blog_heading_translations' );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Title', 'pixo' ),
		'setting' => 'blog_title',
		'default' => zorbix_helper::get_default( 'blog_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Daily Archives Title', 'pixo' ),
		'setting' => 'blog_daily_archives_title',
		'default' => zorbix_helper::get_default( 'blog_daily_archives_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Monthly Archives Title', 'pixo' ),
		'setting' => 'blog_monthly_archives_title',
		'default' => zorbix_helper::get_default( 'blog_monthly_archives_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Yearly Archives Title', 'pixo' ),
		'setting' => 'blog_yearly_archives_title',
		'default' => zorbix_helper::get_default( 'blog_yearly_archives_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Author Archives Title', 'pixo' ),
		'setting' => 'blog_author_archives_title',
		'default' => zorbix_helper::get_default( 'blog_author_archives_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Category Title', 'pixo' ),
		'setting' => 'blog_category_title',
		'default' => zorbix_helper::get_default( 'blog_category_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Tag Title', 'pixo' ),
		'setting' => 'blog_tag_title',
		'default' => zorbix_helper::get_default( 'blog_tag_title' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Blog Search Title', 'pixo' ),
		'setting' => 'blog_search_title',
		'default' => zorbix_helper::get_default( 'blog_search_title' ),
	) );

	/*
	 * Translate comments
	 */
	zorbix_settings::set_section( 'blog_comment_translations', 'comment_' );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Title Single', 'pixo' ),
		'setting' => 'title_single',
		'default' => esc_html__( 'One Comment on', 'pixo' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Title Plural', 'pixo' ),
		'setting' => 'title_plural',
		'default' => esc_html__( 'Comments on', 'pixo' ),
	) );

	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Name', 'pixo' ),
		'setting' => 'name',
	) );
	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Email', 'pixo' ),
		'setting' => 'email',
	) );
	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Url', 'pixo' ),
		'setting' => 'url',
	) );
	zorbix_settings::add_translate_field( array(
		'label'   => esc_html__( 'Message', 'pixo' ),
		'setting' => 'message',
	) );
}