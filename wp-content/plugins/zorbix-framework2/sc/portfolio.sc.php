<?php

# PORTFOLIO METABOXES
add_action( 'after_setup_theme', 'zorbix_portfolio_meta_boxes' );
function zorbix_portfolio_meta_boxes() {

	zorbix_mb::create(
		array(
			'id'       => 'project',
			'title'    => esc_html__( 'Options', 'zorbix' ),
			'desc'     => '',
			'pages'    => array( 'project' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array( // Title
				       'type'  => 'text',
				       'id'    => 'title',
				       'label' => esc_html__( 'Thumbnail Title', 'zorbix' ),
				       'desc' => esc_html__('This is the label when you hover over the thumbnail', 'pixo')
				),
				array( // pre title
				       'type'    => 'text',
				       'id'      => 'subtitle',
				       'label'   => esc_html__( 'Thumbnail subtitle', 'zorbix' ),
				       'default' => '',
				       'desc' => esc_html__('This is the 2nd label when you hover over the thumbnail', 'pixo')
				),

				array(
					'type'    => 'on-off',
					'id'      => 'large',
					'label'   => esc_html__( 'Tall', 'zorbix' ),
					'std'         => 'off',
					'desc' => esc_html__('Make an item twice as tall (for a mansonry style layout)', 'pixo'),
				),

				array(
					'type'    => 'on-off',
					'id'      => 'layout',
					'label'   => esc_html__( 'Lightbox', 'zorbix' ),
					'desc' => esc_html__('Use a lightbox popup instead of going to a project page', 'pixo') ,
					'std'         => 'off'
				),
				array(
					'type'  => 'upload',
					'id'    => 'seperate_image',
					'label' => esc_html__( 'Optional: Use different Full Size Image than the thumbnail image', 'zorbix' ),
					'desc'  => esc_html__(
						'Set image here only if you would like a seperate lightbox image in the popup. By default the larger version of the featured image will show',
						'zorbix'
					),
				),
			),
		)
	);
}



add_shortcode( 'portfolio', 'zorbix_portfolio' );
function zorbix_portfolio( $atts ) {

	$default_atts = array(
		'boxed'          => '',
		'gutter'         => '',
		'porttiles'      => '',
		'loadbutton'     => '',
		'load_more_text' => esc_html__( 'LOAD MORE', 'zorbix' ),
		'all_text'       => esc_html__( 'All', 'zorbix' ),
		'filter_menu'    => '',
		'disable_large'    => '',
		'disable_ajax'   => '',
		'columns'        => 'port-4',
		'show'           => '4',
		'port_height'    => '',
		'order_by' => 'menu_order'
	);

	# Set Attributes
	$default_atts = zorbix_sc::get_attr_set( $default_atts, array( 'cpt' ) );
	$atts         = zorbix_sc::shortcode_atts( $default_atts, $atts, 'portfolio' );

	$atts['disable_ajax'] = zorbix::if_false( $atts['disable_ajax'], 'portfolio_ajax' );

	$class = zorbix::join(
		zorbix::if_true( $atts['gutter'], 'port-gutter'),
		$atts['porttiles'],
		$atts['disable_ajax'],
		$atts['columns'],
		$atts['show'],
		$atts['port_height']
	);

//	return $class;

	# Get posts
	$cpt_posts = zorbix_sc::cpt( array(
		'post_type' => 'Project',
		'tax'       => 'portfolio',
		'atts'      => $atts,
	) );
	//zorbix_sc::cpt_debug($cpt_posts);

	switch ( $atts['columns'] ) {
		case 'port-2':
			$num = 2;
			break;
		case 'port-3':
			$num = 3;
			break;
		case 'port-5':
			$num = 5;
			break;
		default:
			$num = 4;
	}

	# Generate HTML
	ob_start(); ?>

	<div class="portfolio-wrapper">

	<?php if ( ! $atts['filter_menu'] ) : ?>
		<ul class="filter-menu">
			<?php zorbix_sc::port_list( $atts['all_text'] ); ?>
		</ul>
	<?php endif; ?>

	<div class="project-wrapper <?php echo esc_attr( $atts['boxed'] ) ?>"></div>

<div class="portfolio <?php echo esc_attr( $class ) ?>" data-show="<?php echo esc_attr( $atts['show'] ) ?>">

	<?php
	if ( $cpt_posts->have_posts() ) : while ( $cpt_posts->have_posts() ) : $cpt_posts->the_post();

		# Get metabox data
		$data                = new stdClass();
		$data->content       = zorbix_mb::get( 'portfolio.content' );
		$data->img_full      = zorbix_img::get_thumb_src( 'full', '', true );
		$data->title         = zorbix_mb::get( 'title' );
		$data->subtitle      = zorbix_mb::get( 'subtitle' );
		$data->layout        = zorbix_mb::get( 'layout' );
		$data->lightbox_full = zorbix_mb::get( 'seperate_image' );
		$data->lightbox_full = zorbix_mb::get( 'seperate_image' );
		$data->port_height = $atts['port_height'];

		$itemClass = ( '' === $atts['disable_large'] && 'on' === zorbix_mb::get( 'large' ) ) ? 'tall' : '';

		if( '' === $atts['disable_large'] && zorbix_mb::get( 'size' ) !== '') {
			$data->port_height = 'port_thumb';
		}
		if ( ! empty( $data->lightbox_full ) ) {
			$data->img_full = $data->lightbox_full;
		}


		wp_enqueue_script( 'zorbix_portfolio' ); ?>

		<div class="port-item <?php echo esc_attr( $itemClass ) ?>" data-cat="<?php zorbix_sc::port_cats() ?>">

			<div class="port-inner">

				<!-- thumb -->
				<?php
				if ( $cpt_posts->current_post < $atts['show'] ) {
					zorbix_img::thumb_tag( $data->port_height, '', true );
				} else {
					$data->img_src = zorbix_img::get_thumb_src( $data->port_height, '', true );
					echo '<div data-port-thumb="' . esc_attr( $data->img_src ) . '"></div>';
				}

				// Only run if not frontend editor as creates a loop
				if ( function_exists( 'vc_is_page_editable' ) && ! vc_is_page_editable() ) {
					// Process shortcodes without displaying them to load vc libraries
					do_shortcode( get_the_content() );
				} else {
					do_shortcode( get_the_content() );
				}

				if ( $data->layout === 'on' ) : ?>
				<a class="lightbox-btn" data-pp="prettyPhoto"
				   href="<?php echo esc_attr( $data->img_full ) ?>">
					<?php else : ?>
					<a href="<?php the_permalink() ?>" class="port-overlay">
						<?php endif; ?>

						<div class="inner">
							<i class="fa fa-plus-circle"></i>
							<?php if ( ! $atts['porttiles'] ) : ?>
								<h4 class="title"><?php echo esc_attr( $data->title ) ?></h4>
								<span><?php echo esc_attr( $data->subtitle ) ?></span>
							<?php endif; ?>
						</div>

					</a><!-- / .port-overlay -->

			</div>
			<!-- End .port-inner -->

			<?php if ( $atts['porttiles'] ) : ?>


				<?php if ( ! empty( $data->title ) || ! empty( $data->subtitle ) ) : ?>
					<div class="port-info">

					<?php zorbix::printf_if_exists('<h4 class="title">%s</h4>', esc_attr( $data->title ) ) ?>

						<p><?php echo esc_attr( $data->subtitle ) ?></p>
					</div>
				<?php endif; ?>

			<?php endif ?>
		</div><!-- / .port-item-->
	<?php
	endwhile;
	endif;
	echo '</div>'; // Portfolio
	if ( ! $atts['loadbutton'] ) : ?>
		<a href="#" data-num="<?php echo esc_attr( $num ) ?>" id="load-more" class="btn btn-default load-more">
			<?php echo esc_html( $atts['load_more_text'] ) ?>
		</a>
	<?php endif;
	echo '</div>'; // End .portfolio-wrapper

	return ob_get_clean();
}
