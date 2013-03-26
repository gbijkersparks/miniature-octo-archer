<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* CSS stylesheet generator
*****************************************************
*/

	//include WP core
		require_once '../../../../../wp-load.php';





/*
*****************************************************
*      OUTPUT
*****************************************************
*/

	$out = '';

	ob_start(); //This function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.



	$themeSkin   = ( wm_option( 'design-skin' ) ) ? ( wm_option( 'design-skin' ) ) : ( 'default.css' );
	$layoutWidth = ( wm_option( 'general-width' ) ) ? ( wm_option( 'general-width' ) ) : ( 'r940' );
	$fontFile    = ( ! file_exists( '../font/custom/css/fontello-codes.css' ) ) ? ( array( 'icons-font.css', '../font/fontello/css/fontello-codes.css' ) ) : ( array( 'icons-font-custom.css', '../font/custom/css/fontello-codes.css' ) );

	//Start including files and editing output
		@readfile( 'google-fonts.css' );
		@readfile( 'normalize.css' );
		@readfile( 'icons-basic.css' );
		@readfile( $fontFile[0] );
		@readfile( $fontFile[1] );
		@readfile( 'core.css' );
		@readfile( 'columns-content.css' );
		@readfile( 'columns-' . $layoutWidth . '.css' );
		@readfile( 'wp-styles.css' );
		@readfile( 'forms.css' );
		if ( function_exists( 'wpcf7_enqueue_scripts' ) )
			@readfile( 'forms-wpcf7.css' );
		if ( function_exists( 'gravity_form_enqueue_scripts' ) )
			@readfile( 'forms-gravity.css' );
		@readfile( 'typography.css' );
		@readfile( 'headings.css' );
		@readfile( 'header.css' );
		@readfile( 'slider.css' );
		@readfile( 'content.css' );
		@readfile( 'comments.css' );
		@readfile( 'sidebar.css' );
		@readfile( 'footer.css' );
		@readfile( 'prettyphoto.css' );
		@readfile( 'shortcodes.css' );
		@readfile( 'borders.css' );
		@readfile( 'skins/' . $themeSkin );
		if ( class_exists( 'Woocommerce' ) )
			@readfile( 'woocommerce.css' );
		if ( 'r940' === $layoutWidth || 'r1160' === $layoutWidth )
			@readfile( 'responsive.css' );
		@readfile( 'high-dpi.css' );

	//Stop including files and editing output
		$out = ob_get_clean(); //output and clean the buffer





/*
*****************************************************
*      CUSTOM STYLES FROM ADMIN PANEL
*****************************************************
*/

	/**
	* Compare skin and default elements returning CSS selectors string
	*
	* @param $skin    [STRING: string of elements from theme skin (every element must be prepended with - or +)]
	* @param $default [ARRAY: array of default theme elements to compare]
	*/
	if ( ! function_exists( 'wm_compare_elements' ) ) {
		function wm_compare_elements( $skin = '', $default = array() ) {
			$output = '';

			//make the skin elements array
			$skin      = array_filter( explode( ', ', $skin ) );
			$separator = ( ! empty( $default ) ) ? ( ', ' ) : ( '' );

			if ( ! empty( $skin ) ) {
			//if skin elements defined

				$default = array_flip( $default ); //prepare array for removing items

				foreach ( $skin as $value ) {
					$action = substr( $value, 0, 1 ); //whether to subtract (-) or add (+) elements

					if ( '-' == $action )
						unset( $default[substr( $value, 1 )] );
					else
						$output .= substr( $value, 1 ) . $separator;
				}

				$output .= implode( ', ', array_flip( $default ) );

			} else {
			//if skin elements not defined, use default theme elements

				$output .= implode( ', ', $default );

			}

			return $output;
		}
	} // /wm_compare_elements



	// E in variable names below stands for "Elements", BE stands for "BorderedElements"
	//fonts
		$themePrimaryFontE   = array( 'body', '.font-primary', '.logo', 'h1.logo', '.quote-source', 'input', 'select', 'textarea', '.btn', 'a.btn', '.nav-main .btn', 'button', 'input[type="button"]', 'input[type="submit"]' );
		$themeSecondaryFontE = array( '.font-secondary', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.hero', '.call-to-action', 'blockquote', '.countdown-timer .dash .digit', '.numbering', '.article-excerpt' );

		$primaryFontE   = wm_compare_elements( wm_skin_meta( $themeSkin, 'font-primary-tags' ), $themePrimaryFontE );
		$secondaryFontE = wm_compare_elements( wm_skin_meta( $themeSkin, 'font-secondary-tags' ), $themeSecondaryFontE );

	//borders
		/* anywhere bordered elements (from borders.css):
			'.wrap-projects-shortcode .wrap-filter li',
			'td', 'th', '.table-bordered', '.table-bordered th:first-child', '.table-bordered td:first-child', '.table-bordered th', '.table-bordered td',
			'.accordion-wrapper > ul', '.accordion-heading', '.toggle-heading', '.accordion-content', '.toggle-content',
			'.frame',
			'.pagination a', '.pagination span', '.pagination .wp-pagenavi a', '.pagination .wp-pagenavi a:hover', '.pagination .wp-pagenavi span.current', '.pagination .wp-pagenavi span',
			'.box.no-background', '.box.no-background[class*="color-"]',
			'blockquote.left-border',
			'.wrap-staff-shortcode .staff-excerpt ul',
			'.tabs-wrapper ul.tabs li', '.tabs-wrapper .tabs + ul > li', '.vertical ul.tabs li',
			'.tour-nav',
			'.wm-posts-list .image-container', '.wm-projects-list .portfolio-content article',
			'button', 'input', 'select', 'textarea',
		*/
		$themeToppanelBE = array(
			'.top-bar .widget li li'
			);
		$themeHeaderBE = array();
		$themeNavigationBE = array(
			'.header .nav-main li li'
			);
		$themeSliderBE = array(
			'.map-section'
			);
		$themeMainheadingBE = array();
		$themePageexcerptBE = array(
			/* movable border elements */
			'.page-excerpt .wrap-projects-shortcode .wrap-filter li',
			'.page-excerpt td', '.page-excerpt th', '.page-excerpt .table-bordered', '.page-excerpt .table-bordered th:first-child', '.page-excerpt .table-bordered td:first-child', '.page-excerpt .table-bordered th', '.page-excerpt .table-bordered td',
			'.page-excerpt .accordion-wrapper > ul', '.page-excerpt .accordion-heading', '.page-excerpt .toggle-heading', '.page-excerpt .accordion-content', '.page-excerpt .toggle-content',
			'.page-excerpt .frame',
			'.page-excerpt .pagination a', '.page-excerpt .pagination span', '.page-excerpt .pagination .wp-pagenavi a', '.page-excerpt .pagination .wp-pagenavi a:hover', '.page-excerpt .pagination .wp-pagenavi span.current', '.page-excerpt .pagination .wp-pagenavi span',
			'.page-excerpt .box.no-background', '.page-excerpt .box.no-background[class*="color-"]',
			'.page-excerpt blockquote.left-border',
			'.page-excerpt .wrap-staff-shortcode .staff-excerpt ul',
			'.page-excerpt .tabs-wrapper ul.tabs li', '.page-excerpt .tabs-wrapper .tabs + ul > li', '.page-excerpt .vertical ul.tabs li',
			'.page-excerpt .tour-nav',
			'.page-excerpt .wm-posts-list .image-container', '.page-excerpt .wm-projects-list .portfolio-content article',
			'.page-excerpt button', '.page-excerpt input', '.page-excerpt select', '.page-excerpt textarea',
			);
		$themeContentBE = array(
			/* article meta info */
			'.single-post .meta-article', '.meta-bottom', '#comments', '.content div.sharedaddy',
			/* attributes */
			'.attributes ul',
			/* author info */
			'.avatar', '.bio .author-info', '.bio .author-social-links',
			/* comments */
			'.commentlist li.comment', '.commentlist li li.comment', '.commentlist li.comment:last-child', '.commentlist li li.comment',
			/* image captions */
			'.wp-caption figure',
			/* preformated text */
			'pre',
			/* sitemap */
			'.sitemap-menu', '.sitemap-menu a',
			/* movable border elements */
			'.content .wrap-projects-shortcode .wrap-filter li',
			'.content td', '.content th', '.content .table-bordered', '.content .table-bordered th:first-child', '.content .table-bordered td:first-child', '.content .table-bordered th', '.content .table-bordered td',
			'.content .accordion-wrapper > ul', '.content .accordion-heading', '.content .toggle-heading', '.content .accordion-content', '.content .toggle-content',
			'.content .frame',
			'.content .pagination a', '.content .pagination span', '.content .pagination .wp-pagenavi a', '.content .pagination .wp-pagenavi a:hover', '.content .pagination .wp-pagenavi span.current', '.content .pagination .wp-pagenavi span',
			'.content .box.no-background', '.content .box.no-background[class*="color-"]',
			'.content blockquote.left-border',
			'.content .wrap-staff-shortcode .staff-excerpt ul',
			'.content .tabs-wrapper ul.tabs li', '.content .tabs-wrapper .tabs + ul > li', '.content .vertical ul.tabs li',
			'.content .tour-nav',
			'.content .wm-posts-list .image-container', '.content .wm-projects-list .portfolio-content article',
			'.content button', '.content input', '.content select', '.content textarea',
			);
		$themeAbovefooterBE = array(
			/* movable border elements */
			'.above-footer-widgets-wrap .wrap-projects-shortcode .wrap-filter li',
			'.above-footer-widgets-wrap td', '.above-footer-widgets-wrap th', '.above-footer-widgets-wrap .table-bordered', '.above-footer-widgets-wrap .table-bordered th:first-child', '.above-footer-widgets-wrap .table-bordered td:first-child', '.above-footer-widgets-wrap .table-bordered th', '.above-footer-widgets-wrap .table-bordered td',
			'.above-footer-widgets-wrap .accordion-wrapper > ul', '.above-footer-widgets-wrap .accordion-heading', '.above-footer-widgets-wrap .toggle-heading', '.above-footer-widgets-wrap .accordion-content', '.above-footer-widgets-wrap .toggle-content',
			'.above-footer-widgets-wrap .frame',
			'.above-footer-widgets-wrap .pagination a', '.above-footer-widgets-wrap .pagination span', '.above-footer-widgets-wrap .pagination .wp-pagenavi a', '.above-footer-widgets-wrap .pagination .wp-pagenavi a:hover', '.above-footer-widgets-wrap .pagination .wp-pagenavi span.current', '.above-footer-widgets-wrap .pagination .wp-pagenavi span',
			'.above-footer-widgets-wrap .box.no-background', '.above-footer-widgets-wrap .box.no-background[class*="color-"]',
			'.above-footer-widgets-wrap blockquote.left-border',
			'.above-footer-widgets-wrap .wrap-staff-shortcode .staff-excerpt ul',
			'.above-footer-widgets-wrap .tabs-wrapper ul.tabs li', '.above-footer-widgets-wrap .tabs-wrapper .tabs + ul > li', '.above-footer-widgets-wrap .vertical ul.tabs li',
			'.above-footer-widgets-wrap .tour-nav',
			'.above-footer-widgets-wrap .wm-posts-list .image-container', '.above-footer-widgets-wrap .wm-projects-list .portfolio-content article',
			'.above-footer-widgets-wrap button', '.above-footer-widgets-wrap input', '.above-footer-widgets-wrap select', '.above-footer-widgets-wrap textarea',
			);
		$themeBreadcrumbsBE = array();
		$themeFooterBE = array(
			/* movable border elements */
			'.footer .wrap-projects-shortcode .wrap-filter li',
			'.footer td', '.footer th', '.footer .table-bordered', '.footer .table-bordered th:first-child', '.footer .table-bordered td:first-child', '.footer .table-bordered th', '.footer .table-bordered td',
			'.footer .accordion-wrapper > ul', '.footer .accordion-heading', '.footer .toggle-heading', '.footer .accordion-content', '.footer .toggle-content',
			'.footer .frame',
			'.footer .pagination a', '.footer .pagination span', '.footer .pagination .wp-pagenavi a', '.footer .pagination .wp-pagenavi a:hover', '.footer .pagination .wp-pagenavi span.current', '.footer .pagination .wp-pagenavi span',
			'.footer .box.no-background', '.footer .box.no-background[class*="color-"]',
			'.footer blockquote.left-border',
			'.footer .wrap-staff-shortcode .staff-excerpt ul',
			'.footer .tabs-wrapper ul.tabs li', '.footer .tabs-wrapper .tabs + ul > li', '.footer .vertical ul.tabs li',
			'.footer .tour-nav',
			'.footer .wm-posts-list .image-container', '.footer .wm-projects-list .portfolio-content article',
			'.footer button', '.footer input', '.footer select', '.footer textarea',
			);
		$themeBottomBE = array();

		//WooCommerce borders
		if ( class_exists( 'Woocommerce' ) )
			array_push( $themeContentBE,
					'.content .woocommerce-tabs ul.tabs li',
					'.product_meta',
					//and these are from woocommerce.css:
					'.content div.product div.images img',
					'.content ul.products li.product a img',
					'.content .woocommerce-tabs > div',
					'.content form.login',
					'.content form.checkout_coupon',
					'.content form.register',
					'.content .addresses .column',
					'.content ul.cart_list li img',
					'.content ul.product_list_widget li img',
					'.content .widget_layered_nav ul small.count',
					'.content ul.cart_list li',
					'.content ul.product_list_widget li',
					'.content .order_details li',
					'.content table.shop_attributes',
					'.content .group_table',
					'.content #reviews #comments > div[itemprop]',
					'.content ul.cart_list li dl',
					'.content ul.product_list_widget li dl'
				);

		$toppanelBE    = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-toppanel' ), $themeToppanelBE );
		$headerBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-header' ), $themeHeaderBE );
		$navigationBE  = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-navigation' ), $themeNavigationBE );
		$sliderBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-slider' ), $themeSliderBE );
		$mainheadingBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-mainheading' ), $themeMainheadingBE );
		$pageexcerptBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-pageexcerpt' ), $themePageexcerptBE );
		$contentBE     = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-content' ), $themeContentBE );
		$abovefooterBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-abovefooter' ), $themeAbovefooterBE );
		$breadcrumbsBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-breadcrumbs' ), $themeBreadcrumbsBE );
		$footerBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-footer' ), $themeFooterBE );
		$bottomBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-bottom' ), $themeBottomBE );

	//text color calculations
		$textColorCoeficient = ( wm_option( 'design-text-color-coeficient' ) ) ? ( 2.55 * absint( wm_option( 'design-text-color-coeficient' ) + 50 ) ) : ( 170 );



	//Array of custom styles from admin panel
		$customStyles = array(

			/**
			* Accent color
			*/
				//basic link color (mainly applied in content area)
					array(
						'selector' => 'a, a:hover, .tp-caption .btn:hover',
						'styles'   => array(
							'color' => wm_option( 'design-accent-color', 'color' ),
							)
					),
				//default buttons
					array(
						'selector' => 'a.btn, .btn, .nav-main .btn, button, input[type="button"], input[type="submit"]',
						'styles'   => array(
							'background-color' => wm_option( 'design-accent-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-accent-color' ), $textColorCoeficient, -$textColorCoeficient ),
							'text-shadow'      => ( WM_COLOR_TRESHOLD < wm_color_brightness( wm_option( 'design-accent-color' ) ) ) ? ( '0 1px rgba(255,255,255, .33)' ) : ( '0 -1px rgba(0,0,0, .33)' ),
							'border-color'     => wm_modify_color( wm_option( 'design-accent-color' ), -17, -17 ),
							'background-image' => wm_css3_gradient( wm_option( 'design-accent-color' ), 32 ),
						)
					),
						array(
							'selector' => 'button, input[type="button"], input[type="submit"]',
							'styles'   => array(
								'background-color' => wm_option( 'design-accent-color', 'color' ),
								'border-color'     => wm_modify_color( wm_option( 'design-accent-color' ), -17, -17 ),
							)
						),
							array(
								'selector' => '.form-search input[type="submit"]',
								'styles'   => array(
									'background' => 'transparent !important',
									'border'     => '0 !important',
								)
							),
				//text selection
					array(
						'selector' => '::-moz-selection',
						'styles'   => array(
							'background-color' => wm_option( 'design-accent-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-accent-color' ), $textColorCoeficient, -$textColorCoeficient ),
						)
					),
					array(
						'selector' => '::selection',
						'styles'   => array(
							'background' => wm_option( 'design-accent-color', 'color' ),
							'color'      => wm_modify_color( wm_option( 'design-accent-color' ), $textColorCoeficient, -$textColorCoeficient ),
						)
					),
				//project icon, calendar widget, tags widget, sitemap menu
					array(
						'selector' => '.wrap-projects-shortcode .project-icon, #wp-calendar tbody a, .widget_tag_cloud .tagcloud a:hover, .sitemap-menu li a:hover',
						'styles'   => array(
							'background-color' => wm_option( 'design-accent-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-accent-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
					),
				//shortcodes
					array(
						'selector' => '.dropcap.round, .dropcap.square, .dropcap.leaf',
						'styles'   => array(
							'background-color' => wm_option( 'design-accent-color', 'color' ),
							)
					),
					array(
						'selector' => '.dropcap.round, .dropcap.square, .dropcap.leaf',
						'styles'   => array(
							'color' => wm_modify_color( wm_option( 'design-accent-color' ), 200, -200 ),
							)
					),
					array(
						'selector' => '.active > .accordion-heading, .active > .toggle-heading, .tabs-wrapper > ul > li.active, .page-excerpt .active > .accordion-heading, .page-excerpt .active > .toggle-heading, .page-excerpt .tabs-wrapper > ul > li.active, .content .active > .accordion-heading, .content .active > .toggle-heading, .content .tabs-wrapper > ul > li.active, .above-footer-widgets-wrap .active > .accordion-heading, .above-footer-widgets-wrap .active > .toggle-heading, .above-footer-widgets-wrap .tabs-wrapper > ul > li.active, .footer .active > .accordion-heading, .footer .active > .toggle-heading, .footer .tabs-wrapper > ul > li.active, .content .woocommerce-tabs > ul.tabs > li.active',
						'styles'   => array(
							'background-color' => ( wm_option( 'design-elements-color' ) ) ? ( wm_option( 'design-elements-color', 'color' ) ) : ( wm_option( 'design-accent-color', 'color' ) ),
							'background-image' => ( wm_option( 'design-elements-color' ) ) ? ( wm_css3_gradient( wm_option( 'design-elements-color' ), 15 ) ) : ( wm_css3_gradient( wm_option( 'design-accent-color' ), 15 ) ),
							'border-color'     => ( wm_option( 'design-elements-color' ) ) ? ( wm_option( 'design-elements-color', 'color' ) ) : ( wm_option( 'design-accent-color', 'color' ) ),
							'color'            => ( wm_option( 'design-elements-color' ) ) ? ( wm_modify_color( wm_option( 'design-elements-color' ), 200, -200 ) ) : ( wm_modify_color( wm_option( 'design-accent-color' ), 200, -200 ) ),
							)
					),
				//post formats
					array(
						'selector' => '.format-status, .format-link, .format-quote blockquote',
						'styles'   => array(
							'background-color' => wm_option( 'design-accent-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-accent-color' ), 255, -255 ),
							)
					),
						array(
							'selector' => '.format-quote cite:before',
							'styles'   => array(
								'border-right-color' => wm_option( 'design-accent-color', 'color' ),
								)
						),
				//WooCommerce accent color
					array(
						'selector' => 'div.product .price, div.product .stock, ul.products li.product .price, .cart-collaterals .cart_totals .discount td',
						'styles'   => array(
							'color' => ( class_exists( 'Woocommerce' ) ) ? ( wm_option( 'design-accent-color-woocommerce', 'color' ) ) : ( '' ),
							)
					),
					array(
						'selector' => 'li.product .pre-item-title a + a, li.product .pre-item-title a + a:hover, li.product .pre-item-title a + a:active, .star-rating span, p.stars span a:hover, p.stars span a:focus, p.stars span a.active, .widget_layered_nav ul li.chosen a, .widget_price_filter .ui-slider .ui-slider-range',
						'styles'   => array(
							'background-color' => ( class_exists( 'Woocommerce' ) ) ? ( wm_option( 'design-accent-color-woocommerce', 'color' ) ) : ( '' ),
							'color'            => ( class_exists( 'Woocommerce' ) ) ? ( wm_modify_color( wm_option( 'design-accent-color-woocommerce' ), $textColorCoeficient, -$textColorCoeficient ) ) : ( '' ),
							)
					),



			/**
			* Backgrounds and colors
			*/
				array(
					'selector' => '\r\n' //new linebreak
				),

				//html and body
					array(
						'selector' => 'html',
						'styles'   => array(
							'background-color' => ( wm_option( 'design-html-bg-color', 'color' ) && ! ( wm_option( 'design-html-bg-img-url' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_option( 'design-html-bg-color', 'color' ) ) : ( '' ),
							'background'       => ( ( wm_option( 'design-html-bg-img-url' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_css_background( 'design-html-' ) ) : ( '' ),
						)
					),
					array(
						'selector' => 'body',
						'styles'   => array(
							'background' => ( ( wm_option( 'design-body-bg-img-url' ) || wm_option( 'design-body-bg-pattern' ) ) ) ? ( wm_css_background( 'design-body-' ) ) : ( null ),
						)
					),



				//top bar (option prefix: toppanel)
					array(
						'selector' => '.top-bar .wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-toppanel-' ),
							'color'      => wm_option( 'design-toppanel-color', 'color' ),
						)
					),
					array(
						'selector' => '.top-bar a',
						'styles'   => array(
							'color' => wm_option( 'design-toppanel-accent-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $toppanelBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-toppanel-border-color' ) ) ? ( wm_option( 'design-toppanel-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-toppanel-bg-color' ), 34, -34 ) ),
							)
						),
					//forms
						array(
							'selector' => '.top-bar button, .top-bar input, .top-bar select, .top-bar textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-toppanel-bg-color' ), 8, -8 ),
							)
						),



				//header (option prefix: header)
					array(
						'selector' => '.header .wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-header-' ),
						)
					),
					array(
						'selector' => '.header, .logo .description, .header h1, .header h2, .header h3, .header h4, .header h5, .header h6',
						'styles'   => array(
							'color' => wm_option( 'design-header-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $headerBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-header-border-color' ) ) ? ( wm_option( 'design-header-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-header-bg-color' ), 34, -34 ) ),
							)
						),
					//forms
						array(
							'selector' => '.header button, .header input, .header select, .header textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-header-bg-color' ), 8, -8 ),
							)
						),



				//navigation (option prefix: navigation, subnavigation)
					array(
						'selector' => '.navigation-wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-navigation-' ),
						)
					),
					array(
						'selector' => '.nav-main, .nav-main a.normal small, .nav-main .inner.normal small',
						'styles'   => array(
							'color' => wm_option( 'design-navigation-color', 'color' ),
						)
					),
					//navigation
						array(
							'selector' => '.nav-main .inner:hover',
							'styles'   => array(
								'color' => ( wm_option( 'design-navigation-accent-color', 'color' ) ) ? ( wm_option( 'design-navigation-accent-color', 'color' ) ) : ( wm_option( 'design-accent-color', 'color' ) ),
								)
						),
						array(
							'selector' => '.nav-main li li:hover > a, .nav-main li li a:hover, .nav-main li li.current-menu-ancestor > a, .nav-main li li.current-menu-item > a',
							'styles'   => array(
								'border-left-color' => ( wm_option( 'design-navigation-accent-color', 'color' ) ) ? ( wm_option( 'design-navigation-accent-color', 'color' ) ) : ( wm_option( 'design-accent-color', 'color' ) ),
								)
						),
					//sub-menu
						array(
							'selector' => '.nav-main li ul',
							'styles'   => array(
								'background-color' => ( wm_option( 'design-subnavigation-bg-color' ) && ! wm_option( 'design-navigation-bg-color' ) ) ? ( wm_option( 'design-subnavigation-bg-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-navigation-bg-color' ), 8, -8 ) ),
								'color'            => wm_option( 'design-subnavigation-color', 'color' ),
							)
						),
						array(
							'selector' => '.header .nav-main li li',
							'styles'   => array(
								'border-color' => ( wm_option( 'design-navigation-border-color' ) ) ? ( wm_option( 'design-navigation-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-subnavigation-bg-color' ), 8, -8 ) ),
							)
						),
						array(
							'selector' => '.nav-main li li:hover > a, .nav-main li li a:hover, .nav-main li li.current-menu-ancestor > a, .nav-main li li.current-menu-item > a',
							'styles'   => array(
								'background-color' => ( wm_option( 'design-subnavigation-bg-color' ) ) ? ( wm_modify_color( wm_option( 'design-subnavigation-bg-color' ), 8, -8 ) ) : ( wm_modify_color( wm_option( 'design-navigation-bg-color' ), 17, -17 ) ),
							)
						),
					//borders
						array(
							'selector' => $navigationBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-navigation-border-color' ) ) ? ( wm_option( 'design-navigation-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-navigation-bg-color' ), 17, -17 ) ),
							)
						),



				//slider (option prefix: slider)
					array(
						'selector' => '.slider-main-wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-slider-' ),
							'color'      => wm_option( 'design-slider-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $sliderBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-slider-border-color' ) ) ? ( wm_option( 'design-slider-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-slider-bg-color' ), 34, -34 ) ),
							)
						),
							array(
								'selector' => '.slider hr.dashed, .slider hr.dotted, .slider hr.star',
								'styles'   => array(
									'border-color' => wm_modify_color( wm_option( 'design-slider-bg-color' ), 255, -255 ), //divider is eigher black or white
								)
							),



				//main heading (option prefix: mainheading)
					array(
						'selector' => '.main-heading',
						'styles'   => array(
							'background' => wm_css_background( 'design-mainheading-' ),
						)
					),
					array(
						'selector' => '.main-heading, .main-heading h1, .main-heading h2.h1-style, .main-heading h2',
						'styles'   => array(
							'color' => wm_option( 'design-mainheading-color', 'color' ),
						)
					),
					array(
						'selector' => '.main-heading h2',
						'styles'   => array(
							'color' => wm_option( 'design-mainheading-alt-color', 'color' ),
						)
					),
					array(
						'selector' => '.main-heading a',
						'styles'   => array(
							'color' => wm_option( 'design-mainheading-accent-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $mainheadingBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-mainheading-border-color' ) ) ? ( wm_option( 'design-mainheading-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-mainheading-bg-color' ), 34, -34 ) ),
							)
						),



				//breadcrumbs (option prefix: breadcrumbs)
					array(
						'selector' => '.breadcrumbs',
						'styles'   => array(
							'background' => wm_css_background( 'design-breadcrumbs-' ),
							'color'      => wm_option( 'design-breadcrumbs-color', 'color' ),
						)
					),
					array(
						'selector' => '.breadcrumbs a',
						'styles'   => array(
							'color' => wm_option( 'design-breadcrumbs-accent-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $breadcrumbsBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-breadcrumbs-border-color' ) ) ? ( wm_option( 'design-breadcrumbs-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-breadcrumbs-bg-color' ), 34, -34 ) ),
							)
						),
					//forms
						array(
							'selector' => '.breadcrumbs button, .breadcrumbs input, .breadcrumbs select, .breadcrumbs textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-breadcrumbs-bg-color' ), 8, -8 ),
							)
						),



				//page excerpt (option prefix: pageexcerpt)
					array(
						'selector' => '.page-excerpt, .countdown-timer-wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-pageexcerpt-' ),
						)
					),
					array(
						'selector' => '.page-excerpt, .countdown-timer-wrap',
						'styles'   => array(
							'color' => wm_option( 'design-pageexcerpt-color', 'color' ),
						)
					),
					array(
						'selector' => '.page-excerpt h1, .page-excerpt h2, .page-excerpt h3, .page-excerpt h4, .page-excerpt h5, .page-excerpt h6, .page-excerpt .size-big, .page-excerpt .size-huge, .countdown-timer-wrap h1, .countdown-timer-wrap h2, .countdown-timer-wrap h3, .countdown-timer-wrap h4, .countdown-timer-wrap h5, .countdown-timer-wrap h6, .countdown-timer-wrap .size-big, .countdown-timer-wrap .size-huge',
						'styles'   => array(
							'color' => ( wm_option( 'design-pageexcerpt-alt-color' ) ) ? ( wm_option( 'design-pageexcerpt-alt-color', 'color' ) ) : ( wm_option( 'design-pageexcerpt-color', 'color' ) ),
						)
					),
					array(
						'selector' => '.page-excerpt a, .countdown-timer-wrap a',
						'styles'   => array(
							'color' => wm_option( 'design-pageexcerpt-accent-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $pageexcerptBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-pageexcerpt-border-color' ) ) ? ( wm_option( 'design-pageexcerpt-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 34, -34 ) ),
							)
						),
							array(
								'selector' => '.page-excerpt hr.dashed, .page-excerpt hr.dotted, .page-excerpt hr.star',
								'styles'   => array(
									'border-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 255, -255 ), //divider is eigher black or white
								)
							),
					//forms
						array(
							'selector' => '.page-excerpt button, .page-excerpt input, .page-excerpt select, .page-excerpt textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 8, -8 ),
							)
						),
					//tabs, accordions, toggles
						array(
							'selector' => '.page-excerpt .tabs-wrapper ul.tabs li, .page-excerpt .accordion-heading, .page-excerpt .toggle-heading',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 8, -8 ),
								'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 8, -8 ), 15 ),
							)
						),
					//price table defaults, project page, staff page, login shortcode
						array(
							'selector' => '.page-excerpt .price-heading, .page-excerpt .price-column .bottom, .page-excerpt .price-spec li:nth-child(even), .staff-card, .page-excerpt .wrap-login',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 17, -17 ),
							)
						),
							array(
								'selector' => '.lie8 .page-excerpt .price-spec li.even',
								'styles'   => array(
									'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
								)
							),
						array(
							'selector' => '.page-excerpt .price-column.legend .price-spec li',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 17, -17 ),
							)
						),
						array(
							'selector' => '.page-excerpt .price-heading h3',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 25, -25 ),
								'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 25, -25 ), 32 ),
							)
						),
					//separator heading
						array(
							'selector' => '.page-excerpt .separator-heading .text-holder',
							'styles'   => array(
								'background' => wm_css_background( 'design-pageexcerpt-' ),
							)
						),
					//testimonials
						array(
							'selector' => '.page-excerpt .wrap-testimonials-shortcode blockquote',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 17, -17 ),
								)
						),
							array(
								'selector' => '.page-excerpt .wrap-testimonials-shortcode .testimonial-source:before',
								'styles'   => array(
									'border-right-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 17, -17 ),
									)
							),



				//content (option prefix: content)
					array(
						'selector' => '.content, .content hr.star:after',
						'styles'   => array(
							'background' => wm_css_background( 'design-content-' ),
							'color'      => wm_option( 'design-content-color', 'color' ),
						)
					),
					array(
						'selector' => '.content .box.no-background',
						'styles'   => array(
							'color' => wm_option( 'design-content-color', 'color !important' ),
						)
					),
					array(
						'selector' => '.content h1, .content h2, .content h3, .content h4, .content h5, .content h6, .content .size-big, .content .size-huge',
						'styles'   => array(
							'color' => ( wm_option( 'design-content-alt-color' ) ) ? ( wm_option( 'design-content-alt-color', 'color' ) ) : ( wm_option( 'design-content-color', 'color' ) ),
						)
					),
					//borders
						array(
							'selector' => $contentBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-content-border-color' ) ) ? ( wm_option( 'design-content-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-content-bg-color' ), 34, -34 ) ),
							)
						),
							array(
								'selector' => '.content hr.dashed, .content hr.dotted, .content hr.star',
								'styles'   => array(
									'border-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 255, -255 ), //divider is eigher black or white
								)
							),
					//forms
						array(
							'selector' => '.content button, .content input, .content select, .content textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 8, -8 ),
							)
						),
					//tag cloud
						array(
							'selector' => '.content .widget_tag_cloud .tagcloud a',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 255, -255 ),
								'color'            => wm_modify_color( wm_option( 'design-content-bg-color' ), -255, 255 ),
							)
						),
					//articles list, countdown timer, section shortcode
						array(
							'selector' => '.content .list-articles .meta-article, .content .wrap-section.alt',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 8, -8 ),
							)
						),
						array(
							'selector' => '.content .list-articles article, .content .list-articles .meta-article',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
							)
						),
					//tabs, accordions, toggles
						array(
							'selector' => '.content .tabs-wrapper ul.tabs li, .content .accordion-heading, .content .toggle-heading, .woocommerce-tabs ul.tabs li',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 8, -8 ),
								'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'design-content-bg-color' ), 8, -8 ), 15 ),
							)
						),
					//price table defaults, project page, staff page, login shortcode, author biography
						array(
							'selector' => '.content .price-heading, .content .price-column .bottom, .content .price-spec li:nth-child(even), .lie8 .content .price-spec li.even, .content .meta-project, .content .staff-card, .content .wrap-login, .content .bio .author-info',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
							)
						),
							array(
								'selector' => '.lie8 .content .price-spec li.even',
								'styles'   => array(
									'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
								)
							),
							array(
								'selector' => '.content .meta-project a',
								'styles'   => array(
									'color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 200, -200 ),
								)
							),
						array(
							'selector' => '.content .price-column.legend .price-spec li',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
							)
						),
						array(
							'selector' => '.content .price-heading h3',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 25, -25 ),
								'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'design-content-bg-color' ), 25, -25 ), 32 ),
							)
						),
					//separator heading
						array(
							'selector' => '.content .separator-heading .text-holder',
							'styles'   => array(
								'background' => wm_css_background( 'design-content-' ),
							)
						),
					//testimonials
						array(
							'selector' => '.content .wrap-testimonials-shortcode blockquote',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
								)
						),
							array(
								'selector' => '.content .wrap-testimonials-shortcode .testimonial-source:before',
								'styles'   => array(
									'border-right-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
									)
							),
					//pagination
						array(
							'selector' => '.pagination a, .pagination span, .pagination .wp-pagenavi a, .pagination .wp-pagenavi span',
							'styles'   => array(
								'background' => wm_modify_color( wm_option( 'design-content-bg-color' ), 8, -8 ),
								'color'      => wm_option( 'design-content-color', 'color' ),
							)
						),
						array(
							'selector' => '.pagination a:hover, .pagination > span, .pagination a:active, .pagination .wp-pagenavi span.current',
							'styles'   => array(
								'background' => wm_modify_color( wm_option( 'design-content-bg-color' ), 17, -17 ),
							)
						),



				//above footer (option prefix: abovefooter)
					array(
						'selector' => '.above-footer-widgets-wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-abovefooter-' ),
							'color'      => wm_option( 'design-abovefooter-color', 'color' ),
						)
					),
						array(
							'selector' => '.above-footer-widgets-wrap .twelve',
							'styles'   => array(
								'padding-top' => ( wm_css_background( 'design-abovefooter-' ) || wm_css_background( 'design-content-' ) ) ? ( '40px' ) : ( '' ),
							)
						),
					array(
						'selector' => '.above-footer-widgets-wrap h1, .above-footer-widgets-wrap h2, .above-footer-widgets-wrap h3, .above-footer-widgets-wrap h4, .above-footer-widgets-wrap h5, .above-footer-widgets-wrap h6, .above-footer-widgets-wrap .size-big, .above-footer-widgets-wrap .size-huge',
						'styles'   => array(
							'color' => ( wm_option( 'design-abovefooter-alt-color' ) ) ? ( wm_option( 'design-abovefooter-alt-color', 'color' ) ) : ( wm_option( 'design-abovefooter-color', 'color' ) ),
						)
					),
					array(
						'selector' => '.above-footer-widgets-wrap a',
						'styles'   => array(
							'color' => wm_option( 'design-abovefooter-accent-color', 'color' ),
						)
					),
					//borders
						array(
							'selector' => $abovefooterBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-abovefooter-border-color' ) ) ? ( wm_option( 'design-abovefooter-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 34, -34 ) ),
							)
						),
							array(
								'selector' => '.above-footer-widgets-wrap hr.dashed, .above-footer-widgets-wrap hr.dotted, .above-footer-widgets-wrap hr.star',
								'styles'   => array(
									'border-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 255, -255 ), //divider is eigher black or white
								)
							),
					//forms
						array(
							'selector' => '.above-footer-widgets-wrap button, .above-footer-widgets-wrap input, .above-footer-widgets-wrap select, .above-footer-widgets-wrap textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 8, -8 ),
							)
						),
					//tabs, accordions, toggles
						array(
							'selector' => '.above-footer-widgets-wrap .tabs-wrapper ul.tabs li, .above-footer-widgets-wrap .accordion-heading, .above-footer-widgets-wrap .toggle-heading',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 8, -8 ),
								'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 8, -8 ), 15 ),
							)
						),
					//separator heading
						array(
							'selector' => '.above-footer-widgets-wrap .separator-heading .text-holder',
							'styles'   => array(
								'background' => wm_css_background( 'design-abovefooter-' ),
							)
						),
					//testimonials
						array(
							'selector' => '.above-footer-widgets-wrap .wrap-testimonials-shortcode blockquote',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 17, -17 ),
								)
						),
							array(
								'selector' => '.above-footer-widgets-wrap .wrap-testimonials-shortcode .testimonial-source:before',
								'styles'   => array(
									'border-right-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 17, -17 ),
									)
							),



				//footer (option prefix: footer)
					array(
						'selector' => '.footer',
						'styles'   => array(
							'background' => wm_css_background( 'design-footer-' ),
							'color'      => wm_option( 'design-footer-color', 'color' ),
						)
					),
					array(
						'selector' => '.footer h1, .footer h2, .footer h3, .footer h4, .footer h5, .footer h6, .footer .size-big, .footer .size-huge',
						'styles'   => array(
							'color' => ( wm_option( 'design-footer-alt-color' ) ) ? ( wm_option( 'design-footer-alt-color', 'color' ) ) : ( wm_option( 'design-footer-color', 'color' ) ),
						)
					),
					array(
						'selector' => '.footer a',
						'styles'   => array(
							'color' => wm_option( 'design-footer-accent-color', 'color' ),
						)
					),
						array(
							'selector' => '.footer a:hover',
							'styles'   => array(
								'color' => wm_modify_color( wm_option( 'design-footer-accent-color' ), 68, -68 ),
							)
						),
					//borders
						array(
							'selector' => $footerBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-footer-border-color' ) ) ? ( wm_option( 'design-footer-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-footer-bg-color' ), 34, -34 ) ),
							)
						),
							array(
								'selector' => '.footer hr.dashed, .footer hr.dotted, .footer hr.star',
								'styles'   => array(
									'border-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 255, -255 ), //divider is eigher black or white
								)
							),
					//forms
						array(
							'selector' => '.footer button, .footer input, .footer select, .footer textarea',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 8, -8 ),
							)
						),
					//tabs, accordions, toggles
						array(
							'selector' => '.footer .tabs-wrapper ul.tabs li, .footer .accordion-heading, .footer .toggle-heading',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 8, -8 ),
								'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'design-footer-bg-color' ), 8, -8 ), 15 ),
							)
						),
					//tag cloud
						array(
							'selector' => '.footer .widget_tag_cloud .tagcloud a',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 255, -255 ),
								'color'            => wm_modify_color( wm_option( 'design-footer-bg-color' ), -255, 255 ),
							)
						),
					//separator heading
						array(
							'selector' => '.footer .separator-heading .text-holder',
							'styles'   => array(
								'background' => wm_css_background( 'design-footer-' ),
							)
						),
					//testimonials
						array(
							'selector' => '.footer .wrap-testimonials-shortcode blockquote',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 17, -17 ),
								)
						),
							array(
								'selector' => '.footer .wrap-testimonials-shortcode .testimonial-source:before',
								'styles'   => array(
									'border-right-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 17, -17 ),
									)
							),



				//bottom panel - credits (option prefix: bottom)
					array(
						'selector' => '.bottom-wrap',
						'styles'   => array(
							'background' => wm_css_background( 'design-bottom-' ),
							'color'      => wm_option( 'design-bottom-color', 'color' ),
						)
					),
						array(
							'selector' => '.bottom-wrap a',
							'styles'   => array(
								'color' => wm_option( 'design-bottom-accent-color', 'color' ),
							)
						),
							array(
								'selector' => '.bottom-wrap a:hover',
								'styles'   => array(
									'color' => wm_modify_color( wm_option( 'design-bottom-accent-color' ), -34, 34 ),
								)
							),
					//borders
						array(
							'selector' => $bottomBE,
							'styles'   => array(
								'border-color' => ( wm_option( 'design-bottom-border-color' ) ) ? ( wm_option( 'design-bottom-border-color', 'color' ) ) : ( wm_modify_color( wm_option( 'design-bottom-bg-color' ), 34, -34 ) ),
							)
						),



			/**
			* Predefined colors for colored elements - blue, gray, green, orange, red
			*/
				//blue
					array(
						'selector' => '.box.color-blue, .btn.color-blue, .button.color-blue, .call-to-action.color-blue, .marker.color-blue, .call-to-action-title.blue',
						'styles'   => array(
							'background-color' => wm_option( 'design-type-blue-bg-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-type-blue-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							'text-shadow'      => ( WM_COLOR_TRESHOLD < wm_color_brightness( wm_option( 'design-type-blue-bg-color' ) ) ) ? ( '0 1px rgba(255,255,255, .33)' ) : ( '0 -1px rgba(0,0,0, .33)' ),
						)
					),
						array(
							'selector' => '.box.color-blue, .btn.color-blue, .button.color-blue',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-type-blue-bg-color' ), -17, -17 ),
							)
						),
						array(
							'selector' => '.btn.color-blue, .button.color-blue',
							'styles'   => array(
								'background-image' => wm_css3_gradient( wm_option( 'design-type-blue-bg-color' ), 32 ),
							)
						),
						array(
							'selector' => '.call-to-action-title.blue',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-blue-bg-color' ), 17, 17 ),
							)
						),
						array(
							'selector' => '.nav-main > ul > li > .btn.color-blue:hover, .tp-caption .btn.color-blue:hover',
							'styles'   => array(
								'color' => wm_modify_color( wm_option( 'design-type-blue-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),
						array(
							'selector' => '.box.color-blue > h1:first-child, .box.color-blue > h2:first-child',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-blue-bg-color' ), -17, -17 ),
								'color'            => wm_modify_color( wm_modify_color( wm_option( 'design-type-blue-bg-color' ), -17, -17 ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),

				//gray
					array(
						'selector' => '.box.color-gray, .btn.color-gray, .button.color-gray, .call-to-action.color-gray, .marker.color-gray, .call-to-action-title.gray, .button, .button:hover, .button:active, .widget_product_search input[type="submit"], .quantity input[type="button"]',
						'styles'   => array(
							'background-color' => wm_option( 'design-type-gray-bg-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-type-gray-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							'text-shadow'      => ( WM_COLOR_TRESHOLD < wm_color_brightness( wm_option( 'design-type-gray-bg-color' ) ) ) ? ( '0 1px rgba(255,255,255, .33)' ) : ( '0 -1px rgba(0,0,0, .33)' ),
						)
					),
						array(
							'selector' => '.box.color-gray, .btn.color-gray, .button.color-gray, .button, .widget_product_search input[type="submit"], .quantity input[type="button"]',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-type-gray-bg-color' ), -17, -17 ),
							)
						),
						array(
							'selector' => '.btn.color-gray, .button.color-gray, .button, .widget_product_search input[type="submit"], .quantity input[type="button"]',
							'styles'   => array(
								'background-image' => wm_css3_gradient( wm_option( 'design-type-gray-bg-color' ), 32 ),
							)
						),
						array(
							'selector' => '.call-to-action-title.gray',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-gray-bg-color' ), 17, 17 ),
							)
						),
						array(
							'selector' => '.nav-main > ul > li > .btn.color-gray:hover, .tp-caption .btn.color-gray:hover',
							'styles'   => array(
								'color' => wm_modify_color( wm_option( 'design-type-gray-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),
						array(
							'selector' => '.box.color-gray > h1:first-child, .box.color-gray > h2:first-child',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-gray-bg-color' ), -17, -17 ),
								'color'            => wm_modify_color( wm_modify_color( wm_option( 'design-type-gray-bg-color' ), -17, -17 ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),

				//green
					array(
						'selector' => '.box.color-green, .btn.color-green, .button.color-green, .call-to-action.color-green, .marker.color-green, .call-to-action-title.green, .button.alt, .button.checkout',
						'styles'   => array(
							'background-color' => wm_option( 'design-type-green-bg-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-type-green-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							'text-shadow'      => ( WM_COLOR_TRESHOLD < wm_color_brightness( wm_option( 'design-type-green-bg-color' ) ) ) ? ( '0 1px rgba(255,255,255, .33)' ) : ( '0 -1px rgba(0,0,0, .33)' ),
						)
					),
						array(
							'selector' => '.box.color-green, .btn.color-green, .button.color-green, .button.alt, .button.checkout',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-type-green-bg-color' ), -17, -17 ),
							)
						),
						array(
							'selector' => ' .btn.color-green, .button.color-green, .button.alt, .button.checkout',
							'styles'   => array(
								'background-image' => wm_css3_gradient( wm_option( 'design-type-green-bg-color' ), 32 ),
							)
						),
						array(
							'selector' => '.call-to-action-title.green',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-green-bg-color' ), 17, 17 ),
							)
						),
						array(
							'selector' => '.nav-main > ul > li > .btn.color-green:hover, .tp-caption .btn.color-green:hover',
							'styles'   => array(
								'color' => wm_modify_color( wm_option( 'design-type-green-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),
						array(
							'selector' => '.box.color-green > h1:first-child, .box.color-green > h2:first-child',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-green-bg-color' ), -17, -17 ),
								'color'            => wm_modify_color( wm_modify_color( wm_option( 'design-type-green-bg-color' ), -17, -17 ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),

				//orange
					array(
						'selector' => '.box.color-orange, .btn.color-orange, .button.color-orange, .call-to-action.color-orange, .marker.color-orange, .call-to-action-title.orange',
						'styles'   => array(
							'background-color' => wm_option( 'design-type-orange-bg-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-type-orange-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							'text-shadow'      => ( WM_COLOR_TRESHOLD < wm_color_brightness( wm_option( 'design-type-orange-bg-color' ) ) ) ? ( '0 1px rgba(255,255,255, .33)' ) : ( '0 -1px rgba(0,0,0, .33)' ),
						)
					),
						array(
							'selector' => '.box.color-orange, .btn.color-orange, .button.color-orange',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-type-orange-bg-color' ), -17, -17 ),
							)
						),
						array(
							'selector' => '.btn.color-orange, .button.color-orange',
							'styles'   => array(
								'background-image' => wm_css3_gradient( wm_option( 'design-type-orange-bg-color' ), 32 ),
							)
						),
						array(
							'selector' => '.call-to-action-title.orange',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-orange-bg-color' ), 17, 17 ),
							)
						),
						array(
							'selector' => '.nav-main > ul > li > .btn.color-orange:hover, .tp-caption .btn.color-orange:hover',
							'styles'   => array(
								'color' => wm_modify_color( wm_option( 'design-type-orange-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),
						array(
							'selector' => '.box.color-orange > h1:first-child, .box.color-orange > h2:first-child',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-orange-bg-color' ), -17, -17 ),
								'color'            => wm_modify_color( wm_modify_color( wm_option( 'design-type-orange-bg-color' ), -17, -17 ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),

				//red
					array(
						'selector' => '.box.color-red, .btn.color-red, .button.color-red, .call-to-action.color-red, .marker.color-red, .call-to-action-title.red',
						'styles'   => array(
							'background-color' => wm_option( 'design-type-red-bg-color', 'color' ),
							'color'            => wm_modify_color( wm_option( 'design-type-red-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							'text-shadow'      => ( WM_COLOR_TRESHOLD < wm_color_brightness( wm_option( 'design-type-red-bg-color' ) ) ) ? ( '0 1px rgba(255,255,255, .33)' ) : ( '0 -1px rgba(0,0,0, .33)' ),
						)
					),
						array(
							'selector' => '.box.color-red, .btn.color-red, .button.color-red',
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-type-red-bg-color' ), -17, -17 ),
							)
						),
						array(
							'selector' => '.btn.color-red, .button.color-red',
							'styles'   => array(
								'background-image' => wm_css3_gradient( wm_option( 'design-type-red-bg-color' ), 32 ),
							)
						),
						array(
							'selector' => '.call-to-action-title.red',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-red-bg-color' ), 17, 17 ),
							)
						),
						array(
							'selector' => '.nav-main > ul > li > .btn.color-red:hover, .tp-caption .btn.color-red:hover',
							'styles'   => array(
								'color' => wm_modify_color( wm_option( 'design-type-red-bg-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),
						array(
							'selector' => '.box.color-red > h1:first-child, .box.color-red > h2:first-child',
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-type-red-bg-color' ), -17, -17 ),
								'color'            => wm_modify_color( wm_modify_color( wm_option( 'design-type-red-bg-color' ), -17, -17 ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),



			/**
			* Paddings and heights
			*/
				array(
					'selector' => '\r\n' //new linebreak
				),
				array(
					'selector' => '.header .wrap > .wrap-inner',
					'styles'   => array(
						'min-height' => ( wm_option( 'header-height' ) ) ? ( absint( wm_option( 'header-height' ) ) . 'px' ) : ( null ),
					)
				),
					array(
						'selector' => '.header .wrap',
						'styles'   => array(
							'min-height' => ( wm_option( 'header-height' ) ) ? ( 'auto' ) : ( null ),
						)
					),
				array(
					'selector' => '.logo, h1.logo',
					'styles'   => array(
						'padding-top' => ( -1 < intval( wm_option( 'branding-logo-margin' ) ) ) ? ( intval( wm_option( 'branding-logo-margin' ) ) . 'px' ) : ( null ),
					)
				),
				array(
					'selector' => '.header-right',
					'styles'   => array(
						'padding-top' => ( -1 < intval( wm_option( 'header-right-margin' ) ) ) ? ( intval( wm_option( 'header-right-margin' ) ) . 'px' ) : ( null ),
					)
				),
				array(
					'selector' => '.nav-top .navigation-wrap, .nav-right .navigation-wrap, .nav-bottom .navigation-wrap',
					'styles'   => array(
						'padding-top' => ( -1 < intval( wm_option( 'header-navigation-margin' ) ) ) ? ( intval( wm_option( 'header-navigation-margin' ) ) . 'px' ) : ( null ),
					)
				),
					array(
						'selector' => '.nav-main > ul > li > .inner',
						'styles'   => array(
							'padding-bottom' => ( absint( wm_option( 'header-navigation-item-padding' ) ) ) ? ( absint( wm_option( 'header-navigation-item-padding' ) ) . 'px !important' ) : ( null ),
						)
					),



			/**
			* Fonts
			*/
				array(
					'selector' => '\r\n' //new linebreak
				),
				array(
					'selector' => $primaryFontE,
					'styles'   => array(
						'font-family' => ( wm_option( 'design-font-body-stack' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-' . wm_option( 'design-font-body-stack' ) ) ) ) : ( null ),
						'font-size'   => ( wm_option( 'design-font-body-size' ) ) ? ( wm_option( 'design-font-body-size' ) . 'px' ) : ( null ),
					)
				),
				array(
					'selector' => $secondaryFontE,
					'styles'   => array(
						'font-family' => ( wm_option( 'design-font-secondary' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-secondary' ) ) ) : ( null ),
					)
				),
				array(
					'selector' => 'h1, h2, h3, h4, h5, h6',
					'styles'   => array(
						'font-family' => ( wm_option( 'design-font-heading-stack' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-' . wm_option( 'design-font-heading-stack' ) ) ) ) : ( null ),
					)
				),



			/**
			* Responsive styles
			*/
				array(
					'custom' => '@media only screen and (max-width: 767px) {'
				),

					//navigation
						array(
							'selector' => '.nav-main > ul',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-header-bg-color' ), 8, -8 ),
							)
						),
						array(
							'selector' => '.nav-main li > a:hover, .nav-main li > .inner:hover',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-color' => wm_option( 'design-accent-color', 'color' ),
								'color'            => wm_modify_color( wm_option( 'design-accent-color' ), $textColorCoeficient, -$textColorCoeficient ),
							)
						),
							array(
								'selector' => '.nav-main li:hover > a',
								'indent'   => "\t\t",
								'styles'   => array(
									'background-color' => wm_modify_color( wm_option( 'design-header-bg-color' ), 17, -17 ),
								)
							),
						array(
							'selector' => '.nav-main > ul, .nav-main li a, .nav-main li li a, .nav-main li .inner',
							'indent'   => "\t\t",
							'styles'   => array(
								'border-color' => wm_modify_color( wm_option( 'design-header-bg-color' ), 17, -17, ' !important' ),
							)
						),

					//sidebar
						array(
							'selector' => '.sidebar, .sidebar .separator-heading .text-holder',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 8, -8 ),
							)
						),

					//tabs
						array(
							'selector' => '.page-excerpt ul.tabs li',
							'indent'   => "\t\t",
							'styles'   => array(
								'border-left-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 34, -34, ' !important' ),
								'border-bottom-color' => wm_modify_color( wm_option( 'design-pageexcerpt-bg-color' ), 34, -34, ' !important' ),
							)
						),
						array(
							'selector' => '.content ul.tabs li',
							'indent'   => "\t\t",
							'styles'   => array(
								'border-left-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 34, -34, ' !important' ),
								'border-bottom-color' => wm_modify_color( wm_option( 'design-content-bg-color' ), 34, -34, ' !important' ),
							)
						),
						array(
							'selector' => '.above-footer-widgets-wrap ul.tabs li',
							'indent'   => "\t\t",
							'styles'   => array(
								'border-left-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 34, -34, ' !important' ),
								'border-bottom-color' => wm_modify_color( wm_option( 'design-abovefooter-bg-color' ), 34, -34, ' !important' ),
							)
						),
						array(
							'selector' => '.footer ul.tabs li',
							'indent'   => "\t\t",
							'styles'   => array(
								'border-left-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 34, -34, ' !important' ),
								'border-bottom-color' => wm_modify_color( wm_option( 'design-footer-bg-color' ), 34, -34, ' !important' ),
							)
						),

				array(
					'custom' => '}' //end of responsive rules
				),



			/**
			* High DPI / Retina styles
			*/
				array(
					'custom' => '@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5), only screen and (min-resolution: 1.5dppx) {'
				),

					//html and body
						array(
							'selector' => 'html',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-html-bg-img-url-highdpi' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_css_background( 'design-html-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-html-bg-img-url-highdpi' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_css_background( 'design-html-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-html-bg-img-url-highdpi' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_css_background( 'design-html-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-html-bg-img-url-highdpi' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_css_background( 'design-html-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),
						array(
							'selector' => 'body',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-body-bg-img-url-highdpi' ) || wm_option( 'design-body-bg-pattern' ) ) ) ? ( wm_css_background( 'design-body-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-body-bg-img-url-highdpi' ) || wm_option( 'design-body-bg-pattern' ) ) ) ? ( wm_css_background( 'design-body-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-body-bg-img-url-highdpi' ) || wm_option( 'design-body-bg-pattern' ) ) ) ? ( wm_css_background( 'design-body-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-body-bg-img-url-highdpi' ) || wm_option( 'design-body-bg-pattern' ) ) ) ? ( wm_css_background( 'design-body-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//top bar (option prefix: toppanel)
						array(
							'selector' => '.top-bar .wrap',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-toppanel-bg-img-url-highdpi' ) || wm_option( 'design-toppanel-bg-pattern' ) ) ) ? ( wm_css_background( 'design-toppanel-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-toppanel-bg-img-url-highdpi' ) || wm_option( 'design-toppanel-bg-pattern' ) ) ) ? ( wm_css_background( 'design-toppanel-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-toppanel-bg-img-url-highdpi' ) || wm_option( 'design-toppanel-bg-pattern' ) ) ) ? ( wm_css_background( 'design-toppanel-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-toppanel-bg-img-url-highdpi' ) || wm_option( 'design-toppanel-bg-pattern' ) ) ) ? ( wm_css_background( 'design-toppanel-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//header (option prefix: header)
						array(
							'selector' => '.header .wrap',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-header-bg-img-url-highdpi' ) || wm_option( 'design-header-bg-pattern' ) ) ) ? ( wm_css_background( 'design-header-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-header-bg-img-url-highdpi' ) || wm_option( 'design-header-bg-pattern' ) ) ) ? ( wm_css_background( 'design-header-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-header-bg-img-url-highdpi' ) || wm_option( 'design-header-bg-pattern' ) ) ) ? ( wm_css_background( 'design-header-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-header-bg-img-url-highdpi' ) || wm_option( 'design-header-bg-pattern' ) ) ) ? ( wm_css_background( 'design-header-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//navigation (option prefix: navigation, subnavigation)
						array(
							'selector' => '.navigation-wrap',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-navigation-bg-img-url-highdpi' ) || wm_option( 'design-navigation-bg-pattern' ) ) ) ? ( wm_css_background( 'design-navigation-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-navigation-bg-img-url-highdpi' ) || wm_option( 'design-navigation-bg-pattern' ) ) ) ? ( wm_css_background( 'design-navigation-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-navigation-bg-img-url-highdpi' ) || wm_option( 'design-navigation-bg-pattern' ) ) ) ? ( wm_css_background( 'design-navigation-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-navigation-bg-img-url-highdpi' ) || wm_option( 'design-navigation-bg-pattern' ) ) ) ? ( wm_css_background( 'design-navigation-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//slider (option prefix: slider)
						array(
							'selector' => '.slider-main-wrap',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-slider-bg-img-url-highdpi' ) || wm_option( 'design-slider-bg-pattern' ) ) ) ? ( wm_css_background( 'design-slider-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-slider-bg-img-url-highdpi' ) || wm_option( 'design-slider-bg-pattern' ) ) ) ? ( wm_css_background( 'design-slider-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-slider-bg-img-url-highdpi' ) || wm_option( 'design-slider-bg-pattern' ) ) ) ? ( wm_css_background( 'design-slider-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-slider-bg-img-url-highdpi' ) || wm_option( 'design-slider-bg-pattern' ) ) ) ? ( wm_css_background( 'design-slider-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//main heading (option prefix: mainheading)
						array(
							'selector' => '.main-heading',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-mainheading-bg-img-url-highdpi' ) || wm_option( 'design-mainheading-bg-pattern' ) ) ) ? ( wm_css_background( 'design-mainheading-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-mainheading-bg-img-url-highdpi' ) || wm_option( 'design-mainheading-bg-pattern' ) ) ) ? ( wm_css_background( 'design-mainheading-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-mainheading-bg-img-url-highdpi' ) || wm_option( 'design-mainheading-bg-pattern' ) ) ) ? ( wm_css_background( 'design-mainheading-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-mainheading-bg-img-url-highdpi' ) || wm_option( 'design-mainheading-bg-pattern' ) ) ) ? ( wm_css_background( 'design-mainheading-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//breadcrumbs (option prefix: breadcrumbs)
						array(
							'selector' => '.breadcrumbs',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-breadcrumbs-bg-img-url-highdpi' ) || wm_option( 'design-breadcrumbs-bg-pattern' ) ) ) ? ( wm_css_background( 'design-breadcrumbs-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-breadcrumbs-bg-img-url-highdpi' ) || wm_option( 'design-breadcrumbs-bg-pattern' ) ) ) ? ( wm_css_background( 'design-breadcrumbs-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-breadcrumbs-bg-img-url-highdpi' ) || wm_option( 'design-breadcrumbs-bg-pattern' ) ) ) ? ( wm_css_background( 'design-breadcrumbs-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-breadcrumbs-bg-img-url-highdpi' ) || wm_option( 'design-breadcrumbs-bg-pattern' ) ) ) ? ( wm_css_background( 'design-breadcrumbs-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//page excerpt (option prefix: pageexcerpt)
						array(
							'selector' => '.page-excerpt, .countdown-timer-wrap, .page-excerpt .separator-heading .text-holder',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-pageexcerpt-bg-img-url-highdpi' ) || wm_option( 'design-pageexcerpt-bg-pattern' ) ) ) ? ( wm_css_background( 'design-pageexcerpt-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-pageexcerpt-bg-img-url-highdpi' ) || wm_option( 'design-pageexcerpt-bg-pattern' ) ) ) ? ( wm_css_background( 'design-pageexcerpt-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-pageexcerpt-bg-img-url-highdpi' ) || wm_option( 'design-pageexcerpt-bg-pattern' ) ) ) ? ( wm_css_background( 'design-pageexcerpt-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-pageexcerpt-bg-img-url-highdpi' ) || wm_option( 'design-pageexcerpt-bg-pattern' ) ) ) ? ( wm_css_background( 'design-pageexcerpt-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//content (option prefix: content)
						array(
							'selector' => '.content, .content hr.star:after, .separator-heading .text-holder',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-content-bg-img-url-highdpi' ) || wm_option( 'design-content-bg-pattern' ) ) ) ? ( wm_css_background( 'design-content-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-content-bg-img-url-highdpi' ) || wm_option( 'design-content-bg-pattern' ) ) ) ? ( wm_css_background( 'design-content-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-content-bg-img-url-highdpi' ) || wm_option( 'design-content-bg-pattern' ) ) ) ? ( wm_css_background( 'design-content-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-content-bg-img-url-highdpi' ) || wm_option( 'design-content-bg-pattern' ) ) ) ? ( wm_css_background( 'design-content-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//above footer (option prefix: abovefooter)
						array(
							'selector' => '.above-footer-widgets-wrap, .above-footer-widgets-wrap .separator-heading .text-holder',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-abovefooter-bg-img-url-highdpi' ) || wm_option( 'design-abovefooter-bg-pattern' ) ) ) ? ( wm_css_background( 'design-abovefooter-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-abovefooter-bg-img-url-highdpi' ) || wm_option( 'design-abovefooter-bg-pattern' ) ) ) ? ( wm_css_background( 'design-abovefooter-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-abovefooter-bg-img-url-highdpi' ) || wm_option( 'design-abovefooter-bg-pattern' ) ) ) ? ( wm_css_background( 'design-abovefooter-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-abovefooter-bg-img-url-highdpi' ) || wm_option( 'design-abovefooter-bg-pattern' ) ) ) ? ( wm_css_background( 'design-abovefooter-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//footer (option prefix: footer)
						array(
							'selector' => '.footer, .footer .separator-heading .text-holder',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-footer-bg-img-url-highdpi' ) || wm_option( 'design-footer-bg-pattern' ) ) ) ? ( wm_css_background( 'design-footer-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-footer-bg-img-url-highdpi' ) || wm_option( 'design-footer-bg-pattern' ) ) ) ? ( wm_css_background( 'design-footer-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-footer-bg-img-url-highdpi' ) || wm_option( 'design-footer-bg-pattern' ) ) ) ? ( wm_css_background( 'design-footer-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-footer-bg-img-url-highdpi' ) || wm_option( 'design-footer-bg-pattern' ) ) ) ? ( wm_css_background( 'design-footer-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

					//bottom panel - credits (option prefix: bottom)
						array(
							'selector' => '.bottom-wrap',
							'indent'   => "\t\t",
							'styles'   => array(
								'background-image'        => ( ( wm_option( 'design-bottom-bg-img-url-highdpi' ) || wm_option( 'design-bottom-bg-pattern' ) ) ) ? ( wm_css_background( 'design-bottom-', array( 'out' => 'image', 'high-dpi' => true ) ) ) : ( '' ),
								'-webkit-background-size' => ( ( wm_option( 'design-bottom-bg-img-url-highdpi' ) || wm_option( 'design-bottom-bg-pattern' ) ) ) ? ( wm_css_background( 'design-bottom-', array( 'out' => 'size' ) ) ) : ( '' ),
								'-moz-background-size'    => ( ( wm_option( 'design-bottom-bg-img-url-highdpi' ) || wm_option( 'design-bottom-bg-pattern' ) ) ) ? ( wm_css_background( 'design-bottom-', array( 'out' => 'size' ) ) ) : ( '' ),
								'background-size'         => ( ( wm_option( 'design-bottom-bg-img-url-highdpi' ) || wm_option( 'design-bottom-bg-pattern' ) ) ) ? ( wm_css_background( 'design-bottom-', array( 'out' => 'size' ) ) ) : ( '' ),
							)
						),

				array(
					'custom' => '}' //end of responsive rules
				),

		); // /$customStyles



	//Generate CSS output
		if ( ! empty( $customStyles ) && 2 === intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) {
			$outStyles = '';

			foreach ( $customStyles as $selector ) {
				if (
						isset( $selector['selector'] ) &&
						$selector['selector'] &&
						isset( $selector['styles'] ) &&
						is_array( $selector['styles'] ) &&
						! empty( $selector['styles'] )
					) {
					$selectorStyles = '';
					$indent = ( isset( $selector['indent'] ) ) ? ( $selector['indent'] ) : ( '' );

					foreach ( $selector['styles'] as $property => $style ) {
						if ( isset( $style ) && $style )
							$selectorStyles .= $indent . "\t" . $property . ': ' . $style . ';' . "\r\n";
					}

					if ( $selectorStyles )
						$outStyles .= $indent . $selector['selector'] . ' {' . "\r\n" . $selectorStyles . $indent . '}' . "\r\n";
				} elseif ( isset( $selector['custom'] ) && $selector['custom'] ) {
					$outStyles .= "\r\n\t" . $selector['custom'] . "\r\n\r\n";
				} elseif ( isset( $selector['selector'] ) && '\r\n' === $selector['selector'] ) { // 'selector' => '\r\n'
					$outStyles .= "\r\n";
				}
			}

			if ( $outStyles )
				$out .= "\r\n\r\n\r\n/*********************************************/\r\n/* Custom design styles                      */\r\n/*********************************************/\r\n\r\n" . $outStyles;
		}

	//Include style.css file
		ob_start(); //start buffer
		@readfile( get_stylesheet_directory() . '/style.css' );
		$out .= "\r\n\r\n" . ob_get_clean(); //output and clean the buffer

	//Add manually written styles from admin panel
		$out .= ( wm_option( 'design-custom-css-enable' ) && wm_option( 'design-custom-css' ) ) ? ( "\r\n\r\n\r\n/* Custom CSS textarea styles */\r\n" . wm_option( 'design-custom-css' ) ) : ( '' );

	$out .= "\r\n\r\n" . '/* End of file */';





/*
*****************************************************
*      CSS FINAL OUTPUT (AND FILE HEADER)
*****************************************************
*/

	header( 'content-type: text/css; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + WM_CSS_EXPIRATION ) . ' GMT' );
	header( 'cache-control: public, max-age=' . WM_CSS_EXPIRATION );

	if ( ! isset( $_GET['noc'] ) && ( wm_option( 'design-minimize-css' ) ) )
		$out = wm_minimize_css( $out );

	if ( wm_option( 'general-gzip' ) || wm_option( 'design-gzip-cssonly' ) )
		ob_start( 'ob_gzhandler' ); //Enable GZIP

	echo $out;

?>