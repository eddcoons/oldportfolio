<?php

add_shortcode( 'hex', 'zorbix_hex' );
function zorbix_hex( $atts, $content = null ) {

	$default_atts = array(
		'link'    => '',
		'heading' => '',
		'text'    => '',
		'mb'      => '',
		'image'   => '',
	);

	$default_atts = zorbix_sc::get_attr_set( $default_atts, array( 'animation' ) );
	$atts         = shortcode_atts( $default_atts, $atts );

	$class = zorbix_sc::animation_class( $atts );

	# HTML
	$mb            = (int) $atts['mb'];
	$atts['style'] = ( $atts['mb'] ) ? "margin-bottom: {$mb}px" : '';

	ob_start();

	printf( '<div class="hexes-img %s" style="%s" %s>',
		esc_attr( $class ),
		esc_attr( $atts['style'] ),
		zorbix_anim_data_esc( $atts )
	);
	?>


		<svg width="235" height="240" viewBox="0, 0, 200, 200">
		<g class="feature_hex_svg">
			<path
				d="M186.603,150 L100,200 L13.397,150 L13.397,50 L100,0 L186.603,50 z"
				fill-opacity="0"
				fill="#fff"
				stroke="#ddd"
				stroke-width="1"></path>
			<image xmlns:xlink="http://www.w3.org/1999/xlink"
			       xlink:href="<?php echo esc_attr( zorbix_img::get_src_from_id( $atts['image'], '300_square', true ) ) ?>"
			       opacity="1" width="100%" height="100%"
			       preserveAspectRatio="xMidYMid"
			       clip-path="url(#hexes_mask)"></image>
		</g>
	</svg>


	<?php zorbix_sc::anchor_or_div( $atts['link'], 'hexes-overlay' ); ?>

	<span class="inner">
		<span class="more">+</span>
		<h4 class="title"><?php echo esc_html( $atts['heading'] ) ?></h4>
		<?php printf( '<p>%s</p>', esc_attr( $atts['text'] ) ) ?>
	</span>

	<?php zorbix_sc::anchor_or_div_close( $atts['link'] ); ?>

	</div>

	<?php return ob_get_clean();
}
