<?php
/**
 * Newsup Performance Edition
 *
 * Safe performance helpers that do not change existing menu, widget, or
 * Customizer architecture.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add fetchpriority="high" to Newsup's single-post featured image.
 *
 * The theme's single-post template explicitly marks this image with the
 * "single-featured-image" class. This avoids guessing which arbitrary image
 * is the LCP element.
 *
 * WordPress 6.3+ supports fetchpriority/loading optimization attributes.
 * We also set loading=eager so the LCP candidate is not lazy-loaded.
 */
function newsup_performance_post_thumbnail_attr( $attr, $attachment, $size ) {
    if ( is_admin() || ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
        return $attr;
    }

    if ( ! empty( $attr['class'] ) && false !== strpos( $attr['class'], 'single-featured-image' ) ) {
        if ( empty( $attr['fetchpriority'] ) ) {
            $attr['fetchpriority'] = 'high';
        }

        if ( empty( $attr['loading'] ) || 'lazy' === $attr['loading'] ) {
            $attr['loading'] = 'eager';
        }

        if ( empty( $attr['decoding'] ) ) {
            $attr['decoding'] = 'async';
        }
    }

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'newsup_performance_post_thumbnail_attr', 20, 3 );

/**
 * Defer Newsup's own JavaScript on WordPress 6.3+.
 *
 * jQuery itself is intentionally not deferred here because many existing
 * child themes and custom snippets may depend on its early availability.
 * WordPress resolves dependency order for deferred scripts.
 */
function newsup_performance_defer_scripts() {
    if ( is_admin() || ! function_exists( 'wp_script_add_data' ) ) {
        return;
    }

    $handles = array(
        'newsup-navigation',
        'bootstrap',
        'owl-carousel-min',
        'smartmenus-js',
        'bootstrap-smartmenus-js',
        'newsup-marquee-js',
        'newsup-main-js',
        'newsup-custom',
        'newsup-custom-time',
    );

    foreach ( $handles as $handle ) {
        if ( wp_script_is( $handle, 'registered' ) || wp_script_is( $handle, 'enqueued' ) ) {
            wp_script_add_data( $handle, 'strategy', 'defer' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'newsup_performance_defer_scripts', 100 );


/**
 * Add the theme version to Newsup-owned static assets that do not already
 * have a version query string. This is cache-busting support; the server/CDN
 * controls the actual cache lifetime.
 */
function newsup_performance_version_theme_assets( $src ) {
    if ( empty( $src ) || false !== strpos( $src, '?ver=' ) ) {
        return $src;
    }

    $theme_uri = trailingslashit( get_template_directory_uri() );
    if ( 0 !== strpos( $src, $theme_uri ) ) {
        return $src;
    }

    $version = defined( 'NEWSUP_THEME_VERSION' ) ? NEWSUP_THEME_VERSION : '1.0.0';

    return add_query_arg( 'ver', $version, $src );
}
add_filter( 'style_loader_src', 'newsup_performance_version_theme_assets', 99 );
add_filter( 'script_loader_src', 'newsup_performance_version_theme_assets', 99 );
