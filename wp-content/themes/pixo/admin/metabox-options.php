<?php
/*
 * Theme specific metabox options.
 *
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || die;

if( method_exists( 'zorbix_mb', 'add_to_metabox' ) && is_admin() ) {

	zorbix_mb::add_to_metabox( 'page_options',
			array(

					array(
							'label' => esc_html__( 'Scroller', 'zorbix' ),
							'id'    => 'scroller_tab',
							'type'  => 'tab',
					),

					array(
							'type'    => 'radio',
							'id'      => 'scroller_direction',
							'label'   => esc_html__( 'Scroller Direction', 'zorbix' ),
							'desc'    => esc_html__( 'Should the full page scroller scroll horizontally or vertically', 'zorbix' ),
							'choices' => array(
									array(
											'label' => esc_html__( 'Horizonal Scroll', 'zorbix' ),
											'value' => 'horizontal',
									),
									array(
											'label' => esc_html__( 'Vertical Scroll', 'zorbix' ),
											'value' => 'vertical',
									),
							),
					)
			)
	);

}