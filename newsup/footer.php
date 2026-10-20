<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Newsup
 */
?>
    <div class="container-fluid missed-section mg-posts-sec-inner">
        <?php do_action('newsup_action_footer_missed'); ?>
    </div>
    <!--==================== FOOTER AREA ====================-->
    <?php
    $newsup_footer_widget_background = get_theme_mod( 'newsup_footer_widget_background' );
    $newsup_footer_overlay_color     = get_theme_mod( 'newsup_footer_overlay_color' );
    ?>
    <footer class="footer back-img"<?php if ( ! empty( $newsup_footer_widget_background ) ) : ?> style="background-image:url('<?php echo esc_url( $newsup_footer_widget_background ); ?>');"<?php endif; ?>>
        <div class="overlay"<?php if ( ! empty( $newsup_footer_overlay_color ) ) : ?> style="background-color:<?php echo esc_attr( $newsup_footer_overlay_color ); ?>;"<?php endif; ?>>
        <?php do_action('newsup_action_footer_widget_area'); 
        do_action('newsup_action_footer_bottom_area'); ?>
            <div class="mg-footer-copyright">
                <?php do_action('newsup_action_footer_copyright'); ?>
            </div>
        <!--/overlay-->
        </div>
    </footer>
    <!--/footer-->
  </div>
    <!--/wrapper-->
   <?php do_action('newsup_action_footer_scroller'); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>