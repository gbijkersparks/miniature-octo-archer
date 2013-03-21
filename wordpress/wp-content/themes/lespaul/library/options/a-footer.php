<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Footer
*****************************************************
*/

$prefix = 'footer-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "web-footer",
	"title" => __( 'Footer', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "web-footer",
		"list" => array(
			__( 'Website footer', 'lespaul_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "web-footer-1",
		"title" => __( 'Website footer', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Footer credits', 'lespaul_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "textarea",
				"id" => $prefix."credits",
				"label" => __( 'Credits (copyright) text', 'lespaul_domain_panel' ),
				"desc" => __( 'Copyright text at the bottom of the website. You can use YEAR for dynamic (always current) year.', 'lespaul_domain_panel' ),
				"default" => '[column size="3/4"]<p><strong>(C) Copyright YEAR ' . get_bloginfo( 'name' ) . '.</strong> WordPress theme by <a href="http://www.webmandesign.eu">WebManDesign.eu</a>.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer magna felis, laoreet sed pulvinar mattis, aliquet non mauris. Nulla facilisi. Fusce mattis congue vulputate. Curabitur eu libero eu urna varius egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>[/column]

[column size="1/4 last"]<p><em>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer magna felis, laoreet sed pulvinar mattis, aliquet non mauris.</em></p>[/column]',
				"editor" => true,
				"empty" => true
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