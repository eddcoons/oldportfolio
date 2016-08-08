<?php if ( zorbix_option_r( 'woocommerce_top_widgets' ) && is_active_sidebar( 'shop-top' ) ) : ?>
	<div class="sidebar-top">
		<div class="container">
			<div class="widgets">

				<?php dynamic_sidebar( 'shop-top' ); ?>

			</div>	<!-- End .widgets -->
		</div>
	</div>
<?php endif; ?>
