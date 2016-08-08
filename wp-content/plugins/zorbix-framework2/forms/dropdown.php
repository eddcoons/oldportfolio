<select name="<?php echo esc_attr( $param_name ) ?>" class="<?php echo esc_attr( $type ) ?>">
	<?php if ( is_array( $options ) ) : foreach ( $options as $option_label => $option_value ) :
		$selected = ( trim($preset_value_for_field) === trim($option_value) ) ? 'selected' : '';

		printf( '<option value="%s" %s>%s</option>',
			esc_attr( $option_value ),
			esc_attr( $selected ),
			esc_attr( $option_label )
		);
	endforeach; endif; ?>
</select>
