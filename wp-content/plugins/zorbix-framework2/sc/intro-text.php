<?php

add_shortcode( 'intro-text', 'zorbix_introtext' );
function zorbix_introtext( $atts, $content = null ) {
	ob_start();
	?>
	<div class="intro_text">
		<?php echo do_shortcode( $content ) ?>
	</div>

	<?php
	return ob_get_clean();
}
