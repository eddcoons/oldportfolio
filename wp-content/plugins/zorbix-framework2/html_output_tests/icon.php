<?php ob_start(); ?>
	// link: link="url:http%3A%2F%2Fgoogle.co.uk|title:dfaSDfa|target:%20_blank"]


	// With link
	[pixo-icon size="Small" link="http://google.co.uk" icon_type="Font Awesome" icon_fontawesome="fa fa-youtube-play"][/pixo-icon]

	// Without link
	[pixo-icon size="Small" icon_type="Font Awesome" icon_fontawesome="fa fa-youtube-play"][/pixo-icon]

	// Blank link
	[pixo-icon size="Small" link="" icon_type="Font Awesome" icon_fontawesome="fa fa-youtube-play"][/pixo-icon]

	// internal link
	[pixo-icon size="Small" link="" icon_type="Font Awesome" icon_fontawesome="fa fa-youtube-play"][/pixo-icon]

	// target _blank
	[pixo-icon size="Small" link="url:http://google.co.uk||target:_blank" icon_type="Font Awesome" icon_fontawesome="fa fa-youtube-play"][/pixo-icon]

	//Size
	[pixo-icon size="small" icon_type="Font Awesome" icon_fontawesome="fa fa-youtube-play"][/pixo-icon]

<?php echo( do_shortcode( ob_get_clean() ) );