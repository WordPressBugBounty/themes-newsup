<?php

//Header Background Overlay 
$wp_customize->add_setting(
    'newsup_header_overlay_color', 
    array( 
        'sanitize_callback' => 'newsup_alpha_color_custom_sanitization_callback',
        'default' => 'rgba(32,47,91,0.4)',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Customize_Alpha_Color_Control( $wp_customize,'newsup_header_overlay_color', array(
        'label'      => __('Overlay Color', 'newsup' ),
        'palette' => true,
        'section' => 'header_image',
        'active_callback' => 'newsup_header_image_overlay_status',
    )
) );

$wp_customize->add_setting('remove_header_image_overlay',
    array(
        'default'           => $newsup_default['remove_header_image_overlay'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control('remove_header_image_overlay',
    array(
        'label'    => __('Remove Image Overlay', 'newsup'),
        'section'  => 'header_image',
        'type'     => 'checkbox',
        'priority' => 50,
    )
);