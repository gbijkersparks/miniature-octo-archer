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
	"title" => __( 'Branding', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "branding",
		"list" => array(
			__( 'Logo, favicon', 'lespaul_domain_panel' ),
			__( 'Login screen', 'lespaul_domain_panel' ),
			__( 'Admin', 'lespaul_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "branding-1",
		"title" => __( 'Logo, favicon', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Website logo, favicon and touch icon', 'lespaul_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "radio",
				"id" => $prefix."logo-type",
				"label" => __( 'Logo type', 'lespaul_domain_panel' ),
				"desc" => __( 'You can use image or text logo.', 'lespaul_domain_panel' ),
				"options" => array(
					'img'  => __( 'Use image logo', 'lespaul_domain_panel' ),
					'text' => __( 'Use website title from WordPress Settings', 'lespaul_domain_panel' ).' ("' . get_bloginfo('title') . '")'
					),
				"default" => "img"
			),
			array(
				"type" => "image",
				"id" => $prefix."logo-img",
				"label" => __( 'Custom logo image URL address', 'lespaul_domain_panel' ),
				"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_panel' ),
				"default" => "",
				"validate" => "url",
				"readonly" => true,
				"imgsize" => 'mobile'
			),
			array(
				"type" => "image",
				"id" => $prefix."logo-img-highdpi",
				"label" => __( 'High DPI / Retina logo image URL address', 'lespaul_domain_panel' ),
				"desc" => __( 'Needs to be double the size of the normal logo', 'lespaul_domain_panel' ),
				"default" => "",
				"validate" => "url",
				"readonly" => true,
				"imgsize" => 'mobile'
			),
			array(
				"type" => "slider",
				"id" => $prefix."logo-margin",
				"label" => __( 'Logo padding', 'lespaul_domain_panel' ),
				"desc" => __( 'Sets the top logo padding size ("-1" sets the default padding). The bottom spacing of the logo can be tweaked by setting website header height.', 'lespaul_domain_panel' ),
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
				"label" => __( 'Favicon (16x16 and 32x32, .ico format) for IE', 'lespaul_domain_panel' ),
				"desc" => __( 'Favicon for Internet Explorer browsers. As ICO files can contain multiple icon sizes, please include both 16x16 and 32x32 icon version for the highDPI/Retina displays compatibility. You can use an <a href="http://xiconeditor.com/" target="_blank">online tool to create your ICO file</a>.', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/favicon.ico',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."favicon-url-png",
				"label" => __( 'Favicon (32x32 size preferably, .png format) for other browsers', 'lespaul_domain_panel' ),
				"desc" => __( 'Favicon will be displayed as bookmark icon or on browser tab or in browser address line', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/favicon.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-57",
				"label" => __( 'Touch icon 57x57', 'lespaul_domain_panel' ),
				"desc" => __( 'Touch icon for non-Retina iPhone, iPod Touch and Android 2.1+ devices', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-57.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-72",
				"label" => __( 'Touch icon 72x72', 'lespaul_domain_panel' ),
				"desc" => __( 'Touch icon for 1st and 2nd generation iPad', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-72.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-114",
				"label" => __( 'Touch icon 114x114', 'lespaul_domain_panel' ),
				"desc" => __( 'Touch icon for Retina iPhone', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/touch-icon-114.png',
				"validate" => "url"
			),
			array(
				"type" => "image",
				"id" => $prefix."touch-icon-url-144",
				"label" => __( 'Touch icon 144x144', 'lespaul_domain_panel' ),
				"desc" => __( 'Touch icon for Retina iPad', 'lespaul_domain_panel' ),
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
		"title" => __( 'Login screen', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Login screen customization', 'lespaul_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "heading4",
			"content" => __( 'Login logo', 'lespaul_domain_panel' )
		),
			array(
				"type" => "image",
				"id" => $prefix."login-logo",
				"label" => __( 'Logo', 'lespaul_domain_panel' ),
				"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_panel' ),
				"default" => site_url() . "/wp-admin/images/" . $loginLogoFile,
				"validate" => "url"
			),
			array(
				"type" => "slider",
				"id" => $prefix."login-logo-height",
				"label" => __( 'Logo container height', 'lespaul_domain_panel' ),
				"desc" => __( 'Set the height of login logo container in pixels. The logo will be centered inside.', 'lespaul_domain_panel' ),
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
			"content" => __( 'Login page background', 'lespaul_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-"."bg-color",
				"label" => __( 'Background color', 'lespaul_domain_panel' ),
				"default" => "",
				"validate" => "color",
				"onchange" => "[data-option='wm-branding-login-bg-pattern'] label span, [data-option='wm-branding-login-bg-pattern'] .pattern-preview div"
			),

			array(
				"type" => "image",
				"id" => $prefix."login-"."bg-img-url",
				"label" => __( 'Custom background image', 'lespaul_domain_panel' ),
				"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_panel' ),
				"default" => "",
				"validate" => "url"
			),
			array(
				"type" => "select",
				"id" => $prefix."login-"."bg-img-position",
				"label" => __( 'Background image position', 'lespaul_domain_panel' ),
				"desc" => __( 'Set background image position', 'lespaul_domain_panel' ),
				"options" => array(
					'50% 50%'   => __( 'Center', 'lespaul_domain_panel' ),
					'50% 0'     => __( 'Center horizontally, top', 'lespaul_domain_panel' ),
					'50% 100%'  => __( 'Center horizontally, bottom', 'lespaul_domain_panel' ),
					'0 0'       => __( 'Left, top', 'lespaul_domain_panel' ),
					'0 50%'     => __( 'Left, center vertically', 'lespaul_domain_panel' ),
					'0 100%'    => __( 'Left, bottom', 'lespaul_domain_panel' ),
					'100% 0'    => __( 'Right, top', 'lespaul_domain_panel' ),
					'100% 50%'  => __( 'Right, center vertically', 'lespaul_domain_panel' ),
					'100% 100%' => __( 'Right, bottom', 'lespaul_domain_panel' ),
					),
				"default" => '50% 0'
			),
			array(
				"type" => "select",
				"id" => $prefix."login-"."bg-img-repeat",
				"label" => __( 'Background image repeat', 'lespaul_domain_panel' ),
				"desc" => __( 'Set background image repeating', 'lespaul_domain_panel' ),
				"options" => array(
					'no-repeat' => __( 'Do not repeat', 'lespaul_domain_panel' ),
					'repeat'    => __( 'Repeat', 'lespaul_domain_panel' ),
					'repeat-x'  => __( 'Repeat horizontally', 'lespaul_domain_panel' ),
					'repeat-y'  => __( 'Repeat vertically', 'lespaul_domain_panel' )
					),
				"default" => 'no-repeat'
			),
			array(
				"type" => "radio",
				"id" => $prefix."login-"."bg-img-attachment",
				"label" => __( 'Background image attachment', 'lespaul_domain_panel' ),
				"desc" => __( 'Set the background image attachment', 'lespaul_domain_panel' ),
				"options" => array(
					'scroll' => __( 'Move on scrolling', 'lespaul_domain_panel' ),
					'fixed'  => __( 'Fixed position', 'lespaul_domain_panel' )
					),
				"default" => 'scroll'
			),

			array(
				"type" => "patterns",
				"id" => $prefix."login-"."bg-pattern",
				"label" => __( 'Set background pattern', 'lespaul_domain_panel' ),
				"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color.<br />Background image attachment setting will affect patterns too.', 'lespaul_domain_panel' ),
				"options" => wm_get_image_files(),
				"default" => "",
				"preview" => true
			),

			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Form settings', 'lespaul_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-form-bg-color",
				"label" => __( 'Form background color', 'lespaul_domain_panel' ),
				"desc" => __( 'Label color will be set automatically', 'lespaul_domain_panel' ),
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "color",
				"id" => $prefix."login-form-button-bg-color",
				"label" => __( 'Submit button color', 'lespaul_domain_panel' ),
				"desc" => __( 'Button text color will be set automatically', 'lespaul_domain_panel' ),
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Links below login form settings', 'lespaul_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-accent-color",
				"label" => __( 'Link text color', 'lespaul_domain_panel' ),
				"desc" => "",
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "color",
				"id" => $prefix."login-link-bg-color",
				"label" => __( 'Link background color', 'lespaul_domain_panel' ),
				"desc" => "",
				"default" => "",
				"validate" => "color"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Messages settings', 'lespaul_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."login-message-bg-color",
				"label" => __( 'Messages background color', 'lespaul_domain_panel' ),
				"desc" => __( 'Message text color will be set automatically', 'lespaul_domain_panel' ),
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
		"title" => __( 'Admin', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'WordPress admin area customization', 'lespaul_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "box",
			"content" => __( 'Many clients require custom branded admin area for their websites. You can do exactly that in this section: set custom logo (or disable it), remove WordPress logo from admin bar, customize admin footer text, disable/enable WordPress admin menu items and dashboard widgets and completely debrand this theme admin panel.', 'lespaul_domain_panel' )
		),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin logo', 'lespaul_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."admin-use-logo",
				"label" => __( 'Use custom admin logo', 'lespaul_domain_panel' ),
				"desc" => __( 'Replaces "Dashboard" WordPress admin menu item with your custom logo set below', 'lespaul_domain_panel' ),
				"value" => "true",
				"default" => "true"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."admin-bar-no-logo",
				"label" => __( 'Remove (W) logo from admin bar', 'lespaul_domain_panel' ),
				"desc" => __( 'Removes WordPress logo and menu from admin bar', 'lespaul_domain_panel' ),
				"value" => "true",
				"default" => "true"
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "image",
				"id" => $prefix."admin-logo",
				"label" => __( 'Custom admin logo', 'lespaul_domain_panel' ),
				"desc" => __( 'Maximum width of 120px. The logo will be displayed at the top of WordPress admin menu.', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/logo-' . WM_THEME_SHORTNAME . '-admin-main.png',
				"validate" => "url"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin footer', 'lespaul_domain_panel' )
		),
			array(
				"type" => "textarea",
				"id" => $prefix."admin-footer",
				"label" => __( 'Admin custom footer text', 'lespaul_domain_panel' ),
				"desc" => __( 'Text (you can use inline HTML tags) will be inserted into Paragraph HTML tag of WordPress admin footer', 'lespaul_domain_panel' ),
				"default" => "",
				"cols" => 65,
				"rows" => 3
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Theme admin panel branding', 'lespaul_domain_panel' )
		),
			array(
				"type" => "image",
				"id" => $prefix."panel-logo",
				"label" => __( 'Admin panel logo', 'lespaul_domain_panel' ),
				"desc" => __( 'Sets the logo displayed above admin panel main navigation (maximum width of 160px)', 'lespaul_domain_panel' ),
				"default" => WM_ASSETS_THEME . 'img/branding/logo-' . WM_THEME_SHORTNAME . '-admin.png',
				"validate" => "url"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."panel-no-logo",
				"label" => __( 'Remove logo from admin panel', 'lespaul_domain_panel' ),
				"desc" => __( 'No logo will be displayed in theme admin panel', 'lespaul_domain_panel' )
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin menu', 'lespaul_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-menu-posts",
				"label" => __( 'Disable WordPress Posts', 'lespaul_domain_panel' ),
				"desc" => __( 'In case blog is not required for your website (note, however, that testimonials are being populated from Quote posts)', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-menu-media",
				"label" => __( 'Disable WordPress Media', 'lespaul_domain_panel' ),
				"desc" => __( 'Removes Media library from WordPress admin menu', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-menu-comments",
				"label" => __( 'Disable WordPress Comments', 'lespaul_domain_panel' ),
				"desc" => __( 'Removes Comments management from WordPress admin menu', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'WordPress admin dashboard widgets', 'lespaul_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-incominglinks",
				"label" => __( 'Disable "Incoming Links"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-wpsecondary",
				"label" => __( 'Disable "Other WordPress News"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-plugins",
				"label" => __( 'Disable "Plugins"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-quickpress",
				"label" => __( 'Disable "QuickPress"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-recentcomments",
				"label" => __( 'Disable "Recent Comments"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-recentdrafts",
				"label" => __( 'Disable "Recent Drafts"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-rightnow",
				"label" => __( 'Disable "Right Now"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-wpprimary",
				"label" => __( 'Disable "WordPress Blog"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading4",
			"content" => __( 'Custom "Quick Access" dashboard widget', 'lespaul_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."remove-dash-quickaccess",
				"label" => __( 'Disable "Quick Access"', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "text",
				"id" => $prefix."dash-quickaccess-title",
				"label" => __( '"Quick Access" widget title', 'lespaul_domain_panel' ),
				"desc" => __( 'You can change the title of the widget here', 'lespaul_domain_panel' ),
				"default" => __( 'Quick Access', 'lespaul_domain_panel' ),
			),
			array(
				"type" => "textarea",
				"id" => $prefix."dash-quickaccess-text",
				"label" => __( '"Quick Access" widget text', 'lespaul_domain_panel' ),
				"desc" => __( 'This text will be displayed in "Quick Access" dashboard widget. You can use user group specific shortcodes to display text only for specific group, such as:', 'lespaul_domain_panel' ) . ' <code>[administrator][/administrator]</code>, <code>[editor][/editor]</code>, <code>[author][/author]</code>, <code>[contributor][/contributor]</code>, <code>[subscriber][/subscriber]</code>.',
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