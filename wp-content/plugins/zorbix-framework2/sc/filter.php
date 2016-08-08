<?php

/**/
/* ONLY EFFECTS THEMES SHORTCODES LISTED IN THE FUNCTIONS ARRAY

/* Adds shortcodes to filter in the functions array
/* This doesn't strip non empty p tags, so use
/* something else for that
/**/

add_filter('the_content', 'zorbix_content_filter');
function zorbix_content_filter($content)
{

// array of custom shortcodes requiring the fix
	$block = join('|',
		array(
			'alert',
			'hexes',
			'feature',
			'bullets',
			'icon_bullet',
			'bullet',
			'point',
			'container',
			'column',
			'section',
			'vc_row',
			'team',
			'intro-text',
			'services',
			'section_title',
			'button',
			'feature-shapes',
			'masonry_blog',
			'section',
			'nested-column',
			'row',
			'contact',
			'scroller',
			'selector',
			'icon',
			'image',
			'page-heading',
			'heading',
			'sub-heading',
			'testimonials',
			'feature-list',
			'map',
			'part',
			'text',
			'clients',
			'latest_posts',
			'portfolio',
			'flipping-circle',
			'zorbix_video'
		));

// opening tag
	$rep = preg_replace("/(<p>|<\/p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", '[$2$3]', $content);

	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", '[/$2]', $rep);

	return $rep;

}
