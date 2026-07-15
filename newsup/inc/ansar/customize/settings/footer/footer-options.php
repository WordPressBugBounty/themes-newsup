<?php

// section title
$wp_customize->add_setting('footer_options_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'footer_options_title',
        array(
            'label' => esc_html__('Footer Option', 'newsup'),
            'section' => 'footer_options',

        )
    )
);
//Footer Background image
$wp_customize->add_setting( 
    'newsup_footer_widget_background', array(
    'sanitize_callback' => 'esc_url_raw',
    'transport' => 'postMessage',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'newsup_footer_widget_background', array(
    'label'    => __( 'Background Image', 'newsup' ),
    'section'  => 'footer_options',
    'settings' => 'newsup_footer_widget_background',
) ) );
//Background Overlay 
$wp_customize->add_setting(
    'newsup_footer_overlay_color', array( 
        'sanitize_callback' => 'newsup_alpha_color_custom_sanitization_callback',
        'transport' => 'postMessage',
    ) 
);
$wp_customize->add_control(new Newsup_Customize_Alpha_Color_Control( $wp_customize,'newsup_footer_overlay_color', array(
    'label'      => __('Overlay Color', 'newsup' ),
    'palette' => true,
    'section' => 'footer_options')
) );
//Background Overlay 
$wp_customize->add_setting(
    'newsup_footer_text_color', array( 
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ) 
);
$wp_customize->add_control( 'newsup_footer_text_color', array(
    'label'      => __('Text Color', 'newsup' ),
    'type' => 'color',
    'section' => 'footer_options')
);
$wp_customize->add_setting(
    'newsup_footer_column_layout', array(
    'default' => 3,
    'transport' => 'postMessage',
    'sanitize_callback' => 'newsup_sanitize_select',
) );
$wp_customize->add_control(
    'newsup_footer_column_layout', array(
    'type' => 'select',
    'label' => __('Select Column Layout','newsup'),
    'section' => 'footer_options',
    'choices' => array(1=>1, 2=>2,3=>3,4=>4),
) );