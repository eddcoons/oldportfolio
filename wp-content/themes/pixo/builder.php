<?php
/*
 * Template Name: Builder
 * For use with the page builder
 */

get_header();

if ( have_posts() ) { while ( have_posts() ) : the_post();

	the_content();

endwhile; };

get_footer();
