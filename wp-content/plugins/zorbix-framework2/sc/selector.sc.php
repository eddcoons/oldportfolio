<?php

# PORTFOLIO METABOXES


add_shortcode( 'selector', 'zorbix_selector' );
function zorbix_selector( $atts, $content ) {

	$class = '';

	$default_atts = array(
		'layout' => '',
		'height' => '',
		'width'  => '',
		'logo'   => '',
	);

	# Set Attributes
	$atts = zorbix_sc::shortcode_atts( $default_atts, $atts, 'gallery' );


//	zbx::log(zbx::if_true( ! empty( $atts['width'] ), ' w-' . zbx::fraction_to_words( $atts['width'] ) ) );
//	zbx::log(zbx::if_true( ! empty( $atts['height'] ), ' h-' . zbx::fraction_to_words( $atts['height'] ) ) );
//	zbx::log( $atts['width'], 'width' );
//	zbx::log( $atts['height'], 'height' );

	$class = zorbix::join(
		zorbix::if_true( ! empty( $atts['width'] ), ' w-' . zorbix::fraction_to_words( $atts['width'] ) ),
		zorbix::if_true( ! empty( $atts['height'] ), ' h-' . zorbix::fraction_to_words( $atts['height'] ) ),
		$atts['layout']
	);

	# Generate HTML
	ob_start(); ?>

	<div class="selector <?php echo esc_attr( $class ) ?> ">

		<?php echo do_shortcode( $content ); ?>

	</div>

	<?php if ( ! empty( $atts['logo'] ) ) : ?>
		<div class="logo-triangle">
			<img src="<?php echo esc_url( zorbix_img::get_src_from_id($atts['logo']) ) ?>" class="logo"/>
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
			     width="298.715" height="301.67" viewBox="0, 0, 298.715, 301.67">
				<g id="logo_triangle" transform="translate(34, 33)">
					<g>
						<path d="M115.357,212.67 L22,117.835 L115.357,23 L208.715,117.835 L115.357,212.67 z"
						      fill="#FFFFFF"></path>
						<path
							d="M115.357,3.044 L125.334,13.179 L218.692,108.013 L228.36,117.835 L218.692,127.656 L125.334,222.491 L115.357,232.626 L105.381,222.491 L12.023,127.656 L2.355,117.835 L12.023,108.013 L105.381,13.179 L115.357,3.044 z M115.357,23 L22,117.835 L115.357,212.67 L208.715,117.835 L115.357,23 z"
							fill="#ffffff" fill-opacity="0.477"></path>
					</g>
				</g>
			</svg>
		</div>
	<?php endif; ?>


	<?php return ob_get_clean();
}
