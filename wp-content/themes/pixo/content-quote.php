<?php defined( 'ABSPATH' ) || die;


	$pixo['quote_author'] = zorbix_helper::get_post_meta( 'author' );
	$pixo['quote']        = zorbix_helper::get_post_meta( 'quote' );
	$pixo['quote_url']    = zorbix_helper::get_post_meta( 'quote_link' );


	get_template_part( 'partials/blog', 'images' );

	# QUOTE
	if ( !empty ($pixo['quote'] ) ) : ?>
		<blockquote class="post-quote"><i class="fa fa-quote-left"></i>
			<?php zorbix_blog::rendered_quote_anchor_or_text( $pixo ) ?>
			<span class="author">
				<?php echo esc_html( $pixo['quote_author'] ) ?>
			</span>
		</blockquote>

	<?php endif;

	get_template_part( 'partials/blog', 'contents' );