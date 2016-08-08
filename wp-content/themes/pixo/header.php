<?php
/*

 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head <?php language_attributes(); ?>>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<?php  // FALLBACK FAVICONS ( not used on on 4.3+ )
	zorbix_helper::favicons_fallback(); ?>

	<?php
	wp_head(); ?>
</head>

<body <?php body_class( zorbix_helper::get_classes('body') ) ?> >

<!--<h1>--><?php // echo get_post_meta( get_the_ID(), 'page_padding', true ); ?><!--</h1>-->
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong>browser. Upgrade your browser to improve your
	experience.</p>
<![endif]-->

<?php if ( zorbix_helper::get_option( 'enable_preloader' ) ) : ?>
	<!-- Preloader -->
	<div class="preloader">
		<div class="sk-spinner sk-spinner-pulse">
			<div class="sk-rect1"></div>
			<div class="sk-rect2"></div>
			<div class="sk-rect3"></div>
			<div class="sk-rect4"></div>
			<div class="sk-rect5"></div>
		</div>
	</div><!-- End .preloader -->
<?php endif; ?>

<?php get_template_part( 'menu' ) ?>


