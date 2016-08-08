<?php
/*
* For template defaults you want assecible even when framework is not activated.
*/
zorbix_helper::set_defaults(array(
	'404_paragraph_text'          => esc_html__("Sorry, we searched high and low, but we just couldn't find that. This might be a misspelling or a removed page.", 'pixo'),
	'404-sub-heading'             => esc_html__('PAGE NOT FOUND', 'pixo'),
	'404_btn_text'                => esc_html__('HOMEPAGE', 'pixo'),
	'not-found-heading'           => esc_html__('404', 'pixo'),
	'blog_title'                  => esc_html(get_bloginfo()),
	'blog_search_title'           => esc_html__('Search: ', 'pixo'),
	'blog_tag_title'              => esc_html__('Tag: ', 'pixo'),
	'blog_category_title'         => esc_html__('Category Archives: ', 'pixo'),
	'blog_daily_archives_title'   => esc_html__('Daily Archives: ', 'pixo'),
	'blog_monthly_archives_title' => esc_html__('Monthly Archives: ', 'pixo'),
	'blog_yearly_archives_title'  => esc_html__('Yearly Archives: ', 'pixo'),
	'blog_author_archives_title'  => esc_html__('Author Archives: ', 'pixo'),
	'comment_name'                => esc_html__('name', 'pixo'),
	'comment_email'               => esc_html__('Email', 'pixo'),
	'comment_message'             => esc_html__('Comment Message', 'pixo'),
	'comment_url'                 => esc_html__('Comment Url', 'pixo'),
	'theme-color'                 => '#009EC6',
	'footer_copy'                 => esc_html__('&copy; 2015 PIXO', 'pixo'),
	'footer_show'                 => 'on',
	'portfolio_link'              => esc_url(admin_url() . 'portfolio'),
	'enable_backtotop'            => 'on',

));
