<?php defined('ABSPATH') || die;

$pixo_page_title['title'] = get_theme_mod('blog_title', zorbix_helper::get_default('blog_title'));

# Set the title depending on the page type
if (is_search()) {
	$pixo_page_title['title'] = zorbix_helper::get_option_or_default('blog_search_title') . ' ' . get_search_query();
} elseif (is_tag()) {
	$pixo_page_title['title'] = single_tag_title( zorbix_helper::get_option_or_default('blog_tag_title') . ' ', false);
} elseif (is_category()) {
	$pixo_page_title['title'] = single_cat_title( zorbix_helper::get_option_or_default('blog_category_title') . ' ', false);
} elseif (is_day()) {
	$pixo_page_title['title'] = zorbix_helper::get_option_or_default('blog_daily_archives_title') . ' ' . get_the_date();
} elseif (is_month()) {
	$pixo_page_title['title'] = zorbix_helper::get_option_or_default('blog_monthly_archives_title') . ' ' . get_the_date('F Y');
} elseif (is_year()) {
	$pixo_page_title['title'] = zorbix_helper::get_option_or_default('blog_yearly_archives_title') . ' ' . get_the_date('Y');
} elseif (is_author()) {
	$pixo_page_title['title'] = zorbix_helper::get_option_or_default('blog_author_archives_title') . ' ' . get_the_author();
}


# Display the page title
if ($pixo_page_title['title']) : ?>
	<div
		class="blog-heading sect bg-light-gray <?php echo esc_attr(zorbix_helper::join(get_theme_mod('blog_heading_tint'))) ?>">
		<div class="container">
			<h1 class="sectiono-title">
				<span><?php echo esc_html($pixo_page_title['title']) ?></span>
			</h1>
		</div>
	</div>
<?php endif; ?>
