<?php
$wp_customize->add_setting('scroller_heading',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'scroller_heading',
        array(
            'label' => esc_html__('Top to Bottom Scroller', 'newsup'),
            'section' => 'scroller_section',

        )
    )
);
$wp_customize->add_setting('scroller_enable',
    array(
        'default' => true,
        'transport' => 'refresh',
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'scroller_enable', 
    array(
        'label' => esc_html__('Hide/Show', 'newsup'),
        'type' => 'toggle',
        'section' => 'scroller_section',
    )
));