<?php
// Add About Theme
$wp_customize->add_section('theme_info_panel',
    array(
        'title' => __('About Theme', 'newsup'),
        'priority' => 19,
    )
);

// Add Theme Options Panel.
$wp_customize->add_panel('global_panel',
    array(
        'title' => esc_html__('Global', 'newsup'),
        'priority' => 20,
    )
); 
    // Header Image
    $wp_customize->get_section('title_tagline')->panel = 'global_panel';

    // Post Image Settings
    $wp_customize->add_section( 'post_image_options' , array(
        'title' => __('Post Image Settings', 'newsup'),
        'panel' => 'global_panel',
    ) );
    // Post Meta
    $wp_customize->add_section('site_post_date_author_settings',
        array(
            'title' => esc_html__('Post Meta', 'newsup'),
            'panel' => 'global_panel',
        )
    );
    // Top to Bottom Scroller
    $wp_customize->add_section('scroller_section',
        array(
            'title' => esc_html__('Top to Bottom Scroller', 'newsup'),
            'panel' => 'global_panel',
        )
    );
    // You Missed
    $wp_customize->add_section('you_missed_section',
        array(
            'title' => esc_html__('You Missed Section', 'newsup'),
            'panel' => 'global_panel',
        )
    );
// Panel Header Options
$wp_customize->add_panel( 'header_option_panel' , array(
    'title' => __('Header Options', 'newsup'),
    'priority' => 20,
) );
    // Header Image
    $wp_customize->get_section('header_image')->panel = 'header_option_panel';
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
    // Advertisement Section.
    $wp_customize->add_section('header_search_section',
        array(
            'title' => __('Search', 'newsup'),
            'panel' => 'header_option_panel',
        )
    );
    // Advertisement Section.
    $wp_customize->add_section('header_subscribe_section',
        array(
            'title' => __('Subscribe', 'newsup'),
            'panel' => 'header_option_panel',
        )
    );

// Add Frontpage Options Panel.
$wp_customize->add_panel('frontpage_option_panel',
    array(
        'title' => __('Frontpage Options', 'newsup'),
        'priority' => 20,
        'capability' => 'edit_theme_options',
    )
);
// Panel page Options
$wp_customize->add_panel( 'page_option_panel' , array(
    'title' => __('Templates', 'newsup'),
    'priority' => 20,
) );
    // blog-archive.
    $wp_customize->add_section('blog_section', array(
        'title' => __('Blog/Archive','newsup'),
        'panel' => 'page_option_panel',
    ) );
    // Single Post
    $wp_customize->add_section('site_single_posts_settings', array(
        'title' => __('Single Post','newsup'),
        'panel' => 'page_option_panel',
    ) );
    // Pages
    $wp_customize->add_section('pages_section', array(
        'title' => __('Page Settings','newsup'),
        'panel' => 'page_option_panel',
    ) );
    
// Panel footer Options
$wp_customize->add_panel( 'footer_option_panel' , array(
    'title' => __('Footer Options', 'newsup'),
    'priority' => 20,
) );
    // Footer Section.
    $wp_customize->add_section('footer_options', array(
        'title' => __('Footer Options','newsup'),
        'panel' => 'footer_option_panel',
    ) );
    // Section Social Icon
    $wp_customize->add_section('footer_social_icon_section',
        array(
            'title' => __('Social Icon', 'newsup'),
            'panel' => 'footer_option_panel',
        )
    );
    // Section Menus
    $wp_customize->add_section('footer_menu_section',
        array(
            'title' => __('Footer Menu', 'newsup'),
            'panel' => 'footer_option_panel',
        )
    );