<?php
/*
Zorbix Page builder
*/

function zorbix_ajax_request() {
	// The $_REQUEST contains all the data sent via ajax
	if ( isset( $_REQUEST ) ) {
		$sc      = ( isset( $_REQUEST['sc'] ) ) ? esc_js( $_REQUEST['sc'] ) : '';
		$content = ( isset( $_REQUEST['content'] ) ) ? esc_js( $_REQUEST['content'] ) : '';

		echo zorbix_builder::get_form( $sc, $content );
		// Now we'll return it to the javascript function
		// Anything outputted will be returned in the response

		// If you're debugging, it might be useful to see what was sent in the $_REQUEST
		// print_r($_REQUEST);
	}
	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_example_ajax_request', 'zorbix_ajax_request' );
// If you wanted to also use the function for non-logged in users (in a theme for example)
// add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );


// Pass ajax url to JS
// bit inside the function where you pass the vars


/**
 * Helper for creating front end HTML. This class is not part of the framework plugin as these functions need to be available on page templates
 **/
class zorbix_builder {

	private static $instance = null;
	public static $options_loaded = 'false';
	public static $classes = array();
	public static $elements = array();
	static $get = null;
	public static $maps = array();


	static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new zorbix_builder();
		}

		add_action( 'current_screen', 'my_admin_add_page' );
		function my_admin_add_page() {
			$enabled_pages = array( 'page', 'project' );
			if ( class_exists( 'zorbix_builder' ) ) {
				$current_screen = get_current_screen()->id;
				if ( in_array( $current_screen, $enabled_pages ) ) {
					zorbix_builder::queue_assets();
					add_action( "add_meta_boxes", array( 'zorbix_builder', 'my_custom_meta_box' ) );
				}
			} else {
				error_log( 'no framework' );
			}
		}

	}

	public static function get_maps() {
		return self::$maps;
	}

	public static function add_to_map( $map_name, $newParams ) {
		$params                            = array_merge_recursive( self::$maps[ $map_name ]['params'], $newParams );
		self::$maps[ $map_name ]['params'] = $params;

	}

	public static function add_map( $map, $debug = false ) {
//		if( $debug ) {
//			zorbix::debug( $map, 'Map set a' );
//		}
		// If group param not set, set it to empty


		self::$elements[]           = $map['base'];
		self::$maps[ $map['base'] ] = $map;

		return $map['base'];
	}

	/**
	 * @param $map_name
	 * @param $sc
	 *
	 * @var $description
	 */
	private static function build_from_map( $map, $sc ) {

		/* @var $description */
		/* @var $heading */
		/* @var $param_name */
		?>

		<?php foreach ( $map['params'] as $param ) : ?>
			<?php
			$param_name = "{$param['param_name']}";
			if ( ! isset( $param['description'] ) ) {
				$param['description'] = '';
			}

			extract( $param );
			$preset_value_for_field = '';  // Used in field includes
			$atts                   = ( isset( $sc->attrs ) ) ? $sc->attrs : '';
			if ( isset( $atts->$param_name ) && ! empty( $atts->$param_name ) ) {
				$preset_value_for_field = $atts->$param_name;
			}

			if ( ! isset( $param['group'] ) ) {
				$param['group'] = 'main';
			}

			// Convert linebreaks
			$sc->content = str_replace( '\r', "\r", str_replace( '\n', "\n", $sc->content ) );
			$sc->content = str_replace( '&nbsp;', "", $sc->content );
			$class       = ( 'info' !== $type ) ? 'col-sm-6 ' : '';
//		$class = 'col-sm-6 ' . $type . '-wrap'
			?>
			<div class="field-wrap <?php echo esc_attr( 'field-wrap-' . $param['type'] ) ?> "
			     data-group="<?php echo esc_attr( $param['group'] ) ?>">
				<div class="zbx-input <?php echo esc_attr( $class ) ?>">

					<?php

					if ( 'content' === $param['param_name'] && 'textfield' === $param['type'] ) {
//					$param['value'] = $sc->content;
						$preset_value_for_field = $sc->content;
					}

					switch ( $param['type'] ) {
						case 'editor':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'editor.php';
							break;
						case 'textarea':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'textarea.php';
							break;
						case 'dropdown':
							$options = $param['value'];
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'dropdown.php';
							break;
						case 'iconpicker':
							$options = $param['value'];
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'dropdown.php';
							break;
						case 'checkbox':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'checkbox.php';
							break;
						case 'media':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'media.php';
							break;
						case 'image':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'media.php';
							break;
						case 'image_multi':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'media.php';
							break;
						case 'link':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'link.php';
							break;
						case 'info':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'info.php';
							break;
						case 'colorpicker':
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'colorpicker.php';
							break;
						default:
							include ZORBIX_PLUGIN_DIR . 'forms/' . 'textfield.php';
					} ?>

				</div>

				<?php if ( 'info' !== $type ) : ?>
					<div class="zbx-desc col-sm-6">
						<label for="<?php echo esc_html( $param_name ) ?>">
							<?php echo esc_html( $heading ) ?>
						</label>

						<p><?php echo esc_html( $description ) ?></p>
					</div>
				<?php endif; ?>
			</div>

		<?php endforeach;
	}

	public static function get_form( $sc, $content ) {

		ob_start();

		if ( ! empty( $sc ) ) {
			$sc = JSON_DECODE( html_entity_decode( $sc ) );
//			echo json_last_error_msg();/

			$sc->content = trim( html_entity_decode( stripcslashes( stripcslashes( $content ) ), ENT_COMPAT, 'UTF-8' ), '"' );
			$content     = str_replace( '""', '"', $content );
		}

		?>

		<div class="zbx-atts-form-wrap">

			<?php
			if ( isset( self::$maps[ $sc->tag ] ) ) {
				$map     = self::$maps[ $sc->tag ];
				$heading = $map['name'];
				$desc    = isset( $map['description'] ) ? $map['description'] : '';
				?>
				<div class="intro">
					<h1><?php echo esc_html( $heading ) ?></h1>
				</div>
				<form method="post" class="zbx-atts-form">
					<?php zorbix::printf_if_exists( '<div class="desc">%s</div>', esc_html( $desc ) ) ?>
					<?php self::build_from_map( $map, $sc ) ?>
					<button type="submit" id="zbx-builder-submit">Submit</button>
					<a href="#" id="zbx-builder-cancel">cancel</a>
				</form>

			<?php } else {
				echo '<div class="inner">' . esc_html__( 'We don\'t have a map for shortcode: ', 'zorbix' ) . esc_html( $sc->tag ) . '</div>';
				echo '<a href="#" id="zbx-builder-cancel">cancel</a>';
			}
			?>


		</div>
		<?php echo ob_get_clean();
	}

	public static function queue_assets() {

		function load_admin_scripts() {
			wp_enqueue_script(
				'iris',
				admin_url( 'js/iris.min.js' ),
				array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
				false,
				1
			);

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( "jquery-effects-core" );
			wp_enqueue_script( "zorbix-builder", ZORBIX_BUILDER_URI . 'js/bundled-builder.js', array(
				"wp-util",
				"shortcode",
				'wplink'
			), ZORBIX_VERSION, true );
			global $shortcode_tags;

			$templates_full_directory = get_template_directory() . '/admin/templates/';
			$snippets_full_directory  = get_template_directory() . '/admin/snippets/';

			$templates = array();
			if ( file_exists( $templates_full_directory ) ) {
				foreach ( glob( $templates_full_directory . '*.json' ) as $filename ) {
					$name                                     = basename( $filename, '.json' ); // NOTE: basename is not used to include a file. This is only used in the back get to get name of file from the path.
					$templates[ zorbix::id_to_name( $name ) ] = file_get_contents( $filename );
				}
			} else {
				error_log( 'Could not find directory ' . $templates_full_directory );
			}

			$snippets = array();
			if ( file_exists( $snippets_full_directory ) ) {
				foreach ( glob( $snippets_full_directory . '*.json' ) as $filename ) {
					$name                                    = basename( $filename, '.json' ); // NOTE: basename is not used to include a file. This is only used in the back get to get name of file from the path.
					$snippets[ zorbix::id_to_name( $name ) ] = file_get_contents( $filename );
				}
			} else {
				error_log( 'Could not find directory ' . $snippets_full_directory );
			}

			wp_localize_script( 'zorbix-builder', 'zbxbuilder_ajax',
				array(
					'url'               => admin_url( 'admin-ajax.php' ),
					'snippetImagesUrl'  => get_template_directory_uri() . '/admin/snippets/img/',
					'templateImagesUrl' => get_template_directory_uri() . '/admin/templates/img/',
					'tags'              => $shortcode_tags,
					'maps'              => zorbix_builder::$maps,
					'templates'         => $templates,
					'snippets'          => $snippets,
				) );
			wp_enqueue_style( "zorbix-builder", ZORBIX_BUILDER_URI . 'css/builder.css', false, ZORBIX_VERSION );
		}

		add_action( "admin_enqueue_scripts", "load_admin_scripts" );
	}

	public static function meta_box_markup() {

		?>

		<div class="hidden-editor-container" style="display: none;">
			<?php wp_editor( 'Default Content', 'builder' ); ?>
		</div>
		<div class="zbx-add-stuff-popup">
			<div class="inner">
				<h2>ADD SHORTCODE</h2>
				<input type="text" id="sc-filter">
				<a href="#" class="close"><i class="fa fa-times-circle-o close"></i></a>

				<div class="content">
					<?php
					$exclude        = array( 'section' );
					self::$elements = array_diff( self::$elements, $exclude );
					foreach ( self::$elements as $element ) : ?>
						<div class="col-md-3">
							<a href="#" class="zbx-add-element"
							   data-element="<?php echo esc_html( $element ) ?>">
								<?php
								if ( isset( self::$maps[ $element ]['icon'] ) ) {
									printf( '<i class="%s"></i>', esc_attr( self::$maps[ $element ]['icon'] ) );
								}

								echo esc_html( self::$maps[ $element ]['name'] );
								?>
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<a class="zbx-add-section" data-tag="section" href="#">Add Section</a>

		<a id="add-template" href="#">Add Template</a>

		<!--		<a href="#" id="zbx-convert">Convert From VC</a>-->

		<div id="zbx-drop-zone"></div>

		<?php
	}

	public static function my_custom_meta_box() {
		add_meta_box( "page-builder", "Page Builder", array(
			'zorbix_builder',
			"meta_box_markup"
		), "page", "normal", "high", null );

		add_meta_box( "page-builder", "Page Builder", array(
			'zorbix_builder',
			"meta_box_markup"
		), "project", "normal", "high", null );

	}


}


add_action( 'wp_loaded', array( 'zorbix_builder', 'get_instance' ) );
