<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Prices custom post meta boxes
*
* CONTENT:
* - 1) Actions and filters
* - 2) Meta box form
* - 3) Saving meta
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Adding meta boxes
		add_action( 'edit_form_after_title', 'wm_price_metabox_start', 1000 );
		add_action( 'edit_form_after_editor', 'wm_price_metabox_end', 1 );
		//Saving CP
		add_action( 'save_post', 'wm_price_cp_save_meta' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_price_meta_fields' ) ) {
		function wm_price_meta_fields() {
			$prefix   = 'price-';

			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general-settings",
					"title" => __( 'Price set up', 'atlantes_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."cost",
						"label" => __( 'Price cost (including currency)', 'atlantes_domain_adm' ),
						"desc" => __( 'The actual price cost displayed including currency', 'atlantes_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."note",
						"label" => __( 'Note text', 'atlantes_domain_adm' ),
						"desc" => __( 'Additional note displayed below price cost', 'atlantes_domain_adm' )
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "text",
						"id" => $prefix."order",
						"label" => __( 'Price column order', 'atlantes_domain_adm' ),
						"desc" => __( 'Set a number to order price columns in price table. Higher number will move the column further to the right in the price table.<br />Leave empty or set to 0 (zero) to keep the default ordering (by date created).', 'atlantes_domain_adm' ),
						"size" => 3,
						"maxlength" => 3,
						"validate" => "absint"
					),
				array(
					"type" => "section-close"
				),



				//Button
				array(
					"type" => "section-open",
					"section-id" => "button-settings",
					"title" => __( 'Button set up', 'atlantes_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."btn-text",
						"label" => __( 'Button text', 'atlantes_domain_adm' ),
						"desc" => __( 'Price button text', 'atlantes_domain_adm' ),
						"default" => ""
					),
					array(
						"type" => "text",
						"id" => $prefix."btn-url",
						"label" => __( 'Button link', 'atlantes_domain_adm' ),
						"desc" => __( 'Price button URL link', 'atlantes_domain_adm' ),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."btn-color",
						"label" => __( 'Button color', 'atlantes_domain_adm' ),
						"desc" => __( 'Choose style of the button', 'atlantes_domain_adm' ),
						"options" => array(
							''       => __( 'Link color button (default)', 'atlantes_domain_adm' ),
							'gray'   => __( 'Gray button', 'atlantes_domain_adm' ),
							'green'  => __( 'Green button', 'atlantes_domain_adm' ),
							'blue'   => __( 'Blue button', 'atlantes_domain_adm' ),
							'orange' => __( 'Orange button', 'atlantes_domain_adm' ),
							'red'    => __( 'Red button', 'atlantes_domain_adm' ),
							),
						"default" => ""
					),
				array(
					"type" => "section-close"
				),



				//Styling
				array(
					"type" => "section-open",
					"section-id" => "styling-settings",
					"title" => __( 'Styling', 'atlantes_domain_adm' )
				),
					array(
						"type" => "radio",
						"id" => $prefix."style",
						"label" => __( 'Column style', 'atlantes_domain_adm' ),
						"desc" => __( 'Select, how this column should be styles', 'atlantes_domain_adm' ),
						"options" => array(
							''          => __( 'Price column', 'atlantes_domain_adm' ),
							' featured' => __( 'Featured price column', 'atlantes_domain_adm' ),
							' legend'   => __( 'Legend', 'atlantes_domain_adm' ),
							),
					),
					array(
						"type" => "space"
					),
					array(
						"type" => "color",
						"id" => $prefix."color",
						"label" => __( 'Custom column color', 'atlantes_domain_adm' ),
						"desc" => __( 'Sets the custom price column background color', 'atlantes_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"type" => "section-close"
				),

			);

			return $metaFields;
		}
	} // /wm_price_meta_fields



	/*
	* Meta form generator start
	*/
	if ( ! function_exists( 'wm_price_metabox_start' ) ) {
		function wm_price_metabox_start() {
			global $post;

			if ( 'wm_price' != $post->post_type )
				return;

			$metaFields = wm_price_meta_fields();

			wp_nonce_field( 'wm_price-metabox-nonce', 'wm_price-metabox-nonce' );

			//Display meta box form HTML
			$out = '<div class="wm-wrap meta meta-special jquery-ui-tabs">';

				//Tabs
				$out .= '<ul class="tabs no-js">';
				$out .= '<li class="item-0 visual-editor"><a href="#wm-meta-visual-editor">' . __( 'Content', 'atlantes_domain_adm' ) . '</a></li>';
				$i = 0;
				foreach ( $metaFields as $tab ) {
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
	} // /wm_price_metabox_start



	/*
	* Meta form generator end
	*/
	if ( ! function_exists( 'wm_price_metabox_end' ) ) {
		function wm_price_metabox_end() {
			global $post;

			if ( 'wm_price' != $post->post_type )
				return;

			$metaFields = wm_price_meta_fields();
			$metaFields = array_merge( array( array( "type" => "section-close" ) ), $metaFields );

			//Content
			wm_render_form( $metaFields, 'meta' );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'atlantes_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'atlantes_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		}
	} // /wm_price_metabox_end





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
	if ( ! function_exists( 'wm_price_cp_save_meta' ) ) {
		function wm_price_cp_save_meta( $post_id ) {
			global $post;

			if ( is_object( $post ) && 'wm_price' != $post->post_type )
				return $post_id;

			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_price-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_price-metabox-nonce'], 'wm_price-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			$capability = ( wm_option( 'cp-role-prices' ) && 'disable' !== wm_option( 'cp-role-prices' ) ) ? ( 'edit_' . wm_option( 'cp-role-prices' ) ) : ( 'edit_post' );
			if ( ! current_user_can( $capability, $post_id ) )
				return $post_id;

			//Save each meta field separately
			$metaFields = wm_price_meta_fields();

			wm_save_meta( $post_id, $metaFields );
		}
	} // /wm_price_cp_save_meta

?>