<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Shortcodes registration
*
* CONTENT:
* - 1) Actions and filters
* - 2) Helper functions
* - 3) Shortcodes
* - Access and visibility shortcodes
* - Accordion
* - Boxes
* - Buttons
* - Columns
* - Countdown timer
* - Divider
* - Dropcaps
* - Icon
* - Lists
* - Login form
* - Markers
* - Posts / pages / custom posts
* - Pullquotes
* - Raw code (pre HTML tag)
* - Simple slideshow
* - Social icons
* - Split
* - Table
* - Tabs
* - Text
* - Toggles
* - Video
* - Widgets
*****************************************************
*/




/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//FILTERS
	//Allows "[shortcode][/shortcode]" in RAW/PRE shortcode output
	add_filter( 'the_content', 'wm_preprocess_shortcode', 7 );
	add_filter( 'wm_default_content_filters', 'wm_preprocess_shortcode', 7 );
	//Shortcodes in text widget
	add_filter( 'widget_text', 'wm_preprocess_shortcode', 7 );
	add_filter( 'widget_text', 'do_shortcode' );
	//Fixes HTML issues created by wpautop
	add_filter( 'the_content', 'wm_shortcode_paragraph_insertion_fix' );





/*
*****************************************************
*      2) HELPER FUNCTIONS
*****************************************************
*/
	/**
	* Plugin Name: Shortcode Empty Paragraph Fix
	* Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
	* Description: Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop.
	* Author URI: http://www.johannheyne.de
	* Version: 0.1
	* Put this in /wp-content/plugins/ of your Wordpress installation
	*
	* Update: by WebMan - www.webmandesign.eu
	*/
	if ( ! function_exists( 'wm_shortcode_paragraph_insertion_fix' ) ) {
		function wm_shortcode_paragraph_insertion_fix( $content ) {
			$fix = array(
				'<p>['            => '[',
				']</p>'           => ']',
				']<br />'         => ']',
				']<br>'           => ']',

				'<p></p>'         => '<span class="br"></span>',
				'<p>&nbsp;</p>'   => '<span class="br"></span>',

				'<h1></h1>'       => '<span class="br"></span>',
				'<h1>&nbsp;</h1>' => '<span class="br"></span>',

				'<h2></h2>'       => '<span class="br"></span>',
				'<h2>&nbsp;</h2>' => '<span class="br"></span>',

				'<h3></h3>'       => '<span class="br"></span>',
				'<h3>&nbsp;</h3>' => '<span class="br"></span>',

				'<h4></h4>'       => '<span class="br"></span>',
				'<h4>&nbsp;</h4>' => '<span class="br"></span>',

				'<h5></h5>'       => '<span class="br"></span>',
				'<h5>&nbsp;</h5>' => '<span class="br"></span>',

				'<h6></h6>'       => '<span class="br"></span>',
				'<h6>&nbsp;</h6>' => '<span class="br"></span>'
			);
			$content = strtr( $content, $fix );

			return $content;
		}
	} // /wm_shortcode_paragraph_insertion_fix



	/**
	* Preprocess certain shortcodes to prevent HTML errors
	*
	* Source: http://betterwp.net/17-protect-shortcodes-from-wpautop-and-the-likes/
	*/
	if ( ! function_exists( 'wm_preprocess_shortcode' ) ) {
		function wm_preprocess_shortcode( $content ) {
			global $shortcode_tags;

			//Backup current registered shortcodes and clear them all out
			$orig_shortcode_tags = $shortcode_tags;
			remove_all_shortcodes();

			//To let [shortcode][/shortcode] in preformated text
			add_shortcode( 'raw', 'wm_shortcode_raw' );
			add_shortcode( 'pre', 'wm_shortcode_raw' );

			/*
			Preprocess shortcodes using inline HTML tags not to mess up with <p> tags openings and closings (or maybe all shortcodes? - some themes do that - but what for?).
			These shortcodes will be processed also normally (outside preprocessing) to retain compatibility with do_shortcode() (in sliders for example).
			Surely, if the shortcode was applied in preprocess, it shouldn't appear again in the content.
			*/
			add_shortcode( 'button', 'wm_shortcode_button' );
			add_shortcode( 'dropcap', 'wm_shortcode_dropcap' );
			add_shortcode( 'marker', 'wm_shortcode_marker' );
			add_shortcode( 'icon', 'wm_shortcode_icon' );
			add_shortcode( 'last_update', 'wm_shortcode_posts_update' );
			add_shortcode( 'social', 'wm_shortcode_social' );
			//text shortcodes:
				add_shortcode( 'big_text', 'wm_shortcode_big_text' );
				add_shortcode( 'huge_text', 'wm_shortcode_huge_text' );
				add_shortcode( 'small_text', 'wm_shortcode_small_text' );
				add_shortcode( 'uppercase', 'wm_shortcode_uppercase' );

			//Do the shortcodes (only the above ones)
			$content = do_shortcode( $content );

			//Put the original shortcodes back
			$shortcode_tags = $orig_shortcode_tags;

			return $content;
		}
	} // /wm_preprocess_shortcode





/*
*****************************************************
*      3) SHORTCODES:
*****************************************************
*/

/*
*****************************************************
*      ACCESS SHORTCODES
*****************************************************
*/
	/**
	* [administrator]content[/administrator]
	*
	* Displays content only for Administrators
	*/
	if ( ! function_exists( 'wm_shortcode_administrator' ) ) {
		function wm_shortcode_administrator( $atts, $content = null ) {
			if ( current_user_can( 'edit_dashboard' ) )
				return do_shortcode( $content );
		}
	} // /wm_shortcode_administrator
	add_shortcode( 'administrator', 'wm_shortcode_administrator' );



	/**
	* [author]content[/author]
	*
	* Displays content only for Authors
	*/
	if ( ! function_exists( 'wm_shortcode_author' ) ) {
		function wm_shortcode_author( $atts, $content = null ) {
			if ( current_user_can( 'edit_published_posts' ) && ! current_user_can( 'read_private_pages' ) )
				return do_shortcode( $content );
		}
	} // /wm_shortcode_author
	add_shortcode( 'author', 'wm_shortcode_author' );



	/**
	* [contributor]content[/contributor]
	*
	* Displays content only for Contributors
	*/
	if ( ! function_exists( 'wm_shortcode_contributor' ) ) {
		function wm_shortcode_contributor( $atts, $content = null ) {
			if ( current_user_can( 'edit_posts' ) && ! current_user_can( 'delete_published_posts' ) )
				return do_shortcode( $content );
		}
	} // /wm_shortcode_contributor
	add_shortcode( 'contributor', 'wm_shortcode_contributor' );



	/**
	* [editor]content[/editor]
	*
	* Displays content only for Editors
	*/
	if ( ! function_exists( 'wm_shortcode_editor' ) ) {
		function wm_shortcode_editor( $atts, $content = null ) {
			if ( current_user_can( 'moderate_comments' ) && ! current_user_can( 'edit_dashboard' ) )
				return do_shortcode( $content );
		}
	} // /wm_shortcode_editor
	add_shortcode( 'editor', 'wm_shortcode_editor' );



	/**
	* [subscriber]content[/subscriber]
	*
	* Displays content only for Subscribers
	*/
	if ( ! function_exists( 'wm_shortcode_subscriber' ) ) {
		function wm_shortcode_subscriber( $atts, $content = null ) {
			if ( current_user_can('moderate_comments') && ! current_user_can( 'delete_posts' ) )
				return do_shortcode( $content );
		}
	} // /wm_shortcode_subscriber
	add_shortcode( 'subscriber', 'wm_shortcode_subscriber' );



	/**
	* [screen size="desktop"]content[/screen]
	*
	* Displays content only for specific screen widths
	*
	* @param size [TEXT]
	*
	* Desktop = 960+
	* Tablet = 768 to 959
	* Mobile = 767-
	* Mobile landscape = 480 to 767
	* Mobile portrait = 479-
	*/
	if ( ! function_exists( 'wm_shortcode_screen' ) ) {
		function wm_shortcode_screen( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'size' => 'desktop',
				), $atts)
				);

			//validation
			$sizes = array( 'desktop', 'tablet', 'min tablet', 'phone', 'phone landscape', 'min phone landscape', 'phone portrait', 'mobile', 'mobile landscape', 'min mobile landscape', 'mobile portrait' );
			$size  = ( in_array( trim( $size ), $sizes ) ) ? ( sanitize_title( trim( $size ) ) ) : ( 'desktop' );

			return '<div class="screen-' . $size . '">' . do_shortcode( $content ) . '</div>';
		}
	} // /wm_shortcode_screen
	add_shortcode( 'screen', 'wm_shortcode_screen' );





/*
*****************************************************
*      ACCORDION
*****************************************************
*/
	/**
	* [accordion auto="1"]content[/accordion]
	*
	* Accordion wrapper
	*
	* @param auto [BOOLEAN/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_accordion' ) ) {
		function wm_shortcode_accordion( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'auto' => ''
				), $atts)
				);

			//validation
			if ( $auto )
				$auto = ' auto';

			//output
			$out = '<div class="accordion-wrapper apply-top-margin' . $auto . '"><ul>' . do_shortcode( $content ) . '</ul></div>';
			return $out;
		}
	} // /wm_shortcode_accordion
	add_shortcode( 'accordion', 'wm_shortcode_accordion' );



	/**
	* [accordion_item title="Accordion item title"]content[/accordion_item]
	*
	* Accordion item
	*
	* @param title [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_accordion_item' ) ) {
		function wm_shortcode_accordion_item( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'title' => ''
				), $atts)
				);

			//validation
			if ( ! trim( $title ) )
				$title = 'Accordion';

			$title = strip_tags( trim( $title ), '<img><strong><span><small><em><b><i>' );

			//output
			$out = '<li><h3 class="accordion-heading">' . $title . '</h3>' . wpautop( do_shortcode( $content ) ) . '</li>';
			return $out;
		}
	} // /wm_shortcode_accordion_item
	add_shortcode( 'accordion_item', 'wm_shortcode_accordion_item' );





/*
*****************************************************
*      BOXES
*****************************************************
*/
	/**
	* [box color="green" style="" title="Box title" icon="check" transparent="" hero=""]content[/box]
	*
	* @param color       [gray/green/blue/orange/red/NONE]
	* @param icon        [info/question/check/warning/cancel/NONE]
	* @param hero        [BOOLEAN/NONE]
	* @param style       [TEXT]
	* @param title       [TEXT]
	* @param transparent [BOOLEAN/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_box' ) ) {
		function wm_shortcode_box( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'color'       => 'gray',
				'icon'        => '',
				'hero'        => '',
				'style'       => '',
				'title'       => '',
				'transparent' => '',
				), $atts )
				);

			$colors = array( 'gray', 'green', 'blue', 'orange', 'red' );
			$icons  = array( 'info', 'question', 'check', 'warning', 'cancel' );

			//validation
			$color = ( in_array( trim( $color ), $colors ) ) ? ( esc_attr( $color ) ) : ( 'gray' );
			$hero  = ( $hero ) ? ( ' hero' ) : ( '' );
			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );
			$title = trim( $title );

			if ( $title && ! $hero )
				$boxTitle = '<h2>' . $title . '</h2>';
			elseif ( $title && $hero )
				$boxTitle = '<p class="size-big"><strong>' . $title . '</strong></p>';
			else
				$boxTitle = '';

			$icon        = ( in_array( trim( $icon ), $icons ) ) ? ( ' iconbox ' . esc_attr( $icon ) ) : ( '' );
			$transparent = ( $transparent ) ? ( ' no-background' ) : ( '' );

			//output
			return '<div class="box color-' . $color . $icon . $transparent . $hero . '"' . $style . '>' . $boxTitle . do_shortcode( $content ) . '</div>';
		}
	} // /wm_shortcode_box
	add_shortcode( 'box', 'wm_shortcode_box' );





/*
*****************************************************
*      BUTTONS
*****************************************************
*/
	/**
	* [button url="#" color="green" size="" align="right" new_window="" icon="" id=""]content[/button]
	*
	* @param align      [right/left/NONE]
	* @param color      [gray/green/blue/orange/red/NONE]
	* @param icon       [TEXT/NONE]
	* @param id         [TEXT/NONE]
	* @param new_window [BOOLEAN/NONE]
	* @param size       [s/m/l/xl/NONE]
	* @param style      [TEXT]
	* @param url        [URL/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_button' ) ) {
		function wm_shortcode_button( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align'      => '',
				'color'      => '',
				'icon'       => '',
				'id'         => '',
				'new_window' => false,
				'size'       => 'm',
				'style'      => '',
				'url'        => '#',
				), $atts )
				);

			$colorsArray = array( 'gray', 'green', 'blue', 'orange', 'red' );
			$buttonSizes = array(
				'all' => array( 's', 'm', 'l', 'xl' ),
				's'   => 'small',
				'm'   => 'medium',
				'l'   => 'large',
				'xl'  => 'extra-large',
				 );

			//validation
			$url   = esc_url( $url );
			$color = ( in_array( trim( $color ), $colorsArray ) ) ? ( ' color-' . esc_attr( trim( $color ) ) ) : ( '' );
			$size  = ( in_array( trim( $size ), $buttonSizes['all'] ) ) ? ( ' size-' . esc_attr( $buttonSizes[trim( $size )] ) ) : ( ' size-medium' );

			$icon = ( $icon && false === strstr( $icon, 'icon-' ) ) ? ( 'icon-' . sanitize_title( $icon ) ) : ( $icon );
			$icon = ( $icon ) ? ( '<i class="' . $icon . '"></i> ' ) : ( '' );

			$align = ( 'right' === trim( $align ) ) ? ( ' alignright' ) : ( '' );
			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );
			$id    = ( trim( $id ) ) ? ( ' id="' . trim( $id ) . '"' ) : ( '' );

			$newWindow = ( $new_window ) ? ( ' target="_blank"' ) : ( '' );

			//output
			$out = '<a href="' . $url . '" class="btn' . $size . $color . $align . '"' . $id . $style . $newWindow . '>' . $icon . do_shortcode( $content ) . '</a>';
			return $out;
		}
	} // /wm_shortcode_button
	add_shortcode( 'button', 'wm_shortcode_button' );





/*
*****************************************************
*      CALL TO ACTION
*****************************************************
*/
	/**
	* [call_to_action title="" subtitle="" button_text="Button text" button_url="#" button_color="green" new_window="" color="" style=""]content[/call_to_action]
	*
	* @param button_color [gray/green/blue/orange/red/NONE]
	* @param button_text  [TEXT]
	* @param button_url   [URL]
	* @param color        [gray/green/blue/orange/red/NONE]
	* @param new_window   [BOOLEAN/NONE]
	* @param style        [TEXT]
	* @param subtitle     [TEXT]
	* @param title        [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_call_to_action' ) ) {
		function wm_shortcode_call_to_action( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'button_color' => 'green',
				'button_text'  => '',
				'button_url'   => '',
				'color'        => '',
				'new_window'   => false,
				'style'        => '',
				'subtitle'     => '',
				'title'        => '',
				), $atts )
				);

			$colorsArray = array( 'gray', 'green', 'blue', 'orange', 'red' );

			//validation
			$title       = trim( $title );
			$subtitle    = trim( $subtitle );
			$button_text = trim( $button_text );

			$buttonText  = $button_text;
			$buttonUrl   = esc_url( $button_url );
			$buttonColor = ( in_array( trim( $button_color ), $colorsArray ) ) ? ( esc_attr( trim( $button_color ) ) ) : ( 'green' );
			$newWindow   = ( $new_window ) ? ( '1' ) : ( '' );

			$subtitle   = ( $subtitle ) ? ( ' <small>' . $subtitle . '</small>' ) : ( '' );
			$title      = ( $title ) ? ( '<div class="call-to-action-title ' . $buttonColor . '"><h2>' . $title . $subtitle . '</h2></div>' ) : ( '' );
			$titleClass = ( $title ) ? ( ' has-title' ) : ( '' );

			$color = ( in_array( trim( $color ), $colorsArray ) ) ? ( esc_attr( ' color-' . trim( $color ) ) ) : ( '' );
			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			$out  = '<div class="call-to-action clearfix' . $color . $titleClass . '"' . $style . '>';
			$out .= $title . '<div class="call-to-action-text">' . $content . '</div>';
			$out .= '<div class="cta-button">[button url="' . $buttonUrl . '" color="' . $buttonColor . '" size="xl" new_window="' . $newWindow . '"]' . $buttonText . '[/button]</div>';
			$out .= '</div>';

			return do_shortcode( shortcode_unautop( $out ) );
		}
	} // /wm_shortcode_call_to_action
	add_shortcode( 'call_to_action', 'wm_shortcode_call_to_action' );





/*
*****************************************************
*      COLUMNS
*****************************************************
*/
	/**
	* [column size="1/4 last"]content[/column]
	*
	* Single column
	*
	* @param last [optional/legacy:BOOLEAN/NONE]
	* @param size [predefined,NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_column' ) ) {
		function wm_shortcode_column( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'last' => false,
				'size' => '1/2',
				), $atts )
				);

			$columnSizes = array(
				'1/2',
					'1/2 last',
				'1/3',
					'1/3 last',
				'2/3',
					'2/3 last',
				'1/4',
					'1/4 last',
				'3/4',
					'3/4 last',
				'1/5',
					'1/5 last',
				'2/5',
					'2/5 last',
				'3/5',
					'3/5 last',
				'4/5',
					'4/5 last',
				'1/6',
					'1/6 last',
				'5/6',
					'5/6 last',
				);

			//validation
			$size = ( in_array( trim( $size ), $columnSizes ) ) ? ( 'col-' . str_replace( '/', '', trim( $size ) ) ) : ( 'col-12' );
			$last = ( $last ) ? ( ' last' ) : ( '' );

			//output
			$out = '<div class="column ' . $size . $last . '">' . wpautop( do_shortcode( $content ) ) . '</div>';
			return $out;
		}
	} // /wm_shortcode_column
	add_shortcode( 'column', 'wm_shortcode_column' );

	/* Support for stupidity... */
		//halfs
			if ( ! function_exists( 'wm_shortcode_one_half' ) ) {
				function wm_shortcode_one_half( $atts, $content = null ) {
					extract( shortcode_atts( array(
								'last' => '',
							), $atts )
						);
					$last = ( trim( $last ) ) ? ( ' last' ) : ( '' );
					return do_shortcode( '[column size="1/2' . $last . '"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_half
			add_shortcode( 'one_half', 'wm_shortcode_one_half' );

			if ( ! function_exists( 'wm_shortcode_one_half_last' ) ) {
				function wm_shortcode_one_half_last( $atts, $content = null ) {
					return do_shortcode( '[column size="1/2 last"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_half_last
			add_shortcode( 'one_half_last', 'wm_shortcode_one_half_last' );

		//thirds
			if ( ! function_exists( 'wm_shortcode_one_third' ) ) {
				function wm_shortcode_one_third( $atts, $content = null ) {
					extract( shortcode_atts( array(
								'last' => '',
							), $atts )
						);
					$last = ( trim( $last ) ) ? ( ' last' ) : ( '' );
					return do_shortcode( '[column size="1/3' . $last . '"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_third
			add_shortcode( 'one_third', 'wm_shortcode_one_third' );

			if ( ! function_exists( 'wm_shortcode_one_third_last' ) ) {
				function wm_shortcode_one_third_last( $atts, $content = null ) {
					return do_shortcode( '[column size="1/3 last"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_third_last
			add_shortcode( 'one_third_last', 'wm_shortcode_one_third_last' );

			if ( ! function_exists( 'wm_shortcode_two_third' ) ) {
				function wm_shortcode_two_third( $atts, $content = null ) {
					extract( shortcode_atts( array(
								'last' => '',
							), $atts )
						);
					$last = ( trim( $last ) ) ? ( ' last' ) : ( '' );
					return do_shortcode( '[column size="2/3' . $last . '"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_two_third
			add_shortcode( 'two_third', 'wm_shortcode_two_third' );

			if ( ! function_exists( 'wm_shortcode_two_third_last' ) ) {
				function wm_shortcode_two_third_last( $atts, $content = null ) {
					return do_shortcode( '[column size="2/3 last"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_two_third_last
			add_shortcode( 'two_third_last', 'wm_shortcode_two_third_last' );

		//fourths
			if ( ! function_exists( 'wm_shortcode_one_fourth' ) ) {
				function wm_shortcode_one_fourth( $atts, $content = null ) {
					extract( shortcode_atts( array(
								'last' => '',
							), $atts )
						);
					$last = ( trim( $last ) ) ? ( ' last' ) : ( '' );
					return do_shortcode( '[column size="1/4' . $last . '"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_fourth
			add_shortcode( 'one_fourth', 'wm_shortcode_one_fourth' );

			if ( ! function_exists( 'wm_shortcode_one_fourth_last' ) ) {
				function wm_shortcode_one_fourth_last( $atts, $content = null ) {
					return do_shortcode( '[column size="1/4 last"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_fourth_last
			add_shortcode( 'one_fourth_last', 'wm_shortcode_one_fourth_last' );

			if ( ! function_exists( 'wm_shortcode_three_fourth' ) ) {
				function wm_shortcode_three_fourth( $atts, $content = null ) {
					extract( shortcode_atts( array(
								'last' => '',
							), $atts )
						);
					$last = ( trim( $last ) ) ? ( ' last' ) : ( '' );
					return do_shortcode( '[column size="3/4' . $last . '"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_three_fourth
			add_shortcode( 'three_fourth', 'wm_shortcode_three_fourth' );

			if ( ! function_exists( 'wm_shortcode_three_fourth_last' ) ) {
				function wm_shortcode_three_fourth_last( $atts, $content = null ) {
					return do_shortcode( '[column size="3/4 last"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_three_fourth_last
			add_shortcode( 'three_fourth_last', 'wm_shortcode_three_fourth_last' );

		//fifths
			if ( ! function_exists( 'wm_shortcode_one_fifth' ) ) {
				function wm_shortcode_one_fifth( $atts, $content = null ) {
					extract( shortcode_atts( array(
								'last' => '',
							), $atts )
						);
					$last = ( trim( $last ) ) ? ( ' last' ) : ( '' );
					return do_shortcode( '[column size="1/5' . $last . '"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_fifth
			add_shortcode( 'one_fifth', 'wm_shortcode_one_fifth' );

			if ( ! function_exists( 'wm_shortcode_one_fifth_last' ) ) {
				function wm_shortcode_one_fifth_last( $atts, $content = null ) {
					return do_shortcode( '[column size="1/5 last"]' . $content . '[/column]' );
				}
			} // /wm_shortcode_one_fifth_last
			add_shortcode( 'one_fifth_last', 'wm_shortcode_one_fifth_last' );





/*
*****************************************************
*      COUNTDOWN TIMER
*****************************************************
*/
	/**
	* [countdown time="" size="" /]
	*
	* Countdown timer
	*
	* @param size [s/m/l/xl/NONE]
	* @param time [DATE: Y-m-d H:i]
	*/
	if ( ! function_exists( 'wm_shortcode_countdown' ) ) {
		function wm_shortcode_countdown( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'size' => 'xl',
				'time' => '',
				), $atts)
				);

			//validation
			if ( ! trim( $time ) || ! strtotime( trim( $time ) ) || strtotime( trim( $time ) ) < strtotime( 'now' ) )
				return;

			static $countdownIDs;

			$sizes = array(
				'all' => array( 's', 'm', 'l', 'xl' ),
				's'   => 'small',
				'm'   => 'medium',
				'l'   => 'large',
				'xl'  => 'extra-large',
				);

			$size = ( in_array( trim( $size ), $sizes['all'] ) ) ? ( ' size-' . esc_attr( $sizes[trim( $size )] ) ) : ( ' size-medium' );
			$time = strtotime( trim( $time ) );


			$out = '<!-- Countdown timer -->
				<div class="countdown-timer' . $size . '">
					<div id="countdown-timer-' . absint( ++$countdownIDs ) . '">
						<div class="dash weeks_dash">
							<span class="dash_title">' . __( 'Weeks', 'lespaul_domain' ) . '</span>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash days_dash">
							<span class="dash_title">' . __( 'Days', 'lespaul_domain' ) . '</span>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash hours_dash">
							<span class="dash_title">' . __( 'Hours', 'lespaul_domain' ) . '</span>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash minutes_dash">
							<span class="dash_title">' . __( 'Minutes', 'lespaul_domain' ) . '</span>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>

						<div class="dash seconds_dash">
							<span class="dash_title">' . __( 'Seconds', 'lespaul_domain' ) . '</span>
							<div class="digit first">0</div>
							<div class="digit">0</div>
						</div>
					</div>
				</div>

			<script><!--
			jQuery( function() {
				jQuery( "#countdown-timer-' . absint( $countdownIDs ) . '" ).countDown( {
					targetDate: {
						"day"   : ' . date( 'j', $time ) . ',
						"month" : ' . date( 'n', $time ) . ',
						"year"  : ' . date( 'Y', $time ) . ',
						"hour"  : ' . date( 'G', $time ) . ',
						"min"   : ' . intval( date( 'i', $time ) ) . ',
						"sec"   : 0
					}
				} );
			} );
			//--></script>';

			//output
			if ( $out ) {
				wp_enqueue_script( 'lwtCountdown' );
				return $out . "\r\n\r\n";
			}
		}
	} // /wm_shortcode_countdown
	add_shortcode( 'countdown', 'wm_shortcode_countdown' );





/*
*****************************************************
*      DEVIDER
*****************************************************
*/
	/**
	* [divider type="normal" opacity="10" space_before="" space_after="" style="" /]
	*
	* @param opacity      [0-100]
	* @param space_after  [#/NONE]
	* @param space_before [#/NONE]
	* @param style        [TEXT]
	* @param type         [plain/normal/dashed/dotted/fading/star/shadow-top/shadow-bottom/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_divider' ) ) {
		function wm_shortcode_divider( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'opacity'      => 0,
				'space_after'  => 0,
				'space_before' => 0,
				'style'        => '',
				'type'         => 'normal',
				), $atts )
				);

			$types      = array( 'plain', 'normal', 'dashed', 'diagonal', 'dotted', 'fading', 'star', 'shadow-top', 'shadow-bottom' );
			$styleStart = '';

			//validation
			$type = ( in_array( trim( $type ), $types ) ) ? ( ' class="' . esc_attr( trim( $type ) ) . '"' ) : ( '' );

			if ( trim( $opacity ) && 101 > absint( $opacity ) )
				$styleStart .= 'opacity: ' . ( absint( str_replace( '%', '', $opacity ) ) / 100 ) . '; filter: alpha(opacity=' . str_replace( '%', '', $opacity ) . '); ';

			if ( absint( $space_before ) )
				$styleStart .= 'margin-top: ' . absint( $space_before ) . 'px; ';
			if ( absint( $space_after ) )
				$styleStart .= 'margin-bottom: ' . absint( $space_after ) . 'px; ';

			$style = $styleStart . trim( $style );
			$style = ( $style ) ? ( ' style="' . $style . '"' ) : ( '' );

			//output
			$out = '<hr' . $type . $style . ' />';
			return $out;
		}
	} // /wm_shortcode_divider
	add_shortcode( 'devider', 'wm_shortcode_divider' ); //legacy...
	add_shortcode( 'divider', 'wm_shortcode_divider' );





/*
*****************************************************
*      DROPCAPS
*****************************************************
*/
	/**
	* [dropcap type="round"]content[/dropcap]
	*
	* @param style [TEXT]
	* @param type  [round/square/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_dropcap' ) ) {
		function wm_shortcode_dropcap( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'style' => '',
				'type'  => ''
				), $atts )
				);

			$types = array( 'round', 'square', 'leaf' );

			//validation
			$type  = ( in_array( trim( $type ), $types ) ) ? ( ' ' . trim( $type ) ) : ( '' );
			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			$out = '<span class="dropcap' . $type . '"' . $style . '>' . do_shortcode( $content ) . '</span>';
			return $out;
		}
	} // /wm_shortcode_dropcap
	add_shortcode( 'dropcap', 'wm_shortcode_dropcap' );





/*
*****************************************************
*      ICON
*****************************************************
*/
	/**
	* [icon type="icon-adjust" size="" /]
	*
	* @param size [#/NONE]
	* @param type [predefined/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_icon' ) ) {
		function wm_shortcode_icon( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'size'  => '',
				'style' => '',
				'type'  => '',
				), $atts )
				);

			//validation
			$size  = ( trim( $size ) ) ? ( 'font-size: ' . absint( $size ) . 'px; line-height: ' . absint( $size ) . 'px; vertical-align: middle; position: relative; top: -.05em;' ) : ( '' );
			$style = ( $size || trim( $style ) ) ? ( ' style="' . $size . trim( $style ) . '"' ) : ( '' );
			$type  = ( false !== stripos( $type, 'icon-' ) ) ? ( trim( $type ) ) : ( 'icon-' . trim( $type ) );

			//output
			return ( ! $type ) ? ( '' ) : ( '<i class="' . esc_attr( $type ) . '"' . $style . '></i>' );
		}
	} // /wm_shortcode_icon
	add_shortcode( 'icon', 'wm_shortcode_icon' );





/*
*****************************************************
*      LISTS
*****************************************************
*/
	/**
	* [list bullet="star"]content[/list]
	*
	* @param bullet [icon name/NONE]
	* @param icon   [legacy - the same as bullet]
	*/
	if ( ! function_exists( 'wm_shortcode_list' ) ) {
		function wm_shortcode_list( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'bullet' => '',
				'icon'   => '',
				), $atts )
				);

			$bullet = ( $bullet ) ? ( trim( $bullet ) ) : ( trim( $icon ) );
			$bullet = ( $bullet && false === strstr( $bullet, 'icon-' ) ) ? ( 'icon-' . sanitize_title( $bullet ) ) : ( $bullet );

			//output
			return do_shortcode( shortcode_unautop( str_replace( '<li>', '<li class="' . $bullet . '">', $content ) ) );
		}
	} // /wm_shortcode_list
	add_shortcode( 'list', 'wm_shortcode_list' );





/*
*****************************************************
*      LOGIN FORM
*****************************************************
*/
	/**
	* [login stay="" /]
	*
	* @param stay [BOOLEAN/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_login' ) ) {
		function wm_shortcode_login( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'stay' => false,
				), $atts)
				);

			$redirect = ( $stay ) ? ( get_permalink() ) : ( home_url() );

			$out = '';
			$out .= '<div class="wrap-login">';


			if ( ! is_user_logged_in() ) {
				$out .= '<h3>' . __( 'Log in', 'lespaul_domain' ) . '</h3>';

				$out .= wp_login_form( array(
					'echo'           => false,
					'redirect'       => $redirect,
					'form_id'        => 'form-login',
					'label_username' => __( 'Username', 'lespaul_domain' ),
					'label_password' => __( 'Password', 'lespaul_domain' ),
					'label_remember' => __( 'Remember Me', 'lespaul_domain' ),
					'label_log_in'   => __( 'Log In', 'lespaul_domain' ),
					'id_username'    => 'user_login',
					'id_password'    => 'user_pass',
					'id_remember'    => 'rememberme',
					'id_submit'      => 'wp-submit',
					'remember'       => true,
					'value_username' => null,
					'value_remember' => false
					) );

				$out .= '<p class="note"><small><a href="' . wp_lostpassword_url( get_permalink() ) . '" title="' . __( 'Password will be resent to your e-mail address.', 'lespaul_domain' ) . '">' . __( 'I have lost my password', 'lespaul_domain' ) . '</a></small></p>';
			} else {
				$out .= '[button url="' . wp_logout_url( get_permalink() ) . '" color="red" size="xl"]' . __( 'Log out', 'lespaul_domain' ) . '[/button]';
			}

			$out .= '</div>';

			//output
			return do_shortcode( $out );
		}
	} // /wm_shortcode_login
	add_shortcode( 'login', 'wm_shortcode_login' );





/*
*****************************************************
*      MARKERS
*****************************************************
*/
	/**
	* [marker color="green" style=""]content[/marker]
	*
	* @param color [gray/green/blue/orange/red/NONE]
	* @param style [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_marker' ) ) {
		function wm_shortcode_marker( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'color' => 'gray',
				'style' => '',
				), $atts )
				);

			$colors = array( 'gray', 'green', 'blue', 'orange', 'red' );

			//validation
			$color = ( in_array( trim( $color ), $colors ) ) ? ( ' color-' . esc_attr( trim( $color ) ) ) : ( ' color-gray' );
			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			return '<mark class="marker' . $color . '"' . $style . '>' . do_shortcode( $content ) . '</mark>';
		}
	} // /wm_shortcode_marker
	add_shortcode( 'marker', 'wm_shortcode_marker' );





/*
*****************************************************
*      POSTS / PAGES / CUSTOM POSTS
*****************************************************
*/
	/**
	* [content_module module="123" no_thumb="" no_title="" layout="" randomize="" /]
	*
	* Content module
	*
	* @param id        [POST ID OR SLUG [required]]
	* @param module    [the same as id]
	* @param layout    [center/NONE]
	* @param no_thumb  [BOOLEAN]
	* @param no_title  [BOOLEAN]
	* @param randomize [CONTENT MODULE TAG ID OR SLUG [required]]
	* @param widget    [BOOLEAN]
	*/
	if ( ! function_exists( 'wm_shortcode_content_module' ) ) {
		function wm_shortcode_content_module( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'id'        => null,
				'layout'    => '',
				'module'    => null,
				'no_thumb'  => false,
				'no_title'  => false,
				'randomize' => null,
				'widget'    => true,
				), $atts )
				);

			$id = ( trim( $module ) ) ? ( trim( $module ) ) : ( trim( $id ) );

			if ( ! $id && ! $randomize )
				return;

			static $displayedIds = array();

			$id        = ( is_numeric( $id ) ) ? ( absint( $id ) ) : ( sanitize_title( $id ) );
			$postQuery = ( is_numeric( $id ) ) ? ( 'p' ) : ( 'name' );
			$randomize = ( is_numeric( $randomize ) ) ? ( absint( $randomize ) ) : ( sanitize_title( $randomize ) );
			$field     = ( is_numeric( $randomize ) ) ? ( 'id' ) : ( 'slug' );

			$out = '';

			//get the Content Module content
			wp_reset_query();

			if ( $randomize )
				$queryArgs = array(
					'post_type'           => 'wm_modules',
					'posts_per_page'      => 1,
					'ignore_sticky_posts' => 1,
					'orderby'             => 'rand',
					'tax_query'           => array( array(
							'taxonomy' => 'content-module-tag',
							'field'    => $field,
							'terms'    => $randomize
						) ),
					'post__not_in'        => $displayedIds,
					);
			else
				$queryArgs = array(
					'post_type' => 'wm_modules',
					$postQuery  => $id,
					);

			$the_module = new WP_Query( $queryArgs );
			if ( $the_module->have_posts() ) {

				$the_module->the_post();

				$displayedIds[] = get_the_ID();

				$moreURL = esc_url( stripslashes( wm_meta_option( 'module-link' ) ) );
				$iconBg  = ( wm_meta_option( 'module-icon-box-color' ) ) ? ( ' style="background-color: ' . wm_meta_option( 'module-icon-box-color', get_the_ID(), 'color' ) . '; color: ' . wm_modify_color( wm_meta_option( 'module-icon-box-color', get_the_ID(), 'color' ), 200, -200 ) . '"' ) : ( '' );
				$layout  = ( $layout ) ? ( ' layout-' . $layout ) : ( null );

				//HTML to display output
				$classWrapper  = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( ' icon-module' ) : ( '' );
				$classWrapper .= ( $no_thumb ) ? ( ' no-thumb' ) : ( '' );
				$classWrapper .= ( $no_title ) ? ( ' no-title' ) : ( '' );

				$moduleTitle = '<h3>';
				$moduleTitle .= ( $moreURL ) ? ( '<a href="' . $moreURL . '">' ) : ( '' );
				$moduleTitle .= get_the_title();
				$moduleTitle .= ( $moreURL ) ? ( '</a>' ) : ( '' );
				$moduleTitle .= '</h3>';

				$out .= '<div class="content-module-' . get_the_ID() . $classWrapper . $layout . '">';

					if ( 'icon' === wm_meta_option( 'module-type' ) && wm_meta_option( 'module-font-icon' ) ) {

						$imageContainerClass  = 'icon-container';
						$imageContainerClass .= ( $iconBg ) ? ( ' colored-background' ) : ( '' );
						$out .= '<div class="' . $imageContainerClass . '"' . $iconBg . '>';
							if ( $moreURL )
								$out .= '<a href="' . $moreURL . '">';
							$out .= '<i class="' . wm_meta_option( 'module-font-icon' ) . '"></i>';
							if ( $moreURL )
								$out .= '</a>';
						$out .= '</div>';

					} elseif ( has_post_thumbnail() && ! $no_thumb ) {

						$imageContainerClass  = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( 'icon-container' ) : ( 'image-container' );
						$imageContainerClass .= ( $iconBg ) ? ( ' colored-background' ) : ( '' );
						$out .= '<div class="' . $imageContainerClass . '"' . $iconBg . '>';
							if ( $moreURL )
								$out .= '<a href="' . $moreURL . '">';
							$out .= get_the_post_thumbnail( get_the_ID(), 'mobile' );
							if ( $moreURL )
								$out .= '</a>';
						$out .= '</div>';

					}

					if ( ! $no_title )
						$out .= $moduleTitle;

					$out .= '<div class="module-content clearfix">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';

					$customs = get_post_custom();

				$out .= '</div>';

			}	else {

				return;

			}
			wp_reset_query();

			//output
			if ( $widget )
				return '<div class="wm-content-module apply-top-margin widget">' . $out . '</div>';
			else
				return $out;
		}
	} // /wm_shortcode_content_module
	add_shortcode( 'content_module', 'wm_shortcode_content_module' );



	/**
	* [faq category="5" order="new" align=""][/faq]
	*
	* FAQ list
	*
	* @param align     [left/right/NONE]
	* @param category  [FAQ CATEGORY ID OR SLUG]
	* @param desc_size [#/NONE]
	* @param order     [new/old/name/random/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_faq' ) ) {
		function wm_shortcode_faq( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align'        => 'left',
				'category'     => null,
				'desc_size'    => 4,
				'order'        => 'name',
				), $atts )
				);

			if ( 'disable' === wm_option( 'cp-role-faq' ) )
				return;

			//validation
			$out         = '';
			$align       = ( 'right' === $align ) ? ( $align ) : ( 'left' );
			$colsDesc    = ( 1 < absint( $desc_size ) && 6 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
			$orderMethod = array(
					'all'    => array( 'new', 'old', 'name', 'random' ),
					'new'    => array( 'date', 'DESC' ),
					'old'    => array( 'date', 'ASC' ),
					'name'   => array( 'title', 'ASC' ),
					'random' => array( 'rand', '' )
				);

			$order = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['name'] );

			if ( $category )
				if ( is_numeric( $category ) ) {
					$category = absint( $category );
				} else {
					$category = get_term_by( 'slug', sanitize_title( $category ), 'faq-category' );
					$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
				}
			else
				$category = null;

			//get the faq
			wp_reset_query();

			$queryArgs = array(
					'post_type'           => 'wm_faq',
					'posts_per_page'      => -1,
					'ignore_sticky_posts' => 1,
					'orderby'             => $order[0],
					'order'               => $order[1]
				);
			if ( $category )
				$queryArgs['tax_query'] = array( array(
					'taxonomy' => 'faq-category',
					'field'    => 'id',
					'terms'    => $category
				) );

			$faq = new WP_Query( $queryArgs );
			if ( $faq->have_posts() ) {

				$out .= '<div class="wrap-faq-shortcode clearfix apply-top-margin">';
				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last">' );
				}

				$out .= '<div class="wrap-faqs">';

				while ( $faq->have_posts() ) : //output post content
					$faq->the_post();

					$terms      = get_the_terms( get_the_ID() , 'faq-category' );
					$termsClass = '';
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach( $terms as $term ) {
							$termsClass .= ' faq-category-' . $term->slug;
						}
					}

					$out   .= '<article class="item item-' . get_the_ID() . $termsClass . '"><div class="toggle-wrapper">';
						$out .= '<h3 class="toggle-heading question">' . get_the_title() . '</h3>';
						$out .= '<div class="answer"><h2 class="faq-question">' . get_the_title() . '</h2>' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';
					$out   .= '</div></article>';
				endwhile;

				$out .= '</div>';

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '</div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div>' );
				}

				$out .= '</div>';

			}
			wp_reset_query();

			return $out;
		}
	} // /wm_shortcode_faq
	add_shortcode( 'faq', 'wm_shortcode_faq' );



	/**
	* [last_update format="" item="" /]
	*
	* Date of last update of posts or projects
	*
	* @param item   [projects/posts/NONE]
	* @param format [text/NONE (PHP date format)]
	*/
	if ( ! function_exists( 'wm_shortcode_posts_update' ) ) {
		function wm_shortcode_posts_update( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'item'   => 'posts',
				'format' => get_option( 'date_format' ),
				), $atts )
				);

			$itemArray = array(
				'projects' => 'wm_projects',
				'posts'    => 'post'
				);
			if ( 'disable' === wm_option( 'cp-role-projects' ) )
				$itemArray = array(
					'posts' => 'post'
					);

			$item = ( in_array( trim( $item ), array_flip( $itemArray ) ) ) ? ( $itemArray[trim( $item )] ) : ( 'post' );

			$post = get_posts( array(
				'numberposts' => 1,
				'post_type'   => $item,
				) );

			return date( $format, strtotime( $post[0]->post_date ) );
		}
	} // /wm_shortcode_posts_update
	add_shortcode( 'last_update', 'wm_shortcode_posts_update' );



	/**
	* [logos columns="5" count="10" order="new" align="left" grayscale="0" scroll=""]content[/logos]
	*
	* Logos (of clients/partners)
	*
	* @param align        [left/right/NONE]
	* @param category     [LOGOS CATEGORY ID OR SLUG]
	* @param columns      [#/NONE (1 - 9)]
	* @param count        [#/NONE]
	* @param desc_size    [#/NONE]
	* @param grayscale    [BOOLEAN/NONE]
	* @param order        [new/old/name/random/NONE]
	* @param scroll       [#/NONE]
	* @param scroll_stack [BOOLEAN/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_logos' ) ) {
		function wm_shortcode_logos( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align'        => 'left',
				'category'     => null,
				'columns'      => 4,
				'count'        => 4,
				'desc_size'    => 4,
				'grayscale'    => true,
				'order'        => 'random',
				'scroll'       => 0,
				'scroll_stack' => false,
				), $atts )
				);

			if ( 'disable' === wm_option( 'cp-role-logos' ) )
				return;

			$out = '';

			//validation
			$align       = ( 'right' === trim( $align ) ) ? ( trim( $align ) ) : ( 'left' );
			$cols        = ( 0 < absint( $columns ) && 9 >= absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
			$colsDesc    = ( 1 < absint( $desc_size ) && 6 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
			$count       = ( $count ) ? ( absint( $count ) ) : ( 4 );
			$grayscale   = ( $grayscale ) ? ( ' class="grayscale"' ) : ( '' );
			$orderMethod = array(
					'all'    => array( 'new', 'old', 'name', 'random' ),
					'new'    => array( 'date', 'DESC' ),
					'old'    => array( 'date', 'ASC' ),
					'name'   => array( 'title', 'ASC' ),
					'random' => array( 'rand', '' )
				);
			$order       = ( in_array( trim( $order ), $orderMethod['all'] ) ) ? ( $orderMethod[trim( $order )] ) : ( $orderMethod['new'] );

			$classScroll = array( '', '', '' );
			if ( $scroll && 999 < absint( $scroll ) )
				$classScroll = array( ' scrollable auto', absint( $scroll ), ' auto-scroll' );
			elseif ( $scroll )
				$classScroll = array( ' scrollable', '', ' manual-scroll' );
			if ( $scroll && $scroll_stack )
				$classScroll[0] .= ' stack';

			if ( $category )
				if ( is_numeric( $category ) ) {
					$category = absint( $category );
				} else {
					$category = get_term_by( 'slug', sanitize_title( $category ), 'logos-category' );
					$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
				}
			else
				$category = null;

			//get the logos
			wp_reset_query();

			$queryArgs = array(
					'post_type'           => 'wm_logos',
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => 1,
					'orderby'             => $order[0],
					'order'               => $order[1]
				);
			if ( $category )
				$queryArgs['tax_query'] = array( array(
					'taxonomy' => 'logos-category',
					'field'    => 'id',
					'terms'    => $category
				) );

			$logos = new WP_Query( $queryArgs );
			if ( $logos->have_posts() ) {

				$i    = $row = 0;
				$out .= '<div class="wrap-logos-shortcode clearfix apply-top-margin' . $classScroll[2] . '">';

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '"><div class="wrap-logos' . $classScroll[0] . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last"><div class="wrap-logos' . $classScroll[0] . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">' ); //if description on the right - open logos container and inner container only ELSE output content column and open logos container
				} else {
				//if no description (no shortcode content)
					$out .= '<div class="wrap-logos' . $classScroll[0] . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">';
				}

					$out .= ( ! $classScroll[0] ) ? ( '<div class="row">' ) : ( '' );

					while ( $logos->have_posts() ) : //output post content
						$logos->the_post();

						$link   = ( wm_meta_option( 'client-link' ) ) ? ( esc_url( wm_meta_option( 'client-link' ) ) ) : ( null );

						if  ( ! $classScroll[0] ) {
							$row  = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
							$out .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
						}
						
						// $thumb  = '';
	     //                $width  = 140;
	     //                $height = 70;
	     //                $title  = get_the_title();
	     //                //$img = get_post_image_src($logos->post->ID);
	     //                $img = wm_meta_option( 'client-logo' );
	     //                $default_attr = array(
	     //                    'src'   => $src,
	     //                    'class' => "attachment-$size",
	     //                    'alt'   => trim(strip_tags( $attachment->post_excerpt )),
	     //                    'title' => trim(strip_tags( $attachment->post_title )),
	     //                 );
	     //                $thumbnail = get_the_post_thumbnail($width,$height);
	     //                $thumb = $thumbnail["thumb"];

						$out   .= '<div class="item column col-1' . $cols . ' no-margin">';
							$out .= ( $link ) ? ( '<a href="' . $link . '" target="_blank">' ) : ( '' );
							//if(has_post_thumbnail())
							//$out .= the_crop_image($img, "&amp;w=$width&amp;h=$height&amp;zc=0",'<img src="' . esc_url( wm_meta_option( 'client-logo' ) ) . '" alt="' . $title . '" title="' . $title . '"' . $grayscale .' />');
							$out .= '<img src="' . esc_url( wm_meta_option( 'client-logo' ) ) . '" alt="' . get_the_title() . '" title="' . get_the_title() . '"' . $grayscale .' />';
							$out .= ( $link ) ? ( '</a>' ) : ( '' );
						$out   .= '</div>';
					endwhile;

					$out .=  ( ! $classScroll[0] ) ? ( '</div>' ) : ( '' );

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '</div></div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div>' ); //if description on the right - close logos container and its inner container and output content column ELSE just close logos container and its inner container
				} else {
				//if no description (no shortcode content)
					$out .= '</div>';
				}

				$out .= '</div>';

			}
			wp_reset_query();

			if ( $classScroll[0] )
				wp_enqueue_script( 'bxslider' );

			return $out;
		}
	} // /wm_shortcode_logos
	add_shortcode( 'logos', 'wm_shortcode_logos' );



	/**
	* [posts columns="5" count="10" category="5" order="new" align="left" scroll="" thumb="0"]content[/posts]
	*
	* Post list
	*
	* @param align          [left/right/NONE]
	* @param category       [POSTS CATEGORY ID OR SLUG]
	* @param columns        [#/NONE (1 - 6)]
	* @param count          [#/NONE]
	* @param desc_size      [#/NONE]
	* @param excerpt_length [#/NONE]
	* @param order          [new/old/name/random/NONE]
	* @param scroll         [#/NONE]
	* @param scroll_stack   [BOOLEAN/NONE]
	* @param thumb          [BOOLEAN]
	*/
	if ( ! function_exists( 'wm_shortcode_posts' ) ) {
		function wm_shortcode_posts( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align'          => 'left',
				'category'       => null,
				'columns'        => 4,
				'count'          => 4,
				'desc_size'      => 4,
				'excerpt_length' => 20,
				'order'          => 'new',
				'scroll'         => 0,
				'scroll_stack'   => false,
				'thumb'          => true,
				), $atts )
				);

			$out = '';

			$imgSize = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );

			//validation
			$align         = ( 'right' === trim( $align ) ) ? ( trim( $align ) ) : ( 'left' );
			$cols          = ( 0 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
			$colsDesc      = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
			$count         = ( $count ) ? ( absint( $count ) ) : ( 4 );
			$orderMethod   = array(
					'all'    => array( 'new', 'old', 'name', 'random' ),
					'new'    => array( 'date', 'DESC' ),
					'old'    => array( 'date', 'ASC' ),
					'name'   => array( 'title', 'ASC' ),
					'random' => array( 'rand', '' )
				);
			$order         = ( in_array( trim( $order ), $orderMethod['all'] ) ) ? ( $orderMethod[trim( $order )] ) : ( $orderMethod['new'] );
			$thumb         = ( $thumb ) ? ( ' has-thumbs' ) : ( false );
			$excerptLength = ( isset( $excerpt_length ) ) ? ( absint( $excerpt_length ) ) : ( 10 );

			$classScroll = array( '', '', '' );
			if ( $scroll && 999 < absint( $scroll ) )
				$classScroll = array( ' scrollable auto', absint( $scroll ), ' auto-scroll' );
			elseif ( $scroll )
				$classScroll = array( ' scrollable', '', ' manual-scroll' );
			if ( $scroll && $scroll_stack )
				$classScroll[0] .= ' stack';

			if ( $category )
				if ( is_numeric( $category ) ) {
					$category = absint( $category );
				} else {
					$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
					$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
				}
			else
				$category = null;

			//get the posts
			wp_reset_query();

			$queryArgs = array(
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => 1,
					'cat'                 => $category,
					'orderby'             => $order[0],
					'order'               => $order[1],
					'tax_query'           => array( array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-quote', 'post-format-status' ),
						'operator' => 'NOT IN',
						) )
				);

			$posts = new WP_Query( $queryArgs );

			if ( $posts->have_posts() ) {

				$i    = $row = 0;
				$out .= '<div class="wrap-posts-shortcode clearfix apply-top-margin' . $thumb . $classScroll[2] . '">';

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '"><div class="wrap-posts' . $classScroll[0] . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last"><div class="wrap-posts' . $classScroll[0] . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">' ); //if description on the right - open posts container and inner container only ELSE output content column and open posts container
				} else {
				//if no description (no shortcode content)
					$out .= '<div class="wrap-posts' . $classScroll[0] . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">';
				}

					$out .= ( ! $classScroll[0] ) ? ( '<div class="row">' ) : ( '' );

					while ( $posts->have_posts() ) : //output post content
						$posts->the_post();

						//setting excerpt text
						if ( 0 < $excerptLength ) {
							$excerptText = $posts->post->post_excerpt . $posts->post->post_content;
							if ( has_post_format( 'audio' ) || has_post_format( 'video' ) ) {
								$mediaURL = '';
								//search for the first URL in content
								preg_match( '/http(.*)/', strip_tags( $excerptText ), $matches );
								if ( isset( $matches[0] ) )
									$mediaURL = trim( $matches[0] );
								//remove <a> tag containing URL
								$excerptText = preg_replace( '/<a(.*?)>http(.*?)<\/a>/', '', $excerptText );
								//remove any video URL left in content
								if ( $mediaURL )
									$excerptText = str_replace( array( $mediaURL, $mediaURL . ' ', ' ' . $mediaURL ), '', $excerptText );
							}
							$excerptText = wm_string_length( strip_tags( $excerptText ), $excerptLength, '&hellip;' );
						} else {
							$excerptText = '';
						}

						$postOutput  = array(
								'date'    => '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>',
								'thumb'   => wm_thumb( array(
										'class'       => 'post-thumb',
										'size'        => $imgSize,
										'list'        => true,
										'placeholder' => true,
										'overlay'     => __( 'Read more', 'lespaul_domain' ),
									) ),
								'title'   => '<h3 class="post-title text-element"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>',
								'excerpt' => $excerptText,
								'more'    => ' | ' . wm_more( 'nobtn' )
							);

						if  ( ! $classScroll[0] ) {
							$row  = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
							$out .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
						}

						$out   .= '<article class="column col-1' . $cols . ' no-margin">';
							$out .= ( $thumb ) ? ( $postOutput['thumb'] ) : ( '' );
							$out .= '<div class="text">';
								$out .= $postOutput['title'];
								$out .= '<div class="text-element post-date">' . $postOutput['date'] . '</div>';
								$out .= '<div class="post-excerpt text-element">' . $postOutput['excerpt'] . '</div>';
							$out .= '</div>';
						$out   .= '</article>';
					endwhile;

					$out .=  ( ! $classScroll[0] ) ? ( '</div>' ) : ( '' );

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '</div></div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div>' ); //if description on the right - close posts container and its inner container and output content column ELSE just close posts container and its inner container
				} else {
				//if no description (no shortcode content)
					$out .= '</div>';
				}

				$out .= '</div>';

			}
			wp_reset_query();

			if ( $classScroll[0] )
				wp_enqueue_script( 'bxslider' );

			return $out;
		}
	} // /wm_shortcode_posts
	add_shortcode( 'posts', 'wm_shortcode_posts' );



	/**
	* [prices table="123" /]
	*
	* Price tables
	*
	* @param table [PRICE TABLE ID OR SLUG [required]]
	*/
	if ( ! function_exists( 'wm_shortcode_prices' ) ) {
		function wm_shortcode_prices( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'table' => null
				), $atts )
				);

			if ( 'disable' === wm_option( 'cp-role-prices' ) )
				return;

			if ( ! $table )
				return;

			$i            = 0;
			$out          = '';
			$columnsArray = array();
			$table        = ( is_numeric( $table ) ) ? ( absint( $table ) ) : ( sanitize_title( $table ) );
			$field        = ( is_numeric( $table ) ) ? ( 'id' ) : ( 'slug' );

			//get the table columns
			wp_reset_query();
			$price_table = new WP_Query( array(
				'post_type'      => 'wm_price',
				'posts_per_page' => 6,
				'tax_query'      => array( array(
						'taxonomy' => 'price-table',
						'field'    => $field,
						'terms'    => $table
					) ),
				'post__not_in'   => get_option( 'sticky_posts' )
				) );
			if ( $price_table->have_posts() && $table ) {
				$columnSize = $price_table->post_count;

				$out .= '<div id="price-table-' . $table . '" class="price-table">';

				while ( $price_table->have_posts() ) :

					$price_table->the_post();

					$i++;

					//$last = ( $columnSize === $i ) ? ( ' last' ) : ( '' );

					$colorBg = ( wm_meta_option( 'price-color' ) ) ? ( wm_meta_option( 'price-color', null, 'color' ) ) : ( null );
					$styles  = ( $colorBg ) ? ( array( ' style="background-color: ' . $colorBg . '; color: ' . wm_modify_color( $colorBg, 200, -200 ) . ';"', ' style="background-color: ' . $colorBg . '; background-image: ' . preg_replace( '/\s+/', ' ', wm_css3_gradient( wm_modify_color( $colorBg, -8, -8 ), 32 ) ) . '; color: ' . wm_modify_color( $colorBg, 200, -200 ) . ';"' ) ) : ( array( '', '' ) );

					$outColumn = '<div class="price-column column no-margin col-1' . $columnSize . wm_meta_option( 'price-style' ) . '">';

						$outColumn .= '<div class="price-heading"' . $styles[0] . '>';
							$outColumn .= '<h3' . $styles[1] . '>' . get_the_title() . '</h3>';
							$outColumn .= '<p class="cost">' . wm_meta_option( 'price-cost' ) . '</p>';
							$outColumn .= '<p class="note">' . wm_meta_option( 'price-note' ) . '</p>';
							$outColumn .= '<div class="price-button">';
								$outColumn .= ( wm_meta_option( 'price-btn-text' ) ) ? ( '<p class="wrap-button">[button url="' . esc_url( wm_meta_option( 'price-btn-url' ) ) . '" color="' . wm_meta_option( 'price-btn-color' ) . '" size="medium"]' . wm_meta_option( 'price-btn-text' ) . '[/button]</p>' ) : ( '' );
							$outColumn .= '</div>';
						$outColumn .= '</div>';

						$outColumn .= '<div class="price-spec">';
						$outColumn .= apply_filters( 'wm_default_content_filters', get_the_content() );
						$outColumn .= '</div>';

						$outColumn .= '<div class="bottom"' . $styles[0] . '></div>';

					$outColumn .= '</div>';

					$colOrder = ( wm_meta_option( 'price-order' ) ) ? ( wm_meta_option( 'price-order' ) ) : ( -7 + $i );
					$columnsArray[$colOrder] = $outColumn;

				endwhile;

				ksort( $columnsArray );
				$out .= implode( "\r\n", $columnsArray );
				$out .= '</div>';

			}
			wp_reset_query();

			//output
			return do_shortcode( $out );
		}
	} // /wm_shortcode_prices
	add_shortcode( 'prices', 'wm_shortcode_prices' );



	/**
	* [projects align="" filter="" columns="5" count="10" category="" order="" pagination="" thumb="1" scroll=""]content[/projects]
	*
	* Projects list
	*
	* @param align          [left/right/NONE]
	* @param category       [PROJECTS CATEGORY ID OR SLUG]
	* @param columns        [#/NONE (1 - 6)]
	* @param count          [#/NONE]
	* @param desc_size      [#/NONE]
	* @param excerpt_length [#/NONE]
	* @param filter         [BOOLEAN]
	* @param order          [newest/oldest/name/random/NONE]
	* @param pagination     [BOOLEAN]
	* @param related        [BOOLEAN]
	* @param scroll         [#/NONE]
	* @param scroll_stack   [BOOLEAN/NONE]
	* @param thumb          [BOOLEAN]
	*/
	if ( ! function_exists( 'wm_shortcode_projects' ) ) {
		function wm_shortcode_projects( $atts, $content = null ) {
			global $paged;

			if ( ! isset( $paged ) )
				$paged = 1;

			extract( shortcode_atts( array(
				'align'          => 'left',
				'category'       => '',
				'columns'        => 4,
				'count'          => -1,
				'desc_size'      => 4,
				'excerpt_length' => 'default',
				'filter'         => false,
				'order'          => 'new',
				'pagination'     => false,
				'related'        => false,
				'scroll'         => 0,
				'scroll_stack'   => false,
				'thumb'          => true,
				), $atts )
				);

			if ( 'disable' === wm_option( 'cp-role-projects' ) )
				return;

			$out = $filterContent = $wrapperClasses = '';

			$imgSize = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );

			//validation
			$align       = ( 'right' === trim( $align ) ) ? ( trim( $align ) ) : ( 'left' );
			$cols        = ( 0 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
			$colsDesc    = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
			$count       = ( $count ) ? ( intval( $count ) ) : ( -1 );
			$orderMethod = array(
					'all'    => array( 'new', 'old', 'name', 'random' ),
					'new'    => array( 'date', 'DESC' ),
					'old'    => array( 'date', 'ASC' ),
					'name'   => array( 'title', 'ASC' ),
					'random' => array( 'rand', '' )
				);
			$order       = ( in_array( trim( $order ), $orderMethod['all'] ) ) ? ( $orderMethod[trim( $order )] ) : ( $orderMethod['new'] );
			$thumb       = ( $thumb ) ? ( ' has-thumbs' ) : ( false );

			$classScroll = array( '', '', '' );
			if ( $scroll && 999 < absint( $scroll ) )
				$classScroll = array( ' scrollable auto', absint( $scroll ), ' auto-scroll' );
			elseif ( $scroll )
				$classScroll = array( ' scrollable', '', ' manual-scroll' );
			if ( $scroll && $scroll_stack )
				$classScroll[0] .= ' stack';

			$defaultExcerpt = ( 1 == $cols ) ? ( 52 ) : ( 12 );
			$excerptLength  = ( 'default' != $excerpt_length ) ? ( absint( $excerpt_length ) ) : ( $defaultExcerpt );
			$isotopeLayout  = 'fitRows';
			$filter         = ( $filter && ! $classScroll[0] ) ? ( true ) : ( false );
			$filterThis     = ( $filter ) ? ( ' filter-this' ) : ( '' );

			$wrapperClasses .= ( $filter ) ? ( ' filterable-content' ) : ( '' );
			$wrapperClasses .= ( $related ) ? ( ' related-projects' ) : ( '' );
			$wrapperClasses .= ( 1 == $cols ) ? ( ' single-columned' ) : ( '' );

			if ( $related ) {
				global $post;
				$category = array();
				$terms    = get_the_terms( $post->ID , 'project-category' );
				if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
					foreach( $terms as $term ) {
						$category[] = $term->term_id;
					}
				}
			} elseif ( $category ) {
				if ( is_numeric( $category ) ) {
					$category = absint( $category );
				} else {
					$category = get_term_by( 'slug', sanitize_title( $category ), 'project-category' );
					$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
				}
			} else {
				$category = null;
			}

			//get project icons
			$projectIcons = array();
			$terms = get_terms( 'project-type', 'orderby=name&hide_empty=0&hierarchical=0' );
			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$meta = get_option( 'wm-tax_project-type-' . $term->term_id );
					$projectIcons[$meta['type'] . '[' . $term->slug . ']'] = array( $meta['icon'], $term->name );
				}
			}
			if ( empty( $projectIcons ) )
				$projectIcons = array(
						'static-project' => array( 'wmicon-image', __( 'Image', 'lespaul_domain' ) ),
						'slider-project' => array( 'wmicon-gallery', __( 'Image slider', 'lespaul_domain' ) ),
						'video-project'  => array( 'wmicon-video', __( 'Video', 'lespaul_domain' ) ),
						'audio-project'  => array( 'wmicon-audio', __( 'Audio', 'lespaul_domain' ) )
					);

			//get the projects
			wp_reset_query();

			$queryArgs = array(
					'paged'               => $paged,
					'post_type'           => 'wm_projects',
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => 1,
					'orderby'             => $order[0],
					'order'               => $order[1]
				);
			if ( $category )
				$queryArgs['tax_query'] = array( array(
					'taxonomy' => 'project-category',
					'field'    => 'id',
					'terms'    => $category
				) );
			if ( $related && get_the_ID() )
				$queryArgs['post__not_in'] = array( get_the_ID() );

			$projects = new WP_Query( $queryArgs );

			$pagination      = ( $pagination ) ? ( wm_pagination( $projects, array( 'print' => false ) ) ) : ( '' );
			$wrapperClasses .= ( $pagination ) ? ( ' paginated' ) : ( '' );
			$wrapperClasses .= $thumb . $classScroll[2];

			if ( $projects->have_posts() ) {

				$i    = $row = 0;
				$out .= '<div class="wrap-projects-shortcode clearfix apply-top-margin' . $wrapperClasses . '">';
				$out .= ( $related ) ? ( '<h3 class="separator-heading"><span class="text-holder">' . strip_tags( trim( $related ), '<strong><span><small><em><b><i>' ) . '</span></h3>' ) : ( '' );

				//filter output code
				if ( $filter ) {
					$filterContent .= '<div class="wrap-filter"><ul>';

					if ( $category ) {
					//if parent category set - filter from child categories

						$parentCategory = get_term_by( 'id', $category, 'project-category' );
						$filterContent .= '<li><a href="#" data-filter="*" class="active">' . sprintf( __( 'All <span>%s</span>', 'lespaul_domain' ), $parentCategory->name ) . '</a></li>';

						$terms  = get_term_children( $category, 'project-category' );
						$count  = count( $terms );
						if ( ! is_wp_error( $terms ) && $count > 0 ) {
							$outFilter = array();
							foreach ( $terms as $child ) {
								$term = get_term_by( 'id', $child, 'project-category' );

								$outArray['<li><a href="#" data-filter=".project-category-' . $term->slug . '">' . $term->name . ' <span class="count">(' . $term->count . ')</span></a></li>'] = $term->name;
							}
							asort( $outArray );
							$outArray = array_flip( $outArray );
							$filterContent .= implode( '', $outArray );
						}

					} else {
					//no parent category - filter from all categories

						$filterContent .= '<li><a href="#" data-filter="*" class="active">' . __( 'All', 'lespaul_domain' ) . '</a></li>';

						$terms = get_terms( 'project-category' );
						$count = count( $terms );
						if ( ! is_wp_error( $terms ) && $count > 0 ) {
							foreach ( $terms as $term ) {
								$filterContent .= '<li><a href="#" data-filter=".project-category-' . $term->slug . '">' . $term->name . ' <span class="count">(' . $term->count . ')</span></a></li>';
							}
						}

					}

					$filterContent .= '</ul></div>';
				} // if filter

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '">' . $filterContent . '<div class="wrap-projects' . $filterThis . $classScroll[0] . '" data-layout-mode="' . $isotopeLayout . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last">' . $filterContent . '<div class="wrap-projects' . $filterThis . $classScroll[0] . '" data-layout-mode="' . $isotopeLayout . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">' ); //if description on the right - open projects container and inner container only ELSE output content column and open projects container
				} else {
				//if no description (no shortcode content)
					$out .= $filterContent . '<div class="wrap-projects' . $filterThis . $classScroll[0] . '" data-layout-mode="' . $isotopeLayout . '" data-time="' . $classScroll[1] . '" data-columns="' . $cols . '">';
				}

					$out .= ( ! $filter && ! $classScroll[0] && 1 != $cols ) ? ( '<div class="row">' ) : ( '' );
					$alt  = '';

					while ( $projects->have_posts() ) : //output post content
						$projects->the_post();

						$terms         = get_the_terms( get_the_ID() , 'project-category' );
						$termsClass    = '';
						$termsOutArray = array();
						if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
							foreach( $terms as $term ) {
								//$termsOutArray[] = '<a href="' . get_term_link( $term->slug, 'project-category' ) . '" class="item">' . $term->name . '</a>';
								$termsOutArray[] = '<span class="item">' . $term->name . '</span>';
								$termsClass .= ' project-category-' . $term->slug;
							}
						}

						$link        = ( wm_meta_option( 'project-link-list' ) ) ? ( esc_url( wm_meta_option( 'project-link' ) ) ) : ( get_permalink() );
						$target      = ( 'target-blank' == wm_meta_option( 'project-link-list' ) ) ? ( ' target="_blank"' ) : ( '' );
						$overlayText = ( 'modal' == wm_meta_option( 'project-link-list' ) ) ? ( __( 'Zoom', 'lespaul_domain' ) ) : ( __( '<div class="p-more"></div>Saiba Mais', 'lespaul_domain' ) );

						if ( 0 < $excerptLength && has_excerpt() )
							$excerptText = wm_string_length( get_the_excerpt(), $excerptLength, '&hellip;' );
						else
							$excerptText = '';

						$icon      = 'wmicon-image';
						$iconTitle = __( 'Image', 'lespaul_domain' );
						if ( wm_meta_option( 'project-type' ) ) {
							if ( isset( $projectIcons[wm_meta_option( 'project-type' )][0] ) )
								$icon = $projectIcons[wm_meta_option( 'project-type' )][0];
							if ( isset( $projectIcons[wm_meta_option( 'project-type' )][1] ) )
								$iconTitle = $projectIcons[wm_meta_option( 'project-type' )][1];
						}

						$projectOutput  = array(
								'category' => '<div class="project-category text-element">' . implode( ', ', $termsOutArray ) . '</div>',
								'thumb'    => wm_thumb( array(
										'class'        => 'post-thumb',
										'size'         => $imgSize,
										'list'         => true,
										'link'         => array( $link, wm_meta_option( 'project-link-list' ) ),
										'placeholder'  => true,
										'a-attributes' => $target,
										'overlay'      => $overlayText,
									) ),
								'title'    => '<h3 class="project-title text-element"><a href="' . $link . '"' . $target . ' class="' . wm_meta_option( 'project-link-list' ) . '">' . get_the_title() . '</a></h3>',
								'type'     => '<a class="project-icon ' . wm_meta_option( 'project-link-list' ) . '"' . $target . ' href="' . $link . '"><i class="' . $icon . '" title="' . $iconTitle . '"></i></a>',
								'excerpt'  => ( $excerptText ) ? ( '<div class="project-excerpt text-element">' . strip_tags( strip_shortcodes( $excerptText ) ) . '</div>' ) : ( '' ),
							);

						if ( ! $filter && ! $classScroll[0] && 1 != $cols ) {
							$row  = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
							$out .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
						}

						$out   .= '<article class="column col-1' . $cols . ' no-margin item item-' . get_the_ID() . $termsClass . $alt . '">';
							$out .= ( $thumb ) ? ( $projectOutput['thumb'] ) : ( '' );
							$out .= '<div class="text">';
								$out .= $projectOutput['type'];
								$out .= $projectOutput['title'];
								$out .= $projectOutput['category'];
								$out .= $projectOutput['excerpt'];
							$out .= '</div>';
						$out   .= '</article>';

						$alt = ( $alt ) ? ( '' ) : ( ' alt' );
					endwhile;

					$out .= ( ! $filter && ! $classScroll[0] && 1 != $cols ) ? ( '</div>' ) : ( '' ); //end row

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '</div>' . $pagination . '</div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div>' . $pagination . '</div>' ); //if description on the right - close projects container and its inner container and output content column ELSE just close projects container and its inner container
				} else {
				//if no description (no shortcode content)
					$out .= '</div>' . $pagination;
				}

				$out .= '</div>';

			}
			wp_reset_query();

			if ( $classScroll[0] )
				wp_enqueue_script( 'bxslider' );
			elseif ( $filter )
				wp_enqueue_script( 'isotope' );

			return $out;
		}
	} // /wm_shortcode_projects
	add_shortcode( 'projects', 'wm_shortcode_projects' );



	/**
	* [project_attributes title="" /]
	*
	* Project attributes
	*
	* @param title [text/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_project_attributes' ) ) {
		function wm_shortcode_project_attributes( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'title' => ''
				), $atts )
				);

			if ( 'disable' === wm_option( 'cp-role-projects' ) )
				return;

			$out   = '';
			$title = ( trim( $title ) ) ? ( '<h3>' . trim( $title ) . '</h3>' . "\r\n" ) : ( '' );

			if ( wm_meta_option( 'project-link' ) ) {
				$link = wm_meta_option( 'project-link' );
				$out .= '<li class="attribute-link"><strong class="attribute-heading">' . __( 'Project URL', 'lespaul_domain' ) . ':</strong> ';
				$out .= '<a href="' . esc_url( $link ) . '">' . $link . '</a></li>';
			}

			if ( wm_meta_option( 'project-attributes' ) ) {
				foreach ( wm_meta_option( 'project-attributes' ) as $item ) {
					if ( $item['attr'] && $item['val'] ) {
						$out .= '<li><strong class="attribute-heading">' . $item['attr'] . ':</strong> ';
						$out .= $item['val'] . '</li>';
					}
				}
			}

			$out = ( $out ) ? ( do_shortcode( '<div class="attributes">' . $title . '<ul>' . $out . '</ul></div>' ) ) : ( null );

			//output
			return $out;
		}
	} // /wm_shortcode_project_attributes
	add_shortcode( 'project_attributes', 'wm_shortcode_project_attributes' );



	/**
	* [staff columns="5" count="10" department="5" order="new" align="left" thumb="1"]content[/staff]
	*
	* Staff list
	*
	* @param align      [left/right/NONE]
	* @param columns    [#/NONE (1 - 6)]
	* @param count      [#/NONE]
	* @param department [STAFF DEPARTMENT ID OR SLUG]
	* @param desc_size  [#/NONE]
	* @param order      [new/old/name/random/NONE]
	* @param thumb      [BOOLEAN]
	*/
	
	if ( ! function_exists( 'wm_shortcode_staff' ) ) {
		function wm_shortcode_staff( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align'      => 'left',
				'columns'    => 4,
				'count'      => 4,
				'department' => null,
				'desc_size'  => 4,
				'order'      => 'new',
				'thumb'      => true,
				), $atts )
				);

			if ( 'disable' === wm_option( 'cp-role-staff' ) )
				return;

			$out = '';

			$imgSize = ( wm_option( 'general-staff-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-staff-image-ratio' ) ) : ( 'mobile-ratio-169' );

			//validation
			$align         = ( 'right' === trim( $align ) ) ? ( trim( $align ) ) : ( 'left' );
			$cols          = ( 0 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
			$colsDesc      = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
			$count         = ( $count ) ? ( absint( $count ) ) : ( 4 );
			$orderMethod   = array(
					'all'    => array( 'new', 'old', 'name', 'random' ),
					'new'    => array( 'date', 'DESC' ),
					'old'    => array( 'date', 'ASC' ),
					'name'   => array( 'title', 'ASC' ),
					'random' => array( 'rand', '' )
				);
			$order         = ( in_array( trim( $order ), $orderMethod['all'] ) ) ? ( $orderMethod[trim( $order )] ) : ( $orderMethod['new'] );
			$thumb         = ( $thumb ) ? ( ' has-thumbs' ) : ( false );

			if ( $department )
				if ( is_numeric( $department ) ) {
					$department = absint( $department );
				} else {
					$department = get_term_by( 'slug', sanitize_title( $department ), 'department' );
					$department = ( $department && isset( $department->term_id ) ) ? ( $department->term_id ) : ( null );
				}
			else
				$department = null;

			//get the staff
			wp_reset_query();

			$queryArgs = array(
					'post_type'           => 'wm_staff',
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => 1,
					'orderby'             => $order[0],
					'order'               => $order[1]
				);
			if ( 0 < $department )
				$queryArgs['tax_query'] = array( array(
					'taxonomy' => 'department',
					'field'    => 'id',
					'terms'    => explode( ',', $department )
				) );

			$staff = new WP_Query( $queryArgs );
			if ( $staff->have_posts() ) {

				$i    = $row = 0;
				$out .= '<div class="wrap-staff-shortcode clearfix apply-top-margin' . $thumb . '">';

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '"><div class="wrap-staff"><div class="row">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last"><div class="wrap-staff"><div class="row">' ); //if description on the right - open staff container and inner container only ELSE output content column and open staff container
				} else {
				//if no description (no shortcode content)
					$out .= '<div class="wrap-staff"><div class="row">';
				}

					while ( $staff->have_posts() ) : //output post content
						$staff->the_post();

						if ( wm_option( 'cp-staff-rich' ) )
							$excerptText  = ( has_excerpt() ) ? ( apply_filters( 'wm_default_content_filters', get_the_excerpt() ) ) : ('');
 						else
							$excerptText = apply_filters( 'wm_default_content_filters', get_the_content() );


						$contacts = '';
						if ( wm_meta_option( 'staff-phone' ) )
							$contacts .= '<li class="staff-phone">' . wm_meta_option( 'staff-phone' ) . '</li>';
						if ( wm_meta_option( 'staff-email' ) )
							$contacts .= '<li class="staff-email"><a href="#" data-address="' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '" class="email-nospam">' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '</a></li>';
						if ( wm_meta_option( 'staff-linkedin' ) )
							$contacts .= '<li class="staff-linkedin"><a href="' . esc_url( wm_meta_option( 'staff-linkedin' ) ) . '" target="_blank">' . get_the_title() . '</a></li>';
						if ( wm_meta_option( 'staff-skype' ) )
							$contacts .= '<li class="staff-skype"><a href="skype:' . sanitize_title( wm_meta_option( 'staff-skype' ) ) . '?call">' . wm_meta_option( 'staff-skype' ) . '</a></li>';
						$excerptText .= ( $contacts ) ? ( '<ul>' . $contacts . '</ul>' ) : ( '' );

						$staffOutput  = array(
								'thumb' => wm_thumb( array(
										'class'       => 'staff-thumb',
										'size'        => $imgSize,
										'list'        => true,
										'link'        => 'modal',
										'placeholder' => true,
										'overlay'     => __( 'Zoom', 'lespaul_domain' ),
									) ),
								'thumb-permalink' => wm_thumb( array(
										'class'       => 'staff-thumb',
										'size'        => $imgSize,
										'list'        => true,
										'placeholder' => true,
										'overlay'     => __( '<div class="p-more"></div>Saiba Mais', 'lespaul_domain' ),
									) ),
								'title'      => '<h3 class="staff-title text-element"><strong>' . get_the_title() . '</strong></h3>',
								'title-link' => '<h3 class="staff-title text-element"><a href="' . get_permalink() . '"><strong>' . get_the_title() . '</strong></a></h3>',
								'position'   => '<p class="staff-position text-element">' . wm_meta_option( 'staff-position' ) . '</p>',
								'excerpt'    => $excerptText
							);

						$row    = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
						$out   .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
						$out   .= '<article class="column col-1' . $cols . ' no-margin">';
							if ( $thumb )
								$out .= ( wm_option( 'cp-staff-rich' ) ) ? ( $staffOutput['thumb-permalink'] ) : ( $staffOutput['thumb'] );
							$out .= '<div class="text">';
								$out .= ( wm_option( 'cp-staff-rich' ) ) ? ( $staffOutput['title-link'] ) : ( $staffOutput['title'] );
								$out .= $staffOutput['position'];
								$out .= '<div class="staff-excerpt text-element">' . $staffOutput['excerpt'] . '</div>';
							$out .= '</div>';
						$out   .= '</article>';
					endwhile;

				if ( $content ) {
				//if description (shortcode content)
					$out .= ( 'right' === $align ) ? ( '</div></div></div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div></div>' ); //if description on the right - close staff container and its inner container and output content column ELSE just close staff container and its inner container
				} else {
				//if no description (no shortcode content)
					$out .= '</div></div>';
				}

				$out .= '</div>';

			}
			wp_reset_query();

			return $out;
		}
	} // /wm_shortcode_staff
	add_shortcode( 'staff', 'wm_shortcode_staff' );



	/**
	* [subpages depth="1" order="menu" parents="0" /]
	*
	* Subpages list
	*
	* @param depth   [# [0 = all levels, 1 = top level, 2+ = level depth]]
	* @param order   [TEXT]
	* @param parents [BOOLEAN]
	*/
	if ( ! function_exists( 'wm_shortcode_subpages' ) ) {
		function wm_shortcode_subpages( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'depth'   => 0,
				'order'   => 'menu',
				'parents' => false,
				), $atts )
				);

			global $post, $page_exclusions;

			$sortColumns = array(
				'title' => 'post_title',
				'menu'  => 'menu_order',
				);

			$post        = ( is_home() ) ? ( get_post( get_option( 'page_for_posts' ) ) ) : ( $post );
			$parents     = ( $parents ) ? ( true ) : ( false );
			$parentPages = ( isset( $post->ancestors ) && $parents ) ? ( $post->ancestors ) : ( null ); //get all parent pages in array
			$grandparent = ( ! empty( $parentPages ) ) ? ( end( $parentPages ) ) : ( '' ); //get the first parent page (at the end of the array)
			$order       = ( in_array( trim( $order ), array_flip( $sortColumns ) ) ) ? ( $sortColumns[trim( $order )] ) : ( 'menu_order' );
			$depth       = absint( $depth );

			$pageIDs = get_all_page_ids();

			foreach ( $pageIDs as $pageID ) {
				if ( ! wm_restriction_page( $pageID ) ) {
					$page_exclusions .= ( $page_exclusions ) ? ( ',' . $pageID ) : ( $pageID );
				}
			}

			//subpages or siblings
			if ( $grandparent )
				$children = wp_list_pages( 'sort_column=' . $order . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $grandparent . '&echo=0&depth=' . $depth );
			else
				$children = wp_list_pages( 'sort_column=' . $order . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $post->ID . '&echo=0&depth=' . $depth );

			$out = ( $children ) ? ( '<ul class="sub-pages">' . str_replace( 'page_item', 'page_item', $children ) . '</ul>' ) : ( '' );

			//output
			return do_shortcode( $out );
		}
	} // /wm_shortcode_subpages
	add_shortcode( 'subpages', 'wm_shortcode_subpages' );



	/**
	* [testimonials category="123" count="5" speed="3" layout="large" order="random" private="1" /]
	*
	* Testimonials
	*
	* @param category [TESTIMONIALS CATEGORY ID OR SLUG]
	* @param count    [#]
	* @param layout   [normal/large/NONE]
	* @param order    [new/old/random/NONE]
	* @param private  [BOOLEAN]
	* @param speed    [#]
	* @param stack    [#: how many testimonials to display at once]
	*/
	if ( ! function_exists( 'wm_shortcode_testimonials' ) ) {
		function wm_shortcode_testimonials( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'category' => null,
				'count'    => 5,
				'layout'   => 'normal',
				'order'    => 'new',
				'private'  => false,
				'speed'    => 0,
				'stack'    => 1,
				), $atts )
				);

			if ( wm_option( 'blog-no-format-quote' ) || ! $category )
				return;

			$out      = '';
			$count    = absint( $count );
			$speed    = ( 1 < absint( $speed ) ) ? ( ' data-time="' . absint( $speed ) * 1000 . '"' ) : ( false );
			$layout   = ( 'large' == trim( $layout ) ) ? ( ' large' ) : ( ' normal' );
			$orderMethod = array(
					'all'    => array( 'new', 'old', 'random' ),
					'new'    => array( 'date', 'DESC' ),
					'old'    => array( 'date', 'ASC' ),
					'random' => array( 'rand', '' )
				);
			$order    = ( in_array( trim( $order ), $orderMethod['all'] ) ) ? ( $orderMethod[trim( $order )] ) : ( $orderMethod['new'] );
			$private  = ( ! $private ) ? ( 'publish' ) : ( array( 'publish', 'private' ) );
			$stack    = absint( $stack );

			if ( $category )
				if ( is_numeric( $category ) ) {
					$category = absint( $category );
				} else {
					$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
					$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
				}
			else
				$category = null;

			//get the testimonials
			wp_reset_query();

			$queryArgs = array(
					'post_status'         => $private,
					'posts_per_page'      => $count,
					'ignore_sticky_posts' => 1,
					'cat'                 => $category,
					'orderby'             => $order[0],
					'order'               => $order[1],
					'tax_query'           => array( array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => 'post-format-quote',
						) )
				);

			$testimonials = new WP_Query( $queryArgs );
			if ( $testimonials->have_posts() ) {

				$i    = 0;
				$out .= '<div class="wrap-testimonials-shortcode apply-top-margin' . $layout . '"' . $speed . '><div class="testimonials-list">';

				$articleOpened = false;

				while ( $testimonials->have_posts() ) :

					$i++;

					$testimonials->the_post();

					if (
							1 == $stack ||
							1 == $i ||
							1 == $i % $stack
						) {
						$out .= '<article class="testimonial testimonial-' . get_the_ID() . ' item-' . $i . '">';
						$articleOpened = true;
					}

						$out .= '<div class="testimonial-container">';

						$quote = get_the_content();
						$quote = preg_replace( '/<(\/?)blockquote(.*?)>/', '', $quote ); //remove <blockquote> tags
						$quote = explode( '<cite', $quote ); //split where <cite> tag begins

						$out .= '<blockquote>' . apply_filters( 'wm_default_content_filters', $quote[0] ) . '</blockquote>';

						$quoteSource = '';
						if ( has_post_thumbnail() ) {
							$imgUrl       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'widget' );
							$escImgAlt    = esc_attr( strip_tags( strip_shortcodes( wm_meta_option( 'quoted-author' ) ) ) );
							$quoteSource .= '<span class="testimonial-source-img frame"><img src="' . $imgUrl[0] . '" alt="' . $escImgAlt . '" title="' . $escImgAlt . '" /></span>';
						}
						if ( isset( $quote[1] ) && $quote[1] )
							$quoteSource .= '<cite' . $quote[1];
						if ( $quoteSource )
							$out .= '<p class="testimonial-source">' . $quoteSource . '</p>';

						$out .= '</div>';

					if (
							1 == $stack ||
							$count == $i ||
							0 == $i % $stack
						) {
						$out .= '</article>';
						$articleOpened = false;
					}

				endwhile;

				if ( $articleOpened )
					$out .= '</article>';

				$out .= '</div></div>';

			}
			wp_reset_query();

			if ( $speed )
				wp_enqueue_script( 'bxslider' );

			//output
			return do_shortcode( $out );
		}
	} // /wm_shortcode_testimonials
	add_shortcode( 'testimonials', 'wm_shortcode_testimonials' );





/*
*****************************************************
*      PULLQUOTES
*****************************************************
*/
	/**
	* [pullquote align="left"]content[/pullquote]
	*
	* @param align [left/right/NONE]
	* @param style [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_pullquote' ) ) {
		function wm_shortcode_pullquote( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align' => 'left',
				'style' => '',
				), $atts )
				);

			$pullquoteAlign = array( 'left', 'right' );;

			//validation
			$align = ( in_array( trim( $align ), $pullquoteAlign ) ) ? ( ' align' . trim( $align ) ) : ( ' alignleft' );
			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			return '<blockquote class="pullquote ' . $align . '"' . $style . '>' . do_shortcode( $content ) . '</blockquote>';
		}
	} // /wm_shortcode_pullquote
	add_shortcode( 'pullquote', 'wm_shortcode_pullquote' );





/*
*****************************************************
*      RAW CODE (PRE HTML TAG)
*****************************************************
*/
	/*
	* [raw]content[/raw]
	* [pre]content[/pre]
	*/
	if ( ! function_exists( 'wm_shortcode_raw' ) ) {
		function wm_shortcode_raw( $atts, $content = null ) {
			$content = str_replace( '[', '&#91;', $content );
			$content = str_replace( array( '<p>', '</p>', '<br />', '<span class="br"></span>' ), '', $content );
			return '<pre>' . esc_html( shortcode_unautop( $content ) ) . '</pre>';
		}
	} // /wm_shortcode_raw





/*
*****************************************************
*      SIMPLE SLIDESHOW
*****************************************************
*/
	/**
	* [simple_slideshow ids="" size="" link="" time="" /]
	*
	* Displays simple slider from image IDs
	*
	* @param ids  [text/NONE]
	* @param link [text/NONE] - if set "1" large image link is used, if anything else, it will be turned to URL, if not set, no link applied
	* @param size [text/NONE]
	* @param time [#/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_simple_slideshow' ) ) {
		function wm_shortcode_simple_slideshow( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'ids'  => '',
				'link' => '',
				'size' => 'ratio-169',
				'time' => 5000,
				), $atts )
				);

			$ids = explode( ',', trim( preg_replace( '/\s+/', '', $ids ) ) );

			if ( empty( $ids ) )
				return;

			$out = '';

			foreach ( $ids as $imageId ) {
				$fullImage = wp_get_attachment_image_src( $imageId, wm_option( 'general-lightbox-img' ) );

				if ( '1' == $link )
					$out .= '<a href="' . $fullImage[0] . '">';
				elseif( $link )
					$out .= '<a href="' . esc_url( $link ) . '">';

				$out .= wp_get_attachment_image( $imageId, $size );
				$out .= ( $link ) ? ( '</a>' ) : ( '' );
			}

			if ( $out )
				wp_enqueue_script( 'bxslider' );

			//output
			return ( $out ) ? ( '<div class="simple-slider" data-time="' . absint( $time ) . '">' . $out . '</div>' ) : ( '' );
		}
	} // /wm_shortcode_simple_slideshow
	add_shortcode( 'simple_slideshow', 'wm_shortcode_simple_slideshow' );





/*
*****************************************************
*      SOCIAL ICONS
*****************************************************
*/
	/**
	* [social url="#" icon="" title="" size="" rel="" /]
	*
	* Social icons
	*
	* @param icon  [PREDEFINED TEXT]
	* @param rel   [TEXT]
	* @param size  [s/m/l/xl/NONE]
	* @param title [TEXT]
	* @param url   [URL]
	*/
	if ( ! function_exists( 'wm_shortcode_social' ) ) {
		function wm_shortcode_social( $atts, $content = null ) {
			global $socialIconsArray;

			extract( shortcode_atts( array(
				'icon'  => '',
				'rel'   => '',
				'size'  => 'm',
				'title' => '',
				'url'   => '#',
				), $atts)
				);

			if ( ! $icon || ! in_array( strtolower( trim( $icon ) ), array_map( 'strtolower', $socialIconsArray ) ) ) //case insensitive check
				return;

			//validation
			$icon = strtolower( trim( str_replace( '+', 'plus', trim( $icon ) ) ) );
			$size = ( trim( $size ) && in_array( trim( $size ), array( 's', 'm', 'l', 'xl' ) ) ) ? ( trim( $size ) ) : ( 'm' );
			$url  = ( 'Skype' != $icon ) ? ( esc_url( $url ) ) : ( $url );
			$rel  = ( $rel ) ? ( ' rel="' . $rel . '"' ) : ( '' );

			$title = ( trim( $title ) ) ? ( ' title="' . esc_attr( trim( $title ) ) . '"' ) : ( '' );

			//output
			return '<a href="' . $url . '"' . $title . $rel . ' class="social-icon wmicon-' . $icon . ' size-' . $size . '" target="_blank"><span class="invisible">' . esc_attr( trim( $title ) ) . '</span></a>';
		}
	} // /wm_shortcode_social
	add_shortcode( 'social', 'wm_shortcode_social' );





/*
*****************************************************
*      SPLIT
*****************************************************
*/
	/**
	* [section class="" style=""][/section]
	*
	* Home page template split
	*
	* @param class [PREDEFINED TEXT]
	* @param style [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_section' ) ) {
		function wm_shortcode_section( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'class' => '',
				'style' => '',
				), $atts)
				);

			$firstClass = ( trim( $class ) ) ? ( explode( ' ', trim( $class ) ) ) : ( '' );
			$id         = ( isset( $firstClass[0] ) && $firstClass[0] && 'alt' != $firstClass[0] ) ? ( ' id="section-' . esc_attr( sanitize_title( $firstClass[0] ) ) . '"' ) : ( '' );
			$style      = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			return "\r\n" . '<section class="wrap-section ' . esc_attr( trim( $class ) ) . '"' . $id . $style . '><div class="wrap-inner"><div class="twelve pane">' . do_shortcode( $content ) . '</div></div></section>' . "\r\n";
		}
	} // /wm_shortcode_section
	add_shortcode( 'section', 'wm_shortcode_section' );





/*
*****************************************************
*      TABLE
*****************************************************
*/
	/**
	* [table class="css-class" cols="" data="" separator="" heading_col=""]content[/table]
	*
	* Table
	*
	* @param class       [TEXT]
	* @param cols        [TEXT (heading cells separated by separator)]
	* @param data        [TEXT (table cells separated by separator)]
	* @param heading_col [# (styles the # cell in the row as heading)]
	* @param separator   [TEXT (separator character)]
	*/
	if ( ! function_exists( 'wm_shortcode_table' ) ) {
		function wm_shortcode_table( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'class'       => '',
				'cols'        => '',
				'data'        => '',
				'heading_col' => 0,
				'separator'   => ';',
				), $atts)
				);

			$class = ( trim( $class ) ) ? ( ' class="' . esc_attr( $class ) . '"' ) : ( '' );
			$data  = trim( $data );

			//output
			if ( $cols && $data ) {

				$cols       = explode( $separator, $cols );
				$data       = explode( $separator, $data );
				$colsNumber = count( $cols );

				$heading_col = ( $heading_col ) ? ( absint( $heading_col ) ) : ( -1 );
				$heading_col = ( -1 < $heading_col && $colsNumber <= $heading_col ) ? ( 0 ) : ( $heading_col );

				$out  = '<table' . $class . '>';

				if ( ! empty( $cols ) ) {
					$outCol = '';
					$i      = 0;

					foreach ( $cols as $col ) {
						if ( $col )
							$outCol .= '<th class="table-column-' . ++$i . '">' . $col . '</th>';
					}

					$out .= ( $outCol ) ? ( '<thead><tr class="table-row-0">' . $outCol . '</tr></thead>' ) : ( '' );
				}

				if ( ! empty( $data ) ) {
					$out .= '<tbody>';

					$i = $j = 0;
					$class = ' alt';
					foreach ( $data as $cell ) {
						$i++;

						$cellNumber = $i % $colsNumber;

						if ( 1 === $i % $colsNumber ) {
							if ( ' alt' === $class )
								$class = '';
							else
								$class = ' alt';
							$out .= '<tr class="table-row-' . ++$j . $class . '">';
						}

						if ( 0 === $i % $colsNumber )
							$cellNumber = $colsNumber;

						if ( -1 < $heading_col && ( $heading_col === $i % $colsNumber ) )
							$out .= '<th class="table-column-' . $cellNumber . ' text-left">' . $cell . '</th>';
						else
							$out .= '<td class="table-column-' . $cellNumber . '">' . $cell . '</td>';

						if ( 0 === $i % $colsNumber )
							$out .= '</tr>';
					}

					$out .= '</tbody>';
				}

				$out .= '</table>';

			} else {

				$out = '<table' . $class . '>' . do_shortcode( $content ) . '</table>';

			}

			return $out;
		}
	} // /wm_shortcode_table
	add_shortcode( 'table', 'wm_shortcode_table' );



	/**
	* [trow]content[/trow]
	*
	* Table row
	*/
	if ( ! function_exists( 'wm_shortcode_table_row' ) ) {
		function wm_shortcode_table_row( $atts, $content = null ) {
			//output
			return '<tr>' . do_shortcode( $content ) . '</tr>';
		}
	} // /wm_shortcode_table_row
	add_shortcode( 'trow', 'wm_shortcode_table_row' );



	/**
	* [trow_alt]content[/trow_alt]
	*
	* Table row altered
	*/
	if ( ! function_exists( 'wm_shortcode_table_row_alt' ) ) {
		function wm_shortcode_table_row_alt( $atts, $content = null ) {
			//output
			return '<tr class="alt">' . do_shortcode( $content ) . '</tr>';
		}
	} // /wm_shortcode_table_row_alt
	add_shortcode( 'trow_alt', 'wm_shortcode_table_row_alt' );



	/**
	* [tcell]content[/tcell]
	*
	* Table cell
	*/
	if ( ! function_exists( 'wm_shortcode_table_cell' ) ) {
		function wm_shortcode_table_cell( $atts, $content = null ) {
			//output
			return '<td>' . do_shortcode( $content ) . '</td>';
		}
	} // /wm_shortcode_table_cell
	add_shortcode( 'tcell', 'wm_shortcode_table_cell' );



	/**
	* [tcell_heading]content[/tcell_heading]
	*
	* Table heading cell
	*/
	if ( ! function_exists( 'wm_shortcode_table_cell_heading' ) ) {
		function wm_shortcode_table_cell_heading( $atts, $content = null ) {
			//output
			return '<th>' . do_shortcode( $content ) . '</th>';
		}
	} // /wm_shortcode_table_cell_heading
	add_shortcode( 'tcell_heading', 'wm_shortcode_table_cell_heading' );





/*
*****************************************************
*      TABS
*****************************************************
*/
	/**
	* [tabs type="fullwidth"]content[/tabs]
	*
	* Tabs wrapper
	*
	* @param type [vertical/fullwidth/vertical tour/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_tabs' ) ) {
		function wm_shortcode_tabs( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'type' => ''
				), $atts)
				);
			$types = array( 'vertical', 'vertical tour', 'fullwidth' );

			$type = ( in_array( trim( $type ), $types ) ) ? ( ' ' . trim( $type ) ) : ( ' normal' );

			//output
			$out = '<div class="tabs-wrapper apply-top-margin' . $type . '"><ul>' . do_shortcode( $content ) . '</ul></div>';
			return $out;
		}
	} // /wm_shortcode_tabs
	add_shortcode( 'tabs', 'wm_shortcode_tabs' );



	/**
	* [tab title="Tab title" icon=""]content[/tab]
	*
	* Tab item/content
	*
	* @param icon  [TEXT, required at least one of parameters]
	* @param title [TEXT, required at least one of parameters]
	*/
	if ( ! function_exists( 'wm_shortcode_tab' ) ) {
		function wm_shortcode_tab( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'icon'  => '',
				'title' => '',
				), $atts)
				);

			//validation
			$icon  = ( trim( $icon ) ) ? ( '<i class="' . esc_attr( trim( $icon ) ) . '"></i>' ) : ( '' );
			$title = ( $icon ) ? ( ' ' . $title ) : ( $title );
			$title = $icon . $title;
			if ( ! trim( $title ) )
				return;

			$title = strip_tags( trim( $title ), '<img><strong><span><small><em><b><i>' );

			//output
			$out = '<li><h3 class="tab-heading">' . $title . '</h3>' . do_shortcode( $content ) . '</li>';
			return $out;
		}
	} // /wm_shortcode_tab
	add_shortcode( 'tab', 'wm_shortcode_tab' );





/*
*****************************************************
*      TEXT
*****************************************************
*/
	/**
	* [big_text]Text[/big_text]
	*
	* Big text
	*
	* @param style [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_big_text' ) ) {
		function wm_shortcode_big_text( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'style' => '',
				), $atts)
				);

			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			return do_shortcode( '<span class="size-big"' . $style . '>' . $content . '</span>' );
		}
	} // /wm_shortcode_big_text
	add_shortcode( 'big_text', 'wm_shortcode_big_text' );



	/**
	* [separator_heading size="2" type="" align="center" id=""]Text[/separator_heading]
	*
	* Heading separator
	*
	* @param align [left, center, right]
	* @param id [TEXT]
	* @param size [#: 1-6]
	* @param type [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_separator_heading' ) ) {
		function wm_shortcode_separator_heading( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'align' => '',
				'id'    => '',
				'size'  => 2,
				'type'  => 'uniform',
				), $atts)
				);

			//validation
			$aligns = array( 'center', 'right' );

			$align = ( in_array( trim( $align ), $aligns ) ) ? ( ' text-' . trim( $align ) ) : ( '' );
			$id    = ( trim( $id ) ) ? ( ' id="' . sanitize_title( $id ) .'"' ) : ( '' );
			$size  = ( 1 <= absint( $size ) && 6 >= absint( $size ) ) ? ( absint( $size ) ) : ( '2' );
			$type  = ( 'uniform' == trim( $type ) ) ? ( ' apply-top-margin style-uniform' ) : ( ' style-' . trim( $type ) );

			//output
			return '<h' . $size . $id . ' class="separator-heading' . esc_attr( $type ) . esc_attr( $align ) . '"><span class="text-holder">' . do_shortcode( strip_tags( trim( $content ), '<img><strong><span><small><em><b><i>' ) ) . '</span></h' . $size . '>';
		}
	} // /wm_shortcode_separator_heading
	add_shortcode( 'separator_heading', 'wm_shortcode_separator_heading' );



	/**
	* [huge_text]Text[/huge_text]
	*
	* Huge text
	*
	* @param style [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_huge_text' ) ) {
		function wm_shortcode_huge_text( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'style' => '',
				), $atts)
				);

			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			return do_shortcode( '<span class="size-huge"' . $style . '>' . $content . '</span>' );
		}
	} // /wm_shortcode_huge_text
	add_shortcode( 'huge_text', 'wm_shortcode_huge_text' );



	/**
	* [small_text]Text[/small_text]
	*
	* Small text
	*
	* @param style [TEXT]
	*/
	if ( ! function_exists( 'wm_shortcode_small_text' ) ) {
		function wm_shortcode_small_text( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'style' => '',
				), $atts)
				);

			$style = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

			//output
			return do_shortcode( '<small' . $style . '>' . $content . '</small>' );
		}
	} // /wm_shortcode_small_text
	add_shortcode( 'small_text', 'wm_shortcode_small_text' );



	/**
	* [uppercase]Text[/uppercase]
	*
	* Uppercase
	*/
	if ( ! function_exists( 'wm_shortcode_uppercase' ) ) {
		function wm_shortcode_uppercase( $atts, $content = null ) {
			return do_shortcode( '<span class="uppercase">' . $content . '</span>' );
		}
	} // /wm_shortcode_uppercase
	add_shortcode( 'uppercase', 'wm_shortcode_uppercase' );





/*
*****************************************************
*      TOGGLES
*****************************************************
*/
	/**
	* [toggle title="Toggle title" open="1"]content[/toggle]
	*
	* @param open  [BOOLEAN/NONE]
	* @param title [TEXT, required]
	*/
	if ( ! function_exists( 'wm_shortcode_toggle' ) ) {
		function wm_shortcode_toggle( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'open'  => false,
				'title' => '',
				), $atts)
				);

			//validation
			if ( '' == $title )
				return;

			$title = strip_tags( trim( $title ), '<img><strong><span><small><em><b><i>' );
			$open  = ( $open ) ? ( ' active' ) : ( '' );

			//output
			return '<div class="toggle-wrapper apply-top-margin' . $open . '"><h3 class="toggle-heading">' . $title . '</h3>' . wpautop( do_shortcode( $content ) ) . '</div>';
		}
	} // /wm_shortcode_toggle
	add_shortcode( 'toggle', 'wm_shortcode_toggle' );





/*
*****************************************************
*      VIDEO
*****************************************************
*/
	/**
	* [video url="http://videoUrl" /]
	*
	* Video (makes native [embed] responsive and extends in with Screenr support)
	*
	* @param url [URL (video URL address)]
	*
	* @return [embed] video + Screenr video
	*/
	if ( ! function_exists( 'wm_shortcode_video' ) ) {
		function wm_shortcode_video( $atts, $content = null ) {
			global $is_IE;

			extract( shortcode_atts( array(
				'url' => '',
				), $atts)
				);

			$videoURL = $out = '';
			$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );

			$embedPlayerURL = array(
					'screenr' => $protocol . '://www.screenr.com/embed/',
				);

			//validation
			$url = esc_url( $url );
			$url = str_replace( 'https://', 'http://', $url );

			if ( false !== stripos( $url, 'screenr.com' ) ) {
			//Screenr
			//http://www.screenr.com/ScrID
				$url = str_replace( array( 'http://www.screenr.com/', 'http://screenr.com/' ), $embedPlayerURL['screenr'], $url );

				if ( $is_IE )
					$iFrameAtts = ' frameborder="0" scrolling="no" marginheight="0" marginwidth="0"';
				else
					$iFrameAtts = '';

				$out = '<div class="video-container"><iframe src="' . esc_url( $url ) . '"' . $iFrameAtts . '></iframe></div>';
			} elseif ( $url ) {
			//all other embeds
				$out = '<div class="video-container">' . wp_oembed_get( esc_url( $url ) ) . '</div>';
			}

			//output
			if ( ! $out )
				$out = do_shortcode( '[box color="red" icon="warning"]' . __( 'Please check the video URL', 'lespaul_domain' ) . '[/box]' );

			return $out;
		}
	} // /wm_shortcode_video
	add_shortcode( 'video', 'wm_shortcode_video' );





/*
*****************************************************
*      WIDGETS
*****************************************************
*/
	/**
	* [widgets area="default" style="" /]
	*
	* @param area   [widget area ID]
	* @param layout [vertical/horizontal/sidebar-left/sidebar-right/NONE]
	*/
	if ( ! function_exists( 'wm_shortcode_widget_area' ) ) {
		function wm_shortcode_widget_area( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'area'   => '',
				'layout' => 'horizontal',
				), $atts )
				);

			$areas   = array_flip( wm_widget_areas() );
			$layouts = array(
				'horizontal'    => 'columns',
				'vertical'      => 'vertical',
				'sidebar-left'  => 'sidebar sidebar-left',
				'sidebar-right' => 'sidebar sidebar-right'
				);

			//validation
			$area            = ( in_array( trim( $area ), $areas ) && trim( $area ) ) ? ( trim( $area ) ) : ( null );
			$class           = ( in_array( trim( $layout ), array_flip( $layouts ) ) ) ? ( $layouts[trim( $layout )] ) : ( 'columns' );
			$restrictedCount = ( 'horizontal' != $class ) ? ( null ) : ( 5 );

			//wm_sidebar($defaultSidebar, $class, $restrictCount, $print)
			if ( $area )
				return wm_sidebar( $area, $class, $restrictedCount, false );
		}
	} // /wm_shortcode_widget_area
	add_shortcode( 'widgets', 'wm_shortcode_widget_area' );

?>