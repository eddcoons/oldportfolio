<?php ob_start(); ?>

	[zbx-gallery columns="col-md-6" images="3180,3177,3176,3175,3174" zbx-media-btn="Upload" port_height="pixo_400_square" padding_bottom="40"][/zbx-gallery]

<?php echo( do_shortcode( ob_get_clean() ) );