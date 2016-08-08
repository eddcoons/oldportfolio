<?php if ( is_active_sidebar( 'sidebar-widget-area' ) ) : ?>

	<aside class="sidebar col-md-3">

		<div class="widgets">

			<?php dynamic_sidebar( 'sidebar-widget-area' ); ?>

		</div>	<!-- End .widgets -->

	</aside>
<?php endif;
