<?php
if ( wm_option( 'cp-staff-rich' ) )
	$redirectToHome = array( 'wm_logos', 'wm_modules', 'wm_faq', 'wm_price' );
else
	$redirectToHome = array( 'wm_logos', 'wm_modules', 'wm_faq', 'wm_price', 'wm_staff' );

if ( in_array( get_post_type( $post->ID ), $redirectToHome ) ) {
	wp_redirect( home_url(), 301 );
	exit;
}

get_header();

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
<div class="wrap-inner">

<article class="main<?php echo $sidebarPanes[1]; ?>">

	<?php wm_start_main_content(); ?>

	<?php
	if ( 'wm_staff' == get_post_type( $post->ID ) )
		get_template_part( 'inc/loop/loop', 'staff' );
	else
		get_template_part( 'inc/loop/loop', 'singular' );
	?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes[0];

	wm_sidebar( $overrideSidebar, $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>