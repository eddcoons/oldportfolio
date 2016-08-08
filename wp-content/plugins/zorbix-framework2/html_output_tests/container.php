<?php ob_start(); ?>
<!-- Container -->
[container]Adds a container and does do shortcode[/container]

<?php echo( do_shortcode( ob_get_clean() ) );