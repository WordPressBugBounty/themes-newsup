<?php
/**
 * Newsup Theme Customizer
 *
 * @package Newsup
 */

if (!function_exists('newsup_get_option')):
/**
 * Get theme option.
 *
 * @since 1.0.0
 *
 * @param string $key Option key.
 * @return mixed Option value.
 */
function newsup_get_option($key) {

	if (empty($key)) {
		return;
	}

	$value = '';

	$default       = newsup_get_default_theme_options();
	$default_value = null;

	if (is_array($default) && isset($default[$key])) {
		$default_value = $default[$key];
	}

	if (null !== $default_value) {
		$value = get_theme_mod($key, $default_value);
	} else {
		$value = get_theme_mod($key);
	}

	return $value;
}
endif;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function newsup_customize_register($wp_customize) {


    

    $default = newsup_get_default_theme_options();

    $selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	/*theme option panel info*/
	require get_template_directory().'/inc/ansar/customize/theme-options.php';

}
add_action('customize_register', 'newsup_customize_register');


/************************* Related Post Callback function *********************************/

function newsup_rt_post_callback ( $control ) 
{
	if( true == $control->manager->get_setting ('newsup_enable_related_post')->value()){
		return true;
	}
	else {
		return false;
	}       
}