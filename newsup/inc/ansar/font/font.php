<?php
/*--------------------------------------------------------------------*/
/*     Register Google Fonts
/*--------------------------------------------------------------------*/
function newsup_fonts_url() {

    $fonts = array(
        'Montserrat' => array('400','500','600','700','800'),
        'Inter'        => array('400','500','600'),
    );
	$heading_font_family = newsup_get_option( 'heading_fontfamily' );
	$heading_font_weight = newsup_get_option( 'heading_fontweight' );
	$menu_font_family    = newsup_get_option( 'menu_fontfamily' );

    foreach ( array( $heading_font_family => $heading_font_weight, $menu_font_family => '400' ) as $font => $weight ) {
        $font = trim( explode( ',', $font )[0] );

        if ( $font ) {
            $fonts[ $font ][] = $weight;
        }
    }

    $families = array();

    foreach ( $fonts as $font => $weights ) {
        $families[] = 'family=' . rawurlencode(
            $font . ':wght@' . implode( ';', array_unique( $weights ) )
        );
    }

    return 'https://fonts.googleapis.com/css2?' . implode( '&', $families ) . '&display=swap';
}

function newsup_scripts_styles() {
    wp_enqueue_style( 'newsup-fonts', newsup_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'newsup_scripts_styles' );