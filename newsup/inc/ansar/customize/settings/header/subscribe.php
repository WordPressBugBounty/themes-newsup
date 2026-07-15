<?php

$wp_customize->add_setting('newsup_subscribe_icon_setting',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_subscribe_icon_setting',
        array(
            'label' => esc_html__('Subscribe', 'newsup'),
            'section' => 'header_subscribe_section',

        )
    )
);
$wp_customize->add_setting('header_subsc_enable',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'header_subsc_enable', 
    array(
        'label' => esc_html__('Hide/Show', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_subscribe_section',
    )
));
// subsc link
$wp_customize->add_setting(
    'newsup_subsc_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_subsc_link',
    array(
        'label' => __('Link','newsup'),
        'section' => 'header_subscribe_section',
        'type' => 'text',
    )
);
// subsc target
$wp_customize->add_setting('newsup_subsc_link_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_subsc_link_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_subscribe_section',
    )
));