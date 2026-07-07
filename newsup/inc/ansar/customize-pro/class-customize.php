<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Newsup_Customize {
	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {
		static $instance = null;
		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}
		return $instance;
	}
	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}
	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {
		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Loads Customizer helper functions.
		add_action( 'after_setup_theme', array( $this, 'customizer_helpers' ) );

		add_action( 'customize_register', array( $this, 'customize_controls' ), 10 );

		add_action( 'customize_register', array( $this, 'customize_options' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customize_control' ) );

		add_action( 'customize_preview_init', array( $this, 'enqueue_customize_preview' ) );
	}
	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {
		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . '/inc/ansar/customize-pro/section-pro.php' );
		// Register custom section types.
		$manager->register_section_type( 'Newsup_Customize_Section_Pro' );
		// Register sections.
		$manager->add_section(
			new Newsup_Customize_Section_Pro(
				$manager,
				'newsup_pro_upsell',
				array(
					'title'    => __( 'Newsup Pro Available!', 'newsup' ),
					'pro_text' => __( 'Go Pro','newsup' ),
					'pro_url'  => 'https://themeansar.com/themes/newsup-pro/',
					'priority'	=> 1
				)
			)
		);
	}

	/**
	 * Sets up the customizer Controls.
	*/
	public function customize_controls( $wp_customize ) {
		// Load customize controls.
		require get_template_directory().'/inc/ansar/customize/customizer-control.php';
    }
	 /**
	 * Loads Customizer helper functions and sanitization callbacks.
	 *
	 * @since 1.0.0
	 */
	public function customizer_helpers() {

		// Load customize default values.
		require get_template_directory().'/inc/ansar/customize/customizer-callback.php';
		require get_template_directory().'/inc/ansar/customize/selective-refresh-and-partial.php';
		require get_template_directory().'/inc/ansar/customize/customizer-default.php';
		require get_template_directory().'/inc/ansar/customize/customizer-sanitize.php';
	}


	/**
	 * Sets up the customizer options.
	*/
	public function customize_options( $wp_customize ) {
        // Panels and Sections 
		require get_template_directory().'/inc/ansar/customize/settings/panels-and-sections.php';

		// Settings
		require get_template_directory().'/inc/ansar/customize/settings/globel/site-identity.php';
		require get_template_directory().'/inc/ansar/customize/settings/about-theme.php';
		
		// Header Settings
		require get_template_directory().'/inc/ansar/customize/settings/header/date-time.php';
		require get_template_directory().'/inc/ansar/customize/settings/header/social-icons.php';
		require get_template_directory().'/inc/ansar/customize/settings/header/banner-ads.php';
		require get_template_directory().'/inc/ansar/customize/settings/header/header-image.php';
    }
	/**
	 * Loads theme customizer CSS & JS.
	*/
	public function enqueue_customize_control() {
		// Styles
		wp_enqueue_style( 'newsup-customize-controls', get_template_directory_uri() . '/inc/ansar/customize-pro/customize-controls.css' );
		
		// Scripts
		wp_enqueue_script( 'newsup-customize-controls', get_template_directory_uri() . '/inc/ansar/customize/assets/js/customize-control.js', array( 'customize-controls' ), '1.0', true );
	}
	/**
	 * Loads theme customize Preview CSS & JS.
	*/
	public function enqueue_customize_preview() {
		wp_enqueue_script('newsup-customizer-preview', get_template_directory_uri().'/js/customizer.js', array('customize-preview'), '20151215', true);
	}
	
}
// Doing this customizer thang!
Newsup_Customize::get_instance();