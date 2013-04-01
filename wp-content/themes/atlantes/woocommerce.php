<?php get_header(); ?>
<div class="wrap-inner">

<?php
$sidebarLayout = ( wm_option( 'contents-sidebar-position' ) ) ? ( esc_attr( wm_option( 'contents-sidebar-position' ) ) ) : ( WM_SIDEBAR_DEFAULT_POSITION );

//which sidebar to use
if ( is_product() && is_active_sidebar( 'woocommerce-product' ) )
	$overrideSidebar = 'woocommerce-product';
elseif ( ! is_product() && is_active_sidebar( 'woocommerce' ) )
	$overrideSidebar = 'woocommerce';
else
	$overrideSidebar = ''; //be it fullwidth page!

if ( $overrideSidebar && is_active_sidebar( $overrideSidebar ) ) {
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

	<?php woocommerce_content(); ?>

</article> <!-- /main -->

<?php
if ( $overrideSidebar ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes[0];

	wm_sidebar( $overrideSidebar, $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>