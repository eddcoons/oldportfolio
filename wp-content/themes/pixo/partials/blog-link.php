<?php


	# Format Main Link
	$pixo_url      = zorbix_helper::get_post_meta( 'link' );
	$pixo_title    = zorbix_helper::get_post_meta( 'title' );
	$pixo_subtitle = zorbix_helper::get_post_meta( 'subtitle' );
$pixo_link = (function_exists('zorbix_get_anchor_esc')) ? zorbix_get_anchor_esc( $pixo_url, $pixo_title ) : '';

	# Post link
	if ( $pixo_url ) : ?>
		<div class="blog-link">

			<h4 class="blog-url">
				<a href="<?php echo esc_url( $pixo_url ) ?>">
					<?php // Display link title
					if ( $pixo_title ) {
						echo esc_html( $pixo_title );
					} else { // Or the url
						echo esc_html( $pixo_url );
					} ?>
				</a>
			</h4>

			<?php if ( $pixo_subtitle || $pixo_title ) : // If we have a subtitle or the title has been set ?>

				<div class="link-title">
					<?php
					if ( $pixo_subtitle ) { // Subtitle
						echo esc_html( $pixo_subtitle );
					} else { // Or the url (only shows if it wasn't used for the tite)
						echo esc_url( $pixo_url );
					} ?>
				</div>

			<?php endif; ?>

		</div>

	<?php endif;
