<?php
$wp_customize->add_setting('newsup_footer_menu_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'newsup_footer_menu_heading',
        array(
            'label' => esc_html__('Footer Menu', 'newsup'),
            'section' => 'footer_menu_section',

        )
    )
);
$wp_customize->add_setting('newsup_enable_footer_menu',
    array(
        'default' => true,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
        'transport' => 'postMessage',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'newsup_enable_footer_menu', 
    array(
        'label' => esc_html__('Hide/Show Footer Menu', 'newsup'),
        'type' => 'toggle',
        'section' => 'footer_menu_section',
    )
));