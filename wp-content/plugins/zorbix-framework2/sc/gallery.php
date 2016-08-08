<?php

# PORTFOLIO METABOXES


add_shortcode('zbx-gallery', 'zorbix_gallery');
function zorbix_gallery($atts)
{

	$default_atts = array(
		'columns'        => '
		',
		'port_height'    => 'pixo_400_square',
		'images'         => '',
		'padding'        => '',
		'padding_top'    => '',
		'padding_right'  => '',
		'padding_bottom' => '',
		'padding_left'   => '',
		'unique_id' => 'gallery',
		'ratio' => '',
	);

	# Set Attributes
	$atts = zorbix_sc::shortcode_atts($default_atts, $atts, 'gallery');

	# Get array of images
	$atts['images'] = explode(',', $atts['images']);

	# Generate HTML
	ob_start();

	# Start HTML
	printf('<div class="gallery %s" %s>',
	esc_attr($atts['ratio']),
		zorbix_sc::get_format_style_esc_multi(array(
			'padding'        => $atts['padding'],
			'padding-top'    => $atts['padding_top'],
			'padding-right'  => $atts['padding_right'],
			'padding-bottom' => $atts['padding_bottom'],
			'padding-left'   => $atts['padding_left'],
		))
	); ?>

	<?php if (is_array($atts['images'])) : foreach ($atts['images'] as $image_ID) :

	printf('<div class="item %s">', esc_attr($atts['columns']));

	printf('<a class="prettyPhoto" href="%s" data-pp="prettyPhoto[%s]" style="background-image: url(\'%s\')"></a>',
	esc_url( zorbix_img::get_src_from_id($image_ID ) ),
	esc_attr($atts['unique_id']),
	esc_url( zorbix_img::get_src_from_id($image_ID,$atts['port_height'] ) )
	); ?>


			</div >

		<?php endforeach; endif; ?>

	</div>

	<?php return ob_get_clean();
}
