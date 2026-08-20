<?php /*** Option Panel
 *
 * @package Newsup
 */

$newsup_default = newsup_get_default_theme_options();
/*theme option panel info*/
require get_template_directory() . '/inc/ansar/customize/frontpage-options.php';

/**
 * Layout options section
 *
 * @package newsup
 */


$wp_customize->add_setting('you_missed_enable',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => $selective_refresh
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'you_missed_enable', 
    array(
        'label' => esc_html__('Hide / Show You Missed Section', 'newsup'),
        'type' => 'toggle',
        'section' => 'you_missed_section',
    )
));
// You Misses Title
$wp_customize->add_setting(
'you_missed_title',
    array(
        'default' => esc_html__('You Missed','newsup'),
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => $selective_refresh
    )
);
$wp_customize->add_control(
'you_missed_title',
    array(
        'label' => __('Title','newsup'),
        'section' => 'you_missed_section',
        'type' => 'text',
    )
);

function newsup_header_info_sanitize_text( $input ) {

    return wp_kses_post( force_balance_tags( $input ) );

}
if ( ! function_exists( 'newsup_sanitize_text_content' ) ) :
    /**
     * Sanitize text content.
     *
     * @since 1.0.0
     *
     * @param string               $input Content to be sanitized.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return string Sanitized content.
     */
    function newsup_sanitize_text_content( $input, $setting ) {

        return ( stripslashes( wp_filter_post_kses( addslashes( $input ) ) ) );

    }
endif; 
function newsup_header_sanitize_checkbox( $input ) {
    // Boolean check 
    return ( ( isset( $input ) && true == $input ) ? true : false );
    
}