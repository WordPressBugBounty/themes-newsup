<?php

// Add About Theme
$wp_customize->add_section('theme_info_panel',
    array(
        'title' => __('About Theme', 'newsup'),
        'priority' => 10,
    )
);
    $wp_customize->add_setting( 'theme_docs_info', array(
        'sanitize_callback' => 'esc_attr'
    ) );
    $wp_customize->add_control( new Newsup_Info_Box_Control( $wp_customize, 'theme_docs_info', array(
        'label'           => __( 'Theme Documentation', 'newsup' ),
        'section'         => 'theme_info_panel',
        'features'        => '',
        'url'         => 'https://docs.themeansar.com/docs/newsup-lite/',
        'btn_text' => __( 'View Documentation', 'newsup' )
    ) ) );
    $wp_customize->add_setting( 'theme_support_info', array(
        'sanitize_callback' => 'esc_attr'
    ) );
    $wp_customize->add_control( new Newsup_Info_Box_Control( $wp_customize, 'theme_support_info', array(
        'label'           => __( 'Theme Support', 'newsup' ),
        'section'         => 'theme_info_panel',
        'features'        => '',
        'url'         => 'https://themeansar.ticksy.com/',
        'btn_text' => __( 'Support Form', 'newsup' )
    ) ) );