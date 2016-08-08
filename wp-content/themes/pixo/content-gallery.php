<?php defined('ABSPATH') || die;


// Only run if the plugin is loaded
if (class_exists( 'zorbix_img' )) {

	$pixo_gallery_ids = zorbix_blog::get_gallery_attachments();

	zorbix_blog::remove_first_gallery();

	if (is_array($pixo_gallery_ids)) : ?>
		<div class="blog-media">
			<ul class="post-slider bxslider">
				<?php foreach ($pixo_gallery_ids as $pixo_id) : ?>
					<li>
						<?php
						if (is_single()) :
							zorbix_helper::tag_from_id($pixo_id, 'full');
						else :
							printf('<a href="%s">%s</a>',
								esc_url(get_the_permalink()),
								zorbix_helper::get_tag_from_id($pixo_id, 'full') // Contains HTML escaped in function
							);
						endif;
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif;
}

get_template_part('partials/blog', 'contents');
