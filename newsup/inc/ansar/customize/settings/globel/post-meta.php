<?php
$newsup_default = newsup_get_default_theme_options();
$wp_customize->add_setting('global_post_date_author_setting',
    array(
        'default' => $newsup_default['global_post_date_author_setting'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'newsup_sanitize_select',
    )
);
$wp_customize->add_control('global_post_date_author_setting',
    array(
        'label' => esc_html__('Date and Author', 'newsup'),
        'section' => 'site_post_date_author_settings',
        'type' => 'select',
        'choices' => array(
            'show-date-author' => esc_html__('Show Date and Author', 'newsup'),
            'show-date-only' => esc_html__('Show Date Only', 'newsup'),
            'show-author-only' => esc_html__('Show Author Only', 'newsup'),
            'hide-date-author' => esc_html__('Hide All', 'newsup'),
        ),
    )
);
// Hide/Show Comments
$wp_customize->add_setting('all_post_comment_disable',
    array(
        'default' => false,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'all_post_comment_disable', 
    array(
        'label' => esc_html__('Hide/Show Comments', 'newsup'),
        'type' => 'toggle',
        'section' => 'site_post_date_author_settings',
    )
));