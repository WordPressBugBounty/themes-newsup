<?php
// section title
$wp_customize->add_setting('header_data_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'header_data_title',
        array(
            'label' => esc_html__('Date & Time', 'newsup'),
            'section' => 'date_time_section',
        )
    )
);
$wp_customize->add_setting('header_data_enable',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'header_data_enable', 
    array(
        'label' => esc_html__('Hide / Show Date', 'newsup'),
        'type' => 'toggle',
        'section' => 'date_time_section',
    )
));
$wp_customize->add_setting('header_time_enable',
    array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'header_time_enable', 
    array(
        'label' => esc_html__('Hide / Show Time', 'newsup'),
        'type' => 'toggle',
        'section' => 'date_time_section',
    )
));
// date in header display type
$wp_customize->add_setting( 'newsup_date_time_show_type', array(
    'default'           => 'newsup_default',
    'capability'        => 'edit_theme_options',
    'transport' => 'postMessage',
    'sanitize_callback' => 'newsup_sanitize_select',
) );
$wp_customize->add_control( 'newsup_date_time_show_type', array(
    'type'     => 'radio',
    'label'    => esc_html__( 'Date / Time in header display type:', 'newsup' ),
    'choices'  => array(
        'newsup_default'          => esc_html__( 'Theme Default Setting', 'newsup' ),
        'wordpress_date_setting' => esc_html__( 'From WordPress Setting', 'newsup' ),
    ),
    'section'  => 'date_time_section',
    'settings' => 'newsup_date_time_show_type',
) );