<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Admin functions
*
* CONTENT:
* - 1) Required files
* - 2) Actions and filters
* - 3) Styles and scripts inclusion
* - 4) Admin login
* - 5) Admin dashboard customization
* - 6) Admin post/page functions
* - 7) Visual editor improvements
* - 8) Other functions
*****************************************************
*/

//define('EMPTY_TRASH_DAYS', 30); //Empties trash automatically after specific amount of days



/*
*****************************************************
*      1) REQUIRED FILES
*****************************************************
*/
	//Layouts and patterns
	require_once( WM_STYLES . 'a-layouts.php' );

	//Widgets areas
	require_once( WM_LIBRARY . 'sidebars.php' );

	//Custom posts
	//require_once( WM_CUSTOMS . 'cp-modules.php' );
	if ( 'disable' != wm_option( 'cp-role-logos' ) )
		require_once( WM_CUSTOMS . 'cp-logos.php' );
	if ( 'disable' != wm_option( 'cp-role-faq' ) )
		require_once( WM_CUSTOMS . 'cp-faq.php' );
	if ( 'disable' != wm_option( 'cp-role-prices' ) )
		require_once( WM_CUSTOMS . 'cp-price.php' );
	if ( 'disable' != wm_option( 'cp-role-projects' ) )
		require_once( WM_CUSTOMS . 'cp-projects.php' );
	if ( 'disable' != wm_option( 'cp-role-staff' ) )
		require_once( WM_CUSTOMS . 'cp-staff.php' );

	//Taxonomies
	require_once( WM_CUSTOMS . 'ct-taxonomies.php' );
	if ( 'disable' != wm_option( 'cp-role-projects' ) )
		require_once( WM_CUSTOMS . 'ct-taxonomy-form.php' );

	//Help
	if ( is_admin() && ! wm_option( 'general-no-help' ) )
		require_once( WM_HELP . 'help.php' );

	//Load the form generator functions
	if ( is_admin() && current_user_can( 'edit_posts' ) )
		require_once( WM_LIBRARY . 'form-generator.php' );

	//Admin panel
	if ( is_admin() && current_user_can( 'switch_themes' ) )
		require_once( WM_LIBRARY . 'wm-options-panel.php' );

	//Meta boxes
	if ( is_admin() && current_user_can( 'edit_pages' ) ) {
		require_once( WM_META . 'm-page.php' );
		if ( wm_option( 'contents-page-excerpt' ) )
			require_once( WM_META . 'm-excerpt.php' );
	}
	if ( is_admin() && current_user_can( 'edit_posts' ) ) {
		require_once( WM_META . 'm-post.php' );
		require_once( WM_META . 'm-cp-modules.php' );
		if ( 'disable' != wm_option( 'cp-role-logos' ) )
			require_once( WM_META . 'm-cp-logos.php' );
		if ( 'disable' != wm_option( 'cp-role-prices' ) )
			require_once( WM_META . 'm-cp-price.php' );
		if ( 'disable' != wm_option( 'cp-role-projects' ) )
			require_once( WM_META . 'm-cp-projects.php' );
		if ( 'disable' != wm_option( 'cp-role-staff' ) )
			require_once( WM_META . 'm-cp-staff.php' );
	}

	//Shortcodes
	require_once( WM_SHORTCODES . 'shortcodes.php' );
	if ( is_admin() && current_user_can( 'edit_posts' ) )
		require_once( WM_SHORTCODES . 'shortcodes-generator.php' );

	//Theme updater
	if ( is_admin() && current_user_can( 'switch_themes' ) && ! wm_option( 'general-no-update-notifier' ) )
		require_once( WM_LIBRARY . 'updater/update-notifier.php' );

	//Plugins activation
	if ( is_admin() && current_user_can( 'switch_themes' ) ) {
		require_once( WM_LIBRARY . 'plugins/plugin-activation/class-tgm-plugin-activation.php' );
		require_once( WM_LIBRARY . 'plugins/plugin-activation/plugins.php' );
	}





/*
*****************************************************
*      2) ACTIONS AND FILTERS
*****************************************************
*/
	$adminPages = array( 'page', 'post', 'wm_logos', 'wm_modules', 'wm_projects', 'wm_price', 'wm_staff' ); //admin pages with below styles and scripts applied

	//ACTIONS
		//Dasboard
		add_action( 'admin_init', 'wm_remove_dash_widgets' );
		add_action( 'right_now_content_table_end', 'wm_right_now' );
		if ( ! wm_option( 'branding-remove-dash-quickaccess' ) )
			add_action( 'wp_dashboard_setup', 'wm_add_dash_widget' );
		//Admin body classes
		add_filter( 'admin_body_class', 'wm_admin_body_class' );
		//Admin customization
		add_action( 'admin_head', 'wm_admin_head' );
		add_action( 'admin_enqueue_scripts', 'wm_admin_include' );
		//add_action( 'wp_dashboard_setup', 'wm_admin_remove_dashboard_widgets' );
		add_action( 'admin_footer', 'wm_admin_footer_scripts' );
		//Login customization
		add_action( 'login_head', 'wm_login_css' );
		//Admin menu and submenus
		if ( is_admin() )
			add_action( 'admin_menu', 'wm_change_admin_menu' );
		//add_action( '_admin_menu', 'wm_remove_editor_menu', 1 );
		//Disable comments
		if ( is_admin() && ( wm_option( 'contents-page-comments' ) || wm_option( 'contents-post-comments' ) || wm_option( 'contents-project-comments' ) ) )
			add_action ( 'admin_footer', 'wm_comments_off' );

	//FILTERS
		//TinyMCE customization
		if ( is_admin() ) {
			add_filter( 'tiny_mce_before_init', 'wm_custom_mce_format' );
			add_filter( 'mce_buttons', 'wm_add_buttons_row1' );
			add_filter( 'mce_buttons_2', 'wm_add_buttons_row2' );
		}
		//Login customization
		add_filter( 'login_headertitle', 'wm_login_headertitle' );
		add_filter( 'login_headerurl', 'wm_login_headerurl' );
		//Admin customization
		if ( is_admin() )
			add_filter( 'admin_footer_text', 'wm_admin_footer' );
		//User profile
		add_filter( 'user_contactmethods', 'wm_user_contact_methods' );
		//Post/page thumbnail in admin list
		if ( is_admin() ) {
			add_filter( 'manage_post_posts_columns', 'wm_admin_post_list_columns' );
			add_filter( 'manage_post_posts_custom_column', 'wm_admin_post_list_columns_content', 10, 2 );
			add_filter( 'manage_pages_columns', 'wm_admin_page_list_columns' );
			add_filter( 'manage_pages_custom_column', 'wm_admin_post_list_columns_content', 10, 2 );
		}
		//Change title text when creating new post
		if ( is_admin() )
			add_filter( 'enter_title_here', 'wm_change_new_post_title' );
		//Default visual editor content
		if ( is_admin() )
			add_filter( 'default_content', 'wm_default_content' );





/*
*****************************************************
*      3) STYLES AND SCRIPTS INCLUSION
*****************************************************
*/
	/*
	* Admin assets
	*/
	if ( ! function_exists( 'wm_admin_include' ) ) {
		function wm_admin_include( ) {
			global $current_screen, $adminPages;

			//styles
			if ( in_array( $current_screen->id, array( 'edit-post', 'edit-wm_projects' ) ) )
				wp_enqueue_style( 'wm-basic-icons' );
			if ( in_array( $current_screen->id, array_merge( $adminPages, array( 'nav-menus', 'edit-project-type', 'edit-wm_projects' ) ) ) )
				wp_enqueue_style( 'wm-icons' );
			wp_enqueue_style( 'wm-admin-addons' );
			if ( in_array( $current_screen->id, $adminPages ) )
				wp_enqueue_style( 'thickbox' );

			//scripts
			wp_enqueue_script( 'wm-wp-admin' );

			//WordPress 3.3+ specific
			if ( wm_check_wp_version( 3.3 ) ) {
				//feature pointers
				//find out which pointer IDs this user has already seen
				$seenIt = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
				//insert scripts only if pointers of these IDs haven't been dismissed: wmfeature01
				if ( ! in_array( 'wmfeature01', $seenIt ) ) {
					//styles
					wp_enqueue_style( 'wp-pointer' );
					//scripts
					wp_enqueue_script( 'wp-pointer' );
				}
			}

			//admin sections specific
			if ( in_array( $current_screen->id, $adminPages ) ) {
				//styles
				wp_enqueue_style( 'fancybox' );
				if ( wm_option( 'branding-panel-logo' ) || wm_option( 'branding-panel-no-logo' ) )
					wp_enqueue_style( 'wm-options-panel-white-label' );
				else
					wp_enqueue_style( 'wm-options-panel' );
				wp_enqueue_style( 'color-picker' );

				//scripts
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'jquery-ui-slider' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_script( 'fancybox' );
				wp_enqueue_script( 'wm-options-panel' );
				wp_enqueue_script( 'color-picker' );
			}
		}
	} // /wm_admin_include



	/*
	* Admin scripts codes in footer
	*/
	if ( ! function_exists( 'wm_admin_footer_scripts' ) ) {
		function wm_admin_footer_scripts() {
			global $current_screen, $adminPages, $pageTemplates;

			$out = '';

			//admin sections specific
			if ( in_array( $current_screen->id, $adminPages ) )
				$out .= "\r\n" . 'jQuery( ".wm-wrap.jquery-ui-tabs" ).tabs();';

			//excerpt field titles
			if ( 'edit' == $current_screen->parent_base && 'wm_projects' == $current_screen->id )
				$out .= "\r\n" . 'jQuery( "#postexcerpt h3.hndle span" ).html("' . addslashes( __( 'Excerpt - see the <em title="On General and Layout tab of Project Settigns metabox">Project page layout</em> option for how excerpt is displayed', 'atlantes_domain_adm' ) ) . '");';
			if ( 'edit' == $current_screen->parent_base && 'wm_staff' == $current_screen->id )
				$out .= "\r\n" . 'jQuery( "#postexcerpt h3.hndle span" ).html("' . __( 'Excerpt - short description displayed in staff list', 'atlantes_domain_adm' ) . '");';

			//display shortcode of logo categories
			if ( 'edit-tags' === $current_screen->base && 'logos-category' === $current_screen->taxonomy )
				$out .= "\r\n" . 'jQuery( ".wp-list-table td.name" ).each( function( cat ) {
					var catItem   = jQuery( this ),
					    catItemId = catItem.closest( "tr" ).find( "td.slug" ).text();

					catItem.find( "a.row-title" ).after( "<br /><input type=\"text\" onfocus=\"this.select();\" style=\"width:300px\" readonly=\"readonly\" value=\"[logos category=&quot;" + catItemId + "&quot; /]\" class=\"shortcode-in-list-table\">" );
				} );';

			//display shortcode of content module tags
			if ( 'edit-tags' === $current_screen->base && 'content-module-tag' === $current_screen->taxonomy )
				$out .= "\r\n" . 'jQuery( ".wp-list-table td.name" ).each( function( tag ) {
					var tagItem   = jQuery( this ),
					    tagItemId = tagItem.closest( "tr" ).find( "td.slug" ).text();

					tagItem.find( "a.row-title" ).after( "<br /><input type=\"text\" onfocus=\"this.select();\" style=\"width:300px\" readonly=\"readonly\" value=\"[content_module randomize=&quot;" + tagItemId + "&quot; /]\" class=\"shortcode-in-list-table\">" );
				} );';

			//display shortcode of faqs categories
			if ( 'edit-tags' === $current_screen->base && 'faq-category' === $current_screen->taxonomy )
				$out .= "\r\n" . 'jQuery( ".wp-list-table td.name" ).each( function( cat ) {
					var catItem   = jQuery( this ),
					    catItemId = catItem.closest( "tr" ).find( "td.slug" ).text();

					catItem.find( "a.row-title" ).after( "<br /><input type=\"text\" onfocus=\"this.select();\" style=\"width:300px\" readonly=\"readonly\" value=\"[faq category=&quot;" + catItemId + "&quot; /]\" class=\"shortcode-in-list-table\">" );
				} );';

			//display shortcode of price tables
			if ( 'edit-tags' === $current_screen->base && 'price-table' === $current_screen->taxonomy )
				$out .= "\r\n" . 'jQuery( ".wp-list-table td.name" ).each( function( cat ) {
					var catItem   = jQuery( this ),
					    catItemId = catItem.closest( "tr" ).find( "td.slug" ).text();

					catItem.find( "a.row-title" ).after( "<br /><input type=\"text\" onfocus=\"this.select();\" style=\"width:300px\" readonly=\"readonly\" value=\"[prices table=&quot;" + catItemId + "&quot; /]\" class=\"shortcode-in-list-table\">" );
				} );';

			//display shortcode of staff departments
			if ( 'edit-tags' === $current_screen->base && 'department' === $current_screen->taxonomy )
				$out .= "\r\n" . 'jQuery( ".wp-list-table td.name" ).each( function( cat ) {
					var catItem   = jQuery( this ),
					    catItemId = catItem.closest( "tr" ).find( "td.slug" ).text();

					catItem.find( "a.row-title" ).after( "<br /><input type=\"text\" onfocus=\"this.select();\" style=\"width:300px\" readonly=\"readonly\" value=\"[staff department=&quot;" + catItemId + "&quot; /]\" class=\"shortcode-in-list-table\">" );
				} );';

			//remove page templates
			if ( function_exists( 'wp_get_theme' ) ) {
				foreach ( $pageTemplates as $file => $name ) {
					$id = sanitize_title( str_replace( '/', '-', $file ) );
					if ( wm_option( 'contents-' . $id ) )
						$out .= "\r\n" . 'jQuery( "#page_template option[value=\"' . $file . '\"]" ).remove()';
				}
			}
			if ( 'disable' === wm_option( 'cp-role-projects' ) )
				$out .= "\r\n" . 'jQuery( "#page_template option[value=\"page-templates/portfolio.php\"]" ).remove()';

			//feature pointers
				//pointer IDs: wmfeature01
				$pointerContent['wmfeature01'] = array(
						//object where the pointer displays
						'#contextual-help-link',
						//pointer content
						'<h3>' . __( 'Documentation in Help', 'atlantes_domain_adm' ) . '</h3><p>' . __( 'The theme extends WordPress contextual help, making it convenient resource of information. Please, check this first if you get stuck or need more info on a topic.', 'atlantes_domain_adm' ) . '</p><p><strong>' . __( 'The whole shortcode documentation can be found here, but you can sure use Shortcode Generator, which is much more easier.', 'atlantes_domain_adm' ) . '</strong></p><p>' . sprintf( __( 'Additional resource: <a%s>Theme user manual</a>.', 'atlantes_domain_adm' ), ' href="' . WM_ONLINE_MANUAL_URL . '" target="_blank"' ) . '</p>'
					);
				$seenIt = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
				//insert scripts only if pointers of these IDs haven't been dismissed: wmfeature01
				if ( ! in_array( 'wmfeature01', $seenIt ) )
					$out .= '
							if ( typeof( jQuery().pointer ) != "undefined" ) {
								jQuery( "' . $pointerContent['wmfeature01'][0] . '" )
									.pointer( {
										pointerClass : "wp-pointer wmfeature01",
										pointerWidth : 320,
										content : "' . addslashes( $pointerContent['wmfeature01'][1] ) . '",
										position : {
												edge  : "top",
												align : "right"
											},
										close : function() {
												jQuery.post( ajaxurl, {
														pointer : "wmfeature01",
														action  : "dismiss-wp-pointer"
													} );
											}
									} )
									.pointer( "open" );
							}
						';

			//output
			if ( $out )
				echo '
					<script type="text/javascript">
					//<![CDATA[
					jQuery(function() {
						' . $out . '
					});
					//]]>
					</script>';
		}
	} // /wm_admin_footer_scripts





/*
*****************************************************
*      4) ADMIN LOGIN
*****************************************************
*/
	/*
	* Login CSS styles file
	*/
	if ( ! function_exists( 'wm_login_css' ) ) {
		function wm_login_css() {
			$url = WM_ASSETS_ADMIN . 'css/login-addon.css.php';

			echo '<link rel="stylesheet" type="text/css" href="' . $url . '" media="screen" />' . "\r\n";
		}
	} // /wm_login_css



	/*
	* Login logo title
	*/
	if ( ! function_exists( 'wm_login_headertitle' ) ) {
		function wm_login_headertitle() {
			return get_bloginfo( 'name' );
		}
	} // /wm_login_headertitle



	/*
	* Login logo URL
	*/
	if ( ! function_exists( 'wm_login_headerurl' ) ) {
		function wm_login_headerurl() {
			return home_url();
		}
	} // /wm_login_headerurl





/*
*****************************************************
*      5) ADMIN DASHBOARD CUSTOMIZATION
*****************************************************
*/
	/*
	* Admin footer text customization
	*/
	if ( ! function_exists( 'wm_admin_footer' ) ) {
		function wm_admin_footer() {
			$out = ( wm_option( 'branding-admin-footer' ) ) ? ( '&copy; ' . get_bloginfo( 'name' ) . ' | ' . wm_option( 'branding-admin-footer' ) ) : ( '&copy; ' . get_bloginfo( 'name' ) . ' | Powered by <a href="http://wordpress.org/">WordPress</a> | Customized by <a href="http://www.webmandesign.eu">WebMan</a>' );

			echo $out;
		}
	} // /wm_admin_footer



	/*
	* Admin HTML head
	*/
	if ( ! function_exists( 'wm_admin_head' ) ) {
		function wm_admin_head() {
			global $current_screen, $adminPages;

			$out            = '';
			$noPreviewPosts = array( 'wm_logos', 'wm_modules', 'wm_faq', 'wm_price' );
			if ( ! wm_option( 'cp-staff-rich' ) )
				$noPreviewPosts[] = 'wm_staff';

			//HTML5 tags registration for WordPress 3.2- (just in case)
			if ( ! wm_check_wp_version( '3.3' ) )
				echo '<!--[if lt IE 9]>' . "\r\n" . '<script src="' . WM_ASSETS_THEME . 'js/html5.js" type="text/javascript"></script>' . "\r\n" . '<![endif]-->' . "\r\n";

			//removing unnecessary view buttons
			if ( in_array( $current_screen->post_type, $noPreviewPosts ) )
				$out .= "\r\n" . '.row-actions .view, #view-post-btn, #preview-action {display: none}';

			//WordPress admin bar logo
			if ( wm_option( 'branding-admin-bar-no-logo' ) )
				$out .= '#wp-admin-bar-wp-logo {display: none !important}' . "\r\n";

			//homepage colorize
			if ( 'edit-page' == $current_screen->id )
				$out .= '.hentry.post-' . get_option( 'page_on_front' ) . ' {background: #d7eef4}' . "\r\n" .
					'.hentry.post-' . get_option( 'page_for_posts' ) . ' {background: #d7f4e3}' . "\r\n";
			if ( 'options-reading' == $current_screen->id )
				$out .= '#front-static-pages li + li {margin-top: 15px} #front-static-pages label {padding: 10px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;}' . "\r\n" .
					'#front-static-pages label[for="page_on_front"] {background: #d7eef4}' . "\r\n" .
					'#front-static-pages label[for="page_for_posts"] {background: #d7f4e3}' . "\r\n";

			if ( $out )
				echo '<style type="text/css">' . "\r\n" . $out . '</style>' . "\r\n";
		}
	} // /wm_admin_head



	/*
	* Rearrange admin menu items
	*
	* Thanks to Randy Hoyt (http://randyhoyt.com/) for inspiration
	*/
	if ( ! function_exists( 'wm_change_admin_menu' ) ) {
		function wm_change_admin_menu() {
			global $menu;

			if ( ! wm_option( 'general-default-menu' ) ) {
				$menu[6] = $menu[5]; //copies "Posts" one position down
				$menu[5] = $menu[20]; //copies "Pages" on "Posts" position
				unset( $menu[20] ); //removes original "Pages" position
			}

			if ( wm_option( 'branding-remove-menu-posts' ) && ! wm_option( 'general-default-menu' ) )
				unset( $menu[6] );
			if ( wm_option( 'branding-remove-menu-posts' ) && wm_option( 'general-default-menu' ) )
				unset( $menu[5] );
			if ( wm_option( 'branding-remove-menu-media' ) )
				remove_menu_page( 'upload.php' );
			if ( wm_option( 'branding-remove-menu-comments' ) )
				remove_menu_page( 'edit-comments.php' );

			//$menu[29] = $menu[4]; //separator

			if ( wm_option( 'branding-admin-use-logo' ) && wm_option( 'branding-admin-logo' ) ) {
				$menu[2][0] = '<img src="' . esc_url( wm_option( 'branding-admin-logo' ) ) . '" alt="" />';
				$menu[2][5] = 'wm-admin-logo';
				unset( $menu[4] ); //removes separator
			}
		}
	} // /wm_change_admin_menu



	/*
	* Remove dashboard widgets
	*/
	if ( ! function_exists( 'wm_remove_dash_widgets' ) ) {
		function wm_remove_dash_widgets() {
			//Right Now
			if ( wm_option( 'branding-remove-dash-rightnow' ) )
				remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
			//Recent Comments
			if ( wm_option( 'branding-remove-dash-recentcomments' ) )
				remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
			//Incoming Links
			if ( wm_option( 'branding-remove-dash-incominglinks' ) )
				remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
			//Plugins
			if ( wm_option( 'branding-remove-dash-plugins' ) )
				remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
			//Quick Press
			if ( wm_option( 'branding-remove-dash-quickpress' ) )
				remove_meta_box( 'dashboard_quick_press', 'dashboard', 'normal' );
			//Recent Drafts
			if ( wm_option( 'branding-remove-dash-recentdrafts' ) )
				remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'normal' );
			//WordPress Blog
			if ( wm_option( 'branding-remove-dash-wpprimary' ) )
				remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
			//Other WordPress News
			if ( wm_option( 'branding-remove-dash-wpsecondary' ) )
				remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		}
	} // /wm_remove_dash_widgets



	/*
	* Add dashboard widgets
	*/
	if ( ! function_exists( 'wm_add_dash_widget' ) ) {
		function wm_add_dash_widget() {
			$title = wm_option( 'branding-dash-quickaccess-title' );

			//$widget_id, $widget_name, $callback, $control_callback
			wp_add_dashboard_widget( 'wm-quick-access', $title . '&nbsp;', 'wm_custom_dash_widget' );
		}
	} // /wm_add_dash_widget

	/*
	* Custom dashboard widget content
	*/
	if ( ! function_exists( 'wm_custom_dash_widget' ) ) {
		function wm_custom_dash_widget() {
			$out = $outLinks = '';

			$userCan = array(
				''        => 'edit_posts', //just placeholder
				'disable' => 'edit_posts', //just placeholder
				'post'    => 'edit_posts',
				'page'    => 'edit_pages'
				);

			if ( current_user_can( 'edit_pages' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=page"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-pages-32x32-white.png" alt="" /><span>' . __( 'Pages', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( 'edit_posts' ) && ! wm_option( 'branding-remove-menu-posts' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-posts-32x32-white.png" alt="" /><span>' . __( 'Posts', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( 'moderate_comments' ) && ! wm_option( 'branding-remove-menu-comments' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit-comments.php"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-comments-32x32-white.png" alt="" /><span>' . __( 'Comments', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( $userCan[wm_option( 'cp-role-projects' )] ) && 'disable' !== wm_option( 'cp-role-projects' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=wm_projects"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-portfolio-32x32-white.png" alt="" /><span>' . __( 'Projects', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( $userCan[wm_option( 'cp-role-logos' )] ) && 'disable' !== wm_option( 'cp-role-logos' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=wm_logos"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-clients-32x32-white.png" alt="" /><span>' . __( 'Logos', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( $userCan[wm_option( 'cp-role-modules' )] ) && 'disable' !== wm_option( 'cp-role-modules' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=wm_modules"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-modules-32x32-white.png" alt="" /><span>' . __( 'Modules', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( $userCan[wm_option( 'cp-role-faq' )] ) && 'disable' !== wm_option( 'cp-role-faq' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=wm_faq"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-faq-32x32-white.png" alt="" /><span>' . __( 'FAQ', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( $userCan[wm_option( 'cp-role-prices' )] ) && 'disable' !== wm_option( 'cp-role-prices' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=wm_price"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-price-32x32-white.png" alt="" /><span>' . __( 'Prices', 'atlantes_domain_adm' ) . '</span></a>';

			if ( current_user_can( $userCan[wm_option( 'cp-role-staff' )] ) && 'disable' !== wm_option( 'cp-role-staff' ) )
				$outLinks .= '<a href="' . get_admin_url() . 'edit.php?post_type=wm_staff"><img src="' . WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-team-32x32-white.png" alt="" /><span>' . __( 'Staff', 'atlantes_domain_adm' ) . '</span></a>';

			$outLinks = ( $outLinks ) ? ( '<p class="links">' . $outLinks . '</p>' ) : ( '' );

			$outText = wm_option( 'branding-dash-quickaccess-text' );
			if ( $outText )
				$outText = '<div class="text">' . apply_filters( 'the_content', $outText ) . '</div>';

			if ( $outLinks && $outText )
				$out = $outLinks . '<hr />' . $outText;
			elseif ( $outLinks )
				$out = $outLinks;
			else
				$out = $outText;

			echo $out;
		}
	} // /wm_custom_dash_widget





/*
*****************************************************
*      6) ADMIN POST/PAGE FUNCTIONS
*****************************************************
*/
	/*
	* Admin post list columns
	*
	* $columns = ARRAY [check WordPress codex on this]
	*/
	if ( ! function_exists( 'wm_admin_post_list_columns' ) ) {
		function wm_admin_post_list_columns( $columns ) {
			$add             = array_slice( $columns, 0, 1 );
			$add['wm-thumb'] = __( 'Image', 'atlantes_domain_adm' );
			$columns         = array_merge( $add, array_slice( $columns, 1 ) );

			return $columns;
		}
	} // /wm_admin_post_list_columns

	/*
	* Admin page list columns
	*
	* $columns = ARRAY [check WordPress codex on this]
	*/
	if ( ! function_exists( 'wm_admin_page_list_columns' ) ) {
		function wm_admin_page_list_columns( $columns ) {
			$add                    = array_slice( $columns, 0, 2 );
			$add['wm-thumb']        = __( 'Image', 'atlantes_domain_adm' );
			$columns                = array_merge( $add, array_slice( $columns, 2 ) );
			$columns['wm-template'] = __( 'Page template', 'atlantes_domain_adm' );

			return $columns;
		}
	} // /wm_admin_page_list_columns

	/*
	* Admin post list columns content
	*
	* $columns = ARRAY [check WordPress codex on this]
	* $post_id = # [current post ID]
	*/
	if ( ! function_exists( 'wm_admin_post_list_columns_content' ) ) {
		function wm_admin_post_list_columns_content( $columns, $post_id ) {
			switch ( $columns ) {
				case 'wm-thumb': //post/page thumbnail

					$overlay = '';
					if ( wm_meta_option( 'slider-type' ) && 'none' != wm_meta_option( 'slider-type' ) ) {
						$sliderImg = ( file_exists( WM_ASSETS_ADMIN . 'img/sliders/' . wm_meta_option( 'slider-type' ) . '.png' ) ) ? ( WM_ASSETS_ADMIN . 'img/sliders/' . wm_meta_option( 'slider-type' ) . '.png' ) : ( WM_ASSETS_ADMIN . 'img/sliders/custom.png' );
						$overlay = '<span class="overlay"><img src="' . $sliderImg . '" alt="" title="' . sprintf( __( 'Page with %s slider', 'atlantes_domain_adm' ), ucfirst( wm_meta_option( 'slider-type' ) ) ) . '" /></span>';
					}

					$imageTitle = ( has_post_format( 'status' ) ) ? ( __( 'Status text: ', 'atlantes_domain_adm' ) . esc_attr( strip_tags( get_the_content() ) ) ) : ( esc_attr( strip_tags( get_the_title() ) ) );
					$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, 'widget', array( 'title' => $imageTitle ) ) ) : ( '' );
					$image = ( ! has_post_thumbnail() && $overlay ) ? ( '' ) : ( $image );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					if ( 'post' == get_post_type( $post_id ) && get_post_format() ) {
						$icon = get_post_format();
						if ( has_post_format( 'status' ) )
							$icon = 'user';
						echo '<i class="wmicon-' . esc_attr( $icon ) . '"></i>';
					} elseif ( 'post' == get_post_type( $post_id ) ) {
						echo '<i class="wmicon-pencil"></i>';
					}

					echo '<span class="wm-image-container' . $hasThumb . '">';

					if ( get_edit_post_link() )
						edit_post_link( $image );
					else
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';

					echo edit_post_link( $overlay ) . '</span>';

				break;
				case 'wm-template': //page template

					$tplFile = get_post_meta( $post_id, '_wp_page_template', TRUE );

					if ( $tplFile && 'default' != $tplFile ) {
						$tplName = array_search( $tplFile, get_page_templates() );
						edit_post_link( '<strong>"' . $tplName . '"</strong>' );
					}

				break;
			}
		}
	} // /wm_admin_post_list_columns_content





/*
*****************************************************
*      7) VISUAL EDITOR IMPROVEMENTS
*****************************************************
*/
	add_editor_style( 'assets/css/visual-editor.css' );



	/*
	* Add buttons to visual editor first row
	*
	* $buttons = ARRAY [default WordPress visual editor buttons array]
	*/
	if ( ! function_exists( 'wm_add_buttons_row1' ) ) {
		function wm_add_buttons_row1( $buttons ) {
			//inserting buttons after "italic" button
			$pos = array_search( 'italic', $buttons, true );
			if ( $pos != false ) {
				$add = array_slice( $buttons, 0, $pos + 1 );
				$add[] = 'underline';
				$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
			}

			//inserting buttons after "justifyright" button
			$pos = array_search( 'justifyright', $buttons, true );
			if ( $pos != false ) {
				$add = array_slice( $buttons, 0, $pos + 1 );
				$add[] = 'justifyfull';
				$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
			}

			//inserting buttons after "link" buttons group
			$pos = array_search( 'unlink', $buttons, true );
			if ( $pos != false ) {
				$add = array_slice( $buttons, 0, $pos + 1 );
				$add[] = 'anchor';
				$add[] = '|';
				$add[] = 'hr';
				$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
			}

			//inserting buttons after "more" button
			$pos = array_search( 'wp_more', $buttons, true );
			if ( $pos != false ) {
				$add = array_slice( $buttons, 0, $pos + 1 );
				$add[] = 'wp_page';
				$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
			}

			return $buttons;
		}
	} // /wm_add_buttons_row1

	/*
	* Add buttons to visual editor second row
	*
	* $buttons = ARRAY [default WordPress visual editor buttons array]
	*/
	if ( ! function_exists( 'wm_add_buttons_row2' ) ) {
		function wm_add_buttons_row2( $buttons ) {
			//inserting buttons before "underline" button
			$pos = array_search( 'underline', $buttons, true );
			if ( $pos != false ) {
				$add = array_slice( $buttons, 0, $pos );
				$add[] = 'styleselect';
				$add[] = '|';
				$add[] = 'removeformat';
				$add[] = '|';
				$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
			}

			//remove "justify full" button from second row
			$pos = array_search( 'justifyfull', $buttons, true );
			if ( $pos != false ) {
				unset( $buttons[$pos] );
				$add = array_slice( $buttons, 0, $pos + 1 );
				$add[] = '|';
				$add[] = 'sub';
				$add[] = 'sup';
				$add[] = '|';
				$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
			}

			return $buttons;
		}
	} // /wm_add_buttons_row2



	/*
	* Customizing format dropdown items and styles dropdown
	*
	* $init = ARRAY [check WordPress codex on this]
	*/
	if ( ! function_exists( 'wm_custom_mce_format' ) ) {
		function wm_custom_mce_format( $init ) {
			//define styles
			/*
			title [required]
				= label for this dropdown item

			selector | block | inline [required]
				= selector limits the style to a specific HTML tag, and will apply the style to an existing tag instead of creating one
				= block creates a new block-level element with the style applied, and WILL REPLACE the existing block element around the cursor
				= inline creates a new inline element with the style applied, and will wrap whatever is selected in the editor, not replacing any tags

			classes [optional]
				= space-separated list of classes to apply to the element

			styles [optional]
				= array of inline styles to apply to the element (two-word attributes, like font-weight, are written in Javascript-friendly camel case: fontWeight)

			attributes [optional]
				= assigns attributes to the element (same syntax as styles)

			wrapper [optional, default = false]
				= if set to true, creates a NEW BLOCK-LEVEL ELEMENT AROUND ANY SELECTED BLOCK-LEVEL ELEMENTS

			exact [optional, default = false]
				= disables the "merge similar styles" feature, needed for some CSS inheritance issues
			*/
			$styles = array(

				//others
					array(
						'title'    => __( 'Framed image', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected image', 'atlantes_domain_adm' ) . '"></span>',
						'selector' => 'img',
						'classes'  => 'frame'
					),
					array(
						'title'    => __( 'Clear floats', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected paragraph, heading, list, blockquote or DIV', 'atlantes_domain_adm' ) . '"></span>',
						'selector' => 'p,h1,h2,h3,h4,h5,h6,ul,ol,blockquote,div',
						'classes'  => 'clear'
					),
					array(
						'title'    => __( 'Remove top margin', 'atlantes_domain_adm' ). ' <span class="inline-help" title="' . __( 'Apply on selected paragraph, heading, list or address element', 'atlantes_domain_adm' ) . '"></span>',
						'selector' => 'p,h1,h2,h3,h4,h5,h6,ul,ol,address',
						'classes'  => 'mt0'
					),
					array(
						'title'    => __( 'Fully bordered table', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected table', 'atlantes_domain_adm' ) . '"></span>',
						'selector' => 'table',
						'classes'  => 'table-bordered'
					),

				//boxes
					array(
						'title' => __( 'BOXES', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected text.', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'   => __( 'Blue box', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'box color-blue',
							'exact'   => true,
							'wrapper' => true
						),
						array(
							'title'   => __( 'Gray box', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'box color-gray',
							'exact'   => true,
							'wrapper' => true
						),
						array(
							'title'   => __( 'Green box', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'box color-green',
							'exact'   => true,
							'wrapper' => true
						),
						array(
							'title'   => __( 'Orange box', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'box color-orange',
							'exact'   => true,
							'wrapper' => true
						),
						array(
							'title'   => __( 'Red box', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'box color-red',
							'exact'   => true,
							'wrapper' => true
						),
						array(
							'title'    => __( 'Add Info icon', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on box', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'div.box',
							'classes'  => 'iconbox info'
						),
						array(
							'title'    => __( 'Add Question icon', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on box', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'div.box',
							'classes'  => 'iconbox question'
						),
						array(
							'title'    => __( 'Add Check icon', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on box', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'div.box',
							'classes'  => 'iconbox check'
						),
						array(
							'title'    => __( 'Add Warning icon', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on box', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'div.box',
							'classes'  => 'iconbox warning'
						),
						array(
							'title'    => __( 'Add Cancel icon', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on box', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'div.box',
							'classes'  => 'iconbox cancel'
						),
						array(
							'title'    => __( 'Make hero box', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on box', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'div.box',
							'classes'  => 'hero'
						),

				//buttons
					array(
						'title' => __( 'BUTTONS', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected link, that will be transformed to medium size button', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'    => __( 'Blue button', 'atlantes_domain_adm' ),
							'selector' => 'a',
							'classes'  => 'btn color-blue'
						),
						array(
							'title'    => __( 'Gray button', 'atlantes_domain_adm' ),
							'selector' => 'a',
							'classes'  => 'btn color-gray'
						),
						array(
							'title'    => __( 'Green button', 'atlantes_domain_adm' ),
							'selector' => 'a',
							'classes'  => 'btn color-green'
						),
						array(
							'title'    => __( 'Orange button', 'atlantes_domain_adm' ),
							'selector' => 'a',
							'classes'  => 'btn color-orange'
						),
						array(
							'title'    => __( 'Red button', 'atlantes_domain_adm' ),
							'selector' => 'a',
							'classes'  => 'btn color-red'
						),
						array(
							'title'    => __( 'Make button small', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on button', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'a.btn',
							'classes'  => 'size-small'
						),
						array(
							'title'    => __( 'Make button large', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on button', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'a.btn',
							'classes'  => 'size-large'
						),
						array(
							'title'    => __( 'Make button extra large', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on button', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'a.btn',
							'classes'  => 'size-extra-large'
						),

				//code
					array(
						'title' => __( 'CODE', 'atlantes_domain_adm' )
					),
						array(
							'title'  => __( 'Inline code HTML tag', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected unformated text', 'atlantes_domain_adm' ) . '"></span>',
							'inline' => 'code'
						),

				//columns
					array(
						'title' => __( 'COLUMNS', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected unformated text. You can format the text afterwards.', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'   => __( 'Column 1/2', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-12'
						),
							array(
								'title'   => __( 'Column 1/2 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-12 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 1/3', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-13'
						),
							array(
								'title'   => __( 'Column 1/3 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-13 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 2/3', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-23'
						),
							array(
								'title'   => __( 'Column 2/3 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-23 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 1/4', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-14'
						),
							array(
								'title'   => __( 'Column 1/4 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-14 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 3/4', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-34'
						),
							array(
								'title'   => __( 'Column 3/4 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-34 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 1/5', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-15'
						),
							array(
								'title'   => __( 'Column 1/5 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-15 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 2/5', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-25'
						),
							array(
								'title'   => __( 'Column 2/5 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-25 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 3/5', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-35'
						),
							array(
								'title'   => __( 'Column 3/5 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-35 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),
						array(
							'title'   => __( 'Column 4/5', 'atlantes_domain_adm' ),
							'block'   => 'div',
							'classes' => 'column col-45'
						),
							array(
								'title'   => __( 'Column 4/5 last', 'atlantes_domain_adm' ),
								'block'   => 'div',
								'classes' => 'column col-45 last',
								'attributes' => array(
									'dataLast' => 'last'
									)
							),

				//divider
					array(
						'title' => __( 'DIVIDER', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected horizontal line element.', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'    => __( 'Fading sides', 'atlantes_domain_adm' ),
							'selector' => 'hr',
							'classes'  => 'fading'
						),
						array(
							'title'    => __( 'Dashed border', 'atlantes_domain_adm' ),
							'selector' => 'hr',
							'classes'  => 'dashed'
						),
						array(
							'title'    => __( 'Dotted border', 'atlantes_domain_adm' ),
							'selector' => 'hr',
							'classes'  => 'dotted'
						),
						array(
							'title'    => __( 'Double border with star', 'atlantes_domain_adm' ),
							'selector' => 'hr',
							'classes'  => 'star'
						),
						array(
							'title'    => __( 'Shadow bottom', 'atlantes_domain_adm' ),
							'selector' => 'hr',
							'classes'  => 'shadow-bottom'
						),
						array(
							'title'    => __( 'Shadow top', 'atlantes_domain_adm' ),
							'selector' => 'hr',
							'classes'  => 'shadow-top'
						),

				//dropcaps
					array(
						'title' => __( 'DROPCAPS', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected letter', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'   => __( 'Normal dropcap', 'atlantes_domain_adm' ),
							'inline'  => 'span',
							'classes' => 'dropcap'
						),
						array(
							'title'   => __( 'Rounded dropcap', 'atlantes_domain_adm' ),
							'inline'  => 'span',
							'classes' => 'dropcap round'
						),
						array(
							'title'   => __( 'Square dropcap', 'atlantes_domain_adm' ),
							'inline'  => 'span',
							'classes' => 'dropcap square'
						),
						array(
							'title'   => __( 'Leaf dropcap', 'atlantes_domain_adm' ),
							'inline'  => 'span',
							'classes' => 'dropcap leaf'
						),

				//markers, highlights
					array(
						'title' => __( 'MARKERS', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected unformated text', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'   => __( 'Blue marker', 'atlantes_domain_adm' ),
							'inline'  => 'mark',
							'classes' => 'marker color-blue'
						),
						array(
							'title'   => __( 'Gray marker', 'atlantes_domain_adm' ),
							'inline'  => 'mark',
							'classes' => 'marker color-gray'
						),
						array(
							'title'   => __( 'Green marker', 'atlantes_domain_adm' ),
							'inline'  => 'mark',
							'classes' => 'marker color-green'
						),
						array(
							'title'   => __( 'Orange marker', 'atlantes_domain_adm' ),
							'inline'  => 'mark',
							'classes' => 'marker color-orange'
						),
						array(
							'title'   => __( 'Red marker', 'atlantes_domain_adm' ),
							'inline'  => 'mark',
							'classes' => 'marker color-red'
						),

				//quotes
					array(
						'title' => __( 'QUOTES', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected blockquote element', 'atlantes_domain_adm' ) . '"></span>'
					),
						array(
							'title'   => __( 'Cite (quoted author)', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Insert it inside blockquote element', 'atlantes_domain_adm' ) . '"></span>',
							'inline'  => 'cite',
							'classes' => 'quote-source'
						),
						array(
							'title'    => __( 'Left pullquote', 'atlantes_domain_adm' ),
							'selector' => 'blockquote',
							'classes'  => 'pullquote alignleft'
						),
						array(
							'title'    => __( 'Right pullquote', 'atlantes_domain_adm' ),
							'selector' => 'blockquote',
							'classes'  => 'pullquote alignright'
						),

				//text
					array(
						'title' => __( 'TEXT', 'atlantes_domain_adm' ),
					),
						array(
							'title'   => __( 'Small text', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected text', 'atlantes_domain_adm' ) . '"></span>',
							'inline'  => 'small',
							'classes' => ''
						),
						array(
							'title'    => __( 'Big text', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected paragraph or heading element', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'p,h2,h3,h4,h5,h6',
							'classes'  => 'size-big'
						),
						array(
							'title'    => __( 'Huge text', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected paragraph or heading element', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'p,h2,h3,h4,h5,h6',
							'classes'  => 'size-huge'
						),
						array(
							'title'   => __( 'Uppercase', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected text', 'atlantes_domain_adm' ) . '"></span>',
							'inline'  => 'span',
							'classes' => 'uppercase'
						),
						array(
							'title'    => __( 'Alternate font', 'atlantes_domain_adm' ) . ' <span class="inline-help" title="' . __( 'Apply on selected paragraph, heading, DIV, table element or on a link', 'atlantes_domain_adm' ) . '"></span>',
							'selector' => 'p,h2,h3,h4,h5,h6,div,table,a',
							'classes'  => 'font-secondary'
						),

			);

			$init['style_formats'] = json_encode( $styles );

			//format buttons, default = 'p,address,pre,h1,h2,h3,h4,h5,h6'
			$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6,address,div';

			//command separated string of extended elements
			$ext = 'pre[id|name|class|style]';
			//add to extended_valid_elements if it alreay exists
			if ( isset( $init['extended_valid_elements'] ) )
				$init['extended_valid_elements'] .= ',' . $ext;
			else
				$init['extended_valid_elements'] = $ext;

			return $init;
		}
	} // /wm_custom_mce_format





/*
*****************************************************
*      8) OTHER FUNCTIONS
*****************************************************
*/
	/*
	* Adding new contact fields to WordPress user profile
	*
	* $user_contactmethods = ARRAY [default WordPress user account contact fields]
	*/
	if ( ! function_exists( 'wm_admin_body_class' ) ) {
		function wm_admin_body_class( $classes ) {
			global $post;

			if ( isset( $post ) && is_object( $post ) ) {
				$postType = get_post_type( $post->ID );

				if ( is_admin() && 'wm_modules' == $postType )
					$classes .= 'post-type-' . $postType;
			}

			return $classes;
		}
	} // /wm_admin_body_class



	/*
	* Adding new contact fields to WordPress user profile
	*
	* $user_contactmethods = ARRAY [default WordPress user account contact fields]
	*/
	if ( ! function_exists( 'wm_user_contact_methods' ) ) {
		function wm_user_contact_methods( $user_contactmethods ) {
			//unset( $user_contactmethods['yim'] );
			//unset( $user_contactmethods['aim'] );
			//unset( $user_contactmethods['jabber'] );

			if ( ! isset( $user_contactmethods['twitter'] ) )
				$user_contactmethods['twitter'] = 'Twitter';
			if ( ! isset( $user_contactmethods['facebook'] ) )
				$user_contactmethods['facebook'] = 'Facebook';
			if ( ! isset( $user_contactmethods['googleplus'] ) )
				$user_contactmethods['googleplus'] = 'Google+';

			return $user_contactmethods;
		}
	} // /wm_user_contact_methods



	/*
	* Switch page/post/projects comments and pingbacks off
	*/
	if ( ! function_exists( 'wm_comments_off' ) ) {
		function wm_comments_off() {
			global $current_screen;

			$postType = array();
			if ( wm_option( 'contents-page-comments' ) )
				$postType[] = 'page';
			if ( wm_option( 'contents-post-comments' ) )
				$postType[] = 'post';
			if ( wm_option( 'contents-project-comments' ) )
				$postType[] = 'wm_projects';

			if ( ! empty( $postType ) && isset( $current_screen->post_type ) && in_array( $current_screen->post_type, $postType ) && isset( $current_screen->action ) && 'add' == $current_screen->action ) {
				$out = '<script><!--
					if ( document.post ) {
						var the_comment = document.post.comment_status,
						    the_ping    = document.post.ping_status;
						if ( the_comment && the_ping ) {
							the_comment.checked = false;
							the_ping.checked    = false;
						}
					}
					//--></script>';

				echo $out;
			}
		}
	} // /wm_comments_off



	/*
	* Changes "Enter title here" text when creating new post
	*/
	if ( ! function_exists( 'wm_change_new_post_title' ) ) {
		function wm_change_new_post_title( $title ){
			$screen = get_current_screen();

			if ( 'wm_logos' == $screen->post_type )
				$title = __( "Name / title", 'atlantes_domain_adm' );

			if ( 'wm_staff' == $screen->post_type )
				$title = __( "Person's name", 'atlantes_domain_adm' );

			if ( 'wm_price' == $screen->post_type )
				$title = __( "Price column title", 'atlantes_domain_adm' );

			if ( 'wm_faq' == $screen->post_type )
				$title = __( "Enter question here", 'atlantes_domain_adm' );

			return $title;
		}
	} // /wm_change_new_post_title



	/*
	* Default visual editor content for specific custom posts
	*/
	if ( ! function_exists( 'wm_default_content' ) ) {
		function wm_default_content( $content ) {
			global $current_screen;

			$iconShortcodes = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( '<li>[icon type="icon-check" /]</li><li>[icon type="icon-cancel" /]</li>' ) : ( '' );

			if ( ! ( 'add' === $current_screen->action && 'post' === $current_screen->base ) )
				return $content;

			if ( 'wm_price' === $current_screen->id )
				$content = '
					<ul>
						<li>' . __( '<strong>Your feature</strong> goes here', 'atlantes_domain_adm' ) . '</li>
						<li>' . __( '<strong>Another feature</strong> on separate list item', 'atlantes_domain_adm' ) . '</li>
						<li>' . __( 'Will be automatically centered', 'atlantes_domain_adm' ) . '</li>'
						. $iconShortcodes . '
					</ul>
					';

			if ( 'wm_faq' === $current_screen->id )
				$content = '<p>' . __( 'Your answer goes here...', 'atlantes_domain_adm' ) . '</p>';

			if ( 'wm_staff' === $current_screen->id )
				$content = ( wm_option( 'cp-staff-rich' ) ) ? ( '<p>' . __( 'Rich staff member info goes here, place the short description into excerpt field below...', 'atlantes_domain_adm' ) . '</p>' ) : ( '<p>' . __( 'Staff member info goes here...', 'atlantes_domain_adm' ) . '</p>' );

			return $content;
		}
	} // /wm_default_content



	/*
	* Extend "Right now" dashboard widget
	*
	* Thanks: http://new2wp.com/snippet/add-custom-post-types-to-the-right-now-dashboard-widget/
	*/
	if ( ! function_exists( 'wm_right_now' ) ) {
		function wm_right_now() {
			$args = array(
					'public'   => true,
					'_builtin' => false
				);
			$output   = 'object';
			$operator = 'and';

			$post_types = get_post_types( $args, $output, $operator );

			foreach( $post_types as $post_type ) {
				$num_posts = wp_count_posts( $post_type->name );
				$num       = number_format_i18n( $num_posts->publish );
				$text      = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );

				if ( current_user_can( 'edit_posts' ) ) {
					$num  = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
					$text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
				}
				echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
				echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
			}
		}
	} // /wm_right_now

?>