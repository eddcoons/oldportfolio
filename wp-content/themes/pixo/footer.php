<?php
if ( 'on' === zorbix_helper::get_mb_or_option('footer_show')) : ?>

	<footer id="footer" class="footer">
		<div class="container">
			<?php if (is_active_sidebar('footer-widgets')) : ?>
				<div class="footer-widgets">
					<?php dynamic_sidebar('footer-widgets'); ?>
				</div>
			<?php endif; ?>

			<?php // Contact Info
			$pixo_contact_info = zorbix_helper::get_contact_info();
			$pixo_footer_settings = zorbix_helper::get_footer_settings();

			if (is_array($pixo_contact_info)) :
				printf('<div class="contact-info container cols-centered %s" %s>',
					esc_attr($pixo_footer_settings['footer_animate']),
					zorbix_esc_get_div_att('data-animate', $pixo_footer_settings['footer_animate_data_top'])
				);

				foreach ($pixo_contact_info as $text => $icon) : ?>
					<div class="col-sm-3 mb-20-sm">
						<i class="fa <?php echo esc_attr($icon) ?>" style="opacity: 1;"></i>

						<div><?php echo wp_kses_post(html_entity_decode($text)) // Needs to allow HTML ?></div>
					</div>
				<?php endforeach;
				echo '</div>';
			endif; ?>


			<hr>
			<!-- SOCIAL ICONS -->
			<?php


			if (zorbix_helper::get_option('footer_social')) :
				printf('<div class="social-icons %s" %s>',
					esc_attr($pixo_footer_settings['footer_animate']),
					zorbix_esc_get_div_att('data-animate', $pixo_footer_settings['footer_animate_data_bottom'])
				);

				foreach (zorbix_helper::get_option('footer_social') as $pixo_key => $pixo_value) : ?>
					<a href="<?php echo esc_url(zorbix_helper::get_option( 'social_' . $pixo_value)) ?>"><i
							class="fa fa-<?php echo esc_attr($pixo_value) ?>"></i></a>
				<?php endforeach;
				echo '</div>';
			endif; ?>

			<div class="copy">
				<?php echo str_replace('&amp;copy;', '&copy;', esc_html(zorbix_helper::get_option_or_default('footer_copy'))) ?>
			</div>
		</div>
	</footer>
<?php endif; ?>

<?php if ( 'on' === zorbix_helper::get_option_or_default('enable_backtotop')) : ?>
	<a href="#" class="top-btn"><i class="fa fa-chevron-up"></i></a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
