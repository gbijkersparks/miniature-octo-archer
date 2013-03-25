<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Content Module custom post meta boxes
*
* CONTENT:
* - 1) Actions and filters
* - 2) Meta box form
* - 3) Saving meta
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Adding meta boxes
		add_action( 'edit_form_after_title', 'wm_modules_metabox_start', 1000 );
		add_action( 'edit_form_after_editor', 'wm_modules_metabox_end', 1 );
		//Saving CP
		add_action( 'save_post', 'wm_modules_cp_save_meta' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_modules_meta_fields' ) ) {
		function wm_modules_meta_fields() {
			global $post, $sidebarPosition, $projectLayouts;

			$prefix = 'module-';
			$postId = ( $post ) ? ( $post->ID ) : ( null );

			//Get icons
			$fontFile      = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
			$fontIcons     = wm_fontello_classes( $fontFile );
			$menuIcons     = array();
			$menuIcons[''] = __( '- select icon -', 'lespaul_domain_adm' );
			foreach ( $fontIcons as $icon ) {
				$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
			}

			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general",
					"title" => __( 'Icon', 'lespaul_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( 'Custom link', 'lespaul_domain_adm' ),
						"desc" => __( 'If set, the link will be applied on featured image and module title', 'lespaul_domain_adm' ),
						"validate" => "url"
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."type",
						"label" => __( 'Icon box', 'lespaul_domain_adm' ),
						"desc" => __( 'Style this module as icon box', 'lespaul_domain_adm' ),
						"value" => "icon"
					),
					array(
						"id" => "icon-box-settings",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "space"
						),
						array(
							"type" => "box",
							"content" => '<h4>' . __( 'Set the predefined icon below or upload your custom one as featured image', 'lespaul_domain_adm' ) . '</h4><p>' . __( 'Predefined icons are high DPI / Retina display ready.', 'lespaul_domain_adm' ) . '</p><p>' . __( 'If you upload a custom icon, note that icon dimensions should be 32&times;32 px (24&times;24 if custom icon background set) in default layout, or 64&times;64 px (48&times;48 if custom icon background set) in centered icon box display layout. For high DPI / Retina displays double the size of the icon (it will be automatically scaled down).', 'lespaul_domain_adm' ) . '<br /><a class="button thickbox button-set-featured-image" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Set featured image', 'lespaul_domain_adm' ) . '</a>' . '</p>' . __( 'Layout can be set in shortcode or in widget parameters when displaying the Content Module.', 'lespaul_domain_adm' ),
						),
						array(
							"type" => "select",
							"id" => $prefix."font-icon",
							"label" => __( 'Predefined icon', 'lespaul_domain_adm' ),
							"desc" => __( 'Select an icon to display with this icon module (the icons are ready for high DPI / Retina displays). This icon will be prioritized over icon uploaded as featured image.', 'lespaul_domain_adm' ),
							"options" => $menuIcons,
							"icons" => true
						),
						array(
							"type" => "color",
							"id" => $prefix."icon-box-color",
							"label" => __( 'Custom icon background', 'lespaul_domain_adm' ),
							"desc" => __( 'Leave empty for no background color', 'lespaul_domain_adm' ),
							"default" => "",
							"validate" => "color"
						),
					array(
						"conditional" => array(
							"field" => WM_THEME_SETTINGS_PREFIX . $prefix . "type",
							"custom" => array( "input", "name", "checkbox" ),
							"value" => "icon"
							),
						"id" => "icon-box-settings",
						"type" => "inside-wrapper-close"
					),

				array(
					"type" => "section-close"
				)

			);

			return $metaFields;
		}
	} // /wm_modules_meta_fields



	/*
	* Meta form generator start
	*/
	if ( ! function_exists( 'wm_modules_metabox_start' ) ) {
		function wm_modules_metabox_start() {
			global $post;

			if ( 'wm_modules' != $post->post_type )
				return;

			$metaFields = wm_modules_meta_fields();

			wp_nonce_field( 'wm_modules-metabox-nonce', 'wm_modules-metabox-nonce' );

			//Display meta box form HTML
			$out = '<div class="wm-wrap meta meta-special jquery-ui-tabs">';

				//Tabs
				$out .= '<ul class="tabs no-js">';
				$out .= '<li class="item-0 visual-editor"><a href="#wm-meta-visual-editor">' . __( 'Content', 'lespaul_domain_adm' ) . '</a></li>';
				$i = 0;
				foreach ( $metaFields as $tab ) {
					if ( 'section-open' == $tab['type'] ) {
						++$i;
						$out .= '<li class="item-' . $i . ' ' . $tab['section-id'] . '"><a href="#wm-meta-' . $tab['section-id'] . '">' . $tab['title'] . '</a></li>';
					}
				}
				$out .= '</ul> <!-- /tabs -->';

			echo $out;

			$editorTabContent = array(
				array(
					"type" => "section-open",
					"section-id" => "visual-editor",
				)
			);

			//Content
			wm_render_form( $editorTabContent, 'meta' );
		}
	} // /wm_modules_metabox_start



	/*
	* Meta form generator end
	*/
	if ( ! function_exists( 'wm_modules_metabox_end' ) ) {
		function wm_modules_metabox_end() {
			global $post;

			if ( 'wm_modules' != $post->post_type )
				return;

			$metaFields = wm_modules_meta_fields();
			$metaFields = array_merge( array( array( "type" => "section-close" ) ), $metaFields );

			//Content
			wm_render_form( $metaFields, 'meta' );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'lespaul_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'lespaul_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		}
	} // /wm_modules_metabox_end





/*
*****************************************************
*      3) SAVING META
*****************************************************
*/
	/*
	* Saves post meta options
	*
	* $post_id = # [current post ID]
	*/
	if ( ! function_exists( 'wm_modules_cp_save_meta' ) ) {
		function wm_modules_cp_save_meta( $post_id ) {
			global $post;

			if ( is_object( $post ) && 'wm_modules' != $post->post_type )
				return $post_id;

			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_modules-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_modules-metabox-nonce'], 'wm_modules-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			$capability = ( wm_option( 'cp-role-modules' ) && 'disable' !== wm_option( 'cp-role-modules' ) ) ? ( 'edit_' . wm_option( 'cp-role-modules' ) ) : ( 'edit_post' );
			if ( ! current_user_can( $capability, $post_id ) )
				return $post_id;

			//Save each meta field separately
			$metaFields = wm_modules_meta_fields();

			wm_save_meta( $post_id, $metaFields );
		}
	} // /wm_modules_cp_save_meta

?>