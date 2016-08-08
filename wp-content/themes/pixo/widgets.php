<?php

function zorbix_widgets_register() {
// Sidebar widget area, located in the sidebar. Empty by default.
	register_sidebar( array(
		'name'          => 'Sidebar Widget Area',
		'id'            => 'sidebar-widget-area',
		'description'   => 'The sidebar widget area',
		'before_widget' => '<div class="widget-container %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => 'Footer Widgets',
		'id'            => 'footer-widgets',
		'before_widget' => '<div class="footer-widget %2$s" id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}

add_action( 'widgets_init', 'zorbix_widgets_register' );

