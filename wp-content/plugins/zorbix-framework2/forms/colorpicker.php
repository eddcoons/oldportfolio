<?php
// Color Picker
$class = $type . ' color-picker';
printf('<input id="%s" class="%s" type="text" name="%s" value="%s">',
	esc_attr($param_name),
	esc_attr($class),
	esc_attr($param_name),
	esc_attr($preset_value_for_field)
); ?>