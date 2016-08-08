<?php
/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php $pixo_logged_in = ( is_user_logged_in() ) ? 'logged-in' : ''; ?>

<div id="comments" class="comments-area <?php echo esc_attr( $pixo_logged_in ) ?>">

	<?php if ( have_comments() ) : ?>

		<!-- COMMENTS TITLE -->
		<h4 class="comments-title sub-title">
			<?php
			if ( get_comments_number() > 1 ) {
				printf( '%s %s &ldquo;%s&rdquo;',
					esc_html( number_format_i18n( get_comments_number() ) ),
					esc_html( zorbix_helper::get_option('comment_title_plural') ),
					esc_html( get_the_title() )
				);
			} else {
				printf( '%s &ldquo;%s&rdquo;',
					esc_html( zorbix_helper::get_option('comment_title_single') ),
					esc_html( get_the_title() )
				);
			}
			?>&#x200E;
		</h4>

		<!-- COMMENTS LIST -->
		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ul',
				'short_ping'  => true,
				'avatar_size' => 70,
				'callback'    => 'zorbix_blog::format_comments',
			) );
			?>
		</ul><!-- End .conents-list -->

		<!-- COMMENTS NAVIGATON -->
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'pixo' ); ?></h1>

				<div class="nav-previous">
					<?php previous_comments_link( esc_html__( '&larr; Older Comments', 'pixo' ) ); ?>
				</div>
				<div class="nav-next">
					<?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'pixo' ) ); ?>
				</div>
			</nav><!-- #comment-nav-below -->
		<?php endif; // Check for comment navigation. ?>

		<!-- COMMENTS CLOSED MESSAGE-->
		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'pixo' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>


	<!-- COMMENTS FORM -->
	<?php

	$pixo_comment_fields['author']
		= '<div class="col-md-3">
			<input type="text" id="comment-name" name="author" placeholder="'
		  . esc_html( zorbix_helper::get_option_or_default('comment_name') ) . '*">';

	$pixo_comment_fields['email'] = '<input type="email" id="comment-email" name="email" placeholder="'
	                                  . esc_attr( zorbix_helper::get_option_or_default('comment_email') ) . ' *">';

	$pixo_comment_fields['url']
		= '<input type="text" id="comment-url" name="url" placeholder="' . esc_attr( zorbix_helper::get_option_or_default('comment_url') )
		  . '"></div>';

	$pixo_comment_textarea = '<div class="col-md-9"><textarea name="comment" id="comment-message"  placeholder="'
	                           . esc_attr( zorbix_helper::get_option_or_default('comment_message') ) . '*"></textarea></div>';


	?>

	<?php comment_form( array(
		'fields'              => $pixo_comment_fields,
		'comment_field'       => $pixo_comment_textarea,
		'comment_notes_after' => '', // Removes html info
		'class_submit' => 'btn btn-default',
	) ); ?>

</div><!-- #comments -->
