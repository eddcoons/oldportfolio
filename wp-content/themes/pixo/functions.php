<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || die;

// ----------------------------------
// --  Constants  --
// ----------------------------------

define( 'PIXO_DEBUG', true );

// Current theme version
//$pixo_version = ( PIXO_DEBUG ) ? time() :esc_url( wp_get_theme()->version;
$pixo_version = wp_get_theme()->version;

define( 'PIXO_VERSION', $pixo_version );
define( 'PIXO_DIR', trailingslashit( get_template_directory() ) );
define( 'PIXO_URI', trailingslashit( get_template_directory_uri() ) );
define( 'PIXO_PLUGINS_DIR', get_template_directory() . '/plugins/' );
define( 'PIXO_DEMOS_DIR', get_template_directory() . '/demo_content/' );
define( 'PIXO_FRAMEWOK_DIR', get_template_directory() . '/framework/' );
define( 'PIXO_CLASSES_DIR', get_template_directory() . '/framework/classes/' );
define( 'PIXO_CSS_URI', get_template_directory_uri() . '/css/' );
define( 'PIXO_JS_URI', get_template_directory_uri() . '/js/' );
define( 'PIXO_ASSETS_URI', get_template_directory_uri() . '/assets/' );
define( 'PIXO_ADMIN_DIR', get_template_directory() . '/admin/' );
define( 'PIXO_ADMIN_URI', get_template_directory_uri() . '/admin/' );


// Wizard
include PIXO_ADMIN_DIR . 'envato_setup/envato_setup.php';


/* Set up the theme early. */
add_action( 'after_setup_theme', 'pixo_theme_setup', 5 );

function pixo_theme_setup() {

	// Define what theme supports
	include PIXO_DIR . 'pixo_theme_support.php';

	// Load text domain
	load_theme_textdomain( 'pixo', PIXO_DIR . '/languages/' );

	// maximum allowed width for any content in the theme
	if ( ! isset( $content_width ) ) {
		$content_width = 900;
	}

	// Framework helpers - these need to be in the theme to provide
	// functions when the framework plugin is not load
	include PIXO_ADMIN_DIR . 'zorbix_blog.class.php';
	include PIXO_ADMIN_DIR . 'zorbix_menu_walker.class.php';
	include PIXO_ADMIN_DIR . 'zorbix_helper.class.php';

	// Request plugins that assist theme using TGMPA
	include PIXO_ADMIN_DIR . 'request-plugins.php';

	// Add theme specific metaboxes
	include PIXO_ADMIN_DIR . 'metabox-options.php';

	// Backend stuff only
	if ( is_admin() ) {
		// Extending the WP Editor
		include PIXO_ADMIN_DIR . 'wpeditor/wpeditor.php';

		// Load builder maps if the zorbix builder is available
		if ( class_exists( 'zorbix_builder' ) && function_exists( 'zorbix_autoload_directory' ) ) {
			zorbix_autoload_directory( PIXO_DIR . 'maps/' );
		}
	}

	// Load the theme panel default values
	include PIXO_ADMIN_DIR . 'defaults.php';

	// Load customizer options
	if ( class_exists( 'zorbix_settings' ) ) {
		require_once PIXO_ADMIN_DIR . 'options.php';
	}

	// Register Menus
	add_theme_support( 'menus' );
	register_nav_menus( array( 'main' => 'Main Menu' ) );

	// Add Posts Formats
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'link', 'video', 'audio' ) );
	add_post_type_support( 'post', 'post-formats' );

	// Remove gallery default styling so we can load custom styling.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Loads widget areas
	require_once PIXO_DIR . 'widgets.php';

	// Remove font sizes on tag cloud
	add_filter( 'wp_generate_tag_cloud', 'pixo_tag_cloud_filter', 10, 3 );
	function pixo_tag_cloud_filter( $tag_string ) {
		return preg_replace( "/style='font-size:.+pt;'/", '', $tag_string );
	}

	// Register fonts
	add_action( 'wp_enqueue_scripts', 'pixo_fonts' );
	function pixo_fonts_url() {
		$font_url = '';
		// ie: Open Sans|Raleway|Pacifico
		$font_families = array(
			'Lato',
			'|Pacifico'
		);

		foreach ( $font_families as $family ) {
			$font_url .= $family . ':100,200,300,400,500,600,700,800,900,200italic,400italic,700italic,700&subset=latin,latin-ext';
		}

		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'pixo' ) ) {
			$font_url = add_query_arg( 'family',
				urlencode( $font_url ),
				'//fonts.googleapis.com/css' );
		}

		return $font_url;
	}

	// Enqueue fonts
	function pixo_fonts() {
		wp_enqueue_style( 'themeslug-fonts', pixo_fonts_url(), array(), '1.0.0' );
	}


// --------------------------------------------
// --  Add Thumbnails to posts --
// --------------------------------------------

	// Get featured images
	function pixo_get_featured_image( $post_ID ) {
		$post_thumbnail_id = get_post_thumbnail_id( $post_ID );
		if ( $post_thumbnail_id ) {
			$post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );

			return $post_thumbnail_img[0];
		}
	}

	// ADD NEW COLUMN
	function pixo_add_post_thumbnail( $defaults ) {
		$defaults['zorbix_thumbnail'] = 'Featured Image';

		return $defaults;
	}

	// SHOW THE FEATURED IMAGE
	function pixo_post_column_content( $column_name, $post_ID ) {
		if ( $column_name === 'zorbix_thumbnail' ) {
			$post_featured_image = pixo_get_featured_image( $post_ID );
			if ( $post_featured_image ) {
				echo '<img src="' . esc_url( $post_featured_image ) . '" />';
			}
		}
	}

	add_filter( 'manage_post_posts_columns', 'pixo_add_post_thumbnail' );
	add_action( 'manage_post_posts_custom_column', 'pixo_post_column_content', 10, 2 );


// ---------------------------------------------------------
// --  Remove Revslider dropdown from custom post types  --
// ---------------------------------------------------------

	function pixo_remove_revolution_slider_meta_boxes() {
		$post_types = array(
			'page',
			'post',
			'project',
			'zx_slide',
			'team_member',
			'testimonial',
			'info_slide',
			'pricing_table',
			'client',
		);
		foreach ( $post_types as $post_type ) {
			remove_meta_box( 'mymetabox_revslider_0', $post_type, 'normal' );
		}
	}

	if ( is_admin() ) {
		add_action( 'do_meta_boxes', 'pixo_remove_revolution_slider_meta_boxes' );
	}

	add_theme_support( 'deactivate_revslider' );


// ----------------------------------
// --  Register Styles  --
// ----------------------------------

	function pixo_load_front_css() {
		if ( ! is_admin() ) {
			$protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_style( 'pixo_style', PIXO_CSS_URI . 'theme-style.css', false, PIXO_VERSION );

			// Appends user CSS to the above stylesheet
			if ( get_theme_mod( 'css_block' ) ) {
				wp_add_inline_style( 'pixo_style', "\n /* User Added Styling */ \n" . get_theme_mod( 'css_block' ) );
			}
		}
	}


// ----------------------------------
// --  Register scripts  --
// ----------------------------------


	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	function pixo_load_admin_scripts() {
		wp_enqueue_script( 'select2', PIXO_ASSETS_URI . 'select2/select2.js', array( 'jquery' ) );
		wp_enqueue_style( 'select2', PIXO_ASSETS_URI . 'select2/select2.css' );
		wp_enqueue_style( 'font-awesome', PIXO_CSS_URI . '/font-awesome.min.css' );

		// For including TGMPA display on themes page
		wp_enqueue_style( 'pixo_admin', PIXO_CSS_URI . '/admin.css' );
	}


	function pixo_load_front_scripts() {

		wp_dequeue_script( 'vc_jquery_skrollr_js' );
		// All Footer Scripts Frontend Scripts

		wp_enqueue_script( 'modenizer', PIXO_JS_URI . 'vendor/modernizr-2.6.2.min.js' );

		if ( is_ssl() ) {
			wp_register_script( 'google_map_api',
				'https://maps-api-ssl.google.com/maps/api/js?sensor=false&v=3.exp',
				array( 'jquery' ),
				null,
				true );
		} else {
			wp_register_script( 'google_map_api',
				'http://maps.googleapis.com/maps/api/js?sensor=false&v=3.exp',
				array( 'jquery' ),
				null,
				true );
		}

		wp_enqueue_script( 'pixo_pixo',
			PIXO_JS_URI . 'pixo.js',
			array(
				'jquery',
				'jquery-effects-core',
				'google_map_api'
			),
			PIXO_VERSION,
			true );

		if ( class_exists( 'zorbix_settings' ) ) {
			$pixo__settings = array(
				'is_customizer'      => is_customize_preview(),
				'contact'            => array(
					'name_error'    => zorbix_settings::get_option_or_default( 'contact_name_error' ),
					'email_error'   => zorbix_settings::get_option_or_default( 'contact_email_error' ),
					'message_error' => zorbix_settings::get_option_or_default( 'contact_message_error' ),
				),
				'ajax_url'           => admin_url( 'admin-ajax.php' ),
				'scroller_direction' => zorbix_helper::get_post_meta( 'scroller_direction', 'horizontal' )

			);

			wp_localize_script( 'pixo_pixo',
				'zorbix_settings', $pixo__settings
			);
		}

		wp_localize_script( 'pixo_plugins', 'plugins_ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

	// Activate hooks
	add_action( 'wp_enqueue_scripts', 'pixo_load_front_css' );
	add_action( 'wp_enqueue_scripts', 'pixo_load_front_scripts' );
	add_action( 'admin_enqueue_scripts', 'pixo_load_admin_scripts' );

}

if ( ! function_exists( 'pixo_fix_no_editor_on_posts_page' ) ) {

	/**
	 * Add the wp-editor back into WordPress after it was removed in 4.2.2.
	 *
	 * @param Object $post
	 *
	 * @return void
	 */
	function pixo_fix_no_editor_on_posts_page( $post ) {
		if ( isset( $post ) && $post->ID !== get_option( 'page_for_posts' ) ) {
			return;
		}

		remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
		add_post_type_support( 'page', 'editor' );
	}

	add_action( 'edit_form_after_title', 'pixo_fix_no_editor_on_posts_page', 0 );
}


// --------------------------------------------
// --  Improve content link jump --
// --------------------------------------------

// Remove the jump down the page when clicking the read more link
function pixo_remove_more_tag_link_jump( $link ) {
	$offset = strpos( $link, '#more-' ); //Locate the jump portion of the link
	if ( $offset ) { //If we found the jump portion of the link
		$end = strpos( $link, '"', $offset ); //Locate the end of the jump portion
	}
	if ( $end ) { //If we found the end of the jump portion
		$link = substr_replace( $link, '', $offset, $end - $offset ); //Remove the jump portion
	}

	return $link; //Return the link without jump portion or just the normal link if we didn't find a jump portion
}

add_filter( 'the_content_more_link', 'pixo_remove_more_tag_link_jump' ); //Add our function to the more link filter

// --------------------------------------------
// -- Contextual help --
// --------------------------------------------

function pixo_contextual_help() {
	// We are in the correct screen because we are taking advantage of the load-* action (below)

	$screen = get_current_screen();

	if ( 'edit-project' === $screen->id ) {
		//$screen->remove_help_tabs();
		$screen->add_help_tab( array(
			'id'      => 'pixo-project-list',
			'title'   => esc_html__( 'Ordering projects', 'pixo' ),
			'content' => '<p>' . esc_html__( 'Projects are the same as posts and order by date in the same way as a post. If you would like a custom order, the order anything plugin does a great job.', 'pixo' ) . '</p>'
		) );

	}

	switch ( $screen->id ) {
		case 'project':
			$screen->add_help_tab( array(
				'id'      => 'pixo-project-edit',
				'title'   => esc_html__( 'Thumbnail', 'pixo' ),
				'content' => '<p>' . esc_html__( 'The thumbnail you see in portfolio is the featured image to the bottom left', 'pixo' ) . '</p>'
			) );
			break;
	}

}

add_action( 'contextual_help', 'pixo_contextual_help' );

