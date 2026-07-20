<?php

function newsup_customize_options() {

  // Initialize string
  $newsup_custom_css = '';

  if ( get_theme_mod('enable_newsup_typo', false) == true) {
    /* Headings Typography*/
    $newsup_custom_css .= 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, .wp-block-search__label { 
                              font-family:'. esc_attr(newsup_get_option('heading_fontfamily')).' !important;
                              font-weight:'. esc_attr(newsup_get_option('heading_fontweight')).' !important;
                            }';
      /* Menus Font Family*/
    $newsup_custom_css .= '.navbar-wp .navbar-nav > li > a { 
                              font-family:'. esc_attr(newsup_get_option('menu_fontfamily')).' !important; 
                            }';
  }
  // Attach to the handle
  if ( ! empty( $newsup_custom_css ) ) {
    wp_add_inline_style( 'newsup-style', $newsup_custom_css );
  }
}