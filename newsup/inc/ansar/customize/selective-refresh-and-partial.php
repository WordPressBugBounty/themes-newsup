<?php
function newsup_selective_refresh( $wp_customize ) {
	
	
	if (isset($wp_customize->selective_refresh)) {	

		$wp_customize->selective_refresh->add_partial('custom_logo', array(
			'selector'        => '.site-logo', 
			'render_callback' => 'custom_logo_selective_refresh'
		));
		$wp_customize->selective_refresh->add_partial('blogname', array(
			'selector'        => '.site-title a, .site-title-footer a',
			'render_callback' => 'newsup_customize_partial_blogname',
		));		
		$wp_customize->selective_refresh->add_partial('blogdescription', array(
			'selector'        => '.site-description, .site-description-footer',
			'render_callback' => 'newsup_customize_partial_blogdescription',
		));
		$wp_customize->selective_refresh->add_partial('header_social_icon_enable', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_fb_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_fb_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_twt_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_twt_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_lnkd_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_lnkd_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_insta_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_insta_insta_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_youtube_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_youtube_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_pintrest_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_pintrest_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_tele_link', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('newsup_header_tele_target', array(
			'selector'        => '.mg-headwidget .mg-head-detail .mg-social',
			'render_callback' => 'newsup_customize_partial_header_social_icon_enable',
		));
		$wp_customize->selective_refresh->add_partial('banner_advertisement_section', array(
			'selector'        => '.mg-headwidget .mg-nav-widget-area .col-md-3 + .col-md-9',
			'render_callback' => 'newsup_customize_partial_banner_advertisement_section',
		));
		$wp_customize->selective_refresh->add_partial('banner_advertisement_section_url', array(
			'selector'        => '.mg-headwidget .mg-nav-widget-area .col-md-3 + .col-md-9',
			'render_callback' => 'newsup_customize_partial_banner_advertisement_section',
		));
		$wp_customize->selective_refresh->add_partial('newsup_open_on_new_tab', array(
			'selector'        => '.mg-headwidget .mg-nav-widget-area .col-md-3 + .col-md-9',
			'render_callback' => 'newsup_customize_partial_banner_advertisement_section',
		));
		$wp_customize->selective_refresh->add_partial('select_slider_news_category', array(
			'selector'        => '.homemain',
			'render_callback' => '.newsup_customize_partial_select_slider_news_category',
		));
		$wp_customize->selective_refresh->add_partial('latest_tab_title', array(
			'selector'        => '.top-right-area .nav-tabs',
			'render_callback' => '.newsup_customize_partial_latest_tab_title',
		));
		$wp_customize->selective_refresh->add_partial('show_popular_tags_title', array(
			'selector'        => '.mg-tpt-txnlst strong',
			'render_callback' => 'newsup_customize_partial_show_popular_tags_title',
		));
		$wp_customize->selective_refresh->add_partial('header_data_enable', array(
			'selector'        => '.mg-head-detail .info-left',
			'render_callback' => 'newsup_customize_partial_newsup_date_time',
		));
		$wp_customize->selective_refresh->add_partial('header_time_enable', array(
			'selector'        => '.mg-head-detail .info-left',
			'render_callback' => 'newsup_customize_partial_newsup_date_time',
		));
		$wp_customize->selective_refresh->add_partial('newsup_date_time_show_type', array(
			'selector'        => '.mg-head-detail .info-left',
			'render_callback' => 'newsup_customize_partial_newsup_date_time',
		));
		$wp_customize->selective_refresh->add_partial('flash_news_title', array(
			'selector'        => '.mg-latest-news .bn_title .title',
			'render_callback' => 'newsup_customize_partial_flash_news_title',
		));
		$wp_customize->selective_refresh->add_partial('you_missed_title', array(
			'selector'        => '.missed-inner .mg-sec-title h4',
			'render_callback' => 'newsup_customize_partial_you_missed_title',
		));
		$wp_customize->selective_refresh->add_partial('footer_social_icon_enable', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_fb_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_fb_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_twt_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_twt_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_lnkd_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_lnkd_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_insta_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_insta_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_youtube_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_youtube_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_pinterest_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_pinterest_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_tele_link', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_footer_tele_target', array(
			'selector'        => 'footer .mg-footer-bottom-area .mg-social',
			'render_callback' => 'newsup_customize_partial_footer_social_icon',
		));
		$wp_customize->selective_refresh->add_partial('newsup_related_post_title', array(
			'selector'        => '.mg-featured-slider .mg-sec-title h4',
			'render_callback' => 'newsup_customize_partial_newsup_related_post_title',
		));
		$wp_customize->selective_refresh->add_partial('header_search_enable', array(
			'selector'        => '.mg-search-box',
			'render_callback' => 'newsup_customize_partial_header_search_enable',
		));
		$wp_customize->selective_refresh->add_partial('header_subsc_enable', array(
			'selector'        => '.btn-bell',
			'render_callback' => 'newsup_customize_partial_newsup_subsc',
		));
		$wp_customize->selective_refresh->add_partial('newsup_subsc_link', array(
			'selector'        => '.btn-bell',
			'render_callback' => 'newsup_customize_partial_newsup_subsc',
		));
		$wp_customize->selective_refresh->add_partial('newsup_subsc_link_target', array(
			'selector'        => '.btn-bell',
			'render_callback' => 'newsup_customize_partial_newsup_subsc',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_footer_menu', array(
			'selector'        => '.mg-footer-copyright',
			'render_callback' => 'newsup_customize_partial_newsup_enable_footer_menu',
		));
		$wp_customize->selective_refresh->add_partial('post_image_type', array(
			'selector'        => '.mg-posts-sec.mg-posts-modul-6 .mg-posts-sec-inner',
			'render_callback' => 'newsup_customize_partial_post_image_type',
		));
		$wp_customize->selective_refresh->add_partial('post_image_type', array(
			'selector'        => '#grid.row.grid-content',
			'render_callback' => 'newsup_customize_partial_grid_post_image_type',
		));
		$wp_customize->selective_refresh->add_partial('newsup_content_layout', array(
			'selector'        => '#content.home > .row, .archive-class > .row',
			'render_callback' => 'newsup_customize_partial_content_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_page_layout', array(
			'selector'        => '.page-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_page_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_single_page_layout', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_single_post_category', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_single_post_admin_details', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_single_post_date', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_single_post_tag', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('single_show_featured_image', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('single_show_share_icon', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_single_post_admin_details', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_related_post', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_single_post_category', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_single_post_date', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_single_post_admin', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('newsup_enable_single_post_comments', array(
			'selector'        => '.single-class > .container-fluid > .row',
			'render_callback' => 'newsup_customize_partial_single_layout',
		));
		$wp_customize->selective_refresh->add_partial('you_missed_enable', array(
			'selector'        => '.missed-section.mg-posts-sec-inner',
			'render_callback' => 'newsup_customize_partial_you_missed',
		));
	}
}
add_action( 'customize_register', 'newsup_selective_refresh' );

/**
 * Render the selective refresh partial.
 *
 * @return void
 */
function newsup_customize_partial_blogname() {
	bloginfo('name');
}

function newsup_customize_partial_blogdescription() {
	bloginfo('description');
}

function newsup_customize_partial_select_slider_news_category() {
	return get_theme_mod( 'select_slider_news_category' );
}

function newsup_customize_partial_latest_tab_title() {
	return get_theme_mod( 'latest_tab_title' );
}

function newsup_customize_partial_banner_advertisement_section() {
	return do_action( 'newsup_action_banner_advertisement' );
}

function newsup_customize_partial_header_social_icon_enable() {
	if( get_theme_mod( 'header_social_icon_enable' ) == false ) return;
	return do_action('newsup_action_header_social_icon');
}

function newsup_customize_partial_newsup_date_time() {
	if( get_theme_mod( 'header_data_enable' ) === false &&  get_theme_mod('header_time_enable') === false ) return;
	return newsup_date_display_type();
}

function newsup_customize_partial_show_popular_tags_title() {
	return get_theme_mod( 'show_popular_tags_title' );
}

function newsup_customize_partial_flash_news_title() {
	return get_theme_mod( 'flash_news_title' );
}

function newsup_customize_partial_flash_news_section(){
	return do_action('newsup_action_banner_exclusive_posts');
}

function newsup_customize_partial_you_missed_title() {
    return get_theme_mod( 'you_missed_title' );
}

function newsup_customize_partial_footer_social_icon() {
    return do_action('newsup_action_footer_social_icon');
}

function newsup_customize_partial_newsup_related_post_title() {
    return get_theme_mod( 'newsup_related_post_title' );
}

function newsup_customize_partial_header_search_enable(){
	return do_action('newsup_action_header_search');
}

function newsup_customize_partial_newsup_subsc(){
	return do_action('newsup_action_header_subscribe');
}

function newsup_customize_partial_newsup_enable_footer_menu(){
	return do_action('newsup_action_footer_copyright');
}

function newsup_customize_partial_post_image_type(){
	return do_action('newsup_action_main_list_content');
}

function newsup_customize_partial_grid_post_image_type(){
	return do_action('newsup_action_main_grid_content');
}

function custom_logo_selective_refresh() {
	if( get_theme_mod( 'custom_logo' ) === "" ) return;
	echo '<div class="site-logo">'.the_custom_logo().'</div>';
}

function newsup_customize_partial_content_layout(){
	return do_action('newsup_action_main_content_layouts');
}

function newsup_customize_partial_you_missed(){
	return do_action('newsup_action_footer_missed');
}

function newsup_customize_partial_page_layout() {
	return get_template_part('template-parts/content', 'page');
}

function newsup_customize_partial_single_layout() {
	return get_template_part('template-parts/content', 'single');
}