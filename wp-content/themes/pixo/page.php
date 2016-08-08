<?php
/*
 * The default page template
 */

get_header(); ?>

	<div
		class="blog-heading sect bg-light-gray <?php echo esc_attr(zorbix_helper::join(get_theme_mod('blog_heading_tint'))) ?>">
		<div class="container">
			<h1 class="sectiono-title">
				<span><?php the_title() ?></span>
			</h1>
		</div>
	</div>
	<section class="sect">

		<div class="container">

			<?php if (have_posts()) {
				while (have_posts()) :
					the_post(); ?>
					<?php the_content(); ?>

					<?php if (comments_open() || get_comments_number()) { ?>
					<div class="page-comments">
						<?php comments_template(); ?>
					</div>
				<?php } ?>

				<?php endwhile;
			}; ?>

		</div>
	</section>


<?php get_footer();
