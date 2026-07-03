<?php

$wp_customize->get_setting('custom_logo')->sanitize_callback  = 'esc_url_raw';
$wp_customize->get_setting('custom_logo')->transport  = 'postMessage';
$wp_customize->get_setting('blogname')->transport         = 'postMessage';
$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

$wp_customize->get_control( 'header_textcolor')->section = 'title_tagline';
$wp_customize->get_control( 'display_header_text')->label = __('Display Site Title', 'newsup');

$wp_customize->add_setting('display_header_tagline',
    array(
        'default' => false,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control('display_header_tagline',
    array(
        'label' => __('Display Tagline', 'newsup'),
        'section' => 'title_tagline',
        'type' => 'checkbox',
        'priority' => 50,

    )
);
/*--- Site title Font size **/
$wp_customize->add_setting('newsup_title_font_size',
    array(
        'default'           => 34,
        'capability'        => 'edit_theme_options',
        'transport'        	=> 'postMessage',
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control('newsup_title_font_size',
    array(
        'label'    => __('Site Title Size', 'newsup'),
        'section'  => 'title_tagline',
        'type'     => 'number',
        'priority' => 50,
    )
);

$wp_customize->add_setting('newsup_center_logo_title',
    array(
        'default' => false,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control('newsup_center_logo_title',
    array(
        'label' => __('Display Center Site Title and Tagline', 'newsup'),
        'section' => 'title_tagline',
        'type' => 'checkbox',
        'priority' => 55,

    )
);