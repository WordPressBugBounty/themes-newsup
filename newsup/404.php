<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Newsup
 */
get_header(); ?>
<!--==================== Newsup breadcrumb section ====================-->
<?php get_template_part('index','banner'); ?>
  <!--==================== main content section ====================-->
  <!--container-->
  <div id="content" class="container-fluid home 404">
    <!--row-->
      <!--container-->
      <div class="col-md-12 text-center mg-section-404"> 
        <!--mg-error-404-->
        <div class="mg-error-404">
          <h1><?php esc_html_e('4','newsup'); ?><i class="fas fa-ban"></i>4</h1>
          <h4><?php esc_html_e('Oops! Page not found','newsup'); ?></h4>
          <p><?php esc_html_e("We are sorry, but the page you are looking for does not exist.","newsup"); ?></p>
          <a href="<?php echo esc_url(home_url());?>" onClick="history.back();" class="btn btn-theme"><?php esc_html_e('Go Back','newsup'); ?></a> </div>
        <!--/mg-error-404--> 
      </div>
      <!--/col-md-12--> 
  </div>
  <!--/container-->
<?php
get_footer();