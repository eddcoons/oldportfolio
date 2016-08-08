<?php

add_action( 'after_setup_theme', 'zorbix_testimonial_meta_boxes' );
function zorbix_testimonial_meta_boxes() {

	zorbix_mb::create( array(
		'id'       => 'testimonials',
		'title'    => esc_html__( 'Options', 'zorbix' ),
		'desc'     => '',
		'pages'    => array( 'testimonial' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array( // Author
				'type'  => 'text',
				'id'    => 'author',
				'label' => esc_html__( 'Author', 'zorbix' ),
			),
			array(
				'type'  => 'textarea',
				'id'    => 'quote',
				'label' => esc_html__( 'Quote', 'zorbix' ),
			),
		),
	) );
}

add_shortcode( 'testimonials', 'zorbix_testimonials' );
function zorbix_testimonials( $atts ) {

	$default_atts = array(
			'center_text' => '',
			'margin_bottom' => '40',
	);
	$sets         = array( 'makewhite', 'animation', 'cpt' );
	$default_atts = zorbix_sc::get_attr_set( $default_atts, $sets );
	$atts         = zorbix_sc::shortcode_atts( $default_atts, $atts, 'team' );

	$cpt_posts = zorbix_sc::cpt( array(
		'post_type' => 'testimonial',
		'tax'       => 'testimonial_slider',
		'atts'      => $atts,
	) );

	$class = zorbix_sc::class_from_key( 'center_text', $atts );

	ob_start(); ?>

	<!-- TESTIMONIALS -->
	<div class="testimonials <?php echo esc_attr( $class ) ?>" <?php zorbix_sc::format_style_esc( 'margin-bottom', $atts['margin_bottom'] )  ?>>
		<ul class="testimonial bxslider">

			<?php if ( $cpt_posts->have_posts() ) : while ( $cpt_posts->have_posts() ) : $cpt_posts->the_post();

				$quote  = zorbix_mb::get( 'quote' );
				$author = zorbix_mb::get( 'author' );
				?>

				<li>
					<?php // Thumb or quote icon
					if ( get_the_post_thumbnail() ) {
						zorbix_img::thumb_tag( ZORBIX_PREFIX . '400_square' );
					} ?>
					<h1 class="quote"><?php echo esc_html( $quote ) ?></h1>

					<p class="author"><?php echo esc_html( $author ) ?></p>
				</li>
			<?php endwhile; endif; ?>

		</ul>
		<!-- End .testimonial -->
	</div><!-- End .container -->

	<?php return ob_get_clean();

}
