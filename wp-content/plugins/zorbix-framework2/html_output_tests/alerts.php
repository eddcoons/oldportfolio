<?php ob_start();



);?>
	<!--[alert margin_bottom=20]This is some alert <p>stuff</p>[/alert]-->
	<!--	[alert padding_bottom=20]This is some alert <p>stuff</p>[/alert]-->
<?php echo(do_shortcode(ob_get_clean()));