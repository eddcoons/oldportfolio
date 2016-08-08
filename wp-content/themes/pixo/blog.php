<?php
/*
 Template Name: Blog
 Default blog page
*/

get_header();

$pixo_posts_query = array( 'post_type' => 'post', 'posts_per_page' => 10);
$pixo_posts_query = new WP_Query($pixo_posts_query);

$pixo_blog['post_classes'] = '';
$pixo_blog['layout'] = zorbix_helper::get_mb_or_option('blog-layout', 'classic');
$pixo_blog['sidebar'] = zorbix_helper::get_mb_or_option('blog_sidebar');


get_template_part(
		'partials/blog-title'
);
?>

	<div class="blog-wrap container">

		<?php
		$pixo_blog['main_classes'] = 'blog-main ';

		if ('medium' === $pixo_blog['layout']) {
			$pixo_blog['main_classes'] = 'blog-medium';
		}

		if ( !empty( $pixo_blog['sidebar'] ) ) {
			$pixo_blog['main_classes'] .= ' col-md-9';
		}

		if ('masonry' === $pixo_blog['layout']) {
			$pixo_blog['main_classes'] = 'blog-masonry';
			$pixo_blog['post_classes'] = 'col-md-4 col-sm-6';
			$pixo_blog['sidebar'] = '';
		}


		// Sidebar left
		if ( $pixo_blog['sidebar'] === 'left') {
			get_sidebar();
		} ?>

		<div class="<?php echo esc_attr($pixo_blog['main_classes']) ?>">

			<?php if ($pixo_posts_query->have_posts()) : while ($pixo_posts_query->have_posts()) : $pixo_posts_query->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class("blog-post {$pixo_blog['post_classes']}"); ?>>

					<?php zorbix_blog::get_post_format_template(); ?>

				</article><!-- End .blog-post -->

			<?php endwhile;
			else : ?>

				<p><?php esc_html_e('Sorry, no posts matched your criteria.', 'pixo'); ?></p>

			<?php endif; ?>

			<?php
			zorbix_blog::pagination(); ?>

		</div>

		<?php // Sidebar right
		if ( $pixo_blog['sidebar'] === 'right') {
			get_sidebar();
		} ?>
	</div><!-- End .blog/.container -->
<?php get_footer();