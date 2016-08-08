<?php


# Map
zorbix_builder::add_map(array(
		'name'            => esc_html__('Team', 'pixo'),
		'base'            => 'team',
		'category'        => esc_html__('Zorbix', 'pixo'),
		'icon'            => 'fa fa-users',
		"as_parent"       => array('except' => ''),
		'content_element' => true,
		'params'          => array(
			array(
				'type'       => 'textfield',
				'holder'     => 'h1',
				'heading'    => esc_html__('Name', 'pixo'),
				'param_name' => 'name',
			),
			array(
				'type'       => 'textfield',
				'holder'     => 'h2',
				'heading'    => esc_html__('Job', 'pixo'),
				'param_name' => 'job',
			),
			array(
				'type'       => 'image',
				'holder'     => 'div',
				'heading'    => esc_html__('Image', 'pixo'),
				'param_name' => 'image', // No dashes!
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('facebook', 'pixo'),
				'group'      => 'social',
				'param_name' => 'facebook',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('twitter', 'pixo'),
				'group'      => 'social',
				'param_name' => 'twitter',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('behance', 'pixo'),
				'group'      => 'social',
				'param_name' => 'behance',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('delicious', 'pixo'),
				'group'      => 'social',
				'param_name' => 'delicious',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('deviantart', 'pixo'),
				'group'      => 'social',
				'param_name' => 'deviantart',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('digg', 'pixo'),
				'group'      => 'social',
				'param_name' => 'digg',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('dribbble', 'pixo'),
				'group'      => 'social',
				'param_name' => 'dribbble',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('dropbox', 'pixo'),
				'group'      => 'social',
				'param_name' => 'dropbox',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('envelope', 'pixo'),
				'group'      => 'social',
				'param_name' => 'envelope',
			), array(
				'type'       => 'textfield',
				'heading'    => esc_html__('flickr', 'pixo'),
				'group'      => 'social',
				'param_name' => 'flickr',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('foursquare', 'pixo'),
				'param_name' => 'foursquare',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('github', 'pixo'),
				'param_name' => 'github',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('google', 'pixo'),
				'param_name' => 'google',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('instagram', 'pixo'),
				'param_name' => 'instagram',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('linkedin', 'pixo'),
				'param_name' => 'linkedin',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('pinterest', 'pixo'),
				'param_name' => 'pinterest',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('reddit', 'pixo'),
				'param_name' => 'reddit',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('rss', 'pixo'),
				'param_name' => 'rss',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('skype', 'pixo'),
				'param_name' => 'skype',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('soundcloud', 'pixo'),
				'param_name' => 'soundcloud',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('stumbleupon', 'pixo'),
				'param_name' => 'stumbleupon',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('tumblr', 'pixo'),
				'param_name' => 'tumblr',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('vimeo', 'pixo'),
				'param_name' => 'vimeo',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('eddcoons_portfolio', 'pixo'),
				'param_name' => 'eddcoons_portfolio',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('xing', 'pixo'),
				'param_name' => 'xing',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('yahoo', 'pixo'),
				'param_name' => 'yahoo',
			), array(
				'type'       => 'textfield',
				'group'      => 'social',
				'heading'    => esc_html__('youtube', 'pixo'),
				'param_name' => 'youtube',
			)
		)
	)
);
