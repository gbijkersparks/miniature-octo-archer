<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* File prefixes used:
* a-            options array
* cp-           custom post
* ct-           custom taxonomies
* m-            meta box
* s-            slider content
* w-            widget
* no prefix     core function files
*
* Core functions
*
* CONTENT:
* - 1) Required files
* - 2) Actions and filters
* - 3) Register styles and scripts
* - 4) Variables
* - 5) Get/save theme/meta options
* - 6) Widget areas
* - 7) Breadcrumbs and pagination
* - 8) Password protected post
* - 9) Comments
* - 10) Sliders
* - 11) Header and footer functions
* - 12) SEO and tracking functions
* - 13) Post/page functions
* - 14) Other functions
*****************************************************
*/





/*
*****************************************************
*      1) REQUIRED FILES
*****************************************************
*/
	//Navigation enhancements
	require_once( WM_CLASSES . 'nav-walker.php' );

	//Theme hooks
	require_once( WM_HOOKS . 'hooks.php' );





/*
*****************************************************
*      2) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering theme styles and scripts
		add_action( 'init', 'wm_register_assets' );
		//Meta title
		add_filter( 'wp_title', 'wm_seo_title', 10, 2 );
		//Main content start
		add_action( 'wm_after_header', 'wm_slider', 10 );
		add_action( 'wm_after_header', 'wm_heading', 20 );

		if ( wm_option( 'contents-page-excerpt' ) )
			add_action( 'wm_after_header', 'wm_page_excerpt', wm_option( 'contents-page-excerpt' ) );
		if ( 'top' === wm_option( 'general-breadcrumbs' ) || 'both' === wm_option( 'general-breadcrumbs' ) )
			add_action( 'wm_after_header', 'wm_display_breadcrumbs', 100 );
		if ( 'bottom' === wm_option( 'general-breadcrumbs' ) || 'both' === wm_option( 'general-breadcrumbs' ) || 'stick' === wm_option( 'general-breadcrumbs' ) )
			add_action( 'wm_before_footer', 'wm_display_breadcrumbs', 100 );
		//Posts list
		add_action( 'wm_after_list', 'wm_pagination', 1 );
		//Post/page end
		add_action( 'wm_end_post', 'wm_post_parts', 10 );
		add_action( 'wm_after_post', 'wm_post_attachments', 1 );
		add_action( 'wm_after_post', 'wm_display_gallery', 1 );
		add_action( 'wm_after_post', 'wm_author_info', 10 );
		//Custom scripts
		add_action( 'wp_footer', 'wm_scripts_footer', 9998 ); //9998 for better compatibility with plugins
		//Remove recent comments <style> from HTML head
		add_action( 'widgets_init', 'wm_remove_recent_comments_style' );

	//FILTERS
		//Search form
		add_filter( 'get_search_form', 'wm_search_form' );
		//Password protected post
		add_filter( 'the_password_form', 'wm_password_form' );
		//Remove invalid HTML5 rel attribute
		add_filter( 'the_category', 'wm_remove_rel' );
		//Feed
		if ( wm_option( 'general-projects-in-feed' ) )
			add_filter( 'request', 'wm_feed_include_post_types' );
		add_filter( 'the_excerpt_rss', 'wm_rss_post_thumbnail' );
		add_filter( 'the_content_feed', 'wm_rss_post_thumbnail' );
		//Media uploader and media library
		add_filter( 'post_mime_types', 'wm_media_filters' );
		//add_filter( 'upload_mimes', 'wm_custom_mime_types' );
		add_filter( 'image_size_names_choose', 'wm_media_uploader_image_sizes' );
		//HTML in widget title ([e][/e] and [s][/s])
		add_filter( 'widget_title', 'wm_html_widget_title' );
		//WordPress [gallery] shortcode improvements
		add_filter( 'post_gallery', 'wm_shortcode_gallery', 10, 2 );
		//WordPress image with caption shortcode improvements
		add_filter( 'img_caption_shortcode', 'wm_shortcode_image_caption', 10, 3 );
		//Contact Form 7 plugin enhancements
		add_filter( 'wpcf7_form_elements', 'wm_wpcf7_shortcode_support' );
		//Default WordPress content filters only
		add_filter( 'wm_default_content_filters', 'wm_default_content_filters', 10 );





/*
*****************************************************
*      3) REGISTER STYLES AND SCRIPTS
*****************************************************
*/
	/*
	* Registering theme styles and scripts
	*/
	if ( ! function_exists( 'wm_register_assets' ) ) {
		function wm_register_assets() {
			$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );

			//STYLES
				//for jquery plugins
				wp_register_style( 'prettyphoto', WM_ASSETS_THEME . 'css/prettyphoto/prettyphoto.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'fancybox', WM_ASSETS_ADMIN . 'js/fancybox/jquery.fancybox.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'color-picker', WM_ASSETS_ADMIN . 'css/colorpicker.css', false, WM_SCRIPTS_VERSION, 'screen' );

				//other backend
				$fontFile = ( ! file_exists( WM_FONT . 'custom/css/fontello.css' ) ) ? ( WM_ASSETS_THEME . 'font/fontello/css/fontello.css' ) : ( WM_ASSETS_THEME . 'font/custom/css/fontello.css' );
				wp_register_style( 'wm-icons', $fontFile, false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-basic-icons', WM_ASSETS_THEME . 'css/icons-basic.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-options-panel', WM_ASSETS_ADMIN . 'css/wm-options/wm-options-panel.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-options-panel-white-label', WM_ASSETS_ADMIN . 'css/wm-options-white-label/wm-options-panel.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-admin-addons', WM_ASSETS_ADMIN . 'css/admin-addon.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-buttons', WM_ASSETS_ADMIN . 'css/shortcodes/shortcodes.css', false, WM_SCRIPTS_VERSION, 'screen' );

			//SCRIPTS
				//backend
				wp_register_script( 'jquery-cookies', WM_ASSETS_ADMIN . 'js/jquery.cookies.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'easing', WM_ASSETS_THEME . 'js/jquery.easing/jquery.easing-1.3.pack.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'fancybox', WM_ASSETS_ADMIN . 'js/fancybox/jquery.fancybox.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'color-picker', WM_ASSETS_ADMIN . 'js/colorpicker.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true);

				//other backend
				wp_register_script( 'wm-wp-admin', WM_ASSETS_ADMIN . 'js/wm-scripts.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'wm-options-panel', WM_ASSETS_ADMIN . 'js/wm-options-panel.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'wm-options-panel-tabs', WM_ASSETS_ADMIN . 'js/wm-options-panel-tabs.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'wm-shortcodes', WM_ASSETS_ADMIN . 'js/shortcodes/wm-shortcodes.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );

				//sliders
				wp_register_script( 'bxslider', WM_ASSETS_THEME . 'js/bxslider/jquery.bxslider.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );

				//frontend
				wp_register_script( 'wm-theme-scripts', WM_ASSETS_THEME . 'js/scripts.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'prettyphoto', WM_ASSETS_THEME . 'js/prettyphoto/jquery.prettyPhoto.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'imagesloaded', WM_ASSETS_THEME . 'js/imagesloaded/jquery.imagesloaded.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'isotope', WM_ASSETS_THEME . 'js/isotope/jquery.isotope.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'masonry', WM_ASSETS_THEME . 'js/masonry/jquery.masonry.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'lwtCountdown', WM_ASSETS_THEME . 'js/lwtCountdown/jquery.lwtCountdown-1.0.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'gmapapi', $protocol . '://maps.googleapis.com/maps/api/js?v=3.6&amp;sensor=false', false, '', true );
				wp_register_script( 'gmap-infobox', $protocol . '://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.5/src/infobox.js', array( 'gmapapi' ), '', true );
				wp_register_script( 'gmap', WM_ASSETS_THEME . 'js/maps.js', array( 'gmapapi' ), WM_SCRIPTS_VERSION, true );
		}
	} // /wm_register_assets





/*
*****************************************************
*      4) VARIABLES
*****************************************************
*/
	/*
	* Taxonomy list - returns array [slug => name]
	*
	* $args = ARRAY [see below for options]
	*/
	if ( ! function_exists( 'wm_tax_array' ) ) {
		function wm_tax_array( $args = array() ) {
			$args = wp_parse_args( $args, array(
					'all'          => true, //whether to display "all" option
					'allCountPost' => 'post', //post type to count posts for "all" option, if left empty, the posts count will not be displayed
					'allText'      => __( 'All posts', 'lespaul_domain_adm' ), //"all" option text
					'hierarchical' => '1', //whether taxonomy is hierarchical
					'orderBy'      => 'name', //in which order the taxonomy titles should appear
					'parentsOnly'  => false, //will return only parent (highest level) categories
					'return'       => 'slug', //what to return as a value (slug, or term_id?)
					'tax'          => 'category', //taxonomy name
				) );

			$outArray = array();
			$terms    = get_terms( $args['tax'], 'orderby=' . $args['orderBy'] . '&hide_empty=0&hierarchical=' . $args['hierarchical'] );

			if ( $args['all'] ) {
				if ( ! $args['allCountPost'] ) {
					$allCount = '';
				} else {
					$allCount = wp_count_posts( $args['allCountPost'], 'readable' );
					$allCount = ' (' . absint( $allCount->publish ) . ')';
				}
				$outArray[''] = '- ' . $args['allText'] . $allCount . ' -';
			}

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( ! $args['parentsOnly'] ) {
						$outArray[$term->$args['return']] = $term->name;
						$outArray[$term->$args['return']] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					} elseif ( $args['parentsOnly'] && ! $term->parent ) { //get only parent categories, no children
						$outArray[$term->$args['return']] = $term->name;
						$outArray[$term->$args['return']] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					}
				}
			}

			return $outArray;
		}
	} // /wm_tax_array



	/*
	* Pages list - returns array [post_name (slug) => name]
	*
	* $return  = 'post_name' OR 'ID'
	*/
	if ( ! function_exists( 'wm_pages' ) ) {
		function wm_pages( $return = 'post_name' ) {
			$pages       = get_pages();
			$outArray    = array();
			$outArray[0] = __( '- Select page -', 'lespaul_domain_adm' );

			foreach ( $pages as $page ) {
				$indents = $pagePath = '';
				$ancestors = get_post_ancestors( $page->ID );

				if ( ! empty( $ancestors ) ) {
					$indent = ( $page->post_parent ) ? ( '&ndash; ' ) : ( '' );
					foreach ( $ancestors as $ancestor ) {
						if ( 'post_name' == $return ) {
							$parent = get_page( $ancestor );
							$pagePath .= $parent->post_name . '/';
						}
						$indents .= $indent;
					}
				}

				$pagePath .= $page->post_name;
				$returnParam = ( 'post_name' == $return ) ? ( $pagePath ) : ( $page->ID );

				$outArray[$returnParam] = $indents . strip_tags( $page->post_title );
			}

			return $outArray;
		}
	} // /wm_pages



	/*
	* Get array of widget areas - returns array [id => name]
	*/
	if ( ! function_exists( 'wm_widget_areas' ) ) {
		function wm_widget_areas() {
			global $wp_registered_sidebars;

			$outArray     = array();
			$outArray[''] = __( '- Select area -', 'lespaul_domain_adm' );

			foreach ( $wp_registered_sidebars as $area ) {
				$outArray[ $area['id'] ] = $area['name'];
			}

			asort( $outArray );

			return $outArray;
		}
	} // /wm_widget_areas



	/*
	* Get skins
	*/
	if ( ! function_exists( 'wm_skins' ) ) {
		function wm_skins() {
			//empty item
			$themeSkins = array();

			//get files
			$files = array();

			if ( $dir = @opendir( WM_SKINS ) ) {
				//this is the correct way to loop over the directory
				while ( false != ( $file = readdir( $dir ) ) ) {
					$files[] = $file;
				}
				closedir( $dir );
			}

			asort( $files );

			//create output array
			foreach ( $files as $file ) {
				if ( 5 < strlen( $file ) && 'css' == strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
					if ( wm_skin_meta( $file, 'skin' ) && WM_THEME_NAME === wm_skin_meta( $file, 'package' ) ) {
						//$themeSkins[$file] = wm_skin_meta( $file, 'skin' );
						$fileName      = str_replace( array( '.css', '.CSS' ), '', $file );
						$previewImage  = WM_ASSETS_THEME . 'css/skins/' . $fileName . '.png';
						$item          = array();
						$item['name']  = wm_skin_meta( $file, 'skin' );
						$item['desc']  = wm_skin_meta( $file, 'skin' ) . ' - ' . wm_skin_meta( $file, 'description' );
						$item['id']    = esc_attr( $fileName );
						$item['value'] = esc_attr( $file );
						$item['img']   = ( file_exists( WM_SKINS . '/' . $fileName . '.png' ) ) ? ( $previewImage ) : ( WM_ASSETS_ADMIN . 'img/skin.png' );
						$themeSkins[]  = $item;
					}
				}
			}

			return $themeSkins;
		}
	} // /wm_skins



	/*
	* Get theme assets files
	*
	* $folder = TEXT [subfolder of theme assets folder - defaults to "img/patterns/"]
	* $format = TEXT [file format to look for - defaults to ".png"]
	*/
	if ( ! function_exists( 'wm_get_image_files' ) ) {
		function wm_get_image_files( $folder = 'img/patterns/', $format = '.png' ) {
			//empty item
			$filesArray = array(
				array(
					'name' => __( '- None -', 'lespaul_domain_adm' ),
					'id'   => '',
					'img'  => ''
				)
			);

			//get files
			$files = array();

			if ( $dir = @opendir( get_template_directory() . '/assets/' . $folder ) ) {
				//this is the correct way to loop over the directory
				while ( false != ( $file = readdir( $dir ) ) ) {
					$files[] = $file;
				}
				closedir( $dir );
			}

			asort( $files );

			//create output array
			foreach ( $files as $file ) {
				if ( 5 < strlen( $file ) && 'png' == strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) && ! stripos( $file, '@2x' ) ) {
					$fileName = str_replace( $format, '', $file );
					$itemName = str_replace( array( '-', '_' ), ' ', $fileName );

					$item         = array();
					$item['name'] = ucwords( $itemName );
					$item['id']   = esc_attr( $fileName );
					$item['img']  = esc_url( WM_ASSETS_THEME . $folder . $file );
					$filesArray[] = $item;
				}
			}

			return $filesArray;
		}
	} // /wm_get_image_files



	/*
	* Users list [user-nicename => display-name]
	*/
	if ( ! function_exists( 'wm_users' ) ) {
		function wm_users() {
			$outArray = array();

			$users = get_users( array(
				'orderby' => 'display_name',
				'fields'  => array( 'user_login', 'display_name' ) //get user login and display name only
			) );

			$outArray[''] = __( '&mdash; Select user or user group &mdash;', 'lespaul_domain_adm' );

			$outArray['1OPTGROUP'] = __( 'User groups', 'lespaul_domain_adm' );
				//group-CAPABILITY
				$outArray['group-read']          = __( 'Subscribers', 'lespaul_domain_adm' );
				$outArray['group-edit_posts']    = __( 'Contributors', 'lespaul_domain_adm' );
				$outArray['group-publish_posts'] = __( 'Authors', 'lespaul_domain_adm' );
				$outArray['group-publish_pages'] = __( 'Editors', 'lespaul_domain_adm' );
				$outArray['group-switch_themes'] = __( 'Administrators', 'lespaul_domain_adm' );
			$outArray['1/OPTGROUP'] = '';

			$outArray['2OPTGROUP'] = __( 'Users', 'lespaul_domain_adm' );
				$outArray['-1'] = __( '&mdash; All users (logged in)', 'lespaul_domain_adm' );
			foreach ( $users as $user ) {
				$outArray[$user->user_login] = $user->display_name;
			}
			$outArray['2/OPTGROUP'] = '';

			return $outArray;
		}
	} // /wm_users





/*
*****************************************************
*      5) GET/SAVE THEME/META OPTIONS
*****************************************************
*/
	/*
	* Checks whether array value is "-1"
	*/
	if ( ! function_exists( 'wm_remove_negative_array' ) ) {
		function wm_remove_negative_array( $id ) {
			return ( -1 != intval( $id ) );
		}
	} // /wm_remove_negative_array

	/*
	* Checks whether array value is zero or negative
	*/
	if ( ! function_exists( 'wm_remove_zero_negative_array' ) ) {
		function wm_remove_zero_negative_array( $id ) {
			return ( 0 < intval( $id ) );
		}
	} // /wm_remove_zero_negative_array

	/*
	* Checks whether array value is empty array
	*/
	if ( ! function_exists( 'wm_remove_empty_array' ) ) {
		function wm_remove_empty_array( $array ) {
			$arrayEmptyValuesOut = array_filter( $array );
			return ! empty( $arrayEmptyValuesOut );
		}
	} // /wm_remove_empty_array



	/*
	* Get page ID by its slug
	*/
	if ( ! function_exists( 'wm_remove_recent_comments_style' ) ) {
		function wm_page_slug_to_id( $slug = null ) {
			$page = get_page_by_path( $slug );
			return ( $slug && $page ) ? ( $page->ID ) : ( null );
		}
	} // /wm_page_slug_to_id



	/*
	* Get or echo the option
	*
	* $name  = TEXT [option name]
	* $css   = TEXT ["css", "bgimg" - outputs CSS color or background image]
	* $print = TEXT ["print" the value]
	*/
	function wm_option( $name, $css = null, $print = null ) {
		if ( ! isset( $name ) )
			return;

		global $themeOptions;

		$options = ( $themeOptions ) ? ( $themeOptions ) : ( get_option( WM_THEME_SETTINGS ) );
		$name    = WM_THEME_SETTINGS_PREFIX . $name;

		if ( ! isset( $options[$name] ) || ! $options[$name] )
			return;

		$array = ( is_array( $options[$name] ) ) ? ( true ) : ( false );

		//CSS output helper
		$color = ( is_string( $css ) && 5 <= strlen( $css ) && 'color' == substr( $css, 0, 5 ) ) ? ( '#' . str_replace( '#', '', stripslashes( $options[$name] ) ) ) : ( '' );
			$colorSuffix = ( $color && 5 < strlen( $css ) ) ? ( str_replace( 'color', '', $css ) ) : ( '' ); // use for example like "color !important"
		$bg = ( is_string( $css ) && 5 <= strlen( $css ) && 'bgimg' == substr( $css, 0, 5 ) ) ? ( 'url(' . esc_url( stripslashes( $options[$name] ) ) . ')' ) : ( '' );
			$bgSuffix = ( $bg && 5 < strlen( $css ) ) ? ( str_replace( 'bgimg', '', $css ) ) : ( '' ); // use for example for css positioning, repeat, ...

		//setting the output
		if ( $bg )
			$output = $bg . $bgSuffix;
		elseif ( $color )
			$output = $color . $colorSuffix;
		else
			$output = ( $array ) ? ( $options[$name] ) : ( stripslashes( $options[$name] ) );

		//output method
		if ( 'print' == $print )
			echo $output;
		else
			return $output;
	} // /wm_option



	/*
	* Get the static option
	*
	* $name = TEXT [option name]
	*/
	if ( ! function_exists( 'wm_static_option' ) ) {
		function wm_static_option( $name ) {
			$options = get_option( WM_THEME_SETTINGS_STATIC );

			if ( isset( $options[$name] ) )
				return stripslashes( $options[$name] );
		}
	} // /wm_static_option



	/*
	* Get or echo post/page meta option
	*
	* $name   = TEXT [option name]
	* $postId = # [specific post ID, else uses the current post ID]
	* $css    = TEXT ["css", "bgimg" - outputs CSS color or background image]
	* $print  = TEXT ["print" the value]
	*/
	if ( ! function_exists( 'wm_meta_option' ) ) {
		function wm_meta_option( $name, $post_id = null, $css = null, $print = null ) {
			global $post;
			$postIdObj = ( $post ) ? ( $post->ID ) : ( null );
			$post_id   = ( $post_id ) ? ( absint( $post_id ) ) : ( $postIdObj );

			if ( ! isset( $name ) || ! $post_id )
				return;

			$meta = get_post_meta( $post_id, WM_THEME_SETTINGS_META, true ); //TRUE = retrieve only the first value of a given key;

			//legacy (not hidden) meta - if hidden meta doesn't exist, try to get visible meta
				if ( empty( $meta ) )
					$meta = get_post_meta( $post_id, str_replace( '_', '', WM_THEME_SETTINGS_META ), true );

			$name = WM_THEME_SETTINGS_PREFIX . $name;

			if ( ! isset( $meta[$name] ) || ! $meta[$name] )
				return;

			$array = ( is_array( $meta[$name] ) ) ? ( true ) : ( false );

			//CSS output helper
			$color = ( is_string( $css ) && 5 <= strlen( $css ) && 'color' == substr( $css, 0, 5 ) ) ? ( '#' . str_replace( '#', '', stripslashes( $meta[$name] ) ) ) : ( '' );
				$colorSuffix = ( $color && 5 < strlen( $css ) ) ? ( str_replace( 'color', '', $css ) ) : ( '' ); // use for example like "color !important"
			$bg = ( is_string( $css ) && 5 <= strlen( $css ) && 'bgimg' == substr( $css, 0, 5 ) ) ? ( 'url(' . esc_url( stripslashes( $meta[$name] ) ) . ')' ) : ( '' );
				$bgSuffix = ( $bg && 5 < strlen( $css ) ) ? ( str_replace( 'bgimg', '', $css ) ) : ( '' ); // use for example for css positioning, repeat, ...

			//setting the output
			if ( $bg )
				$output = $bg . $bgSuffix;
			elseif ( $color )
				$output = $color . $colorSuffix;
			else
				$output = ( $array ) ? ( $meta[$name] ) : ( stripslashes( $meta[$name] ) );

			//output method
			if ( 'print' == $print )
				echo $output;
			else
				return $output;
		}
	} // /wm_meta_option



	/*
	* Saves post/page meta (custom fields)
	*
	* $post_id = # [current post ID]
	* $options = ARRAY [options array to save]
	*/
	if ( ! function_exists( 'wm_save_meta' ) ) {
		function wm_save_meta( $post_id, $options ) {
			if ( ! isset( $options ) || ! is_array( $options ) || empty( $options ) || ! $post_id )
				return;

			$newMetaOptions = get_post_meta( $post_id, WM_THEME_SETTINGS_META, true );

			//legacy (not hidden) meta - just delete
				$legacyMetaOptions = get_post_meta( $post_id, str_replace( '_', '', WM_THEME_SETTINGS_META ), true );
				if ( $legacyMetaOptions )
					delete_post_meta( $post_id, str_replace( '_', '', WM_THEME_SETTINGS_META ) );

			if ( ! $newMetaOptions || empty( $newMetaOptions ) )
				$newMetaOptions = array();

			foreach ( $options as $value ) {

				if ( isset( $value['id'] ) ) {
					$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

					if ( isset( $_POST[$valId] ) ) {

						if ( is_array( $_POST[$valId] ) && ! empty( $_POST[$valId] ) ) {
							$updVal = $_POST[$valId];
							if ( isset( $value['field'] ) && 'attributes' == $value['field'] ) {
								$updVal = array_filter( $updVal, 'wm_remove_empty_array' );
							} else {
								$updVal = array_filter( $updVal, 'strlen' ); //removes null array items
								$updVal = array_filter( $updVal, 'wm_remove_negative_array' ); //removes '-1' array items
							}
						} else {
							$updVal = stripslashes( $_POST[$valId] );
						} //if value is array or not

						if ( isset( $value['validate'] ) ) {
							switch ( $value['validate'] ) {
								case 'lineBreakComma':
									$updVal = str_replace( array( "\r\n", "\r", "\n" ), ', ', $updVal );
								break;
								case 'lineBreakSpace':
									$updVal = str_replace( array( "\r\n", "\r", "\n" ), ' ', $updVal );
								break;
								case 'lineBreakHTML':
									$updVal = str_replace( array( "\r\n", "\r", "\n" ), '<br />', $updVal );
								break;
								case 'url':
									$updVal = esc_url( $updVal );
								break;
								case 'absint':
									$updVal = absint( $updVal );
								break;
								case 'int':
									$updVal = intval( $updVal );
								break;
								default:
								break;
							}
						} // if ['validate']

					} //if $_POST set

					if ( isset( $_POST[$valId] ) && $value['id'] )
						$newMetaOptions[$valId] = $updVal;
					else
						$newMetaOptions[$valId] = '';
				} //if value ID set

			} // /foreach options

			update_post_meta( $post_id, WM_THEME_SETTINGS_META, $newMetaOptions );
		}
	} // /wm_save_meta



	/*
	* Get skin meta
	*
	* $skinFile = TEXT [skin file name]
	* $meta     = TEXT [meta info title]
	*/
	if ( ! function_exists( 'wm_skin_meta' ) ) {
		function wm_skin_meta( $skinFile, $meta ) {
			if ( ! $skinFile || ! $meta || ! file_exists( WM_SKINS . $skinFile ) )
				return;

			global $skinAttsStatic;

			$default_headers = $skinAttsStatic;

			$fileMeta = get_file_data( WM_SKINS . $skinFile, $default_headers );

			$out = '';

			if ( $fileMeta['skin'] && WM_THEME_NAME === $fileMeta['package'] ) {
				$out = ( isset( $fileMeta[$meta] ) ) ? ( $fileMeta[$meta] ) : ( null );
			}

			return $out;
		}
	} // /wm_skin_meta



	/**
	* Get design element width
	*
	* @param $element [TEXT]
	*/
	if ( ! function_exists( 'wm_element_width' ) ) {
		function wm_element_width( $element, $print = false ) {
			$elements = array(
					'toppanel',
					'header',
					'navigation',
					'slider',
					'mainheading',
					'pageexcerpt',
					'content',
					'breadcrumbs',
					'abovefooter',
					'footer',
					'bottom',
				);

			if ( ! $element || ! in_array( $element, $elements ) )
				return;

			$out = ( trim( wm_option( 'design-' . $element . '-layout' ) ) ) ? ( ' ' . trim( wm_option( 'design-' . $element . '-layout' ) ) ) : ( '' );

			if ( ! $print )
				return $out;
			else
				echo $out;
		}
	} // /wm_element_width





/*
*****************************************************
*      6) WIDGET AREAS
*****************************************************
*/
	/*
	* Display widget area (sidebar)
	*
	* $defaultSidebar = TEXT [widget area ID to fall back as default (if not set, the first widget area defined is used)]
	* $class          = TEXT [CSS class added on area container]
	* $restrictCount  = # [do not display the sidebar if the number of widgets contained is higher]
	* $print          = BOOLEAN [print or return the sidebar]
	* $hasInner       = TEXT [whether it contains inner content wrapper]
	*/
	if ( ! function_exists( 'wm_sidebar' ) ) {
		function wm_sidebar( $sidebar = WM_SIDEBAR_FALLBACK, $class = 'sidebar', $restrictCount = null, $print = true, $hasInner = null ) {
			global $post, $wp_registered_sidebars, $_wp_sidebars_widgets;

			//restriction = 0 means any number of widgets allowed
			$restrictCount = ( isset( $restrictCount ) && $restrictCount ) ? ( absint( $restrictCount ) ) : ( 0 );
			//set the sidebar to display - default sidebar
			$sidebar       = ( isset( $sidebar ) && $sidebar ) ? ( $sidebar ) : ( WM_SIDEBAR_FALLBACK );
			//fall back to default if the sidebar doesn't exist
			$sidebar       = ( ! in_array( $sidebar, array_keys( $wp_registered_sidebars ) ) ) ? ( WM_SIDEBAR_FALLBACK ) : ( $sidebar );
			//get all widgets in all widget areas into array
			$widgetsList   = wp_get_sidebars_widgets();

			/*
			//cut the widgets over the restricted amount
			if( count($widgetsList[$sidebar]) > $restrictCount ) {
				$slicedWidgets = array_slice( $widgetsList[$sidebar], 0, $restrictCount );
				$widgetsList[$sidebar] = $slicedWidgets;
				wp_set_sidebars_widgets($widgetsList);
			}
			*/

			//if there are some widgets in $sidebar AND no restrictions applied or the number of the widgets in $sidebar is not greater then restriction
			$out = '';

			if ( is_active_sidebar( $sidebar ) && ( 0 == $restrictCount || ( $restrictCount >= count( $widgetsList[$sidebar] ) ) ) ) {
				if ( $hasInner )
					$out .= '<div class="' . $sidebar . '-wrap wrap-widgets"><div class="wrap-inner"><div class="twelve pane">' . "\r\n";

				$out .= '<section data-id="' . $sidebar . '" class="widgets count-' . sizeof( $widgetsList[$sidebar] ) . ' ' . $class . '">' . "\r\n"; //data-id is to prevent double ID attributes on the website

				$out .= wm_start_sidebar(); //hook

				if ( function_exists( 'ob_start' ) && function_exists( 'ob_get_clean' ) ) {
					ob_start();
					dynamic_sidebar( $sidebar );
					$out .= ob_get_clean(); //output and clean the buffer
				}

				$out .= wm_end_sidebar(); //hook

				$out .= '<!-- /' . $sidebar . ' /widgets --></section>' . "\r\n";

				if ( $hasInner )
					$out .= '<!-- /wrap-widgets --></div></div></div>' . "\r\n";
			}

			//output
			if ( $print )
				echo $out;
			else
				return $out;
		}
	} // /wm_sidebar





/*
*****************************************************
*      7) BREADCRUMBS AND PAGINATION
*****************************************************
*/
	/*
	* Pagination
	*
	* $args = ARRAY [array of settings:
			label_previous = TEXT ["Previous"]
			label_next     = TEXT ["Next"]
			before_output  = HTML [wrapper tag strat]
			after_output   = HTML [wrapper tag end]
		]
	*/
	if ( ! function_exists( 'wm_pagination' ) ) {
		function wm_pagination( $query = null, $args = array() ) {
			$args = wp_parse_args( $args, array(
					'label_previous' => __( 'Prev', 'lespaul_domain' ),
					'label_next'     => __( 'Next', 'lespaul_domain' ),
					'before_output'  => '<div class="pagination clearfix">',
					'after_output'   => '</div> <!-- /pagination -->',
					'print'          => true
				) );

			//WP-PageNavi plugin support (for posts only as it doesn't work with projects pagination...)
			if ( function_exists( 'wp_pagenavi' ) && ! $query ) {
				ob_start();
				wp_pagenavi();
				$out = ob_get_clean();

				if ( $args['print'] )
					echo $args['before_output'] . $out . $args['after_output'];
				else
					return $args['before_output'] . $out . $args['after_output'];

				return; //exit if echo
			}

			global $wp_query, $wp_rewrite;

			if ( $query )
				$wp_query = $query;

			//WordPress pagination settings
			$pagination = array(
					'base'      => @add_query_arg( 'paged', '%#%' ),
					'format'    => '',
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $wp_query->max_num_pages,
					'prev_text' => $args['label_previous'],
					'next_text' => $args['label_next'],
				);

			//nice URLs
			if ( $wp_rewrite->using_permalinks() )
				$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
			//search
			if ( get_query_var( 's' ) )
				$pagination['add_args'] = array( 's' => urlencode( get_query_var( 's' ) ) );

			//output
			if ( 1 < $wp_query->max_num_pages ) {
				if ( $args['print'] )
					echo $args['before_output'] . paginate_links( $pagination ) . $args['after_output'];
				else
					return $args['before_output'] . paginate_links( $pagination ) . $args['after_output'];
			}
		}
	} // /wm_pagination



	/*
	* Breadcrumbs
	*
	* $args = ARRAY [array of settings:
			separator        = TEXT [">"]
			before_output    = HTML [wrapper tag strat]
			after_output     = HTML [wrapper tag end]
			curently_reading = TEXT
			back_to          = TEXT
		]
	*/
	if ( ! function_exists( 'wm_breadcrumbs' ) ) {
		function wm_breadcrumbs( $args = array() ) {
			//breadcrumbs container classes
			$classContainer  = wm_element_width( 'breadcrumbs' );
			$classContainer .= wm_option( 'general-breadcrumbs-search' );

			$args = wp_parse_args( $args, array(
					'separator'        => '&raquo;',
					'before_output'    => '<div class="breadcrumbs wrap clearfix' . $classContainer . '"><div class="wrap-inner"><div class="twelve pane"><div class="breadcrumbs-container">',
					'after_output'     => '</div></div></div></div>',
					'curently_reading' => esc_attr( __( 'Currently viewing "%s"', 'lespaul_domain' ) ),
					'back_to'          => esc_attr( __( 'Back to homepage', 'lespaul_domain' ) ),
				) );

			$out = '';

			//If using WooCommerce and on a shop page
				if ( class_exists( 'Woocommerce' ) && is_woocommerce() ) {
					ob_start(); //start buffer
					woocommerce_breadcrumb( array(
							'delimiter'   => '<span class="separator">&raquo;</span>',
							'wrap_before' => '<div class="woocommerce-breadcrumbs-wrap">',
							'wrap_after'  => '</div>',
							'before'      => '<span class="woocommerce-breadcrumb">',
							'after'       => '</span>',
						) );
					$breadcrumbs = ob_get_clean(); //output and clean the buffer

					if ( wm_option( 'general-breadcrumbs-search' ) )
						$out = get_search_form( false );
					echo $args['before_output'] . $breadcrumbs . $out . $args['after_output'];

					return;
				} // /WooCommerce breadcrumbs

			//If using Yoast SEO Breadcrumbs, bypass the theme ones
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					$breadcrumbs = yoast_breadcrumb( '', '', false ); //http://yoast.com/wordpress/breadcrumbs/

					if ( wm_option( 'general-breadcrumbs-search' ) )
						$out = get_search_form( false );
					echo $args['before_output'] . $breadcrumbs . $out . $args['after_output'];

					return;
				} // /yoast_breadcrumb

			//Start theme breadcrumbs
			global $post, $wp_query;

			$cats      = ( $post ) ? ( get_the_category() ) : ( array() );

			$parents   = ( isset( $post->ancestors ) ) ? ( $post->ancestors ) : ( null ); //get all parent pages in array
			$parents   = ( ! empty( $parents ) ) ? ( array_reverse( $parents ) ) : ( '' );  //flip the array

			$separator = ' <span class="separator">' . $args['separator'] . '</span> ';

			//Do not display breadcrumbs on homepage or main blog page
			if ( ! is_home() && ! is_front_page() ) {
			//no front page, nor home (posts list) page

				$out = $args['before_output'] . '<a href="' . home_url() . '" class="home-item" title="' . $args['back_to'] . '">' . __( 'Home', 'lespaul_domain' ) . '</a>' . $separator;

				if ( is_category() ) {
				//output single cat name and its parents

					$catId    = intval( get_query_var('cat') );
					$parent   = &get_category( $catId );
					$catsOut  = '';
					$blogPage = ( get_option( 'page_for_posts' ) ) ? ( '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>' . $separator ) : ( null );

					if ( is_wp_error( $parent ) )
						return $parent;
					if ( $parent->parent && ( $parent->parent != $parent->term_id ) )
						$catsOut .= get_category_parents( $parent->parent, true, $separator );

					$out .= $blogPage . $catsOut . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( single_cat_title( '', FALSE ) ) ) ) . '">' . single_cat_title( '', FALSE ) . '</span>';;

				} elseif ( is_date() ) {
				//date archives

					$year      = get_the_time('Y');
					$month     = get_the_time('m');
					$monthname = get_the_time('F');
					$day       = get_the_time('d');
					$dayname   = get_the_time('l');

					if ( is_year() )
						$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( 'year %d archive', 'lespaul_domain' ), absint( $year ) ) ) . '">' . sprintf( __( 'Year %d archive', 'lespaul_domain' ), absint( $year ) ) . '</span>';
					if ( is_month() )
						$out .= '<a href="' . get_year_link( $year ) . '">' . $year . '</a>' . $separator . '<span class="current-item">' . sprintf( __( '%s archive', 'lespaul_domain' ), $monthname ) . '</span>';
					if ( is_day() )
						$out .= '<a href="' . get_year_link( $year ) . '">' . $year . '</a>' . $separator . '<a href="' . get_month_link( $year, $month ) . '">' . $monthname . '</a>' . $separator . '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( 'day %1$d, %2$s archive', 'lespaul_domain' ), $day, $dayname ) ) . '">' . sprintf( __( 'Day %1$d, %2$s archive', 'lespaul_domain' ), $day, $dayname ) . '</span>';

				} elseif ( is_author() ) {
				//author archives

					$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
					$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( 'posts by %s', 'lespaul_domain' ), $curauth->display_name ) ) . '">' . sprintf( __( 'Posts by <em>%s</em>', 'lespaul_domain' ), $curauth->display_name ) . '</span>';

				} elseif ( is_tag() ) {
				//tag archives

					$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( '%s tag archive', 'lespaul_domain' ), single_tag_title( '', false ) ) ) . '">' . sprintf( __( '<em>%s</em> tag archive', 'lespaul_domain' ), single_tag_title( '', false ) ) . '</span>';

				} elseif ( is_search() ) {
				//search results

					$out .= '<span class="current-item">' . sprintf( __( 'Search results for <em>"%s"</em>', 'lespaul_domain' ), get_search_query() ) . '</span>';

				} elseif ( is_single() && ! empty( $cats ) ) {
				//single post with hierarchical categories

					$cat      = ( isset( $cats[0] ) ) ? ( $cats[0] ) : ( null );
					$catsOut  = '';
					$blogPage = ( get_option( 'page_for_posts' ) ) ? ( '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>' . $separator ) : ( null );

					if ( is_object( $cat ) ) {
						if ( 0 != $cat->parent ) {
							$catsOut = get_category_parents( $cat->term_id, true, $separator );
						} else {
							$catsOut = '<a href="' . get_category_link( $cat->term_id ) . '">' . $cat->name . '</a>' . $separator;
						}
					}

					$out .= $blogPage . $catsOut . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} elseif ( is_single() && 'wm_projects' == $post->post_type ) {
				//single portfolio

					$terms = get_the_terms( $post->ID , 'project-category' );
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach( $terms as $term ) {
							$cats[] = $term;
						}
					}

					$catsOut = $portfolioPage = '';
					$cat     = ( isset( $cats[0] ) ) ? ( $cats[0] ) : ( null );

					$portfolioPage   = wm_option( 'general-breadcrumbs-portfolio-page' );
					$portfolioPageID = wm_page_slug_to_id( $portfolioPage );
					$catURL          = ( $portfolioPage ) ? ( get_permalink( $portfolioPageID ) ) : ( home_url() );

					if ( is_object( $cat ) )
						$catsOut = '<a href="' . $catURL . '">' . $cat->name . '</a>' . $separator;

					if ( $portfolioPageID )
						$portfolioPage = '<a href="' . get_permalink( $portfolioPageID ) . '">' . get_the_title( $portfolioPageID ) . '</a>' . $separator;

					$out .= $portfolioPage . $catsOut . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} elseif ( is_single() ) {
				//single post

					$blogPage = ( get_option( 'page_for_posts' ) ) ? ( '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>' . $separator ) : ( null );

					$out .= $blogPage . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} elseif ( is_404() ) {
				//error 404 page

					$out .= '<span class="current-item">' . __( 'Page not found', 'lespaul_domain' ) . '</span>';

				} elseif ( is_page() ) {
				//page with hierarchical parent pages

					if ( $parents ) {
						foreach ( $parents as $parent ) {
							$out .= '<a href="' . get_permalink( $parent ) . '">' . get_the_title( $parent ) . '</a>' . $separator; // print all page parents
						}
					}
					$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} else {
				//default

					$out .= '<span class="current-item">' . __( 'Archive', 'lespaul_domain' ) . '</span>';

				}

			} elseif ( is_home() ) {
			//home (posts list) page

				//$title = ( wm_option( 'pages-default-archives-title' ) ) ? ( wm_option( 'pages-default-archives-title' ) ) : ( __( 'Archives', 'lespaul_domain' ) );
				$title = get_the_title( get_option( 'page_for_posts' ) );

				if ( get_option( 'page_for_posts' ) ) {
					$out  = $args['before_output'];
					$out .= '<a href="' . home_url() . '" class="home-item">' . __( 'Home', 'lespaul_domain' ) . '</a>' . $separator . '<span class="current-item">' . $title . '</span>';
				}

			} elseif ( is_front_page() ) {
			//front (home) page

				$title = get_the_title( get_option( 'page_on_front' ) );

				if ( get_option( 'page_on_front' ) ) {
					$out  = $args['before_output'];
					$out .= '<a href="' . home_url() . '" class="home-item">' . __( 'Home', 'lespaul_domain' ) . '</a>';
				}

			}

			if ( $out ) {
				if ( wm_option( 'general-breadcrumbs-search' ) )
					$out .= get_search_form( false );
				echo $out . $args['after_output'];
			} else {
				return;
			}
		}
	} // /wm_breadcrumbs

	/*
	* Display breadcrumbs
	*/
	if ( ! function_exists( 'wm_display_breadcrumbs' ) ) {
		function wm_display_breadcrumbs() {
			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			if ( 'none' != wm_option( 'general-breadcrumbs' ) && ! wm_meta_option( 'breadcrumbs', $postId ) ) {

				if (
						( ( is_archive() || is_home() ) && wm_option( 'general-breadcrumbs-archives' ) ) ||
						( is_404() && wm_option( 'general-breadcrumbs-404' ) ) ||
						( is_page_template( 'page-template/landing.php' ) ) ||
						( is_page_template( 'page-template/construction.php' ) )
					) {
					return;
				} else {
					wm_breadcrumbs();
				}

			}
		}
	} // /wm_display_breadcrumbs





/*
*****************************************************
*      8) PASSWORD PROTECTED POST
*****************************************************
*/
	/*
	* Password protected post form
	*/
	if ( ! function_exists( 'wm_password_form' ) ) {
		function wm_password_form() {
			global $post;
			$label     = 'pwbox-' . ( ( empty( $post->ID ) ) ? ( rand() ) : ( $post->ID ) );
			$checkPage = ( wm_check_wp_version( 3.4 ) ) ? ( 'wp-login.php?action=postpass' ) : ( 'wp-pass.php' );
			$out       = '';

			$out = do_shortcode( '[box color="red" icon="warning"]<form class="protected-post-form" action="' . get_option( 'siteurl' ) . '/' . $checkPage . '" method="post"><h4>' . __( 'Enter password to view the content:', 'lespaul_domain' ) . '</h4><p><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" id="submit" value="' . esc_attr__( 'Submit', 'lespaul_domain' ) . '" /></p></form>[/box]' );

			return $out;
		}
	} // /wm_password_form





/*
*****************************************************
*      9) COMMENTS
*****************************************************
*/
	/*
	* Prints comment/trackback
	*
	* $comment, $args, $depth - check WordPress codex for info
	*/
	if ( ! function_exists( 'wm_comment' ) ) {
		function wm_comment( $comment, $args, $depth ) {
			$GLOBALS['comment'] = $comment;

			switch ( $comment->comment_type ) {
				case 'pingback' :
				case 'trackback' :

				?>
				<li class="pingback">
					<p>
						<strong><?php _e( 'Pingback:', 'lespaul_domain' ); ?></strong>
						<?php comment_author_link(); ?>
						<?php
						if ( get_edit_comment_link() )
							echo ' | <a href="' . get_edit_comment_link() . '" class="edit-link">' . __( 'Edit', 'lespaul_domain' ) . '</a>';
						?>

					</p>
				<?php

				break;
				default :

				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<article class="comment-content">
							<div class="gravatar"><?php echo get_avatar( $comment, 180 ); ?></div>

							<div class="comment-heading">
								<strong class="author"><?php comment_author_link(); ?></strong><br />

								<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="published-on">
									<time datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php printf( __( '%1$s at %2$s', 'lespaul_domain' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?></time>
								</a>

								<?php
								if ( get_edit_comment_link() )
									echo ' | <a href="' . get_edit_comment_link() . '" class="comment-edit-link">' . __( 'Edit', 'lespaul_domain' ) . '</a>';

								comment_reply_link( array_merge( $args, array(
									'reply_text' => __( ' | Reply', 'lespaul_domain' ),
									'depth'      => $depth,
									'max_depth'  => $args['max_depth']
									) ) );
								?>
							</div> <!-- /comment-heading -->

							<div class="comment-text">
								<?php
								if ( '0' == $comment->comment_approved )
									echo '<p class="awaiting"><em>' . __( 'Your comment is awaiting moderation.', 'lespaul_domain' ) . '</em></p>';

								comment_text();
								?>
							</div>
					</article>
				<?php

				break;
			} // /switch
		}
	} // /wm_comment



	/*
	* List pingbacks and trackback
	*
	* $tag = TEXT ["h2" heading wrapper tag]
	*/
	if ( ! function_exists( 'wm_pings' ) ) {
		function wm_pings( $tag = 'h2' ) {
			$haveTrackbacks = array();
			$haveTrackbacks = get_comments( array( 'type' => 'pings' ) );

			if ( ! empty( $haveTrackbacks ) ) {
				echo '<' . $tag . '>' . __( 'Pingbacks list', 'lespaul_domain' ) . '</' . $tag . '>';
				?>
				<ol class="commentlist pingbacks">
					<?php
					wp_list_comments( array(
						'type'     => 'pings',
						'callback' => 'wm_comment'
						) );
					?>
				</ol>
				<?php
			}
		}
	} // /wm_pings





/*
*****************************************************
*      10) SLIDERS
*****************************************************
*/
	/*
	* Slider type switch
	*/
	if ( ! function_exists( 'wm_slider' ) ) {
		function wm_slider() {
			global $paged, $page;

			if ( ! isset( $paged ) )
				$paged = 0;
			if ( ! isset( $page ) )
				$page = 0;

			if ( ( ! is_singular() && ! is_home() ) || 1 < $paged || 1 < $page )
				//do nothing if no post, page or blog displayed, or if paginated
				return;

			if ( is_page() && wm_option( 'access-client-area' ) && ! wm_restriction_page() )
				//also do nothing if on page that current user can not display
				return;

			$out    = $class = $height = '';
			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//Slider type
				$sliderType = ( wm_meta_option( 'slider-type', $postId ) ) ? ( wm_meta_option( 'slider-type', $postId ) ) : ( 'none' );

				//for map page
				if ( is_page_template( 'page-template/map.php' ) )
					$sliderType = 'map';

				//for project posts
				$project = 'wm_projects' == get_post_type() && 'plain' === wm_meta_option( 'project-single-layout' );
				if ( $project && wm_meta_option( 'project-type' ) ) {
					$projectTypes = array( 'static-project', 'slider-project', 'video-project', 'audio-project' );
					$sliderType   = explode( '[', wm_meta_option( 'project-type' ) );
					$sliderType   = ( ! empty( $sliderType ) && isset( $sliderType[0] ) && in_array( $sliderType[0], $projectTypes ) ) ? ( $sliderType[0] ) : ( 'static-project' );
				}

				//Do not continue, if no slider type selected
				if ( 'none' == $sliderType )
					return;

			//max slides count
			$slidesCount = 20;

			//slider image size
			$imageSize = 'content-width';

			//slider wrapper background color
			if ( 'gallery' !== $sliderType )
				$styles = ( wm_meta_option( 'slider-bg-color', $postId ) ) ? ( ' style="background-color: ' . wm_meta_option( 'slider-bg-color', $postId, 'color' ) . ';"' ) : ( null );
			else
				$styles = ( wm_meta_option( 'gallery-bg-color', $postId ) ) ? ( ' style="background-color: ' . wm_meta_option( 'gallery-bg-color', $postId, 'color' ) . ';"' ) : ( null );

			//choose slider type
			switch ( $sliderType ) {

				//Page sliders
					case 'video':
						if ( ! wm_meta_option( 'slider-video-url', $postId ) )
							return;

						$videoURL = esc_url( wm_meta_option( 'slider-video-url', $postId ) );

						$coverImage    = '';
						$hasCoverImage = ' no-cover';

						if ( has_post_thumbnail( $postId ) && get_post( get_post_thumbnail_id( $postId ) ) ) {
							//Post featured image used as video cover image
							$attachment    = get_post( get_post_thumbnail_id( $postId ) );
							$coverImage    = get_the_post_thumbnail( $postId, $imageSize, array( 'class' => 'video-cover', 'title' => esc_attr( $attachment->post_title ) ) );
							$hasCoverImage = ' has-cover';
						}

						$out .= '<div class="wrap-inner">' . $coverImage . '<div id="video-slider" class="video-slider slider-content' . $hasCoverImage . ' twelve pane">';
						$out .= do_shortcode( '[video url="' . $videoURL . '"]' );
						$out .= '</div></div> <!-- /video-slider -->';

						$class = ' video';
					break;

					case 'static':
						if ( has_post_thumbnail( $postId ) ) {
							//Post featured image
							$width = '';
							if ( wm_meta_option( 'slider-static-stretch' ) ) {
								$width     = ' stretch-image';
								$imageSize = 'full';
							}

							$attachment = get_post( get_post_thumbnail_id( $postId ) );
							$imageTitle = '';
							if ( is_object( $attachment ) && ! empty( $attachment ) ) {
								$imageTitle  = $attachment->post_title;
								$imageTitle .= ( $attachment->post_excerpt ) ? ( ' - ' . $attachment->post_excerpt ) : ( '' );
							}

							$out .= '<div id="static-slider" class="static-slider slider-content img-content' . $width . '">';
							$out .= get_the_post_thumbnail( $postId, $imageSize, array( 'title' => esc_attr( $imageTitle ) ) );
							$out .= '</div> <!-- /static-slider -->';
						}
					break;

					case 'custom':
						$customSliderWidth = ( ! wm_meta_option( 'slider-width', $postId ) ) ? ( ' twelve pane' ) : ( '' );

						$out .= ( $customSliderWidth ) ? ( '<div class="wrap-inner">' ) : ( '' );
						$out .= '<div class="custom-slider slider-content' . $customSliderWidth . '">';
						$out .= do_shortcode( wm_meta_option( 'slider-custom-shortcode', $postId ) );
						$out .= '</div>';
						$out .= ( $customSliderWidth ) ? ( '</div>' ) : ( '' );
					break;

					case 'gallery':
						$columns = wm_meta_option( 'gallery-columns' );
						$images  = wm_meta_option( 'gallery-images' );
						$images  = ( is_array( $images ) && ! empty( $images ) ) ? ( implode( ',', $images ) ) : ( '' );

						$galleryWidth = ( ! wm_meta_option( 'gallery-width' ) ) ? ( ' twelve pane' ) : ( '' );

						$out .= ( $galleryWidth ) ? ( '<div class="wrap-inner">' ) : ( '' );
						$out .= '<div id="gallery-slider" class="gallery-slider slider-content' . $galleryWidth . '">';
						$out .= do_shortcode( '[gallery columns="' . $columns . '" include="' . $images . '" link="file" sardine="1" /]' );
						$out .= '</div>';
						$out .= ( $galleryWidth ) ? ( '</div>' ) : ( '' );
					break;

				//Project sliders
					case 'slider-project':
						//Post gallery images
						$slides = wm_get_post_images( get_the_ID(), $imageSize, $slidesCount );

						if ( empty( $slides ) )
							return;

						$duration = ' data-time="' . absint( wm_meta_option( 'project-slider-duration' ) * 1000 ) . '"';

						//Images
						foreach ( $slides as $slide ) {
							if ( isset( $slide['id'] ) && get_post_thumbnail_id( get_the_ID() ) != $slide['id'] && isset( $slide['img'] ) && $slide['img'] ) {
								$out .= '<li>';

								$imageAlt   = ( isset( $slide['alt'] ) ) ? ( $slide['alt'] ) : ( '' );
								$imageTitle = ( isset( $slide['title'] ) ) ? ( $slide['title'] ) : ( '' );

								$out .= '<img src="' . esc_url( $slide['img'] ) . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';

								$out .= '</li>';
							}
						}

						$out = ( $out ) ? ( '<div class="wrap-inner"><div id="project-slider" class="project-slider slider-content twelve pane"><ul' . $duration . '>' . $out . '</ul></div><!-- /project-slider --></div>' ) : ( '' );

						wp_enqueue_script( 'bxslider' );
					break;

					case 'video-project':
						$coverImage    = '';
						$hasCoverImage = ' no-cover';

						if ( has_post_thumbnail( $postId ) && get_post( get_post_thumbnail_id( $postId ) ) ) {
							//Post featured image used as video cover image
							$attachment    = get_post( get_post_thumbnail_id( $postId ) );
							$coverImage    = get_the_post_thumbnail( $postId, $imageSize, array( 'class' => 'video-cover' ) );
							$hasCoverImage = ' has-cover';
						}

						$out .= '<div class="wrap-inner">' . $coverImage . '<div id="video-slider" class="video-slider slider-content' . $hasCoverImage . ' twelve pane">';
						$out .= do_shortcode( '[video url="' . esc_url( wm_meta_option( 'project-video' ) ) . '"]' );
						$out .= '</div></div> <!-- /video-slider -->';

						$class = ' video';
					break;

					case 'audio-project':
						$audioURL = wm_meta_option( 'project-audio' );

						$out .= '<div class="wrap-inner"><div id="audio-slider" class="audio-slider slider-content no-cover twelve pane">';
						//Post featured image
						if ( has_post_thumbnail( $postId ) )
							$out .= get_the_post_thumbnail( $postId, $imageSize );
						$out .= strip_tags( wp_oembed_get( esc_url( $audioURL ) ), '<iframe>' );
						$out .= '</div></div> <!-- /audio-slider -->';

						$class = ' audio';
					break;

					case 'static-project':
						$imageArray = wm_meta_option( 'project-image' );

						if ( isset( $imageArray['url'] ) && isset( $imageArray['id'] ) ) {
							//Post featured image
							$attachment = get_post( $imageArray['id'] );
							if ( empty( $attachment ) )
								return;

							$imageSrc   = wp_get_attachment_image_src( $imageArray['id'], $imageSize );
							$attachment = get_post( $imageArray['id'] );
							$imageAlt   = get_post_meta( $imageArray['id'], '_wp_attachment_image_alt', true );
							$imageTitle = '';
							if ( is_object( $attachment ) && ! empty( $attachment ) ) {
								$imageTitle  = $attachment->post_title;
								$imageTitle .= ( $attachment->post_excerpt ) ? ( ' - ' . $attachment->post_excerpt ) : ( '' );
							}

							$out .= '<div id="static-slider" class="static-slider slider-content img-content">';
							$out .= '<img src="' . $imageSrc[0] . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';
							$out .= '</div> <!-- /static-slider -->';
						}
					break;

				//Map
					case 'map':
						//get map height
						$height = ( wm_meta_option( 'map-height' ) ) ? ( ' style="height: ' . wm_meta_option( 'map-height' ) . 'px"' ) : ( ' style="height: 300px"' );

						//get map locations
						$locations = wm_meta_option( 'map-gps' );
						if ( ! ( is_array( $locations ) && isset( $locations[0]['attr'] ) && $locations[0]['attr'] ) )
							$locations = array( array( 'attr' => '0,0', 'val' => '' ) );

							//create JavaScript array of GPS and info bubble text
							$locationsArray = array();
							$i = -1;
							foreach ( $locations as $location ) {
								$infoBubbleText   = ( isset( $location['val'] ) ) ? ( $location['val'] ) : ( '' );
								$locationsArray[] = '[' . preg_replace( '/[^0-9,.-]/', '', $location['attr'] ) . ',"' . trim( addslashes( $infoBubbleText ) ) . '"]';
							}
							$locationsArray = '[' . implode( ',', $locationsArray ) . ']';

						if ( ! empty( $locations ) ) {
							$mapStyleJSON = ( trim( wm_option( 'design-map-custom' ) ) ) ? ( preg_replace( '/\s+/', ' ', trim( wm_option( 'design-map-custom' ) ) ) ) : ( 'null' );
							$markerInvert = ( 'default' != wm_meta_option( 'map-style' ) ) ? ( trim( wm_option( 'design-map-custom-marker' ) ) ) : ( '' );

							$out .= '<div id="map" class="map"' . $height . '></div>';
							$out .= '
								<script><!--
									var mapName   = "' . __( 'Custom', 'lespaul_domain' ) . '",
									    mapStyle  = "' . wm_meta_option( 'map-style' ) . '",
									    mapZoom   = ' . absint( wm_meta_option( 'map-zoom' ) ) . ',
									    mapCoords = ' . $locationsArray . ',
									    mapInfo   = "'. str_replace( '"', '\"', do_shortcode( wm_meta_option( 'map-info' ) ) ) . '",
									    mapCenter = ' . absint( wm_meta_option( 'map-center' ) ) . ',
									    themeImgs = "' . WM_ASSETS_THEME . 'img/",
									    styleMap  = ' . $mapStyleJSON . ',
									    imgInvert = "' . $markerInvert . '",
									    pinBounce = ' . absint( wm_option( 'design-map-bounce-marker' ) ) . ';
								//--></script>' . "\r\n\r\n";
						} else {
							$out .= '<div class="wrap-inner"><div class="twelve pane"><br /><div class="box color-red text-center"><h3>' . __( 'Please, set the map location', 'lespaul_domain' ) . '</h3></div></div></div>';
						}
					break;

				//Default fallbacks
					case 'none':
					break;

					default:
					break;

			} // /switch

			//slider background color class
			$class .= ( wm_css_background( 'design-slider-' ) ) ? ( ' set-bg' ) : ( null );
			$class .= wm_element_width( 'slider' );

			if ( $out && ! is_page_template( 'page-template/map.php' ) )
				echo '<section id="slider" class="wrap clearfix slider-main-wrap slider' . $class . '"' . $styles . '>' . $out . '</section>';
			elseif ( $out && is_page_template( 'page-template/map.php' ) )
				echo '<section id="map-section" class="wrap clearfix map-section">' . $out . '</section>';
		}
	} // /wm_slider





/*
*****************************************************
*      11) HEADER AND FOOTER FUNCTIONS
*****************************************************
*/
	/*
	* Prints logo
	*/
	if ( ! function_exists( 'wm_logo' ) ) {
		function wm_logo() {
			$separator = ' | ';
			$logoType  = ( wm_option( 'branding-logo-type' ) ) ? ( wm_option( 'branding-logo-type' ) ) : ( 'img' );
			$skin      = ( wm_option( 'design-skin' ) ) ? ( '/' . str_replace( '.css', '', wm_option( 'design-skin' ) ) ) : ( '' );
			$logoSize  = explode( ',', WM_DEFAULT_LOGO_SIZE );

			//logo image (highDPI ready)
			$logoImage = array( wm_option( 'branding-logo-img' ), wm_option( 'branding-logo-img-highdpi' ) );
			if ( isset( $logoImage[0]['url'] ) && isset( $logoImage[0]['id'] ) ) {
				$logoURL     = wp_get_attachment_image_src( $logoImage[0]['id'], 'full' );
				$highDPIlogo = ( isset( $logoImage[1]['url'] ) && isset( $logoImage[1]['id'] ) ) ? ( wp_get_attachment_image_src( $logoImage[1]['id'], 'full' ) ) : ( array( '' ) );

				$atts = array(
						'alt'   => sprintf( __( '%s logo', 'lespaul_domain' ), trim( get_bloginfo( 'name' ) ) ),
						'title' => esc_attr( get_bloginfo( 'name' ) . $separator . get_bloginfo( 'description' ) ),
						'class' => '',
						'data-highdpi' => ( $highDPIlogo[0] ) ? ( $highDPIlogo[0] ) : ( $logoURL[0] ),
					);
				$logoImage = wp_get_attachment_image( $logoImage[0]['id'], 'full', false, $atts );
			} else {
				$logoURL     = WM_ASSETS_THEME . 'img/branding' . $skin . '/logo-' . WM_THEME_SHORTNAME . '.png';
				$highDPIlogo = WM_ASSETS_THEME . 'img/branding' . $skin . '/logo-' . WM_THEME_SHORTNAME . '@2x.png';
				$logoImage   = '<img width="' . $logoSize[0] . '" height="' . $logoSize[1] . '" src="' . $logoURL . '" alt="' . sprintf( __( '%s logo', 'lespaul_domain' ), trim( get_bloginfo( 'name' ) ) ) . '" title="' . get_bloginfo( 'name' ) . $separator . get_bloginfo( 'description' ) . '" data-highdpi="' . $highDPIlogo . '" />';
			}

			//SEO logo HTML tag
			if ( is_front_page() )
				$logoTag = 'h1';
			else
				$logoTag = 'div';

			//output
			$out  = '<' . $logoTag . ' class="logo ' . $logoType . '-only">';
			$out .= '<a href="' . home_url() . '" title="' . get_bloginfo( 'name' ) . $separator . get_bloginfo( 'description' ) . '">';
			if ( 'text' === $logoType )
				$out .= '<span class="text-logo">' . get_bloginfo( 'name' ) . '</span>';
			else
				$out .= $logoImage . '<span class="invisible">' . get_bloginfo( 'name' ) . '</span>';

			if ( get_bloginfo( 'description' ) )
				$out .= '<span class="description">' . get_bloginfo( 'description' ) . '</span>';
			$out .= '</a>';
			$out .= '</' . $logoTag . '>';

			echo $out;
		}
	} // /wm_logo



	/*
	* Prints favicon and touch icon
	*/
	if ( ! function_exists( 'wm_favicon' ) ) {
		function wm_favicon() {
			$out = '';

			if ( wm_option( 'branding-touch-icon-url-144' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( wm_option( 'branding-touch-icon-url-144' ) ) . '" /> <!-- for retina iPad -->' . "\r\n";
			if ( wm_option( 'branding-touch-icon-url-114' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( wm_option( 'branding-touch-icon-url-114' ) ) . '" /> <!-- for retina iPhone -->' . "\r\n";
			if ( wm_option( 'branding-touch-icon-url-72' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . esc_url( wm_option( 'branding-touch-icon-url-72' ) ) . '" /> <!-- for legacy iPad -->' . "\r\n";
			if ( wm_option( 'branding-touch-icon-url-57' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( wm_option( 'branding-touch-icon-url-57' ) ) . '" /> <!-- for non-retina devices -->' . "\r\n";

			if ( wm_option( 'branding-favicon-url-png' ) )
				$out .= '<link rel="icon" type="image/png" href="' . esc_url( wm_option( 'branding-favicon-url-png' ) ) . '" /> <!-- standard favicon -->' . "\r\n";
			if ( wm_option( 'branding-favicon-url-ico' ) )
				$out .= '<link rel="shortcut icon" href="' . esc_url( wm_option( 'branding-favicon-url-ico' ) ) . '" /> <!-- IE favicon -->' . "\r\n";

			if ( $out )
				$out = "<!-- icons and favicon -->\r\n$out\r\n";

			echo $out;
		}
	} // /wm_favicon



	/*
	* Prints copyright text
	*/
	if ( ! function_exists( 'wm_credits' ) ) {
		function wm_credits( $class = null, $topButton = true ) {
			$copyText = '';
			if ( is_page_template( 'page-template/landing.php' ) && wm_meta_option( 'landing-credits' ) )
				$copyText = wm_meta_option( 'landing-credits' );
			elseif ( is_page_template( 'page-template/construction.php' ) && wm_meta_option( 'construction-credits' ) )
				$copyText = wm_meta_option( 'construction-credits' );
			elseif ( wm_option( 'footer-credits' ) )
				$copyText = wm_option( 'footer-credits' );
			else
				$copyText = '&copy; ' . get_bloginfo( 'name' );

			$replaceArray = array(
				'YEAR' => date( 'Y' )
			);
			$copyText = strtr( $copyText, $replaceArray );
			?>
			<!-- CREDITS -->
			<div class="credits<?php if ( $class ) echo ' ' . $class; ?>">
				<?php echo apply_filters( 'wm_default_content_filters', $copyText ); ?>
			</div> <!-- /credits -->
			<?php
			if ( $topButton )
					echo '<a href="#top" class="top-of-page wmicon-up" title="' . __( 'Back to top of page', 'lespaul_domain' ) . '"><span>' . __( 'Back to top', 'lespaul_domain' ) . '</span></a>';
		}
	} // /wm_credits





/*
*****************************************************
*      12) SEO AND TRACKING FUNCTIONS
*****************************************************
*/
	/*
	* SEO website title
	*/
	if ( ! function_exists( 'wm_seo_title' ) ) {
		function wm_seo_title( $title, $sep ) {
			global $page, $paged;

			if ( ! isset( $paged ) )
				$paged = 0;
			if ( ! isset( $page ) )
				$page = 0;

			$sep   = ( wm_option( 'seo-meta-title-separator' ) ) ? ( ' ' . strip_tags( wm_option( 'seo-meta-title-separator' ) ) . ' ' ) : ( ' | ' );
			$title = ( is_singular() && wm_meta_option( 'seo-title' ) ) ? ( wm_meta_option( 'seo-title' ) ) : ( $title );

			if ( is_feed() )
				return $title;

			if ( is_tag() ) {
			//tag archive

				$title = sprintf( __( 'Tag archive for "%s"', 'lespaul_domain' ), single_tag_title( '', false ) ) . $sep;

			} elseif ( is_search() ) {
			//search

				$title = sprintf( __( 'Search for "%s"', 'lespaul_domain' ), get_search_query() ) . $sep;

			} elseif ( is_archive() ) {
			//general archive

				$title = sprintf( __( 'Archive for %s', 'lespaul_domain' ), $title ) . $sep;

			} elseif ( is_singular() && ! is_404() && ! is_front_page() && ! is_home() ) {
			//is page or post but not 404, front page nor home page post list

				$title = trim( $title ) . $sep;

			} elseif ( is_404() ) {
			//404 page

				$title = ( wm_option( 'p404-title' ) ) ? ( wm_option( 'p404-title' ) . $sep ) : ( __( 'Web page was not found', 'lespaul_domain' ) . $sep );

			} elseif ( is_home() && get_option( 'page_for_posts' ) ) {
			//post page (if set) - get the actual page title

				$title = get_the_title( get_option( 'page_for_posts' ) ) . $sep;

			}

			$title .= get_bloginfo( 'name' );

			//front page
			if ( is_front_page() )
				$title .= $sep . get_bloginfo( 'description' );

			//paginated
			if ( 1 < $paged )
				$title .= sprintf( __( ' (page %s)', 'lespaul_domain' ), $paged );
			//article parts
			if ( 1 < $page )
				$title .= sprintf( __( ' (part %s)', 'lespaul_domain' ), $page );

			return esc_attr( $title );
		}
	} // /wm_seo_title



	/*
	* Prints footer scripts (analytics)
	*/
	if ( ! function_exists( 'wm_scripts_footer' ) ) {
		function wm_scripts_footer() {
			if ( wm_option( 'tracking-no-logged' ) && is_user_logged_in() && current_user_can( wm_option( 'tracking-no-logged' ) ) )
				return;

			$code = wm_option( 'tracking-custom-footer' );

			if ( is_page() && is_page_template( 'page-template/landing.php' ) )
				$code = wm_meta_option( 'landing-tracking' );

			echo $code . "\r\n";
		}
	} // /wm_scripts_footer





/*
*****************************************************
*      13) POST/PAGE FUNCTIONS
*****************************************************
*/
	/*
	* H1 or H2 headings (on singular pages also checks for subtitle)
	*
	* $list = TEXT [if set, outputs H2 instead of H1]
	* $wrap = HTML ["span" inside H1/H2 text wrapper]
	*/
	if ( ! function_exists( 'wm_heading' ) ) {
		function wm_heading( $list = null, $wrap = null ) {
			if ( is_page_template( 'page-template/construction.php' ) || is_404() )
				return;

			global $post, $page, $paged, $wp_query;

			if ( ! isset( $paged ) )
				$paged = 0;
			if ( ! isset( $page ) )
				$page = 0;

			$authorInfo   = '';
			$blogPageId   = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			$subheading   = ( ! is_archive() ) ? ( wm_meta_option( 'subheading', $blogPageId ) ) : ( '' );
			$headingAlign = wm_meta_option( 'main-heading-alignment', $blogPageId );

			$headingAlign = ( $headingAlign ) ? ( $headingAlign ) : ( wm_option( 'design-main-heading-alignment' ) );

			if ( is_search() && ! is_home() && ! class_exists( 'Woocommerce' ) )
				$subheading = sprintf( __( 'Number of items found: %s', 'lespaul_domain' ), $wp_query->found_posts );

			if ( is_author() && 2 > $paged ) {
				$userID = $wp_query->query_vars['author'];

				$authorDescription = get_the_author_meta( 'description', $userID );

				if ( $authorDescription ) {
					$authorDescription = '<div class="desc">' . $authorDescription . '</div>';

					$authorWebsite = ( get_the_author_meta( 'user_url', $userID ) ) ? ( '<div class="website"><a href="' . esc_url( get_the_author_meta( 'user_url', $userID ) ) . '">' . __( "Visit author's website", 'lespaul_domain' ) . '</a></div>' ) : ( '' );
					$authorAvatar  = get_avatar( $userID, 180 );
					$authorName    = get_the_author_meta( 'display_name', $userID );

					$authorSocial = array();
					if ( get_the_author_meta( 'facebook', $userID ) )
						$authorSocial[] = '[social url="' . esc_url( get_the_author_meta( 'facebook', $userID ) ) . '" icon="Facebook" title="' . sprintf( __( '%s on Facebook', 'lespaul_domain' ), $authorName ) . '" size="m"]';
					if ( get_the_author_meta( 'googleplus', $userID ) )
						$authorSocial[] = '[social url="' . esc_url( get_the_author_meta( 'googleplus', $userID ) ) . '" icon="Google+" title="' . sprintf( __( '%s on Google+', 'lespaul_domain' ), $authorName ) . '" size="m" rel="me"]';
					if ( get_the_author_meta( 'twitter', $userID ) )
						$authorSocial[] = '[social url="' . esc_url( get_the_author_meta( 'twitter', $userID ) ) . '" icon="Twitter" title="' . sprintf( __( '%s on Twitter', 'lespaul_domain' ), $authorName ) . '" size="m"]';
					$authorSocial = ( ! empty( $authorSocial ) ) ? ( '<div class="socials">' . implode( ' ', $authorSocial ) . '</div>' ) : ( '' );

					$authorInfo = apply_filters( 'wm_default_content_filters', $authorAvatar . $authorDescription . $authorWebsite . $authorSocial );
				}
			}

			if ( is_attachment() && ! empty( $post->post_parent ) )
				$subheading = '<a href="' . get_permalink( $post->post_parent ) . '" title="' . esc_attr( sprintf( __( 'Return to %s', 'lespaul_domain' ), strip_tags( get_the_title( $post->post_parent ) ) ) ) . '">&laquo; ' . get_the_title( $post->post_parent ) . '</a>';

			//List title
			if ( isset( $list ) && $list ) {
				$out = '';

				if ( has_post_format( 'status' ) )
					$out .= ( get_the_title() ) ? ( get_the_title() ) : ( '' );
				else
					$out .= ( get_the_title() ) ? ( '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' ) : ( '' );

				$titleSticky = '';
				if ( is_sticky() )
					$titleSticky = ' title="' . __( 'This is featured post', 'lespaul_domain' ) . '"';

				$output =  ( $out ) ? ( '<h2 class="post-title"' . $titleSticky . '>' . $out . '</h2>' ) : ( '' );

				//output
				echo $output;
				return;
			}

			//Main H1 title
			$out = '';
			if ( is_singular() || $blogPageId ) {
			//post or page

				$title = ( isset( $wrap ) && $wrap ) ? ( '<' . $wrap . '>' . get_the_title( $blogPageId ) . '</' . $wrap . '>' ) : ( get_the_title( $blogPageId ) );
				if ( 1 < $page )
					$out .= ( $title ) ? ( '<a href="' . get_permalink() . '">' . $title . '</a> <small>(part ' . $page . ')</small>' ) : ( '' );
				else
					$out .= ( $title ) ? ( $title ) : ( '' );

			} elseif ( is_day() ) {
			//dayly archives

				$out .= sprintf( __( 'Daily Archives: <span>%s</span>', 'lespaul_domain' ), get_the_date() );

			} elseif ( is_month() ) {
			//monthly archives

				$out .= sprintf( __( 'Monthly Archives: <span>%s</span>', 'lespaul_domain' ), get_the_date( 'F Y' ) );

			} elseif ( is_year() ) {
			//yearly archives

				$out .= sprintf( __( 'Yearly Archives: <span>%s</span>', 'lespaul_domain' ), get_the_date( 'Y' ) );

			} elseif ( is_author() ) {
			//author archive

				$userID = $wp_query->query_vars['author'];

				$out .= sprintf( __( 'Posts by <span>%s</span>', 'lespaul_domain' ), get_the_author_meta( 'display_name', $userID ) );

			} elseif ( is_category() ) {
			//category archive

				$out .= sprintf( __( 'Posts in <span>%s</span> Category', 'lespaul_domain' ), single_cat_title( '', false ) );

			} elseif ( is_tag() ) {
			//tag archive

				$out .= sprintf( __( 'Posts Tagged "<span>%s</span>"', 'lespaul_domain' ), single_tag_title( '', false ) );

			} elseif ( is_search() ) {
			//search

				$out .= sprintf( __( 'Search results for <span>"%s"</span>', 'lespaul_domain' ), get_search_query() );

			} elseif ( is_tax( 'project-category' ) ) {
			//custom taxonomy

				$portfolioPage   = wm_option( 'general-breadcrumbs-portfolio-page' );
				$portfolioPageID = wm_page_slug_to_id( $portfolioPage );
				$portfolioPage   = ( $portfolioPageID ) ? ( get_the_title( $portfolioPageID ) . ' / ' ) : ( '' );

				$out .= $portfolioPage . $wp_query->queried_object->name;

			} else {
			//other situations

				$out .= ( wm_option( 'pages-default-archives-title' ) ) ? ( wm_option( 'pages-default-archives-title' ) ) : ( '' );

			}

			//WooCommerce titles
				if ( class_exists( 'Woocommerce' ) && ! $out ) {
					global $shop_page_title;
					$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
					$out = apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) )  ? $shop_page_title : $shop_page->post_title );
				}

			//paged
			$out .= ( 1 < $paged ) ? ( ' <small>(page ' . $paged . ')</small>' ) : ( '' );

			//post, page title and subtitle display
			$class = $classContainer = '';
			if ( wm_meta_option( 'no-heading', $blogPageId ) || ! $out ) {
				$class           = ( ( is_singular() || is_home() ) && $subheading ) ? ( 'invisible' ) : ( '' );
				$classContainer .= ( ( is_singular() || is_home() ) && ! $subheading ) ? ( ' invisible' ) : ( ' visible' );
			} else {
				$classContainer .= ' visible';
			}

			$subtitleH2      = ( $subheading ) ? ( '<h2 class="subtitle">' . do_shortcode( $subheading ) . '</h2>' ) : ( '' );
			$subtitleH2      = ( $authorInfo ) ? ( '<div class="authorinfo">' . $authorInfo . '</div>' ) : ( $subtitleH2 );
			$classContainer .= ( $subtitleH2 ) ? ( ' has-subtitle' ) : ( '' );
			$wrapper         = $wrapperEnd = '';

			//main heading background color class
			$classContainer .= ( wm_css_background( 'design-main-heading-' ) ) ? ( ' set-bg' ) : ( '' );
			$classContainer .= ( ( is_singular() || is_home() ) && $headingAlign ) ? ( ' text-' . $headingAlign ) : ( '' );

			//icon
			$headingIcon     = ( ! wm_meta_option( 'main-heading-icon', $blogPageId ) || is_archive() || is_search() ) ? ( '' ) : ( '<i class="' . wm_meta_option( 'main-heading-icon', $blogPageId ) . '"></i>' );
			$classContainer .= ( ! wm_meta_option( 'main-heading-icon', $blogPageId ) || is_archive() || is_search() ) ? ( '' ) : ( ' has-icon' );

			//wrapper width
			$classContainer .= wm_element_width( 'mainheading' );

			//CSS3 animations
			$classContainer .= ( ! wm_option( 'design-no-animation-heading' ) ) ? ( ' animated' ) : ( '' );

			$before = '<header id="main-heading" class="main-heading wrap clearfix' . $classContainer . '"><div class="no-overflow"><div class="wrap-inner"><div class="twelve pane">';
			$after  = '</div></div></div></header>';

			$mainHeadingTag = ( ! is_front_page() ) ? ( '1' ) : ( '2' );
			if ( is_front_page() )
				$class .= ' h1-style';
			if ( $class )
				$class = ' class="' . trim( $class ) . '"';

			//output
			echo $before . $wrapper . $headingIcon . '<h' . $mainHeadingTag . $class . '>' . $out . '</h' . $mainHeadingTag . '>' . $subtitleH2 . $wrapperEnd . $after;
		}
	} // /wm_heading



	/**
	* Thumbnail image
	*
	* @param $args [ARRAY: array of different function options (see below)]
	*
	* @return HTML of post thumbnail in image container
	*/
	if ( ! function_exists( 'wm_thumb' ) ) {
		function wm_thumb( $args = array() ) {
			$args = wp_parse_args( $args, array(
					'a-attributes' => '',          //TEXT: additional <A> HTML tag parameters (like " target='_blank'" for example)
					'class'        => '',          //TEXT: image container additional CSS class name
					'img-attr'     => null,        //ARRAY: check WordPress codex on this
					'link'         => true,        //BOOLEAN = whether to apply a permalink, TEXT = either 'modal' or URL, ARRAY = [url, class]
					'list'         => false,       //BOOLEAN: set to use post permalink in [posts] even when shortcode on single post or page (@todo: test this, not sure if still required...)
					'overlay'      => '',          //TEXT: link overlay content
					'placeholder'  => false,       //BOOLEAN: whether to display placeholder image if featured image does not exist
					'post'         => null,        //OBJECT: WordPress post object
					'size'         => 'thumbnail', //TEXT: image size
				) );

			$post = $args['post'];
			if ( ! $post )
				global $post;

			$attachment         = ( has_post_thumbnail() ) ? ( get_post( get_post_thumbnail_id( $post->ID ) ) ) : ( '' );
			$attachmentTitle[0] = ( isset( $attachment->post_title ) ) ? ( trim( strip_tags( $attachment->post_title ) ) ) : ( '' );
			$attachmentTitle[1] = ( isset( $attachment->post_excerpt ) ) ? ( trim( strip_tags( $attachment->post_excerpt ) ) ) : ( '' );

			$args['img-attr'] = wp_parse_args( $args['img-attr'], array( 'title' => $attachmentTitle[0] ) );

			$attachmentTitle = esc_attr( implode( ' | ', array_filter( $attachmentTitle ) ) );

			$anchorClass = '';

			$theClass      = ( $args['class'] ) ? ( ' ' . esc_attr( $args['class'] ) ) : ( '' );
			$image         = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, $args['size'], $args['img-attr'] ) ) : ( '' );
			$image         = ( ! $image && $args['placeholder'] ) ? ( '<img src="' . WM_ASSETS_THEME . 'img/placeholder/' . $args['size'] . '.png" alt="" />' ) : ( $image );
			$largeImageUrl = ( has_post_thumbnail() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), wm_option( 'general-lightbox-img' ) ) ) : ( array( '' ) );

			if ( is_array( $args['link'] ) ) {
				$linkURL = $largeImageUrl[0] = $args['link'][0];
				$anchorClass = ' class="' . $args['link'][1] . '"';
			} elseif ( false === strpos( $args['link'], 'http' ) ) {
				if ( 'modal' === $args['link'] && $largeImageUrl[0] )
					$linkURL = $largeImageUrl[0];
				elseif ( 'modal' !== $args['link'] )
					$linkURL = get_permalink();
				else
					$linkURL = '';
			} else {
				$linkURL = $largeImageUrl[0] = $args['link'];
			}

			if ( $args['overlay'] )
				$args['overlay'] = '<span class="overlay">' . $args['overlay'] . '</span>';

			$out = '';
			if ( is_singular() && isset( $post->ID ) && ! $args['list'] ) {

				if ( $image ) {
					$out .= '<div class="image-container' . $theClass . '">';
					$out .= ( $args['link'] ) ? ( '<a href="' . $largeImageUrl[0] . '"' . $args['a-attributes'] . $anchorClass . ' title="' . $attachmentTitle . '">' ) : ( '' );
					$out .= $image;
					$out .= ( $args['link'] ) ? ( $args['overlay'] . '</a>' ) : ( '' );
					$out .= '</div>';
				}

			} else {

				if ( $image ) {
					$out .= '<div class="image-container' . $theClass . '">';
					$out .= ( $args['link'] && $linkURL ) ? ( '<a href="' . $linkURL . '"' . $args['a-attributes'] . $anchorClass . ' title="' . $attachmentTitle . '">' ) : ( '' );
					$out .= $image;
					$out .= ( $args['link'] && $linkURL ) ? ( $args['overlay'] . '</a>' ) : ( '' );
					$out .= '</div>';
				}

			}

			return $out;
		}
	} // /wm_thumb



	/**
	* Get all images attached to the post
	*
	* @param $numberposts [INT: number of images to get (-1 = all)]
	* @param $post_id     [ABSINT: specific post id, else current post id used]
	* @param $size        [TEXT: image size]
	*
	* @return array of images (array keys: name, id, img, title, alt)
	*/
	if ( ! function_exists( 'wm_get_post_images' ) ) {
		function wm_get_post_images( $post_id = null, $size = null, $numberposts = -1 ) {
			global $post;
			if ( ! $post_id && ! $post )
				return;

			$post_id     = ( $post_id ) ? ( absint( $post_id ) ) : ( $post->ID );
			$size        = ( $size ) ? ( $size ) : ( 'widget' );
			$outputArray = array();

			$args = array(
				'numberposts'    => $numberposts,
				'post_parent'    => $post_id,
				'orderby'        => 'menu_order',
				'order'          => 'asc',
				'post_mime_type' => 'image',
				'post_type'      => 'attachment'
				);
			$images =& get_children( $args );

			if ( ! empty( $images ) ) {
				foreach ( $images as $attachment_id => $attachment ) {
					$imgUrlArray    = wp_get_attachment_image_src( $attachment_id, $size );
					$imgTitle       = trim( strip_tags( $attachment->post_title ) );
					$imgCaption     = trim( strip_tags( $attachment->post_excerpt ) );

					$entry          = array();
					$entry['name']  = ( $imgCaption ) ? ( esc_attr( $imgTitle . ' - ' . $imgCaption ) ) : ( esc_attr( $imgTitle ) );
					$entry['id']    = esc_attr( $attachment_id );
					$entry['img']   = $imgUrlArray[0];
					$entry['title'] = esc_attr( $imgTitle );
					$entry['alt']   = esc_attr( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

					$outputArray[]  = $entry;
				}
			}

			return $outputArray;
		}
	} // /wm_get_post_images



	/*
	* Media uploader image sizes
	*
	* $sizes = ARRAY [check WordPress codex on this]
	*/
	if ( ! function_exists( 'wm_media_uploader_image_sizes' ) ) {
		function wm_media_uploader_image_sizes( $sizes ) {
			$sizes['content-width'] = __( 'Content width', 'lespaul_domain_panel' );

			return $sizes;
		}
	} // /wm_media_uploader_image_sizes



	/*
	* Additional file uploader mime types
	*/
	if ( ! function_exists( 'wm_custom_mime_types' ) ) {
		function wm_custom_mime_types( $mimes ) {
			return array_merge( $mimes, array(
					'ac3' => 'audio/ac3',
					'flv' => 'video/x-flv',
					'ico' => 'image/x-icon'
				) );
		}
	} // /wm_custom_mime_types



	/*
	* Media library filters
	*/
	if ( ! function_exists( 'wm_media_filters' ) ) {
		function wm_media_filters( $mimes ) {
			//multimedia
			$mimes['image/x-icon'] = array(
					__( 'Icons', 'lespaul_domain_adm' ),
					__( 'Manage icons', 'lespaul_domain_adm' ),
					_n_noop( 'Icon <span class="count">(%s)</span>', 'Icons <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/x-shockwave-flash'] = array(
					__( 'SWFs', 'lespaul_domain_adm' ),
					__( 'Manage SWFs', 'lespaul_domain_adm' ),
					_n_noop( 'SWF <span class="count">(%s)</span>', 'SWFs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);

			//office documents
			$mimes['application/msword'] = array(
					__( 'MS Word documents', 'lespaul_domain_adm' ),
					__( 'Manage MS Word documents', 'lespaul_domain_adm' ),
					_n_noop( 'MS Word document <span class="count">(%s)</span>', 'MS Word documents <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/vnd.ms-excel'] = array(
					__( 'MS Excel spreadsheets', 'lespaul_domain_adm' ),
					__( 'Manage MS Excel spreadsheets', 'lespaul_domain_adm' ),
					_n_noop( 'MS Excel spreadsheet <span class="count">(%s)</span>', 'MS Excel spreadsheets <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/vnd.ms-powerpoint'] = array(
					__( 'MS Powerpoint presentations', 'lespaul_domain_adm' ),
					__( 'Manage MS Powerpoint presentations', 'lespaul_domain_adm' ),
					_n_noop( 'MS Powerpoint presentation <span class="count">(%s)</span>', 'MS Powerpoint presentations <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/rtf'] = array(
					__( 'RTFs', 'lespaul_domain_adm' ),
					__( 'Manage RTFs', 'lespaul_domain_adm' ),
					_n_noop( 'RTF <span class="count">(%s)</span>', 'RTFs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/vnd.oasis.opendocument.text'] = array(
					__( 'ODT documents', 'lespaul_domain_adm' ),
					__( 'Manage ODT documents', 'lespaul_domain_adm' ),
					_n_noop( 'ODT document <span class="count">(%s)</span>', 'ODT documents <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/vnd.oasis.opendocument.spreadsheet'] = array(
					__( 'ODS spreadsheets', 'lespaul_domain_adm' ),
					__( 'Manage ODS spreadsheets', 'lespaul_domain_adm' ),
					_n_noop( 'ODS spreadsheet <span class="count">(%s)</span>', 'ODS spreadsheets <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/vnd.oasis.opendocument.presentation'] = array(
					__( 'ODP presentations', 'lespaul_domain_adm' ),
					__( 'Manage ODP presentations', 'lespaul_domain_adm' ),
					_n_noop( 'ODP presentation <span class="count">(%s)</span>', 'ODP presentations <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);

			//pdf
			$mimes['application/pdf'] = array(
					__( 'PDFs', 'lespaul_domain_adm' ),
					__( 'Manage PDFs', 'lespaul_domain_adm' ),
					_n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);

			//packages
			$mimes['application/zip'] = array(
					__( 'ZIPs', 'lespaul_domain_adm' ),
					__( 'Manage ZIPs', 'lespaul_domain_adm' ),
					_n_noop( 'ZIP <span class="count">(%s)</span>', 'ZIPs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/x-gzip'] = array(
					__( 'GZIPs', 'lespaul_domain_adm' ),
					__( 'Manage GZIPs', 'lespaul_domain_adm' ),
					_n_noop( 'GZIP <span class="count">(%s)</span>', 'GZIPs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/rar'] = array(
					__( 'RARs', 'lespaul_domain_adm' ),
					__( 'Manage RARs', 'lespaul_domain_adm' ),
					_n_noop( 'RAR <span class="count">(%s)</span>', 'RARs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);
			$mimes['application/x-msdownload'] = array(
					__( 'EXEs', 'lespaul_domain_adm' ),
					__( 'Manage EXEs', 'lespaul_domain_adm' ),
					_n_noop( 'EXE <span class="count">(%s)</span>', 'EXEs <span class="count">(%s)</span>', 'lespaul_domain_adm' )
				);

			return $mimes;
		}
	} // /wm_media_filters



	/**
	* WP gallery improvements
	*
	* Improves WordPress [gallery] shortcode: removes inline CSS, changes HTML markup to valid, makes it easier to remove images from gallery.
	*
	* @param $attr [ARRAY : check WordPress codex on this]
	*
	* Original source code from wp-includes/media.php
	*/
	if ( ! function_exists( 'wm_shortcode_gallery' ) ) {
		function wm_shortcode_gallery( $output, $attr ) {
			$post = get_post();

			static $instance = 0;
			$instance++;
			//WordPress only passes $attr variable to the filter, so the above needs to be reset

			$output = '';

			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			if ( isset( $attr['orderby'] ) ) {
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( ! $attr['orderby'] )
					unset( $attr['orderby'] );
			}

			extract( shortcode_atts( array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'figure',
				'icontag'    => 'span',
				'captiontag' => 'div',
				'columns'    => 3,
				'size'       => ( wm_option( 'general-gallery-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-gallery-image-ratio' ) ) : ( 'mobile-ratio-169' ),
				'include'    => '',
				'exclude'    => '',
				//custom theme additions:
					'remove'   => '', //remove images by order number
					'flexible' => '', //if set, masonry gallery displayed
					'sardine'  => '', //no margins between gallery images
					'frame'    => '', //frames gallery images
				// /custom theme additions
			), $attr ) );

			//custom theme additions:
				$excludeImages = ( 'exclude' === wm_meta_option( 'gallery' ) || 'excludedGallery' === wm_meta_option( 'gallery' ) ) ? ( wm_meta_option( 'gallery-images' ) ) : ( null );
				if ( is_array( $excludeImages ) && ! empty( $excludeImages ) ) {
					/*
					* WP3.5 generates multiple galleries per post with "ids" parameter (see above) that translates into "include".
					* That's why we need to manage that one too for the theme gallery improvements.
					* Basically, remove all the excluded images from "include" only when "ids" parameter set, otherwise leave include untouched.
					*/
					if ( isset( $attr['ids'] ) && ! empty( $attr['ids'] ) ) {
						$include       = str_replace( ' ', '', $include );
						$includeRemove = explode( ',', $include );
						foreach ( $includeRemove as $key => $value ) {
							if ( in_array( $value, $excludeImages ) )
								unset( $includeRemove[$key] );
						}
						$include = implode( ',', $includeRemove );
					}

					$excludeImages = implode( ',', $excludeImages );
				}

				$exclude = ( $exclude ) ? ( $exclude ) : ( $excludeImages );
				$remove  = preg_replace( '/[^0-9,]+/', '', $remove );
				$remove  = ( $remove ) ? ( explode( ',', $remove ) ) : ( array() );
				$sardine = ( $sardine ) ? ( ' no-margin' ) : ( '' );
				$frame   = ( $frame ) ? ( ' frame' ) : ( '' );
			// /custom theme additions

			$id = intval( $id );
			if ( 'RAND' == $order )
				$orderby = 'none';

			if ( ! empty( $include ) ) {
				$include = preg_replace( '/[^0-9,]+/', '', $include ); //not in WP 3.5 but keeping it
				$_attachments = get_posts( array(
						'include'        => $include,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => $order,
						'orderby'        => $orderby
					) );

				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			} elseif ( ! empty( $exclude ) ) {
				$exclude     = preg_replace( '/[^0-9,]+/', '', $exclude ); //not in WP 3.5 but keeping it
				$attachments = get_children( array(
						'post_parent'    => $id,
						'exclude'        => $exclude,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => $order,
						'orderby'        => $orderby
					) );
			} else {
				$attachments = get_children( array(
						'post_parent'    => $id,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => $order,
						'orderby'        => $orderby
					) );
			}

			if ( empty( $attachments ) || is_feed() )
				return ''; //this will make the default WordPress function to take care of processing

			$itemtag    = tag_escape( $itemtag );
			$captiontag = tag_escape( $captiontag );
			$columns    = absint( $columns );
			$float      = is_rtl() ? 'right' : 'left';

			//custom theme additions:
				$wrapper    = ( 'li' == $itemtag ) ? ( '<ul>' ) : ( '' );
				$wrapperEnd = ( $wrapper ) ? ( '</ul>' ) : ( '' );
				$columns    = ( 1 > $columns || 9 < $columns ) ? ( 3 ) : ( $columns ); //only 1 to 9 columns allowed

				if ( 1 === absint( $columns ) )
					$size = 'content-width';

				$flexible = ( ( $flexible || 'mobile' == $size || 'content-width' == $size ) && 1 < $columns ) ? ( true ) : ( false );

				if ( $flexible ) {
					$flexible = ' masonry-container';
					$size     = 'mobile';
					if ( 1 === absint( $columns ) )
						$size = 'content-width';
					wp_enqueue_script( 'masonry' );
				}
			// /custom theme additions

			$selector   = "gallery-{$instance}";
			$size_class = sanitize_html_class( $size );
			$output     = "<div id='$selector' class='gallery galleryid-{$id} clearfix apply-top-margin gallery-columns-{$columns} gallery-columns gallery-size-{$size_class}{$flexible}'>" . $wrapper; //custom theme additions

			$i = $j = 0; //$i = every image from gallery, $j = only displayed images
			foreach ( $attachments as $id => $attachment ) { //custom theme additions in this foreach
				$fullImgSize = ( wm_option( 'general-lightbox-img' ) ) ? ( wm_option( 'general-lightbox-img' ) ) : ( 'full' );
				$fullImg     = wp_get_attachment_image_src( $id, $fullImgSize, false );
				$imageArray  = wp_get_attachment_image_src( $id, $size, false );
				$titleText   = array( ucfirst( $attachment->post_title ), $attachment->post_excerpt );
				$titleText   = esc_attr( implode( ' - ', array_filter( $titleText ) ) );
				$image       = '<img src="' . $imageArray[0] . '" alt="' . $titleText . '" title="' . $titleText . '" />';
				$link        = '<a href="' . $fullImg[0] . '" title="' . $titleText . '">' . $image . '</a>';

				$i++;

				if ( ! in_array( $i, $remove ) ) {
					if ( ++$j % $columns == 0 )
						$last = ' last';
					else
						$last = '';

					$last .= ( $j <= $columns ) ? ( ' first-row' ) : ( null );

					$output .= "<{$itemtag} class='gallery-item column$sardine col-1{$columns}$last$frame'>";
					$output .= "<{$icontag} class='gallery-icon'>$link</{$icontag}>";
					if ( $captiontag && trim( $attachment->post_excerpt ) ) {
						$output .= "
							<{$captiontag} class='wp-caption-text gallery-caption'>
							" . apply_filters( 'wm_default_content_filters', $attachment->post_excerpt ) . "
							</{$captiontag}>";
					}
					$output .= "</{$itemtag}>";
					if ( $columns > 0 && $i % $columns == 0 )
						$output .= '';
				}
			}

			$output .= $wrapperEnd . "</div>\r\n"; //custom theme additions

			return $output;
		}
	} // /wm_shortcode_gallery

	/**
	* Displays gallery
	*/
	if ( ! function_exists( 'wm_display_gallery' ) ) {
		function wm_display_gallery() {
			global $page, $numpages; //display only on the last page of paged post

			if ( ( 'gallery' === wm_meta_option( 'gallery' ) || 'excludedGallery' === wm_meta_option( 'gallery' ) ) && $numpages === $page ) {
				$columns = wm_meta_option( 'gallery-columns' );
				$images  = wm_meta_option( 'gallery-images' );
				$images  = ( is_array( $images ) && ! empty( $images ) ) ? ( implode( ',', $images ) ) : ( '' );

				echo do_shortcode( '<div class="meta-bottom icon-picture">[gallery columns="' . $columns . '" include="' . $images . '" link="file" /]</div>' );
			}
		}
	} // /wm_display_gallery



	/**
	* WordPress image captions
	*
	* Improves WordPress image captions by removing inline styling.
	*
	* @param $attr [ARRAY : check WordPress codex on this]
	*
	* Original source code from wp-includes/media.php
	*/
	if ( ! function_exists( 'wm_shortcode_image_caption' ) ) {
		function wm_shortcode_image_caption( $val, $attr, $content = null ) {
			extract( shortcode_atts( array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => ''
				), $attr)
				);

			if ( 1 > (int) $width || empty( $caption ) )
				return $content;

			if ( $id )
				$id = 'id="' . esc_attr( $id ) . '" ';

			return '<div ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '"><figure>' . $content . '<figcaption class="wp-caption-text">' . do_shortcode( $caption ) . '</figcaption></figure></div>';
		}
	} // /wm_shortcode_image_caption



	/*
	* Excerpt
	*
	* $length_fn = FN [callback function setting the excerpt length]
	* $more_fn   = FN [callback function setting the "..." string after excerpt]
	*/
	if ( ! function_exists( 'wm_excerpt' ) ) {
		function wm_excerpt( $length_fn = null, $more_fn = null ) {
			if ( $length_fn && is_callable( $length_fn ) )
				add_filter( 'excerpt_length', $length_fn, 999 );
			else
				add_filter( 'excerpt_length', 'wm_excerpt_length_blog', 999 );

			if ( $more_fn && is_callable( $more_fn ) )
				add_filter( 'excerpt_more', $more_fn );
			else
				add_filter( 'excerpt_more', 'wm_excerpt_more' );

			$excerpt = trim( get_the_excerpt() ); //shortcodes are being stripped out by WordPress by default

			$out = '';
			if ( $excerpt ) {
				if ( post_password_required() )
					$excerpt = '<strong>' . __( 'Password protected', 'lespaul_domain' ) . '</strong>';
				$out .= '<div class="excerpt">';
				$out .= apply_filters( 'wm_default_content_filters', $excerpt );
				$out .= '</div>';
			}

			return $out;
		}
	} // /wm_excerpt

	//Page excerpt
	if ( ! function_exists( 'wm_page_excerpt' ) ) {
		function wm_page_excerpt() {
			global $post;

			if ( is_page() || is_home() ) {
				$postId  = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( $post->ID );
				$allowed = ( wm_option( 'access-client-area' ) ) ? ( wm_restriction_page() ) : ( true );

				$excerpt = get_post_meta( $postId, 'page_excerpt', true );

				if ( $excerpt && $allowed ) {
					if ( post_password_required() )
						$excerpt = '<strong>' . __( 'Password protected', 'lespaul_domain' ) . '</strong>';

					echo '<div id="page-excerpt" class="wrap clearfix page-excerpt"><div class="wrap-inner"><div class="twelve pane"><div class="page-excerpt-container clearfix">' . apply_filters( 'wm_default_content_filters', $excerpt ) . '</div></div></div></div>';
				}
			}
		}
	} // /wm_page_excerpt

	/*
	* Different excerpt length callback functions
	*/
	if ( ! function_exists( 'wm_excerpt_length_blog' ) ) {
		function wm_excerpt_length_blog( $length ) {
			$defaultLength = ( wm_option( 'blog-excerpt-length' ) ) ? ( wm_option( 'blog-excerpt-length' ) ) : ( WM_DEFAULT_EXCERPT_LENGTH );
			$customLength  = ( wm_option( 'blog-excerpt-length' ) ) ? ( wm_option( 'blog-excerpt-length' ) ) : ( $defaultLength );
			return $customLength;
		}
	} // /wm_excerpt_length_blog

	if ( ! function_exists( 'wm_excerpt_length_short' ) ) {
		function wm_excerpt_length_short( $length ) {
			$customLength = ( wm_option( 'blog-excerpt-length-short' ) ) ? ( wm_option( 'blog-excerpt-length-short' ) ) : ( 25 );
			return $customLength;
		}
	} // /wm_excerpt_length_short

	if ( ! function_exists( 'wm_excerpt_length_very_short' ) ) {
		function wm_excerpt_length_very_short( $length ) {
			$customLength = ( wm_option( 'blog-excerpt-length-shortest' ) ) ? ( wm_option( 'blog-excerpt-length-shortest' ) ) : ( 10 );
			return $customLength;
		}
	} // /wm_excerpt_length_very_short

	/*
	* Excerpt "more" callback function
	*/
	if ( ! function_exists( 'wm_excerpt_more' ) ) {
		function wm_excerpt_more( $more ) {
			return '&hellip;';
		}
	} // /wm_excerpt_more

	/*
	* Displays excerpt
	*/
	if ( ! function_exists( 'wm_display_excerpt' ) ) {
		function wm_display_excerpt() {
			if ( is_single() && has_excerpt() )
				wm_excerpt( 'wm_excerpt_length_blog', null );
		}
	} // /wm_display_excerpt

	/*
	* Post content or excerpt depending on using <!--more--> tag
	*/
	if ( ! function_exists( 'wm_content_or_excerpt' ) ) {
		function wm_content_or_excerpt( $post ) {
			$out = '';

			if ( isset( $post ) && $post ) {
				if ( false !== stripos( $post->post_content, '<!--more-->' ) ) {
					global $more; //required for <!--more--> tag to work
					$more = 0; //required for <!--more--> tag to work
					$out .= '<div class="excerpt">';
					if ( has_excerpt() && ! post_password_required() )
						$out .= '<div class="excerpt">' . apply_filters( 'wm_default_content_filters', get_the_excerpt() ) . '</div>';

					$out .= ( ! post_password_required() ) ? ( apply_filters( 'wm_default_content_filters', get_the_content( '' ) ) ) : ( '<strong>' . __( 'Password protected', 'lespaul_domain' ) . '</strong>' );
					$out .= '</div>';
					$out .= '<p><a href="' . get_permalink() . '#more-' . $post->ID . '" class="more-link">' . __( 'Continue reading &raquo;', 'lespaul_domain' ) . '</a></p>';
				} else {
					$out .= wm_excerpt( 'wm_excerpt_length_blog', 'wm_excerpt_more' );
					$out .= '<p><a href="' . get_permalink() . '" class="more-link">' . __( 'Continue reading &raquo;', 'lespaul_domain' ) . '</a></p>';
				}
			}

			return $out;
		}
	} // /wm_content_or_excerpt



	/*
	* "Read more" button
	*
	* $print = TEXT ["print" the value]
	* $class = TEXT [like "btn color-green" for example]
	*/
	if ( ! function_exists( 'wm_more' ) ) {
		function wm_more( $class = 'more-link', $print = null ) {
			$out = '<a href="' . get_permalink() . '" class="' . $class . '">' . __( 'Read more &raquo;', 'lespaul_domain' ) . '</a>';

			if ( $print )
				echo $out;
			else
				return $out;
		}
	} // /wm_more



	/*
	* Post meta info
	*
	* $positions = ARRAY [array of meta information positions]
	* $class     = TEXT [like "btn color-green" for example]
	* $tag       = TEXT [wrapper HTML tag]
	*/
	if ( ! function_exists( 'wm_meta' ) ) {
		function wm_meta( $positions = null, $class = null, $tag = 'footer', $print = true ) {
			if ( ! $positions )
				$positions = array(
						'date',
						'author',
						'cats',
						'comments',
						'permalink',
					);

			$out    = '';
			$tag    = ( $tag ) ? ( $tag ) : ( 'footer' );
			$format = ( get_post_format() ) ? ( get_post_format() ) : ( 'standard' );

			if ( ! empty( $positions ) ) {
				foreach ( $positions as $position ) {
					switch ( $position ) {
						case 'permalink':

							if ( ! wm_option( 'blog-disable-permalink' ) )
								$out .= '<span class="permalink meta-item"><a href="' . get_permalink() . '" title="' . esc_attr( sprintf( __( 'Permalink to %s', 'lespaul_domain' ), the_title_attribute( 'echo=0' ) ) ) . '" rel="bookmark"><span>' . get_the_title() . '</span></a></span>';

						break;
						case 'author':

							if ( ! wm_option( 'blog-disable-author' ) )
								$out .= '<span class="author vcard meta-item">' . sprintf( __( 'By %s', 'lespaul_domain' ), '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author">' . get_the_author() . '</a>' ) . '</span>';

						break;
						case 'cats':

							if ( ! wm_option( 'blog-disable-cats' ) )
								$out .= ( get_the_category_list( '' ) ) ? ( '<span class="categories meta-item">' . sprintf( __( 'In %s', 'lespaul_domain' ), get_the_category_list( ', ' ) ) . '</span>' ) : ( '' );

						break;
						case 'comments':

							if ( ! wm_option( 'blog-disable-comments-count' ) && ( comments_open() || get_comments_number() ) ) {
							//comments displayed only when enabled by admin panel AND if the post has comments eventhough commenting disabled for the post now

								$elementId = ( get_comments_number() ) ? ( '#comments' ) : ( '#respond' );
								$out      .= '<span class="comments meta-item"><a href="' . get_permalink() . $elementId . '">' . sprintf( __( 'Comments: %s', 'lespaul_domain' ), '<span class="comments-count" title="' . get_comments_number() . '">' . get_comments_number() . '</span>' ) . '</a></span>';
							}

						break;
						case 'date':

							if ( ! wm_option( 'blog-disable-date' ) )
								$out .= '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="date meta-item" title="' . esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time() ) . '">' . esc_html( get_the_date() ) . '</time>';

						break;
						case 'tags':

							if ( ! wm_option( 'blog-disable-tags' ) )
								$out .= ( get_the_tag_list( '', '', '' ) ) ? ( '<span class="tags meta-item">' . sprintf( __( '<strong>Tags:</strong> %s', 'lespaul_domain' ), get_the_tag_list( '', ', ', '' ) ) . '</span>' ) : ( '' );

						break;
						default:
						break;
					} // /switch
				} // /foreach

				$out = ( $out ) ? ( '<' . $tag . ' class="meta-article clearfix ' . $class . '">' . $out . '</' . $tag . '>' ) : ( '' );
			} // /if $position

			if ( $print )
				echo $out;
			else
				return $out;
		}
	} // /wm_meta



	/*
	* Post/page parts pagination
	*/
	if ( ! function_exists( 'wm_post_parts' ) ) {
		function wm_post_parts() {
			wp_link_pages( array(
				'before'         => '<p class="pagination post">',
				'after'          => '</p>',
				'next_or_number' => 'number',
				'pagelink'       => '<span class="page-numbers">' . __( 'Part %', 'lespaul_domain' ) . '</span>',
			) );
		}
	} // /wm_post_parts



	/*
	* Post author info
	*/
	if ( ! function_exists( 'wm_author_info' ) ) {
		function wm_author_info() {
			if (
					is_page() ||
					( is_single() && 'post' != get_post_type() ) ||
					wm_meta_option( 'author' ) ||
					( is_single() && wm_option( 'blog-disable-bio' ) ) ||
					is_attachment()
				)
				return;

			$authorDescription = get_the_author_meta( 'description' );

			if ( $authorDescription ) {

				$authorDescription = explode( '<!--more-->', $authorDescription ); //allows using WordPress more tag to display short description on single posts and full info on author archives pages

				$authorName     = get_the_author_meta( 'display_name' );
				$authorWebsite  = ( get_the_author_meta( 'user_url' ) ) ? ( ' <small><a href="' . esc_url( get_the_author_meta( 'user_url' ) ) . '">' . __( "Visit author's website", 'lespaul_domain' ) . '</a></small>' ) : ( '' );
				$authorPostsUrl = get_author_posts_url( get_the_author_meta( 'ID' ) );
				$authorAvatar   = get_avatar( get_the_author_meta( 'ID' ), 180 );

				$out  = '<div class="bio meta-bottom clearfix">';
				$out .= '<div class="author-info"><div class="avatar-container"><a href="' . $authorPostsUrl . '">' . $authorAvatar . '</a></div><div class="author-details">';

				$outSocial = array();
				if ( get_the_author_meta( 'facebook' ) )
					$outSocial[] = '[social url="' . esc_url( get_the_author_meta( 'facebook' ) ) . '" icon="Facebook" title="' . sprintf( __( '%s on Facebook', 'lespaul_domain' ), $authorName ) . '" size="s"]';
				if ( get_the_author_meta( 'googleplus' ) )
					$outSocial[] = '[social url="' . esc_url( get_the_author_meta( 'googleplus' ) ) . '" icon="Google+" title="' . sprintf( __( '%s on Google+', 'lespaul_domain' ), $authorName ) . '" size="s" rel="me"]';
				if ( get_the_author_meta( 'twitter' ) )
					$outSocial[] = '[social url="' . esc_url( get_the_author_meta( 'twitter' ) ) . '" icon="Twitter" title="' . sprintf( __( '%s on Twitter', 'lespaul_domain' ), $authorName ) . '" size="s"]';

				$out .= '<h3 class="mt0"><small>' . __( 'By', 'lespaul_domain' ) . '</small> <a href="' . $authorPostsUrl . '"><strong>' . $authorName . '</strong></a>';

				if ( $outSocial )
					$out .= '<span class="author-social-links">' . implode( ' ', $outSocial ) . $authorWebsite . '</span>';

				$out .= '</h3>';

				$out .= '<div class="desc">' . do_shortcode( wptexturize( trim( $authorDescription[0] ) ) ) . '</div>';

				if ( wm_option( 'blog-author-posts' ) ) {
					wp_reset_query();
					$ordering  = ( wm_option( 'blog-author-posts-order' ) ) ? ( trim( wm_option( 'blog-author-posts-order' ) ) ) : ( 'rand' );
					$queryArgs = array(
							'author'         => get_the_author_meta( 'ID' ),
							'posts_per_page' => absint( wm_option( 'blog-author-posts' ) ),
							'orderby'        => $ordering,
							'post__not_in'   => array( get_the_ID() )
						);
					$authorPosts = new WP_Query( $queryArgs );
					if ( $authorPosts->have_posts() ) {
						$out .= '<h5>' . __( 'More from author:', 'lespaul_domain' ) . '</h5>';
						$out .= '<ul class="posts-by-author">';
						while ( $authorPosts->have_posts() ) {
							$authorPosts->the_post();
							$postFormat = ( get_post_format() ) ? ( get_post_format() ) : ( 'standard' );
							$out .= '<li class="wmicon-' . $postFormat . '"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
						}
						$out .= '</ul>';
					}
					wp_reset_query();
				}

				$out .= '</div></div><!-- /bio --></div>';

				echo do_shortcode( $out );

			}
		}
	} // /wm_author_info



	/*
	* Prints no content found message
	*/
	if ( ! function_exists( 'wm_not_found' ) ) {
		function wm_not_found() {
			$out  = '<article class="not-found">';
			$out .= '<h2>' . __( 'No item found', 'lespaul_domain' ) . '</h2>';
			$out .= '</article>';

			echo $out;
		}
	} // /wm_not_found





/*
*****************************************************
*      14) OTHER FUNCTIONS
*****************************************************
*/
	/**
	* Use default WordPress content filters only
	*
	* Some plugins (such as JetPack) extend the "the_content" filters, causing issue when the filter is applied on different content sections of the website (such as excerpt...).
	* Use apply_filters( 'wm_default_content_filters', $content ) to prevent this.
	*/
	if ( ! function_exists( 'wm_default_content_filters' ) ) {
		function wm_default_content_filters( $content ) {
			/*
			Default filters WordPress apply on "the_content" (from "wp-includes/default-filters.php"):
			add_filter( 'the_content', 'wptexturize'        );
			add_filter( 'the_content', 'convert_smilies'    );
			add_filter( 'the_content', 'convert_chars'      );
			add_filter( 'the_content', 'wpautop'            );
			add_filter( 'the_content', 'shortcode_unautop'  );
			add_filter( 'the_content', 'prepend_attachment' );.
			*/

			$content = wptexturize( $content );
			$content = convert_smilies( $content );
			$content = convert_chars( $content );
			$content = do_shortcode( $content );
			$content = wpautop( $content );
			$content = shortcode_unautop( $content );
			$content = prepend_attachment( $content );

			return $content;
		}
	} // /wm_default_content_filters



	/*
	* Check WordPress version
	*
	* $version = #FLOAT ["3.1" - at least this version]
	*/
	if ( ! function_exists( 'wm_check_wp_version' ) ) {
		function wm_check_wp_version( $version = '3.0' ) {
			global $wp_version;

			return version_compare( $wp_version, $version, '>=' );
		}
	} // /wm_check_wp_version



	/*
	* Get Fontello classes from JSON file
	*/
	if ( ! function_exists( 'wm_fontello_classes' ) ) {
		function wm_fontello_classes( $fileFontelloJSON = '' ) {
			$classesArray = array();

			if ( wm_option( 'design-fontello-classes' ) )
				return explode( ', ', wm_option( 'design-fontello-classes' ) );

			if ( ! $fileFontelloJSON )
				return $classesArray;

			//We don't need to write to the file, so just open for reading.
			$fp = fopen( $fileFontelloJSON, 'r' );
			//Pull only the first 8kiB of the file in.
			$file_data = fread( $fp, filesize( $fileFontelloJSON ) );

			if ( ! $file_data )
				return $classesArray;

			//PHP will close file handle, but we are good citizens.
			fclose( $fp );
			//Make sure we catch CR-only line endings.
			$file_data = preg_replace('/\s+/', '', rtrim( $file_data ) );
			$file_data = str_replace( array( "\r", "\n", "\r\n" ), '', $file_data );

			//get Fontello classes
			$JSONobject = ( json_decode( $file_data ) );
			if ( is_object( $JSONobject ) && isset( $JSONobject->glyphs ) && is_array( $JSONobject->glyphs ) ) {
				foreach ( $JSONobject->glyphs as $glyph ) {
					$classesArray[] = sanitize_title( 'icon-' . $glyph->css );
				}
			}

			//output
			sort( $classesArray );
			return $classesArray;
		}
	} // /wm_fontello_classes



	/*
	* Prevent your email address from stealing (requires jQuery functions)
	*
	* $email  = TEXT [email address to encrypt]
	* $method = TEXT ["wp" encrypt method]
	*/
	if ( ! function_exists( 'wm_nospam' ) ) {
		function wm_nospam( $email, $method = null ) {
			if ( ! isset( $email ) || ! $email )
				return;

			if ( 'wp' == $method ) {
				$email = antispambot( $email );
			} else {
				$email = strrev( $email );
				$email = preg_replace( '[@]', ']ta[', $email );
				$email = preg_replace( '[\.]', '/', $email );
			}

			return $email;
		}
	} // /wm_nospam



	/*
	* CSS output minimizer
	*
	* $buffer = TEXT [code text to minimize]
	*/
	if ( ! function_exists( 'wm_minimize_css' ) ) {
		function wm_minimize_css( $buffer ) {
			$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer ); //remove css comments
			$buffer = str_replace( array( "\r\n", "\r", "\n", "\t", "  ", "    " ), '', $buffer ); //remove tabs, spaces, line breaks, etc.

			return $buffer;
		}
	} // /wm_minimize_css



	/**
	* Get background CSS styles
	*
	* @param $optionBase [TEXT: wm_option base name (option full name minus function suffixes: bg-color, bg-img-url, bg-img-repeat, bg-img-attachment, bg-img-position, bg-pattern)]
	* @param $args       [ARRAY: array of different function options (see below)]
	*/
	if ( ! function_exists( 'wm_css_background' ) ) {
		function wm_css_background( $optionBase = '', $args = array() ) {
			$args = wp_parse_args( $args, array(
					'pattern-folder' => 'img/patterns/',
					'pattern-format' => '.png',
					'high-dpi'       => false,
					'out'            => '',
				) );

			$out = array(
					'color' => '', //color
					'image' => '', //image URL
					'size'  => '', //image size
					'out'   => '', //actual output string
				);

			//get background color
			$out['color'] = ( wm_option( $optionBase . 'bg-color' ) ) ? ( '#' . wm_option( $optionBase . 'bg-color' ) ) : ( '' );

			//get background image
			$out['image'] = '';
			if ( wm_option( $optionBase . 'bg-pattern' ) ) {

				$out['image'] = WM_ASSETS_THEME . $args['pattern-folder'] . wm_option( $optionBase . 'bg-pattern' ) . $args['pattern-format'];

				$imagePath = get_template_directory() . '/assets/' . $args['pattern-folder'] . wm_option( $optionBase . 'bg-pattern' ) . '.png';
				$size      = getimagesize( $imagePath );
				if ( $size && isset( $size[0] ) && isset( $size[1] ) )
					$out['size'] = $size[0] . 'px ' . $size[1] . 'px';

				if ( $args['high-dpi'] )
					$out['image'] = esc_url( WM_ASSETS_THEME . $args['pattern-folder'] . wm_option( $optionBase . 'bg-pattern' ) ) . '@2x' . $args['pattern-format'];

			} else {

				if ( is_array( wm_option( $optionBase . 'bg-img-url' ) ) ) {
					$attachment = wm_option( $optionBase . 'bg-img-url' );
					$attachment = wp_get_attachment_image_src( $attachment['id'], 'full' ); //returns array( URL, width, height )

					$out['image']  = ( isset( $attachment[0] ) ) ? ( $attachment[0] ) : ( '' );
					$out['size']   = ( isset( $attachment[1] ) ) ? ( $attachment[1] . 'px' ) : ( '' );
					$out['size']  .= ( isset( $attachment[2] ) ) ? ( ' ' . $attachment[2] . 'px' ) : ( '' );

					if ( $args['high-dpi'] ) {
						$attachment   = wm_option( $optionBase . 'bg-img-url-highdpi' );
						$attachment   = ( isset( $attachment['id'] ) ) ? ( wp_get_attachment_image_src( $attachment['id'], 'full' ) ) : ( '' );
						$out['image'] = ( isset( $attachment[0] ) ) ? ( $attachment[0] ) : ( '' );
					}
				} elseif ( wm_option( $optionBase . 'bg-img-url' ) ) {
					$out['image'] = wm_option( $optionBase . 'bg-img-url' ); //no need to esc_url() as it is possible to use relative paths
				}

			}

			if ( $out['image'] ) {
				$out['image'] = ' url(' . esc_url( $out['image'] ) . ')';

				$bgImgRepeat     = ( wm_option( $optionBase . 'bg-img-repeat' ) ) ? ( ' ' . wm_option( $optionBase . 'bg-img-repeat' ) ) : ( '' );
				$bgImgAttachment = ( wm_option( $optionBase . 'bg-img-attachment' ) ) ? ( ' ' . wm_option( $optionBase . 'bg-img-attachment' ) ) : ( '' );
				$bgImgPosition   = ( wm_option( $optionBase . 'bg-img-position' ) ) ? ( ' ' . wm_option( $optionBase . 'bg-img-position' ) ) : ( '' );
				$bgImgParameters = $bgImgRepeat . $bgImgAttachment . $bgImgPosition;

				if ( wm_option( $optionBase . 'bg-pattern' ) )
					$bgImgParameters = ' repeat' . $bgImgAttachment;

				if ( 'image' != $args['out'] )
					$out['image'] .= $bgImgParameters;
			}

			//output
			if ( ! $args['out'] )
				$out['out'] = $out['color'] . $out['image'];
			else
				$out['out'] = $out[$args['out']];

			return trim( $out['out'] );
		}
	} // /wm_css_background



	/**
	* Get background CSS styles from post meta
	*
	* @param $optionBase [TEXT: wm_meta_option base name (option full name minus function suffixes: bg-color, bg-img-url, bg-img-repeat, bg-img-attachment, bg-img-position)]
	*/
	if ( ! function_exists( 'wm_css_background_meta' ) ) {
		function wm_css_background_meta( $optionBase = '' ) {
			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			$out = array(
					'color' => '', //color
					'image' => '', //image URL
					'size'  => '', //image size
				);

			//get background color
			$out['color'] = ( wm_meta_option( $optionBase . 'bg-color', $postId ) ) ? ( '#' . wm_meta_option( $optionBase . 'bg-color', $postId ) ) : ( '' );

			//get background image
			$attachment = wm_meta_option( $optionBase . 'bg-img-url', $postId );
			if ( ! is_array( $attachment ) ) {
				$out['image'] = esc_url( $attachment );
			} elseif ( isset( $attachment['url'] ) && $attachment['url'] && isset( $attachment['id'] ) ) {
				$attachment = wp_get_attachment_image_src( $attachment['id'], 'full' ); //returns array( URL, width, height )
				if ( ! empty( $attachment ) && 3 <= count( $attachment ) ) {
					$out['image'] = ( isset( $attachment[0] ) ) ? ( $attachment[0] ) : ( '' );
					$out['size']  = ( isset( $attachment[1] ) ) ? ( $attachment[1] . 'px' ) : ( '' );
					$out['size'] .= ( isset( $attachment[2] ) ) ? ( ' ' . $attachment[2] . 'px' ) : ( '' );
					$out['size']  = ( $out['size'] ) ? ( '; -webkit-background-size: ' . $out['size'] . '; -moz-background-size: ' . $out['size'] . '; background-size: ' . $out['size'] . ';' ) : ( '' );
				}
			}
			if ( $out['image'] ) {
				$out['image']  = ' url(' . $out['image'] . ')';
				$out['image'] .= ( wm_meta_option( $optionBase . 'bg-img-repeat', $postId ) ) ? ( ' ' . wm_meta_option( $optionBase . 'bg-img-repeat', $postId ) ) : ( '' );
				$out['image'] .= ( wm_meta_option( $optionBase . 'bg-img-attachment', $postId ) ) ? ( ' ' . wm_meta_option( $optionBase . 'bg-img-attachment', $postId ) ) : ( '' );
				$out['image'] .= ( wm_meta_option( $optionBase . 'bg-img-position', $postId ) ) ? ( ' ' . wm_meta_option( $optionBase . 'bg-img-position', $postId ) ) : ( '' );
			}

			//output
			$out = $out['color'] . $out['image'] . $out['size'];
			return trim( $out );
		}
	} // /wm_css_background_meta



	/*
	* Strip string by words count
	*
	* $str   = TEXT [string to process]
	* $words = # [wordcount]
	* $more  = TEXT ["..."]
	*/
	if ( ! function_exists( 'wm_string_length' ) ) {
		function wm_string_length( $str, $words = 20, $more = '' ) {
			if ( ! $str )
				return;

			$str = preg_replace( '/\s\s+/', ' ', $str );
			$str = explode( ' ', $str, ( $words + 1 ) );

			if ( count( $str ) > $words ) {
				array_pop( $str );
				$out = implode( ' ', $str ) . $more;
			} else {
				$out = implode( ' ', $str );
			}

			return $out;
		}
	} // /wm_string_length



	/*
	* Remove invalid HTML5 rel attribute
	*/
	if ( ! function_exists( 'wm_remove_rel' ) ) {
		function wm_remove_rel( $link ) {
			return ( str_replace ( 'rel="category tag"', '', $link ) );
		}
	} // /wm_remove_rel



	/*
	* Include post types in feed
	*/
	if ( ! function_exists( 'wm_feed_include_post_types' ) ) {
		function wm_feed_include_post_types( $query ) {
			if ( isset( $query['feed'] ) && ! isset( $query['post_type'] ) )
				$query['post_type'] = array( 'post', 'wm_projects' );

			return $query;
		}
	} // /wm_feed_include_post_types



	/*
	* Display thumbnails in RSS
	*/
	if ( ! function_exists( 'wm_rss_post_thumbnail' ) ) {
		function wm_rss_post_thumbnail( $content ) {
			global $post;

			if ( has_post_thumbnail( $post->ID ) )
				$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . get_the_content();

			return $content;
		}
	} // /wm_rss_post_thumbnail



	/**
	* Color brightness detection
	*
	* @param $hex [HEX]
	*
	* @return INT (0-255)
	*/
	if ( ! function_exists( 'wm_color_brightness' ) ) {
		function wm_color_brightness( $hex ) {
			$hex = preg_replace( "/[^0-9A-Fa-f]/", '', $hex );
			$hex = substr( $hex, 0, 6 );

			if ( ! $hex )
				return;

			$rgb = array();

			if ( 6 == strlen( $hex ) ) {
				$rgb['r'] = hexdec( substr( $hex, 0, 2 ) );
				$rgb['g'] = hexdec( substr( $hex, 2, 2 ) );
				$rgb['b'] = hexdec( substr( $hex, 4, 2 ) );
			} else { //if shorthand notation, need some string manipulations
				$rgb['r'] = hexdec( str_repeat( substr( $hex, 0, 1 ), 2 ) );
				$rgb['g'] = hexdec( str_repeat( substr( $hex, 1, 1 ), 2 ) );
				$rgb['b'] = hexdec( str_repeat( substr( $hex, 2, 1 ), 2 ) );
			}

			return absint( ( ( $rgb['r'] * 299 ) + ( $rgb['g'] * 587 ) + ( $rgb['b'] * 114 ) ) / 1000 ); //returns value from 0 to 255
		}
	} // /wm_color_brightness



	/**
	* Alter color brightness
	*
	* @param $hex  [HEX]
	* @param $step [INT]
	*
	* @return HEX color
	*/
	if ( ! function_exists( 'wm_alter_brightness' ) ) {
		function wm_alter_brightness( $hex, $step ) {
			$hex = preg_replace( "/[^0-9A-Fa-f]/", '', $hex );
			$hex = substr( $hex, 0, 6 );

			if ( ! $hex )
				return;

			$rgb = array();

			if ( 6 == strlen( $hex ) ) {
				$rgb['r'] = hexdec( substr( $hex, 0, 2 ) );
				$rgb['g'] = hexdec( substr( $hex, 2, 2 ) );
				$rgb['b'] = hexdec( substr( $hex, 4, 2 ) );
			} else {
				$rgb['r'] = hexdec( str_repeat( substr( $hex, 0, 1 ), 2 ) );
				$rgb['g'] = hexdec( str_repeat( substr( $hex, 1, 1 ), 2 ) );
				$rgb['b'] = hexdec( str_repeat( substr( $hex, 2, 1 ), 2 ) );
			}

			foreach ( $rgb as $key => $value ) {
				$newHexPart = dechex( max( 0, min( 255, $value + intval( $step ) ) ) );
				$rgb[$key] = ( 1 == strlen( $newHexPart ) ) ? ( '0' . $newHexPart ) : ( $newHexPart );
			}

			return '#' . implode( '', $rgb );
		}
	} // /wm_alter_brightness



	/**
	* Modifying input color by changing brightness in response to treshold
	*
	* @param $color     [COLOR HEX]
	* @param $dark      [-255 to 255: brightness modification when below treshold]
	* @param $light     [-255 to 255: brightness modification when above treshold]
	* @param $important [TEXT: important CSS rule]
	*
	* @return HEX color
	*/
	if ( ! function_exists( 'wm_modify_color' ) ) {
		function wm_modify_color( $color, $dark, $light, $important = '' ) {
			$out = ( WM_COLOR_TRESHOLD > wm_color_brightness( $color ) ) ? ( wm_alter_brightness( $color, $dark ) ) : ( wm_alter_brightness( $color, $light ) );
			if ( $out )
				return $out . $important;
		}
	} // /wm_modify_color



	/**
	* CSS3 linear gradient
	*
	* @param $color    [COLOR HEX: base bottom color of gradient]
	* @param $brighten [-255 to 255: top gradient color brightening (default 17 DEC = 11 HEX)]
	*
	* @return STRING of CSS3 gradient rules
	*/
	if ( ! function_exists( 'wm_css3_gradient' ) ) {
		function wm_css3_gradient( $color, $brighten = 17, $important = '' ) {
			$color = preg_replace( "/[^0-9A-Fa-f]/", '', $color );
			$color = ( 6 > strlen( $color ) ) ? ( substr( $color, 0, 3 ) ) : ( substr( $color, 0, 6 ) );

			$important = ( trim( $important ) ) ? ( ' ' . trim( $important ) ) : ( '' );

			$out = '';

			if ( $color && 3 <= strlen( $color ) ) {
				/* the first "background-image:" will be filled in by style.css.php script */
				$out .=                          '-webkit-linear-gradient(top, ' . wm_alter_brightness( $color, $brighten ) . ', #' . $color . ')' . $important . ';' . "\r\n";
				$out .= "\t" . 'background-image:    -moz-linear-gradient(top, ' . wm_alter_brightness( $color, $brighten ) . ', #' . $color . ')' . $important . ';' . "\r\n";
				$out .= "\t" . 'background-image:     -ms-linear-gradient(top, ' . wm_alter_brightness( $color, $brighten ) . ', #' . $color . ')' . $important . ';' . "\r\n";
				$out .= "\t" . 'background-image:      -o-linear-gradient(top, ' . wm_alter_brightness( $color, $brighten ) . ', #' . $color . ')' . $important . ';' . "\r\n";
				$out .= "\t" . 'background-image:         linear-gradient(top, ' . wm_alter_brightness( $color, $brighten ) . ', #' . $color . ')' . $important;
				/* the last ";\r\n" will be filled in by style.css.php script */
			}

			return $out;
		}
	} // /wm_css3_gradient



	/*
	* Get post attachments list (except images)
	*/
	if ( ! function_exists( 'wm_post_attachments' ) ) {
		function wm_post_attachments() {
			global $post;

			if ( ! is_singular() )
				return;

			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( $post->ID );

			if ( ! wm_meta_option( 'attachments-list', $postId ) )
				return;

			$out = '';

			$args = array(
					'post_type'      => 'attachment',
					'post_mime_type' => 'application,audio,video',
					'numberposts'    => -1,
					'post_status'    => null,
					'post_parent'    => $postId,
					'orderby'        => 'menu_order',
					'order'          => 'ASC'
				);

			$attachments = get_posts( $args );

			if ( $attachments ) {
				foreach ( $attachments as $attachment ) {
					$out .= '<li class="attachment mime-' . sanitize_title( $attachment->post_mime_type ) . '"><a href="' . wp_get_attachment_url( $attachment->ID ) . '" title="' . esc_attr( $attachment->post_title ) . '">' . $attachment->post_title . '</a></li>';
				}
				$out = '<div class="list-attachments meta-bottom"><ul class="download">' . $out . '</ul></div>';
			}

			echo $out;
		}
	} // /wm_post_attachments



	/*
	* Search form (needs to be function to maintain return output of get_search_form())
	*/
	if ( ! function_exists( 'wm_search_form' ) ) {
		function wm_search_form( $form ) {
			$form = '
				<div class="idioma">
					<ul>
						<li><a href="' . get_option('home') . '"><div class="ico-por"> <span>POR</span></a></li>
						<li><a href="' .  get_option( 'home') . '/en/"><div class="ico-eng"> <span>ENG</span></a></li>
					</ul>
				</div>
				<form method="get" class="form-search" action="' . home_url( '/' ) . '">
				<fieldset>
					<label class="assistive-text invisible">' . __( 'Search for:', 'lespaul_domain' ) . '</label>
					<input type="text" class="text" name="s" placeholder="' . wm_option( 'general-search-placeholder' ) . '" />
					<input type="submit" class="submit" value="' . __( 'Submit', 'lespaul_domain' ) . '" />
					<i class="wmicon-search"></i>
				</fieldset>
				</form>
				';

			return $form;
		}
	} // /wm_search_form



	/*
	* HTML (basic) in widget titles
	*/
	if ( ! function_exists( 'wm_html_widget_title' ) ) {
		function wm_html_widget_title( $title ) {

			$replaceArray = array(
				//HTML tag opening/closing brackets
				'['  => '<',
				'[/' => '</',
				//<strong></strong>
				's]' => 'strong>',
				//<em></em>
				'e]' => 'em>',
			);
			$title = strtr( $title, $replaceArray );

			return $title;
		}
	} // /wm_html_widget_title



	/*
	* Can user view the page?
	*
	* Outputs TRUE or FALSE
	*/
	if ( ! function_exists( 'wm_restriction_page' ) ) {
		function wm_restriction_page( $pageId = null ) {
			$restriction = wm_meta_option( 'restrict-access', $pageId );
			$noGroup     = ! stripos( $restriction, 'roup-' );
			$capability  = str_replace( 'group-', '', $restriction );

			if ( $restriction ) {

				if ( ! is_user_logged_in() ) {
					//no user logged in
					$display = false;
				} else {
					global $user_login;
					get_currentuserinfo();

					//user logged in
					if ( $noGroup && -1 !== $restriction && $user_login === $restriction )
						//specific user logged in
						$display = true;
					elseif ( $noGroup && -1 === $restriction )
						//any logged in user
						$display = true;
					elseif ( ! $noGroup && $restriction && @current_user_can( $capability ) )
						//user group allowed
						$display = true;
					else
						//otherwise restrict
						$display = false;
				}

				return $display;

			} else {

				return true;

			}
		}
	} // /wm_restriction_page



	/*
	* Remove "recent comments" <style> from HTML head
	*/
	if ( ! function_exists( 'wm_remove_recent_comments_style' ) ) {
		function wm_remove_recent_comments_style( $pageId = null ) {
			global $wp_widget_factory;
			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
		}
	} // /wm_remove_recent_comments_style



	/*
	* Contact Form 7 plugin enhancements
	*/
	if ( ! function_exists( 'wm_wpcf7_shortcode_support' ) ) {
		function wm_wpcf7_shortcode_support( $form ) {
			return do_shortcode( $form );
		}
	} // /wm_wpcf7_shortcode_support



	/*
	Plugin Name: Previous and Next Post in Same Taxonomy
	Plugin URI: http://core.trac.wordpress.org/ticket/17807
	Description: Extends the prev/next links to let you limit to same taxonomy. Used for testing WP Core patch, and can be disabled if patch is committed to core.
	Author: Bill Erickson
	Version: 1.0
	Author URI: http://www.billerickson.net
	*/
		/**
		 * Retrieve previous post that is adjacent to current post.
		 *
		 * @since 1.5.0
		 *
		 * @param bool $in_same_cat Optional. Whether post should be in same category.
		 * @param array|string $excluded_categories Optional. Array or comma-separated list of excluded category IDs.
		 * @param string $taxonomy Optional. Which taxonomy to use.
		 * @return mixed Post object if successful. Null if global $post is not set. Empty string if no corresponding post exists.
		 */
		function be_get_previous_post($in_same_cat = false, $excluded_categories = '', $taxonomy = 'category') {
			return be_get_adjacent_post($in_same_cat, $excluded_categories, true, $taxonomy);
		}
		/**
		 * Retrieve next post that is adjacent to current post.
		 *
		 * @since 1.5.0
		 *
		 * @param bool $in_same_cat Optional. Whether post should be in same category.
		 * @param array|string $excluded_categories Optional. Array or comma-separated list of excluded category IDs.
		 * @param string $taxonomy Optional. Which taxonomy to use.
		 * @return mixed Post object if successful. Null if global $post is not set. Empty string if no corresponding post exists.
		 */
		function be_get_next_post($in_same_cat = false, $excluded_categories = '', $taxonomy = 'category') {
			return be_get_adjacent_post($in_same_cat, $excluded_categories, false, $taxonomy);
		}
		/**
		 * Retrieve adjacent post.
		 *
		 * Can either be next or previous post.
		 *
		 * @since 2.5.0
		 *
		 * @param bool $in_same_cat Optional. Whether post should be in same category.
		 * @param array|string $excluded_categories Optional. Array or comma-separated list of excluded category IDs.
		 * @param bool $previous Optional. Whether to retrieve previous post.
		 * @param string $taxonomy Optional. Which taxonomy to use.
		 * @return mixed Post object if successful. Null if global $post is not set. Empty string if no corresponding post exists.
		 */
		function be_get_adjacent_post( $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy = 'category' ) {
			global $post, $wpdb;

			if ( empty( $post ) )
				return null;

			$current_post_date = $post->post_date;

			$join = '';
			$posts_in_ex_cats_sql = '';
			if ( $in_same_cat || ! empty( $excluded_categories ) ) {
				$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

				if ( $in_same_cat ) {
					$cat_array = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
					$join .= " AND tt.taxonomy = '$taxonomy' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
				}

				$posts_in_ex_cats_sql = "AND tt.taxonomy = '$taxonomy'";
				if ( ! empty( $excluded_categories ) ) {
					if ( ! is_array( $excluded_categories ) ) {
						// back-compat, $excluded_categories used to be IDs separated by " and "
						if ( strpos( $excluded_categories, ' and ' ) !== false ) {
							_deprecated_argument( __FUNCTION__, '3.3', sprintf( 'Use commas instead of %s to separate excluded categories.', "'and'" ) );
							$excluded_categories = explode( ' and ', $excluded_categories );
						} else {
							$excluded_categories = explode( ',', $excluded_categories );
						}
					}

					$excluded_categories = array_map( 'intval', $excluded_categories );

					if ( ! empty( $cat_array ) ) {
						$excluded_categories = array_diff($excluded_categories, $cat_array);
						$posts_in_ex_cats_sql = '';
					}

					if ( !empty($excluded_categories) ) {
						$posts_in_ex_cats_sql = " AND tt.taxonomy = '$taxonomy' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
					}
				}
			}

			$adjacent = $previous ? 'previous' : 'next';
			$op = $previous ? '<' : '>';
			$order = $previous ? 'DESC' : 'ASC';

			$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
			$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_date, $post->post_type), $in_same_cat, $excluded_categories );
			$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );

			$query = "SELECT p.* FROM $wpdb->posts AS p $join $where $sort";
			$query_key = 'adjacent_post_' . md5($query);
			$result = wp_cache_get($query_key, 'counts');
			if ( false !== $result )
				return $result;

			$result = $wpdb->get_row("SELECT p.* FROM $wpdb->posts AS p $join $where $sort");
			if ( null === $result )
				$result = '';

			wp_cache_set($query_key, $result, 'counts');
			return $result;
		}

?>