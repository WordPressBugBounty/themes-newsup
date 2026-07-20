<?php
$wp_customize->add_setting('preloader_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'preloader_heading',
        array(
            'label' => esc_html__('Preloader', 'newsup'),
            'section' => 'newsup_preloader_settings',

        )
    )
);
// Hide/Show Preloader
$wp_customize->add_setting('preloader_enable', array(
    'default' => $newsup_default['preloader_enable'],
    'sanitize_callback' => 'newsup_sanitize_checkbox',
));
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'preloader_enable', 
    array(
        'label' => esc_html__('Hide/Show', 'newsup'),
        'type' => 'toggle',
        'section' => 'newsup_preloader_settings',
        
    )
));

// Setting preloader image.
$wp_customize->add_setting('preloader_image',
array(
    'default' => $newsup_default['preloader_image'],
    'capability' => 'edit_theme_options',
    'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'preloader_image',
        array(
            'label' => esc_html__('Image', 'newsup'),
            'section' => 'newsup_preloader_settings',
            'description' => sprintf(esc_html__('Recommended GIF & SVG', 'newsup'), 930, 100),
            'flex_width' => true,
            'flex_height' => true,
        )
    )
);