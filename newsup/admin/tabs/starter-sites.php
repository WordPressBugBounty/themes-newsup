<?php
if (!defined('ABSPATH')) exit;
?>
<div class="newsup-tab-content starter-sites">
    <?php if ( ! is_plugin_active( 'ansar-import/ansar-import.php' ) ) { ?>
    <div class="newsup-modal-main">
        <div class="newsup-modal-image overlay">
            <img src="<?php echo esc_url(NEWSUP_THEME_URI) . 'admin/images/demos.jpg' ?>" alt="">
        </div>
        <div class="newsup-modal-popup">
            <div class="newsup-modal-popup-content">
                <div class="newsup-modal-icon">
                    <img src="<?php echo esc_url(NEWSUP_THEME_URI) . 'admin/images/ansar-import-logo.png' ?>" alt="">
                </div>
                <div>
                    <h4><?php esc_html_e("Ansar Import","newsup"); ?></h4>
                    <p><?php esc_html_e("Click View Demo Button to install a ready-made News & Magazine Demos — fast, simple, and customizable.","newsup"); ?></p>
                    <a href="#" class="newsup-btn-ins newsup-str-sites load" >
                        <?php 
                            esc_html_e( 'View Demos', 'newsup' );
                        ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php } else { 
        
        // <!-- This file should primarily consist of HTML with a little bit of PHP. -->
        $cat_data = wp_remote_get(esc_url_raw('https://api.themeansar.com/wp-json/wp/v2/categories?_fields=id,name,slug&post_type=demos&per_page=50&exclude=1'), [ 'timeout' => 15 ]);
        $cat_data_body = wp_remote_retrieve_body($cat_data);
        $all_categories = json_decode($cat_data_body, TRUE);

        $theme_data = wp_get_theme();
        $theme_name = $theme_data->get('Name');
        $theme_slug = $theme_data->get('TextDomain');
        
        $theme_data_api = wp_remote_get(esc_url_raw("https://api.themeansar.com/wp-json/wp/v2/demos/?orderby=menu_order&order=asc&search=%27" . urlencode($theme_name) . "%27&per_page=50"), [ 'timeout' => 15 ]);

        $theme_data_api_body = wp_remote_retrieve_body($theme_data_api);
        $all_demos = json_decode($theme_data_api_body, TRUE);

        $present_cat = array();
        $present_cat = array_values(array_unique($present_cat));

        if (count($all_demos) == 0) {
            wp_die('This theme is not supported yet!');
        }

        //print_r($theme_data_api);
        foreach ($all_demos as $demo) {
            foreach ($demo['categories'] as $in_cat) {
                // echo $in_cat.'<br>';
                array_push($present_cat, $in_cat['id']);
            }
        }

        $present_cat = array_values(array_unique($present_cat));
        ?>

        <hr class="wp-header-end">
        <div class="theme-browser rendered demo-ansar-container newsup-ansar-importer">
            <div class="themes wp-clearfix">
                <!-- Filter Controls -->
                <div uk-filter="target: .js-filter">
                    <ul class="uk-subnav uk-subnav-pill">
                        <li class="uk-active" uk-filter-control><a href="#">All</a></li>
                        <?php
                        foreach ($all_categories as $category) {
                            if (in_array($category['id'], $present_cat)) {
                                ?>
                                <li uk-filter-control="[data-color*='cat_<?php echo esc_html($category['id']); ?>']"><a href="#"><?php echo esc_attr($category['name']); ?></a></li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                    <div class="js-filter grid-wrap">
                        <?php
                        //  print_r($all_demos);
                        foreach ($all_demos as $demo) {  $c = 0; ?>
                            <div class="ansar-inner-box" data-color="<?php
                                foreach ($demo['categories'] as $in_cat) {
                                    echo "cat_" . esc_attr($in_cat['id']) . " ";
                                }
                                ?>">
                                <!-- product -->
                                <div class="uk-card theme" style="width: 100%;" tabindex="0">
                                    <div class="theme-screenshot">
                                        <?php if ($theme_name != $demo['theme_name']) { ?>
                                            <span class="ribbon pro">
                                                <?php esc_html_e('Pro','ansar-import'); ?>
                                            </span>
                                            <?php } else { ?>
                                            <span class="ribbon">
                                                <?php esc_html_e('Free','ansar-import'); ?>
                                            </span>
                                        <?php } ?>
                                        <img src="<?php echo esc_url($demo['preview_url']); ?>" >
                                    </div>
                                    <span class="more-details btn-preview" data-id="<?php echo absint($demo['id']); ?>" data-live="<?php  if(get_option( 'ansar_demo_installed' )== $demo['id']){ echo 1; }?>" data-toggle="modal" data-target="#AnsardemoPreview"><?php esc_html_e('Preview','ansar-import'); ?></span>
                                    <div class="theme-author"><?php esc_html_e('By Themeansar','ansar-import'); ?> </div>
                                    <div class="theme-id-container">
                                        <div class="theme-names-about">
                                            <h2 class="theme-name" id=""><?php echo esc_attr($demo['title']['rendered']); ?></h2>
                                            <?php $lastcat = end($demo['categories']);
                                                foreach ($demo['categories'] as $in_cat) {
                                                if($c == 0){
                                                    echo '<ul class="theme-cate">';
                                                    $c++;
                                                }
                                                echo '<li class="theme-cate-item">'.$in_cat['name'].'</li>';
                                                
                                                if ($in_cat === $lastcat) {
                                                    echo "</ul>";
                                                }
                                            } ?>
                                        </div>
                                        <div class="theme-actions">
                                            <?php if ($theme_name != $demo['theme_name']) {
                                                ?>
                                                <a class="button activate" target="_new" href="<?php echo esc_url($demo['pro_link']); ?>" >
                                                    <?php esc_html_e('Buy Now','ansar-import'); ?></a>
                                            <?php } else {
                
                                                ?>
                                                <a class="button activate live-btn-<?php echo absint($demo['id']); ?> <?php  if(get_option( 'ansar_demo_installed' )!= $demo['id']){ echo "uk-hidden"; }?> " target="_new" data-id="<?php echo absint($demo['id']); ?>"  href="<?php echo esc_url(home_url()); ?>">Live Preview</a>
                                                <button type="button" class="<?php  if(get_option( 'ansar_demo_installed' )== $demo['id']){ echo "uk-hidden"; }?> button activate btn-import btn-import-<?php echo absint($demo['id']); ?>" href="#" data-id="<?php echo absint($demo['id']); ?>"><?php esc_html_e('Import','ansar-import'); ?></button>
                                                <?php }  ?>
                                            <a class="button button-primary load-customize hide-if-no-customize btn-preview" data-id="<?php echo absint($demo['id']); ?>" data-toggle="modal" data-target="#AnsardemoPreview" href="#"><?php esc_html_e('Preview','ansar-import'); ?></a>

                                        </div>
                                    </div>    
                                </div>
                                <!-- /product -->
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /product -->
                </div>
            </div>
        </div>
        <!-- This file should primarily consist of HTML with a little bit of PHP. -->

        <!-- Modal -->
        <div id="AnsardemoPreview" tabindex="-1" class="uk-modal-full" uk-modal>
            <!-- main include -->   
            <div class="theme-install-overlay wp-full-overlay expanded iframe-ready" style="display: block;">
                <div class="wp-full-overlay-sidebar">
                    
                    <div class="wp-full-overlay-header">
                        <button class="close-full-overlay"><span class="screen-reader-text"><?php esc_html_e('Close', 'ansar-import'); ?></span></button>
                        <a class="button activate preview-live-btn uk-hidden" target="_new"  href="<?php echo esc_url(home_url()); ?>"> <?php esc_html_e('Live Preview','ansar-import'); ?></a>
                        <button type="button" class="button button-primary import-priview activate btn-import" href="#" data-id="0"><?php esc_html_e('Import', 'ansar-import'); ?></button>
                        <a class="button activate preview-buy uk-hidden" target="_new" href="#" ><?php esc_html_e('Buy Now', 'ansar-import'); ?></a>
                    </div>

                    <div class="wp-full-overlay-sidebar-content">
                        <div class="install-theme-info">
                            <h3 class="theme-name"> <?php echo esc_html($theme_data->get('Name')); ?> </h3>
                            <span class="theme-by"><?php esc_html_e('By', 'ansar-import'); ?> <?php echo esc_attr($theme_data->get('Author')); ?> </span>
                            <img class="theme-screenshot" src="" alt="">
                            <div class="theme-details">
                                <div class="theme-version"><?php echo esc_html($theme_data->get('Version')); ?></div>
                                <div class="theme-description"><?php echo esc_html($theme_data->get('Description')); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="wp-full-overlay-footer">

                        <button type="button" class="collapse-sidebar button" aria-expanded="true" aria-label="Collapse Sidebar">
                            <span class="collapse-sidebar-arrow"></span>
                            <span class="collapse-sidebar-label"><?php esc_html_e('Collapse', 'ansar-import'); ?></span>
                        </button>
                        <div class="devices-wrapper">
                            <div class="devices">
                                <button type="button" class="preview-desktop active" aria-pressed="true" data-device="desktop">
                                    <span class="screen-reader-text"><?php esc_html_e('Enter desktop preview mode', 'ansar-import'); ?><?php esc_html_e('Collapse', 'ansar-import'); ?></span>
                                </button>
                                <button type="button" class="preview-tablet" aria-pressed="false" data-device="tablet">
                                    <span class="screen-reader-text"><?php esc_html_e('Enter tablet preview mode', 'ansar-import'); ?></span>
                                </button>
                                <button type="button" class="preview-mobile" aria-pressed="false" data-device="mobile">
                                    <span class="screen-reader-text"><?php esc_html_e('Enter mobile preview mode', 'ansar-import'); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wp-full-overlay-main">
                    <iframe id="theme_preview" title="Preview"></iframe> 
                </div>
            </div>
            <!-- main include -->   
        </div>
        <!-- Modal preview  End -->
        <div id="ImportConfirm" class="ansar-modal" style="display: none;">
            <div class="ansar-modal-dialog ansar-import-options" id="ansar-import-options">
                <button class="ansar-modal-close-default" type="button" id="closeConfirm">&times;</button>
                <div class="ansar-modal-header">
                    <h2 class="ansar-modal-title"><?php esc_html_e('Confirmation', 'ansar-import'); ?></h2>
                </div>

                <div class="ansar-modal-body">
                    <div class="demo-import-confirm-message"><?php echo sprintf('Importing demo data will ensure that your site will look similar as theme demo. It makes you easy to modify the content instead of creating them from scratch. Also, consider before importing the demo: <ol><li>Importing the demo on the site if you have already added the content is highly discouraged.</li> <li>You need to import demo on fresh WordPress install to exactly replicate the theme demo.</li> <li>It will install the required plugins as well as activate them for installing the required theme demo within your site.</li> <li>Copyright images will get replaced with other placeholder images.</li> <li>None of the posts, pages, attachments or any other data already existing in your site will be deleted or modified.</li> <li>It will take some time to import the theme demo.</li></ol>', 'ansar-import'); ?></div>
                </div>

                <ul class="import-option-list">
                    <li class="active">
                        <input class="ansar-checkbox" type="checkbox" id="import-customizer" name="import-customizer" checked="checked">
                        <label for="import-customizer"><?php esc_html_e('Import Customize Settings', 'ansar-import'); ?></label>
                    </li>
                    <li class="active">
                        <input class="ansar-checkbox" type="checkbox" id="import-widgets" name="import-widgets" checked="checked">
                        <label for="import-widgets"><?php esc_html_e('Import Widgets', 'ansar-import'); ?></label>
                    </li>
                    <li>
                        <input class="ansar-checkbox" type="checkbox" id="import-content" name="import-content" checked="checked">
                        <label for="import-content"><?php esc_html_e('Import Content', 'ansar-import'); ?></label>
                    </li>
                </ul>

                <div class="ansar-modal-footer">
                    <form method="post" class="import">
                        <input type="hidden" name="theme_id" id="theme_id" value="0">
                        <?php wp_nonce_field('ansar_demo_import_nonce'); ?>
                        <button type="button" class="ansar-button ansar-button-default" id="cancelModal"><?php esc_html_e('Close', 'ansar-import'); ?></button>
                        <button type="button" class="ansar-button ansar-button-primary" id="import_data" ><?php esc_html_e('Confirm', 'ansar-import'); ?></button>
                    </form>
                </div>

            </div>
            <div class="ansar-modal-dialog ansar-importing" id="ansar-importing" style="display: none;">
                <div class="ansar-intall-importer">
                    <div class="inner">
                        <div class="heading">
                            <h4 class="title">Importing Demo Data</h4>
                        </div>  
                        <div class="ansar-import-menu" id="ansar_import_menu">
                            <div class="progress-tooltip">
                                <span class="progress-tooltip-info" style="left: 0%;">0%</span>
                                <progress class="progress" value="0" max="100">0%</progress>
                            </div>
                            <ul class="ansar-import-tabs" id="ansar_import_tabs">
                                <li class="tab_disabled dashicons" id="demo_file_step">
                                    <a href="#">Checking Theme Data Files</a>
                                </li>
                                <li class="tab_disabled dashicons" id="demo_import_step">
                                    <a href="#">Importing Theme Data </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ansar-modal-dialog ansar-import-complete" id="ansar-import-complete"  style="display: none;" >
                <div class="ansar-intall-importer imported">
                    <button class="ansar-modal-close-default" type="button" id="importDoneClose">&times;</button>
                    <div class="inner">
                        <div class="succes-icon"></div>
                        <div class="heading">
                            <h4 class="title">🎉 Import Complete Successfully</h4>
                            <p>Your site is now ready. Start exploring and customizing!</p>
                        </div> 
                        <div class="ansar-import-action">
                        <a href="<?php echo esc_url(home_url()); ?>" target="_blank" class="ansar-button">visit your site</a>
                        <a href="<?php echo esc_url(admin_url()); ?>" class="ansar-button no-bg">back to dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>