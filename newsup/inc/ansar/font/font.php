<?php
/*--------------------------------------------------------------------*/
/*     Register Google Fonts
/*--------------------------------------------------------------------*/
function newsup_fonts_url() {

	$heading_font_family = newsup_get_option( 'heading_fontfamily' );
	$heading_font_weight = newsup_get_option( 'heading_fontweight' );
	$menu_font_family    = newsup_get_option( 'menu_fontfamily' );

	$font_families = array(
		$heading_font_family . ':' . $heading_font_weight,
		$menu_font_family . ':700' ,
		'Inter:300,400,500,600,700,800,900',
	);

	$font_families = array_unique( $font_families );

	$query_args = array(
		'family'  => implode( '|', $font_families ),
		'subset'  => 'latin,latin-ext',
		'display' => 'swap',
	);

	return add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
}
function newsup_scripts_styles() {
    wp_enqueue_style( 'newsup-fonts', newsup_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'newsup_scripts_styles' );