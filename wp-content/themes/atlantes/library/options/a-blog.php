<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - Blog
*****************************************************
*/

$prefix = 'blog-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "blog",
	"title" => __( 'Blog', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "blog",
		"list" => array(
			__( 'Basics', 'lespaul_domain_panel' ),
			__( 'Post formats', 'lespaul_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "blog-1",
		"title" => __( 'Basics', 'lespaul_domain_panel' )
	),
		array(
			"type" => "slider",
			"id" => $prefix."blog-excerpt-length",
			"label" => __( 'Excerpt length', 'lespaul_domain_panel' ),
			"desc" => __( 'Sets the default blog list excerpt length in words', 'lespaul_domain_panel' ),
			"default" => 40,
			"min" => 10,
			"max" => 70,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Blog entry meta information', 'lespaul_domain_panel' )
		),
			array(
				"type" => "paragraph",
				"content" => __( 'Choose the post meta information to display. By default all the information below are displayed.', 'lespaul_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-featured-image",
				"label" => __( 'Disable featured image in a single post view', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides featured image when displaying single post. This can be disabled also per post basis.', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-date",
				"label" => __( 'Disable publish date', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides post publish date and time', 'lespaul_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-author",
				"label" => __( 'Disable author name', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides post author name', 'lespaul_domain_panel' ) . '<br />' . __( 'Keep the author name when taking advantage of Google Authorship!', 'lespaul_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-cats",
				"label" => __( 'Disable categories', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides post categories links', 'lespaul_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-comments-count",
				"label" => __( 'Disable comments count', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides post comments count link', 'lespaul_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-permalink",
				"label" => __( 'Disable post permalink icon', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides post permalink icon', 'lespaul_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-tags",
				"label" => __( 'Disable tags', 'lespaul_domain_panel' ),
				"desc" => __( 'Hides post tags list on single post page', 'lespaul_domain_panel' )
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "checkbox",
			"id" => $prefix."archive-no-sidebar",
			"label" => __( 'Disable sidebar on archive pages', 'lespaul_domain_panel' ),
			"desc" => __( 'Removes sidebar from archive posts list pages (such as category, tag, author or date archive page)', 'lespaul_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Author biography', 'lespaul_domain_panel' )
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."disable-bio",
			"label" => __( 'Disable author biography altogether', 'lespaul_domain_panel' ),
			"desc" => __( 'Hides author information below all posts (otherwise the information is displayed, but only if author entered Biographical Info in his/her user profile). You can hide this information also on per post basis (see corresponding post settings).', 'lespaul_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "slider",
			"id" => $prefix."author-posts",
			"label" => __( 'Display author posts in bio', 'lespaul_domain_panel' ),
			"desc" => __( 'Set the number of author posts displayed in author biography at the end of single post page', 'lespaul_domain_panel' ),
			"default" => 0,
			"min" => 0,
			"max" => 10,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "select",
			"id" => $prefix."author-posts-order",
			"label" => __( 'Author posts order', 'lespaul_domain_panel' ),
			"desc" => __( 'If author posts in bio are displayed, choose their order method here', 'lespaul_domain_panel' ),
			"options" => array(
				'rand' => __( 'Random', 'lespaul_domain_panel' ),
				'date' => __( 'Most recent', 'lespaul_domain_panel' ),
				),
		),
		array(
			"type" => "info",
			"content" => __( 'Using the <code>&lt!--more--></code> tag in author biographical info (set up on WordPress user account page) you can control the portion of text to be displayed in author bio box on single post pages. The whole bio text will be displayed on author archive pages.', 'lespaul_domain_panel' ),
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "blog-2",
		"title" => __( 'Post formats', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Disable unnecessary post formats', 'lespaul_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-format-audio",
				"label" => __( 'Disable audio posts', 'lespaul_domain_panel' ),
				"desc" => __( 'Disables this post format', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-format-gallery",
				"label" => __( 'Disable gallery posts', 'lespaul_domain_panel' ),
				"desc" => __( 'Disables this post format', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-format-link",
				"label" => __( 'Disable link posts', 'lespaul_domain_panel' ),
				"desc" => __( 'Disables this post format', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-format-quote",
				"label" => __( 'Disable quote posts', 'lespaul_domain_panel' ),
				"desc" => __( 'Disables this post format', 'lespaul_domain_panel' ) . '<br />' . __( 'However, keep in mind that Quote post format is used to populate the Testimonials shortcode!', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-format-status",
				"label" => __( 'Disable status posts', 'lespaul_domain_panel' ),
				"desc" => __( 'Disables this post format', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-format-video",
				"label" => __( 'Disable video posts', 'lespaul_domain_panel' ),
				"desc" => __( 'Disables this post format', 'lespaul_domain_panel' )
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