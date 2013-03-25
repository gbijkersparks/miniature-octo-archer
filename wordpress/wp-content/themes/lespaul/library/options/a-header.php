<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Header
*****************************************************
*/

$prefix = 'header-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "web-header",
	"title" => __( 'Header', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "web-header",
		"list" => array(
			__( 'Website header', 'lespaul_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "web-header-1",
		"title" => __( 'Website header', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Website header', 'lespaul_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "slider",
				"id" => $prefix."height", //no prefix here to keep compatibility after moving from Design section to Layout
				"label" => __( '(Minimal) Header height', 'lespaul_domain_panel' ),
				"desc" => __( 'Set the minimal header height (leave zero to use the default theme settings)', 'lespaul_domain_panel' ),
				"default" => 0,
				"min" => 0,
				"max" => 300,
				"step" => 5,
				"validate" => "int",
				"zero" => true
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."header-position",
				"label" => __( 'Stick header to the top', 'lespaul_domain_panel' ),
				"desc" => __( 'Sticks website header to the top of the browser window, making it always visible', 'lespaul_domain_panel' ),
				"value" => "header-fixed"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."top-bar-fixed", //no prefix here to keep compatibility after moving from Design section to Layout
				"label" => __( 'Sticky top bar', 'lespaul_domain_panel' ),
				"desc" => __( 'Sticks the top bar to the top of the browser window, making it always visible', 'lespaul_domain_panel' )
			),
			array(
				"type" => "hr",
			),

			array(
				"type" => "select",
				"id" => $prefix."navigation-position",
				"label" => __( 'Navigation position', 'lespaul_domain_panel' ),
				"desc" => __( 'Changes website main navigation position, affecting the website header layout', 'lespaul_domain_panel' ),
				"options" => array(
					' nav-right'                  => __( 'Navigation right (no right header area text)', 'lespaul_domain_panel' ),
					' nav-bottom'                 => __( 'Navigation bottom', 'lespaul_domain_panel' ),
					' nav-bottom layout-centered' => __( 'Navigation bottom, centered logo and navigation', 'lespaul_domain_panel' ),
					' nav-top'                    => __( 'Navigation top', 'lespaul_domain_panel' ),
					),
				"default" => " nav-right"
			),
			array(
				"type" => "slider",
				"id" => $prefix."navigation-margin",
				"label" => __( 'Navigation top padding', 'lespaul_domain_panel' ),
				"desc" => __( 'Sets the top padding size for navigation wrapper ("-1" sets the default theme value). The bottom spacing of the navigation can be tweaked by setting website header height.', 'lespaul_domain_panel' ),
				"default" => -1,
				"min" => -1,
				"max" => 100,
				"step" => 1,
				"validate" => "int",
				"zero" => true
			),
			array(
				"type" => "slider",
				"id" => $prefix."navigation-item-padding",
				"label" => __( 'Navigation menu item padding', 'lespaul_domain_panel' ),
				"desc" => __( 'Sets the padding size for navigation menu item ("0" sets the default theme value). This setting will affect the submenu position.', 'lespaul_domain_panel' ),
				"default" => 0,
				"min" => 0,
				"max" => 60,
				"step" => 1,
				"validate" => "absint",
				"zero" => true
			),
			array(
				"type" => "hr",
			),

			array(
				"type" => "textarea",
				"id" => $prefix."right",
				"label" => __( 'Right header area text', 'lespaul_domain_panel' ),
				"desc" => __( 'Text in area right from logo in website header. You can use HTML and shortcodes here too.', 'lespaul_domain_panel' ) . '<br />' . __( 'Use (R) to display &reg; sign, (TM) for &trade;, YEAR for current year or SEARCH to display a search form.', 'lespaul_domain_panel' ),
				"default" => '',
				"cols" => 200,
				"rows" => 3,
				"empty" => true
			),
			array(
				"type" => "slider",
				"id" => $prefix."right-margin",
				"label" => __( 'Right header area padding', 'lespaul_domain_panel' ),
				"desc" => __( 'Sets the top padding size for textarea in website header ("-1" sets the default theme value)', 'lespaul_domain_panel' ),
				"default" => -1,
				"min" => -1,
				"max" => 100,
				"step" => 1,
				"validate" => "int",
				"zero" => true
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