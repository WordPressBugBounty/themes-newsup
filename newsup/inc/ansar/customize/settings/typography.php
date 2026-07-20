<?php
$font_family = array('Inter'=> 'Inter', 'Open Sans'=>'Open Sans', 'Montserrat'=>'Montserrat', 
'Rokkitt'=>'Rokkitt', 'Jost' => 'Jost', 'Poppins' => 'Poppins', 'Lato' => 'Lato', 'Noto Serif'=>'Noto Serif', 
'Raleway'=>'Raleway', 'Roboto' => 'Roboto');

$font_weight = array('300'=>'300 (Light)','400'=>'400 (Normal)','500'=>'500 (Medium)' ,'600'=>'600 (Semi Bold)',
'700'=>'700 (Bold)','800'=>'800 (Extra Bold)','900'=>'900 (Black)');

$newsup_default = newsup_get_default_theme_options();

// Breadcrumb Enable/Disble Section
$wp_customize->add_setting('enable_newsup_typo',
    array(
        'default' => false,
        'sanitize_callback' => 'newsup_sanitize_checkbox',
    )
);
$wp_customize->add_control(new Newsup_Toggle_Control( $wp_customize, 'enable_newsup_typo', 
    array(
        'label' => esc_html__('Typography', 'newsup'),
        'type' => 'toggle',
        'section' => 'newsup_typography_setting',
    )
));

$wp_customize->add_setting('heading_typo_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'heading_typo_title',
        array(
            'label' => esc_html__('Heading', 'newsup'),
            'section' => 'newsup_typography_setting',

        )
    )
);

$wp_customize->add_setting(
    'heading_fontfamily',
    array(
        'default'           =>  $newsup_default['heading_fontfamily'],
		'capability'        =>  'edit_theme_options',
		'sanitize_callback' =>  'newsup_sanitize_select',
    )	
);
$wp_customize->add_control('heading_fontfamily', array(
    'label' => __('Font Family','newsup'),
    'section' => 'newsup_typography_setting',
    'type'    =>  'select',
    'choices'=>$font_family
));
 
$wp_customize->add_setting(
    'heading_fontweight',
    array(
        'default'           =>  $newsup_default['heading_fontweight'],
		'capability'        =>  'edit_theme_options',
		'sanitize_callback' =>  'newsup_sanitize_select',
    )	
);
$wp_customize->add_control('heading_fontweight', array(
    'label' => __('Font Weight','newsup'),
    'section' => 'newsup_typography_setting',
    'type'    =>  'select',
    'choices'=>$font_weight
));


$wp_customize->add_setting('menu_typo_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control(
    new Newsup_Section_Title(
        $wp_customize,
        'menu_typo_title',
        array(
            'label' => esc_html__('Menu Font', 'newsup'),
            'section' => 'newsup_typography_setting',

        )
    )
);

$wp_customize->add_setting(
    'menu_fontfamily',
    array(
        'default'           =>  $newsup_default['menu_fontfamily'],
		'capability'        =>  'edit_theme_options',
		'sanitize_callback' =>  'newsup_sanitize_select',
    )	
);
$wp_customize->add_control('menu_fontfamily', array(
    'label' => __('Font Family','newsup'),
    'section' => 'newsup_typography_setting',
    'type'    =>  'select',
    'choices'=>$font_family
));