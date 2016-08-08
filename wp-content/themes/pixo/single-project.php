<?php get_header(); ?>

<?php
// Start the Loop.
while (have_posts()) : the_post();
	the_content();
endwhile; ?>

<div class="project-arrows">
	<div class="container">
		<?php
		next_post_link('%link', zorbix_helper::prev_arrow() . esc_html__('PREV', 'pixo'));
		printf(
			'<a class="main-portfolio" href="%s">%s</a>',
			esc_url(zorbix_helper::get_option_or_default('portfolio_link')),
				esc_html__('MAIN', 'pixo')
		);
		previous_post_link('%link', esc_html__('NEXT', 'pixo') . zorbix_helper::next_arrow());
		?>
	</div>
</div>

<?php get_footer(); ?>

