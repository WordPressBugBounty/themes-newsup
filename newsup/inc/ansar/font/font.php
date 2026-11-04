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

    $requested = array(
        array( newsup_get_option( 'heading_fontfamily' ), newsup_get_option( 'heading_fontweight' ) ),
        array( newsup_get_option( 'menu_fontfamily' ), '400' ),
    );

    foreach ( $requested as $item ) {
        list( $font, $weight ) = $item;

        $font   = trim( explode( ',', (string) $font )[0], " \t\n\r\0\x0B'\"" );
        $weight = absint( $weight );

        if ( $font && $weight >= 100 && $weight <= 900 ) {
            $fonts[ $font ][] = $weight;
        }
    }

    $fonts = apply_filters( 'blogarise_google_fonts', $fonts );

    ksort( $fonts );

    $families = array();

    foreach ( $fonts as $font => $weights ) {
        $weights = array_filter( array_unique( array_map( 'absint', (array) $weights ) ) );
        sort( $weights, SORT_NUMERIC );

        if ( ! $font || empty( $weights ) ) {
            continue;
        }

        $families[] = 'family=' . urlencode( $font ) . ':wght@' . implode( ';', $weights );
    }

    return 'https://fonts.googleapis.com/css2?' . implode( '&', $families ) . '&display=swap';
}

function newsup_scripts_styles() {
    wp_enqueue_style( 'newsup-fonts', newsup_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'newsup_scripts_styles' );