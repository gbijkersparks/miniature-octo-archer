<?php
/*
*****************************************************
* WEBMAN WORDPRESS THEME FRAMEWORK
* Created by WebMan - Oliver Juhás
*
* WordPress menu extensions
*****************************************************
*/

//Enhancing main menus
class wm_main_walker extends Walker_Nav_Menu {

	function start_el( &$output, $element, $depth, $args ) {
		global $wp_query;
		$class_names = $isButton = $isIcon = '';

		$indent  = ( $depth ) ? ( str_repeat( "\t", $depth ) ) : ( '' );
		$classes = ( empty( $element->classes ) ) ? ( array() ) : ( (array) $element->classes );

		if ( 1 === $element->menu_order )
			$classes[] = 'first';

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $element ) );

		//stripos = Find the position of the first occurrence of a substring in a string. Faster.
		//stristr = Find the first occurrence of a string. Returns part of haystack string starting from and including the first occurrence of needle to the end of haystack.
		if ( false !== stripos( $class_names, 'button-' ) ) {
			$isButton = stristr( $class_names, 'button-' );
			$isButton = explode( ' ', $isButton );
			$isButton = str_replace( 'button-', '', $isButton[0] );
		}
		if ( false !== stripos( $class_names, 'icon-' ) ) {
			$isIcon = stristr( $class_names, 'icon-' );
			$isIcon = explode( ' ', $isIcon );
			$isIcon = sanitize_title( $isIcon[0] );
			$isIcon = '<i class="nav-icon ' . $isIcon . '"></i>';
		}

		$class_names = ' class="'. esc_attr( str_replace( 'icon-', 'iconnav-', $class_names ) ) . '"';

		//Link attributes
		$attributes = $attributeTitle = ( ! empty( $element->attr_title ) ) ? ( ' title="' . esc_attr( $element->attr_title ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $element->target ) ) ? ( ' target="' . esc_attr( $element->target ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $element->xfn ) ) ? ( ' rel="' . esc_attr( $element->xfn ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $element->url ) ) ? ( ' href="' . esc_attr( $element->url ) . '"' ) : ( '' );

		$classes = ( ! empty( $element->description ) ) ? ( 'has-description ' ) : ( '' );
		$classes .= ( $isButton ) ? ( 'btn color-' . esc_attr( $isButton ) ) : ( 'normal' );

		//Display desciption
		$mainItemStart = '<span>';
		$mainItemEnd   = '</span>';
		$desc          = ( ! empty( $element->description ) ) ? ( '<small>' . strip_tags( $element->description ) . '</small>' ) : ( '' );
		/*
		//description only on main menu items (not on submenus)
		if ( $depth != 0 )
			$desc = '';
		*/

		$outItem = $args->before;
		if ( ! empty( $element->url ) && 'http://' != $element->url && 'http://-' != $element->url && '-' != $element->url )
			$outItem .= '<a'. $attributes .' class="inner ' . esc_attr( $classes ) . '">' . $isIcon;
		else
			$outItem .= '<span class="inner ' . esc_attr( $classes ) . '"' . $attributeTitle . '>' . $isIcon;
		$outItem .= $args->link_before . $mainItemStart . apply_filters( 'the_title', do_shortcode( $element->title ), $element->ID ) . $mainItemEnd;
		$outItem .= $desc . $args->link_after;
		if ( ! empty( $element->url ) && 'http://' != $element->url && 'http://-' != $element->url && '-' != $element->url )
			$outItem .= '</a>';
		else
			$outItem .= '</span>';
		$outItem .= $args->after;

		if ( wm_option( 'access-client-area' ) ) {
			$pageId  = ( isset( $element->object_id ) && $element->object_id ) ? ( $element->object_id ) : ( 0 );
			$allowed = wm_restriction_page( $pageId );
		} else {
			$allowed = true;
		}

		if ( $allowed )
			$output .= $indent . '<li' . $class_names .' data-depth="' . $depth . '">' . apply_filters( 'walker_nav_menu_start_el', $outItem, $element, $depth, $args );
		else
			$output .= '<li class="hide">';
	} // /start_el

} // /wm_main_walker





//Enhancing widget menus
class wm_widget_walker extends Walker_Nav_Menu {

	function start_el( &$output, $element, $depth, $args ) {
		global $wp_query;
		$class_names = '';

		$indent  = ( $depth ) ? ( str_repeat( "\t", $depth ) ) : ( '' );
		$classes = ( empty( $element->classes ) ) ? ( array() ) : ( (array) $element->classes );

		$classes = implode( ' ', $classes );
		$classes = str_replace( array( 'alignleft', 'alignright' ), '', $classes );
		$classes = explode( ' ', $classes );

		if ( 1 === $element->menu_order )
			$classes[] = 'first';

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $element ) );

		$class_names = ' class="'. esc_attr( str_replace( 'icon-', 'iconnav-', $class_names ) ) . '"';

		//Link attributes
		$attributes  = ( ! empty( $element->attr_title ) ) ? ( ' title="' . esc_attr( $element->attr_title ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $element->target ) ) ? ( ' target="' . esc_attr( $element->target ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $element->xfn ) ) ? ( ' rel="' . esc_attr( $element->xfn ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $element->url ) ) ? ( ' href="' . esc_attr( $element->url ) . '"' ) : ( '' );

		//Display desciption
		$mainItemStart = '';
		$mainItemEnd   = '';

		$outItem = $args->before;
		if ( ! empty( $element->url ) && 'http://' != $element->url && 'http://-' != $element->url && '-' != $element->url )
			$outItem .= '<a'. $attributes .' class="inner">';
		else
			$outItem .= '<span class="inner ' . esc_attr( $class_names ) . '">';
		$outItem .= $args->link_before . $mainItemStart . apply_filters( 'the_title', do_shortcode( $element->title ), $element->ID ) . $mainItemEnd . $args->link_after;
		if ( ! empty( $element->url ) && 'http://' != $element->url && 'http://-' != $element->url && '-' != $element->url )
			$outItem .= '</a>';
		else
			$outItem .= '</span>';
		$outItem .= $args->after;

		if ( wm_option( 'access-client-area' ) ) {
			$pageId  = ( isset( $element->object_id ) && $element->object_id ) ? ( $element->object_id ) : ( 0 );
			$allowed = wm_restriction_page( $pageId );
		} else {
			$allowed = true;
		}

		if ( $allowed )
			$output .= $indent . '<li' . $class_names .'>' . apply_filters( 'walker_nav_menu_start_el', $outItem, $element, $depth, $args );
		else
			$output .= '<li class="hide">';
	} // /start_el

} // /wm_widget_walker

?>