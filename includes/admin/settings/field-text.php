<?php
if( !defined( 'ABSPATH' ) ) die();
if( empty( $args ) ) return;

//Get the existing options
$settings = self::megacal_get_settings();
$default = !empty( $default ) ? $default : '';
$placeholder = !empty( $placeholder ) ? $placeholder : '';
?>

<input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
	name="megacal_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
	value="<?php echo !empty( $settings[$args['label_for']] ) ? esc_attr( $settings[$args['label_for']] ) : esc_attr( $default ); ?>"
	<?php echo !empty( $placeholder ) ? 'placeholder="' . esc_attr( $placeholder ) . '"' : ''; ?> />