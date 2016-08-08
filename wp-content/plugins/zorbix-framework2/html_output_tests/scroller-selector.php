<?php ob_start(); ?>
	[scroller]
	[selector]
	[part url="http://google.co.uk" image_id=2276][/part]
	[part url="http://google.co.uk" image_id=2268][/part]
	[part url="http://google.co.uk" image_id=2257][/part]
	[part url="http://google.co.uk" image_id=2277][/part]
	[/selector]
	[/scroller]
<?php echo( do_shortcode( ob_get_clean() ) );