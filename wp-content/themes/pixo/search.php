<?php

get_header();

$pixo_blog['sidebar'] = zorbix_helper::get_mb_or_option('blog_sidebar');

get_template_part( 'partials/blog', 'title' ) ?>

	<div class="blog-wrap container">

		<?php // Sidebar left
		$pixo_blog['main_classes'] = '';
		if (!empty($pixo_blog['sidebar'])) {
			$pixo_blog['main_classes'] .= 'blog-main col-md-9';
		}

		if ($pixo_blog['sidebar'] === 'left') {
		get_sidebar();
		} ?>

		<div class="<?php echo esc_attr( $pixo_blog['main_classes'] ) ?>">

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/blog', 'image-single' ); ?>
				<?php get_template_part( 'partials/blog', 'date' ); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post' ); ?>>

					<?php
					# Get Post Template
//					zorbix_get_post_format_template();
					get_template_part( 'partials/blog', 'heading' ); ?>

					<?php get_template_part( 'partials/blog', 'meta' ) ?>

					<p><?php echo zorbix_blog::limit_excerpt('200'); ?></p>

					<p><a class="more-link" href="<?php get_the_permalink() ?>">Read More</a></p>

				</article><!-- End .blog-post -->

			<?php endwhile;
			else : ?>

				<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'pixo' ); ?></p>

			<?php endif; ?>

			<?php zorbix_blog::pagination(); ?>

		</div>

		<?php // Sidebar right
		if ($pixo_blog['sidebar'] === 'right') {
			get_sidebar();
		} ?>

	</div>
<?php get_footer();
