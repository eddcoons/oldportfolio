<?php if ( is_active_sidebar( 'shop' ) ) :
	$pixo['last'] = zorbix_when_equals( zorbix_option_r( 'woocommerce_sidebar' ), 'right', 'last' );
	?>

	<aside class="sidebar one-fourth <?php echo esc_attr( $pixo['last'] ) ?>">

		<div class="widgets">

			<?php dynamic_sidebar( 'shop' ); ?>

		</div>	<!-- End .widgets -->

	</aside>
<?php endif;
