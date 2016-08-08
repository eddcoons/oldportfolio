<?php ob_start(); ?>

	[scroller]
	No scroller
	[/scroller]

	[scroller container=true ]
	Container
	[/scroller]

	[scroller  center_contents=true]
	centerer
	[/scroller]

	[scroller bg_id="2333"]
	BG IMAGE
	[/scroller]

<?php echo( do_shortcode( ob_get_clean() ) );