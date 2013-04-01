<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Branding
*****************************************************
*/

$loginLogoFile = ( wm_check_wp_version( '3.2' ) ) ? ( "logo-login.png" ) : ( "logo-login.gif" );
$loginLogoFile = ( wm_check_wp_version( '3.4' ) ) ? ( "wordpress-logo.png" ) : ( $loginLogoFile );

$prefix = 'branding-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "branding",
	"title" => __( 'Branding', 'atlantes_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "branding",
		"list" => array(
			__( 'Logo, favicon', 'atlantes_domain_panel' ),
			__( 'Login screen', 'atlantes_domain_panel' ),
			__( 'Admin', 'atlantes_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "branding-1",
		"title" => __( 'Logo, favicon', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Website logo, favicon and touch icon', 'atlantes_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "radio",
				"id" => $prefix."logo-type",
				"label" => __( 'Logo type', 'atlantes_domain_panel' ),
				"desc" => __( 'You can use image or text logo.', 'atlantes_domain_panel' ),
				"options" => array(
					'img'  => __( 'Use image logo', 'atlantes_domain_panel' ),
					'text' => __( 'Use website title from WordPress Settings', 'atlantes_domain_panel' ).' ("' . get_bloginfo('title') . '")'
					),
				"default" => "img"
			),
			array(
				"type" => "image",
				"id" => $prefix."logo-img",
				"label" => __( 'Custom logo image URL address', 'atlantes_domain_panel' ),
				"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "url",
				"readonly" => true,
				"imgsize" => 'mobile'
			),
			array(
				"type" => "image",
				"id" => $prefix."logo-img-highdpi",
				"label" => __( 'High DPI / Retina logo image URL address', 'atlantes_domain_panel' ),
				"desc" => __( 'Needs to be double the size of the normal logo', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "url",
				"readonly" => true,
				"imgsize" => 'mobile'
			),
			array(
				"type" => "slider",
				"id" => $prefix."logo-margin",
				"label" => __( 'Logo padding', 'atlantes_domain_panel' ),
				"desc" => __( 'Sets the top logo padding size ("-1" sets the default padding). The bottom spacing of the logo can be tweaked by setting website header height.', 'atlantes_domain_panel' ),
				"default" => -1,
				"min" => -1,
				"max" => 100,
				"step" => 1,
				"validate" => "int",
				"zero" => true
			),
			array(
				"type" => "hr"
			),
			array(
				"type" => "image",
				"id" => $prefix."favicon-url-ico",
				"label" => __( 'Favicon (16x16 and 32x32, .ico format) for IE', 'atlantes_domain_panel' ),
				"desc" => __( 'Favicon for Internet Explorer browsers. As ICO files can contain multiple icon sizes, please include both 16x16 and 32x32 icon version for the highDPI/Retina displays compatibility. You can use an <a href="http://xiconeditor.com/" target="_blank">online tool to create your ICO file</a>.', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/favicon.ico',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."favicon-url-png",
				"label" => __( 'Favicon (32x32 size preferably, .png format) for other browsers', 'atlantes_domain_panel' ),
				"desc" => __( 'Favicon will be displayed as bookmark icon or on browser tab or in browser address line', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/favicon.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-57",
				"label" => __( 'Touch icon 57x57', 'atlantes_domain_panel' ),
				"desc" => __( 'Touch icon for non-Retina iPhone, iPod Touch and Android 2.1+ devices', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-57.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-72",
				"label" => __( 'Touch icon 72x72', 'atlantes_domain_panel' ),
				"desc" => __( 'Touch icon for 1st and 2nd generation iPad', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-72.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-114",
				"label" => __( 'Touch icon 114x114', 'atlantes_domain_panel' ),
				"desc" => __( 'Touch icon for Retina iPhone', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-114.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-144",
				"label" => __( 'Touch icon 144x144', 'atlantes_domain_panel' ),
				"desc" => __( 'Touch icon for Retina iPad', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-144.png',
				"validate" => "url"
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "branding-2",
		"title" => __( 'Login screen', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Login screen customization', 'atlantes_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "heading4",
			"content" => __( 'Login logo', 'atlantes_domain_panel' )
		),
			array(
				"type" => "image",
				"id" => $prefix."login-logo",
				"label" => __( 'Logo', 'atlantes_domain_panel' ),
				"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
				"default" => site_url() . "/wp-admin/images/" . $loginLogoFile,
				"validate" => "url"
			),
			array(
				"type" => "slider",
				"id" => $prefix."login-logo-height",
				"label" => __( 'Logo container height', 'atlantes_domain_panel' ),
				"desc" => __( 'Set the height of login logo container in pixels. The logo will be centered inside.', 'atlantes_domain_panel' ),
				"default" => 100,
				"min" => 60,
				"max" => 300,
				"step" => 5,
				"validate" => "absint"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Login page background', 'atlantes_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-"."bg-color",
				"label" => __( 'Background color', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "color",
				"onchange" => "[data-option='wm-branding-login-bg-pattern'] label span, [data-option='wm-branding-login-bg-pattern'] .pattern-preview div"
			),

			array(
				"type" => "image",
				"id" => $prefix."login-"."bg-img-url",
				"label" => __( 'Custom background image', 'atlantes_domain_panel' ),
				"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "url"
			),
			array(
				"type" => "select",
				"id" => $prefix."login-"."bg-img-position",
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
				"id" => $prefix."login-"."bg-img-repeat",
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
				"id" => $prefix."login-"."bg-img-attachment",
				"label" => __( 'Background image attachment', 'atlantes_domain_panel' ),
				"desc" => __( 'Set the background image attachment', 'atlantes_domain_panel' ),
				"options" => array(
					'scroll' => __( 'Move on scrolling', 'atlantes_domain_panel' ),
					'fixed'  => __( 'Fixed position', 'atlantes_domain_panel' )
					),
				"default" => 'scroll'
			),

			array(
				"type" => "patterns",
				"id" => $prefix."login-"."bg-pattern",
				"label" => __( 'Set background pattern', 'atlantes_domain_panel' ),
				"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'atlantes_domain_panel' ),
				"options" => wm_get_image_files(),
				"default" => "",
				"preview" => true
			),

			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Form settings', 'atlantes_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-form-bg-color",
				"label" => __( 'Form background color', 'atlantes_domain_panel' ),
				"desc" => __( 'Label color will be set automatically', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "color",
				"id" => $prefix."login-form-button-bg-color",
				"label" => __( 'Submit button color', 'atlantes_domain_panel' ),
				"desc" => __( 'Button text color will be set automatically', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Links below login form settings', 'atlantes_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-accent-color",
				"label" => __( 'Link text color', 'atlantes_domain_panel' ),
				"desc" => "",
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "color",
				"id" => $prefix."login-link-bg-color",
				"label" => __( 'Link background color', 'atlantes_domain_panel' ),
				"desc" => "",
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Messages settings', 'atlantes_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-message-bg-color",
				"label" => __( 'Messages background color', 'atlantes_domain_panel' ),
				"desc" => __( 'Message text color will be set automatically', 'atlantes_domain_panel' ),
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "branding-3",
		"title" => __( 'Admin', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'WordPress admin area customization', 'atlantes_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "box",
			"content" => __( 'Many clients require custom branded admin area for their websites. You can do exactly that in this section: set custom logo (or disable it), remove WordPress logo from admin bar, customize admin footer text, disable/enable WordPress admin menu items and dashboard widgets and completely debrand this theme admin panel.', 'atlantes_domain_panel' )
		),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin logo', 'atlantes_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."admin-use-logo",
				"label" => __( 'Use custom admin logo', 'atlantes_domain_panel' ),
				"desc" => __( 'Replaces "Dashboard" WordPress admin menu item with your custom logo set below', 'atlantes_domain_panel' ),
				"value" => "true",
				"default" => "true"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."admin-bar-no-logo",
				"label" => __( 'Remove (W) logo from admin bar', 'atlantes_domain_panel' ),
				"desc" => __( 'Removes WordPress logo and menu from admin bar', 'atlantes_domain_panel' ),
				"value" => "true",
				"default" => "true"
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "image",
				"id" => $prefix."admin-logo",
				"label" => __( 'Custom admin logo', 'atlantes_domain_panel' ),
				"desc" => __( 'Maximum width of 120px. The logo will be displayed at the top of WordPress admin menu.', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/logo-' . WM_THEME_SHORTNAME . '-admin-main.png',
				"validate" => "url"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin footer', 'atlantes_domain_panel' )
		),
			array(
				"type" => "textarea",
				"id" => $prefix."admin-footer",
				"label" => __( 'Admin custom footer text', 'atlantes_domain_panel' ),
				"desc" => __( 'Text (you can use inline HTML tags) will be inserted into Paragraph HTML tag of WordPress admin footer', 'atlantes_domain_panel' ),
				"default" => "",
				"cols" => 65,
				"rows" => 3
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Theme admin panel branding', 'atlantes_domain_panel' )
		),
			array(
				"type" => "image",
				"id" => $prefix."panel-logo",
				"label" => __( 'Admin panel logo', 'atlantes_domain_panel' ),
				"desc" => __( 'Sets the logo displayed above admin panel main navigation (maximum width of 160px)', 'atlantes_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/logo-' . WM_THEME_SHORTNAME . '-admin.png',
				"validate" => "url"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."panel-no-logo",
				"label" => __( 'Remove logo from admin panel', 'atlantes_domain_panel' ),
				"desc" => __( 'No logo will be displayed in theme admin panel', 'atlantes_domain_panel' )
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin menu', 'atlantes_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-menu-posts",
				"label" => __( 'Disable WordPress Posts', 'atlantes_domain_panel' ),
				"desc" => __( 'In case blog is not required for your website (note, however, that testimonials are being populated from Quote posts)', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-menu-media",
				"label" => __( 'Disable WordPress Media', 'atlantes_domain_panel' ),
				"desc" => __( 'Removes Media library from WordPress admin menu', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-menu-comments",
				"label" => __( 'Disable WordPress Comments', 'atlantes_domain_panel' ),
				"desc" => __( 'Removes Comments management from WordPress admin menu', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin dashboard widgets', 'atlantes_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-incominglinks",
				"label" => __( 'Disable "Incoming Links"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-wpsecondary",
				"label" => __( 'Disable "Other WordPress News"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-plugins",
				"label" => __( 'Disable "Plugins"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-quickpress",
				"label" => __( 'Disable "QuickPress"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-recentcomments",
				"label" => __( 'Disable "Recent Comments"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-recentdrafts",
				"label" => __( 'Disable "Recent Drafts"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-rightnow",
				"label" => __( 'Disable "Right Now"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-wpprimary",
				"label" => __( 'Disable "WordPress Blog"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Custom "Quick Access" dashboard widget', 'atlantes_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-quickaccess",
				"label" => __( 'Disable "Quick Access"', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "text",
				"id" => $prefix."dash-quickaccess-title",
				"label" => __( '"Quick Access" widget title', 'atlantes_domain_panel' ),
				"desc" => __( 'You can change the title of the widget here', 'atlantes_domain_panel' ),
				"default" => __( 'Quick Access', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "textarea",
				"id" => $prefix."dash-quickaccess-text",
				"label" => __( '"Quick Access" widget text', 'atlantes_domain_panel' ),
				"desc" => __( 'This text will be displayed in "Quick Access" dashboard widget. You can use user group specific shortcodes to display text only for specific group, such as:', 'atlantes_domain_panel' ) . ' <code>[administrator][/administrator]</code>, <code>[editor][/editor]</code>, <code>[author][/author]</code>, <code>[contributor][/contributor]</code>, <code>[subscriber][/subscriber]</code>.',
				"editor" => true,
			),
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