<?php

# PORTFOLIO METABOXES

add_shortcode( 'part', 'zorbix_part' );
function zorbix_part( $atts, $contents ) {

	$class = '';

	$default_atts = array(
		'columns'     => '',
		'port_height' => '',
		'mansonry'    => '',
		'height'      => '',
		'width'       => '',
		'image_id'          => '',
		'link'        => '',
		'filter'      => '',
		'video'       => '',
		'jump_num'    => '',
		'bg_color' => '',
		'overlay_text' => '',
	);

	# Set Attributes
	$atts = zorbix_sc::shortcode_atts( $default_atts, $atts, 'gallery' );

	// add height class if given
	$class = zorbix::join(
		zorbix::if_true( ! empty( $atts['width'] ), ' w-' . zorbix::fraction_to_words( $atts['width'] ) ),
		zorbix::if_true( ! empty( $atts['height'] ), ' h-' . zorbix::fraction_to_words( $atts['height'] ) )
	);

	if ( ! empty( $atts['id'] ) ) {
		$class .= ' selector-image';
	}

	if ( ! empty( $atts['video'] ) ) {
		zorbix_sc::video_background( $video_type, $youtube_link, $video_type, $mp4_url, $webm_url );
	}

	$placeholder = ( 'placeholder' === $atts['image_id']) ? true : false;

	# Generate HTML
	ob_start(); ?>

	<div class="item <?php echo esc_attr( $class ) ?>" data-cat="gallery">

		<?php
		printf( '<div class="wrap scroll-jump" %s %s>',
			zorbix_sc::get_format_style_esc_multi( array(
					'background-color' => $atts['bg_color'],
					'background-image' => zorbix_img::get_src_from_id( $atts['image_id'], 'full', $placeholder ),
				) ),
			zorbix::sprintf_if_exists( 'data-scrolljump="%s"', esc_attr( $atts['jump_num'] ) )
		);

		echo '<div class="caption dark-scheme">' . do_shortcode( $contents ) . '</div>';

		zorbix::printf_if_exists( '<div class="overlay"><span>%s</span></div>',
				esc_attr( $atts['overlay_text'] )
			);

		if ( ! empty( $atts['link'] ) ) {
			if ( ! zorbix::str_contains( $atts['link'], 'http' ) ) {
//				$atts['link'] = get_site_url( '', $atts['link'] );
				if ( ! empty( $atts['filter'] ) ) {
					$atts['link'] = $atts['link'] . '?filter=' . $atts['filter'];
				}
			}

			printf( '<a href="%s"></a>',
				esc_attr( $atts['link'] )
			);

		}


		?>
	</div>

	</div>

	<?php return ob_get_clean();
}
