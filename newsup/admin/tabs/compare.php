<?php 
// Admin Compare Table
?>

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
	    <?php function newsup_admin_table_compare( $feature, $free = false ) { ?>
			<!-- newsup-admin-feature-table -->
			<div class="newsup-admin-tb-tittle">
				<div class="newsup-admin-tb-list">
					<span><?php echo esc_html( $feature ); ?></span>
				</div>
				<div class="newsup-admin-tb-offer">
					<div class="checkable">
						<span class="dashicons dashicons-<?php echo $free ? 'saved' : 'no-alt'; ?>"></span>
					</div>
					<div class="checkable">
						<span class="dashicons dashicons-saved"></span>
					</div>
				</div>
			</div>
			<!-- /newsup-admin-feature-table -->
		<?php }

		newsup_admin_table_compare( __( 'Live editing in Customizer', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Multiple Header Options', 'newsup' ) );
		newsup_admin_table_compare( __( 'Full Width Page Options', 'newsup' ) );
		newsup_admin_table_compare( __( 'Typography style and colors', 'newsup' ) );
		newsup_admin_table_compare( __( 'Preloader', 'newsup' ) );
		newsup_admin_table_compare( __( 'Animation Effects', 'newsup' ) );
		newsup_admin_table_compare( __( 'Load More Posts', 'newsup' ) );
		newsup_admin_table_compare( __( 'Infinity Scroll', 'newsup' ) );
		newsup_admin_table_compare( __( 'Social Icon Repeater', 'newsup' ) );
		newsup_admin_table_compare( __( 'Live Search / Ajax Search', 'newsup' ) );
		newsup_admin_table_compare( __( 'Light Dark Mode', 'newsup' ) );
		newsup_admin_table_compare( __( 'Posts Section Advertisements', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Advanced Posts Section Advertisements', 'newsup' ) );
		newsup_admin_table_compare( __( 'Basic Banner Featured Posts Controls', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Advanced Banner Featured Posts Controls', 'newsup' ) );
		newsup_admin_table_compare( __( 'Popup Advertisement', 'newsup' ) );
		newsup_admin_table_compare( __( 'Custom Widgets', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Advanced Custom Widgets', 'newsup' ) );
		newsup_admin_table_compare( __( 'Archive Layout', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Advanced Archive Layout', 'newsup' ) );
		newsup_admin_table_compare( __( 'Instagram Slider', 'newsup' ) );
		newsup_admin_table_compare( __( 'View Related Post', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Advanced Footer Widgets', 'newsup' ) );
		newsup_admin_table_compare( __( 'Hide Theme Credit Link', 'newsup' ) );
		newsup_admin_table_compare( __( 'WooCommerce Compatibility', 'newsup' ) );
		newsup_admin_table_compare( __( 'Responsive Layout', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Translations Ready', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Proper Documentation', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Updates', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Support', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Priority Support', 'newsup' ) );
		newsup_admin_table_compare( __( 'Prebuild Demos', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Advanced Prebuild Demos', 'newsup' ) );
		newsup_admin_table_compare( __( 'SEO', 'newsup' ), true );
		newsup_admin_table_compare( __( 'Gradient Color Option', 'newsup' ) );
		newsup_admin_table_compare( __( 'Breadcrumb Settings', 'newsup' ) );
		newsup_admin_table_compare( __( 'Random Post', 'newsup' ) );
		newsup_admin_table_compare( __( 'Header Layouts', 'newsup' ) );
		newsup_admin_table_compare( __( 'Slider Layouts', 'newsup' ) );
		newsup_admin_table_compare( __( 'Header Toggle Offcanvas', 'newsup' ) );
		newsup_admin_table_compare( __( 'Maintenance Mode', 'newsup' ) );
		newsup_admin_table_compare( __( 'Schema Markup', 'newsup' ) );
		newsup_admin_table_compare( __( 'Cursor Dot', 'newsup' ) );
		newsup_admin_table_compare( __( 'Post Like Setting', 'newsup' ) );
		newsup_admin_table_compare( __( 'Single Post Layouts', 'newsup' ) );

		?>
	</div>
</div>