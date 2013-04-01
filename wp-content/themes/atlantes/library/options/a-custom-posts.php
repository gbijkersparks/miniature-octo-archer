<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Custom posts
*****************************************************
*/

$prefix = 'cp-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "custom-posts",
	"title" => __( 'Custom posts', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "custom-posts",
		"list" => array(
			__( 'Custom posts settings', 'lespaul_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "custom-posts-1",
		"title" => __( 'Custom posts settings', 'lespaul_domain_panel' )
	),
		array(
			"type" => "box",
			"content" => '<h4>' . __( 'In this section you can enable/disable several different custom post types or set their privilegues and permalink slugs, plus other cool options', 'lespaul_domain_panel' ) . '</h4><p>' . __( 'When setting permalinks, please use URL address allowed characters only.', 'lespaul_domain_panel' ) . '</p><p>' . __( 'For several custom posts you can enable revisions. These will allow you to restore previous content of the specific custom post, however, keep in mind that revisions take space in your database which is not desirable most of the time.', 'lespaul_domain_panel' ) . '</p>' . __( 'Content Modules, FAQ, Logos and Prices (and, if rich staff pages are disabled, also Staff) custom posts are being redirected to homepage when visited directly. There is no need to display them individually.', 'lespaul_domain_panel' )
		),

		//Modules
			array(
				"type" => "heading3",
				"content" => __( 'Content modules', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."modules-role-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "select",
					"id" => $prefix."role-modules",
					"label" => __( 'Content Modules', 'lespaul_domain_panel' ),
					"desc" => __( 'Choose how this post type should be treated', 'lespaul_domain_panel' ),
					"options" => array(
						'post' => __( 'As post', 'lespaul_domain_panel' ),
						'page' => __( 'As page', 'lespaul_domain_panel' ),
						),
					"default" => "page"
				),
				array(
					"type" => "text",
					"id" => $prefix."permalink-module",
					"label" => __( '"module" permalink', 'lespaul_domain_panel' ),
					"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'lespaul_domain_panel' ),
					"default" => "module"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."modules-revisions",
					"label" => __( 'Enable revisions', 'lespaul_domain_panel' ),
					"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'lespaul_domain_panel' )
				),
			array(
				"id" => $prefix."modules-role-container",
				"type" => "inside-wrapper-close"
			),

		//FAQ
			array(
				"type" => "heading3",
				"content" => __( '<abbr title="Frequently Asked Questions">FAQ</abbr>', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."faq-role-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "select",
					"id" => $prefix."role-faq",
					"label" => __( 'FAQ', 'lespaul_domain_panel' ),
					"desc" => __( 'Choose how this post type should be treated', 'lespaul_domain_panel' ),
					"options" => array(
						'disable' => __( 'Disable', 'lespaul_domain_panel' ),
						'post'    => __( 'As post', 'lespaul_domain_panel' ),
						'page'    => __( 'As page', 'lespaul_domain_panel' ),
						),
					"default" => "post"
				),
				array(
					"type" => "text",
					"id" => $prefix."permalink-faq",
					"label" => __( '"faq" permalink', 'lespaul_domain_panel' ),
					"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'lespaul_domain_panel' ),
					"default" => "faq"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."faq-revisions",
					"label" => __( 'Enable revisions', 'lespaul_domain_panel' ),
					"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'lespaul_domain_panel' )
				),
			array(
				"id" => $prefix."faq-role-container",
				"type" => "inside-wrapper-close"
			),

		//Logos
			array(
				"type" => "heading3",
				"content" => __( 'Logos (of clients, partners)', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."logos-role-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "select",
					"id" => $prefix."role-logos",
					"label" => __( 'Logos', 'lespaul_domain_panel' ),
					"desc" => __( 'Choose how this post type should be treated', 'lespaul_domain_panel' ),
					"options" => array(
						'disable' => __( 'Disable', 'lespaul_domain_panel' ),
						'post'    => __( 'As post', 'lespaul_domain_panel' ),
						'page'    => __( 'As page', 'lespaul_domain_panel' ),
						),
					"default" => "post"
				),
				array(
					"type" => "text",
					"id" => $prefix."permalink-logos",
					"label" => __( '"logo" permalink', 'lespaul_domain_panel' ),
					"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'lespaul_domain_panel' ),
					"default" => "logo"
				),
			array(
				"id" => $prefix."logos-role-container",
				"type" => "inside-wrapper-close"
			),

		//Prices
			array(
				"type" => "heading3",
				"content" => __( 'Prices (price tables)', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."prices-role-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "select",
					"id" => $prefix."role-prices",
					"label" => __( 'Prices', 'lespaul_domain_panel' ),
					"desc" => __( 'Choose how this post type should be treated', 'lespaul_domain_panel' ),
					"options" => array(
						'disable' => __( 'Disable', 'lespaul_domain_panel' ),
						'post'    => __( 'As post', 'lespaul_domain_panel' ),
						'page'    => __( 'As page', 'lespaul_domain_panel' ),
						),
					"default" => "page"
				),
				array(
					"type" => "text",
					"id" => $prefix."permalink-price",
					"label" => __( '"price" permalink', 'lespaul_domain_panel' ),
					"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'lespaul_domain_panel' ),
					"default" => "price"
				),
			array(
				"id" => $prefix."prices-role-container",
				"type" => "inside-wrapper-close"
			),

		//Projects
			array(
				"type" => "heading3",
				"content" => __( 'Projects (portfolio)', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."projects-role-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "select",
					"id" => $prefix."role-projects",
					"label" => __( 'Projects', 'lespaul_domain_panel' ),
					"desc" => __( 'Choose how this post type should be treated', 'lespaul_domain_panel' ),
					"options" => array(
						'disable' => __( 'Disable', 'lespaul_domain_panel' ),
						'post'    => __( 'As post', 'lespaul_domain_panel' ),
						'page'    => __( 'As page', 'lespaul_domain_panel' ),
						),
					"default" => "post"
				),
				array(
					"type" => "text",
					"id" => $prefix."permalink-project",
					"label" => __( '"project" permalink', 'lespaul_domain_panel' ),
					"desc" => __( 'Projects posts permalink base - you might need to change this for localization purposes', 'lespaul_domain_panel' ),
					"default" => "project"
				),
					array(
						"type" => "text",
						"id" => $prefix."permalink-project-category",
						"label" => __( 'Project "category" permalink', 'lespaul_domain_panel' ),
						"desc" => __( 'Project categories permalink base - you might need to change this for localization purposes', 'lespaul_domain_panel' ),
						"default" => "project/category"
					),
				array(
					"type" => "checkbox",
					"id" => $prefix."projects-revisions",
					"label" => __( 'Enable revisions', 'lespaul_domain_panel' ),
					"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'lespaul_domain_panel' )
				),
				array(
					"type" => "hr",
				),
				array(
					"type" => "select",
					"id" => $prefix."project-default-layout",
					"label" => __( 'Default project page layout', 'lespaul_domain_adm' ),
					"desc" => __( 'Sets the default layout for project pages', 'lespaul_domain_adm' ),
					"options" => $projectLayouts,
					"default" => "me-4",
					"optgroups" => true
				),
				array(
					"type" => "hr",
				),
				array(
					"type" => "additems",
					"id" => $prefix."projects-default-atts",
					"label" => __( 'Preset project attribute names', 'lespaul_domain_panel' ),
					"desc" => __( 'Streamline your project editing with preset project attribute names (you will just need to add a value on project edit screen). <br />You will still be able to remove or add new attributes per project basis.', 'lespaul_domain_panel' ),
					"default" => ''
				),
			array(
				"id" => $prefix."projects-role-container",
				"type" => "inside-wrapper-close"
			),

		//Staff
			array(
				"type" => "heading3",
				"content" => __( 'Staff', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."staff-role-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "select",
					"id" => $prefix."role-staff",
					"label" => __( 'Staff', 'lespaul_domain_panel' ),
					"desc" => __( 'Choose how this post type should be treated', 'lespaul_domain_panel' ),
					"options" => array(
						'disable' => __( 'Disable', 'lespaul_domain_panel' ),
						'post'    => __( 'As post', 'lespaul_domain_panel' ),
						'page'    => __( 'As page', 'lespaul_domain_panel' ),
						),
					"default" => "page"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."staff-rich",
					"label" => __( 'Rich staff members profiles', 'lespaul_domain_panel' ),
					"desc" => __( 'By default whole staff member information is displayed in staff list (Staff shortcode). This option will, however, enable to display only short excerpt in the Staff shortcode and the whole information on a dedicated staff member page.', 'lespaul_domain_panel' )
				),
				array(
					"type" => "space"
				),
				array(
					"type" => "text",
					"id" => $prefix."permalink-staff",
					"label" => __( '"staff" permalink', 'lespaul_domain_panel' ),
					"desc" => __( 'If rich Staff posts used, you might need to change their permalink base for localization purposes', 'lespaul_domain_panel' ),
					"default" => "staff"
				),
					array(
						"type" => "text",
						"id" => $prefix."permalink-staff-department",
						"label" => __( 'Staff "department" permalink', 'lespaul_domain_panel' ),
						"desc" => __( 'Staff departments permalink base - you might need to change this for localization purposes', 'lespaul_domain_panel' ),
						"default" => "staff/department"
					),
				array(
					"type" => "checkbox",
					"id" => $prefix."staff-revisions",
					"label" => __( 'Enable revisions', 'lespaul_domain_panel' ),
					"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'lespaul_domain_panel' )
				),
			array(
				"id" => $prefix."staff-role-container",
				"type" => "inside-wrapper-close"
			),
	array(
		"type" => "sub-section-close"
	),

array(
	"type" => "section-close"
)

);

?>