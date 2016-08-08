<?php
add_shortcode('flipping-circle', 'zorbix_flipping_circle');
function zorbix_flipping_circle($atts, $content = null)
{

	$default_atts = array(
		'image_id' => '',
	);
	$default_atts = zorbix_sc::get_attr_set($default_atts, array('margin', 'padding'));
	$atts = shortcode_atts($default_atts, $atts);
	$img = zorbix_img::get_src_from_id($atts['image_id'], 'pixo_200_square', true);

	$output
		= '<div class="feature-shape-wrap" >
                <div class="feature-circle" >
                    <img class="create-svg" src="' . esc_attr($img) . '" data-clip="#circle_mask" alt="feature">
                </div ><!-- / .feature - circle-->
                <div class="circle-info">
                    <div class="text">' . zorbix_do_sc_autop($content) . '</div>
                </div>
            </div ><!-- / .feature-shape-wrap-->';

	return $output;
}