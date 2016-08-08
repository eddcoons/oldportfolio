<div>
	<strong><?php esc_html_e('Note', 'pixo') ?>:</strong> <?php echo esc_html($description) ?>
	<?php isset($image) ? printf('<img src="%s"/>', esc_url($image)) : ''; ?>
</div>
