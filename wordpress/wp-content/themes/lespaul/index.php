<?php
get_header();

if ( is_active_sidebar( WM_SIDEBAR_FALLBACK ) ) {
	$sidebarPanes = ( wm_option( 'contents-sidebar-width' ) ) ? ( esc_attr( wm_option( 'contents-sidebar-width' ) ) ) : ( WM_SIDEBAR_WIDTH );
	$sidebarPanes = ( 2 == count( explode( ';', $sidebarPanes ) ) ) ? ( explode( ';', $sidebarPanes ) ) : ( explode( ';', WM_SIDEBAR_WIDTH ) );
} else {
	$sidebarPanes = array( '', ' twelve pane' );
}

if ( is_archive() && wm_option( 'blog-archive-no-sidebar' ) )
	$sidebarPanes[1] = ' twelve pane';
?>
<div class="wrap-inner">

<section class="main<?php echo $sidebarPanes[1]; ?>">

	<?php
	wm_start_main_content();

	$catDesc = category_description();
	if ( ! empty( $catDesc ) )
		echo '<div class="cat-desc">' . apply_filters( 'the_content', category_description() ) . '</div>';
	?>

	<?php get_template_part( 'inc/loop/loop', 'index' ); ?>

</section> <!-- /main -->

<?php
if ( ' twelve pane' !== $sidebarPanes[1] ) {
	$class = 'sidebar clearfix sidebar-right' . $sidebarPanes[0];
	wm_sidebar( WM_SIDEBAR_FALLBACK, $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>