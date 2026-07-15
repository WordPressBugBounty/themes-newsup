<?php

$wp_customize->add_setting('newsup_page_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_page_heading',
        array(
            'label' => esc_html__('Page', 'newsup'),
            'section' => 'pages_section',

        )
    )
);
$wp_customize->add_setting(
    'newsup_page_layout', array(
    'default'           => 'page-align-content-right',
    'sanitize_callback' => 'newsup_sanitize_radio',
    'transport' => 'postMessage',
) );
$wp_customize->add_control(
    new Newsup_Radio_Image_Control( 
        // $wp_customize object
        $wp_customize,
        // $id
        'newsup_page_layout',
        // $args
        array(
            'settings' => 'newsup_page_layout',
            'section'  => 'pages_section',
            'label'    => __( '', 'newsup' ),
            'choices'  => array(
                'page-align-content-left' => get_template_directory_uri() . '/images/fullwidth-left-sidebar.png',
                'page-full-width-content' => get_template_directory_uri() . '/images/fullwidth.png',
                'page-align-content-right'=> get_template_directory_uri() . '/images/right-sidebar.png',
            )
        )
    )
);
