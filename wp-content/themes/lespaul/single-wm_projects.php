<?php
get_header();

$sidebarLayout   = ( wm_meta_option( 'layout' ) ) ? ( wm_meta_option( 'layout' ) ) : ( 'none' );
$overrideSidebar = ( wm_meta_option( 'sidebar' ) && -1 != wm_meta_option( 'sidebar' ) ) ? ( wm_meta_option( 'sidebar' ) ) : ( WM_SIDEBAR_FALLBACK );

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

	<?php //wm_start_main_content(); ?>

	<?php
	if ( 'plain' === wm_meta_option( 'project-single-layout' ) )
		get_template_part( 'inc/loop/loop', 'project-post' );
	else
		get_template_part( 'inc/loop/loop', 'project' );
	?>

	<?php
	//next/previous project links
		$out = '';
		$out .= ( be_get_previous_post( true, '', 'project-category' ) ) ? ( '<a href="' . get_permalink( be_get_previous_post( true, '', 'project-category' )->ID ) . '" title="' . sprintf( __( 'Projeto Anterior (%s)', 'lespaul_domain' ), esc_attr( strip_tags( get_the_title( be_get_previous_post( true, '', 'project-category' )->ID ) ) ) ) . '" class="prev">' . trim( get_the_title( be_get_previous_post( true, '', 'project-category' )->ID ) ) . '</a>' ) : ( null );
		$out .= ( be_get_next_post( true, '', 'project-category' ) ) ? ( '<a href="' . get_permalink( be_get_next_post( true, '', 'project-category' )->ID ) . '" title="' . sprintf( __( 'Próximo Projeto (%s)', 'lespaul_domain' ), esc_attr( strip_tags( get_the_title( be_get_next_post( true, '', 'project-category' )->ID ) ) ) ) . '" class="next">' . trim( get_the_title( be_get_next_post( true, '', 'project-category' )->ID ) ) . '</a>' ) : ( null );
		if ( $out )
			echo '<footer class="meta-project">' . $out . '</footer>';

	//Related projects
		if ( ! wm_option( 'contents-no-related-projects' ) && ! wm_meta_option( 'project-no-related' ) ) {
			$columns = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 4 ) : ( 3 );
			$title   = ( wm_option( 'contents-related-projects-title' ) ) ? ( strip_tags( wm_option( 'contents-related-projects-title' ) ) ) : ( __( 'Related projects', 'lespaul_domain' ) );
			echo do_shortcode( '[projects related="' . $title . '" columns="' . $columns . '" count="' . $columns . '" order="random" thumb="1" /]' );
		}
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