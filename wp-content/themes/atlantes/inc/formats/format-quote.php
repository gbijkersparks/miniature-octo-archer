<div <?php post_class( 'article-content' ); ?>>
	<?php
	$content = get_the_content();

	//remove <blockquote> tags
	$content = preg_replace( '/<(\/?)blockquote(.*?)>/', '', $content );

	//split where <cite> tag begins
	$content = explode( '<cite', $content );

	echo '<blockquote>' . apply_filters( 'wm_default_content_filters', $content[0] ) . '</blockquote>';
	if ( isset( $content[1] ) && $content[1] )
		echo '<cite' . $content[1];
	?>
</div>

<?php
wm_meta();

if ( is_single() )
	wm_meta( array( 'tags' ), 'meta-bottom' );
?>