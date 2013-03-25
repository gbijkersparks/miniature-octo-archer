<?php wm_after_main_content(); ?>

<!-- /content --></div>


<?php
//widget area variables
$aboveFooter = 'above-footer-widgets';
$footerRow   = 'footer-widgets';

if ( is_page_template( 'page-template/landing.php' ) ) {
	$aboveFooter = wm_meta_option( 'landing-above-footer-widgets' );
	$footerRow   = wm_meta_option( 'landing-footer-widgets' );
}
if ( is_page_template( 'page-template/construction.php' ) )
	$aboveFooter = $footerRow = null;
if ( is_404() && wm_option( 'p404-no-above-footer-widgets' ) )
	$aboveFooter = null;

//WooCommerce pages
	if ( class_exists( 'Woocommerce' ) && is_woocommerce() )
		$aboveFooter = null;

if ( $aboveFooter && is_active_sidebar( $aboveFooter ) && ! wm_meta_option( 'no-above-footer-widgets' ) ) {
	echo '<section id="above-footer" class="wrap clearfix above-footer-widgets-wrap' . wm_element_width( 'abovefooter' ) . '"><div class="wrap-inner">';
	wm_sidebar( $aboveFooter, 'widgets columns twelve pane', 5 ); //no restriction
	echo '</div></section>';
}

wm_before_footer();
?>

<footer id="footer" class="wrap clearfix footer<?php echo wm_element_width( 'footer' ); ?>">
<!-- FOOTER -->
	<?php
	if ( $footerRow && is_active_sidebar( $footerRow ) ) {
		echo '<section class="footer-widgets-wrap first"><div class="wrap-inner">';
		wm_sidebar( $footerRow, 'widgets columns twelve pane', 5 ); //restricted to 5 widgets
		echo '</div></section>';
	}
	?>

	<section class="bottom-wrap clearfix"><div class="wrap-inner">
		<div class="twelve pane">
			<?php
			if ( is_page_template( 'page-template/landing.php' ) )
				$menuLocationName = 'menu-landing-page-' . get_the_ID();
			else
				$menuLocationName = 'footer-menu';

			if ( ! is_page_template( 'page-template/construction.php' ) )
				wp_nav_menu( array(
						'theme_location'  => $menuLocationName,
						'menu'            => null,
						'container'       => null,
						'container_class' => null,
						'container_id'    => null,
						'menu_class'      => 'menu-footer',
						'menu_id'         => null,
						'echo'            => true,
						'fallback_cb'     => null,
						'before'          => null,
						'after'           => null,
						'link_before'     => null,
						'link_after'      => null,
						'items_wrap'      => '<div class="%2$s"><ul>%3$s</ul></div>',
						'depth'           => 1,
						'walker'          => ( has_nav_menu( $menuLocationName ) ) ? ( new wm_widget_walker() ) : ( null )
					) );

			$class = ( is_page_template( 'page-template/construction.php' ) ) ? ( 'text-center clearfix' ) : ( 'clearfix' );

			wm_credits( $class );
			?>
		</div>
	</div></section> <!-- /bottom-wrap -->
<!-- /footer --></footer>

<!-- wp_footer() -->
<?php wp_footer(); //WordPress footer hook ?>
</body>

<!-- <?php echo wm_static_option( 'static-webdesigner' ); ?> -->

</html>