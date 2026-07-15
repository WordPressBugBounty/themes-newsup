<?php
// date in header display type
$wp_customize->add_setting( 'post_image_type', array(
    'default'           => 'newsup_post_img_hei',
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'newsup_sanitize_select',
    'transport' => 'postMessage',
) );
$wp_customize->add_control( 'post_image_type', array(
    'type'     => 'radio',
    'label'    => esc_html__( 'Post Image display type:', 'newsup' ),
    'choices'  => array(
        'newsup_post_img_hei'          => esc_html__( 'Fix Height Post Image', 'newsup' ),
        'newsup_post_img_acc' => esc_html__( 'Auto Height Post Image', 'newsup' ),
    ),
    'section'  => 'post_image_options',
    'settings' => 'post_image_type',
) );