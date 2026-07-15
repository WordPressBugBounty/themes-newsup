<?php
$wp_customize->add_setting('newsup_archive_page_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_archive_page_heading',
        array(
            'label' => esc_html__('Blog/Archive', 'newsup'),
            'section' => 'blog_section',

        )
    )
);
$wp_customize->add_setting(
    'newsup_content_layout', array(
    'default'           => 'align-content-right',
    'sanitize_callback' => 'newsup_sanitize_radio',
    'transport' => 'postMessage',
) );
$wp_customize->add_control(
    new Newsup_Radio_Image_Control( 
        // $wp_customize object
        $wp_customize,
        // $id
        'newsup_content_layout',
        // $args
        array(
            'settings'      => 'newsup_content_layout',
            'section'       => 'blog_section',
            'label'         => __( '', 'newsup' ),
            'choices'       => array(
                'align-content-left' => get_template_directory_uri() . '/images/fullwidth-left-sidebar.png',  
                'full-width-content'    => get_template_directory_uri() . '/images/fullwidth.png',
                'align-content-right'    => get_template_directory_uri() . '/images/right-sidebar.png',
                'grid-left-sidebar' => get_template_directory_uri() . '/images/grid-left-sidebar.png',
                'grid-fullwidth' => get_template_directory_uri() . '/images/grid-fullwidth.png',
                'grid-right-sidebar' => get_template_directory_uri() . '/images/grid-right-sidebar.png',
            )
        )
    )
);