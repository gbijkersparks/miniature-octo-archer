<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Error 404 page
*****************************************************
*/

$prefix = 'p404-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "p404",
	"title" => __( 'Error 404', 'atlantes_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "p404",
		"list" => array(
			__( 'Error 404 page', 'atlantes_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "p404-1",
		"title" => __( 'Error 404 page', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Error 404 page settings', 'atlantes_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "text",
			"id" => $prefix."title",
			"label" => __( 'Page meta title', 'atlantes_domain_panel' ),
			"desc" => __( 'Error 404 page meta title', 'atlantes_domain_panel' ),
			"default" => __( 'Web page was not found', 'atlantes_domain' )
		),
		array(
			"type" => "textarea",
			"id" => $prefix."text",
			"label" => __( 'Page text', 'atlantes_domain_panel' ),
			"desc" => __( 'You can insert HTML here', 'atlantes_domain_panel' ),
			"default" => "<h1>" . __( 'Page not found', 'atlantes_domain' ) . "</h1>
<p>" . __( 'The page you are looking for was moved, deleted or does not exist.', 'atlantes_domain' ) . "</p>
<p>[button color=\"blue\" icon=\"icon-home\" size=\"xl\" url=\"" . home_url() . "\"]" . __( 'Return to homepage', 'atlantes_domain' ) . "[/button]</p>
",
			"cols" => 70,
			"rows" => 7,
			"empty" => true
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."no-above-footer-widgets",
			"label" => __( 'Disable widgets above footer', 'atlantes_domain_panel' ),
			"desc" => __( 'Disables Above Footer widgets area on Error 404 page', 'atlantes_domain_panel' ),
			"value" => "no"
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