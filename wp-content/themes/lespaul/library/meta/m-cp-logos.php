<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Logos custom post meta boxes
*
* CONTENT:
* - 1) Actions and filters
* - 2) Meta box form
* - 3) Saving meta
* - 4) Add meta box
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Adding meta boxes
		add_action( 'add_meta_boxes', 'wm_logos_cp_admin_box' );
		//Saving CP
		add_action( 'save_post', 'wm_logos_cp_save_meta' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_logos_meta_fields' ) ) {
		function wm_logos_meta_fields() {
			$prefix = 'client-';
			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general",
					"title" => __( 'Client info', 'lespaul_domain_adm' )
				),
					array(
						"type" => "image",
						"id" => $prefix."logo",
						"label" => __( 'Logo', 'lespaul_domain_adm' ),
						"desc" => __( 'Logo image URL. Keep the logo images constant aspect ratio to display correctly in Logos shortcode.', 'lespaul_domain_adm' ),
						"default" => "",
						"imgsize" => 'full'
					),
					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( "Custom link URL", 'lespaul_domain_adm' ),
						"desc" => __( 'When left blank, no link will be applied', 'lespaul_domain_adm' ),
						"validate" => "url"
					),
				array(
					"type" => "section-close"
				)

			);

			return $metaFields;
		}
	} // /wm_logos_meta_fields



	/*
	* Meta form generator
	*
	* $post = OBJ [current post object]
	*/
	if ( ! function_exists( 'wm_logos_cp_meta_options' ) ) {
		function wm_logos_cp_meta_options( $post ) {
			wp_nonce_field( 'wm_logos-metabox-nonce', 'wm_logos-metabox-nonce' );

			//Display custom meta box form HTML
			$metaFields = wm_logos_meta_fields();

			wm_cp_meta_form_generator( $metaFields );
		}
	} // /wm_logos_cp_meta_options





/*
*****************************************************
*      3) SAVING META
*****************************************************
*/
	/*
	* Saves post meta options
	*
	* $post_id = # [current post ID]
	*/
	if ( ! function_exists( 'wm_logos_cp_save_meta' ) ) {
		function wm_logos_cp_save_meta( $post_id ) {
			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_logos-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_logos-metabox-nonce'], 'wm_logos-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			$capability = ( wm_option( 'cp-role-logos' ) && 'disable' !== wm_option( 'cp-role-logos' ) ) ? ( 'edit_' . wm_option( 'cp-role-logos' ) ) : ( 'edit_post' );
			if ( ! current_user_can( $capability, $post_id ) )
				return $post_id;

			//Save each meta field separately
			$metaFields = wm_logos_meta_fields();

			wm_save_meta( $post_id, $metaFields );
		}
	} // /wm_logos_cp_save_meta





/*
*****************************************************
*      4) ADD META BOX
*****************************************************
*/
	/*
	* Add meta box
	*/
	if ( ! function_exists( 'wm_logos_cp_admin_box' ) ) {
		function wm_logos_cp_admin_box() {
			add_meta_box( 'wm-metabox-wm_logos-meta', __( 'Logo info', 'lespaul_domain_adm' ), 'wm_logos_cp_meta_options', 'wm_logos', 'normal', 'high' );
		}
	} // /wm_logos_cp_admin_box

?>