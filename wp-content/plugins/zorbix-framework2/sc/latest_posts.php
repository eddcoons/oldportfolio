<?php


if ( ! ( function_exists( 'zorbix_limit_excerpt' ) ) ) {
	function zorbix_limit_excerpt( $limit, $source = null ) {
		if ( $source === 'content' ? ( $excerpt = get_the_content() ) : ( $excerpt = get_the_excerpt() ) ) {
		}

		$excerpt       = preg_replace( ' (\[.*?\])', '', $excerpt );
		$excerpt       = strip_shortcodes( $excerpt );
		$excerpt       = strip_tags( $excerpt );
		$length_before = strlen( $excerpt );
		$excerpt       = substr( $excerpt, 0, $limit );
		$length_after  = strlen( $excerpt );
		$excerpt       = substr( $excerpt, 0, strripos( $excerpt, ' ' ) );

		$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
		// Add dots to all but those with out any text.
		if ( strlen( $excerpt ) !== 0 ) {
			return $excerpt . '<a class="more" href="' . esc_url( get_permalink( get_the_id() ) ) . '">...</a>';
		} else {
			return $excerpt;
		}
	}

}

add_shortcode( 'latest_posts', 'zorbix_latest_posts' );

function zorbix_latest_posts( $atts ) {

	$post_type    = 'post';
	$taxonomy     = 'category';
	$sets         = array( 'cpt', 'animation', 'column' );
	$default_atts = array(
		'images' => 'false',
		'disable_post_types' => 'false',
	);

	$default_atts    = zorbix_sc::get_attr_set( $default_atts, $sets );
	$atts            = shortcode_atts( $default_atts, $atts, 'latest_posts' );
	$animation_class = zorbix_sc::animation_class( $atts );

	$cpt_posts = zorbix_sc::cpt( array(
		'post_type' => $post_type,
		'tax'       => $taxonomy,
		'atts'      => $atts,
	) );

	$comments_meta_bool =  ( class_exists( 'zorbix_settings' ) ) ? zorbix_settings::get_option( 'meta_comments' ) : true;

	ob_start(); ?>
	<div class="latest-posts">
		<?php if ( $cpt_posts->have_posts() ) : while ( $cpt_posts->have_posts() ) : $cpt_posts->the_post();

		$class = "$animation_class {$atts['col_width']} col col-sm-6";
//$class ='';

		$zorbix['quote']        = zorbix_mb::get( 'quote' );
		$zorbix['quote_url']    = zorbix_mb::get( 'link' );
		$zorbix['quote_author'] = zorbix_mb::get( 'author' );

		printf( '<div class="%s" %s >',
			esc_attr( $class ),
			zorbix_anim_data_esc( $atts, $cpt_posts )
		);

		?><div class="post"><?php

		# Get formatted link
		if( 'true' !== $atts['disable_post_types'] && defined('ZORBIX_VERSION') ) { // only look for if theme is loaded.
			include( locate_template( 'partials/blog-link.php' ) );
		} ?>

		<?php
		if ( has_post_thumbnail() && 'true' !== $atts['images'] ) : ?>
		<!-- Blog Media -->
		<a href="<?php the_permalink() ?>" class="blog-media">
			<?php zorbix_img::thumb_tag( 'pixo_blog_thumb' ); ?>
		</a>
		<?php endif; ?>

		<div class="post-content">
		<h4 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>


		<?php echo zorbix_limit_excerpt( 150 ); ?>

		<hr/>

		<div class="blog-meta">
			<?php the_author_posts_link() ?> -
			<?php the_time( 'd M' ); ?>
			<?php echo ( $comments_meta_bool ) ? comments_number( '',
				' - one <a class="smooth_jump" href="#comments">comment</a>',
				' - % <a class="smooth_jump" href="#comments">comments</a>' ) : ''; ?>
		</div>

		</div>

		</div>
		</div>
		<?php
//		zorbix_sc::col_seperator( $cpt_posts, 3, $atts['col_width'] );

	endwhile; endif;
	?>
	</div>

	<?php return $output = ob_get_clean();

}

;
