<?php 
$newsup_background_image = get_theme_support( 'custom-header', 'default-image' );
$newsup_bcrumb_section_enable = get_theme_mod('bcrumb_section_enable',true);
$newsup_site_breadcrumb_type = get_theme_mod('newsup_site_breadcrumb_type','default');
if ( has_header_image() ) { $newsup_background_image = get_header_image(); } 
if ( ! $newsup_bcrumb_section_enable ) {
  return;
}
?>
  <div class="mg-breadcrumb-section">
    <div class="overlay">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="mg-breadcrumb-title">
              <?php if($newsup_site_breadcrumb_type == 'yoast') {
                if( function_exists( 'yoast_breadcrumb' ) ) {
                  yoast_breadcrumb();
                }
              } elseif($newsup_site_breadcrumb_type == 'navxt') {
                if( function_exists( 'bcn_display' ) ) {
                  bcn_display();
                }                                        
              } elseif($newsup_site_breadcrumb_type == 'rankmath') {
                if( function_exists( 'rank_math_the_breadcrumbs' ) ) {
                  rank_math_the_breadcrumbs();
                }                                        
              } else {
                if( class_exists( 'WooCommerce' )) {
                  if(is_shop()) { ?>
                    <h1 class="title"><?php woocommerce_page_title();?></h1><?php
                  } elseif(is_product_category() || is_product_tag()){ 
                    the_archive_title( '<h2 class="title">', '</h2>' );
                  } elseif(is_archive()) {
                    the_archive_title( '<h1 class="title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                  } elseif ( is_404() ) { ?>
                    <ul class="mg-page-breadcrumb">
                      <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'newsup' ); ?></a></li>
                      <li class="active"><?php esc_html_e( '404', 'newsup' ); ?></li>
                    </ul>
                  <?php
                  } elseif(is_search()){ ?>
                    <h1><?php /* translators: %s: search term */ printf( esc_html__( 'Search Results for: %s','newsup'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1> <?php
                    newsup_search_count();
                  } else { ?>
                    <h1 class="title"><?php the_title(); ?></h1>
                  <?php }
                } elseif(is_archive()) {
                  the_archive_title( '<h1 class="title">', '</h1>' );
                  the_archive_description( '<div class="archive-description">', '</div>' );
                } elseif ( is_404() ) { ?>
                  <ul class="mg-page-breadcrumb">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'newsup' ); ?></a></li>
                    <li class="active"><?php esc_html_e( '404', 'newsup' ); ?></li>
                  </ul>
                <?php
                } elseif(is_search()){ ?>
                  <h1><?php /* translators: %s: search term */ printf( esc_html__( 'Search Results for: %s','newsup'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1> <?php
                  newsup_search_count();
                } else { ?>
                  <h1 class="title"><?php the_title(); ?></h1>
                <?php }
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>