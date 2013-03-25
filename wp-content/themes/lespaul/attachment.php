<?php
get_header();

$sidebarLayout = ( wm_option( 'contents-sidebar-position' ) ) ? ( esc_attr( wm_option( 'contents-sidebar-position' ) ) ) : ( WM_SIDEBAR_DEFAULT_POSITION );

if ( is_active_sidebar( WM_SIDEBAR_FALLBACK ) ) {
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

	<?php get_template_part( 'inc/loop/loop', 'attachment' ); ?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes[0];

	wm_sidebar( 'default', $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>