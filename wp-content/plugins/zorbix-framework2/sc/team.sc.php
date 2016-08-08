<?php

add_shortcode('team', 'zorbix_team' );
function zorbix_team($atts, $content = null)
{

	$sc_name = 'team';
	$sets = array('makewhite', 'animation', 'icon');
	$default_atts = array(
		'name'  => '',
		'job'   => '',
		'image' => '',

		'facebook'    => '',
		'twitter'     => '',
		'behance'     => '',
		'delicious'   => '',
		'deviantart'  => '',
		'digg'        => '',
		'dribbble'    => '',
		'dropbox'     => '',
		'envelope'    => '',
		'flickr'      => '',
		'foursquare'  => '',
		'github'      => '',
		'google'      => '',
		'instagram'   => '',
		'linkedin'    => '',
		'pinterest'   => '',
		'reddit'      => '',
		'rss'         => '',
		'skype'       => '',
		'soundcloud'  => '',
		'stumbleupon' => '',
		'tumblr'      => '',
		'vimeo'       => '',
		'eddcoons_portfolio'   => '',
		'xing'        => '',
		'yahoo'       => '',
		'youtube'     => '',
	);

	$default_atts = zorbix_sc::get_attr_set($default_atts, $sets);
	$atts = zorbix_sc::shortcode_atts($default_atts, $atts, $sc_name);

	$class = '';

	ob_start(); ?>

	<div class="team-member <?php echo esc_attr($class) ?>">

		<?php zorbix_img::tag_from_id($atts['image'], ZORBIX_PREFIX . '400_square', true); ?>

		<div class="inner">
			<h2 class="name"><?php echo esc_html__($atts['name']) ?></h2>

			<h3 class="job"><?php echo esc_html__($atts['job']) ?></h3>

			<?php

			foreach (zorbix_sc::get_social_array() as $name) {
				if (!empty($atts[$name])) {
					printf('<a href="%s"><i class="zx-icon fa fa-%s"></i></a>',
						esc_url($atts[$name]),
						esc_attr($name)
					);
					echo "\n";
				}
			}
			?>
			<?php echo do_shortcode($content) ?>
		</div>

	</div>

	<?php return ob_get_clean();

}



