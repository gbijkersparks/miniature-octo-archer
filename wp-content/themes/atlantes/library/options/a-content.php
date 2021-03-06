<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Content area
*****************************************************
*/

$prefix = 'contents-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "web-content",
	"title" => __( 'Content', 'atlantes_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "web-content",
		"list" => array(
			__( 'Website content area', 'atlantes_domain_panel' ),
			__( 'Page templates', 'atlantes_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "web-content-1",
		"title" => __( 'Website content area', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Sidebar', 'atlantes_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "select",
				"id" => $prefix."sidebar-width",
				"label" => __( 'Sidebar width', 'atlantes_domain_panel' ),
				"desc" => __( 'Sets the sidebar width ratio against the website content width', 'atlantes_domain_panel' ),
				"options" => array(
						" three pane; nine pane" => __( '1/4 sidebar', 'atlantes_domain_panel' ),
						" four pane; eight pane" => __( '1/3 sidebar', 'atlantes_domain_panel' ),
						" golden-narrow pane; golden-wide pane" => __( 'Golden ratio', 'atlantes_domain_panel' ),
					),
				"default" => WM_SIDEBAR_WIDTH
			),
			array(
				"type" => "select",
				"id" => $prefix."sidebar-position",
				"label" => __( 'Default sidebar position', 'atlantes_domain_panel' ),
				"desc" => __( 'Sets the default sidebar position', 'atlantes_domain_panel' ),
				"options" => array(
						"right" => __( 'Right', 'atlantes_domain_panel' ),
						"left"  => __( 'Left', 'atlantes_domain_panel' ),
					),
				"default" => WM_SIDEBAR_DEFAULT_POSITION
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Page excerpt', 'atlantes_domain_panel' ),
		),
			array(
				"type" => "select",
				"id" => $prefix."page-excerpt",
				"label" => __( 'Page excerpt', 'atlantes_domain_panel' ),
				"desc" => __( 'You can add additional content area to pages and also set where this content should be displayed', 'atlantes_domain_panel' ),
				"options" => array(
						''   => __( 'Disable page excerpt', 'atlantes_domain_panel' ),
						'25' => __( 'Order: slider, main heading, page excerpt', 'atlantes_domain_panel' ),
						'15' => __( 'Order: slider, page excerpt, main heading', 'atlantes_domain_panel' ),
						'5'  => __( 'Order: page excerpt, slider, main heading', 'atlantes_domain_panel' ),
					),
				"default" => ""
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Project page', 'atlantes_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-related-projects",
				"label" => __( 'Disable related projects', 'atlantes_domain_panel' ),
				"desc" => __( 'Globaly disables related projects displayed at the bottom of project pages', 'atlantes_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "text",
				"id" => $prefix."related-projects-title",
				"label" => __( 'Related projects section title', 'atlantes_domain_panel' ),
				"desc" => __( 'Customize the "Related projects" title if the section is enabled', 'atlantes_domain_panel' )
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Comments', 'atlantes_domain_panel' ),
		),
			array(
				"type" => "warning",
				"content" => __( 'Please note that these settings will affect pages/posts/projects you create from now on. If there are comments already active for the existing pages/posts/projects, you will need to disable them manually. This is default WordPress behaviour.', 'atlantes_domain_panel' )
			),
			array(
				"type" => "box",
				"content" => '<p><strong>' . __( 'To disable comments manually for each already created page/post/project you have 2 options:', 'atlantes_domain_panel' ) . '</strong></p><ol><li>' . __( 'On page/posts/projects list table in WordPress admin select all the affected pages/posts/projects and choose "Edit" from "Bulk action" dropdown above the table, and press [Apply] button. Then just disable the comments option. This will disable the comments for already created pages/posts/projects in a batch.', 'atlantes_domain_panel' ) . '</li><li>' . __( 'On page/post/project edit screen make sure the "Discussion" metabox is enabled in "Screen Options" (in upper right corner of the screen). Then just uncheck the checkboxes in that metabox.', 'atlantes_domain_panel' ) . '</li></ol>'
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."page-comments",
				"label" => __( 'Disallow page comments', 'atlantes_domain_panel' ),
				"desc" => __( 'Disables page comments and pingbacks only (even if global comments are enabled)', 'atlantes_domain_panel' ),
				"default" => "true"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."post-comments",
				"label" => __( 'Disallow post comments', 'atlantes_domain_panel' ),
				"desc" => __( 'Disables post comments and pingbacks only (even if global comments are enabled)', 'atlantes_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."project-comments",
				"label" => __( 'Disallow project comments', 'atlantes_domain_panel' ),
				"desc" => __( 'Disables project comments and pingbacks only (even if global comments are enabled)', 'atlantes_domain_panel' ),
				"default" => "true"
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "web-content-2",
		"title" => __( 'Page templates', 'atlantes_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Disable unnecessary page templates', 'atlantes_domain_panel' ),
			"class" => "first"
		)
	);
	if ( function_exists( 'wp_get_theme' ) ) { //WP3.3 and below cannot get the array of page templates - it is not even in database
		foreach ( $pageTemplates as $file => $name ) {
			$id = sanitize_title( str_replace( '/', '-', $file ) );
			if ( ! ( 'page-template-portfolio-php' === $id && 'disable' === wm_option( 'cp-role-projects' ) ) )
				array_push( $options,
					array(
						"type"  => "checkbox",
						"id"    => $prefix.$id,
						"label" => sprintf( __( '%s template', 'atlantes_domain_panel' ), $name ),
						"desc"  => __( 'Hides this page template from template dropdown list', 'atlantes_domain_panel' )
					),
					array(
						"type" => "space"
					)
				);
		}
	} else {
		array_push( $options,
				array(
					"type" => "warning",
					"content" => __( 'Sorry this function is available only for WordPress version 3.4 and up.', 'atlantes_domain_panel' )
				)
			);
	}
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