<?php
if ( wm_option( 'general-gzip' ) )
	ob_start( 'ob_gzhandler' ); //Enable GZIP

global $is_opera, $is_IE, $content_width;

$opera      = ( $is_opera ) ? ( ' browser-opera' ) : ( '' );
$protocol   = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
$blogLayout = ''; //global for archives and single posts
$postId     = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
$isTopBar   = is_active_sidebar( 'top-bar-widgets' ) && ! ( ! is_archive() && ! is_search() && wm_meta_option( 'no-top-bar', $postId ) ) && ! is_page_template( 'page-template/landing.php' ) && ! is_page_template( 'page-template/construction.php' );
?><!doctype html>

<!--[if lte IE 7]> <html class="ie ie7 lie9 lie8 lie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lie9 lie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>     <html class="ie ie9 lie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js<?php echo $opera; ?>" <?php language_attributes(); ?>><!--<![endif]-->

<head>
<!-- (c) Copyright <?php bloginfo( 'name' ); ?> -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- website title -->
<title><?php wp_title( '', true ); ?></title>

<!-- website info -->
<meta name="author" content="<?php if ( ! wm_option( 'general-website-author' ) ) echo 'WebMan - www.webmandesign.eu'; else echo wm_option( 'general-website-author' ); ?>" />

<?php if ( 'r940' === wm_option( 'general-width' ) || 'r1160' === wm_option( 'general-width' ) ) : ?>
<!-- mobile viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php
endif;

if ( $is_IE ) : ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<!--[if lt IE 9]>
<script src="<?php echo $protocol; ?>://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script>window.html5 || document.write('<script src="<?php echo WM_ASSETS_THEME; ?>js/html5.js"><\/script>')</script>
<script src="<?php echo $protocol; ?>://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<?php endif; ?>
<!-- profile and pingback -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- css stylesheets -->
<?php
if ( wm_option( 'design-font-custom' ) )
	echo wm_option( 'design-font-custom' ) . "\r\n";
?>
<link rel="stylesheet" href="<?php echo WM_ASSETS_THEME; ?>css/style.css.php<?php echo '?ver=' . WM_SCRIPTS_VERSION; ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/print.css<?php echo '?ver=' . WM_SCRIPTS_VERSION; ?>" type="text/css" media="print" />

<?php wm_favicon(); ?>
<!-- wp_head() -->
<?php wp_head(); ?>
</head>



<body id="top" <?php body_class(); ?>>
<?php
//Background image fit browser window width
if (
		( isset( $post ) || is_home() ) &&
		! is_search() && ! is_archive() &&
		wm_css_background_meta( 'background-' ) &&
		wm_meta_option( 'background-bg-img-fit-window', $postId )
	) {
	$imageURL      = wm_meta_option( 'background-bg-img-url', $postId );
	$imageURL      = ( ! is_array( $imageURL ) ) ? ( esc_url( $imageURL ) ) : ( esc_url( $imageURL['url'] ) );
	$imagePosition = ( 'fixed' === wm_meta_option( 'background-bg-img-attachment', $postId ) ) ? ( 'fixed' ) : ( 'absolute' );
	echo '<img src="' . $imageURL . '" alt="" style="position: ' . $imagePosition . '; width: 100%; left: 0; top: 0; z-index: -1;" />';
}

//TOP BAR
if ( $isTopBar ) {
	$topbarClasses = '';
	if ( wm_option( 'header-top-bar-fixed' ) )
		$topbarClasses = ' fixed';

	echo "\r\n\r\n" . '<div id="top-bar" class="clearfix top-bar' . $topbarClasses . '"><div class="wrap' . wm_element_width( 'toppanel' ) . '"><div class="wrap-inner"><div class="twelve pane clearfix">' . "\r\n" . '<!-- TOP BAR -->' . "\r\n" . '<a class="invisible" href="#nav-main">' . __( 'Go to main navigation', 'lespaul_domain' ) . '</a>' . "\r\n";

	wm_sidebar( 'top-bar-widgets', 'widgets', 2 ); //restricted to 2 widgets

	echo '<!-- /top-bar --></div></div></div></div>' . "\r\n\r\n\r\n";
}



//header classes
$headerClasses  = '';
$headerClasses .= ( wm_css_background( 'design-header-' ) ) ? ( ' set-bg' ) : ( '' );
$headerClasses .= wm_option( 'header-navigation-position' );
?>

<header id="header" class="clearfix header<?php echo $headerClasses; ?>"><div class="wrap<?php wm_element_width( 'header', true ); ?>"><?php //Header has to be done this way for option of fixed header ?>
<?php
if ( ! is_page_template( 'page-template/construction.php' ) && ' nav-top' === wm_option( 'header-navigation-position' ) )
	//display only when top navigation header layout used and not Under construction template
	get_template_part( 'nav' );
?>

<!-- HEADER -->
<div class="wrap-inner">
	<div class="twelve pane clearfix">

	<?php wm_logo(); ?>

	<?php
	if (
			! in_array( wm_option( 'header-navigation-position' ), array( ' nav-right', ' nav-bottom layout-centered' ) ) ||
			is_page_template( 'page-template/construction.php' ) ||
			( is_page_template( 'page-template/landing.php' ) && ! has_nav_menu( 'menu-landing-page-' . get_the_ID() ) )
		) {

		//Header right area (display only when rich (normal) header layout used)
		$headerText = wm_option( 'header-right' );
		$headerText = ( ' ' == $headerText ) ? ( '' ) : ( $headerText );

		if ( is_page_template( 'page-template/landing.php' ) )
			$headerText = wm_meta_option( 'landing-header-right' );
		if ( is_page_template( 'page-template/construction.php' ) )
			$headerText = wm_meta_option( 'construction-header-right' );

		$replaceArray = array(
			'(r)'    => '&reg;',
			'(R)'    => '&reg;',

			'(tm)'   => '&trade;',
			'(TM)'   => '&trade;',

			'YEAR'   => date( 'Y' ),
			'SEARCH' => get_search_form( false )
		);
		$headerText = strtr( $headerText, $replaceArray );

		if ( $headerText )
			echo '<div class="header-right"><a class="invisible" href="#nav-main">' . __( 'Go to main navigation', 'lespaul_domain' ) . '</a><div class="header-right-content">' . apply_filters( 'wm_default_content_filters', $headerText ) . '</div></div>';

	} else {

		if ( ' nav-bottom layout-centered' !== wm_option( 'header-navigation-position' ) )
			get_template_part( 'nav' );

	}
	?>

	</div>
</div> <!-- /wrap-inner -->

<?php
if ( ! is_page_template( 'page-template/construction.php' ) && in_array( wm_option( 'header-navigation-position' ), array( ' nav-bottom', ' nav-bottom layout-centered' ) ) )
	//display only when bottom navigation header layout used and not Under construction template
	get_template_part( 'nav' );
?>
</div><!-- /header --></header>


<?php wm_after_header(); ?>

<div id="content" class="wrap clearfix content<?php echo wm_element_width( 'content' ); ?>">
<!-- CONTENT -->

<?php wm_before_main_content(); ?>
