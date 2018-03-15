<?php
// Add new input type "colorpicker"
if ( function_exists('smile_add_input_type'))
{
	smile_add_input_type('colorpicker' , 'color_picker_settings_field' );
}
add_action( 'admin_enqueue_scripts', 'framework_color_picker_admin_styles' );

function framework_color_picker_admin_styles($hook){
	$cp_page = strpos( $hook, CP_PLUS_SLUG );	
	$data  =  get_option( 'convert_plug_debug' );

	if( $cp_page !== false && ( isset( $data['cp-dev-mode'] ) && $data['cp-dev-mode'] == '1' )  && isset( $_GET['style-view'] ) && ( $_GET['style-view'] == "edit" || $_GET['style-view'] == "variant" ) ) {
		wp_enqueue_script( 'smile-colorpicker-script', SMILE_FRAMEWORK_URI . '/lib/fields/colorpicker/cp-color-picker.min.js', array(), '1.0.0', true );
		wp_enqueue_style( 'smile-colorpicker-style', SMILE_FRAMEWORK_URI . '/lib/fields/colorpicker/cp-color-picker.min.css');
	}
}

/**
* Function to handle new input type "colorpicker"
*
* @param $settings		- settings provided when using the input type "colorpicker"
* @param $value			- holds the default / updated value
* @return string/html 	- html output generated by the function
*/
function color_picker_settings_field($name, $settings, $value)
{
	$input_name = $name;
	$type = isset($settings['type']) ? $settings['type'] : '';
	$class = isset($settings['class']) ? $settings['class'] : '';

	//	Apply partials
	$partials =	generate_partial_atts( $settings );

	$output = '<p><input type="text" id="smile_'.$input_name.'" data-default-color="'.$value.'" class="cs-wp-color-picker smile-input smile-'.$type.' '.$input_name.' '.$type.' '.$class.'" name="' . $input_name . '" value="'.$value.'" '.$partials .' /></p>';

	return $output;
}
