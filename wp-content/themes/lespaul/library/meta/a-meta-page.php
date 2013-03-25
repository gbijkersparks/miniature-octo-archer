<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Page meta boxes
*****************************************************
*/

/*
* Meta settings options for pages
*
* Has to be set up as function to pass the custom taxonomies array.
* Custom taxonomies are hooked onto 'init' action which is executed after the theme's functions file has been included.
* So if you're looking for taxonomy terms directly in the functions file, you're doing so before they've actually been registered.
* Meta box generator, which uses these settings options, is hooked onto 'add_meta_boxes' which is executed after 'init' action.
*/
if ( ! function_exists( 'wm_meta_page_options' ) ) {
	function wm_meta_page_options() {
		global $post, $portfolioLayout, $sidebarPosition, $websiteLayoutEmpty, $current_screen;

		$skin            = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
		$postId          = ( $post ) ? ( $post->ID ) : ( null );
		$prefix          = '';
		$prefixBg        = 'background-';
		$prefixBgHeading = 'heading-background-';
		$fontFile        = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
		$fontIcons       = wm_fontello_classes( $fontFile );

		//Get icons
		$menuIcons = array();
		$menuIcons[''] = __( '- select icon -', 'lespaul_domain_adm' );
		foreach ( $fontIcons as $icon ) {
			$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
		}

		$widgetsButtons = ( current_user_can( 'switch_themes' ) ) ? ( '<a class="button confirm" href="' . get_admin_url() . 'widgets.php">' . __( 'Manage widget areas', 'lespaul_domain_adm' ) . '</a> <a class="button confirm" href="' . get_admin_url() . 'admin.php?page=' . WM_THEME_SHORTNAME . '-options">' . __( 'Create new widget areas', 'lespaul_domain_adm' ) . '</a>' ) : ( '' );


		//Page settings
		$metaPageOptions = $availableSliders = array();

		$availableSliders['none']     = __( '- no slider -', 'lespaul_domain_adm' );
		$availableSliders['video']    = __( 'Video', 'lespaul_domain_adm' );
		$availableSliders['static']   = __( 'Static featured image', 'lespaul_domain_adm' );
		if ( ! wm_option( 'slider-custom-remove' ) )
			$availableSliders['custom'] = __( 'Custom slider', 'lespaul_domain_adm' );



		//Redirect settings
		if ( ! wm_option( 'contents-page-template-redirect-php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "redirect-section",
					"title" => __( 'Redirect', 'lespaul_domain_adm' ),
					"onlyfor" => array( 'page-template/redirect.php' )
				),
					array(
						"type" => "box",
						"content" => __( 'No page content will be displayed. The page will be automatically redirected to URL set below.', 'lespaul_domain_adm' ),
					),

					array(
						"type" => "text",
						"id" => $prefix."redirect-link",
						"label" => __( 'Redirect link', 'lespaul_domain_adm' ),
						"desc" => __( 'URL where the page will be automatically redirected to', 'lespaul_domain_adm' ),
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."redirect-page",
						"label" => __( '...or choose a page', 'lespaul_domain_adm' ),
						"desc" => __( 'Select a page to redirect to', 'lespaul_domain_adm' ),
						"options" => wm_pages(),
					),
					array(
						"type" => "select",
						"id" => $prefix."redirect-status",
						"label" => __( 'Redirect status', 'lespaul_domain_adm' ),
						"desc" => __( 'Select which redirect method to use', 'lespaul_domain_adm' ),
						"options" => array(
							'301' => __( 'Permanent redirect (301)', 'lespaul_domain_adm' ),
							'302' => __( 'Temporary redirect (302)', 'lespaul_domain_adm' ),
							)
					),
				array(
					"type" => "section-close"
				)
			);



		//Map settings
		if ( ! wm_option( 'contents-page-template-map-php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "map-section",
					"title" => __( 'Map', 'lespaul_domain_adm' ),
					"onlyfor" => array( 'page-template/map.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This page will display a map', 'lespaul_domain_adm' ) . '</h4>
							' . sprintf( __( 'View map page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-map.png" class="fancybox"' ),
					),

					array(
						"type" => "additems",
						"id" => $prefix."map-gps",
						"label" => __( 'Map locations GPS and info', 'lespaul_domain_adm' ),
						"desc" => __( 'Insert the GPS geographic coordinates into first field (latitude and longitude separated with comma "40.123, -73.123") and location info into second field (you can use HTML) The location info will be displayed after clicking the location marker.<br />The first location coordinates will be used to center the map. If you do not want to display the map centering marker, insert "-" (minus sign) into first location info field.', 'lespaul_domain_adm' ) . '<br /><a href="http://webmandesign.eu/getgps/" class="fancybox iframe">' . __( 'You can use external app to find geographic coordinates.', 'lespaul_domain_adm' ) . '</a>',
						"field-labels" => array( __( 'Location GPS', 'lespaul_domain_adm' ), __( 'Location info text', 'lespaul_domain_adm' ) ),
						"field" => "attributes"
					),

					array(
						"type" => "checkbox",
						"id" => $prefix."map-center",
						"label" => __( 'Always center map on location', 'lespaul_domain_adm' ),
						"desc" => __( 'Map will always center the first GPS location even after dragging', 'lespaul_domain_adm' ),
						"value" => 1
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."map-style",
						"label" => __( 'Use default map styling', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets default Google Map styling', 'lespaul_domain_adm' ) . '<br /><br />',
						"value" => "default"
					),
					array(
						"type" => "slider",
						"id" => $prefix."map-zoom",
						"label" => __( 'Map zoom', 'lespaul_domain_adm' ),
						"desc" => __( 'Map zoom on location', 'lespaul_domain_adm' ),
						"default" => 10,
						"min" => 1,
						"max" => 19,
						"step" => 1,
						"validate" => "absint"
					),
					array(
						"type" => "slider",
						"id" => $prefix."map-height",
						"label" => __( 'Map height', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets map height in pixels', 'lespaul_domain_adm' ),
						"default" => 300,
						"min" => 100,
						"max" => 1000,
						"step" => 10,
						"validate" => "absint"
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."map-top",
						"label" => __( 'Map beneath header', 'lespaul_domain_adm' ),
						"desc" => __( 'You can move map beneath the website header just by selecting the option below', 'lespaul_domain_adm' ),
					),
				array(
					"type" => "section-close"
				)
			);



		//Blog section
		if ( ! wm_option( 'contents-home-php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "blog-section",
					"title" => __( 'Blog', 'lespaul_domain_adm' ),
					"onlyfor" => array( 'blog-page', 'home.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This page will display blog posts', 'lespaul_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View blog page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-blog.png" class="fancybox"' ) . ' ' . __( 'The actual content of the page will be displayed above blog posts list. You can set blog posts list options below.', 'lespaul_domain_adm' ) . '</p>
							<a class="button-primary confirm" href="' . get_admin_url() . 'post-new.php">' . __( 'Add new post', 'lespaul_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit.php">' . __( 'Edit posts', 'lespaul_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">' . __( 'Edit post categories', 'lespaul_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=post_tag">' . __( 'Edit post tags', 'lespaul_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "slider",
						"id" => $prefix."blog-posts-count",
						"label" => __( 'Number of posts to display', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the number of posts listed on this page only. Other archives will display posts according to WordPress settings. <br />Value of "-1" will display all posts. When you set the value of "0", WordPress settings are applied.', 'lespaul_domain_adm' ),
						"default" => get_option( 'posts_per_page' ),
						"min" => -1,
						"max" => 25,
						"step" => 1,
						"validate" => "int"
					),
					array(
						"type" => "hr"
					),

					array(
						"type" => "additems",
						"id" => $prefix."blog-cats",
						"label" => __( 'Posts source', 'lespaul_domain_adm' ),
						"desc" => __( 'You can choose to display all posts or posts from specific categories. <br />Press [+] button to add a category and select the category name from dropdown list.', 'lespaul_domain_adm' ),
						"default" => "0",
						"field" => "select",
						"options" => wm_tax_array()
					),
					array(
						"conditional" => array(
							"field" => $prefix."blog-cats",
							"value" => "",
							"type" => "not"
							),
						"type" => "radio",
						"id" => $prefix."blog-cats-action",
						"label" => __( 'Exclude / use categories', 'lespaul_domain_adm' ),
						"desc" => __( 'Choose whether above categories should be excluded or used (does not apply on "All posts")', 'lespaul_domain_adm' ),
						"options" => array(
							'category__in'     => __( 'Posts just from these categories', 'lespaul_domain_adm' ),
							'category__not_in' => __( 'Exclude posts from these categories', 'lespaul_domain_adm' )
							),
						"default" => "category__in"
					),
					array(
						"type" => "hr"
					),

					array(
						"type" => "select",
						"id" => $prefix."blog-layout",
						"label" => __( 'Blog layout', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the blog posts list layout', 'lespaul_domain_adm' ),
						"options" => array(
								""                   => __( 'Media on top', 'lespaul_domain_adm' ),
								" media-left"        => __( 'Media left', 'lespaul_domain_adm' ),
								" media-right"       => __( 'Media right', 'lespaul_domain_adm' ),
								" zigzag"            => __( 'Zigzag', 'lespaul_domain_adm' ),
								" masonry-container" => __( 'Masonry (Pinterest style)', 'lespaul_domain_adm' ),
							),
						"default" => ""
					),
					array(
						"conditional" => array(
							"field" => $prefix."blog-layout",
							"value" => " masonry-container",
							),
						"type" => "slider",
						"id" => $prefix."blog-masonry-size",
						"label" => __( 'Number of columns', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the number of post columns for masonry blog layout', 'lespaul_domain_adm' ),
						"default" => 3,
						"min" => 2,
						"max" => 4,
						"step" => 1,
						"validate" => "absint"
					),
				array(
					"type" => "section-close"
				)
			);



		//Portfolio settings
		if ( 'disable' != wm_option( 'cp-role-projects' ) && ! wm_option( 'contents-page-template-portfolio-php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "portfolio-section",
					"title" => __( 'Portfolio', 'lespaul_domain_adm' ),
					"onlyfor" => array( 'page-template/portfolio.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This page will display portfolio of your projects', 'lespaul_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View portfolio page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-portfolio.png" class="fancybox"' ) . ' ' . __( 'The actual content of the page will be displayed above projects list. You can set projects list options below.', 'lespaul_domain_adm' ) . '</p>
							<a class="button-primary confirm" href="' . get_admin_url() . 'post-new.php?post_type=wm_projects">' . __( 'Add new project', 'lespaul_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit.php?post_type=wm_projects">' . __( 'Edit projects', 'lespaul_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=project-category&amp;post_type=wm_projects">' . __( 'Edit project categories', 'lespaul_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "select",
						"id" => $prefix."portfolio-category",
						"label" => __( 'Projects main category', 'lespaul_domain_adm' ),
						"desc" => __( 'Select whether to display all projects or just the ones from specific main category (only first level categories can be chosen)', 'lespaul_domain_adm' ),
						"options" => wm_tax_array( array(
								'allCountPost' => 'wm_projects',
								'allText'      => __( 'All projects', 'lespaul_domain_adm' ),
								'parentsOnly'  => true,
								'tax'          => 'project-category',
							) ),
						"default" => ""
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."portfolio-filter",
						"label" => __( 'Display filter', 'lespaul_domain_adm' ),
						"desc" => __( 'Use animated filtering on the projects list', 'lespaul_domain_adm' )
					),
					array(
						"type" => "space",
					),
					array(
						"type" => "slider",
						"id" => $prefix."portfolio-count",
						"label" => __( 'Number of projects', 'lespaul_domain_adm' ),
						"desc" => __( 'This will affect the number of projects listed on the page. Set "-1" to display all items, set "0" to use default WordPress settings.', 'lespaul_domain_adm' ),
						"default" => get_option( 'posts_per_page' ),
						"min" => -1,
						"max" => 32,
						"step" => 1,
						"validate" => "int"
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."portfolio-pagination",
						"label" => __( 'Display pagination', 'lespaul_domain_adm' ),
						"desc" => __( 'By default the pagination on projects list is disabled. You can enable it with this setting.', 'lespaul_domain_adm' )
					),
					array(
						"type" => "space",
					),
					array(
						"type" => "layouts",
						"id" => $prefix."portfolio-columns",
						"label" => __( 'Layout', 'lespaul_domain_adm' ),
						"desc" => __( 'Choose how many columns should the projects list be split to', 'lespaul_domain_adm' ),
						"options" => $portfolioLayout,
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."portfolio-order",
						"label" => __( 'List ordering', 'lespaul_domain_adm' ),
						"desc" => __( 'Choose how projects should be ordered', 'lespaul_domain_adm' ),
						"options" => array(
							'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
							'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
							'name'   => __( 'Alphabetically', 'lespaul_domain_adm' ),
							'random' => __( 'Random selection', 'lespaul_domain_adm' )
							)
					),
				array(
					"type" => "section-close"
				)
			);



		//Landing page settings
		if ( ! wm_option( 'contents-page-template-landing-php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "landing-section",
					"title" => __( 'Landing page', 'lespaul_domain_adm' ),
					"onlyfor" => array( 'page-template/landing.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This is a special landing page layout', 'lespaul_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View landing page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-landing.png" class="fancybox"' ) . ' ' . __( 'Please note that a new navigation menu location was created for this page. This allows you to display diferent menu on this page as oppose to the rest of the website. If no menu assigned, only logo and header text area (set below) will be displayed in header.', 'lespaul_domain_adm' ) . '</p>
							<a class="button confirm" href="' . get_admin_url() . 'nav-menus.php">' . __( 'Assign a menu to', 'lespaul_domain_adm' ) . ' <strong>"' . get_the_title() . '" ' . __( 'page navigation', 'lespaul_domain_adm' ) . '</strong></a>
							',
					),

					array(
						"type" => "textarea",
						"id" => $prefix."landing-header-right",
						"label" => __( 'Header text', 'lespaul_domain_adm' ),
						"desc" => __( 'Text in area right from logo in website header. You can use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade;, YEAR for current year or SEARCH to display a search form.', 'lespaul_domain_adm' ),
						"default" => wm_option( 'header-right' ),
						"cols" => 60,
						"validate" => "lineBreakHTML",
						"rows" => 5
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."landing-above-footer-widgets",
						"label" => __( 'Above footer widgets area', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets above footer widgets area', 'lespaul_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."landing-footer-widgets",
						"label" => __( 'Footer widgets area', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets footer widgets area', 'lespaul_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."landing-credits",
						"label" => __( 'Credits / copyright text', 'lespaul_domain_adm' ),
						"desc" => __( 'Leave empty to display default text. Use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade; or YEAR for current year.', 'lespaul_domain_adm' ),
						"default" => "",
						"cols" => 60,
						"validate" => "lineBreakHTML",
						"rows" => 3
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."landing-tracking",
						"label" => __( 'Custom tracking code', 'lespaul_domain_adm' ),
						"desc" => __( 'Google Analytics custom tracking code (the default one will be replaced) - include <code>&lt;script&gt;</code> HTML tag', 'lespaul_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakSpace",
						"class" => "code",
						"cols" => 60,
						"rows" => 3
					),
				array(
					"type" => "section-close"
				)
			);



		//Under construction settings
		if ( ! wm_option( 'contents-page-template-construction-php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "construction-section",
					"title" => __( 'Under construction', 'lespaul_domain_adm' ),
					"onlyfor" => array( 'page-template/construction.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'Countdown timer will be displayed on this page', 'lespaul_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View under construction page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-under-construction.png" class="fancybox"' ) . ' ' . __( 'The page displays information of when your website is about to be lounched. You can set the date, when it is planned to go live and the countdown timer will be displayed.', 'lespaul_domain_adm' ) . '</p>
							<a class="button-primary confirm" href="' . get_admin_url() . 'options-reading.php">' . __( 'Set this page as homepage', 'lespaul_domain_adm' ) . '</a> (' . __( 'do not forget to <strong>save/update the page first</strong>', 'lespaul_domain_adm' ) . ')
							',
					),
					array(
						"type" => "datepicker",
						"id" => $prefix."construction-date",
						"label" => __( 'Date', 'lespaul_domain_adm' ),
						"desc" => __( 'Set the date when the website will be ready', 'lespaul_domain_adm' ),
						"class" => "future"
					),
					array(
						"type" => "select",
						"id" => $prefix."construction-time",
						"label" => __( 'Optional time', 'lespaul_domain_adm' ),
						"desc" => __( 'Set the exact hour when the website will be ready', 'lespaul_domain_adm' ),
						"options" => array(
								"00:00" => "00:00",
								"01:00" => "01:00",
								"02:00" => "02:00",
								"03:00" => "03:00",
								"04:00" => "04:00",
								"05:00" => "05:00",
								"06:00" => "06:00",
								"07:00" => "07:00",
								"08:00" => "08:00",
								"09:00" => "09:00",
								"10:00" => "10:00",
								"11:00" => "11:00",
								"12:00" => "12:00",
								"13:00" => "13:00",
								"14:00" => "14:00",
								"15:00" => "15:00",
								"16:00" => "16:00",
								"17:00" => "17:00",
								"18:00" => "18:00",
								"19:00" => "19:00",
								"20:00" => "20:00",
								"21:00" => "21:00",
								"22:00" => "22:00",
								"23:00" => "23:00"
							),
						"default" => "00:00"
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."construction-header-right",
						"label" => __( 'Header text', 'lespaul_domain_adm' ),
						"desc" => __( 'Text in area right from logo in website header. You can use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade;, YEAR for current year or SEARCH to display a search form.', 'lespaul_domain_adm' ),
						"default" => wm_option( 'header-right' ),
						"validate" => "lineBreakHTML",
						"cols" => 60,
						"rows" => 5
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."construction-timer-widgets",
						"label" => __( 'Below timer widgets area', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the widget area below countdown timer', 'lespaul_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."construction-credits",
						"label" => __( 'Credits / copyright text', 'lespaul_domain_adm' ),
						"desc" => __( 'Leave empty to display default text. Use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade; or YEAR for current year.', 'lespaul_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"cols" => 60,
						"rows" => 3
					),
				array(
					"type" => "section-close"
				)
			);



		array_push( $metaPageOptions,

			//General settings
			array(
				"type" => "section-open",
				"section-id" => "general-section",
				"title" => __( 'General', 'lespaul_domain_adm' ),
				"exclude" => array( 'page-template/construction.php', 'page-template/redirect.php' )
			),
				//default page tpl
					array(
						"id" => "pagetemplate-default",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "box",
							"content" => sprintf( __( 'View default page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-default.png" class="fancybox"' )
						),
					array(
						"conditional" => array(
							"field" => "page_template",
							"value" => "default"
							),
						"id" => "pagetemplate-default",
						"type" => "inside-wrapper-close"
					),

				//sections page tpl
					array(
						"id" => "pagetemplate-sections",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "box",
							"content" => sprintf( __( 'View sections page <a %1s>layout structure</a>. Please note that you have to use the %2s shortcode to wrap content on this page template. Otherwise the page layout may be broken.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-sections.png" class="fancybox"', '<code>[section class="TEXT"&#93; TEXT [/section&#93;</code>' )
						),
					array(
						"conditional" => array(
							"field" => "page_template",
							"value" => "page-template/sections.php"
							),
						"id" => "pagetemplate-sections",
						"type" => "inside-wrapper-close"
					),

				//sitemap page tpl
					array(
						"id" => "pagetemplate-sitemap",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "box",
							"content" => sprintf( __( 'View sitemap page <a %s>layout structure</a>.', 'lespaul_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-sitemap.png" class="fancybox"' )
						),
					array(
						"conditional" => array(
							"field" => "page_template",
							"value" => "page-template/sitemap.php"
							),
						"id" => "pagetemplate-sitemap",
						"type" => "inside-wrapper-close"
					),

				array(
					"type" => "checkbox",
					"id" => $prefix."no-heading",
					"label" => __( 'Disable main heading', 'lespaul_domain_adm' ),
					"desc" => __( 'Hides post/page main heading - the title', 'lespaul_domain_adm' ),
					"value" => "true"
				),
					array(
						"type" => "space"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."subheading",
						"label" => __( 'Subtitle', 'lespaul_domain_adm' ),
						"desc" => __( 'If defined, the specially styled subtitle will be displayed', 'lespaul_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"rows" => 2,
						"cols" => 57
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-alignment",
						"label" => __( 'Main heading alignment', 'lespaul_domain_adm' ),
						"desc" => __( 'Set the text alignment in main heading area', 'lespaul_domain_adm' ),
						"options" => array(
								""       => __( 'Default', 'lespaul_domain_adm' ),
								"left"   => __( 'Left', 'lespaul_domain_adm' ),
								"center" => __( 'Center', 'lespaul_domain_adm' ),
								"right"  => __( 'Right', 'lespaul_domain_adm' ),
							),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-icon",
						"label" => __( 'Main heading icon', 'lespaul_domain_adm' ),
						"desc" => __( 'Select an icon to display in main heading area', 'lespaul_domain_adm' ),
						"options" => $menuIcons,
						"icons" => true
					),
				array(
					"type" => "hr"
				),

				array(
					"type" => "checkbox",
					"id" => $prefix."toggle-header-position",
					"label" => __( 'Toggle header position', 'lespaul_domain_adm' ),
					"desc" => __( 'Sticks the header to the top when it is not and vice versa (sticky header is not used when slider or map is beneath it)', 'lespaul_domain_adm' ),
					"value" => "true"
				),

				array(
					"id" => $prefix."general-settings-not-on-landing",
					"type" => "inside-wrapper-open"
				)
			);

			if ( is_active_sidebar( 'top-bar-widgets' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-top-bar",
						"label" => __( 'Disable top bar', 'lespaul_domain_adm' ),
						"desc" => __( 'Disables top bar widget area on this page', 'lespaul_domain_adm' ),
						"value" => "true"
					)
				);

			if ( 'none' != wm_option( 'general-breadcrumbs' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."breadcrumbs",
						"label" => __( 'Disable breadcrumbs', 'lespaul_domain_adm' ),
						"desc" => __( 'Disables breadcrumbs navigation on this page', 'lespaul_domain_adm' ),
						"value" => "true"
					)
				);

			if ( is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-above-footer-widgets",
						"label" => __( 'Disable widgets above footer', 'lespaul_domain_adm' ),
						"desc" => __( 'Hides widget area above footer', 'lespaul_domain_adm' ),
						"value" => "true"
					)
				);

			array_push( $metaPageOptions,
					array(
						"type" => "hr"
					),
					array(
						"type" => "checkbox",
						"id" => "attachments-list",
						"label" => __( 'Display post attachments list', 'lespaul_domain_adm' ),
						"desc" => __( 'Displays links to download all post attachments except images', 'lespaul_domain_adm' ),
						"value" => "true"
					),
				array(
					"conditional" => array(
						"field" => "page_template",
						"value" => "page-template/landing.php",
						"type" => "not"
						),
					"id" => $prefix."general-settings-not-on-landing",
					"type" => "inside-wrapper-close"
				),
				array(
					"type" => "hr"
				),

				array(
					"type" => "layouts",
					"id" => $prefix."boxed",
					"label" => __( 'Page layout', 'lespaul_domain_adm' ),
					"desc" => __( 'Choose layout for this page', 'lespaul_domain_adm' ),
					"options" => $websiteLayoutEmpty
				)
			);

			if ( wm_option( 'access-client-area' ) )
			array_push( $metaPageOptions,
				array(
					"id" => $prefix."not-on-landing",
					"type" => "inside-wrapper-open"
				),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."restrict-access",
						"label" => __( 'Restrict access', 'lespaul_domain_adm' ),
						"desc" => __( 'Restricts access to certain users or user groups', 'lespaul_domain_adm' ),
						"options" => wm_users(),
						"optgroups" => true
					),
				array(
					"conditional" => array(
						"field" => "page_template",
						"value" => "page-template/map.php,page-template/portfolio.php,page-template/sections.php,page-template/sitemap.php,default",
						),
					"id" => $prefix."not-on-landing",
					"type" => "inside-wrapper-close"
				)
			);

			array_push( $metaPageOptions,
			array(
				"type" => "section-close"
			),



			//Slider settings
			array(
				"type" => "section-open",
				"section-id" => "slider-section",
				"title" => __( 'Slider', 'lespaul_domain_adm' ),
				"exclude" => array( 'page-template/redirect.php', 'page-template/map.php' )
			),
				array(
					"type" => "box",
					"content" => '
						<h4>' . __( 'Choose what slider to display on this page', 'lespaul_domain_adm' ) . '</h4>
						' . __( 'You can display in a slider area any slider (plugin) that supports insertion by shortcode.', 'lespaul_domain_adm' ),
				),

				array(
					"type" => "select",
					"id" => $prefix."slider-type",
					"label" => __( 'Enable slider', 'lespaul_domain_adm' ),
					"desc" => __( 'Select a slider type from the dropdown list below', 'lespaul_domain_adm' ),
					"options" => $availableSliders,
					"default" => "none"
				),

					array(
						"id" => $prefix."slider-settings",
						"type" => "inside-wrapper-open"
					),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "static"
								),
							"type" => "checkbox",
							"id" => $prefix."slider-static-stretch",
							"label" => __( 'Stretch (fit) the image', 'lespaul_domain_adm' ),
							"desc" => __( 'Image fits the full website width', 'lespaul_domain_adm' ) . '<br /><br />',
							"value" => "fullwidth"
						),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "video"
								),
							"type" => "text",
							"id" => $prefix."slider-video-url",
							"label" => __( 'Video URL', 'lespaul_domain_adm' ),
							"desc" => sprintf( __( 'Enter full video URL (<a%s>supported video portals</a> and Screenr videos only)', 'lespaul_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ) . '<br />' . __( 'If you set featured image, it will be used as video cover image. The video starts to play after clicking the image (for Vimeo and YouTube videos only).', 'lespaul_domain_adm' ),
							"validate" => "url"
						),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "custom"
								),
							"type" => "text",
							"id" => $prefix."slider-custom-shortcode",
							"label" => __( 'Custom slider shortcode', 'lespaul_domain_adm' ),
							"desc" => __( 'Most of custom slider plugins let you display the slider using shortcode. Please, insert such slider shortcode into this text field. The slider will then be displayed in main slider area of the website.', 'lespaul_domain_adm' ),
						),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "custom"
								),
							"type" => "checkbox",
							"id" => $prefix."slider-width",
							"label" => __( 'Fit website width', 'lespaul_domain_adm' ),
							"desc" => __( 'Stretches the slider full website width', 'lespaul_domain_adm' ) . '<br /><br />',
							"value" => "fullwidth"
						),

						array(
							"type" => "color",
							"id" => $prefix."slider-bg-color",
							"label" => __( 'Slider background color', 'lespaul_domain_adm' ),
							"desc" => __( 'Sets the custom slider background color', 'lespaul_domain_adm' ),
							"validate" => "color",
							"default" => ""
						),
						array(
							"type" => "checkbox",
							"id" => $prefix."slider-top",
							"label" => __( 'Slider beneath header', 'lespaul_domain_adm' ),
							"desc" => __( 'You can move slider beneath the website header just by selecting the option below', 'lespaul_domain_adm' ),
						),

					array(
						"conditional" => array(
							"field" => $prefix."slider-type",
							"value" => "static,video,custom"
							),
						"id" => $prefix."slider-settings",
						"type" => "inside-wrapper-close"
					),
			array(
				"type" => "section-close"
			),



			//Sidebar settings
			array(
				"type" => "section-open",
				"section-id" => "sidebar-section",
				"title" => __( 'Sidebar', 'lespaul_domain_adm' ),
				"exclude" => array( 'page-template/sitemap.php', 'page-template/construction.php', 'page-template/redirect.php', 'page-template/sections.php' )
			),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Choose a sidebar and its position on the post/page', 'lespaul_domain_adm' ) . '</h4>' . $widgetsButtons,
				),

				array(
					"type" => "layouts",
					"id" => $prefix."layout",
					"label" => __( 'Sidebar position', 'lespaul_domain_adm' ),
					"desc" => __( 'Choose a sidebar position on the post/page (set the first one to use the theme default settings)', 'lespaul_domain_adm' ),
					"options" => $sidebarPosition,
					"default" => ""
				),
				array(
					"type" => "select",
					"id" => $prefix."sidebar",
					"label" => __( 'Choose a sidebar', 'lespaul_domain_adm' ),
					"desc" => __( 'Select a widget area used as a sidebar for this post/page (if not set, the dafault theme settings will apply)', 'lespaul_domain_adm' ),
					"options" => wm_widget_areas(),
					"default" => ""
				),
			array(
				"type" => "section-close"
			),



			//Design - website background settings
			array(
				"type" => "section-open",
				"section-id" => "background-settings",
				"title" => __( 'Backgrounds', 'lespaul_domain_adm' ),
				"exclude" => array( 'page-template/redirect.php' )
			),
				array(
					"type" => "heading4",
					"content" => __( 'Main heading area background', 'lespaul_domain_panel' )
				),
				array(
					"id" => $prefix."bg-heading",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "slider",
						"id" => $prefixBgHeading."padding",
						"label" => __( 'Section padding', 'lespaul_domain_adm' ),
						"desc" => __( 'Top and bottom padding size applied on the section (leave zero for default)', 'lespaul_domain_adm' ),
						"default" => 0,
						"min" => 1,
						"max" => 100,
						"step" => 1,
						"validate" => "absint"
					),
					array(
						"type" => "color",
						"id" => $prefixBgHeading."color",
						"label" => __( 'Text color', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the custom main heading text color', 'lespaul_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefixBgHeading."bg-color",
						"label" => __( 'Background color', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the custom main heading background color', 'lespaul_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "image",
						"id" => $prefixBgHeading."bg-img-url",
						"label" => __( 'Custom background image', 'lespaul_domain_adm' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_adm' ),
						"default" => "",
						"readonly" => true,
						"imgsize" => 'mobile'
					),
					array(
						"type" => "select",
						"id" => $prefixBgHeading."bg-img-position",
						"label" => __( 'Background image position', 'lespaul_domain_adm' ),
						"desc" => __( 'Set background image position', 'lespaul_domain_adm' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'lespaul_domain_adm' ),
							'50% 0'     => __( 'Center horizontally, top', 'lespaul_domain_adm' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'lespaul_domain_adm' ),
							'0 0'       => __( 'Left, top', 'lespaul_domain_adm' ),
							'0 50%'     => __( 'Left, center vertically', 'lespaul_domain_adm' ),
							'0 100%'    => __( 'Left, bottom', 'lespaul_domain_adm' ),
							'100% 0'    => __( 'Right, top', 'lespaul_domain_adm' ),
							'100% 50%'  => __( 'Right, center vertically', 'lespaul_domain_adm' ),
							'100% 100%' => __( 'Right, bottom', 'lespaul_domain_adm' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefixBgHeading."bg-img-repeat",
						"label" => __( 'Background image repeat', 'lespaul_domain_adm' ),
						"desc" => __( 'Set background image repeating', 'lespaul_domain_adm' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'lespaul_domain_adm' ),
							'repeat'    => __( 'Repeat', 'lespaul_domain_adm' ),
							'repeat-x'  => __( 'Repeat horizontally', 'lespaul_domain_adm' ),
							'repeat-y'  => __( 'Repeat vertically', 'lespaul_domain_adm' )
							),
						"default" => 'no-repeat'
					),
				array(
					"id" => $prefix."bg-heading",
					"type" => "inside-wrapper-close"
				),

				array(
					"type" => "heading4",
					"content" => __( 'Page background', 'lespaul_domain_panel' )
				),
				array(
					"id" => $prefix."bg",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefixBg."bg-color",
						"label" => __( 'Background color', 'lespaul_domain_adm' ),
						"desc" => __( 'Sets the custom website background color.', 'lespaul_domain_adm' ) . '<br />' . __( 'Please always set this to reset any possible background styles applied on main HTML element.', 'lespaul_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "image",
						"id" => $prefixBg."bg-img-url",
						"label" => __( 'Custom background image', 'lespaul_domain_adm' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'lespaul_domain_adm' ),
						"default" => "",
						"readonly" => true,
						"imgsize" => 'mobile'
					),
					array(
						"type" => "select",
						"id" => $prefixBg."bg-img-position",
						"label" => __( 'Background image position', 'lespaul_domain_adm' ),
						"desc" => __( 'Set background image position', 'lespaul_domain_adm' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'lespaul_domain_adm' ),
							'50% 0'     => __( 'Center horizontally, top', 'lespaul_domain_adm' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'lespaul_domain_adm' ),
							'0 0'       => __( 'Left, top', 'lespaul_domain_adm' ),
							'0 50%'     => __( 'Left, center vertically', 'lespaul_domain_adm' ),
							'0 100%'    => __( 'Left, bottom', 'lespaul_domain_adm' ),
							'100% 0'    => __( 'Right, top', 'lespaul_domain_adm' ),
							'100% 50%'  => __( 'Right, center vertically', 'lespaul_domain_adm' ),
							'100% 100%' => __( 'Right, bottom', 'lespaul_domain_adm' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefixBg."bg-img-repeat",
						"label" => __( 'Background image repeat', 'lespaul_domain_adm' ),
						"desc" => __( 'Set background image repeating', 'lespaul_domain_adm' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'lespaul_domain_adm' ),
							'repeat'    => __( 'Repeat', 'lespaul_domain_adm' ),
							'repeat-x'  => __( 'Repeat horizontally', 'lespaul_domain_adm' ),
							'repeat-y'  => __( 'Repeat vertically', 'lespaul_domain_adm' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefixBg."bg-img-attachment",
						"label" => __( 'Background image attachment', 'lespaul_domain_adm' ),
						"desc" => __( 'Set background image attachment', 'lespaul_domain_adm' ),
						"options" => array(
							'fixed'  => __( 'Fixed position', 'lespaul_domain_adm' ),
							'scroll' => __( 'Move on scrolling', 'lespaul_domain_adm' )
							),
						"default" => 'fixed'
					),
					array(
						"type" => "checkbox",
						"id" => $prefixBg."bg-img-fit-window",
						"label" => __( 'Fit browser window width', 'lespaul_domain_adm' ),
						"desc" => __( 'Makes the image to scale to browser window width. Note that background image position and repeat options does not apply when this is checked.', 'lespaul_domain_adm' ),
						"value" => "true"
					),
				array(
					"id" => $prefix."bg",
					"type" => "inside-wrapper-close"
				),
			array(
				"type" => "section-close"
			)

		);

		return $metaPageOptions;
	}
} // /wm_meta_page_options

?>