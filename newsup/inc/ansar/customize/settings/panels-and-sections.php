<?php
// Add About Theme
$wp_customize->add_section('theme_info_panel',
    array(
        'title' => __('About Theme', 'newsup'),
        'priority' => 19,
    )
);

// Panel Header Options
$wp_customize->add_panel( 'header_option_panel' , array(
    'title' => __('Header Options', 'newsup'),
    'priority' => 20,
) );
    // Section Date & Time
    $wp_customize->add_section('date_time_section',
        array(
            'title' => __('Date & Time', 'newsup'),
            'panel' => 'header_option_panel',
        )
    );
    // Section Social Icon
    $wp_customize->add_section('header_social_icon_section',
        array(
            'title' => __('Social Icon', 'newsup'),
            'panel' => 'header_option_panel',
        )
    );
    // Advertisement Section.
    $wp_customize->add_section('frontpage_advertisement_settings',
        array(
            'title' => __('Banner Advertisement', 'newsup'),
            'panel' => 'header_option_panel',
        )
    );
    // Header Image
    $wp_customize->get_section('header_image')->panel = 'header_option_panel';