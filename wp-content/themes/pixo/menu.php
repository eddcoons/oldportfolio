<?php if ( has_nav_menu( 'main' ) ): ?>

<a class="menu-btn"><i class="fa fa-bars"></i></a>

<?php $class = zorbix_helper::get_class_from_mb('sticky_triangle'); ?>

<div class="triangle-menu-wrap <?php echo esc_html(zorbix_helper::get_option('menu_overlay')) ?>">

	<div class="menu-triangle">

		<?php
		wp_nav_menu(array(
			'menu_class'     => 'main_menu',
			'container'      => '',
			//							  'container_class' => 'menu_wrapper',
			'theme_location' => 'main',
			'walker'         => new zorbix_menu_walker(),
		)); ?>

		<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0"
		     width="298.715" height="301.67" viewBox="0, 0, 298.715, 301.67">
			<g id="menu_triangle" transform="translate(34, 33)">
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


</div>
	<?php endif; ?>