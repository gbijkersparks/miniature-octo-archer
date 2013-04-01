<?php
global $blogLayout;

$mediaClasses = ( in_array( $blogLayout, array( ' media-left', ' media-right', ' zigzag' ) ) ) ? ( ' frame' ) : ( '' );
?>
<div class="post-media<?php echo $mediaClasses; ?>">
	<?php
	if ( is_single() ) {
		$imageSize = ( wm_option( 'general-post-image-ratio' ) ) ? ( wm_option( 'general-post-image-ratio' ) ) : ( 'ratio-169' );
		if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
			echo wm_thumb( array( 'size' => 'content-width' ) );
		elseif ( ! is_single() )
			echo wm_thumb( array( 'size' => $imageSize ) );
	}

	$mediaURL = '';
	$content  = get_the_content();

	//search for the first URL in content
	preg_match( '/http(.*)/', strip_tags( $content ), $matches );
	if ( isset( $matches[0] ) )
		$mediaURL = trim( $matches[0] );

	//preparing content output:
	if ( ! is_single() )
		$content = wm_content_or_excerpt( $post );

	//remove <a> tag containing URL
	$content = preg_replace( '/<a(.*?)>http(.*?)<\/a>/', '', $content );
	//remove any audio URL left in content
	if ( $mediaURL )
		$content = str_replace( array( $mediaURL, $mediaURL . ' ', ' ' . $mediaURL ), '', $content );

	//outputting audio
	if ( $mediaURL )
		echo '<div class="audio-container">' . wp_oembed_get( esc_url( $mediaURL ) ) . '</div>';
	else
		echo do_shortcode( '[box color="red" icon="warning"]' . __( 'Please set the SoundCloud audio URL address', 'atlantes_domain' ) . '[/box]' );
	?>
</div>

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

		echo apply_filters( 'the_content', $content );

		wm_end_post();
	} else {
		echo $content; //filters already applied in wm_content_or_excerpt()
	}
	?>
</div>

<?php
if ( ! is_single() )
	wm_meta();
else
	wm_meta( array( 'tags' ), 'meta-bottom' );
?>