<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Staff custom post meta boxes
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
		add_action( 'edit_form_after_title', 'wm_staff_metabox_start', 1000 );
		add_action( 'edit_form_after_editor', 'wm_staff_metabox_end', 1 );
		//Saving CP
		add_action( 'save_post', 'wm_staff_cp_save_meta' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_staff_meta_fields' ) ) {
		function wm_staff_meta_fields() {
			global $sidebarPosition, $current_screen;

			$skin            = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
			$prefix          = 'staff-';
			$prefixBg        = 'background-';
			$prefixBgHeading = 'heading-background-';

			$widgetsButtons = ( current_user_can( 'switch_themes' ) ) ? ( '<a class="button confirm" href="' . get_admin_url() . 'widgets.php">' . __( 'Manage widget areas', 'lespaul_domain_adm' ) . '</a> <a class="button confirm" href="' . get_admin_url() . 'admin.php?page=' . WM_THEME_SHORTNAME . '-options">' . __( 'Create new widget areas', 'lespaul_domain_adm' ) . '</a>' ) : ( '' );

			$metaFields = array(

				//Position settings
				array(
					"type" => "section-open",
					"section-id" => "position",
					"title" => __( 'Position', 'lespaul_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."position",
						"label" => __( 'Position', 'lespaul_domain_adm' ),
						"desc" => __( 'Staff member position', 'lespaul_domain_adm' )
					),
				array(
					"type" => "section-close"
				),



				//Contacts settings
				array(
					"type" => "section-open",
					"section-id" => "contact",
					"title" => __( 'Contact', 'lespaul_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."phone",
						"label" => __( 'Phone', 'lespaul_domain_adm' ),
						"desc" => __( 'Phone number', 'lespaul_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."email",
						"label" => __( 'E-mail', 'lespaul_domain_adm' ),
						"desc" => __( 'E-mail (spam protection will be applied)', 'lespaul_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."linkedin",
						"label" => __( 'LinkedIn', 'lespaul_domain_adm' ),
						"desc" => __( 'LinkedIn account URL', 'lespaul_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."skype",
						"label" => __( 'Skype username', 'lespaul_domain_adm' ),
						"desc" => __( 'Skype username', 'lespaul_domain_adm' )
					),
				array(
					"type" => "section-close"
				)

			);

			if ( wm_option( 'cp-staff-rich' ) ) {
				array_push( $metaFields,
					//Sidebar settings
					array(
						"type" => "section-open",
						"section-id" => "sidebar-section",
						"title" => __( 'Sidebar', 'lespaul_domain_adm' )
					),
						array(
							"type" => "box",
							"content" => '<h4>' . __( 'Choose a sidebar and its position on the post/page', 'lespaul_domain_adm' ) . '</h4>' . $widgetsButtons,
						),

						array(
							"type" => "layouts",
							"id" => "layout",
							"label" => __( 'Sidebar position', 'lespaul_domain_adm' ),
							"desc" => __( 'Choose a sidebar position on the post/page (set the first one to use the theme default settings)', 'lespaul_domain_adm' ),
							"options" => $sidebarPosition,
							"default" => ""
						),
						array(
							"type" => "select",
							"id" => "sidebar",
							"label" => __( 'Choose a sidebar', 'lespaul_domain_adm' ),
							"desc" => __( 'Select a widget area used as a sidebar for this post/page (if not set, the dafault theme settings will apply)', 'lespaul_domain_adm' ),
							"options" => wm_widget_areas(),
							"default" => ""
						),
					array(
						"type" => "section-close"
					),



					//Design - website background settings
					array(
						"type" => "section-open",
						"section-id" => "background-settings",
						"title" => __( 'Backgrounds', 'lespaul_domain_adm' )
					),
						array(
							"type" => "heading4",
							"content" => __( 'Main heading area background', 'lespaul_domain_panel' )
						),
						array(
							"id" => $prefix."bg-heading",
							"type" => "inside-wrapper-open",
							"class" => "toggle box"
						),
							array(
								"type" => "slider",
								"id" => $prefixBgHeading."padding",
								"label" => __( 'Section padding', 'lespaul_domain_adm' ),
								"desc" => __( 'Top and bottom padding size applied on the section (leave zero for default)', 'lespaul_domain_adm' ),
								"default" => 0,
								"min" => 1,
								"max" => 100,
								"step" => 1,
								"validate" => "absint"
							),
							array(
								"type" => "color",
								"id" => $prefixBgHeading."color",
								"label" => __( 'Text color', 'lespaul_domain_adm' ),
								"desc" => __( 'Sets the custom main heading text color', 'lespaul_domain_adm' ),
								"default" => "",
								"validate" => "color"
							),
							array(
								"type" => "color",
								"id" => $prefixBgHeading."bg-color",
								"label" => __( 'Background color', 'lespaul_domain_adm' ),
								"desc" => __( 'Sets the custom main heading background color', 'lespaul_domain_adm' ),
								"default" => "",
								"validate" => "color"
							),
							array(
								"type" => "image",
								"id" => $prefixBgHeading."bg-img-url",
								"label" => __( 'Custom background image', 'lespaul_domain_adm' ),
								"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_adm' ),
								"default" => "",
								"readonly" => true,
								"imgsize" => 'mobile'
							),
							array(
								"type" => "select",
								"id" => $prefixBgHeading."bg-img-position",
								"label" => __( 'Background image position', 'lespaul_domain_adm' ),
								"desc" => __( 'Set background image position', 'lespaul_domain_adm' ),
								"options" => array(
									'50% 50%'   => __( 'Center', 'lespaul_domain_adm' ),
									'50% 0'     => __( 'Center horizontally, top', 'lespaul_domain_adm' ),
									'50% 100%'  => __( 'Center horizontally, bottom', 'lespaul_domain_adm' ),
									'0 0'       => __( 'Left, top', 'lespaul_domain_adm' ),
									'0 50%'     => __( 'Left, center vertically', 'lespaul_domain_adm' ),
									'0 100%'    => __( 'Left, bottom', 'lespaul_domain_adm' ),
									'100% 0'    => __( 'Right, top', 'lespaul_domain_adm' ),
									'100% 50%'  => __( 'Right, center vertically', 'lespaul_domain_adm' ),
									'100% 100%' => __( 'Right, bottom', 'lespaul_domain_adm' ),
									),
								"default" => '50% 0'
							),
							array(
								"type" => "select",
								"id" => $prefixBgHeading."bg-img-repeat",
								"label" => __( 'Background image repeat', 'lespaul_domain_adm' ),
								"desc" => __( 'Set background image repeating', 'lespaul_domain_adm' ),
								"options" => array(
									'no-repeat' => __( 'Do not repeat', 'lespaul_domain_adm' ),
									'repeat'    => __( 'Repeat', 'lespaul_domain_adm' ),
									'repeat-x'  => __( 'Repeat horizontally', 'lespaul_domain_adm' ),
									'repeat-y'  => __( 'Repeat vertically', 'lespaul_domain_adm' )
									),
								"default" => 'no-repeat'
							),
						array(
							"id" => $prefix."bg-heading",
							"type" => "inside-wrapper-close"
						)
				);

				if (
						isset( $current_screen ) && 'edit' === $current_screen->parent_base &&
						'fullwidth' == wm_option( 'general-boxed' )
					) {
					array_push( $metaFields,
						array(
							"type" => "section-close"
						)
					);
					return $metaFields;
				}

				array_push( $metaFields,

						array(
							"type" => "heading4",
							"content" => __( 'Page background', 'lespaul_domain_panel' )
						),
						array(
							"id" => $prefix."bg",
							"type" => "inside-wrapper-open",
							"class" => "toggle box"
						),
							array(
								"type" => "color",
								"id" => $prefixBg."bg-color",
								"label" => __( 'Background color', 'lespaul_domain_adm' ),
								"desc" => __( 'Sets the custom website background color.', 'lespaul_domain_adm' ) . '<br />' . __( 'Please always set this to reset any possible background styles applied on main HTML element.', 'lespaul_domain_adm' ),
								"default" => "",
								"validate" => "color"
							),
							array(
								"type" => "image",
								"id" => $prefixBg."bg-img-url",
								"label" => __( 'Custom background image', 'lespaul_domain_adm' ),
								"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_adm' ),
								"default" => "",
								"readonly" => true,
								"imgsize" => 'mobile'
							),
							array(
								"type" => "select",
								"id" => $prefixBg."bg-img-position",
								"label" => __( 'Background image position', 'lespaul_domain_adm' ),
								"desc" => __( 'Set background image position', 'lespaul_domain_adm' ),
								"options" => array(
									'50% 50%'   => __( 'Center', 'lespaul_domain_adm' ),
									'50% 0'     => __( 'Center horizontally, top', 'lespaul_domain_adm' ),
									'50% 100%'  => __( 'Center horizontally, bottom', 'lespaul_domain_adm' ),
									'0 0'       => __( 'Left, top', 'lespaul_domain_adm' ),
									'0 50%'     => __( 'Left, center vertically', 'lespaul_domain_adm' ),
									'0 100%'    => __( 'Left, bottom', 'lespaul_domain_adm' ),
									'100% 0'    => __( 'Right, top', 'lespaul_domain_adm' ),
									'100% 50%'  => __( 'Right, center vertically', 'lespaul_domain_adm' ),
									'100% 100%' => __( 'Right, bottom', 'lespaul_domain_adm' ),
									),
								"default" => '50% 0'
							),
							array(
								"type" => "select",
								"id" => $prefixBg."bg-img-repeat",
								"label" => __( 'Background image repeat', 'lespaul_domain_adm' ),
								"desc" => __( 'Set background image repeating', 'lespaul_domain_adm' ),
								"options" => array(
									'no-repeat' => __( 'Do not repeat', 'lespaul_domain_adm' ),
									'repeat'    => __( 'Repeat', 'lespaul_domain_adm' ),
									'repeat-x'  => __( 'Repeat horizontally', 'lespaul_domain_adm' ),
									'repeat-y'  => __( 'Repeat vertically', 'lespaul_domain_adm' )
									),
								"default" => 'no-repeat'
							),
							array(
								"type" => "radio",
								"id" => $prefixBg."bg-img-attachment",
								"label" => __( 'Background image attachment', 'lespaul_domain_adm' ),
								"desc" => __( 'Set background image attachment', 'lespaul_domain_adm' ),
								"options" => array(
									'fixed'  => __( 'Fixed position', 'lespaul_domain_adm' ),
									'scroll' => __( 'Move on scrolling', 'lespaul_domain_adm' )
									),
								"default" => 'fixed'
							),
							array(
								"type" => "checkbox",
								"id" => $prefixBg."bg-img-fit-window",
								"label" => __( 'Fit browser window width', 'lespaul_domain_adm' ),
								"desc" => __( 'Makes the image to scale to browser window width. Note that background image position and repeat options does not apply when this is checked.', 'lespaul_domain_adm' ),
								"value" => "true"
							),
						array(
							"id" => $prefix."bg",
							"type" => "inside-wrapper-close"
						),
					array(
						"type" => "section-close"
					)

				);
			}

			return $metaFields;
		}
	} // /wm_staff_meta_fields



	/*
	* Meta form generator start
	*/
	if ( ! function_exists( 'wm_staff_metabox_start' ) ) {
		function wm_staff_metabox_start() {
			global $post;

			if ( 'wm_staff' != $post->post_type )
				return;

			$metaFields = wm_staff_meta_fields();

			wp_nonce_field( 'wm_staff-metabox-nonce', 'wm_staff-metabox-nonce' );

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
	} // /wm_staff_metabox_start



	/*
	* Meta form generator end
	*/
	if ( ! function_exists( 'wm_staff_metabox_end' ) ) {
		function wm_staff_metabox_end() {
			global $post;

			if ( 'wm_staff' != $post->post_type )
				return;

			$metaFields = wm_staff_meta_fields();
			$metaFields = array_merge( array( array( "type" => "section-close" ) ), $metaFields );

			//Content
			wm_render_form( $metaFields, 'meta' );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'lespaul_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'lespaul_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		}
	} // /wm_staff_metabox_end





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
	if ( ! function_exists( 'wm_staff_cp_save_meta' ) ) {
		function wm_staff_cp_save_meta( $post_id ) {
			global $post;

			if ( is_object( $post ) && 'wm_staff' != $post->post_type )
				return $post_id;

			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_staff-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_staff-metabox-nonce'], 'wm_staff-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			$capability = ( wm_option( 'cp-role-staff' ) && 'disable' !== wm_option( 'cp-role-staff' ) ) ? ( 'edit_' . wm_option( 'cp-role-staff' ) ) : ( 'edit_post' );
			if ( ! current_user_can( $capability, $post_id ) )
				return $post_id;

			//Save each meta field separately
			$metaFields = wm_staff_meta_fields();

			wm_save_meta( $post_id, $metaFields );
		}
	} // /wm_staff_cp_save_meta

?>