<?php

include ZORBIX_PLUGIN_CPT_CLASSES_DIR . 'cuztom.class.php';
include ZORBIX_PLUGIN_CPT_CLASSES_DIR . 'taxonomy.class.php';
include ZORBIX_PLUGIN_CPT_CLASSES_DIR . 'post_type.class.php';
include ZORBIX_PLUGIN_CLASSES_DIR . 'zorbix_cpt.class.php';


add_filter('images_cpt', 'zorbix_image_cpt');
function zorbix_image_cpt()
{
	$cpts = array('page', 'project');
	return $cpts;
}

// Testimonial CPT
$zorbix_new_cpt = new Zorbix_CPT('Testimonial', array('supports' => array('title', 'thumbnail')));
$zorbix_new_cpt->add_taxonomy('Testimonial Slider');
$zorbix_new_cpt->add_column(array('category'));

// Post Type
$zorbix_cpt = new Zorbix_CPT(
	get_theme_mod('portfolio_custom_post_type', esc_html__('Project', 'pixo')),
	array('supports' => array('title', 'thumbnail', 'editor'))
);
$zorbix_cpt->add_taxonomy('Portfolio');
$zorbix_cpt->add_column(array('thumbnail', 'category'));

