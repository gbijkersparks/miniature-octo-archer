<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Clients access
*****************************************************
*/

$prefix = 'access-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "access",
	"title" => __( 'Client area', 'atlantes_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "access",
		"list" => array(
			__( 'Client area', 'atlantes_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "access-1",
		"title" => __( 'Client area', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Clients area', 'atlantes_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "box",
				"content" => '<p class="info">' . __( 'Please read the information below before enabling and using the Client area.', 'atlantes_domain_panel' ) . '</p><br /><br />
					<h4>' . __( 'What is Client area and how can I use it?', 'atlantes_domain_panel' ) . '</h4>
					<p>' . sprintf( __( 'Client area makes it possible to restrict a visitor access to certain pages. The restriction can be set to registered users individually or to certain registered user group, such as "Subscribers" or "Contributors" &rarr; <a href="%s" target="_blank">manage users</a>. Restricted pages will be also removed from all menus, including !LesPaul Submenu widget, Custom Menu widget and Pages widget and also from search results when visitor access denied.', 'atlantes_domain_panel' ), get_admin_url() . 'users.php' ) . '</p>
					<p>' . __( 'You can use this functionality to provide a special access to your clients specific files or information. Client will only see the pages (and menu items) after logging in (you can even use Login shortcode to place the form on any page or into text widget).', 'atlantes_domain_panel' ) . '</p>
					<p>' . __( 'When you enable Client area below, a new option will be added to the bottom of <strong>"General" tab</strong> of page settings on page edit screen.', 'atlantes_domain_panel' ) . '</p>
					<h4>' . __( 'How about security?', 'atlantes_domain_panel' ) . '</h4>
					<p>' . __( 'Clients area is built upon WordPress native functionality, so it is as secure as your WordPress installation is. However, it does not provide restriction on attachment files, so if the visitor by any chance knows the exact URL of specific attachment file (even if it was attached to restricted page), it can be easily accessed. As a workaround you can use password protected ZIP files for this reason, for example.', 'atlantes_domain_panel' ) . '</p>
					<h4>' . __( 'Can I restrict access to any page?', 'atlantes_domain_panel' ) . '</h4>
					<p>' . __( 'Client area supports these page templates only: <strong>default</strong> page template, <strong>Map</strong> page template, <strong>Portfolio</strong> page template, <strong>Sections</strong> page template and <strong>Sitemap</strong> page template.', 'atlantes_domain_panel' ) . '</p>
					<h4>' . __( 'How about posts or other content?', 'atlantes_domain_panel' ) . '</h4>' . __( 'You can restrict access just for page templates mentioned previously. All the other content will be accessible.', 'atlantes_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."client-area",
				"label" => __( 'Enable client area', 'atlantes_domain_panel' ),
				"desc" => __( 'Enables client area capabilities', 'atlantes_domain_panel' )
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