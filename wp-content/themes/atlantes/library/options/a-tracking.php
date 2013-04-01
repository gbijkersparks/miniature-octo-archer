<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Tracking and scripts
*****************************************************
*/

$prefix = 'tracking-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "seo",
	"title" => __( 'Tracking', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "seo",
		"list" => array(
			__( 'Tracking and scripts', 'lespaul_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "seo-1",
		"title" => __( 'Tracking and scripts', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Tracking codes or custom <abbr title="JavaScript">JS</abbr> scripts', 'lespaul_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "textarea",
			"id" => $prefix."custom-footer",
			"label" => __( 'Scripts', 'lespaul_domain_panel' ),
			"desc" => __( 'Custom scripts at the end of the website HTML code just before closing BODY tag. Can be used for tracking code placement. Do not forget to include <code>&lt;script&gt;</code> HTML tags.', 'lespaul_domain_panel' ),
			"default" => "",
			"class" => "code",
			"cols" => 70,
			"rows" => 15,
		),
		array(
			"type" => "select",
			"id" => $prefix."no-logged",
			"label" => __( 'Do not track logged in users', 'lespaul_domain_panel' ),
			"desc" => __( 'Removes the above scripts when user is logged in with certain minimum user role, thus preventing the tracking of logged-in users.', 'lespaul_domain_panel' ),
			"options" => array(
				''                       => __( 'Track everyone', 'lespaul_domain_panel' ),
				'read'                   => __( 'Subscribers (and above) - all logged in users', 'lespaul_domain_panel' ),
				'delete_posts'           => __( 'Contributors (and above)', 'lespaul_domain_panel' ),
				'delete_published_posts' => __( 'Authors (and above)', 'lespaul_domain_panel' ),
				'read_private_pages'     => __( 'Editors (and above)', 'lespaul_domain_panel' ),
				'edit_dashboard'         => __( 'Administrators', 'lespaul_domain_panel' ),
				),
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