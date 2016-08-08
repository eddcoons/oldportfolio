<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02/07/15
 * Time: 08:04
 */
class zorbix_custom_menu {
	private function __construct() {
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'rc_scm_add_custom_nav_fields' ) );
		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'rc_scm_update_custom_nav_fields' ), 10, 3 );
	}

	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0
	 * @return      void
	 */
	private function rc_scm_add_custom_nav_fields( $menu_item ) {

		$menu_item->subtitle = get_post_meta( $menu_item->ID, '_menu_item_subtitle', true );

		return $menu_item;

	}

	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0
	 * @return      void
	 */
	private function rc_scm_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

		// Check if element is properly sent
		if ( is_array( $_REQUEST['menu-item-subtitle'] ) ) {
			$subtitle_value = $_REQUEST['menu-item-subtitle'][ $menu_item_db_id ];
			update_post_meta( $menu_item_db_id, '_menu_item_subtitle', $subtitle_value );
		}

	}


}
