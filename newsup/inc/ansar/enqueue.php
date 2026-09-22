<?php 
function newsup_scripts() {

	wp_enqueue_style('bootstrap', NEWSUP_THEME_URI . 'css/bootstrap.css', array(), NEWSUP_THEME_VERSION );

	wp_style_add_data( 'bootstrap', 'rtl', 'replace' );

	wp_enqueue_style( 'newsup-style', get_stylesheet_uri() );

	wp_style_add_data( 'newsup-style', 'rtl', 'replace' );

	wp_enqueue_style('newsup-default', NEWSUP_THEME_URI . 'css/colors/default.css', array(), NEWSUP_THEME_VERSION);

	wp_enqueue_style(
        'font-awesome-5-all',
        NEWSUP_THEME_URI . 'css/font-awesome/css/all.min.css',
        array(),
        defined( 'NEWSUP_THEME_VERSION' ) ? NEWSUP_THEME_VERSION : null
    );

	wp_enqueue_style(
        'font-awesome-4-shim',
        NEWSUP_THEME_URI . 'css/font-awesome/css/v4-shims.min.css',
        array( 'font-awesome-5-all' ),
        defined( 'NEWSUP_THEME_VERSION' ) ? NEWSUP_THEME_VERSION : null
    );

	wp_enqueue_style('owl-carousel', NEWSUP_THEME_URI . 'css/owl.carousel.css', array(), NEWSUP_THEME_VERSION);
	
	wp_enqueue_style('smartmenus',NEWSUP_THEME_URI.'css/jquery.smartmenus.bootstrap.css', array(), NEWSUP_THEME_VERSION);

	wp_enqueue_style('newsup-custom-css', NEWSUP_THEME_URI . 'inc/ansar/customize/assets/css/customizer.css', array(), NEWSUP_THEME_VERSION, '1.0', 'all');

	wp_enqueue_style('newsup-common-css', NEWSUP_THEME_URI . 'css/common.css', array(), NEWSUP_THEME_VERSION);

	if (class_exists('WooCommerce')) {
		wp_enqueue_style('newsup-woocommerce-style', NEWSUP_THEME_URI . 'css/woocommerce.css', array(), NEWSUP_THEME_VERSION);
	}

	/* Js script */

	wp_enqueue_script( 'newsup-navigation', NEWSUP_THEME_URI . 'js/navigation.js', array('jquery'), NEWSUP_THEME_VERSION);

	wp_enqueue_script('bootstrap', NEWSUP_THEME_URI . 'js/bootstrap.js', array('jquery'), NEWSUP_THEME_VERSION);

	wp_enqueue_script('owl-carousel-min', NEWSUP_THEME_URI . 'js/owl.carousel.min.js', array('jquery'), NEWSUP_THEME_VERSION);

	wp_enqueue_script('smartmenus-js', NEWSUP_THEME_URI . 'js/jquery.smartmenus.js' , array('jquery'), NEWSUP_THEME_VERSION);

	wp_enqueue_script('bootstrap-smartmenus-js', NEWSUP_THEME_URI . 'js/jquery.smartmenus.bootstrap.js' , array('jquery'), NEWSUP_THEME_VERSION);

	wp_enqueue_script('newsup-marquee-js', NEWSUP_THEME_URI . 'js/jquery.marquee.js' , array('jquery'), NEWSUP_THEME_VERSION);
	
	wp_enqueue_script('newsup-main-js', NEWSUP_THEME_URI . 'js/main.js' , array('jquery'), NEWSUP_THEME_VERSION);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	newsup_customize_options();
}
add_action('wp_enqueue_scripts', 'newsup_scripts');

//Custom js for time
function newsup_custom_js() {

	wp_enqueue_script(	'newsup-custom', NEWSUP_THEME_URI . 'js/custom.js', array( 'jquery', 'bootstrap', 'owl-carousel-min', 'newsup-marquee-js' ),
		defined( 'NEWSUP_THEME_VERSION' ) ? NEWSUP_THEME_VERSION : null,
		true
	);

	if ( function_exists( 'wp_script_add_data' ) ) {
		wp_script_add_data( 'newsup-custom', 'strategy', 'defer' );
	}

	$header_time_enable = get_theme_mod('header_time_enable',true); 
	if($header_time_enable == 'true') { 
	
		$newsup_date_time_show_type = get_theme_mod('newsup_date_time_show_type','newsup_default'); 

		if($newsup_date_time_show_type == 'newsup_default'){

			wp_enqueue_script('newsup-custom-time', NEWSUP_THEME_URI . 'js/custom-time.js' , array('jquery'), NEWSUP_THEME_VERSION); 

		}
	}
} 
add_action('wp_footer','newsup_custom_js');

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function newsup_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'newsup_skip_link_focus_fix' );

//Footer widget text color
function newsup_footer_text_color() {
	$newsup_footer_text_color = get_theme_mod('newsup_footer_text_color');
	if($newsup_footer_text_color) { ?>
		<style>
			footer .mg-widget p, footer .site-title-footer a, footer .site-title a:hover, footer .site-description-footer, footer .site-description:hover, footer .mg-widget ul li a{
				color: <?php echo esc_attr($newsup_footer_text_color); ?>;
			}
		</style>
	<?php } ?>
	<style>
		.wp-block-search .wp-block-search__label::before, .mg-widget .wp-block-group h2:before, .mg-sidebar .mg-widget .wtitle::before, .mg-sec-title h4::before, footer .mg-widget h6::before {
			background: inherit;
		}
	</style>
	<?php
}
add_action('wp_footer','newsup_footer_text_color');

if ( ! function_exists( 'newsup_admin_scripts' ) ) :
function newsup_admin_scripts() {
    wp_enqueue_script(
        'newsup-admin-script',
        NEWSUP_THEME_URI . 'inc/ansar/customizer-admin/js/newsup-admin-script.js',
        array( 'jquery' ), NEWSUP_THEME_VERSION,
        '',
        true
    );
    wp_localize_script(
        'newsup-admin-script',
        'newsup_ajax_object',
        array(
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'install_nonce' => wp_create_nonce( 'newsup_install_plugin_nonce' ),
            'can_install'   => current_user_can( 'install_plugins' ),
        )
    );

    wp_enqueue_style( 'newsup-admin-style-css', NEWSUP_THEME_URI . 'css/customizer-controls.css', array(), NEWSUP_THEME_VERSION);
}
endif;
add_action( 'admin_enqueue_scripts', 'newsup_admin_scripts' );

/**
 * Newsup Performance Edition: lightweight presentation CSS.
 * Does not replace existing styles or widgets.
 */
add_action( 'wp_enqueue_scripts', 'newsup_enqueue_performance_styles', 99 );
function newsup_enqueue_performance_styles() {
    wp_enqueue_style(
        'newsup-performance',
        NEWSUP_THEME_URI . 'css/newsup-performance.css',
        array(),
        defined( 'NEWSUP_THEME_VERSION' ) ? NEWSUP_THEME_VERSION : '1.0.0'
    );
}
