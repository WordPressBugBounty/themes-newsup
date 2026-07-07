<?php
$newsup_default = newsup_get_default_theme_options();
// Setting banner_advertisement_section.
$wp_customize->add_setting('banner_advertisement_section',
    array(
        'default' => $newsup_default['banner_advertisement_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage'
    )
);
$wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control($wp_customize, 'banner_advertisement_section',
        array(
            'label' => __('Banner Section Advertisement', 'newsup'),
            'description' => sprintf(__('Recommended Size %1$s px X %2$s px', 'newsup'), 930, 100),
            'section' => 'frontpage_advertisement_settings',
            'width' => 930,
            'height' => 100,
            'flex_width' => true,
            'flex_height' => true,
            'priority' => 120,
        )
    )
);
/*banner_advertisement_section_url*/
$wp_customize->add_setting('banner_advertisement_section_url',
    array(
        'default' => $newsup_default['banner_advertisement_section_url'],
        'capability' => 'edit_theme_options',
        'transport' => 'postMessage',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('banner_advertisement_section_url',
    array(
        'label' => __('URL Link', 'newsup'),
        'section' => 'frontpage_advertisement_settings',
        'type' => 'url',
        'priority' => 130,
    )
);
$wp_customize->add_setting('newsup_open_on_new_tab',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_open_on_new_tab', 
    array(
        'label' => __('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'frontpage_advertisement_settings',
        'priority' => 140,
    )
)); 