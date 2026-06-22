<?php 
// Admin Page
class NewsUp_Admin {

    public function __construct() {
        // Add admin page
        add_action('admin_menu', [$this, 'newsup_admin_page']);
        
        add_filter( 'submenu_file', [ $this, 'newsup_set_active_submenu' ] );
        // Remove all third party notices and enqueue style and script
        add_action('admin_enqueue_scripts', [$this, 'admin_script_n_style'], 9999);

        // AJAX install + activate plugin
        add_action('wp_ajax_newsup_install_plugin', [$this, 'newsup_install_plugin_callback']);
        add_action('wp_ajax_newsup_activate_plugin', [$this, 'newsup_activate_plugin_callback']);
    }

    public function newsup_admin_page() {
        // $site_favi_icon = '';
        $site_favi_icon = NEWSUP_THEME_URI .'admin/images/siteicon.png';

        $customMenu = add_menu_page(
            esc_html( NEWSUP_THEME_NAME ),
            esc_html( NEWSUP_THEME_NAME ),
            'manage_options',
            'newsup_admin_menu',
            [ $this, 'newsup_admin_page_content' ],
            $site_favi_icon,
            30
        );

        add_submenu_page(
            'newsup_admin_menu',
            __('Starter Sites', 'newsup'),
            __('Starter Sites', 'newsup'),
            'manage_options',
            'newsup_admin_menu&tab=starter-sites',
            [ $this, 'render_starter_sites_tab' ]

        );
        add_submenu_page(
            'newsup_admin_menu',
            __('Customize', 'newsup'),
            __('Customize', 'newsup'),
            'manage_options',
            'customize.php'
        );
        add_submenu_page(
            'newsup_admin_menu',
            __('Footer Builder', 'newsup'),
            '<span id="newsup-upgrade-menu-item">' . __('Upgrade Now &nbsp;➤', 'newsup') . '</span>',
            'manage_options',
            esc_url('https://themeansar.com/themes/newsup-pro/')
        );
    }
    public function newsup_set_active_submenu( $submenu_file ) {

        if (
            isset( $_GET['page'], $_GET['tab'] ) &&
            $_GET['page'] === 'newsup_admin_menu' &&
            $_GET['tab'] === 'starter-sites'
        ) {

            $submenu_file = 'newsup_admin_menu&tab=starter-sites';
        }

        return $submenu_file;
    }
    public function admin_script_n_style() {
        $screen = get_current_screen();
        if (isset( $screen->base ) && $screen->base == 'toplevel_page_newsup_admin_menu') {

            remove_all_actions('admin_notices');

            wp_enqueue_script('newsup-admin', NEWSUP_THEME_URI . 'js/admin.js', ['jquery'], NEWSUP_THEME_VERSION, true);

            wp_localize_script('newsup-admin', 'newsup_ajax_obj', [
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('newsup_plugin_nonce'),
            ]);

            wp_enqueue_style('newsup-admin-styles', NEWSUP_THEME_URI . 'css/admin.css', array(), NEWSUP_THEME_VERSION);

            // Add Gooogle Font
            wp_enqueue_style( 
                'admin-google-fonts', 
                'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap',
                [], 
                NEWSUP_THEME_VERSION
            );

            add_filter('admin_footer_text', [$this, 'newsup_admin_footer_text']);
        
            if ( is_plugin_active( 'ansar-import/ansar-import.php' ) ) {
            
                wp_enqueue_style(
                    'ansar-import-admin-css',
                    plugins_url( 'admin/css/ansar-import-admin.css', WP_PLUGIN_DIR . '/ansar-import/ansar-import.php' ),
                    array(),
                    NEWSUP_THEME_VERSION
                );
                wp_enqueue_style(
                    'ansar-import-uikit.min-css',
                    plugins_url( 'admin/css/uikit.min.css', WP_PLUGIN_DIR . '/ansar-import/ansar-import.php' ),
                    array(),
                    NEWSUP_THEME_VERSION
                );
                wp_enqueue_script(
                    'ansar-import-uikit-js',
                    plugins_url( 'admin/js/uikit.min.js', WP_PLUGIN_DIR . '/ansar-import/ansar-import.php' ),
                    array('jquery'),
                    NEWSUP_THEME_VERSION
                );
                wp_enqueue_script(
                    'ansar-import-admin-js',
                    plugins_url( 'admin/js/ansar-import-admin.js', WP_PLUGIN_DIR . '/ansar-import/ansar-import.php' ),
                    array('jquery'),
                    NEWSUP_THEME_VERSION
                );
                $theme_data = wp_get_theme();
                $theme_name = $theme_data->get('Name');
                wp_localize_script(
                    'ansar-import-admin-js',
                    'my_ajax_object',
                        array( 
                            'ajax_url' => admin_url('admin-ajax.php'),
                            'nonce' => wp_create_nonce('ansar_demo_import_nonce'),
                            'theme_name' => $theme_name
                        )
                );
                if ( isset( $_GET['page'], $_GET['tab'] ) && $_GET['page'] === 'newsup_admin_menu' && $_GET['tab'] === 'starter-sites') {
                    $theme_data_api = wp_remote_get(esc_url_raw("https://api.themeansar.com/wp-json/wp/v2/demos/?search=%27" . urlencode($theme_name) . "%27&per_page=50"), [ 'timeout' => 15 ]);
                    $theme_data_api_body = wp_remote_retrieve_body($theme_data_api);
                    $all_demos = json_decode($theme_data_api_body, TRUE);
            
                    wp_localize_script(
                        'ansar-import-admin-js',
                        'ansar_theme_object', 
                        $all_demos
                    );
                }
            }
        }
    }

    function newsup_admin_footer_text() {
        return sprintf(
            wp_kses_post(
                __( 'Enjoyed <span class="newsup-footer-thankyou"><strong>%s</strong>? Please leave us a <a href="https://wordpress.org/support/theme/newsup/reviews/" target="_blank">★★★★★</a></span> rating.', 'newsup' )
            ),
            esc_html( NEWSUP_THEME_NAME )
        );
    }

    public function newsup_admin_page_content() {
        $change_log = NEWSUP_THEME_DIR . 'change-log.txt';
        if ( ! file_exists( $change_log ) ) {
            $change_log = esc_html__( 'Change log file not found.', 'newsup' );
        } elseif ( ! is_readable( $change_log ) ) {
            $change_log = esc_html__( 'Change log file not readable.', 'newsup' );
        } else {
            global $wp_filesystem;

            // Check if the the global filesystem isn't setup yet.
            if ( is_null( $wp_filesystem ) ) {
                WP_Filesystem();
            }

            $change_log = $wp_filesystem->get_contents( $change_log );
        }
        ?>

        <div class="newsup-page-content">
            <div class="newsup-tabbed">
                <?php
                    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                    $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'welcome';
                ?>
                <input type="radio" id="tab1" name="css-tabs" <?php checked( $active_tab, 'welcome' ); ?> >
                <input type="radio" id="tab2" name="css-tabs" <?php checked( $active_tab, 'starter-sites' ); ?> >
                <input type="radio" id="tab3" name="css-tabs" <?php checked( $active_tab, 'useful-plugin' ); ?> >
                <input type="radio" id="tab4" name="css-tabs" <?php checked( $active_tab, 'compare' ); ?> >
                <input type="radio" id="tab5" name="css-tabs" <?php checked( $active_tab, 'change-log' ); ?> >
                <div class="newsup-head-top-items">
                    <div class="newsup-head-item">
                        <a href="<?php echo esc_url( add_query_arg( [ 'tab'   => 'welcome'] ) ); ?>" class="newsup-site-icon"><img src=<?php echo esc_url(NEWSUP_THEME_URI) .'admin/images/mainlogo-1.png'; ?>  alt="mainlogo"></a>
                    </div>
                    <ul class="newsup-tabs">
                        <li class="newsup-tab">
                            <label for="tab1">
                            <a href="<?php echo esc_url( add_query_arg( [ 'tab'   => 'welcome'] ) ); ?>">
                                <?php esc_attr_e('Dashboard','newsup'); ?>
                            </a>
                            </label>
                        </li>
                        <li class="newsup-tab">
                            <label for="tab2">
                            <a href="<?php echo esc_url( add_query_arg( [ 'tab'   => 'starter-sites'] )); ?>">
                                <?php esc_attr_e('Starter Sites','newsup'); ?>
                            </a>
                            </label>
                        </li>
                        <li class="newsup-tab">
                            <label for="tab3">
                            <a href="<?php echo esc_url( add_query_arg( [ 'tab'   => 'useful-plugin'] ) ); ?>">
                                <?php esc_attr_e('Useful Plugin','newsup'); ?>
                            </a>
                            </label>
                        </li>
                        <li class="newsup-tab">
                            <label for="tab4">
                            <a href="<?php echo esc_url( add_query_arg( [ 'tab'   => 'compare'] ) ); ?>">
                                <?php esc_attr_e('Free Vs Pro','newsup'); ?>
                            </a>
                            </label>
                        </li>
                        <li class="newsup-tab">
                            <label for="tab5">
                            <a href="<?php echo esc_url( add_query_arg( [ 'tab'   => 'change-log'] ) ); ?>">
                                <?php esc_attr_e('Change Log','newsup'); ?>
                            </a>
                            </label>
                        </li>
                    </ul>
                    <div class="newsup-right-top-area">
                        <div class="newsup-ask-help">            
                            <div class="newsup-ask-icon">
                                <svg class="svg-inline--fa fa-book" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="book" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"></path></svg>
                            </div>                            
                            <a href="https://docs.themeansar.com/docs/newsup-lite/" target="_blank" class="newsup-btn-link">Docs </a>
                        </div>
                        <div class="newsup-feature-pro">
                            <span><?php echo esc_html(NEWSUP_THEME_VERSION); ?> Current Version</span>
                        </div>
                    </div>
                </div>
                <div class="newsup-main-area">
                    <div class="newsup-tab-contents">
                        <div class="newsup-tab-content newsup-welcome">
                            <div class="newsup-getstart newsup-d-grid column6 gap-30">
                                <!--  -->
                                <!-- <div class="newsup-getstart-inner newsup-col-span-4">
                                    
                                </div>  -->
                                <div class="newsup-getstart-inner newsup-col-span-4">
                                    <div class="newsup-wrapper first">
                                        <div class="newsup-getstart-content">
                                                <h1 class="newsup-content-title"><?php esc_html_e('Welcome, ','newsup');   $current_user = wp_get_current_user();
                                                echo esc_html( $current_user->display_name );?></h1>
                                                <p class="newsup-content-description">
                                                    <?php printf(
                                                            esc_html__(
                                                                'Thank you for installing %s — your complete solution for creating modern, dynamic, engaging News, and Magazine websites.',
                                                                'newsup'
                                                            ),
                                                            esc_html( NEWSUP_THEME_NAME )
                                                        );
                                                    ?>
                                                </p>
                                            <?php if ( is_plugin_active( 'ansar-import/ansar-import.php' ) ) : ?>
                                                <a href="<?php echo esc_url(admin_url( 'admin.php?page=newsup_admin_menu&tab=starter-sites' )); ?>" class="newsup-content-btn newsup-str-sites"><?php esc_html_e('Start with Demo Sites','newsup'); ?></a>
                                            <?php else : ?>
                                                <a href="#" class="newsup-content-btn newsup-str-sites load"><?php esc_html_e('Start with Demo Sites','newsup'); ?></a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="newsup-getstart-image">
                                            <iframe src="https://www.youtube.com/embed/255CSHjfFJU?si=a2zBoFRrIbP44EB9" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <div class="newsup-wrapper second">
                                        <div class="newsup-feature-area newsup-d-grid column3 align-start">
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Theme Option</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=theme_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Header Option</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=theme_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Footer Option</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=theme_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Site Identity</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[section]=title_tagline') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Banner Advertisement</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=frontpage_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Top Tags</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=frontpage_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">News Ticker</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=frontpage_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Slider Section</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=frontpage_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Content Layout Settings</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=theme_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Single Post Settings</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=theme_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">You Missed Section</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=theme_option_panel') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <h3 class="newsup-feature-area-title">Widgets Settings</h3>
                                                <p class="newsup-feature-area-desc"><a href="<?php echo esc_url('customize.php?autofocus[panel]=widgets') ?>" target="_blank">Go to Customizer</a></p>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Animation Effects</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Post Content Settings</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Post Pagination Settings</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Breadcrumb Settings</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Theme Style Setting</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Color Settings</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Popup Advertisement</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Typography Settings</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Advanced Widgets Settings</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Slider Layouts</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Header Layouts</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Preloader</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Random Post</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Live Search / Ajax Search</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Header Toggle Offcanvas</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Maintenance Mode</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Schema Markup</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">SEO Setting</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Cursor Dot</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Post Like Setting</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Load more Posts</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Infinity Scroll</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Single Post Layouts</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Social Icon Repeater</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Light Dark Mode</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                            <div class="newsup-feature-box">
                                                <span class="ribbon pro">Pro</span>
                                                <h3 class="newsup-feature-area-title">Gradient Color</h3>
                                                <?php echo $this->newsup_upgrade_callback(); ?>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="newsup-wrapper four details-more">
                                        <div class="newsup-d-grid column2 gap-30">
                                            <?php echo $this->plugin_box(
                                                'ansar-import',
                                                'ansar-import/ansar-import.php',
                                                'Ansar Import – One Click Demo Import for WordPress Themes',
                                                'Ansar Import is a simple yet powerful one-click demo importer plugin for WordPress.',
                                                NEWSUP_THEME_URI . 'admin/images/ansar-icon.png',
                                                'https://wordpress.org/plugins/ansar-import/'
                                            ); ?>

                                            <?php echo $this->plugin_box(
                                                'ansar-elements',
                                                'ansar-elements/ansar-elements.php',
                                                'Post Query Loop for Blog, News & Magazine Sites – Ansar Elements',
                                                'Ansar Elements for Elementor is a complete solution for bloggers, news portals, and magazine-style websites using Elementor.',
                                                NEWSUP_THEME_URI . 'admin/images/an-icon.jpg',
                                                'https://wordpress.org/plugins/ansar-elements/'
                                            ); ?>
                                        </div>
                                    </div>
                                </div> 
                                <?php $this->newsup_admin_right_sidebar() ?>                          
                            </div>
                        </div>
                        <?php $this->render_starter_sites_tab(); ?>
                        <div class="newsup-tab-content newsup-useful-plugin">
                            <div class="newsup-plugins-tab newsup-d-grid column6 gap-30">

                                <div class="newsup-getstart-inner newsup-col-span-4">
                                    <div class="newsup-wrapper four details-more">
                                        <div class="newsup-d-grid column2 gap-30">
                                            <?php echo $this->plugin_box(
                                                'ansar-import',
                                                'ansar-import/ansar-import.php',
                                                'Ansar Import – One Click Demo Import for WordPress Themes',
                                                'Ansar Import is a simple yet powerful one-click demo importer plugin for WordPress.',
                                                NEWSUP_THEME_URI . 'admin/images/ansar-icon.png',
                                                'https://wordpress.org/plugins/ansar-import/'
                                            ); ?>

                                            <?php echo $this->plugin_box(
                                                'ansar-elements',
                                                'ansar-elements/ansar-elements.php',
                                                'Ansar Elements- Post Query Loop for Blog, News & Magazine Sites',
                                                'Ansar Elements for Elementor is a complete solution for bloggers, news portals, and magazine-style websites using Elementor.',
                                                NEWSUP_THEME_URI . 'admin/images/an-icon.jpg',
                                                'https://wordpress.org/plugins/ansar-elements/'
                                            ); ?>
                                        </div>
                                    </div>
                                </div> 
                                <?php $this->newsup_admin_right_sidebar() ?>                                
                            </div>
                        </div>
                        <div class="newsup-tab-content newsup-compare">
                            <div class="newsup-plugins-compare newsup-d-grid column6 gap-30">
                                <div class="newsup-getstart-inner newsup-col-span-4">
                                    <div class="newsup-table-main">
                                        <div class="newsup-admin-table">
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle pri">
                                                <div class="header">
                                                    <h4><?php esc_html_e('Features', 'newsup' ); ?></h4> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <h5><?php esc_html_e('Free', 'newsup' ); ?></h5>
                                                </div>
                                                <div class="checkable">
                                                    <h5 class="pro"><?php esc_html_e('Pro', 'newsup' ); ?></h5>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Live editing in Customizer', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Multiple Header Options', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Full Width Page Options', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Typography style and colors', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Preloader', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Animation Effects', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Load More Posts', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Infinity Scroll', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Social Icon Repeater', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Live Search / Ajax Search', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Light Dark Mode', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Posts Section Advertisements', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Advanced Posts Section Advertisements', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Basic Banner Featured Posts Controls', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Advanced Banner Featured Posts Controls', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Popup Advertisement', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Custom Widgets', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Advanced Custom Widgets', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Archive Layout', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class="newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Advanced Archive Layout', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Instagram Slider', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('View Related Post', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Advanced Footer Widgets', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Hide Theme Credit Link', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('WooCommerce Compatibility', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Responsive Layout', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Translations Ready', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Proper Documentation', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Updates', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Support', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Priority Support', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Prebuild Demos', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Advanced Prebuild Demos', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('SEO', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Gradient Color Option', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Breadcrumb Settings', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Random Post', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Header Layouts', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Slider Layouts', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Header Toggle Offcanvas', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Maintenance Mode', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Schema Markup', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Cursor Dot', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Post Like Setting', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                            <!-- newsup-admin-feature-table -->
                                            <div class="newsup-admin-tb-tittle">
                                                <div class=" newsup-admin-tb-list">
                                                    <span><?php esc_html_e('Single Post Layouts', 'newsup' ); ?></span> 
                                                </div>
                                                <div class="newsup-admin-tb-offer">
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-no-alt"></span>
                                                </div>
                                                <div class="checkable">
                                                    <span class="dashicons dashicons-saved"></span>
                                                </div>
                                                </div> 
                                            </div>
                                            <!-- /newsup-admin-feature-table -->
                                        </div>
                                    </div>
                                </div> 
                                <?php $this->newsup_admin_right_sidebar() ?>                                
                            </div>
                        </div>
                        <div class="newsup-tab-content newsup-change-log">
                            <div class="newsup-change-log-main newsup-d-grid column6 gap-30">
                                <div class="newsup-getstart-inner newsup-col-span-4">
                                    <pre class="newsup-change-log-content"><?php echo esc_html( $change_log ); ?></pre>
                                </div> 
                                <?php $this->newsup_admin_right_sidebar() ?>  
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    <?php }

    public function newsup_install_plugin_callback() {
        check_ajax_referer('newsup_plugin_nonce', 'nonce');

        if (!current_user_can('install_plugins')) {
            wp_send_json_error(['msg' => 'Not allowed']);
        }

        $slug = sanitize_text_field($_POST['slug']);

        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        include_once ABSPATH . 'wp-admin/includes/file.php';

        // Fetch plugin info
        $api = plugins_api('plugin_information', [
            'slug'   => $slug,
            'fields' => ['sections' => false],
        ]);

        if (is_wp_error($api)) {
            wp_send_json_error(['msg' => 'Plugin not found']);
        }

        // FAST AJAX UPGRADER (no screen output)
        $skin = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader($skin);
        $result   = $upgrader->install($api->download_link);

        if (is_wp_error($result)) {
            wp_send_json_error(['msg' => 'Install Failed']);
        }

        // Return TRUE instantly
        wp_send_json_success([
            'msg'    => 'installed',
            'plugin' => $slug,
        ]);
    }

    public function newsup_activate_plugin_callback() {
        check_ajax_referer('newsup_plugin_nonce', 'nonce');

        if (!current_user_can('activate_plugins')) {
            wp_send_json_error(['msg' => 'Not allowed']);
        }

        $plugin_file = sanitize_text_field($_POST['plugin_file']);

        $result = activate_plugin($plugin_file);

        if (is_wp_error($result)) {
            wp_send_json_error(['msg' => 'Activation failed']);
        }

        wp_send_json_success(['msg' => 'activated']);
    }

    private function plugin_box($slug, $plugin_file, $title, $desc, $image, $more_link) {

        if (!file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
            $status = "install";
            $btn_text = "Install";
            $btn_class = "btn-install";
        } elseif (!is_plugin_active($plugin_file)) {
            $status = "activate";
            $btn_text = "Activate";
            $btn_class = "btn-activate";
        } else {
            $status = "activated";
            $btn_text = "Activated";
            $btn_class = "btn-disabled";
        }

        ob_start(); ?>

        <div class="bottom-item" data-status="<?php echo esc_attr($status); ?>"
             data-slug="<?php echo esc_attr($slug); ?>"
             data-plugin="<?php echo esc_attr($plugin_file); ?> 
             ">

            <div class="head-item">
                <div class="details-image">
                    <img src="<?php echo esc_url($image); ?>" />
                </div>
                <div class="details-heading">
                    <h4><?php echo esc_html($title); ?></h4>
                </div>
            </div>
            <p class="detail-description"><?php echo esc_html($desc); ?></p>
            <div class="foot-item">
                <div class="details-btn">
                    <a href="#" class="btn-active <?php echo $btn_class; ?>">
                        <?php echo esc_html($btn_text); ?>
                    </a>
                    <a href="<?php echo esc_url($more_link); ?>" target="_blank" class="more-detail-link">
                        More Details
                    </a>
                </div>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    private function newsup_upgrade_callback(){
        return ('<p class="newsup-feature-area-desc"><a href='. esc_url('https://themeansar.com/themes/newsup-pro/','newsup') . ' target="_blank">'. esc_html('Go to Pro','newsup') . '</a></p>');
    }
       
    private function render_starter_sites_tab() {
        include dirname(__FILE__) . '/tabs/starter-sites.php';
    }
    private function newsup_admin_right_sidebar() {
        include dirname(__FILE__) . '/tabs/right-sidebar.php';
    }
}

new NewsUp_Admin();