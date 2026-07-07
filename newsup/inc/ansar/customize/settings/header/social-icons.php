<?php

// section title
$wp_customize->add_setting('header_social_icon_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'header_social_icon_title',
        array(
            'label' => esc_html__('Social Icon', 'newsup'),
            'section' => 'header_social_icon_section',
        )
    )
);
$wp_customize->add_setting('header_social_icon_enable',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'header_social_icon_enable', 
    array(
        'label' => esc_html__('Hide/Show', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
// Soical facebook link
$wp_customize->add_setting(
    'newsup_header_fb_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_fb_link',
    array(
        'label' => __('Facebook URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_header_fb_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_header_fb_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
//Social Twitter link
$wp_customize->add_setting(
    'newsup_header_twt_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_twt_link',
    array(
        'label' => __('Twitter URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_header_twt_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_header_twt_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
//Soical Linkedin link
$wp_customize->add_setting(
    'newsup_header_lnkd_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_lnkd_link',
    array(
        'label' => __('Linkedin URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_header_lnkd_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_header_lnkd_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
//Soical Instagram link
$wp_customize->add_setting(
    'newsup_header_insta_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_insta_link',
    array(
        'label' => __('Instagram URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_insta_insta_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_insta_insta_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
//Soical youtube link
$wp_customize->add_setting(
    'newsup_header_youtube_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_youtube_link',
    array(
        'label' => __('Youtube URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_header_youtube_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_header_youtube_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
//Soical Pintrest link
$wp_customize->add_setting(
    'newsup_header_pintrest_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_pintrest_link',
    array(
        'label' => __('Pintrest URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_header_pintrest_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_header_pintrest_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));
//Soical Telegram link
$wp_customize->add_setting(
    'newsup_header_tele_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_header_tele_link',
    array(
        'label' => __('Telegram URL','newsup'),
        'section' => 'header_social_icon_section',
        'type' => 'url',
    )
);
$wp_customize->add_setting('newsup_header_tele_target',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_header_tele_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'header_social_icon_section',
    )
));