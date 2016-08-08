<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>


	<div class="full-page-container not-found <?php echo esc_attr(zorbix_helper::get_option('not-found-tint')) ?>">

		<div class="contents">
			<div>

				<h1 class="heading">
					<?php echo esc_html(zorbix_helper::get_option_or_default('not-found-heading')); ?>
				</h1>

				<h2 class="sub-heading">
					<?php echo esc_html(zorbix_helper::get_option_or_default('404-sub-heading')); ?>
				</h2>


				<p>
					<?php echo esc_html(zorbix_helper::get_option_or_default('404_paragraph_text') ); ?>
				</p>

				<div class="dash"></div>

				<a class='btn' href="<?php echo esc_url( home_url() ) ?>">
					<?php echo esc_html(zorbix_helper::get_option_or_default('404_btn_text')); ?>
				</a>

				<?php //get_search_form(); ?>

			</div>
		</div>

	</div>

<?php
get_footer();
