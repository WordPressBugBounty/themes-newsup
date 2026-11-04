<?php

function newsup_customize_options() {

  // Initialize string
  $newsup_custom_css = '';

  if ( get_theme_mod('enable_newsup_typo', false) == true) {
    /* Headings Typography*/
    $newsup_custom_css .= ':root {
                              --headFont:'. esc_attr(newsup_get_option('heading_fontfamily')).';
                              --headWeight:'. esc_attr(newsup_get_option('heading_fontweight')).';
                              --menuFont:'. esc_attr(newsup_get_option('menu_fontfamily')).';
                            }';                            
  }
  // Attach to the handle
  if ( ! empty( $newsup_custom_css ) ) {
    wp_add_inline_style( 'newsup-style', $newsup_custom_css );
  }
}