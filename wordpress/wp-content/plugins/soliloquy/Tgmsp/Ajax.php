<?php
/**
 * Ajax class for Soliloquy.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy
 * @author	Thomas Griffin
 */
class Tgmsp_Ajax {

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
	
		add_action( 'wp_ajax_soliloquy_link_search', array( $this, 'link_search' ) );
		add_action( 'wp_ajax_soliloquy_refresh_images', array( $this, 'refresh_images' ) );
		add_action( 'wp_ajax_soliloquy_iframe_refresh_images', array ( $this, 'refresh_images' ) );
		add_action( 'wp_ajax_soliloquy_sort_images', array( $this, 'sort_images' ) );
		add_action( 'wp_ajax_soliloquy_remove_images', array( $this, 'remove_images' ) );
		add_action( 'wp_ajax_soliloquy_update_meta', array( $this, 'update_meta' ) );
	
	}
	
	/**
	 * Returns search results from the internal content linking feature.
	 *
	 * @since 1.0.0
	 */
	public function link_search() {

		/** Do a security check first */
		check_ajax_referer( 'soliloquy_linking', 'nonce' );

		$args = array();

		if ( isset( $_POST['search'] ) ) {
			$args['s'] = stripslashes( $_POST['search'] );
			$args['pagenum'] = ! empty( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
		}

		require( ABSPATH . WPINC . '/class-wp-editor.php' );
		$results['links'] = _WP_Editors::wp_link_query( $args );

		/** Do nothing if no search results have been found */
		if ( ! isset( $results ) )
			die;

		echo json_encode( $results );
		die;

	}

	/**
	 * Ajax callback to refresh attachment images for the current Soliloquy.
	 *
	 * @since 1.0.0
	 */
	public function refresh_images() {

		/** Do a security check first */
		check_ajax_referer( 'soliloquy_uploader', 'nonce' );

		/** Prepare our variables */
		$response['images'] = array(); // This will hold our images as an object titled 'images'
		$images 			= array();
		$html 				= ''; // This will hold the HTML for our metadata structure
		$args 				= array(
			'orderby' 			=> 'menu_order',
			'order' 			=> 'ASC',
			'post_type' 		=> 'attachment',
			'post_parent' 		=> $_POST['id'],
			'post_mime_type' 	=> 'image',
			'post_status' 		=> null,
			'posts_per_page' 	=> -1
		);

		/** Get all of the image attachments to the Soliloquy */
		$attachments = get_posts( $args );

		/** Loop through the attachments and store the data */
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				/** Get attachment metadata for each attachment */
				$thumb = wp_get_attachment_image_src( $attachment->ID, 'soliloquy-thumb' );

				/** Store data in an array to send back to the script as on object */
				$images[] = apply_filters( 'tgmsp_ajax_refresh_callback', array(
					'id' 		=> $attachment->ID,
					'src' 		=> $thumb[0],
					'width' 	=> $thumb[1],
					'height' 	=> $thumb[2],
					'title' 	=> $attachment->post_title,
					'alt' 		=> get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'linktype'	=> get_post_meta( $attachment->ID, '_soliloquy_image_link_type', true ),
					'link' 		=> get_post_meta( $attachment->ID, '_soliloquy_image_link', true ),
					'linktitle' => get_post_meta( $attachment->ID, '_soliloquy_image_link_title', true ),
					'linktab' 	=> get_post_meta( $attachment->ID, '_soliloquy_image_link_tab', true ),
					'linkcheck' => checked( get_post_meta( $attachment->ID, '_soliloquy_image_link_tab', true ), 1, false ),
					'videolink'	=> get_post_meta( $attachment->ID, '_soliloquy_video_link', true ),
					'v_width'	=> get_post_meta( $attachment->ID, '_soliloquy_video_width', true ),
					'v_height'	=> get_post_meta( $attachment->ID, '_soliloquy_video_height', true ),
					'caption' 	=> $attachment->post_excerpt
				), $attachment );
			}
		}
		
		/** Now let's loop through our images and build out the HTML structure */
		if ( $images ) {
			foreach ( $images as $image ) {
				/** Let's build out our HTML structure here for better performance and consistency */
				$html .= '<li id="' . $image['id'] . '" class="soliloquy-image attachment-' . $image['id'] . '">';
					$html .= '<img src="' . $image['src'] . '" width="' . $image['width'] . '" height="' . $image['height'] . '" />';
					$html .= '<a href="#" class="remove-image" title="' . Tgmsp_Strings::get_instance()->strings['remove_image'] . '"></a>';
					$html .= '<a href="#" class="modify-image" title="' . Tgmsp_Strings::get_instance()->strings['modify_image'] . '"></a>';
					$html .= '<div id="meta-' . $image['id'] . '" class="soliloquy-image-meta" style="display: none;">';
						$html .= '<div class="soliloquy-meta-wrap">';
							$html .= '<h2>' . Tgmsp_Strings::get_instance()->strings['update_meta'] . '</h2>';
							$html .= '<p>' . Tgmsp_Strings::get_instance()->strings['image_meta'] . '</p>';
							if ( array_key_exists( 'before_image_meta_table', $image ) )
								foreach ( (array) $image['before_image_meta_table'] as $data )
									$html .= $data;
							$html .= '<table id="soliloquy-meta-table-' . $image['id'] . '" class="form-table soliloquy-meta-table">';
								$html .= '<tbody>';
									if ( array_key_exists( 'before_image_title', $image ) )
										foreach ( (array) $image['before_image_title'] as $data )
											$html .= $data;
									$html .= '<tr id="soliloquy-title-box-' . $image['id'] . '" valign="middle">';
										$html .= '<th scope="row"><label for="soliloquy-title-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_title'] . '</label></th>';
										$html .= '<td>';
											$html .= '<input id="soliloquy-title-' . $image['id'] . '" class="soliloquy-title" type="text" size="75" name="_soliloquy_uploads[title]" value="' . $image['title'] . '" />';
										$html .= '</td>';
									$html .= '</tr>';
									if ( array_key_exists( 'before_image_alt', $image ) )
										foreach ( (array) $image['before_image_alt'] as $data )
											$html .= $data;
									$html .= '<tr id="soliloquy-alt-box-' . $image['id'] . '" valign="middle">';
										$html .= '<th scope="row"><label for="soliloquy-alt-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_alt'] . '</label></th>';
										$html .= '<td>';
											$html .= '<input id="soliloquy-alt-' . $image['id'] . '" class="soliloquy-alt" type="text" size="75" name="_soliloquy_uploads[alt]" value="' . $image['alt'] . '" />';
										$html .= '</td>';
									$html .= '</tr>';
									if ( array_key_exists( 'before_image_link', $image ) )
										foreach ( (array) $image['before_image_link'] as $data )
											$html .= $data;
									$html .= '<tr id="soliloquy-link-box-' . $image['id'] . '" valign="middle">';
										$html .= '<th scope="row"><label for="soliloquy-link-type-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_link'] . '</label></th>';
										$html .= '<td>';
											$types = Tgmsp_Admin::link_types();
											$html .= '<label for="soliloquy-link-type-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_link_type'] . '</label>';
											$html .= '<select id="soliloquy-link-type-' . $image['id'] . '" class="soliloquy-link-type" name="_soliloquy_uploads[link_type]">';
											foreach ( (array) $types as $type => $data )
												$html .= '<option value="' . esc_attr( $data['slug'] ) . '"' . selected( $data['slug'], get_post_meta( $image['id'], '_soliloquy_image_link_type', true ), false ) . '>' . esc_html( $data['name'] ) . '</option>';
											$html .= '</select>';
											$html .= '<div class="soliloquy-link-normal-wrap soliloquy-top">';
												$html .= '<label class="soliloquy-link-url" for="soliloquy-link-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_url'] . '</label>';
												$html .= '<input id="soliloquy-link-' . $image['id'] . '" class="soliloquy-link" type="text" size="70" name="_soliloquy_uploads[link]" value="' . $image['link'] . '" />';
												$html .= '<label class="soliloquy-link-title-label" for="soliloquy-link-title-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_url_title'] . '</label>';
												$html .= '<input id="soliloquy-link-title-' . $image['id'] . '" class="soliloquy-link-title" type="text" size="40" name="_soliloquy_uploads[link_title]" value="' . $image['linktitle'] . '" />';
												$html .= '<input id="soliloquy-link-tab-' . $image['id'] . '" class="soliloquy-link-check" type="checkbox" name="_soliloquy_uploads[link_tab]" value="' . $image['linktab'] . '"' . $image['linkcheck'] . ' />';
												$html .= '<label for="soliloquy-link-tab-' . $image['id'] . '"><span class="description"> ' . Tgmsp_Strings::get_instance()->strings['new_tab'] . '</span></label>';
												$html .= '<a id="soliloquy-link-existing" href="#"><em>' . Tgmsp_Strings::get_instance()->strings['link_existing'] . '</em></a>';
												$html .= '<div id="soliloquy-internal-linking-' . $image['id'] . '" style="display: none;">';
													$html .= '<label class="soliloquy-search-label" for="soliloquy-search-links-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['search'] . '</label>';
													$html .= '<input class="soliloquy-search" type="text" id="soliloquy-search-links-' . $image['id'] . '" size="45" value="" />';
													$html .= '<div class="soliloquy-search-results">';
														$html .= '<ul id="soliloquy-list-links-' . $image['id'] . '" class="soliloquy-results-list"></ul>';
													$html .= '</div>';
												$html .= '</div>';
											$html .= '</div>'; 
											$html .= '<div class="soliloquy-link-video-wrap soliloquy-top">';
												$html .= '<label class="soliloquy-video-link-label" for="soliloquy-video-link-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_link_video'] . '</label> ';
												$html .= '<input id="soliloquy-video-link-' . $image['id'] . '" class="soliloquy-video-link" type="text" size="63" name="_soliloquy_uploads[video_link]" value="' . $image['videolink'] . '" />';
												$html .= '<p class="soliloquy-video-info"><strong>' . Tgmsp_Strings::get_instance()->strings['video_link_info'] . '</strong></p>';
												$html .= '<div class="soliloquy-accepted-urls">';
													$html .= '<div class="soliloquy-left">';
														$html .= '<span><strong>' . Tgmsp_Strings::get_instance()->strings['youtube_urls'] . '</strong></span>';
														$html .= '<span>youtube.com/v/{vidid}</span>';
														$html .= '<span>youtube.com/vi/{vidid}</span>';
														$html .= '<span>youtube.com/?v={vidid}</span>';
														$html .= '<span>youtube.com/?vi={vidid}</span>';
														$html .= '<span>youtube.com/watch?v={vidid}</span>';
														$html .= '<span>youtube.com/watch?vi={vidid}</span>';
														$html .= '<span>youtu.be/{vidid}</span>';
													$html .= '</div>';
													$html .= '<div class="soliloquy-right">';
														$html .= '<span><strong>' . Tgmsp_Strings::get_instance()->strings['vimeo_urls'] . '</strong></span>';
														$html .= '<span>vimeo.com/{vidid}</span>';
														$html .= '<span>vimeo.com/groups/tvc/videos/{vidid}</span>';
														$html .= '<span>player.vimeo.com/video/{vidid}</span>';
													$html .= '</div>';
												$html .= '</div>';
											$html .= '</div>';
										$html .= '</td>';
									$html .= '</tr>';
									if ( array_key_exists( 'before_image_caption', $image ) )
										foreach ( (array) $image['before_image_caption'] as $data )
											$html .= $data;
									$html .= '<tr id="soliloquy-caption-box-' . $image['id'] . '" valign="middle">';
										$html .= '<th scope="row"><label for="soliloquy-caption-' . $image['id'] . '">' . Tgmsp_Strings::get_instance()->strings['image_caption'] . '</label></th>';
										$html .= '<td>';
											$html .= '<textarea id="soliloquy-caption-' . $image['id'] . '" class="soliloquy-caption" rows="3" cols="75" name="_soliloquy_uploads[caption]">' . $image['caption'] . '</textarea>';
											$html .= '<span class="description">' . Tgmsp_Strings::get_instance()->strings['image_caption_desc'] . '</span>';
										$html .= '</td>';
									$html .= '</tr>';
									if ( array_key_exists( 'after_meta_defaults', $image ) )
										foreach ( (array) $image['after_meta_defaults'] as $data )
											$html .= $data;
								$html .= '</tbody>';
							$html .= '</table>';
							if ( array_key_exists( 'after_image_meta_table', $image ) )
								foreach ( (array) $image['after_image_meta_table'] as $data )
									$html .= $data;
							$html .= '<a href="#" class="soliloquy-meta-submit button-secondary" title="' . Tgmsp_Strings::get_instance()->strings['save_meta'] . '">' . Tgmsp_Strings::get_instance()->strings['save_meta'] . '</a>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</li>';
			}
		}
		
		/** Store the HTML */
		$response['images'] = $html;

		/** Json encode the images, send them back to the script for processing and die */
		echo json_encode( $response );
		die;

	}

	/**
	 * Ajax callback to save the sortable image order for the current slider.
	 *
	 * @since 1.0.0
	 */
	public function sort_images() {

		/** Do a security check first */
		check_ajax_referer( 'soliloquy_sortable', 'nonce' );

		/** Prepare our variables */
		$order 	= explode( ',', $_POST['order'] );
		$i 		= 1;

		/** Update the menu order for the images in the database */
		foreach ( $order as $id ) {
			$sort 				= array();
			$sort['ID'] 		= $id;
			$sort['menu_order'] = $i;
			wp_update_post( $sort );
			$i++;
		}

		do_action( 'tgmsp_ajax_sort_images', $_POST );

		/** Send the order back to the script */
		echo json_encode( $order );
		die;

	}

	/**
	 * Ajax callback to remove an image from the current Soliloquy.
	 *
	 * @since 1.0.0
	 */
	public function remove_images() {

		/** Do a security check first */
		check_ajax_referer( 'soliloquy_remove', 'nonce' );

		/** Prepare our variable */
		$attachment_id = (int) $_POST['attachment_id'];
		
		do_action( 'tgmsp_ajax_pre_remove_images', $attachment_id );

		/** Delete the corresponding attachment */
		wp_delete_attachment( $attachment_id );

		do_action( 'tgmsp_ajax_remove_images', $attachment_id );

		die;

	}

	/**
	 * Ajax callback to update image meta for the current Soliloquy.
	 *
	 * @since 1.0.0
	 */
	public function update_meta() {

		/** Do a security check first */
		check_ajax_referer( 'soliloquy_meta', 'nonce' );

		/** Make sure attachment ID is an integer */
		$attachment_id = (int) $_POST['attach'];

		/** Update attachment title */
		$title 					= array();
		$title['ID'] 			= $attachment_id;
		$title['post_title'] 	= strip_tags( $_POST['soliloquy-title'] );
		wp_update_post( $title );

		/** Update attachment alt text */
		update_post_meta( $attachment_id, '_wp_attachment_image_alt', strip_tags( $_POST['soliloquy-alt'] ) );

		/** Update attachment link items */	
		update_post_meta( $attachment_id, '_soliloquy_image_link_type', preg_replace( '#[^a-z0-9-_]#', '', $_POST['soliloquy-link-type'] ) );
		update_post_meta( $attachment_id, '_soliloquy_image_link', esc_url( $_POST['soliloquy-link'] ) );
		update_post_meta( $attachment_id, '_soliloquy_image_link_title', esc_attr( strip_tags( $_POST['soliloquy-link-title'] ) ) );
		update_post_meta( $attachment_id, '_soliloquy_image_link_tab', ( 'true' == $_POST['soliloquy-link-check'] ) ? (int) 1 : (int) 0 );
		update_post_meta( $attachment_id, '_soliloquy_video_link', esc_url( $_POST['soliloquy-video-link'] ) );

		/** Update attachment caption */
		$caption 					= array();
		$caption['ID'] 				= $attachment_id;
		$caption['post_excerpt'] 	= current_user_can( 'unfiltered_html' ) ? stripslashes( $_POST['soliloquy-caption'] ) : wp_kses_post( $_POST['soliloquy-caption'] );
		wp_update_post( $caption );

		do_action( 'tgmsp_ajax_update_meta', $_POST );

		die;

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