<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Custom taxonomies meta fields
*
* CONTENT:
* - 1) Actions
* - 2) Function
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS
*****************************************************
*/
	//ACTIONS
		//creating / editing
		add_action( 'project-type_add_form_fields', 'wm_project_type_create', 10, 2 );
		add_action( 'project-type_edit_form_fields', 'wm_project_type_edit', 10, 2 );
		//saving
		add_action( 'created_project-type', 'wm_project_type_save', 10, 2 );
		add_action( 'edited_project-type', 'wm_project_type_save', 10, 2 );
		//deleting
		add_action( 'delete_project-type', 'wm_project_type_delete', 10, 2 );





/*
*****************************************************
*      2) FUNCTIONS
*****************************************************
*/
	/*
	* Form fields basics
	*/
	if ( ! function_exists( 'wm_project_type_form_fields' ) ) {
		function wm_project_type_form_fields( $option = '', $field = '', $tag ) {
			if ( is_object( $tag ) ) {
				$termId    = $tag->term_id;
				$metaArray = get_option( 'wm-tax_project-type-' . $termId );

				$typeSet = ( isset( $metaArray['type'] ) ) ? ( $metaArray['type'] ) : ( '' );
				$iconSet = ( isset( $metaArray['icon'] ) ) ? ( $metaArray['icon'] ) : ( '' );
			} else {
				$iconSet = $typeSet = '';
			}

			$out['type']['label'] = '<label for="term_meta-type">' . __( 'Behaviour', 'atlantes_domain_adm' ) . '</label>';
			$out['type']['field'] = '<p><select name="term_meta[type]" id="term_meta-type">';
				$projectTypes = array(
						'static-project' => __( 'Image', 'atlantes_domain_adm' ),
						'slider-project' => __( 'Slideshow of images', 'atlantes_domain_adm' ),
						'video-project'  => __( 'Video', 'atlantes_domain_adm' ),
						'audio-project'  => __( 'Audio', 'atlantes_domain_adm' ),
					);
				foreach ( $projectTypes as $key => $value ) {
					$out['type']['field'] .= '<option value="' . $key . '" ' . selected( $typeSet, $key, false ) . '>' . $value . '</option>';
				}
				$out['type']['field'] .= '</select></p><p class="description">' . __( 'Select one of predefined behaviours for this project type', 'atlantes_domain_adm' ) . '</p>';


			$out['icon']['label'] = '<label for="term_meta-icon">' . __( 'Icon', 'atlantes_domain_adm' ) . '</label>';
			$out['icon']['field'] = '<p><span class="image-before"></span><select name="term_meta[icon]" id="term_meta-icon"><option value="">' . __( '- Select icon -', 'atlantes_domain_adm' ) . '</option>';
				$fontFile  = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
				$fontIcons = wm_fontello_classes( $fontFile );
				foreach ( $fontIcons as $icon ) {
					$out['icon']['field'] .= '<option value="' . $icon . '" ' . selected( $iconSet, $icon, false ) . '>' . ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) ) . '</option>';
				}
				$out['icon']['field'] .= '</select></p><p class="description">' . __( 'Select one of predefined icons for this project type', 'atlantes_domain_adm' ) . '<br /><small>' . __( 'TIP: Double click the select field to keep it in focus while hiding the dropdown and use arrow keys to browse icons.', 'atlantes_domain_adm' ) . '</small></p>
					<script type="text/javascript">
						<!--
						jQuery( "#tag-description, #description" ).closest( ".form-field" ).hide();
						jQuery( "#term_meta-icon" ).change( function () {
								var $this = jQuery( this );
								$this.prev( ".image-before" ).html( "<i class=\"" + $this.val() + "\"></i>" );
							} ).change();
						-->
					</script>';

			echo $out[$option][$field];
		}
	} // /wm_project_type_form_fields



	/*
	* Adding a custom field to create taxonomy
	*/
	if ( ! function_exists( 'wm_project_type_create' ) ) {
		function wm_project_type_create( $tag ) {
			?>
			<div class="form-field">
				<?php wm_project_type_form_fields( 'type', 'label', $tag ) ?>
				<?php wm_project_type_form_fields( 'type', 'field', $tag ) ?>
			</div>
			<div class="form-field">
				<?php wm_project_type_form_fields( 'icon', 'label', $tag ) ?>
				<?php wm_project_type_form_fields( 'icon', 'field', $tag ) ?>
			</div>
			<?php
		}
	} // /wm_project_type_create



	/*
	* Adding a custom field to edit taxonomy
	*/
	if ( ! function_exists( 'wm_project_type_edit' ) ) {
		function wm_project_type_edit( $tag ) {
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<?php wm_project_type_form_fields( 'type', 'label', $tag ) ?>
				</th>
				<td>
					<?php wm_project_type_form_fields( 'type', 'field', $tag ) ?>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top">
					<?php wm_project_type_form_fields( 'icon', 'label', $tag ) ?>
				</th>
				<td>
					<?php wm_project_type_form_fields( 'icon', 'field', $tag ) ?>
				</td>
			</tr>
			<?php
		}
	} // /wm_project_type_edit



	/*
	* Saving taxonomy meta
	*/
	if ( ! function_exists( 'wm_project_type_save' ) ) {
		function wm_project_type_save( $term_id ) {
			if ( $term_id && isset( $_POST['term_meta'] ) ) {
				$metaArray = get_option( 'wm-tax_project-type-' . $term_id );
				$newMeta   = array_keys( $_POST['term_meta'] );

				foreach ( $newMeta as $new ) {
					if ( isset( $_POST['term_meta'][$new] ) )
						$metaArray[$new] = $_POST['term_meta'][$new];
				}

				//save the option array
				update_option( 'wm-tax_project-type-' . $term_id, $metaArray );
			}
		}
	} // /wm_project_type_save



	/*
	* Delete taxonomy meta
	*/
	if ( ! function_exists( 'wm_project_type_delete' ) ) {
		function wm_project_type_delete( $term_id ) {
			if ( $term_id )
				delete_option( 'wm-tax_project-type-' . $term_id );
		}
	} // /wm_project_type_delete

?>