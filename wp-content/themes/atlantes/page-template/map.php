<?php
/*
Template Name: Map
*/

get_header();
?>
<div class="wrap-inner">

<?php
//check whether current user can display the page
$allowed = ( wm_option( 'access-client-area' ) ) ? ( wm_restriction_page() ) : ( true );
if ( $allowed ) {
	$sidebarLayoutDefault = ( wm_option( 'contents-sidebar-position' ) ) ? ( esc_attr( wm_option( 'contents-sidebar-position' ) ) ) : ( WM_SIDEBAR_DEFAULT_POSITION );
	$sidebarLayout        = ( wm_meta_option( 'layout' ) ) ? ( wm_meta_option( 'layout' ) ) : ( $sidebarLayoutDefault );
	$overrideSidebar      = ( wm_meta_option( 'sidebar' ) && -1 != wm_meta_option( 'sidebar' ) ) ? ( wm_meta_option( 'sidebar' ) ) : ( WM_SIDEBAR_FALLBACK );

	if ( is_active_sidebar( $overrideSidebar ) && 'none' != $sidebarLayout ) {
		$sidebarPanes = ( wm_option( 'contents-sidebar-width' ) ) ? ( esc_attr( wm_option( 'contents-sidebar-width' ) ) ) : ( WM_SIDEBAR_WIDTH );
		$sidebarPanes = ( 2 == count( explode( ';', $sidebarPanes ) ) ) ? ( explode( ';', $sidebarPanes ) ) : ( explode( ';', WM_SIDEBAR_WIDTH ) );

		if ( 'left' == $sidebarLayout )
			$sidebarPanes[1] .= ' sidebar-left';
	} else {
		$sidebarPanes = array( '', ' twelve pane' );
	}
?>

<article class="main<?php echo $sidebarPanes[1]; ?>">

	<?php wm_start_main_content(); ?>

	<?php get_template_part( 'inc/loop/loop', 'singular' ); ?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes[0];

	wm_sidebar( $overrideSidebar, $class );
}
?>

<?php
} else {
	echo do_shortcode( WM_MSG_ACCESS_DENIED );
	wm_sidebar( 'access-denied', 'widgets columns twelve pane', 5 );
} // /check whether current user can display the page
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>