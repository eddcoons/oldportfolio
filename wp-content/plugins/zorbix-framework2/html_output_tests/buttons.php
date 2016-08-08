<?php ob_start(); ?>
	[button heading="Extra Small" size="btn-xs" style="btn-default" margin="0 0 20px 0" icon_fontawesome="fa-glass" ]
	[button heading="Extra Small" size="btn-xs" style="btn-default" margin="0 0 20px 0" icon_fontawesome="" ]
	[button heading="Extra Small" block="true" size="btn-xs" style="btn-default" margin="0 0 20px 0" icon_fontawesome="" center_text="true"]

<?php echo( do_shortcode( ob_get_clean() ) );