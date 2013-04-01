<?php
global $blogLayout;

$mediaClasses = ( in_array( $blogLayout, array( ' media-left', ' media-right', ' zigzag' ) ) ) ? ( ' frame' ) : ( '' );
?>
<div class="post-media<?php echo $mediaClasses; ?>">
	<?php
	$mediaGallery = array( false, '' ); //first value determines whether gallery in use, second one if image IDs set
	$content      = get_the_content();

	//search for the first occurance of [gallery] shortcode
	preg_match( '/\[gallery(.*)\]/', strip_tags( $content ), $matches );
	if ( isset( $matches[1] ) )
		$mediaGallery = array( true, trim( $matches[1] ) ); //this gets the [gallery] shortcode parameters only
	//if "ids" set, get the image IDs into array
	if ( false !== strpos( $mediaGallery[1], 'ids="' ) ) {
		preg_match( '/ids="(.+?)"/', $mediaGallery[1], $galImages );
		$mediaGallery[1] = explode( ',', preg_replace( '/\s+/', '', str_replace( array( 'ids="', '"' ), '', $galImages[0] ) ) );
	}

	//get the image size
	if ( in_array( $blogLayout, array( ' media-left', ' media-right', ' zigzag' ) ) )
		$imageSize = ( wm_option( 'general-post-image-ratio-alt' ) ) ? ( 'mobile-' . wm_option( 'general-post-image-ratio-alt' ) ) : ( 'mobile-ratio-169' );
	else
		$imageSize = ( wm_option( 'general-post-image-ratio' ) ) ? ( wm_option( 'general-post-image-ratio' ) ) : ( 'ratio-169' );

	if ( $mediaGallery[0] && ! is_single() ) {
	//is gallery? -> display slideshow

		$images = array();

		if ( is_array( $mediaGallery[1] ) )
			$images = $mediaGallery[1];
		else
			$images = wm_get_post_images();

		$out = '';

		if ( ! empty( $images ) ) {
			foreach ( $images as $image ) {
				if ( is_array( $image ) )
					$image = $image['id'];

				$out .= '<a href="' . get_permalink() . '">';
				$out .= wp_get_attachment_image( $image, $imageSize );
				$out .= '</a>';
			}
		}

		if ( $out ) {
			wp_enqueue_script( 'bxslider' ); //check whether this could be just like this or it needs a shortcode?
			echo '<div class="simple-slider" data-time="4000">' . $out . '</div>';
		}

	} else {
	//no gallery? -> display featured image

		if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
			echo wm_thumb( array( 'size' => 'content-width' ) );
		elseif ( ! is_single() )
			echo wm_thumb( array( 'size' => $imageSize ) );

	}
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