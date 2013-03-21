<?php if ( have_posts() ) : the_post();

$projectLayout = array();

//Portfolio description
	$content    = get_the_content();
	$excerpt    = ( has_excerpt() ) ? ( get_the_excerpt() ) : ( '' );
	$allContent = $excerpt . $content;

	if ( false !== stripos( $allContent, '[project_attributes' ) )
		$projectLayout['excerpt'] = apply_filters( 'wm_default_content_filters', $excerpt );
	else
		$projectLayout['excerpt'] = '[project_attributes title="" /] ' . apply_filters( 'wm_default_content_filters', $excerpt );

	$content = ( $content ) ? ( '<div class="project-content clearfix">' . apply_filters( 'the_content', get_the_content() ) . '</div>' ) : ( '' );
	$projectLayout['content'] = $content;



//Portfolio preview image/video
	$out              = '';
	$projectTypes     = array( 'static-project', 'slider-project', 'video-project', 'audio-project' );
	$basicProjectType = explode( '[', wm_meta_option( 'project-type' ) );
	$basicProjectType = ( ! empty( $basicProjectType ) && isset( $basicProjectType[0] ) && in_array( $basicProjectType[0], $projectTypes ) ) ? ( $basicProjectType[0] ) : ( 'static-project' );

	if ( 'static-project' === $basicProjectType ) {
	//image

		$imageArray = wm_meta_option( 'project-image' );

		if ( isset( $imageArray['url'] ) && isset( $imageArray['id'] ) ) {
			$imageSize  = ( false == strpos( wm_meta_option( 'project-single-layout' ), 'col-12' ) ) ? ( 'content-width' ) : ( 'mobile' );
			$imageLarge = wp_get_attachment_image_src( $imageArray['id'], wm_option( 'general-lightbox-img' ) );
			$imageSrc   = wp_get_attachment_image_src( $imageArray['id'], $imageSize );

			$attachment = get_post( $imageArray['id'] );
			$imageAlt   = get_post_meta( $imageArray['id'], '_wp_attachment_image_alt', true );
			$imageTitle = '';
			if ( is_object( $attachment ) && ! empty( $attachment ) ) {
				$imageTitle  = $attachment->post_title;
				$imageTitle .= ( $attachment->post_excerpt ) ? ( ' - ' . $attachment->post_excerpt ) : ( '' );
			}

			$out .= '<a href="' . $imageLarge[0] . '" data-modal class="project-preview" title="' . esc_attr( $imageTitle ) . '">';
			$out .= '<img src="' . $imageSrc[0] . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';
			$out .= '</a>';
		} else {
			$out .= '[box color="red" icon="warning"]' . __( 'Please set "Project main image" option', 'lespaul_domain' ) . '[/box]';
		}

	} elseif ( 'slider-project' === $basicProjectType ) {
	//slider

		$imageSize = ( false == strpos( wm_meta_option( 'project-single-layout' ), 'col-12' ) ) ? ( 'content-width' ) : ( 'mobile' );
		$slides    = wm_get_post_images( get_the_ID(), $imageSize, 20 );

		if ( ! empty( $slides ) ) {
			$duration  = ' data-time="' . absint( wm_meta_option( 'project-slider-duration' ) * 1000 ) . '"';

			//Images
			foreach ( $slides as $slide ) {
				if ( isset( $slide['id'] ) && get_post_thumbnail_id( get_the_ID() ) != $slide['id'] && isset( $slide['img'] ) && $slide['img'] ) {
					$out .= '<li>';

					$imageAlt   = ( isset( $slide['alt'] ) ) ? ( $slide['alt'] ) : ( '' );
					$imageTitle = ( isset( $slide['title'] ) ) ? ( $slide['title'] ) : ( '' );
					$imageLarge = wp_get_attachment_image_src( absint( $slide['id'] ), wm_option( 'general-lightbox-img' ) );

					$out .= '<a href="' . $imageLarge[0] . '" data-modal class="project-preview" title="' . esc_attr( $imageTitle ) . '">';
					$out .= '<img src="' . esc_url( $slide['img'] ) . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';
					$out .= '</a>';

					$out .= '</li>';
				}
			}

			$out = ( $out ) ? ( '<div id="project-slider" class="project-slider"><ul' . $duration . '>' . $out . '</ul></div> <!-- /project-slider -->' ) : ( '' );

			wp_enqueue_script( 'bxslider' );
		} else {
			$out .= '[box color="red" icon="warning"]' . __( 'Please upload project images to create a gallery', 'lespaul_domain' ) . '[/box]';
		}

	} elseif ( 'video-project' === $basicProjectType ) {
	//video

		$videoURL = wm_meta_option( 'project-video' );

		if ( $videoURL )
			$out .= '[video url="' . esc_url( $videoURL ) . '" /]';
		else
			$out .= '[box color="red" icon="warning"]' . __( 'Please set "Video URL" option', 'lespaul_domain' ) . '[/box]';

	} elseif ( 'audio-project' === $basicProjectType ) {
	//audio

		$audioURL = wm_meta_option( 'project-audio' );

		//Post featured image
		if ( has_post_thumbnail() ) {
			$imageSize = ( false == strpos( wm_meta_option( 'project-single-layout' ), 'col-12' ) ) ? ( 'content-width' ) : ( 'mobile' );
			$out .= preg_replace( '/(width|height)=\"\d*\"\s/', "", get_the_post_thumbnail( get_the_ID(), $imageSize ) );
		}

		if ( $audioURL )
			$out .= strip_tags( wp_oembed_get( esc_url( $audioURL ) ), '<iframe>' );
		else
			$out .= '[box color="red" icon="warning"]' . __( 'Please set "Audio URL" option', 'lespaul_domain' ) . '[/box]';

	}

	$projectLayout['media'] = $out;



//Output
$layout = ( wm_meta_option( 'project-single-layout' ) ) ? ( explode( ',', wm_meta_option( 'project-single-layout' ) ) ) : ( array( 'media', ' col-34', ' col-14 last' ) );
if ( 3 != count( $layout ) )
	$layout = array( 'media', ' col-34', ' col-14 last' );

if ( 3 === count( $layout ) ) {
	$out = ( 'excerpt' == $layout[0] ) ? ( array( 'excerpt', 'media' ) ) : ( array( 'media', 'excerpt' ) );
	echo do_shortcode( '<div class="column' . $layout[1] . '">' . $projectLayout[$out[0]] . '</div><div class="column' . $layout[2] . '">' . $projectLayout[$out[1]] . '</div>' . $projectLayout['content'] );
}

?>

<?php wm_end_post(); ?>

<?php wp_reset_query(); endif; ?>

<?php comments_template( null, true ); ?>