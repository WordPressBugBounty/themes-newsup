<?php

$wp_customize->add_setting('newsup_search_icon_setting',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_search_icon_setting',
        array(
            'label' => esc_html__('Search', 'newsup'),
            'section' => 'header_search_section',

        )
    )
);
$wp_customize->add_setting('header_search_enable',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'header_search_enable', 
    array(
        'label' => esc_html__('Hide / Show Search', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_search_section',
    )
));