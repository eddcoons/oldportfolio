<?php

get_header();

$post_id = get_queried_object()->ID;
$terms   = get_the_terms( $post_id, 'testimonial_slider' );
$term    = ( $terms[0] ) ? $terms[0]->name : '';
ob_start();
?>

	[section type="sect" container=true center_text=true]
		[testimonials order="" terms="<?php echo esc_attr( $term ) ?>"]
	[/section]

<?php
echo do_shortcode( ob_get_clean() );
get_footer();
