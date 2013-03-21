<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Options Panel - General
*****************************************************
*/

$imageSizes = array(
		'ratio-11'  => __( 'Square', 'lespaul_domain_panel' ),
		//landscape
		'ratio-43'  => __( 'Landscape 4 to 3', 'lespaul_domain_panel' ),
		'ratio-32'  => __( 'Landscape 3 to 2', 'lespaul_domain_panel' ),
		'ratio-169' => __( 'Landscape 16 to 9 (widescreen)', 'lespaul_domain_panel' ),
		'ratio-21'  => __( 'Landscape 2 to 1', 'lespaul_domain_panel' ),
		'ratio-31'  => __( 'Landscape 3 to 1', 'lespaul_domain_panel' ),
		//portrait
		'ratio-34'  => __( 'Portrait 3 to 4', 'lespaul_domain_panel' ),
		'ratio-23'  => __( 'Portrait 2 to 3', 'lespaul_domain_panel' ),
	);

$prefix = 'general-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "general",
	"title" => __( 'General', 'lespaul_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "general",
		"list" => array(
			__( 'Basics', 'lespaul_domain_panel' ),
			__( 'Images', 'lespaul_domain_panel' ),
			__( 'Breadcrums', 'lespaul_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-1",
		"title" => __( 'Basics', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Main website layout', 'lespaul_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "layouts",
				"id" => $prefix."boxed",
				"label" => __( 'Layout', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose the default website layout', 'lespaul_domain_panel' ),
				"options" => $websiteLayout,
				"default" => "fullwidth"
			),
			array(
				"type" => "select",
				"id" => $prefix."width",
				"label" => __( 'Website width', 'lespaul_domain_panel' ),
				"desc" => __( 'Sets the maximum website content width and responsiveness of the design', 'lespaul_domain_panel' ),
				"options" => array(
					'r940'  => __( 'Responsive 940px (1020px website box)', 'lespaul_domain_panel' ),
					'r1160' => __( 'Responsive 1160px (1240px website box)', 'lespaul_domain_panel' ),
					's940'  => __( 'Static 940px (1020px website box)', 'lespaul_domain_panel' ),
					's1160' => __( 'Static 1160px (1240px website box)', 'lespaul_domain_panel' ),
					),
				"default" => "r940"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Others', 'lespaul_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."projects-in-feed",
				"label" => __( 'Include projects in RSS feed', 'lespaul_domain_panel' ),
				"desc" => __( 'Include portfolio projects in your website RSS feed', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "text",
				"id" => $prefix."search-placeholder",
				"label" => __( 'Search form placeholder text', 'lespaul_domain_panel' ),
				"desc" => __( 'Placeholder text displayed in search field', 'lespaul_domain_panel' ),
				"default" => __( 'Search term', 'lespaul_domain' )
			),
			array(
				"type" => "text",
				"id" => $prefix."website-author",
				"label" => __( 'Website author meta tag', 'lespaul_domain_panel' ),
				"desc" => __( 'Place your name or your company name in meta tag in HTML head', 'lespaul_domain_panel' ),
				"default" => 'WebMan - www.webmandesign.eu'
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."gzip",
				"label" => __( 'Enable basic GZIP compression', 'lespaul_domain_panel' ),
				"desc" => __( 'GZIP compression will speed up your website loading time, so it is recommended to turn it on (except when you use a plugin to apply it).<br />Before enabling GZIP compression, please make sure your webhost (web server) supports this compression method and it is enabled (you may get error note if the compression is not supported on your server).', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-help",
				"label" => __( 'Disable theme contextual help', 'lespaul_domain_panel' ),
				"desc" => __( 'Removes theme help texts from WordPress contextual help', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-update-notifier",
				"label" => __( 'Disable theme update notifier', 'lespaul_domain_panel' ),
				"desc" => __( 'The theme is using update notifier script that checks for new theme update by connecting to WebMan server. If you notice slow response of WordPress admin, please try to disable update notifier as it is possible that your server can not connect and obtain correct theme version which causes the slowdown.', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."default-menu",
				"label" => __( 'Default WordPress menu order', 'lespaul_domain_panel' ),
				"desc" => __( 'As you can see, the theme slightly changes positions of default WordPress admin menu items. With some plugins this might cause potential problems. Enable default menu order if the menu item created by the plugin is not displayed. If the problem with menu item of plugin still occurs even after enabling default WordPress menu order, contact WebMan support for assistance.', 'lespaul_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."theme-options-reset",
				"label" => __( 'Add reset button to this admin panel', 'lespaul_domain_panel' ),
				"desc" => __( 'Show [RESET] button at the bottom of this admin panel. You will loose all changes by resetting the theme options!', 'lespaul_domain_panel' )
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-2",
		"title" => __( 'Images', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Image sizes used in different website sections', 'lespaul_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "heading4",
				"content" => __( 'Minimal upload image sizes info', 'lespaul_domain_panel' )
			),
			array(
				"id" => $prefix."minimal-image-sizes",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "paragraph",
					"content" => __( 'The image format settings below will also affect the minimal image size that you upload into WordPress. As the theme scales and reorganizes the content depending on the screen resolution it is viewed on (the responsive design feature), it requires images of <strong>minimal width of half of the website content area width</strong> (this means if you are using 940px content width layout, minimal image width would be 470px, if you set 1160px website width, the minimal image width would be 580px - website width can be set on previous <strong>Basics</strong> tab).', 'lespaul_domain_panel' ),
				),
				array(
					"type" => "paragraph",
					"content" => __( 'The best and recommended upload image width would, however, be at least equal to the width of the website - so <strong>940px or 1160px</strong> (or the size you set up in <strong>Settings &raquo; Media</strong> for large size if it is bigger).', 'lespaul_domain_panel' ),
				),
				array(
					"type" => "paragraph",
					"content" => __( 'The height of the image depends on previously mentioned image formats selected. As an example, if you choose a blog posts featured image to be displayed in 2:1 aspect ratio, you should upload images of minimal size of 940&times;470px for post featured images.', 'lespaul_domain_panel' ),
				),
				array(
					"type" => "paragraph",
					"content" => __( 'WordPress will rescale and crop the images to selected formats (aspect ratios) automatically during the image upload process.', 'lespaul_domain_panel' ),
				),
				array(
					"type" => "paragraph",
					"content" => __( 'The rule of thumb here: the bigger the image, the better (although, keep the actual storage size of the files to minimum).', 'lespaul_domain_panel' ),
				),
				array(
					"type" => "info",
					"content" => __( '<strong>High DPI / Retina display support</strong><br />If you want your website to be fully high DPI (also called Retina) screen compatible, just double the sizes of uploaded images (you can lower the quality of JPEG images a bit to reduce the storage size of the image file). The theme itself is already optimized for high DPI screens.<br />To make sure your content images are high DPI screen ready <a href="http://www.totorotimes.com/news/retina-display-wordpress-plugin/" target="_blank">you can read a tutorial</a> and <a href="http://wordpress.org/extend/plugins/wp-retina-2x/" target="_blank">use a specialized WordPress plugin</a>.<br />If you want to dive more into high DPI screen problematics, I recommend reading <a href="http://retinafy.me/" target="_blank"><strong>Retinafy your web sites &amp; apps</strong></a> book.', 'lespaul_domain_panel' ),
				),
			array(
				"id" => $prefix."minimal-image-sizes",
				"type" => "inside-wrapper-close"
			),

			array(
				"type" => "box",
				"content" => '<p>' . __( 'Please decide on, and set the image sizes up for different website sections right after the theme activation. If you change the image sizes later on, the settings will apply only on newly uploaded images - so the images you upload after you change the settings below. All previous images will keep their original sizes.', 'lespaul_domain_panel' ) . '</p>' . __( 'If you, however, wish to resize the previously uploaded images to new sizes set below, you can use a plugin for this. Recommended plugins are <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> or <a href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" target="_blank">AJAX Thumbnail Rebuild</a>.', 'lespaul_domain_panel' ),
			),
			/*
			//FINAL DECISION: PLUGIN IS USING JS AND THAT WILL IMPROVE IN THE FUTURE AS THE BROWSERS SUPPORT WILL IMPROVE, SO PLUGIN IS ACTUALLY FUTUREPROOF SOLUTION!
			array(
				"type" => "checkbox",
				"id" => $prefix."images-highdpi",
				"label" => __( 'Enable theme highDPI / Retina images', 'lespaul_domain_panel' ),
				"desc" => __( 'If you are using a plugin to resize and distribute your hightDPI / Retina images, keep this setting turned off.', 'lespaul_domain_panel' ) . '<br />'
					. __( 'If you are using a plugin to resize and distribute your hightDPI / Retina images, keep this setting turned off.<br />If you enable this option, theme will create all images double size, so the optimal image upload size would be 2 &times; website content width for highDPI / Retina displays compatibility. Also all your content images should be double the size, but keep in mind to set their width (and height) parameter to half. Example: for content image that should be displayed as 300&times;200 px upload an image of 600&times;400 px dimenstions and set the width parameter of the image to 300px when you insert the image into page/post content.', 'lespaul_domain_panel' )
					. __( 'As there is no straight answer in webdesign comunity on how to deal with images for highDPI / Retina displays nowadays, it is dificult to say which solution is better: using theme settings or using a specialized plugin. Plugin solution is much easier for maintenance, but I (WebMan) think using double sized images and downscaling them is slightly more future proof.', 'lespaul_domain_panel' )
			),
			array(
				"type" => "hr",
			),
			*/
			array(
				"type" => "select",
				"id" => $prefix."projects-image-ratio",
				"label" => __( 'Projects and Posts shortcodes image aspect ratio', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of projects images displayed in portfolio list and post thumbnails in posts list shortcodes', 'lespaul_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-169"
			),
			array(
				"type" => "select",
				"id" => $prefix."post-image-ratio",
				"label" => __( 'Default blog list image aspect ratio', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of post thumbnail images displayed on Blog pages with "Media on top" and "Masonry" layout', 'lespaul_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-21"
			),
			array(
				"type" => "select",
				"id" => $prefix."post-image-ratio-alt",
				"label" => __( 'Alternative blog list image aspect ratio', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of post thumbnail images displayed on Blog pages with "Media left", "Media right" or "Zigzag" layout', 'lespaul_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-169"
			),
			array(
				"type" => "select",
				"id" => $prefix."gallery-image-ratio",
				"label" => __( 'Gallery image aspect ratio', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose the default aspect ratio of gallery images', 'lespaul_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-169"
			),
			array(
				"type" => "select",
				"id" => $prefix."staff-image-ratio",
				"label" => __( 'Staff image aspect ratio', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of staff portraits', 'lespaul_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-169"
			),
			array(
				"type" => "select",
				"id" => $prefix."lightbox-img",
				"label" => __( 'Zoomed image size', 'lespaul_domain_panel' ),
				"desc" => __( 'Choose what image size should be displayed when projects or blog featured image is zoomed', 'lespaul_domain_panel' ),
				"options" => array(
					'full'  => __( 'Full size image', 'lespaul_domain_panel' ),
					'large' => __( 'Large image (can be set in Settings > Media)', 'lespaul_domain_panel' ),
					),
				"default" => "full"
			),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-3",
		"title" => __( 'Breadcrumbs', 'lespaul_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Breadcrumbs navigation settings', 'lespaul_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "info",
			"content" => __( 'The theme is fully compatible with <strong>Yoast SEO breadcrumbs</strong> that are included in <a href="http://www.wordpress.org/extend/plugins/wordpress-seo/" target="_blank"><strong>Yoast SEO WordPress plugin</strong></a>. Once you activate Yoast SEO breadcrumbs, the theme will use them instead of the default ones.', 'lespaul_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "select",
			"id" => $prefix."breadcrumbs",
			"label" => __( 'Breadcrumbs position', 'lespaul_domain_panel' ),
			"desc" => __( 'Select whether and where the breadcrumbs navigation should be displayed', 'lespaul_domain_panel' ),
			"options" => array(
					'none'   => __( 'No breadcrumbs', 'lespaul_domain_panel' ),
					'top'    => __( 'Top breadcrumbs', 'lespaul_domain_panel' ),
					'bottom' => __( 'Bottom breadcrumbs', 'lespaul_domain_panel' ),
					'both'   => __( 'Top and bottom breadcrumbs', 'lespaul_domain_panel' ),
				),
			"default" => "bottom"
		),
		array(
			"type" => "info",
			"content" => __( 'The above option allows you to disable breadcrumbs navigation altogether. However, it is recommended to keep the breadcrumbs displayed as it improves <attr title="Search Engine Optimization">SEO</attr>. Alternatively you can choose to disable breadcrumbs in specific website sections only (see the settings below) or on certain posts and pages (see the post/page settings).', 'lespaul_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "select",
			"id" => $prefix."breadcrumbs-portfolio-page",
			"label" => __( 'Portfolio page', 'lespaul_domain_panel' ),
			"desc" => __( 'Select a main projects list page used as base for single project pages', 'lespaul_domain_panel' ),
			"options" => wm_pages(),
			"default" => ""
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."breadcrumbs-archives",
			"label" => __( 'Disable breadcrumbs on archives', 'lespaul_domain_panel' ),
			"desc" => __( 'Disables breadcrumbs navigation on all archive pages', 'lespaul_domain_panel' )
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."breadcrumbs-404",
			"label" => __( 'Disable breadcrumbs on Error 404 page', 'lespaul_domain_panel' ),
			"desc" => __( 'Disables breadcrumbs navigation on Error 404 page', 'lespaul_domain_panel' )
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "select",
			"id" => $prefix."breadcrumbs-search",
			"label" => __( 'Search form in breadcrumbs', 'lespaul_domain_panel' ),
			"desc" => __( 'Select whether to display search form in breadcrumbs section', 'lespaul_domain_panel' ),
			"options" => array(
					''               => __( 'Do not display search form', 'lespaul_domain_panel' ),
					' animated-form' => __( 'Display animated search form', 'lespaul_domain_panel' ),
					' static-form'   => __( 'Display static search form', 'lespaul_domain_panel' ),
				),
			"default" => " animated-form"
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