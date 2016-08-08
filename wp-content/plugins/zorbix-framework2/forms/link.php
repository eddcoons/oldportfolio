<?php
/* @var $param_name */
?>
<button class="btn <?php echo esc_attr( $type ) ?>" type="button" name="<?php echo esc_attr( $param_name . '_btn') ?>"
value="<?php echo esc_attr( $preset_value_for_field ) ?>"><?php echo esc_html__( 'Add Link', 'zorbix' ) ?></button>
<input name="<?php echo esc_attr( $param_name ) ?>" type='hidden' value="<?php echo esc_attr( $preset_value_for_field ) ?>">