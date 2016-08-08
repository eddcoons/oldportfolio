<?php
/**
 * The Template for displaying all single posts
 */

get_header();

$pixo_blog['sidebar'] = zorbix_helper::get_mb_or_option('sidebar');
$pixo_blog['main_classes'] = '';

if ( !empty( $pixo_blog['sidebar'] ) ) {
	$pixo_blog['main_classes'] .= 'blog-main col-md-9';
} ?>

<?php get_template_part( 'partials/blog', 'title' ) ?>

	<div class="blog-wrap container">

		<?php # Sidebar right
		if ( $pixo_blog['sidebar'] === 'left' ) {
			get_sidebar();
		} ?>

		<div class="<?php echo esc_attr( $pixo_blog['main_classes'] ) ?>">
			<?php
				// Start the Loop.
			while ( have_posts() ) : the_post(); ?>


				<article <?php post_class( 'blog-post single clearfix' ) ?> id="post-<?php the_ID(); ?>">

				<?php
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
					?>

					<?php wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'pixo' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						) ); ?>

					</article>
					<?php
				// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				<?php endwhile; ?>
			</div><!-- End .blog-main -->
			<?php

		# Sidebar right
			if ( $pixo_blog['sidebar'] === 'right' ) {
				get_sidebar();
			} ?>

		</div><!-- End .blog/.container -->
	<?php get_footer();
