<?php ob_start(); ?>

[team name="JOHN GREEN" job="Web Developer" facebook="http://facebook.com" twitter="http://twitter.com" image="2333"]

<?php echo( do_shortcode( ob_get_clean() ) );