<?php

$wp_customize->add_setting('breadcrumb_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'breadcrumb_heading',
        array(
            'label' => esc_html__('Breadcrumb', 'newsup'),
            'section' => 'breadcrumb_section',

        )
    )
);
// Breadcrumb Enable/Disble Section
$wp_customize->add_setting('bcrumb_section_enable',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'bcrumb_section_enable', 
    array(
        'label' => esc_html__('Hide/Show', 'newsup'),
        'type' => 'toggle',
        'section' => 'breadcrumb_settings',
    )
));

//Type Of Bredcrumb 
$wp_customize->add_setting( 'newsup_site_breadcrumb_type', array(
    'sanitize_callback' => 'newsup_sanitize_select',
    'default'   => 'default',
));
$wp_customize->add_control( 'newsup_site_breadcrumb_type', array(
    'type'      => 'select',
    'section'   => 'breadcrumb_settings',
    'label'     => esc_html__( 'Breadcrumb type', 'newsup' ),
    'description' => esc_html__( 'If you use other than "default" one you will need to install and activate respective plugins Breadcrumb NavXT, Yoast SEO and Rank Math SEO', 'newsup' ),
    'choices'   => array(
        'default' => __( 'Default', 'newsup' ),
        'navxt'  => __( 'NavXT', 'newsup' ),
        'yoast'  => __( 'Yoast SEO', 'newsup' ),
        'rankmath'  => __( 'Rank Math', 'newsup' )
    )
));