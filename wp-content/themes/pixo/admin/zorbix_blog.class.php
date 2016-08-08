<?php
/**
 * Class Zorbix_Blog
 *
 * To contain any blog related helper function
 *
 * Instance loaded automatically
 *
 * <code>
 * Zorbix_Blog::post_gallery()
 * </code>
 */
class zorbix_blog
{

	/**
	 * @var null
	 */
	private static $instance = null;
	/**
	 * @var null
	 */
	static $get = null;

	/**
	 *
	 */
	static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new zorbix_blog();
		}
	}

	/**
	 * Returns a formatted image tag
	 *
	 * @param string $size
	 * @param string $class
	 * @return array|bool|string
	 */
	static function get_thumb_tag($size = 'thumb', $class = '')
	{
		$img = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);
		$class = ($class) ? 'class="' . esc_attr($class) . '"' : '';
		if ($img[0]) {
			$img = "<img $class src='" . esc_url($img[0]) . "' alt='image'/>";

			return $img;
		}
	}

	public static function get_post_meta($id, $default = '')
	{
		$option = get_post_meta(get_the_ID(), $id, true);

		return empty($option) ? $default : $option;
	}


	/**
	 *
	 */
	public static function post_audio()
	{
		// Only shortcode & mb
		$mode = self::get_post_meta('audio_mode');
		if ('upload' === $mode) {
			printf('<audio class="internal-video" src="%s" controls> </audio>',
				esc_url(self::get_post_meta('audio_upload'))
			);
		} elseif ('embed' === $mode) {
			$link = self::get_post_meta('audio_embed');
			global $wp_embed;
			echo balanceTags($wp_embed->run_shortcode('[embed]' . esc_url($link) . '[/embed]'));
		} else {
			$video_custom = self::get_post_meta('audio_custom');
			if( method_exists( 'zorbix_sc', 'esc_shortcode_tag' ) ) {
				echo do_shortcode(zorbix_sc::esc_shortcode_tag($video_custom));
			}
		}
	}

	public static function get_post_format_template()
	{
		# Get the post format template
		$post_format = get_post_format();
		if (get_post_type(get_the_ID()) === 'page') {
			$post_format = 'page';
		}
		if ($post_format) {
			$post_template = 'content-' . $post_format . '.php';
		} else {
			$post_template = 'content.php';
		}
		if ($post_template) {
			include(locate_template($post_template));
		}
	}


	/**
	 * Display the post tags
	 */
	public static function tags()
	{
		if (zorbix_helper::get_option('meta_tags')) {
			$posttags = get_the_tags();
			$first = true;
			if ($posttags) {
				echo 'Tags: ';
				foreach ($posttags as $key => $tag) {
					echo (!$first) ? '/ ' : '';
					printf("<a href='%s'>%s</a>",
						esc_url(get_tag_link($tag)),
						esc_html($tag->name)
					);
					$first = false;
				}
			}
		}
	}

	public static function rendered_quote_anchor_or_text($quote_array)
	{
		if ($quote_array['quote_url']) {
			echo zorbix_get_anchor_esc($quote_array['quote_url'], $quote_array['quote']);
		} else {
			echo esc_html($quote_array['quote']);
		}
	}

	public static function limit_excerpt($limit, $source = null)
	{
		if ($source === 'content' ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt())) {
		}

		$excerpt = preg_replace(' (\[.*?\])', '', $excerpt);
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		$length_before = strlen($excerpt);
		$excerpt = substr($excerpt, 0, $limit);
		$length_after = strlen($excerpt);
		$excerpt = substr($excerpt, 0, strripos($excerpt, ' '));

		$excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
		// Add dots to all but those with out any text.
		if (strlen($excerpt) !== 0) {
			return $excerpt . '<a class="more" href="' . esc_url(get_permalink(get_the_id())) . '">...</a>';
		} else {
			return $excerpt;
		}
	}

	public static function prev_arrow()
	{
		return (is_rtl()) ? '<i class="fa fa-chevron-left"></i>' : '<i class="fa fa-chevron-right"></i>';
	}

	public static function next_arrow()
	{
		return (is_rtl()) ? '<i class="fa fa-chevron-right"></i>' : '<i class="fa fa-chevron-left"></i>';
	}

	/**
	 * Return uploaded or video from a metabox id
	 * Works just with the predefined metabox setup
	 *
	 * @param $metabox_id
	 *
	 * @return string
	 */
	public static function video()
	{
		$video_mode = self::get_post_meta('video_mode');
		echo '<div class="video-wrapper post-video">';
		if ('upload' === $video_mode) {
			$video_id = self::get_post_meta('video_upload');
			$video_poster = self::get_post_meta('video_poster');
			$video_webm = self::get_post_meta('video_webm');
			$video_ogg = self::get_post_meta('video_ogg');
			$video_meta = wp_get_attachment_metadata($video_id);
			$video_src = self::get_post_meta('video_upload');

			global $shortcode_tags;
			$func = $shortcode_tags['video'];
			$atts = array(
				'mp4'    => $video_src,
				'webm'   => $video_webm,
				'ogg'    => $video_ogg,
				'poster' => $video_poster,
				'width'  => '',
				'height' => '',

			);
			echo call_user_func($func, $atts);
		} elseif ('embed' === $video_mode) {
			$link = self::get_post_meta('video_embed');
			global $wp_embed;
			echo balanceTags($wp_embed->run_shortcode('[embed]' . esc_url($link) . '[/embed]'));
		} else {
			$video_custom = self::get_post_meta('video_custom');
			if (strpos($video_custom, 'embed') !== false) {
				global $wp_embed;
				echo balanceTags($wp_embed->run_shortcode(self::get_post_meta('video_custom')));
			} else {
				if( method_exists( 'zorbix_sc', 'esc_shortcode_tag' ) ) {
					echo do_shortcode(zorbix_sc::esc_shortcode_tag($video_custom));
				}
			}
		}

		echo '</div>';

	}

	public static function pagination()
	{
		global $wp_query;
		$bignum = 999999999;
		if ($wp_query->max_num_pages <= 1) {
			return;
		}

		echo '<nav class="pagination clearfix">';

		if (is_rtl()) {
			$prev_arrow = 'fa-chevron-right';
			$next_arrow = 'fa-chevron-left';
		} else {
			$prev_arrow = 'fa-chevron-left';
			$next_arrow = 'fa fa-chevron-right';
		}

		echo paginate_links(array(
				'base'      => esc_url(str_replace($bignum, '%#%', get_pagenum_link($bignum))),
				'format'    => '',
				'current'   => max(1, get_query_var('paged')),
				'total'     => esc_html($wp_query->max_num_pages),
				'prev_text' => '<i class="fa ' . esc_attr($prev_arrow) . '"></i>',
				'next_text' => '<i class="fa ' . esc_attr($next_arrow) . '"></i>',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		);

		echo '</nav>';
	}

	public static function format_comments($comment, $args, $depth)
	{
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ('div' === $args['style']) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo tag_escape($tag) ?> <?php comment_class(empty($args['has_children']) ? ''
		: 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ('div' !== $args['style']) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>

		<!-- Comment Avatar -->
		<div class="comment-avatar">
			<?php if ($args['avatar_size'] !== 0) {
				echo get_avatar($comment, $args['avatar_size']);
			} ?>
		</div>

		<div class="comment-content">

		<!-- Comment Author -->
		<?php printf('<h5 class="comment-author">%s</h5>', get_comment_author_link()); ?>

		<!-- Awaiting Modification Message -->
		<?php if ($comment->comment_approved === '0') : ?>
		<em class="comment-awaiting-moderation">
			<?php esc_html_e('Your comment is awaiting moderation.', 'pixo'); ?>
		</em>
	<?php endif; ?>

		<!-- Comment Meta -->
		<span class="comment-meta commentmetadata">
					<?php
					/* translators: 1: date, 2: time */
					printf(esc_html__('%1$s at %2$s', 'pixo'),
						get_comment_date(),
						get_comment_time()
					);
					edit_comment_link(esc_html__('(Edit)&#x200E;', 'pixo'),
						'  ',
						'');
					?>
				</span>

		<!-- Comment Text -->
		<div class="comment-text"><?php comment_text(); ?></div>

		<!-- comment Reply  -->
		<div class="reply">
			<?php comment_reply_link(array_merge($args,
				array(
					'add_below' => $add_below,
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				))); ?>
		</div>
		<?php if ('div' !== $args['style']) : ?>
		</div>
		</div><!-- End .comment-content -->
	<?php endif; ?>
		<?php
	}

	/**
	 * Removes the first gallery in a post
	 */
	public static function remove_first_gallery()
	{
		add_filter('post_gallery', array('zorbix_blog', 'remove_the_first_gallery_filter'));
	}

	public static function get_gallery_attachments()
	{
		global $post;

		$post_content = $post->post_content;
		preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);
		if (isset($ids[1])) {
			$images_id = explode(',', $ids[1]);
			return $images_id;
		}

	}

	public static function remove_the_first_gallery_filter($output)
	{
		$test = remove_filter('post_gallery', 'remove_the_first_gallery');

		$output = '<!-- gallery 1 was here -->';   // Must be non-empty.

		return $output;
	}

	public static function get_thumb_src($size)
	{
		$img = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);
		echo esc_url($img[0]);
	}

} // End Class

add_action('wp_loaded', array('zorbix_blog', 'get_instance'));
