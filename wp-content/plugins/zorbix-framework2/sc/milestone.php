<?php



add_shortcode( 'milestone', 'zorbix_milestone' );
function zorbix_milestone( $atts, $content = null ) {

	$default_atts = array(
		'count'   => '',
		'heading' => '',
	);

	$default_atts = zorbix_sc::get_attr_set( $default_atts, array( 'icon' ) );
	$atts         = zorbix_sc::shortcode_atts( $default_atts, $atts, 'milestone' );

	$atts = zorbix_mb::icon( $atts );

	ob_start(); ?>

	<div class="milestone">
		<i class="fa <?php echo esc_attr( $atts['icon'] ) ?>"></i>

		<div class="count" data-count="<?php echo esc_attr( $atts['count'] ) ?>">
			<?php echo esc_html( $atts['count'] ) ?>
		</div>
		<div class="title">
			<?php echo esc_html( $atts['heading'] ) ?>
		</div>
		<?php echo esc_html( $content ) ?>
	</div><!-- End .milestone -->

	<?php return ob_get_clean();

}

