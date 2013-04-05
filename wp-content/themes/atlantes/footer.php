
<article class="content ">
	<div id="newsletter" class="wrap-inner clearfix">
		<?php echo do_shortcode( '[separator_heading]Cadastre-se em nossa Newsletter[/separator_heading]' ) ?>
		<?php insert_cform('Newsletter'); ?>
	</div>
</article>

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

if ( $aboveFooter && is_active_sidebar( $aboveFooter ) && ! wm_meta_option( 'no-above-footer-widgets' ) && is_front_page() ) {
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
	//echo do_shortcode( '[widgets area="wmcs-footer" /]' );
	?>
</footer>

<!-- wp_footer() -->
<?php wp_footer(); //WordPress footer hook ?>
</body>

<!-- <?php echo wm_static_option( 'static-webdesigner' ); ?> -->

</html>