<div class="top-bar">
	<div class="container">

		<?php if ( is_active_sidebar( 'top-menu-widgets-left' ) ) : ?>
			<div class="info info-left">
				<?php dynamic_sidebar( 'top-menu-widgets-left' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'top-menu-widgets-right' ) ) : ?>
			<div class="info info-right">
				<?php dynamic_sidebar( 'top-menu-widgets-right' ); ?>
			</div>
		<?php endif; ?>

		<!-- SOCIAL ICONS -->
		<?php if ( is_array( zorbix_helper::get_option( 'header_social' ) ) ) : ?>
			<div class="social-icons">
				<?php foreach (zorbix_helper::get_option( 'header_social' ) as $pixo_key => $pixo_value ) : ?>
					<a href="<?php echo esc_url( zorbix_helper::get_option( 'social_'
					                                                        . $pixo_value ) ) ?>"><i
							class="fa fa-<?php echo esc_attr( $pixo_value ) ?>"></i></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div>