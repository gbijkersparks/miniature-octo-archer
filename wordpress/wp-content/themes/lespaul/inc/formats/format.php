<?php
if ( has_post_thumbnail() ) {
	global $blogLayout;

	$mediaClasses = '';
	if ( in_array( $blogLayout, array( ' media-left', ' media-right', ' zigzag' ) ) ) {
		$imageSize = ( wm_option( 'general-post-image-ratio-alt' ) ) ? ( 'mobile-' . wm_option( 'general-post-image-ratio-alt' ) ) : ( 'mobile-ratio-169' );
		$mediaClasses = ' frame';
	} else {
		$imageSize = ( wm_option( 'general-post-image-ratio' ) ) ? ( wm_option( 'general-post-image-ratio' ) ) : ( 'ratio-169' );
	}

	if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
		echo '<div class="post-media' . $mediaClasses . '">' . wm_thumb( array( 'size' => 'content-width' ) ) . '</div>' . "\r\n\r\n";
	elseif ( ! is_single() )
		echo '<div class="post-media' . $mediaClasses . '">' . wm_thumb( array( 'size' => $imageSize ) ) . '</div>' . "\r\n\r\n";
}
?>
<div <?php post_class( 'article-content' ); ?>>
	<?php
	if ( ! is_single() )
		wm_heading( 'list' );
	?>

	<?php
	if ( is_single() ) {
		wm_meta();

		if ( has_excerpt() && ! post_password_required() )
			echo '<div class="article-excerpt">' . apply_filters( 'wm_default_content_filters', get_the_excerpt() ) . '</div>';

		the_content();

		wm_end_post();
	} else {
		echo wm_content_or_excerpt( $post );
	}
	?>
</div>

<?php
if ( ! is_single() )
	wm_meta();
else
	wm_meta( array( 'tags' ), 'meta-bottom' );
?>