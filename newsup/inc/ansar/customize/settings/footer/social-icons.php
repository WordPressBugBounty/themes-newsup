<?php

// section title
$wp_customize->add_setting('footer_social_icon_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'footer_social_icon_title',
        array(
            'label' => esc_html__('Social Icon', 'newsup'),
            'section' => 'footer_social_icon_section',

        )
    )
);
//Enable and disable social icon
$wp_customize->add_setting('footer_social_icon_enable',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'footer_social_icon_enable', 
    array(
        'label' => esc_html__('Hide/Show', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
// Soical facebook link
$wp_customize->add_setting(
    'newsup_footer_fb_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_footer_fb_link',
    array(
        'label' => __('Facebook URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_fb_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_fb_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
//Social Twitter link
$wp_customize->add_setting(
    'newsup_footer_twt_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_footer_twt_link',
    array(
        'label' => __('Twitter URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_twt_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_twt_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
//Soical Linkedin link
$wp_customize->add_setting(
    'newsup_footer_lnkd_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
'newsup_footer_lnkd_link',
    array(
        'label' => __('Linkedin URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_lnkd_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_lnkd_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
//Soical Instagram link
$wp_customize->add_setting(
    'newsup_footer_insta_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_footer_insta_link',
    array(
        'label' => __('Instagram URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_insta_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_insta_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
//Soical Youtube link
$wp_customize->add_setting(
    'newsup_footer_youtube_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_footer_youtube_link',
    array(
        'label' => __('Youtube URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_youtube_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_youtube_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
//Soical Pintrest link
$wp_customize->add_setting(
    'newsup_footer_pinterest_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
    'newsup_footer_pinterest_link',
    array(
        'label' => __('Pinterest URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_pinterest_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_pinterest_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));
//Soical Telegram link
$wp_customize->add_setting(
'newsup_footer_tele_link',
    array(
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(
'newsup_footer_tele_link',
    array(
        'label' => __('Telegram URL','newsup'),
        'section' => 'footer_social_icon_section',
        'type' => 'text',
    )
);
$wp_customize->add_setting('newsup_footer_tele_target',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_social_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_footer_tele_target', 
    array(
        'label' => esc_html__('Open link in a new tab', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_social_icon_section',
    )
));