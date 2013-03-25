<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Post meta boxes generator
*
* CONTENT:
* - 1) Required files
* - 2) Actions and filters
* - 3) Meta box form
* - 4) Saving meta
*****************************************************
*/





/*
*****************************************************
*      1) REQUIRED FILES
*****************************************************
*/
	require_once( WM_META . 'a-meta-post.php' );





/*
*****************************************************
*      2) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		add_action( 'edit_form_after_title', 'wm_post_metabox_start', 1000 );
		add_action( 'edit_form_after_editor', 'wm_post_metabox_end', 1 );
		add_action( 'save_post', 'wm_post_metabox_save' );





/*
*****************************************************
*      3) META BOX FORM
*****************************************************
*/
	/*
	* Meta form generator start
	*/
	if ( ! function_exists( 'wm_post_metabox_start' ) ) {
		function wm_post_metabox_start() {
			global $post;

			if ( 'post' != $post->post_type )
				return;

			$metaPostOptions = wm_meta_post_options();

			wp_nonce_field( 'wm_post_metabox_nonce', 'post_metabox_nonce' );

			//Display meta box form HTML
			$out = '<div class="wm-wrap meta meta-special jquery-ui-tabs">';

				//Tabs
				$out .= '<ul class="tabs no-js">';
				$out .= '<li class="item-0 visual-editor"><a href="#wm-meta-visual-editor">' . __( 'Content', 'lespaul_domain_adm' ) . '</a></li>';
				$i = 0;
				foreach ( $metaPostOptions as $tab ) {
					if ( 'section-open' == $tab['type'] ) {
						++$i;
						$out .= '<li class="item-' . $i . ' ' . $tab['section-id'] . '"><a href="#wm-meta-' . $tab['section-id'] . '">' . $tab['title'] . '</a></li>';
					}
				}
				$out .= '</ul> <!-- /tabs -->';

			echo $out;

			$editorTabContent = array(
				array(
					"type" => "section-open",
					"section-id" => "visual-editor",
				)
			);

			//Content
			wm_render_form( $editorTabContent, 'meta' );
		}
	} // /wm_post_metabox_start



	/*
	* Meta form generator end
	*/
	if ( ! function_exists( 'wm_post_metabox_end' ) ) {
		function wm_post_metabox_end() {
			global $post;

			if ( 'post' != $post->post_type )
				return;

			$metaPostOptions = wm_meta_post_options();

			$editorTabContent = wm_meta_post_options_formats();
			$metaPostOptions  = array_merge( $editorTabContent, array( array( "type" => "section-close" ) ), $metaPostOptions );

			//Content
			wm_render_form( $metaPostOptions, 'meta' );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'lespaul_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'lespaul_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		}
	} // /wm_post_metabox_end





/*
*****************************************************
*      4) SAVING META
*****************************************************
*/
	/*
	* Saves post meta options
	*
	* $post_id = # [current post ID]
	*/
	if ( ! function_exists( 'wm_post_metabox_save' ) ) {
		function wm_post_metabox_save( $post_id ) {
			global $post;

			if ( is_object( $post ) && 'post' != $post->post_type )
				return $post_id;

			$optionsStart    = wm_meta_post_options_formats();
			$optionsEnd      = wm_meta_post_options();
			$metaPostOptions = array_merge( $optionsStart, $optionsEnd );

			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['post_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['post_metabox_nonce'], 'wm_post_metabox_nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;

			//Save the data
			wm_save_meta( $post_id, $metaPostOptions );
		}
	} // /wm_post_metabox_save

?>