<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Projects custom post meta boxes
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
		add_action( 'edit_form_after_title', 'wm_projects_metabox_start', 1000 );
		add_action( 'edit_form_after_editor', 'wm_projects_metabox_end', 1 );
		//Saving CP
		add_action( 'save_post', 'wm_projects_cp_save_meta' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_projects_meta_fields' ) ) {
		function wm_projects_meta_fields() {
			global $post, $sidebarPosition, $projectLayouts, $current_screen;

			$skin            = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
			$postId          = ( $post ) ? ( $post->ID ) : ( null );
			$prefix          = 'project-';
			$prefixBg        = 'background-';
			$prefixBgHeading = 'heading-background-';
			$fontFile        = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
			$fontIcons       = wm_fontello_classes( $fontFile );

			//Get icons
			$menuIcons = array();
			$menuIcons[''] = __( '- select icon -', 'lespaul_domain_adm' );
			foreach ( $fontIcons as $icon ) {
				$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
			}

			$defaultAttsNames = wm_option( 'cp-projects-default-atts' );
			$defaultAtts      = array();
			if ( is_array( $defaultAttsNames ) && ! empty( $defaultAttsNames ) ) {
				foreach ( wm_option( 'cp-projects-default-atts' ) as $attName ) {
					$defaultAtts[] = array( 'attr' => $attName, 'val' => '' );
				}
			}

			//Get project types
			$projectTypes = array();
			$conditionals = array(
				'static-project' => array( 'static-project' ),
				'slider-project' => array( 'slider-project' ),
				'video-project'  => array( 'video-project' ),
				'audio-project'  => array( 'audio-project' )
				);
			$terms = get_terms( 'project-type', 'orderby=name&hide_empty=0&hierarchical=0' );
			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$meta = get_option( 'wm-tax_project-type-' . $term->term_id );
					$projectType = $meta['type'] . '[' . $term->slug . ']';
					$projectTypes[$projectType] = $term->name;
					$conditionals[$meta['type']][] = $projectType;
				}
			}
			if ( empty( $projectTypes ) )
				$projectTypes = array(
						'static-project' => __( 'Image', 'lespaul_domain_adm' ),
						'slider-project' => __( 'Slideshow of images', 'lespaul_domain_adm' ),
						'video-project'  => __( 'Video', 'lespaul_domain_adm' ),
						'audio-project'  => __( 'Audio', 'lespaul_domain_adm' ),
					);

			//The actual meta fields
			$metaFields = array(
				//Featured media settings
				array(
					"type" => "section-open",
					"section-id" => "featured-media-section",
					"title" => __( 'Media', 'lespaul_domain_adm' ),
					"exclude" => array()
				),
					array(
						"type" => "box",
						"content" => '
							<p>' . __( 'Featured image will be used in projects list so please set this always.', 'lespaul_domain_adm' ) . '</p>
							<a class="button-primary thickbox button-set-featured-image" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&tab=library&type=image&TB_iframe=1">' . __( 'Set featured image', 'lespaul_domain_adm' ) . '</a>
							<a class="button-primary thickbox" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Add/manage project images', 'lespaul_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "select",
						"id" => $prefix."type",
						"label" => __( 'Project media type', 'lespaul_domain_adm' ),
						"desc" => __( 'Select a type of project featured media', 'lespaul_domain_adm' ),
						"options" => $projectTypes,
						"default" => "static"
					),

					//static image
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => implode( ',', $conditionals['static-project'] )
								),
							"type" => "image",
							"id" => $prefix."image",
							"label" => __( 'Project main image', 'lespaul_domain_adm' ),
							"desc" => __( 'Used as main project preview image. To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post.', 'lespaul_domain_adm' ),
							"default" => "",
							"readonly" => true,
							"imgsize" => 'mobile'
						),

					//slider
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => implode( ',', $conditionals['slider-project'] )
								),
							"type" => "patterns",
							"id" => "slider-gallery-images",
							"label" => __( 'Slideshow images', 'lespaul_domain_adm' ),
							"desc" => __( 'Set gallery for this post (upload images below). Note that you need to save/update the post once the images have been uploaded to display them below.', 'lespaul_domain_adm' ) . '<br /><a class="button thickbox" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Add/manage gallery images', 'lespaul_domain_adm' ) . '</a>',
							"options" => wm_get_post_images(),
							"hidden" => true
						),
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => implode( ',', $conditionals['slider-project'] )
								),
							"type" => "slider",
							"id" => $prefix."slider-duration",
							"label" => __( 'Slide display time', 'lespaul_domain_adm' ),
							"desc" => __( 'Display duration of single slide (in seconds)', 'lespaul_domain_adm' ),
							"default" => 5,
							"min" => 1,
							"max" => 20,
							"step" => 1,
							"validate" => "absint"
						),

					//video
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => implode( ',', $conditionals['video-project'] )
								),
							"type" => "text",
							"id" => $prefix."video",
							"label" => __( 'Video URL address', 'lespaul_domain_adm' ),
							"desc" => sprintf( __( 'Enter full video URL (<a%s>supported video portals</a> and Screenr videos only)', 'lespaul_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ). '<br />' . __( 'If you set featured image, it will be used as video cover image. The video starts to play after clicking the image (for Vimeo and YouTube videos only).', 'lespaul_domain_adm' ),
							"validate" => "url"
						),

					//audio
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => implode( ',', $conditionals['audio-project'] )
								),
							"type" => "text",
							"id" => $prefix."audio",
							"label" => __( 'SoundCloud audio URL address', 'lespaul_domain_adm' ),
							"desc" => __( 'Set the <a href="http://www.soundcloud.com" target="_blank">SoundCloud.com</a> audio clip URL address', 'lespaul_domain_adm' ),
							"validate" => "url"
						)
				);

			array_push( $metaFields,
				array(
					"type" => "section-close"
				),



				//Attributes settings
				array(
					"type" => "section-open",
					"section-id" => "attributes-settings",
					"title" => __( 'Attributes', 'lespaul_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( 'Project URL link', 'lespaul_domain_adm' ),
						"desc" => __( 'When left blank, no link will be displayed', 'lespaul_domain_adm' )
					),
						array(
							"type" => "select",
							"id" => $prefix."link-list",
							"label" => __( 'Link action', 'lespaul_domain_adm' ),
							"desc" => __( 'Choose how to display/apply the link set above', 'lespaul_domain_adm' ),
							"options" => array(
									"1OPTGROUP"      => __( 'Project page', 'lespaul_domain_adm' ),
										""             => __( 'Display link on project page', 'lespaul_domain_adm' ),
									"1/OPTGROUP"     => "",
									"2OPTGROUP"      => __( 'Apply directly in projects list (on portfolio pages)', 'lespaul_domain_adm' ),
										"modal"        => __( 'Open in popup window (videos and images only)', 'lespaul_domain_adm' ),
										"target-blank" => __( 'Open in new tab/window', 'lespaul_domain_adm' ),
										"target-self"  => __( 'Open in same window', 'lespaul_domain_adm' ),
									"2/OPTGROUP"     => "",
								),
							"default" => "",
							"optgroups" => true
						),
						array(
							"type" => "hr"
						),
					array(
						"type" => "additems",
						"id" => $prefix."attributes",
						"label" => __( 'Project attributes', 'lespaul_domain_adm' ),
						"desc" => __( 'Press [+] button to add an attribute, then type in the attribute name and value (you can use <code>[project_attributes title="Project info" /]</code> shortcode to display attributes anywhere in project content or excerpt - by default they will be displayed as first thing above project excerpt - you can set the layout on "General and layout" tab)', 'lespaul_domain_adm' ),
						"default" => $defaultAtts,
						"field" => "attributes"
					),
				array(
					"type" => "section-close"
				),



				//Heading settings
				array(
					"type" => "section-open",
					"section-id" => "heading",
					"title" => __( 'Heading', 'lespaul_domain_adm' )
				),
					array(
						"type" => "checkbox",
						"id" => "no-heading",
						"label" => __( 'Disable main heading', 'lespaul_domain_adm' ),
						"desc" => __( 'Hides post/page main heading - the title', 'lespaul_domain_adm' ),
						"value" => "true"
					),
						array(
							"type" => "space"
						),
						array(
							"type" => "textarea",
							"id" => "subheading",
							"label" => __( 'Subtitle', 'lespaul_domain_adm' ),
							"desc" => __( 'If defined, the specially styled subtitle will be displayed', 'lespaul_domain_adm' ),
							"default" => "",
							"validate" => "lineBreakHTML",
							"rows" => 2,
							"cols" => 57
						),
						array(
							"type" => "select",
							"id" => "main-heading-alignment",
							"label" => __( 'Main heading alignment', 'lespaul_domain_adm' ),
							"desc" => __( 'Set the text alignment in main heading area', 'lespaul_domain_adm' ),
							"options" => array(
									""       => __( 'Default', 'lespaul_domain_adm' ),
									"left"   => __( 'Left', 'lespaul_domain_adm' ),
									"center" => __( 'Center', 'lespaul_domain_adm' ),
									"right"  => __( 'Right', 'lespaul_domain_adm' ),
								),
							"default" => ""
						),
						array(
							"type" => "select",
							"id" => "main-heading-icon",
							"label" => __( 'Main heading icon', 'lespaul_domain_adm' ),
							"desc" => __( 'Select an icon to display in main heading area', 'lespaul_domain_adm' ),
							"options" => $menuIcons,
							"icons" => true
						),
				array(
					"type" => "section-close"
				),



				//Layout settings
				array(
					"type" => "section-open",
					"section-id" => "layout",
					"title" => __( 'Layout', 'lespaul_domain_adm' )
				),
					array(
						"type" => "select",
						"id" => $prefix."single-layout",
						"label" => __( 'Project page layout', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the layout for this project page', 'lespaul_domain_adm' ),
						"options" => $projectLayouts,
						"default" => wm_option( 'general-project-default-layout' ),
						"optgroups" => true
					),
					array(
						"type" => "checkbox",
						"id" => "toggle-header-position",
						"label" => __( 'Toggle header position', 'lespaul_domain_adm' ),
						"desc" => __( 'Sticks the header to the top when it is not and vice versa', 'lespaul_domain_adm' ),
						"value" => "true"
					)
			);

			if ( ! wm_option( 'contents-no-related-projects' ) )
				array_push( $metaFields,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-related",
						"label" => __( 'Disable related projects', 'lespaul_domain_adm' ),
						"desc" => __( 'Hides related projects list', 'lespaul_domain_adm' )
					)
				);

			if ( is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaFields,
					array(
						"type" => "checkbox",
						"id" => "no-above-footer-widgets",
						"label" => __( 'Disable widgets above footer', 'lespaul_domain_adm' ),
						"desc" => __( 'Hides widget area above footer', 'lespaul_domain_adm' ),
						"value" => "true"
					)
				);

			array_push( $metaFields,
					array(
						"type" => "hr",
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

			return $metaFields;
		}
	} // /wm_projects_meta_fields



	/*
	* Meta form generator start
	*/
	if ( ! function_exists( 'wm_projects_metabox_start' ) ) {
		function wm_projects_metabox_start() {
			global $post;

			if ( 'wm_projects' != $post->post_type )
				return;

			$metaFields = wm_projects_meta_fields();

			wp_nonce_field( 'wm_projects-metabox-nonce', 'wm_projects-metabox-nonce' );

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
	} // /wm_projects_metabox_start



	/*
	* Meta form generator end
	*/
	if ( ! function_exists( 'wm_projects_metabox_end' ) ) {
		function wm_projects_metabox_end() {
			global $post;

			if ( 'wm_projects' != $post->post_type )
				return;

			$metaFields = wm_projects_meta_fields();
			$metaFields = array_merge( array( array( "type" => "section-close" ) ), $metaFields );

			//Content
			wm_render_form( $metaFields, 'meta' );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'lespaul_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'lespaul_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		}
	} // /wm_projects_metabox_end





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
	if ( ! function_exists( 'wm_projects_cp_save_meta' ) ) {
		function wm_projects_cp_save_meta( $post_id ) {
			global $post;

			if ( is_object( $post ) && 'wm_projects' != $post->post_type )
				return $post_id;

			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_projects-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_projects-metabox-nonce'], 'wm_projects-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			$capability = ( wm_option( 'cp-role-projects' ) && 'disable' !== wm_option( 'cp-role-projects' ) ) ? ( 'edit_' . wm_option( 'cp-role-projects' ) ) : ( 'edit_post' );
			if ( ! current_user_can( $capability, $post_id ) )
				return $post_id;

			//Save each meta field separately
			$metaFields = wm_projects_meta_fields();

			wm_save_meta( $post_id, $metaFields );
		}
	} // /wm_projects_cp_save_meta

?>