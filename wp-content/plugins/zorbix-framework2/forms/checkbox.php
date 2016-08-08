<?php
$checked = ('true' === $preset_value_for_field) ? 'checked' : '';
printf('<input id="%s" class="%s" type="checkbox" name="%s" value="true" %s>',
	esc_attr($param_name),
	esc_attr($type . ' cmn-toggle cmn-toggle-round-flat'),
	esc_attr($param_name),
	esc_attr($checked)
); ?>
<label for="<?php echo esc_attr($param_name) ?>"></label>