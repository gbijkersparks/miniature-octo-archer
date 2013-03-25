<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Basic theme setup
*
* CONTENT:
* - 1) Actions and filters
* - 2) Globals
* - 3) Security
* - 4) Theme features
* - 5) Localization
* - 6) Assets and design
* - 7) Others
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Adding assets into HTML head
		add_action( 'wp_enqueue_scripts', 'wm_site_assets' );
		//WordPress header additions
		add_filter( 'wp_head', 'wm_head_styles', 1000 );

	//FILTERS
		//BODY classes
		add_filter( 'body_class', 'wm_body_classes' );





/*
*****************************************************
*      2) GLOBALS
*****************************************************
*/
	//Max content width
	if ( ! isset( $content_width ) )
		$content_width = ( 'r1160' != wm_option( 'general-width' ) && 's1160' != wm_option( 'general-width' ) ) ? ( 940 ) : ( 1160 );





/*
*****************************************************
*      3) SECURITY
*****************************************************
*/
	//Generic login error messages
	if ( ! function_exists( 'wm_login_generic_message' ) ) {
		function wm_login_generic_message() {
			return __( 'It seems something went wrong...', 'lespaul_domain_adm' );
		}
	} // /wm_login_generic_message

	//Hide login errors
	if ( wm_option( 'security-login-error' ) )
		add_filter( 'login_errors', 'wm_login_generic_message' );

	//Remove WP version from HTML header
	if ( wm_option( 'security-wp-version' ) )
		remove_action( 'wp_head', 'wp_generator' );

	//Rremove Windows Live Writer support
	if ( wm_option( 'security-live-writer' ) )
		remove_action( 'wp_head', 'wlwmanifest_link' );





/*
*****************************************************
*      4) THEME FEATURES
*****************************************************
*/
	//Post formats
		$postFormats = array();
		if ( ! wm_option( 'blog-no-format-audio' ) )
			$postFormats[] = 'audio';
		if ( ! wm_option( 'blog-no-format-gallery' ) )
			$postFormats[] = 'gallery';
		if ( ! wm_option( 'blog-no-format-link' ) )
			$postFormats[] = 'link';
		if ( ! wm_option( 'blog-no-format-quote' ) )
			$postFormats[] = 'quote';
		if ( ! wm_option( 'blog-no-format-status' ) )
			$postFormats[] = 'status';
		if ( ! wm_option( 'blog-no-format-video' ) )
			$postFormats[] = 'video';
		if ( ! empty( $postFormats ) )
			add_theme_support( 'post-formats', $postFormats );



	//Feed links
		if ( ! wm_option( 'social-no-auto-feed-link' ) )
			add_theme_support( 'automatic-feed-links' );



	//Custom menus
		add_theme_support( 'menus' );
		//menus array
		$registeredMenusArray = array(
				'main-navigation' => __( 'Main navigation', 'lespaul_domain_adm' ),
				'footer-menu'     => __( 'Footer menu', 'lespaul_domain_adm' ),
			);
			if ( ! wm_option( 'contents-page-template-sitemap-php' ) )
				$registeredMenusArray['sitemap-links'] = __( 'Sitemap links', 'lespaul_domain_adm' );

			//separate menu for each landing page
			$landingPages = get_pages( array(
					'meta_key'     => '_wp_page_template',
					'meta_value'   => 'page-template/landing.php',
					'hierarchical' => 0
				) );
			foreach ( $landingPages as $landingPage ) {
				$registeredMenusArray['menu-landing-page-' . $landingPage->ID] = '"' . $landingPage->post_title . '" ' . __( 'page navigation', 'lespaul_domain_adm' );
			}
		//register menus
		register_nav_menus( $registeredMenusArray );



	//Thumbnails support
		add_theme_support( 'post-thumbnails' ); //thumbs just for posts in categories
		//$coeficient  = ( ! wm_option( 'general-images-highdpi' ) ) ? ( 1 ) : ( 2 );
		$coeficient  = 1; //requires using plugin for highDPI/Retina display images
		$mobileWidth = min( absint( $content_width / 2 ), 520 ); //the half of the content width (for zig-zag posts display), but max 520
		$addImageSizeArray = array(
				'content-width' => array(
						//landscape
						'ratio-11'  => array( $content_width * $coeficient, $content_width * $coeficient ),
						'ratio-43'  => array( $content_width * $coeficient, floor( 3 * $content_width * $coeficient / 4 ) ),
						'ratio-32'  => array( $content_width * $coeficient, floor( 2 * $content_width * $coeficient / 3 ) ),
						'ratio-169' => array( $content_width * $coeficient, floor( 9 * $content_width * $coeficient / 16 ) ),
						'ratio-21'  => array( $content_width * $coeficient, floor( $content_width * $coeficient / 2 ) ),
						'ratio-31'  => array( $content_width * $coeficient, floor( $content_width * $coeficient / 3 ) ),
						//portrait
						'ratio-34'  => array( $content_width * $coeficient, floor( 4 * $content_width * $coeficient / 3 ) ),
						'ratio-23'  => array( $content_width * $coeficient, floor( 3 * $content_width * $coeficient / 2 ) ),
					),
				'mobile' => array(
						//landscape
						'ratio-11'  => array( $mobileWidth * $coeficient, $mobileWidth * $coeficient ),
						'ratio-43'  => array( $mobileWidth * $coeficient, intval( 3 * $mobileWidth * $coeficient / 4 ) ),
						'ratio-32'  => array( $mobileWidth * $coeficient, intval( 2 * $mobileWidth * $coeficient / 3 ) ),
						'ratio-169' => array( $mobileWidth * $coeficient, intval( 9 * $mobileWidth * $coeficient / 16 ) ),
						'ratio-21'  => array( $mobileWidth * $coeficient, intval( $mobileWidth * $coeficient / 2 ) ),
						'ratio-31'  => array( $mobileWidth * $coeficient, intval( $mobileWidth * $coeficient / 3 ) ),
						//portrait
						'ratio-34'  => array( $mobileWidth * $coeficient, intval( 4 * $mobileWidth * $coeficient / 3 ) ),
						'ratio-23'  => array( $mobileWidth * $coeficient, intval( 3 * $mobileWidth * $coeficient / 2 ) ),
					)
			);
		$createImagesArray = array(
				wm_option( 'general-projects-image-ratio' ),
				wm_option( 'general-post-image-ratio' ),
				wm_option( 'general-post-image-ratio-alt' ),
				wm_option( 'general-gallery-image-ratio' ),
				wm_option( 'general-staff-image-ratio' ),
			);
		if ( empty( $createImagesArray ) )
			$createImagesArray( 'ratio-169' );
		$createImagesArray = array_filter( $createImagesArray, 'strlen' );
		$createImagesArray = array_unique( $createImagesArray );

		//image sizes (x, y, crop)
			add_image_size( 'content-width', $content_width * $coeficient, 9999, false ); //website width, unlimited height
			add_image_size( 'mobile', $mobileWidth * $coeficient, 9999, false ); //max mobile width, ulnimited height
			add_image_size( 'widget', 60 * $coeficient, 60 * $coeficient, true ); //small widget squere image, cropped
			foreach ( $createImagesArray as $ratio ) {
				add_image_size( $ratio, $addImageSizeArray['content-width'][$ratio][0], $addImageSizeArray['content-width'][$ratio][1], true );
				add_image_size( 'mobile-' . $ratio, $addImageSizeArray['mobile'][$ratio][0], $addImageSizeArray['mobile'][$ratio][1], true );
			}





/*
*****************************************************
*      5) LOCALIZATION
*****************************************************
*/
	/*
	* The theme splits translation into 4 sections:
	*  1) website front-end
	*  2) main WordPress admin extensions (like post metaboxes)
	*  3) theme's contextual help texts
	*  4) theme admin panel (accessed by administrators only)
	* You can find all theme translation .PO files (and place translated .MO files) in "lespaul/langs/" folder and subsequent subfolders.
	*
	* Theme uses these textdomains:
	*  1) lespaul_domain
	*  2) lespaul_domain_adm
	*  3) lespaul_domain_help
	*  4) lespaul_domain_panel
	*/
	load_theme_textdomain( 'lespaul_domain', WM_LANGUAGES );
	if( is_admin() )
		load_theme_textdomain( 'lespaul_domain_adm', WM_LANGUAGES . '/admin' );
	if ( is_admin() && ! wm_option( 'general-no-help' ) )
		load_theme_textdomain( 'lespaul_domain_help', WM_LANGUAGES . '/help' );
	if( is_admin() && current_user_can( 'switch_themes' ) )
		load_theme_textdomain( 'lespaul_domain_panel', WM_LANGUAGES . '/wm-admin-panel' );





/*
*****************************************************
*      6) ASSETS AND DESIGN
*****************************************************
*/
	/*
	* Frontend HTML head assets
	*/
	if ( ! function_exists( 'wm_site_assets' ) ) {
		function wm_site_assets() {
			global $post;

			$blogPageId = get_option( 'page_for_posts' );

			//scripts
				wp_enqueue_script( 'imagesloaded' );
				wp_enqueue_script( 'prettyphoto' );

				if ( is_home() || is_page_template( 'home.php' ) ) {
					$thisPageId = ( is_home() ) ? ( $blogPageId ) : ( get_the_ID() );
					if ( ' masonry-container' === wm_meta_option( 'blog-layout', $thisPageId ) )
						wp_enqueue_script( 'masonry' );
				}

				if ( is_archive() && wm_meta_option( 'blog-layout', $blogPageId ) )
					wp_enqueue_script( 'masonry' );

				if ( is_page_template( 'page-template/construction.php' ) )
					wp_enqueue_script( 'lwtCountdown' );

				if ( is_page_template( 'page-template/map.php' ) ) {
					wp_enqueue_script( 'gmapapi' );
					wp_enqueue_script( 'gmap-infobox' );
					wp_enqueue_script( 'gmap' );
				}

				wp_enqueue_script( 'wm-theme-scripts' );

				if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
					wp_enqueue_script( 'comment-reply', false, false, false, true ); //true to put it into footer
		}
	} // /wm_site_assets



	/*
	* BODY classes
	*/
	if ( ! function_exists( 'wm_body_classes' ) ) {
		function wm_body_classes( $classes ) {
			global $post;

			//variables needed
				//post ID
				$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				//top panel display boolean variable
				$isTopBar = is_active_sidebar( 'top-bar-widgets' ) && ! ( ! is_archive() && ! is_search() && wm_meta_option( 'no-top-bar', $postId ) ) && ! is_page_template( 'page-template/landing.php' ) && ! is_page_template( 'page-template/construction.php' );

			//body classes
				$bodyClass    = array();
				$bodyClass[0] = trim( wm_option( 'general-boxed' ) );
				if (
						! is_search() && ! is_archive() &&
						wm_meta_option( 'boxed', $postId ) && 'default' != wm_meta_option( 'boxed', $postId )
					) {
					$bodyClass[0] = trim( wm_meta_option( 'boxed', $postId ) );
					$bodyClass[1] = 'page-settings-layout';
				}

				//website layout width class
					$bodyClass[2] = trim( wm_option( 'general-width' ) );

				//top bar and breadcrumbs
					if ( $isTopBar )
						$bodyClass[3] = 'top-bar-enabled';
					if ( $isTopBar && wm_option( 'header-top-bar-fixed' ) )
						$bodyClass[4] = 'top-bar-fixed';
					if ( 'none' != wm_option( 'general-breadcrumbs' ) && ! wm_meta_option( 'breadcrumbs', $postId ) )
						$bodyClass[5] = 'breadcrumbs-' . trim( wm_option( 'general-breadcrumbs' ) );

				//fixed header
					$fixedHeader = ( ! wm_option( 'header-header-position' ) ) ? ( 'no-header-fixed' ) : ( wm_option( 'header-header-position' ) );
					if ( wm_meta_option( 'toggle-header-position', $postId ) ) {
						if ( 'no-header-fixed' === $fixedHeader )
							$fixedHeader = 'header-fixed';
						else
							$fixedHeader = 'no-header-fixed';
					}
					//slider / map beneath the header (affects also fixed header)
						if (
								( is_singular() || is_home() ) &&
								isset( $post ) &&
								(
									( 'none' != wm_meta_option( 'slider-type', $postId ) && wm_meta_option( 'slider-top', $postId ) ) ||
									wm_meta_option( 'map-top', $postId )
								) )
							$fixedHeader = 'no-header-fixed absolute-header';
					//fixed header continute
						$bodyClass[6] = trim( $fixedHeader );

			//output
			$classes = array_merge( $classes, $bodyClass );

			return $classes;
		}
	} // /wm_body_classes



	/*
	* WordPress head styles
	*/
	if ( ! function_exists( 'wm_head_styles' ) ) {
		function wm_head_styles( $classes ) {
			global $post;

			//variables needed
				//post ID
				$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//custom in-header styles
				$inHeaderStyles = '';

				//page background image
					if (
							( isset( $post ) || is_home() ) &&
							! is_search() && ! is_archive() &&
							wm_css_background_meta( 'background-' )
						) {
						$inHeaderStyles .= ( wm_meta_option( 'background-bg-img-fit-window', $postId ) ) ? ( "\t" . 'body {background: none}' . "\r\n" ) : ( "\t" . 'body {background: ' . wm_css_background_meta( 'background-' ) . '}' . "\r\n" );
						$inHeaderStyles .= ( ! wm_meta_option( 'background-bg-color', $postId ) ) ? ( '' ) : ( "\t" . 'html {background: none}' . "\r\n" );
					}

				//main heading area background
					if (
							( isset( $post ) || is_home() ) &&
							( wm_css_background_meta( 'heading-background-' ) || wm_meta_option( 'heading-background-padding' ) )
						) {
						$inHeaderStyles .= ( wm_meta_option( 'heading-background-padding' ) ) ? ( "\t" . '.main-heading .twelve.pane {padding-top: ' . absint( wm_meta_option( 'heading-background-padding' ) ) . 'px; padding-bottom: ' . absint( wm_meta_option( 'heading-background-padding' ) ) . 'px;}' . "\r\n" ) : ( '' );
						$inHeaderStyles .= ( wm_css_background_meta( 'heading-background-' ) ) ? ( "\t" . '.main-heading {background: ' . wm_css_background_meta( 'heading-background-' ) . '}' . "\r\n" ) : ( '' );
						$inHeaderStyles .= ( ! wm_meta_option( 'heading-background-color', $postId ) ) ? ( '' ) : ( "\t" . '.main-heading h1, .main-heading h2, .main-heading i[class^="icon-"] {color: ' . wm_meta_option( 'heading-background-color', $postId, 'color' ) . ';}' . "\r\n" );
					}

				//wrapper padding when fixed header used
					if ( in_array( 'header-fixed', get_body_class() ) && 0 < wm_option( 'header-height' ) )
						$inHeaderStyles .= "\t" . '@media only screen and (min-width: 768px) { body.header-fixed { padding-top: ' . absint( wm_option( 'header-height' ) ) . 'px; } body.top-bar-enabled.header-fixed { padding-top: ' . absint( wm_option( 'header-height' ) + 50 ) . 'px; } }' . "\r\n";

			//output
			if ( $inHeaderStyles )
				$inHeaderStyles = "\r\n<!-- Custom header styles -->\r\n" . '<style type="text/css">' . "\r\n" . $inHeaderStyles . '</style>' . "\r\n";

			echo $inHeaderStyles;
		}
	} // /wm_head_styles





/*
*****************************************************
*      7) OTHERS
*****************************************************
*/
	//WooCommerce integration
		if ( class_exists( 'Woocommerce' ) ) {

			add_theme_support( 'woocommerce' ); //declaring WooCommerce 2.0+ support

			define( 'WOOCOMMERCE_USE_CSS', false );

			/**
			* Remove WooCommerce styles and scripts unless inside the store.
			*
			* @author Greg Rickaby, http://gregrickaby.com/2012/05/remove-woocommerce-styles-and-scripts.html
			* @since 1.0.0
			*/
			if ( ! function_exists( 'wm_woocommerce_assets' ) ) {
				function wm_woocommerce_assets() {
					//remove WooCommerce assets globally
						wp_dequeue_style( 'woocommerce_fancybox_styles' );
						wp_dequeue_script( 'fancybox' );
				}
			} // /wm_woocommerce_assets
			add_action( 'wp_enqueue_scripts', 'wm_woocommerce_assets', 99 );



			/**
			* Output WooCommerce content.
			*
			* This function is only used in the optional 'woocommerce.php' template
			* which people can add to their themes to add basic woocommerce support
			* without using hooks or modifying core templates.
			*
			* @access public
			* @return void
			*
			* WM: OVERRIDE
			* Just removed H1 tag
			*/
			function woocommerce_content() {

				if ( is_singular( 'product' ) ) {

					while ( have_posts() ) : the_post();

						woocommerce_get_template_part( 'content', 'single-product' );

					endwhile;

				} else {

					//Just removed H1 tag

					do_action( 'woocommerce_archive_description' ); ?>

					<?php if ( have_posts() ) : ?>

						<?php do_action('woocommerce_before_shop_loop'); ?>

						<?php woocommerce_product_loop_start(); ?>

							<?php woocommerce_product_subcategories(); ?>

							<?php while ( have_posts() ) : the_post(); ?>

								<?php woocommerce_get_template_part( 'content', 'product' ); ?>

							<?php endwhile; // end of the loop. ?>

						<?php woocommerce_product_loop_end(); ?>

						<?php do_action('woocommerce_after_shop_loop'); ?>

					<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

						<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

					<?php endif;

				}
			} // /woocommerce_content



			/**
			* Get the product thumbnail, or the placeholder if not set.
			*
			* @access public
			* @subpackage	Loop
			* @param string $size (default: 'shop_catalog')
			* @param int $placeholder_width (default: 0)
			* @param int $placeholder_height (default: 0)
			* @return string
			*
			* WM: OVERRIDE
			* Added permalink
			*/
			function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
				global $post;

				if ( has_post_thumbnail() )
					return '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID, $size ) . '</a>';
				elseif ( woocommerce_placeholder_img_src() )
					return '<a href="' . get_permalink() . '">' . woocommerce_placeholder_img( $size ) . '</a>';
			} // woocommerce_get_product_thumbnail



			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 );

		}

?>