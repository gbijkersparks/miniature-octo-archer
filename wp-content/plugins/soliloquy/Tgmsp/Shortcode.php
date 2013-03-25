<?php
/**
 * Shortcode class for Soliloquy.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy
 * @author	Thomas Griffin
 */
class Tgmsp_Shortcode {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		self::$instance = $this;
	
		add_shortcode( 'soliloquy', array( $this, 'shortcode' ) );
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'tgmsp_caption_output', 'do_shortcode' );
	
	}
	
	/**
	 * Outputs slider data in a shortcode called 'soliloquy'.
	 *
	 * @since 1.0.0
	 *
	 * @global array $soliloquy_data An array of data for the current Soliloquy ID
	 * @global int $soliloquy_count Incremental variable for each Soliloquy on current page
	 * @param array $atts Array of shortcode attributes
	 * @return string $slider Concatenated string of slider data
	 */
	public function shortcode( $atts ) {

		/** Create global variables to store all soliloquy ID's and meta on the current page */
		$soliloquy_data 	= array();
		$soliloquy_count 	= 0;
		global $soliloquy_data, $soliloquy_count;

		/** Extract shortcode atts */
		extract( shortcode_atts( array(
			'id' => 0
		), $atts ) );

		/** Return if no slider ID has been entered or if it is not valid */
		if ( ! $id || empty( $id ) ) {
			printf( '<p>%s</p>', Tgmsp_Strings::get_instance()->strings['no_id'] );
			return;
		}

		/** Validate based on type of ID submitted */
		if ( is_numeric( $id ) ) {
			$validate = get_post( $id, OBJECT );
			if ( ! $validate || isset( $validate->post_type ) && 'soliloquy' !== $validate->post_type ) {
				printf( '<p>%s</p>', Tgmsp_Strings::get_instance()->strings['invalid_id'] );
				return;
			}
		} else {
			$validate = get_page_by_path( $id, OBJECT, 'soliloquy' );
			if ( ! $validate ) {
				printf( '<p>%s</p>', Tgmsp_Strings::get_instance()->strings['invalid_slug'] );
				return;
			}
		}
		
		/** Now that we have gotten to this point, let's make sure that $id in an integer if the user entered a slug */
		if ( ! is_numeric( $id ) ) {
			$path 	= get_page_by_path( $id, OBJECT, 'soliloquy' );
			$id 	= absint( $path->ID );
		}

		/** Ok, we have a valid slider ID - store all data in one variable and get started */
		$soliloquy_data[absint( $soliloquy_count )]['id'] 		= $id;
		$soliloquy_data[absint( $soliloquy_count )]['meta'] 	= get_post_meta( $id, '_soliloquy_settings', true );
		$slider 												= '';
		$images 												= $this->get_images( $id, $soliloquy_data[absint( $soliloquy_count )]['meta'] );
		$i 														= 1;
		$preloader 												= false;

		/** Only proceed if we have images to output */
		if ( $images ) {
			// If this is a feed view, customize the output and return early.
			if ( is_feed() )
				return $this->do_feed_output( $images );
				
			// If the user wants a preloader image, store the aspect ratio for dynamic height calculation.
			if ( isset( $soliloquy_data[absint( $soliloquy_count )]['meta']['preloader'] ) && $soliloquy_data[absint( $soliloquy_count )]['meta']['preloader'] ) {
				$preloader = true;
				$soliloquy_data[absint( $soliloquy_count )]['ratio'] = ( $images[0]['width'] / $images[0]['height'] );
				add_action( 'tgmsp_callback_start_' . $id, array( $this, 'preloader' ) );
				add_filter( 'tgmsp_slider_classes', array( $this, 'preloader_class' ) );
			}
				
			// If the users wants randomized images, go ahead and do that now.
			if ( isset( $soliloquy_data[absint( $soliloquy_count )]['meta']['random'] ) && $soliloquy_data[absint( $soliloquy_count )]['meta']['random'] )
				$images = $this->shuffle( $images );
			
			/** Make sure jQuery is loaded and load script and slider */
			wp_enqueue_script( 'soliloquy-script' );
			wp_enqueue_style( 'soliloquy-style' );
			
			/** If the mousewheel option is selected, load the Mousewheel jQuery plugin */
			if ( isset( $soliloquy_data[absint( $soliloquy_count )]['meta']['mousewheel'] ) && $soliloquy_data[absint( $soliloquy_count )]['meta']['mousewheel'] )
				wp_enqueue_script( 'soliloquy-mousewheel' );
				
			/** Add action to initialize the slider */
			add_action( 'wp_footer', array( $this, 'slider_script' ), 99 );
			
			/** Allow devs to circumvent the entire slider if necessary - beware, this filter is powerful - use with caution */
			$pre = apply_filters( 'tgmsp_pre_load_slider', false, $id, $images, $soliloquy_data, absint( $soliloquy_count ), $slider ); 
			if ( $pre )
				return $pre;

			do_action( 'tgmsp_before_slider_output', $id, $images, $soliloquy_data, absint( $soliloquy_count ), $slider );

			/** If a custom size is chosen, all image sizes will be cropped the same, so grab width/height from first image */
			$width 	= $soliloquy_data[absint( $soliloquy_count )]['meta']['width'] ? $soliloquy_data[absint( $soliloquy_count )]['meta']['width'] : $images[0]['width'];
			$width	= apply_filters( 'tgmsp_slider_width', $width, $id );
			$width	= preg_match( '|%$|', trim( $width ) ) ? trim( $width ) . ';' : absint( $width ) . 'px;';
			$height = $soliloquy_data[absint( $soliloquy_count )]['meta']['height'] ? $soliloquy_data[absint( $soliloquy_count )]['meta']['height'] : $images[0]['height'];
			$height	= apply_filters( 'tgmsp_slider_height', $height, $id );
			$height	= preg_match( '|%$|', trim( $height ) ) ? trim( $height ) . ';' : absint( $height ) . 'px;';

			/** Output the slider info */
			$slider = apply_filters( 'tgmsp_before_slider', $slider, $id, $images, $soliloquy_data, absint( $soliloquy_count ) );
			$slider .= '<div id="soliloquy-container-' . esc_attr( $id ) . '" ' . $this->get_custom_slider_classes() . ' style="' . apply_filters( 'tgmsp_slider_width_output', 'max-width: ' . $width, $width, $id ) . ' ' . apply_filters( 'tgmsp_slider_height_output', 'max-height: ' . $height, $height, $id ) . ' ' . apply_filters( 'tgmsp_slider_container_style', '', $id ) . '">';
				$slider .= '<div id="soliloquy-' . esc_attr( $id ) . '" class="soliloquy">';
					$slider .= '<ul id="soliloquy-list-' . esc_attr( $id ) . '" class="soliloquy-slides">';
						foreach ( $images as $image ) {
							$alt 			= empty( $image['alt'] ) ? apply_filters( 'tgmsp_no_alt', '', $id, $image ) : $image['alt'];
							$title 			= empty( $image['title'] ) ? apply_filters( 'tgmsp_no_title', '', $id, $image ) : $image['title'];
							$link_title 	= empty( $image['linktitle'] ) ? apply_filters( 'tgmsp_no_link_title', '', $id, $image ) : $image['linktitle'];
							$link_target 	= empty( $image['linktab'] ) ? apply_filters( 'tgmsp_no_link_target', '', $id, $image ) : 'target="_blank"';

							$slide = '<li id="soliloquy-' . esc_attr( $id ) . '-item-' . $i . '" class="soliloquy-item" style="' . apply_filters( 'tgmsp_slider_item_style', 'display: none;', $id, $image, $i ) . '" ' . apply_filters( 'tgmsp_slider_item_attr', '', $id, $image, $i ) . '>';
								/** If we have a video URL, let's parse and output it */
								if ( ( isset( $image['linktype'] ) && 'video' == $image['linktype'] ) && ( isset( $image['video'] ) && ! empty( $image['video'] ) ) && $soliloquy_data[absint( $soliloquy_count )]['meta']['video'] ) {
										/** We have a video link to parse, so let's output it */
										$source = '';
										
										if ( preg_match( '#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $image['video'], $y_matches ) )
											$source = 'youtube';
									
										if ( preg_match( '#(?:https?:\/\/(?:[\w]+\.)*vimeo\.com(?:[\/\w]*\/videos?)?\/([0-9]+)[^\s]*)#i', $image['video'], $v_matches ) )
											$source = 'vimeo';
									
										/** If there was an error validating the URL, output a notice */
										if ( empty( $source ) ) {
											$slide .= '<p class="soliloquy-video-error">' . Tgmsp_Strings::get_instance()->strings['video_link_error'] . '</p>';
										} else {
											/** Enqueue the FitVids script since it will be needed regardless of video source */
											wp_enqueue_script( 'soliloquy-fitvids' );
										
											/** Generate the video embed code based on the type of video */
											switch ( $source ) {
												case 'youtube' :
													$soliloquy_data[absint( $soliloquy_count )]['youtube'] = true; // Set the YouTube video flag to true
													$vid 					= $y_matches[0];
													$slide					.= $this->get_video_code( 'youtube', $vid, $id, $i, $width, $height );
													break;
												
												case 'vimeo' :
													wp_enqueue_script( 'soliloquy-vimeo' );
													$soliloquy_data[absint( $soliloquy_count )]['vimeo'] = true; // Set the Vimeo video flag to true
													$vid 					= $v_matches[1];
													$slide 					.= $this->get_video_code( 'vimeo', $vid, $id, $i, $width, $height );
													break;
											}
										
											/** Apply the caption as well, but hide it so a user could use it if they need */
											if ( ! empty( $image['caption'] ) )
												$slide .= apply_filters( 'tgmsp_caption_output', '<div class="soliloquy-caption"><div class="soliloquy-caption-inside" style="display: none;">' . $image['caption'] . '</div></div>', $id, $image );
										
											/** Now we need to initialize the video script for interactions between the slider and videos */
											add_action( 'wp_footer', array( $this, 'video_script' ), 100 );
											add_action( 'tgmsp_callback_before_' . absint( $id ), array( $this, 'pause_video' ) );
									}
								} else {									
									/** Output our normal data */
									if ( ! empty( $image['link'] ) ) 
										$slide .= apply_filters( 'tgmsp_link_output', '<a href="' . esc_url( $image['link'] ) . '" title="' . esc_attr( $link_title ) . '" ' . $link_target . '>', $id, $image, $link_title, $link_target );
										
									/** Use data attributes to fake loading of the image until its time to get to it */
									if ( 0 !== $soliloquy_data[absint( $soliloquy_count )]['meta']['number'] && ( $i - 1 ) == $soliloquy_data[absint( $soliloquy_count )]['meta']['number'] )
										$slide .= apply_filters( 'tgmsp_image_output', '<img class="soliloquy-item-image" src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" />', $id, $image, $alt, $title );
									else if ( 1 == $i && 0 == $soliloquy_data[absint( $soliloquy_count )]['meta']['number'] )
										$slide .= apply_filters( 'tgmsp_image_output', '<img class="soliloquy-item-image" src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" />', $id, $image, $alt, $title );
									else
										$slide .= apply_filters( 'tgmsp_image_output', '<img class="soliloquy-item-image" src="' . esc_url( plugins_url( 'css/images/holder.gif', dirname( __FILE__ ) ) ) . '" data-soliloquy-src="' . esc_url( $image['src'] ) . '" alt="' . esc_attr( $alt ) . '" title="' . esc_attr( $title ) . '" />', $id, $image, $alt, $title );
										
									if ( ! empty( $image['link'] ) )
										$slide .= '</a>';
									if ( ! empty( $image['caption'] ) )
										$slide .= apply_filters( 'tgmsp_caption_output', '<div class="soliloquy-caption"><div class="soliloquy-caption-inside">' . $image['caption'] . '</div></div>', $id, $image );
								}
							$slide .= '</li>';
							$slider .= apply_filters( 'tgmsp_individual_slide', $slide, $id, $image, $i );
							$i++;
						}
					$slider .= '</ul>';
					$slider = apply_filters( 'tgmsp_inside_slider', $slider, $id, $images, $soliloquy_data, absint( $soliloquy_count ) );
				$slider .= '</div>';
				$slider = apply_filters( 'tgmsp_inside_slider_container', $slider, $id, $images, $soliloquy_data, absint( $soliloquy_count ) );
			$slider .= '</div>';

			$slider = apply_filters( 'tgmsp_after_slider', $slider, $id, $images, $soliloquy_data, absint( $soliloquy_count ) );
			
			// If we are adding a preloading icon, do it now.
			if ( $preloader ) {
				$slider .= '<style type="text/css">.soliloquy-container.soliloquy-preloader{background: url("' . plugins_url( "css/images/preloader.gif", dirname( __FILE__ ) ) . '") no-repeat scroll 50% 50%;}@media only screen and (-webkit-min-device-pixel-ratio: 1.5),only screen and (-o-min-device-pixel-ratio: 3/2),only screen and (min--moz-device-pixel-ratio: 1.5),only screen and (min-device-pixel-ratio: 1.5){.soliloquy-container.soliloquy-preloader{background-image: url("' . plugins_url( "css/images/preloader@2x.gif", dirname( __FILE__ ) ) . '");background-size: 16px 16px;}}</style>';
			}
		}

		/** Increment the counter in case there are multiple slider instances on the same page */
		$soliloquy_count++;

		return apply_filters( 'tgmsp_slider_shortcode', $slider, $id, $images );

	}
	
	/**
	 * Helper function to generate the correct video embed code and necessary scripts
	 * to facilitate the interactions between the video and the slider.
	 *
	 * @since 1.0.0
	 *
	 * @param string $type The type of video (YouTube or Vimeo)
	 * @param string|int $video The unique video ID
	 * @param int $id The current slider ID
	 * @param int $i The current slide position
	 * @param int $width The width of the slider
	 * @param int $height The height of the slider
	 * @return string $slide Amended slide code with video code attached
	 */
	public function get_video_code( $type = '', $video, $id, $i, $width, $height ) {
	
		/** Generate code based on the type of video being viewed */
		switch ( $type ) {
			case 'youtube' :
				$query_args = apply_filters( 'tgmsp_youtube_query_args', array(
					'enablejsapi' 		=> '1',
					'version'			=> '3',
					'wmode'				=> 'transparent',
					'rel'				=> '0',
					'showinfo'			=> '0',
					'modestbranding'	=> '1'
				), $id, $i );
				$slide = '<div class="soliloquy-touch-left"></div><iframe id="soliloquy-video-' . $id . '-' . $i . '" src="' . add_query_arg( $query_args, 'http://www.youtube.com/embed/' . $video ) . '" width="' . absint( $width ) . '" height="' . absint( $height ) . '" frameborder="0" rel="youtube" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe><div class="soliloquy-touch-right"></div>';
				break;
			case 'vimeo' :
				$query_args = apply_filters( 'tgmsp_vimeo_query_args', array(
					'api' 		=> '1',
					'player_id'	=> 'soliloquy-video-' . $id . '-' . $i,
					'wmode'		=> 'transparent',
					'byline'	=> '0',
					'title'		=> '0',
					'portrait'	=> '0'
				), $id, $i );
				$slide = '<div class="soliloquy-touch-left"></div><iframe id="soliloquy-video-' . $id . '-' . $i . '" src="' . add_query_arg( $query_args, 'http://player.vimeo.com/video/' . $video ) . '" width="' . absint( $width ) . '" height="' . absint( $height ) . '" frameborder="0" rel="vimeo" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe><div class="soliloquy-touch-right"></div>';
				break;
		}
		
		/** Return the new slider code with all the necessary video components loaded */
		return $slide;
	
	}

	/**
	 * Instantiate the slider.
	 *
	 * @since 1.0.0
	 *
	 * @global array $soliloquy_data An array of data for the current Soliloquy ID
	 */
	public function slider_script() {

		global $soliloquy_data;

		/** Add support for multiple instances on the same page */
		$do_not_duplicate 	= array();
		$ie_hover			= true;

		/** Loop through each instance and output the data */
		foreach ( $soliloquy_data as $i => $slider ) {
			/** Only run if the slider ID hasn't been outputted yet */
			if ( ! in_array( $slider['id'], $do_not_duplicate ) ) {
				/** Store ID in variable */
				$do_not_duplicate[] = $slider['id'];

				/** Setup variables for output */
				$animation 	= isset( $slider['meta']['transition'] ) && 'fade' == $slider['meta']['transition'] ? 'fade' : 'slide';
				$transition = isset( $slider['meta']['transition'] ) && 'slide-vertical' == $slider['meta']['transition'] ? 'vertical' : 'horizontal';
				$slide 		= ( 'slide' == $animation ) ? 'direction:\'' . $transition . '\',' : '';
				$slideshow 	= isset( $slider['meta']['animate'] ) 		&& $slider['meta']['animate'] 		? 'true' : 'false';
				$navigation = isset( $slider['meta']['navigation'] ) 	&& $slider['meta']['navigation'] 	? 'true' : 'false';
				$control 	= isset( $slider['meta']['control'] ) 		&& $slider['meta']['control'] 		? 'true' : 'false';
				$keyboard 	= isset( $slider['meta']['keyboard'] ) 		&& $slider['meta']['keyboard'] 		? 'true' : 'false';
				$multi 		= isset( $slider['meta']['multi_key'] ) 	&& $slider['meta']['multi_key'] 	? 'true' : 'false';
				$mouse 		= isset( $slider['meta']['mousewheel'] ) 	&& $slider['meta']['mousewheel'] 	? 'true' : 'false';
				$pauseplay 	= isset( $slider['meta']['pauseplay'] ) 	&& $slider['meta']['pauseplay'] 	? 'true' : 'false';
				$random 	= 'false'; // Force this to false since we will randomize server-side.
				$loop 		= isset( $slider['meta']['loop'] ) 			&& $slider['meta']['loop'] 			? 'true' : 'false';
				$action 	= isset( $slider['meta']['action'] ) 		&& $slider['meta']['action'] 		? 'true' : 'false';
				$hover 		= isset( $slider['meta']['hover'] ) 		&& $slider['meta']['hover'] 		? 'true' : 'false';
				$video		= isset( $slider['meta']['video'] )			&& $slider['meta']['video']			? 'true' : 'false';
				$fitvids	= wp_script_is( 'soliloquy-fitvids', 'queue' ) ? 'fitVids().' : '';
				$css		= isset( $slider['meta']['css'] )			&& $slider['meta']['css']			? 'true' : 'false';
				$reverse	= isset( $slider['meta']['reverse'] )		&& $slider['meta']['reverse']		? 'true' : 'false';
				$smooth		= isset( $slider['meta']['smooth'] )		&& $slider['meta']['smooth']		? 'true' : 'false';
				$touch		= isset( $slider['meta']['touch'] )			&& $slider['meta']['touch']			? 'true' : 'false';
				$preload	= isset( $slider['meta']['preloader'] ) 	&& $slider['meta']['preloader'] 	? true : false;
				
				/** These actions need to be performed if certain settings are set to true */
				if ( empty( $fitvids ) )
					$video = 'false';
					
				if ( 'true' == $video )
					$css = 'false'; // Set to false regardless when an embedded video is present
				
				/** Provide a hook for users before the init script */
				do_action( 'tgmsp_before_slider_init', $slider );
				
				/** Prepare the preloading script */
				$script = 'var soliloquy_holder = jQuery(slider).find("img.soliloquy-item-image");';
				$script .= 'if(0 !== soliloquy_holder.length){';
					$script .= 'var soliloquy_images = ([]).concat(soliloquy_holder.splice(0,2), soliloquy_holder.splice(-2,2), jQuery.makeArray(soliloquy_holder));';
					$script .= 'jQuery.each(soliloquy_images, function(i,el){';
						$script .= 'if(typeof jQuery(this).attr("data-soliloquy-src") == "undefined" || false == jQuery(this).attr("data-soliloquy-src")) return;';
						$script .= '(new Image()).src = jQuery(this).attr("data-soliloquy-src");';
						$script .= 'jQuery(this).attr("src", jQuery(this).attr("data-soliloquy-src")).removeAttr("data-soliloquy-src");';
					$script .= '});';
				$script .= '}';
				
				// Prepare the preloader script if we are using it.
				$preload_script = false;
				if ( $preload )
					$preload_script = 'jQuery(document).ready(function($){$("#soliloquy-container-' . absint( $slider['id'] ) . '").css({"height":(Math.round($("#soliloquy-container-' . absint( $slider['id'] ) . '").width() / ' . $slider['ratio'] . '))});});';
				
				?>
				<script type="text/javascript"><?php if ( $preload_script ) echo $preload_script; ?>jQuery(window).load(function(){var $ = jQuery;$('<?php echo apply_filters( 'tgmsp_slider_selector', '#soliloquy-' . absint( $slider['id'] ), $slider['id'], $slider ); ?>').<?php echo $fitvids; ?>flexslider({animation:'<?php echo $animation; ?>',<?php echo $slide; ?>slideshow:<?php echo $slideshow; ?>,slideshowSpeed:<?php echo isset( $slider['meta']['speed'] ) ? absint( $slider['meta']['speed'] ) : '7000'; ?>,animationSpeed:<?php echo isset( $slider['meta']['duration'] ) ? absint( $slider['meta']['duration'] ) : '600'; ?>,directionNav:<?php echo $navigation; ?>,controlNav:<?php echo apply_filters( 'tgmsp_control_nav', $control, absint( $slider['id'] ) ); ?>,keyboard:<?php echo $keyboard; ?>,multipleKeyboard:<?php echo $multi; ?>,mousewheel:<?php echo $mouse; ?>,pausePlay:<?php echo $pauseplay; ?>,randomize:<?php echo $random; ?>,startAt:<?php echo isset( $slider['meta']['number'] ) ? absint( $slider['meta']['number'] ) : '0'; ?>,animationLoop:<?php echo $loop; ?>,pauseOnAction:<?php echo $action; ?>,pauseOnHover:<?php echo $hover; ?>,controlsContainer:'<?php echo apply_filters( 'tgmsp_slider_controls', '#soliloquy-container-' . absint( $slider['id'] ), $slider['id'] ); ?>',manualControls:'<?php echo apply_filters( 'tgmsp_manual_controls', '', $slider['id'] ); ?>',video:<?php echo $video; ?>,useCSS:<?php echo $css; ?>,reverse:<?php echo $reverse; ?>,smoothHeight:<?php echo $smooth; ?>,touch:<?php echo $touch; ?>,initDelay:<?php echo isset( $slider['meta']['delay'] ) ? absint( $slider['meta']['delay'] ) : '0'; ?>,namespace:'soliloquy-',selector:'.soliloquy-slides > li',<?php do_action( 'tgmsp_slider_script', $slider, absint( $slider['id'] ) ); ?>start:function(slider){<?php echo 'soliloquySlider' . absint( $slider['id'] ) . ' = slider;';echo apply_filters( 'tgmsp_slider_preload', $script, $slider['id'] ); do_action( 'tgmsp_callback_start', absint( $slider['id'] ) ); do_action( 'tgmsp_callback_start_' . absint( $slider['id'] ), absint( $slider['id'] ) ); ?>},before:function(slider){<?php do_action( 'tgmsp_callback_before', absint( $slider['id'] ) ); do_action( 'tgmsp_callback_before_' . absint( $slider['id'] ), absint( $slider['id'] ) ); ?>},after:function(slider){<?php do_action( 'tgmsp_callback_after', absint( $slider['id'] ) ); do_action( 'tgmsp_callback_after_' . absint( $slider['id'] ), absint( $slider['id'] ) ); ?>},end:function(slider){<?php do_action( 'tgmsp_callback_end', absint( $slider['id'] ) ); do_action( 'tgmsp_callback_end_' . absint( $slider['id'] ), absint( $slider['id'] ) ); ?>},added:function(slider){<?php do_action( 'tgmsp_callback_added', absint( $slider['id'] ) ); do_action( 'tgmsp_callback_added_' . absint( $slider['id'] ), absint( $slider['id'] ) ); ?>},removed:function(slider){<?php do_action( 'tgmsp_callback_removed', absint( $slider['id'] ) ); do_action( 'tgmsp_callback_removed_' . absint( $slider['id'] ), absint( $slider['id'] ) ); ?>}});});</script>
				<?php
				
				/** Provide a hook for users after the init script */
				do_action( 'tgmsp_after_slider_init', $slider );
				
				/** Force IE hover states on embedded videos */
				if ( $video && ! empty( $fitvids ) && $ie_hover ) {
					echo '<!--[if IE]>';
						echo '<script type="text/javascript">jQuery(document).ready(function($){$(".soliloquy-container").each(function(i, el){$(el).hover(function(){$(this).addClass("soliloquy-hover");},function(){$(this).removeClass("soliloquy-hover");});});});</script>';
					echo '<![endif]-->';
					$ie_hover = false; // Set flag to false
				}
			}
		}

	}
	
	/**
	 * Handles the pause/play interactions between the slider and YouTube/Vimeo videos.
	 *
	 * @since 1.0.0
	 *
	 * @global array $soliloquy_data An array of data for the current Soliloquy ID
	 */
	public function video_script() {

		global $soliloquy_data;

		/** Add support for multiple instances on the same page */
		$do_not_duplicate = array();

		/** Prepare flags so global vars and functions aren't duplicated */
		$global_vars 	= false; // Flag for global vars setup
		$youtube_vars 	= false; // Flag for YouTube vars setup
		$vimeo_vars 	= false; // Flag for Vimeo vars setup
		$youtube_init	= false; // Flag for YouTube init and event listener functions
		$vimeo_init		= false; // Flag for Vimeo init and event listener functions

		/** Loop through each instance and output the data */
		foreach ( $soliloquy_data as $i => $slider ) {
			/** Only run if the slider ID hasn't been outputted yet */
			if ( ! in_array( $slider['id'], $do_not_duplicate ) ) {
				/** Store ID in variable */
				$do_not_duplicate[] = $slider['id'];

				/** Store the entire script in a variable for easier outputting and instant minification */
				$script = '<script type="text/javascript">';
					if ( ! $global_vars ) {
						/** Declare vars needed in global scope */
						$script .= 'var soliloquy_video_data 	= {};'; // Object to store our video data
						$script .= 'var soliloquy_video_count 	= 0;'; 	// Incremental variable to hold number of video players on the page
						$global_vars = true;
					}

					/** Only load the following vars if the YouTube flag is set to true */
					if ( ! $youtube_vars ) {
						if ( isset( $slider['youtube'] ) && $slider['youtube'] ) {
							$script .= 'var soliloquy_youtube_holder = {};'; 	// Holds all YouTube player IDs
							$script .= 'var soliloquy_youtube_players = {};'; 	// Holds all the YouTube player objects on the page
							$youtube_vars = true;
						}
					}

					/** Only load the following vars if the Vimeo flag is set to true */
					if ( ! $vimeo_vars ) {
						if ( isset( $slider['vimeo'] ) && $slider['vimeo'] ) {
							$script .= 'var soliloquy_vimeo_holder = {};'; 	// Holds all Vimeo player IDs
							$script .= 'var soliloquy_vimeo_players = {};'; // Holds all the Vimeo player objects on the page
							$vimeo_vars = true;
						}
					}

					/** Store video player ID and type in our object */
					$script .= 'jQuery(document).ready(function($){';
						/** Loop through available slides and find all video instances */
						$script .= '$("#soliloquy-' . absint( $slider['id'] ) . ' .soliloquy-slides li:not(.clone)").find("iframe").each(function(i, el){';
							$script .= 'soliloquy_video_data[parseInt(soliloquy_video_count)] = {';
								$script .= 'type: $(this).attr("rel"),';
								$script .= 'id: $(this).attr("id")';
							$script .= '};';
							$script .= 'soliloquy_video_count += parseInt(1);';
						$script .= '});';

						/** Loop through the object and do our stuff */
						$script .= '$.each(soliloquy_video_data, function(i, el){';
							/** Only load if a YouTube video is present */
							if ( isset( $slider['youtube'] ) && $slider['youtube'] ) {
								$script .= 'if ( "youtube" == el.type ) {';
									$script .= 'if ( soliloquy_youtube_holder[el.id] )';
										$script .= 'return;';

									$script .= 'soliloquy_youtube_holder[el.id] = el.id;';
								$script .= '}';				
							}

							/** Only load if a Vimeo video is present */
							if ( isset( $slider['vimeo'] ) && $slider['vimeo'] ) {
								$script .= 'if ( "vimeo" == el.type ) {';
									$script .= 'if ( soliloquy_vimeo_holder[el.id] )';
										$script .= 'return;';

									$script .= 'soliloquy_vimeo_holder[el.id] = el.id;';
									$script .= 'soliloquyLoadVimeoVideo(el.id, $);';
								$script .= '}';
							}
						$script .= '});';
						
						if ( isset( $slider['youtube'] ) && $slider['youtube'] ) {
							/** Load the YouTube IFrame API asynchronously */
							$script .= 'var tag = document.createElement("script");';
      						$script .= 'tag.src = "http://www.youtube.com/player_api";';
      						$script .= 'tag.async = true;';
      						$script .= 'var firstScriptTag = document.getElementsByTagName("script")[0];';
      						$script .= 'firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);';
      					}
					$script .= '});';

					/** Only load if a YouTube video is present */
					if ( ! $youtube_init ) {
						if ( isset( $slider['youtube'] ) && $slider['youtube'] ) {
      						/** Now initialize the API and add event listeners */
      						$script .= 'function onYouTubePlayerAPIReady() {';
      							$script .= 'jQuery.each(soliloquy_youtube_holder, function(i, el){';
      								$script .= 'soliloquy_youtube_players[el] = new YT.Player(el, {';
										$script .= 'events: {';
											$script .= '"onStateChange": soliloquyCreateYTEvent(el)';
										$script .= '}';
									$script .= '});';
      							$script .= '});';
							$script .= '}';	

							$script .= 'function soliloquyCreateYTEvent(playerID) {';
								$script .= 'return function(event) {';
									/** If the video is being played or is buffering, pause the slider */
									$script .= 'if ( 1 == event.data || 3 == event.data ) ';
										if ( isset( $slider['meta']['action'] ) && $slider['meta']['action'] ) {
											$script .= 'if ( ! soliloquySlider' . absint( $slider['id'] ) . '.animating ) ';
												$script .= 'soliloquySlider' . absint( $slider['id'] ) . '.pause();';
										} else {
											$script .= 'soliloquySlider' . absint( $slider['id'] ) . '.pause();';
										}
								$script .= '}';
							$script .= '}';

							$youtube_init = true;
						}
					}

					/** Only load if a Vimeo video is present */
					if ( ! $vimeo_init ) {
						if ( isset( $slider['vimeo'] ) && $slider['vimeo'] ) {
							$script .= 'function soliloquyLoadVimeoVideo(playerID, $) {';
								$script .= '$.each(soliloquy_vimeo_holder, function(key, el){';
									/** Prevent duplicating of Vimeo player objects */
									$script .= ' if ( soliloquy_vimeo_players[el] )';
										$script .= 'return;';

      								/** Setup the Vimeo player object and add event listeners */
      								$script .= 'soliloquy_vimeo_players[el] = $f(el);';
									$script .= 'soliloquy_vimeo_players[el].addEvent("ready", soliloquyVimeoPausePlay);';
								$script .= '});';
							$script .= '}';

							$script .= 'function soliloquyVimeoPausePlay(playerID) {';
								$script .= 'soliloquy_vimeo_players[playerID].addEvent("play", function(data){';
									if ( isset( $slider['meta']['action'] ) && $slider['meta']['action'] ) {
										$script .= 'if ( ! soliloquySlider' . absint( $slider['id'] ) . '.animating ) ';
											$script .= 'soliloquySlider' . absint( $slider['id'] ) . '.pause();';
									} else {
										$script .= 'soliloquySlider' . absint( $slider['id'] ) . '.pause();';
									}
								$script .= '});';
							$script .= '}';

							$vimeo_init = true;
						}
					}
				$script .= '</script>';

				/** Output the script */
				echo $script;
			}
		}

	}

	/**
	 * Callback function to pause an embedded video when moving to another slide.
	 *
	 * @since 1.0.0
	 *
	 * @global array $soliloquy_data An array of data for the current Soliloquy ID
	 */
	public function pause_video() {

		/** Store output in a variable */
		$output = 'var pause_video = $(slider).find("li:not(.clone)");';
		$output .= '$(pause_video).find("iframe").each(function(i, el){';
			$output .= 'if ( "youtube" == $(this).attr("rel") ) {';
				$output .= 'var yt_player = soliloquy_youtube_players[$(this).attr("id")];';
				$output .= 'if ( typeof yt_player == "undefined" || false == yt_player ) {';
					$output .= 'return;'; // This is to prevent errors when the video hasn't yet initialized but the slider is already proceeding to it
				$output .= '} else {';
					$output .= 'if ( typeof yt_player.getPlayerState == "function" ){';
						$output .= 'if ( 1 == yt_player.getPlayerState() ) ';
							$output .= 'yt_player.pauseVideo();';
					$output .= '}';
				$output .= '}';
			$output .= '}';
			$output .= 'if ( "vimeo" == $(this).attr("rel") ) {';
				$output .= 'var vm_player = soliloquy_vimeo_players[$(this).attr("id")];';
				$output .= 'if ( typeof vm_player == "undefined" || false == vm_player ) {';
					$output .= 'return;';
				$output .= '} else {';
					$output .= 'if ( typeof vm_player.api == "function" )';
						$output .= 'vm_player.api("pause");';
				$output .= '}';
			$output .= '}';
		$output .= '});';

		/** Echo the output */
		echo $output;

	}

	/**
	 * Helper function to get image attachments for a particular slider.
	 *
	 * @since 1.0.0
	 *
	 * @param int $id The ID of the post for retrieving attachments
	 
	 * @return null|array Return early if no ID set, array of images on success
	 */
	public function get_images( $id, $meta = '' ) {

		/** Return early if no ID is set */
		if ( ! $id )
			return;

		/** Store images in an array and grab all attachments from the slider */
		$images = array();
		
		/** Get the slider size */
		if ( isset( $meta['custom'] ) && $meta['custom'] )
			$size = $meta['custom'];
		else
			$size = 'full';
				
		/** Prepare args for getting image attachments */
		$args = apply_filters( 'tgmsp_get_slider_images_args', array(
			'orderby' 			=> 'menu_order',
			'order' 			=> 'ASC',
			'post_type' 		=> 'attachment',
			'post_parent' 		=> $id,
			'post_mime_type' 	=> 'image',
			'post_status' 		=> null,
			'posts_per_page' 	=> -1
		), $id );

		/** Get all of the image attachments to the Soliloquy */
		$attachments = apply_filters( 'tgmsp_get_slider_images', get_posts( $args ), $args, $id );

		/** Loop through the attachments and store the data */
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				/** Get attachment metadata for each attachment */
				$image = apply_filters( 'tgmsp_get_image_data', wp_get_attachment_image_src( $attachment->ID, $size ), $id, $attachment, $size );

				/** Store data in an array to send back to the shortcode */
				if ( $image ) {
					$images[] = apply_filters( 'tgmsp_image_data', array(
						'id' 		=> $attachment->ID,
						'src' 		=> $image[0],
						'width' 	=> $image[1],
						'height' 	=> $image[2],
						'title'		=> isset( $attachment->post_title ) ? $attachment->post_title : '',
						'alt' 		=> get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
						'link' 		=> get_post_meta( $attachment->ID, '_soliloquy_image_link', true ),
						'linktype'	=> get_post_meta( $attachment->ID, '_soliloquy_image_link_type', true ),
						'linktitle' => get_post_meta( $attachment->ID, '_soliloquy_image_link_title', true ),
						'linktab' 	=> get_post_meta( $attachment->ID, '_soliloquy_image_link_tab', true ),
						'video'		=> get_post_meta( $attachment->ID, '_soliloquy_video_link', true ),
						'caption' 	=> isset( $attachment->post_excerpt ) ? $attachment->post_excerpt : ''
					), $attachment, $id );
				}
			}
		}

		/** Return array of images */
		return apply_filters( 'tgmsp_slider_images', $images, $meta, $attachments );

	}
	
	/**
	 * Getter method for retrieving custom slider classes.
	 *
	 * @since 1.0.0
	 *
	 * @global array $soliloquy_data Array of data for the current slider
	 * @global int $soliloquy_count The current Soliloquy instance on the page
	 */
	public function get_custom_slider_classes() {
	
		global $soliloquy_data, $soliloquy_count;
		$classes = array();
		
		/** Set the default soliloquy-container */
		$classes[] = 'soliloquy-container';
		
		/** Set a class for the type of transition being used */
		$classes[] = sanitize_html_class( 'soliloquy-' . strtolower( $soliloquy_data[absint( $soliloquy_count )]['meta']['transition'] ), '' );
		
		/** Now add a filter to addons can access and add custom classes */
		return 'class="' . implode( ' ', apply_filters( 'tgmsp_slider_classes', $classes, $soliloquy_data[absint( $soliloquy_count )]['id'] ) ) . '"';
	
	}
	
	/**
	 * Shuffle the associative array of images if the user has chosen to do it.
	 *
	 * @since 1.4.8.1
	 *
	 * @return array $random Shuffled array of images
	 */
	private function shuffle( $images ) {
		
		// Return early if the $images passed is not an array.
		if ( ! is_array( $images ) ) 
			return $images;

		$random = array();
		$keys 	= array_keys( $images );
		
		// Shuffle the keys and loop through them to create a new, randomized array of images.
		shuffle( $keys );  
		foreach ( $keys as $key ) 
			$random[$key] = $images[$key]; 

		// Return the randomized image array.
		return $random;
		
	}
	
	/**
	 * Removes the fixed height and preloader image once the slider has initialized.
	 *
	 * @since 1.4.9
	 */
	public function preloader( $id ) {
		
		echo 'jQuery("#soliloquy-container-' . absint( $id ) . '").css({ "background" : "transparent", "height" : "auto" });';
		
	}
	
	/**
	 * Adds the preloader class to the slider to signify use of a preloading image.
	 *
	 * @since 1.4.9
	 *
	 * @param array $classes Array of slider classes
	 * @return array $classes Amended array of slider classes
	 */
	public function preloader_class( $classes ) {
		
		$classes[] = 'soliloquy-preloader';
		return array_unique( $classes );
		
	}
	
	/**
	 * Outputs only the first image of the slider inside a regular <div> tag
	 * to avoid styling issues with feeds.
	 *
	 * @since 1.4.9
	 *
	 * @param array $images Current slider images
	 * @return string $slider Custom slider output for feeds
	 */
	private function do_feed_output( $images ) {
		
		$slider = '<div class="soliloquy-feed-output">';
			$slider .= '<img class="soliloquy-feed-image" src="' . esc_url( $images[0]['src'] ) . '" title="' . esc_attr( $images[0]['title'] ) . '" alt="' . esc_attr( $images[0]['alt'] ) . '" />';
		$slider .= '</div>';
		
		return apply_filters( 'tgmsp_slider_feed_output', $html, $images );
		
	}
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}
	
}