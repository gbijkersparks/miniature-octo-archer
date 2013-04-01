<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Post meta boxes
*****************************************************
*/

/*
* Meta settings options for posts
*
* Has to be set up as function to pass the custom taxonomies array.
* Custom taxonomies are hooked onto 'init' action which is executed after the theme's functions file has been included.
* So if you're looking for taxonomy terms directly in the functions file, you're doing so before they've actually been registered.
* Meta box generator, which uses these settings options, is hooked onto 'add_meta_boxes' which is executed after 'init' action.
*/
if ( ! function_exists( 'wm_meta_post_options_formats' ) ) {
	function wm_meta_post_options_formats() {
		global $post;

		$postId = ( $post ) ? ( $post->ID ) : ( null );
		$prefix = '';

		$metaPostOptions = array(
			//audio post
				array(
					"id" => "post-format-audio",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "info",
						"content" => '<strong>' . __( 'Audio post format', 'atlantes_domain_adm' ) . '</strong><br />' . __( 'Displays audio player to play the <a href="http://www.soundcloud.com" target="_blank">SoundCloud.com</a> audio files. Could be used for Podcasting. Please place the audio URL as first thing in post content (please make it plain text, not a clickable link). The audio description text can follow on next line.', 'atlantes_domain_adm' ) . '<br />' . __( 'The audio URL will be stripped out from post content on single post page.', 'atlantes_domain_adm' )
					),
				array(
					"conditional" => array(
						"field" => "post_format",
						"custom" => array( "input", "name", "radio" ),
						"value" => "audio"
						),
					"id" => "post-format-audio",
					"type" => "inside-wrapper-close"
				),

			//gallery post
				array(
					"id" => "post-format-gallery",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "info",
						"content" => '<strong>' . __( 'Gallery post format', 'atlantes_domain_adm' ) . '</strong><br />' . __( 'A standard post with a gallery of images in post content. Slideshow will be displayed on blog page from the first gallery found in post content. If no gallery found, featured image is displayed.', 'atlantes_domain_adm' ) . '<br />' . __( 'You can insert a <code>&#91;gallery]</code> shortcode anywhere in the post. This shortcode will not be stripped out from post content on single post page.', 'atlantes_domain_adm' )
					),
				array(
					"conditional" => array(
						"field" => "post_format",
						"custom" => array( "input", "name", "radio" ),
						"value" => "gallery"
						),
					"id" => "post-format-gallery",
					"type" => "inside-wrapper-close"
				),

			//link post
				array(
					"id" => "post-format-link",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "info",
						"content" => '<strong>' . __( 'Link post format', 'atlantes_domain_adm' ) . '</strong><br />' . __( 'Displays useful URL link. You can set the link anywhere in the post content. The link will be emphasized when post is displayed.', 'atlantes_domain_adm' )
					),
				array(
					"conditional" => array(
						"field" => "post_format",
						"custom" => array( "input", "name", "radio" ),
						"value" => "link"
						),
					"id" => "post-format-link",
					"type" => "inside-wrapper-close"
				),

			//quote post
				array(
					"id" => "post-format-quote",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "info",
						"content" => '<strong>' . __( 'Quote post format', 'atlantes_domain_adm' ) . '</strong><br />' . __( 'A quotation. Please place the actual quote (blockquote) directly into post content. To set a quote source just select the quote source name text and use "Style" button to style it as "Cite (quoted author)" (under "Quotes" section).', 'atlantes_domain_adm' ) . '<br />' . __( 'This post format will populate the <code>&#91;testimonials]</code> shortcode. If featured image is set, it will be used as quoted person photo in <code>&#91;testimonials]</code> shortcode (please upload square images only).', 'atlantes_domain_adm' )
					),
				array(
					"conditional" => array(
						"field" => "post_format",
						"custom" => array( "input", "name", "radio" ),
						"value" => "quote"
						),
					"id" => "post-format-quote",
					"type" => "inside-wrapper-close"
				),

			//status post
				array(
					"id" => "post-format-status",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "info",
						"content" => '<strong>' . __( 'Status post format', 'atlantes_domain_adm' ) . '</strong><br />' . __( 'A short status update, similar to a Twitter status update. Please place the actual status text directly into post content area.', 'atlantes_domain_adm' )
					),
				array(
					"conditional" => array(
						"field" => "post_format",
						"custom" => array( "input", "name", "radio" ),
						"value" => "status"
						),
					"id" => "post-format-status",
					"type" => "inside-wrapper-close"
				),

			//video post
				array(
					"id" => "post-format-video",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "info",
						"content" => '<strong>' . __( 'Video post format', 'atlantes_domain_adm' ) . '</strong><br />'  .sprintf( __( 'A single video. Please place the video URL (<a%s>supported video portals</a> and Screenr videos only) as first thing in post content. The video description text can follow on next line.', 'atlantes_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ) . '<br />' . __( 'The video URL will be stripped out from post content on single post page.', 'atlantes_domain_adm' ),
					),
				array(
					"conditional" => array(
						"field" => "post_format",
						"custom" => array( "input", "name", "radio" ),
						"value" => "video"
						),
					"id" => "post-format-video",
					"type" => "inside-wrapper-close"
				)
		);

		return $metaPostOptions;
	}
} // /wm_meta_post_options_formats



if ( ! function_exists( 'wm_meta_post_options' ) ) {
	function wm_meta_post_options() {
		global $post, $sidebarPosition, $current_screen;

		$postId          = ( $post ) ? ( $post->ID ) : ( null );
		$prefix          = '';
		$prefixBg        = 'background-';
		$prefixBgHeading = 'heading-background-';
		$fontFile        = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
		$fontIcons       = wm_fontello_classes( $fontFile );

		//Get icons
		$menuIcons = array();
		$menuIcons[''] = __( '- select icon -', 'atlantes_domain_adm' );
		foreach ( $fontIcons as $icon ) {
			$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
		}

		$widgetsButtons = ( current_user_can( 'switch_themes' ) ) ? ( '<a class="button confirm" href="' . get_admin_url() . 'widgets.php">' . __( 'Manage widget areas', 'atlantes_domain_adm' ) . '</a> <a class="button confirm" href="' . get_admin_url() . 'admin.php?page=' . WM_THEME_SHORTNAME . '-options">' . __( 'Create new widget areas', 'atlantes_domain_adm' ) . '</a>' ) : ( '' );

		$metaPostOptions = array(

			//General settings
			array(
				"type" => "section-open",
				"section-id" => "general-section",
				"title" => __( 'General', 'atlantes_domain_adm' )
			),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-heading",
					"label" => __( 'Disable main heading', 'atlantes_domain_adm' ),
					"desc" => __( 'Hides post/page main heading - the title', 'atlantes_domain_adm' ),
					"value" => "true"
				),
					array(
						"type" => "space"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."subheading",
						"label" => __( 'Subtitle', 'atlantes_domain_adm' ),
						"desc" => __( 'If defined, the specially styled subtitle will be displayed', 'atlantes_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"rows" => 2,
						"cols" => 57
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-alignment",
						"label" => __( 'Main heading alignment', 'atlantes_domain_adm' ),
						"desc" => __( 'Set the text alignment in main heading area', 'atlantes_domain_adm' ),
						"options" => array(
								""       => __( 'Default', 'atlantes_domain_adm' ),
								"left"   => __( 'Left', 'atlantes_domain_adm' ),
								"center" => __( 'Center', 'atlantes_domain_adm' ),
								"right"  => __( 'Right', 'atlantes_domain_adm' ),
							),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-icon",
						"label" => __( 'Main heading icon', 'atlantes_domain_adm' ),
						"desc" => __( 'Select an icon to display in main heading area', 'atlantes_domain_adm' ),
						"options" => $menuIcons,
						"icons" => true
					)
			);

			if ( ! wm_option( 'blog-disable-featured-image' ) || is_active_sidebar( 'top-bar-widgets' ) || ! wm_option( 'blog-disable-bio' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "hr"
					)
				);

			if ( ! wm_option( 'blog-disable-featured-image' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."disable-featured-image",
						"label" => __( 'Disable featured image for this post', 'atlantes_domain_adm' ),
						"desc" => __( 'Disables featured image on single post view', 'atlantes_domain_adm' ),
						"value" => "true"
					)
				);

			if ( is_active_sidebar( 'top-bar-widgets' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-top-bar",
						"label" => __( 'Disable top bar', 'atlantes_domain_adm' ),
						"desc" => __( 'Disables top bar widget area on this post', 'atlantes_domain_adm' ),
						"value" => "true"
					)
				);

			if ( ! wm_option( 'blog-disable-bio' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."author",
						"label" => __( 'Disable author details', 'atlantes_domain_adm' ),
						"desc" => __( 'Disables author information below the post content', 'atlantes_domain_adm' ),
						"value" => "true"
					)
				);

			array_push( $metaPostOptions,
				array(
					"type" => "hr"
				),

				array(
					"type" => "checkbox",
					"id" => "attachments-list",
					"label" => __( 'Display post attachments list', 'atlantes_domain_adm' ),
					"desc" => __( 'Displays links to download all post attachments except images', 'atlantes_domain_adm' ),
					"value" => "true"
				),
			array(
				"type" => "section-close"
			),



			//Sidebar settings
			array(
				"type" => "section-open",
				"section-id" => "sidebar-section",
				"title" => __( 'Sidebar', 'atlantes_domain_adm' )
			),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Choose a sidebar and its position on the post/page', 'atlantes_domain_adm' ) . '</h4>' . $widgetsButtons,
				),

				array(
					"type" => "layouts",
					"id" => $prefix."layout",
					"label" => __( 'Sidebar position', 'atlantes_domain_adm' ),
					"desc" => __( 'Choose a sidebar position on the post/page (set the first one to use the theme default settings)', 'atlantes_domain_adm' ),
					"options" => $sidebarPosition,
					"default" => ""
				),
				array(
					"type" => "select",
					"id" => $prefix."sidebar",
					"label" => __( 'Choose a sidebar', 'atlantes_domain_adm' ),
					"desc" => __( 'Select a widget area used as a sidebar for this post/page (if not set, the dafault theme settings will apply)', 'atlantes_domain_adm' ),
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
				"title" => __( 'Backgrounds', 'atlantes_domain_adm' ),
				"exclude" => array()
			),
				array(
					"type" => "heading4",
					"content" => __( 'Main heading area background', 'atlantes_domain_panel' )
				),
				array(
					"id" => $prefix."bg-heading",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "slider",
						"id" => $prefixBgHeading."padding",
						"label" => __( 'Section padding', 'atlantes_domain_adm' ),
						"desc" => __( 'Top and bottom padding size applied on the section (leave zero for default)', 'atlantes_domain_adm' ),
						"default" => 0,
						"min" => 1,
						"max" => 100,
						"step" => 1,
						"validate" => "absint"
					),
					array(
						"type" => "color",
						"id" => $prefixBgHeading."color",
						"label" => __( 'Text color', 'atlantes_domain_adm' ),
						"desc" => __( 'Sets the custom main heading text color', 'atlantes_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefixBgHeading."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_adm' ),
						"desc" => __( 'Sets the custom main heading background color', 'atlantes_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "image",
						"id" => $prefixBgHeading."bg-img-url",
						"label" => __( 'Custom background image', 'atlantes_domain_adm' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_adm' ),
						"default" => "",
						"readonly" => true,
						"imgsize" => 'mobile'
					),
					array(
						"type" => "select",
						"id" => $prefixBgHeading."bg-img-position",
						"label" => __( 'Background image position', 'atlantes_domain_adm' ),
						"desc" => __( 'Set background image position', 'atlantes_domain_adm' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'atlantes_domain_adm' ),
							'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_adm' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_adm' ),
							'0 0'       => __( 'Left, top', 'atlantes_domain_adm' ),
							'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_adm' ),
							'0 100%'    => __( 'Left, bottom', 'atlantes_domain_adm' ),
							'100% 0'    => __( 'Right, top', 'atlantes_domain_adm' ),
							'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_adm' ),
							'100% 100%' => __( 'Right, bottom', 'atlantes_domain_adm' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefixBgHeading."bg-img-repeat",
						"label" => __( 'Background image repeat', 'atlantes_domain_adm' ),
						"desc" => __( 'Set background image repeating', 'atlantes_domain_adm' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'atlantes_domain_adm' ),
							'repeat'    => __( 'Repeat', 'atlantes_domain_adm' ),
							'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_adm' ),
							'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_adm' )
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
			array_push( $metaPostOptions,
				array(
					"type" => "section-close"
				)
			);
			return $metaPostOptions;
		}

		array_push( $metaPostOptions,

				array(
					"type" => "heading4",
					"content" => __( 'Page background', 'atlantes_domain_panel' )
				),
				array(
					"id" => $prefix."bg",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefixBg."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_adm' ),
						"desc" => __( 'Sets the custom website background color.', 'atlantes_domain_adm' ) . '<br />' . __( 'Please always set this to reset any possible background styles applied on main HTML element.', 'atlantes_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "image",
						"id" => $prefixBg."bg-img-url",
						"label" => __( 'Custom background image', 'atlantes_domain_adm' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_adm' ),
						"default" => "",
						"readonly" => true,
						"imgsize" => 'mobile'
					),
					array(
						"type" => "select",
						"id" => $prefixBg."bg-img-position",
						"label" => __( 'Background image position', 'atlantes_domain_adm' ),
						"desc" => __( 'Set background image position', 'atlantes_domain_adm' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'atlantes_domain_adm' ),
							'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_adm' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_adm' ),
							'0 0'       => __( 'Left, top', 'atlantes_domain_adm' ),
							'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_adm' ),
							'0 100%'    => __( 'Left, bottom', 'atlantes_domain_adm' ),
							'100% 0'    => __( 'Right, top', 'atlantes_domain_adm' ),
							'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_adm' ),
							'100% 100%' => __( 'Right, bottom', 'atlantes_domain_adm' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefixBg."bg-img-repeat",
						"label" => __( 'Background image repeat', 'atlantes_domain_adm' ),
						"desc" => __( 'Set background image repeating', 'atlantes_domain_adm' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'atlantes_domain_adm' ),
							'repeat'    => __( 'Repeat', 'atlantes_domain_adm' ),
							'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_adm' ),
							'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_adm' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefixBg."bg-img-attachment",
						"label" => __( 'Background image attachment', 'atlantes_domain_adm' ),
						"desc" => __( 'Set background image attachment', 'atlantes_domain_adm' ),
						"options" => array(
							'fixed'  => __( 'Fixed position', 'atlantes_domain_adm' ),
							'scroll' => __( 'Move on scrolling', 'atlantes_domain_adm' )
							),
						"default" => 'fixed'
					),
					array(
						"type" => "checkbox",
						"id" => $prefixBg."bg-img-fit-window",
						"label" => __( 'Fit browser window width', 'atlantes_domain_adm' ),
						"desc" => __( 'Makes the image to scale to browser window width. Note that background image position and repeat options does not apply when this is checked.', 'atlantes_domain_adm' ),
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

		return $metaPostOptions;
	}
} // /wm_meta_post_options

?>