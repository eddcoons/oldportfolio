<?php defined( 'ABSPATH' ) || die; ?>
<?php if ( get_theme_mod('meta_date') ) : ?>
	<a href="<?php the_permalink() ?>" class="post-date">
		<div class="day"><?php the_time( 'd' ); ?></div>
		<div class="month"><?php the_time( 'M' ); ?></div>
	</a>
<?php endif;