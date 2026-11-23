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
  $newsup_custom_css .= '.mg-blog-post, .mg-posts-sec-post, .mg-blog-post-3, .mg-blog-post-box{	img.mg-featured-image[width][height] {	height: 100%;	object-fit: cover; object-position: center;	width: 100%; opacity: 1; } }';
  // Attach to the handle
  if ( ! empty( $newsup_custom_css ) ) {
    wp_add_inline_style( 'newsup-style', $newsup_custom_css );
  }
}