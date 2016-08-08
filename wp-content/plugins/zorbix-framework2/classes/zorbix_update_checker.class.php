<?php


/**
 * Class zorbix_update_checker
 */
class zorbix_update_checker {

	private static $instance = null;

	private static $current_version;
	private static $version_url;

	static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new zorbix_update_checker();
		}
	}

	public static function check_updates( $version_url, $current_version ) {
		self::$current_version = $current_version;
		self::$version_url     = $version_url;
		self::notice();
	}

	public static function getRemote_version() {

		$request = wp_remote_post(
			self::$version_url,
			array(
				'body' => array(
					'action'     => 'version',
					'decompress' => true
				)
			) );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return $request['body'];
		}

		return false;
	}

	public static function compare_versions() {

		$output = '';

		$server_version = self::getRemote_version();

		if ( false === $server_version ) {
			return false;
		}

		if ( $server_version !== self::$current_version ) {
			return true;
		}

		return false;

	}

	private static function notice() {
		add_action( 'admin_notices', 'zorbix_update_notice' );

		function zorbix_update_notice() {
			global $current_user;
			$user_id = $current_user->ID;

			/* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta( $user_id, 'zorbix_update_notice_ignore' ) && true === zorbix_update_checker::compare_versions() ) {
				echo '<div class="updated"><p>';
				echo '<h1>New Theme Version available</h1>';
				echo '<p>Theme updates provide bug fixes, feature upgrades and security updates.</p>';
				echo ' Current Version: ' . esc_html( PIXO_VERSION );
				echo ' Available Version: ' . esc_html( zorbix_update_checker::getRemote_version() );
				echo '<a href="?zorbix_update_notice=0" > Hide Notice </a >';
				echo '</p></div>';
			}

		}

		add_action( 'admin_init', 'zorbix_init_update_notice' );

		function zorbix_init_update_notice() {
			global $current_user;
			$user_id = $current_user->ID;
			/* If user clicks to ignore the notice, add that to their user meta */
			if ( isset( $_GET['zorbix_update_notice'] ) && '0' === $_GET['zorbix_update_notice'] ) {
				add_user_meta( $user_id, 'zorbix_update_notice_ignore', 'true', false );
			}
		}


	}


}

add_action( 'wp_loaded', array( 'zorbix_update_checker', 'get_instance' ) );

