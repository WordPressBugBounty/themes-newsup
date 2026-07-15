<?php

// Single Section.
$wp_customize->add_setting('newsup_single_page_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_single_page_heading',
        array(
            'label' => esc_html__('Single Post', 'newsup'),
            'section' => 'site_single_posts_settings',

        )
    )
);
$wp_customize->add_setting(
    'newsup_single_page_layout', array(
    'default'           => 'single-align-content-right',
    'sanitize_callback' => 'newsup_sanitize_radio',
    'transport' => 'postMessage',
) );
$wp_customize->add_control(
    new Newsup_Radio_Image_Control( 
        // $wp_customize object
        $wp_customize,
        // $id
        'newsup_single_page_layout',
        // $args
        array(
            'settings'=> 'newsup_single_page_layout',
            'section' => 'site_single_posts_settings',
            'label'   => __( '', 'newsup' ),
            'choices' => array(
                'single-align-content-left' => get_template_directory_uri() . '/images/fullwidth-left-sidebar.png',
                'single-full-width-content'    => get_template_directory_uri() . '/images/fullwidth.png',
                'single-align-content-right'    => get_template_directory_uri() . '/images/right-sidebar.png',
            )
        )
    )
);

// Setting - Single posts.
$wp_customize->add_setting('newsup_single_post_category',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_single_post_category', 
    array(
        'label' => esc_html__('Hide/Show Categories', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_single_post_admin_details',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_single_post_admin_details', 
    array(
        'label' => esc_html__('Hide/Show Author Details', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_single_post_date',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_single_post_date', 
    array(
        'label' => esc_html__('Hide/Show Date', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_single_post_tag',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_single_post_tag', 
    array(
        'label' => esc_html__('Hide/Show Tag', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('single_show_featured_image',
    array(
        'default' => $newsup_default['single_show_featured_image'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'single_show_featured_image', 
    array(
        'label' => __('Hide/Show Featured Image', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('single_show_share_icon',
    array(
        'default' => $newsup_default['single_show_share_icon'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'single_show_share_icon', 
    array(
        'label' => __('Hide/Show Sharing Icons', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_enable_single_post_admin_details',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_single_post_admin_details', 
    array(
        'label' => esc_html__('Hide/Show Author Details', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_related_post_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_related_post_heading',
        array(
            'label' => esc_html__('Related Post', 'newsup'),
            'section' => 'site_single_posts_settings',

        )
    )
);
$wp_customize->add_setting('newsup_enable_related_post',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_related_post', 
    array(
        'label' => esc_html__('Enable Related Posts', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_related_post_title', 
    array(
        'default' => esc_html__('Related Posts', 'newsup'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control('newsup_related_post_title', 
    array(
        'label' => esc_html__('Title', 'newsup'),
        'type' => 'text',
        'section' => 'site_single_posts_settings',
    )
);

/************************* Meta Hide Show *********************************/
$wp_customize->add_setting('newsup_enable_single_post_category',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_single_post_category', 
    array(
        'label' => esc_html__('Hide/Show Categories', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_enable_single_post_date',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_single_post_date', 
    array(
        'label' => esc_html__('Hide/Show Date', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_enable_single_post_admin',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_single_post_admin', 
    array(
        'label' => esc_html__('Hide/Show Author Name', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));
$wp_customize->add_setting('newsup_enable_single_post_comments',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_single_post_comments', 
    array(
        'label' => esc_html__('Hide/Show Comments', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_single_posts_settings',
    )
));