<?php ob_start(); ?>
	// link: link="url:http%3A%2F%2Fgoogle.co.uk|title:dfaSDfa|target:%20_blank"]

	// Id
	[clients id="2526"][/clients]

	// No atts
	[clients][/clients]

	// With links
	[clients link="http://google.co.uk||_blank||hello"][/clients]

<?php echo( do_shortcode( ob_get_clean() ) );