<?php ob_start(); ?>

	[zorbix_embed]https://www.youtube.com/watch?v=2YBtspm8j8M[/zorbix_embed]
	[embed]https://www.youtube.com/watch?v=2YBtspm8j8M[/embed]
	[embed width="123" height="456"]http://www.youtube.com/watch?v=dQw4w9WgXcQ[/embed]
	[zorbix_embed width="123px" height="456"]http://www.youtube.com/watch?v=dQw4w9WgXcQ[/zorbix_embed]



<?php echo(do_shortcode(ob_get_clean()));