<?php
/*
 Template Name: Page With Children
 */

get_header(); ?>

<!--<div class="page-wrap --><?php //Zorbix_Helper::classes( 'wrapper' ) ?><!--">-->

<?php
// If using the side menu, we want the top bar in the page wrap
if ( true === zorbix_helper::get_option( 'enable_top_bar' ) && 'left-side-menu' === zorbix_helper::get_option( 'menu_type' )) {
	get_template_part( 'top-bar' );
} ?>


<?php

query_posts( array('showposts' => 20, 'post_parent' => get_the_ID(), 'post_type' => 'page', 'orderby' => 'menu_order', 'order' => 'ASC'));

if ( have_posts() ) { while ( have_posts() ) : the_post();

	the_content();

//echo get_the_content();

endwhile; };

//echo '</div>';r

get_footer();
