<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Design
*****************************************************
*/

$fontFile  = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
$fontIcons = wm_fontello_classes( $fontFile );

$prefix = 'design-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "design",
	"title" => __( 'Design', 'atlantes_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "design",
		"list" => array(
			__( 'Skin', 'atlantes_domain_panel' ),
			__( 'Colors', 'atlantes_domain_panel' ),
			__( 'Fonts', 'atlantes_domain_panel' ),
			__( 'Map', 'atlantes_domain_panel' ),
			__( 'Stylesheet', 'atlantes_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-1",
		"title" => __( 'Skin', 'atlantes_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'atlantes_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 7 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Website main theme skin', 'atlantes_domain_panel' )
		),

		array(
			"type" => "skins-json",
			"id" => $prefix."skin",
			"label" => __( 'Theme skins', 'atlantes_domain_panel' ),
			"desc" => __( 'It is recommended to set a theme skin first to be used as a base for your additional design changes.', 'atlantes_domain_panel' ) . '<br /><strong>' . __( 'When skin is changed, it will automatically reset several different options, so, be sure to keep a backup of settings (use Options Export/Import) if you made some design changes.', 'atlantes_domain_panel' ) . '</strong>',
			"options" => wm_skins(),
			"default" => "default.css"
		),
		array(
			"type" => "info",
			"content" => ( ! wm_option( 'design-skin' ) ) ? ( '<strong>' . wm_skin_meta( wm_option( 'default.css' ), 'skin' ) . ' ' . __( 'skin description', 'atlantes_domain_panel' ) . ':</strong><br />' . wm_skin_meta( 'default.css', 'description' ) ) : ( '<strong>' . wm_skin_meta( wm_option( 'design-skin' ), 'skin' ) . ' ' . __( 'skin description', 'atlantes_domain_panel' ) . ':</strong><br />' . wm_skin_meta( wm_option( 'design-skin' ), 'description' ) . '<br />&mdash; by ' . wm_skin_meta( wm_option( 'design-skin' ), 'author' ) )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'CSS3 Animations', 'atlantes_domain_panel' ),
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-animation-navigation",
				"label" => __( 'Disable navigation animation', 'atlantes_domain_panel' ),
				"desc" => __( 'Disables CSS3 animation effects on main theme menu', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-animation-heading",
				"label" => __( 'Disable main heading icon animation', 'atlantes_domain_panel' ),
				"desc" => __( 'Disables CSS3 animation effects on main heading area icon', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Skin tweaking', 'atlantes_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."accent-color",
				"label" => __( 'Accent color', 'atlantes_domain_panel' ),
				"desc" => __( 'The main accent color. Will be used on links, default button, dropcaps, active tabs, accordions and toggles for example.', 'atlantes_domain_panel' ),
				"validate" => "color"
			),
			array(
				"type" => "color",
				"id" => $prefix."elements-color",
				"label" => __( 'Global elements color', 'atlantes_domain_panel' ),
				"desc" => __( 'You can tweak the active accordions, tabs, toggles color here. If left blank, the Accent color is used.', 'atlantes_domain_panel' ),
				"validate" => "color"
			)
);

if ( class_exists( 'Woocommerce' ) )
	array_push( $options,
		array(
			"type" => "color",
			"id" => $prefix."accent-color-woocommerce",
			"label" => __( 'WooCommerce accent color', 'atlantes_domain_panel' ),
			"desc" => __( 'Accent color used for WooCommerce elements like prices, product reviews ratings, add to cart button, price filter and layered navigation widget.', 'atlantes_domain_panel' ),
			"validate" => "color"
		)
	);

array_push( $options,
			array(
				"type" => "space",
			),

		//basic colors:
		array(
			"type" => "box",
			"content" => __( 'Basic colors, which can be set below, are used on elements like buttons, boxes or markers', 'atlantes_domain_panel' ),
		),

			//blue
				array(
					"type" => "color",
					"id" => $prefix."type-blue-bg-color",
					"label" => __( 'General blue color', 'atlantes_domain_panel' ),
					"validate" => "color"
				),

			//gray
				array(
					"type" => "color",
					"id" => $prefix."type-gray-bg-color",
					"label" => __( 'General gray color', 'atlantes_domain_panel' ),
					"validate" => "color"
				),

			//green
				array(
					"type" => "color",
					"id" => $prefix."type-green-bg-color",
					"label" => __( 'General green color', 'atlantes_domain_panel' ),
					"validate" => "color"
				),

			//orange
				array(
					"type" => "color",
					"id" => $prefix."type-orange-bg-color",
					"label" => __( 'General orange color', 'atlantes_domain_panel' ),
					"validate" => "color"
				),

			//red
				array(
					"type" => "color",
					"id" => $prefix."type-red-bg-color",
					"label" => __( 'General red color', 'atlantes_domain_panel' ),
					"validate" => "color"
				),

			array(
				"type" => "slider",
				"id" => $prefix."text-color-coeficient",
				"label" => __( 'Text color tweak', 'atlantes_domain_panel' ),
				"desc" => __( 'Text color for the above basic color elements will be calculated automatically. You can adjust the calculation here.<br />This will set the text color brightness shift against the background color.', 'atlantes_domain_panel' ),
				"default" => 0,
				"min" => -50,
				"max" => 50,
				"step" => 1,
				"validate" => "int"
			),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-2",
		"title" => __( 'Colors', 'atlantes_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'atlantes_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 7 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Custom design', 'atlantes_domain_panel' )
		),
		array(
			"type" => "info",
			"content" => __( 'Here you can set your custom design. You can mainly set background color, image or texture here, alongside with the text, heading, links or border colors of different website sections. Sections also allow you to set additional layout options.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "space"
		),

		//backgrounds:

			//top panel background
			array(
				"type" => "heading3",
				"content" => __( 'Top bar', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."toppanel-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."toppanel-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."toppanel-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."toppanel-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."toppanel-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-toppanel-bg-pattern'] label span, [data-option='wm-design-toppanel-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."toppanel-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."toppanel-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."toppanel-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."toppanel-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."toppanel-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."toppanel-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."toppanel-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."toppanel-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."toppanel-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."toppanel-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//header background
			array(
				"type" => "heading3",
				"content" => __( 'Header', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."header-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."header-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."header-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."header-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."header-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."header-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."header-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."header-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-header-bg-pattern'] label span, [data-option='wm-design-header-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."header-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."header-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."header-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."header-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."header-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."header-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."header-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."header-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."header-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."header-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//navigation background
			array(
				"type" => "heading3",
				"content" => __( 'Navigation', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."navigation-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."navigation-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."accent-color",
						"label" => __( 'Accent color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "color",
						"id" => $prefix."subnavigation-"."bg-color",
						"label" => __( 'Subnavigation background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."subnavigation-"."color",
						"label" => __( 'Subnavigation text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"id" => $prefix."navigation-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."navigation-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-navigation-bg-pattern'] label span, [data-option='wm-design-navigation-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."navigation-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."navigation-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."navigation-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."navigation-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."navigation-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."navigation-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."navigation-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."navigation-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."navigation-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."navigation-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//slider background
			array(
				"type" => "heading3",
				"content" => __( 'Slider', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."slider-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."slider-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."slider-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."slider-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."slider-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."slider-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."slider-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-slider-bg-pattern'] label span, [data-option='wm-design-slider-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."slider-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."slider-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."slider-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."slider-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."slider-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."slider-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."slider-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."slider-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."slider-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."slider-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//main heading background
			array(
				"type" => "heading3",
				"content" => __( 'Main heading / title', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."mainheading-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."mainheading-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."alt-color",
						"label" => __( 'Alternative text color', 'atlantes_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'atlantes_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."mainheading-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-alignment",
						"label" => __( 'Text alignment', 'atlantes_domain_panel' ),
						"desc" => __( 'Sets the default text alignment for main heading area', 'atlantes_domain_panel' ),
						"options" => array(
								"left"   => __( 'Left', 'atlantes_domain_panel' ),
								"center" => __( 'Center', 'atlantes_domain_panel' ),
								"right"  => __( 'Right', 'atlantes_domain_panel' ),
							)
					),
				array(
					"id" => $prefix."mainheading-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."mainheading-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-mainheading-bg-pattern'] label span, [data-option='wm-design-mainheading-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."mainheading-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."mainheading-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."mainheading-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."mainheading-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."mainheading-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."mainheading-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."mainheading-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."mainheading-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."mainheading-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."mainheading-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//breadcrumbs background
			array(
				"type" => "heading3",
				"content" => __( 'Breadcrumbs', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."breadcrumbs-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."breadcrumbs-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."breadcrumbs-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."breadcrumbs-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."breadcrumbs-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-breadcrumbs-bg-pattern'] label span, [data-option='wm-design-breadcrumbs-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."breadcrumbs-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."breadcrumbs-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."breadcrumbs-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."breadcrumbs-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."breadcrumbs-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."breadcrumbs-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."breadcrumbs-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."breadcrumbs-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."breadcrumbs-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."breadcrumbs-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//page excerpt background
			array(
				"type" => "heading3",
				"content" => __( 'Page excerpt area', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."pageexcerpt-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."pageexcerpt-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."alt-color",
						"label" => __( 'Alternative text color', 'atlantes_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'atlantes_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."pageexcerpt-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."pageexcerpt-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."pageexcerpt-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-pageexcerpt-bg-pattern'] label span, [data-option='wm-design-pageexcerpt-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."pageexcerpt-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."pageexcerpt-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."pageexcerpt-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."pageexcerpt-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."pageexcerpt-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."pageexcerpt-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."pageexcerpt-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."pageexcerpt-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."pageexcerpt-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."pageexcerpt-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//content background
			array(
				"type" => "heading3",
				"content" => __( 'Content', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."content-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."content-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."content-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."content-"."alt-color",
						"label" => __( 'Alternative text color', 'atlantes_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'atlantes_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."content-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."content-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."content-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."content-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."content-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-content-bg-pattern'] label span, [data-option='wm-design-content-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."content-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."content-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."content-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."content-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."content-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."content-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."content-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."content-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."content-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."content-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//above footer background
			array(
				"type" => "heading3",
				"content" => __( 'Above footer area', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."abovefooter-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."abovefooter-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."alt-color",
						"label" => __( 'Alternative text color', 'atlantes_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'atlantes_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."abovefooter-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."abovefooter-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."abovefooter-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-abovefooter-bg-pattern'] label span, [data-option='wm-design-abovefooter-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."abovefooter-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."abovefooter-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."abovefooter-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."abovefooter-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."abovefooter-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."abovefooter-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."abovefooter-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."abovefooter-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."abovefooter-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."abovefooter-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//footer background
			array(
				"type" => "heading3",
				"content" => __( 'Footer', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."footer-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."footer-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."alt-color",
						"label" => __( 'Alternative text color', 'atlantes_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'atlantes_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."footer-"."layout",
						"label" => __( 'Section layout', 'atlantes_domain_panel' ),
						"desc" => __( 'Choose layout for this section', 'atlantes_domain_panel' ),
						"options" => array(
							""          => __( 'Theme global setting', 'atlantes_domain_panel' ),
							"boxed"     => __( 'Boxed', 'atlantes_domain_panel' ),
							"fullwidth" => __( 'Fullwidth', 'atlantes_domain_panel' )
							),
					),
				array(
					"id" => $prefix."footer-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."footer-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-footer-bg-pattern'] label span, [data-option='wm-design-footer-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."footer-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."footer-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."footer-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."footer-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."footer-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."footer-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."footer-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."footer-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."footer-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."footer-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//credits / bottom background
			array(
				"type" => "heading3",
				"content" => __( 'Bottom / credits area', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."bottom-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'atlantes_domain_panel' ), __( 'Background', 'atlantes_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."bottom-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."color",
						"label" => __( 'Text color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."accent-color",
						"label" => __( 'Link color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."border-color",
						"label" => __( 'Border color', 'atlantes_domain_panel' ),
						"desc" => __( 'Border color will be set automatically, but you can tweak it here if you want', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"id" => $prefix."bottom-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background
				array(
					"id" => $prefix."bottom-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-bottom-bg-pattern'] label span, [data-option='wm-design-bottom-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."bottom-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."bottom-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."bottom-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."bottom-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."bottom-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."bottom-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."bottom-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."bottom-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."bottom-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."bottom-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//website background
			array(
				"type" => "heading3",
				"content" => __( 'Website background', 'atlantes_domain_panel' )
			),
			array(
				"id" => $prefix."html-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Backmost background', 'atlantes_domain_panel' ), __( 'Topmost background', 'atlantes_domain_panel' ) )
				),

				//background backmost
				array(
					"id" => $prefix."html-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."html-"."bg-color",
						"label" => __( 'Background color', 'atlantes_domain_panel' ),
						"default" => "",
						"validate" => "color",
						"onchange" => "[data-option='wm-design-html-bg-pattern'] label span, [data-option='wm-design-html-bg-pattern'] .pattern-preview div"
					),

					array(
						"type" => "patterns",
						"id" => $prefix."html-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."html-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."html-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."html-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."html-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."html-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."html-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."html-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."html-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//background topmost
				array(
					"id" => $prefix."body-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."body-"."bg-pattern",
						"label" => __( 'Background pattern', 'atlantes_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),

					array(
						"id" => $prefix."body-"."imagebox",
						"type" => "inside-wrapper-open",
						"class" => "box"
					),
						array(
							"type" => "image",
							"id" => $prefix."body-"."bg-img-url",
							"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "image",
							"id" => $prefix."body-"."bg-img-url-highdpi",
							"label" => __( 'Custom high resolution background image', 'atlantes_domain_panel' ),
							"desc" => __( 'Double sized image for hight DPI / Retina displays', 'atlantes_domain_panel' ),
							"default" => "",
							"validate" => "url",
							"readonly" => true,
							"imgsize" => 'mobile'
						),
						array(
							"type" => "select",
							"id" => $prefix."body-"."bg-img-position",
							"label" => __( 'Background image position', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image position', 'atlantes_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'atlantes_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'atlantes_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'atlantes_domain_panel' ),
								'0 0'       => __( 'Left, top', 'atlantes_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'atlantes_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'atlantes_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'atlantes_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'atlantes_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'atlantes_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."body-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'atlantes_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'atlantes_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'atlantes_domain_panel' ),
								'repeat'    => __( 'Repeat', 'atlantes_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'atlantes_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'atlantes_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."body-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
								),
							"default" => 'scroll'
						),
					array(
						"id" => $prefix."body-"."imagebox",
						"type" => "inside-wrapper-close"
					),
				array(
					"id" => $prefix."body-"."sub-2",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."html-"."bg-container",
				"type" => "inside-wrapper-close"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-3",
		"title" => __( 'Fonts', 'atlantes_domain_panel' )
	)

);

if ( ! wm_option( $prefix . 'fontello-classes' ) )
	array_push( $options,
		array(
			"type" => "warning",
			"content" => '<strong>' . __( 'Please re-save the settings once again to save new Fontello font classes into database!', 'atlantes_domain_panel' ) . '</strong><br />' . __( 'For now they have been only collected and displayed in "Fontello font CSS classes" option below for review for possible editing.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "space"
		)
	);


array_push( $options,

		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'atlantes_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 7 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Font families', 'atlantes_domain_panel' )
		),
			array(
				"type" => "textarea",
				"id" => $prefix."font-custom",
				"label" => __( 'Custom font stylesheet link (HTML)', 'atlantes_domain_panel' ),
				"desc" => __( 'Use <code>&lt;link&gt;</code> HTML tags to embed custom fonts (can be obtained from <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a>, for example)', 'atlantes_domain_panel' ),
				"cols" => 70,
				"rows" => 8,
				"class" => "code"
			),
			array(
				"type" => "text",
				"id" => $prefix."font-primary",
				"label" => __( 'Primary font stack', 'atlantes_domain_panel' ),
				"desc" => __( 'Enter font names hierarchically separated with commas. Provide also the most basic fallback ("sans-serif" or "serif").', 'atlantes_domain_panel' ),
				"size" => "",
				"maxlength" => ""
			),
			array(
				"type" => "text",
				"id" => $prefix."font-secondary",
				"label" => __( 'Secondary font stack', 'atlantes_domain_panel' ),
				"desc" => __( 'Enter font names hierarchically separated with commas. Provide also the most basic fallback ("sans-serif" or "serif").', 'atlantes_domain_panel' ),
				"size" => "",
				"maxlength" => ""
			),

		array(
			"type" => "hr"
		),
		array(
			"type" => "heading3",
			"content" => __( 'Basic website font', 'atlantes_domain_panel' )
		),
			array(
				"type" => "select",
				"id" => $prefix."font-body-stack",
				"label" => __( 'Basic website font stack', 'atlantes_domain_panel' ),
				"desc" => __( 'Select previously set font stack for entire website', 'atlantes_domain_panel' ),
				"options" => array(
					"primary" => __( 'Primary font stack', 'atlantes_domain_panel' ),
					"secondary" => __( 'Secondary font stack', 'atlantes_domain_panel' )
					),
				"default" => "primary"
			),
			array(
				"type" => "slider",
				"id" => $prefix."font-body-size",
				"label" => __( 'Basic font size', 'atlantes_domain_panel' ),
				"desc" => __( 'Set the basic font size of the website (in pixels).', 'atlantes_domain_panel' ),
				"default" => 13,
				"min" => 9,
				"max" => 18,
				"step" => 1,
				"validate" => "absint"
			),

		array(
			"type" => "hr"
		),
		array(
			"type" => "heading3",
			"content" => __( 'Heading font', 'atlantes_domain_panel' )
		),
			array(
				"type" => "select",
				"id" => $prefix."font-heading-stack",
				"label" => __( 'Headings font', 'atlantes_domain_panel' ),
				"desc" => __( 'Select previously set font stack for website headings', 'atlantes_domain_panel' ),
				"options" => array(
					"primary" => __( 'Primary font stack', 'atlantes_domain_panel' ),
					"secondary" => __( 'Secondary font stack', 'atlantes_domain_panel' )
					),
				"default" => "secondary"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Icon font (Fontello.com)', 'atlantes_domain_panel' )
		),
			array(
				"type" => "textarea",
				"id" => $prefix."fontello-classes",
				"label" => __( 'Fontello font CSS classes', 'atlantes_domain_panel' ),
				"desc" => __( 'Set this only if you use <strong>custom</strong> Fontello icon font.', 'atlantes_domain_panel' ) . '<br />' . __( 'Once you upload a custom Fontello font files (please refer to theme user manual for procedure), delete all the text in the textarea below and save the settings. The theme will regenerate all the icon classes automatically. After new class names appear in the textarea below, re-save the settings again to confirm the classes (a notice will warn you about this).', 'atlantes_domain_panel' ),
				"default" => implode( ', ', $fontIcons ),
				"cols" => 70,
				"rows" => 8,
				"class" => "code"
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-4",
		"title" => __( 'Map', 'atlantes_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'atlantes_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 7 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Custom Google Map styling', 'atlantes_domain_panel' )
		),
			array(
				"type" => "textarea",
				"id" => $prefix."map-custom",
				"label" => __( 'Custom Google Map styling JSON', 'atlantes_domain_panel' ),
				"desc" => sprintf( __( 'Insert a JSON of custom Google Map styling / design. You can use <a%s>external application to create styling JSON</a> string for you.', 'atlantes_domain_panel' ), ' href="http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html" target="_blank"' ) . '<br />' . sprintf( __( 'Or you can dive into <a%s>Google Maps API</a> to learn the process (insert below only the actual array, not the variable definition).', 'atlantes_domain_panel' ), ' href="https://developers.google.com/maps/documentation/javascript/styling" target="_blank"' ),
				"cols" => 70,
				"rows" => 20,
				"class" => "code"
			),
			array(
				"type" => "select",
				"id" => $prefix."map-custom-marker",
				"label" => __( 'Marker color for custom map style', 'atlantes_domain_panel' ),
				"desc" => __( 'Select map marker color for your custom Google Map styling', 'atlantes_domain_panel' ),
				"options" => array(
					""          => __( 'Dark marker', 'atlantes_domain_panel' ),
					"-inverted" => __( 'Light marker', 'atlantes_domain_panel' )
					),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."map-bounce-marker",
				"label" => __( 'Bouncing markers', 'atlantes_domain_panel' ),
				"desc" => __( 'Enable bouncing animation on all map markers', 'atlantes_domain_panel' ),
				"value" => 1
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-5",
		"title" => __( 'Stylesheet', 'atlantes_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'atlantes_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 7 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'atlantes_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Main CSS stylesheet settings ', 'atlantes_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."minimize-css",
				"label" => __( 'Minimize CSS', 'atlantes_domain_panel' ),
				"desc" => __( 'Compress the main CSS stylesheet file (speeds up website loading)', 'atlantes_domain_panel' ),
				"default" => "true"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."gzip-cssonly",
				"label" => __( 'Enable GZIP compression on main stylesheet file only', 'atlantes_domain_panel' ),
				"desc" => __( 'If your web host applies GZIP compression by default, you can disable the main GZIP compression in "General" theme options. However, as main CSS stylesheet is being inserted as PHP file (and automatic GZIP compression is usually not applied on such files, you can enable it here.<br />You do not need to enable this GZIP compression if the global one (in "General" theme options) is enabled for the theme.', 'atlantes_domain_panel' )
			),
			array(
				"type" => "hr"
			),

			array(
				"type" => "checkbox",
				"id" => $prefix."custom-css-enable",
				"label" => __( 'Enable custom CSS textarea', 'atlantes_domain_panel' ),
				"desc" => __( 'Please note that you should really use <strong>child theme</strong> to apply your custom CSS styles. That is the WordPress default, recommended and preffered approach to tweak CSS styles. You can use this additional textarea for fast fixes or prototyping. Save the settings after you check the field to make the textarea visible.', 'atlantes_domain_panel' ),
				"default" => "true"
			)

);

if ( wm_option( $prefix . 'custom-css-enable' ) )
	array_push( $options,
				array(
					"type" => "space"
				),
				array(
					"type" => "textarea",
					"id" => $prefix."custom-css",
					"label" => __( 'Custom CSS', 'atlantes_domain_panel' ),
					"desc" => __( 'Type in custom CSS styles. These styles will be added to the end of the main CSS stylesheet file.<br />Please note that you should use <strong>child theme</strong> for this purpose.', 'atlantes_domain_panel' ),
					"default" => "",
					"cols" => 200,
					"rows" => 15,
					"class" => "code"
				)
	);


array_push( $options,

			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),

array(
	"type" => "section-close"
)

);

?>