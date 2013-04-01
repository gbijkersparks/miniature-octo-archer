<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Export / import
*****************************************************
*/

$prefix = 'export-';

array_push( $options_ei,

array(
	"type" => "section-open",
	"section-id" => "export",
	"title" => __( 'Export / import', 'atlantes_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "export",
		"list" => array(
			__( 'Export / import', 'atlantes_domain_panel' )
			)
	),

	array(
		"type" => "sub-section-open",
		"sub-section-id" => "export-1",
		"title" => __( 'Export / import', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Theme settings export / import', 'atlantes_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "settingsExporter",
			"id" => "settingsExporter",
			"label-export" => __( 'Export', 'atlantes_domain_panel' ),
			"desc-export" => __( 'To export the current settings copy and keep (save to external file) the settings string below', 'atlantes_domain_panel' ),
			"label-import" => __( 'Import', 'atlantes_domain_panel' ),
			"desc-import" => __( 'To import previously saved settings, insert the settings string below. Note that by importing new settings you will loose all current ones. Always keep the backup of current settings.', 'atlantes_domain_panel' )
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