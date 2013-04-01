<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Content Module custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Admin messages
* - 4) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'wm_modules_cp_init' );
		//CP list table columns
		add_action( 'manage_wm_modules_posts_custom_column', 'wm_modules_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_modules_columns', 'wm_modules_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_modules_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_modules_cp_init' ) ) {
		function wm_modules_cp_init() {
			global $cpMenuPosition;

			$role     = ( wm_option( 'cp-role-modules' ) ) ? ( wm_option( 'cp-role-modules' ) ) : ( 'post' );
			$slug     = ( wm_option( 'cp-permalink-module' ) ) ? ( wm_option( 'cp-permalink-module' ) ) : ( 'module' );
			$supports = array( 'title', 'editor', 'thumbnail' );

			if ( wm_option( 'cp-modules-revisions' ) )
				$supports[] = 'revisions';

			$args = array(
				'query_var'           => 'modules',
				'capability_type'     => $role,
				'public'              => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['content-modules'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-modules.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Content Modules', 'atlantes_domain_adm' ),
					'singular_name'      => __( 'Content module', 'atlantes_domain_adm' ),
					'add_new'            => __( 'Add new module', 'atlantes_domain_adm' ),
					'add_new_item'       => __( 'Add new module', 'atlantes_domain_adm' ),
					'new_item'           => __( 'Add new module', 'atlantes_domain_adm' ),
					'edit_item'          => __( 'Edit module', 'atlantes_domain_adm' ),
					'view_item'          => __( 'View module', 'atlantes_domain_adm' ),
					'search_items'       => __( 'Search modules', 'atlantes_domain_adm' ),
					'not_found'          => __( 'No module found', 'atlantes_domain_adm' ),
					'not_found_in_trash' => __( 'No module found in trash', 'atlantes_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_modules' , $args );
		}
	} // /wm_modules_cp_init





/*
*****************************************************
*      3) ADMIN MESSAGES
*****************************************************
*/
	/*
	* Custom post admin area messages
	*
	* $messages = ARRAY [array of messages]
	*/
	if ( ! function_exists( 'wm_modules_cp_messages' ) ) {
		function wm_modules_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_modules'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Updated.', 'atlantes_domain_adm' ),
				2  => __( 'Custom field updated.', 'atlantes_domain_adm' ),
				3  => __( 'Custom field deleted.', 'atlantes_domain_adm' ),
				4  => __( 'Updated.', 'atlantes_domain_adm' ),
				5  => ( isset( $_GET['revision'] ) ) ? ( sprintf(
					__( 'Restored to revision from %s', 'atlantes_domain_adm' ),
						wp_post_revision_title( (int) $_GET['revision'], false )
					) ) : ( false ),
				6  => __( 'Published.', 'atlantes_domain_adm' ),
				7  => __( 'Saved.', 'atlantes_domain_adm' ),
				8  => __( 'Submitted.', 'atlantes_domain_adm' ),
				9  => sprintf(
					__( 'Scheduled for: <strong>%s</strong>.', 'atlantes_domain_adm' ),
						get_the_date() . ', ' . get_the_time()
					),
				10 => __( 'Draft updated.', 'atlantes_domain_adm' ),
				);

			return $messages;
		}
	} // /wm_modules_cp_messages





/*
*****************************************************
*      4) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'wm_modules_cp_columns' ) ) {
		function wm_modules_cp_columns( $wm_modulesCols ) {
			$prefix = 'wm_modules-';

			$wm_modulesCols = array(
				//standard columns
				"cb"                  => '<input type="checkbox" />',
				$prefix . "thumb"     => __( 'Image <small>[type]</small>', 'atlantes_domain_adm' ),
				"title"               => __( 'Content module', 'atlantes_domain_adm' ),
				$prefix . "shortcode" => __( 'Shortcode', 'atlantes_domain_adm' ),
				$prefix . "tag"       => __( 'Tags', 'atlantes_domain_adm' ),
				$prefix . "link"      => __( 'Custom link', 'atlantes_domain_adm' ),
				"date"                => __( 'Date', 'atlantes_domain_adm' ),
				"author"              => __( 'Created by', 'atlantes_domain_adm' )
			);

			return $wm_modulesCols;
		}
	} // /wm_modules_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_modules_cp_custom_column' ) ) {
		function wm_modules_cp_custom_column( $wm_modulesCol ) {
			global $post;
			$prefix     = 'wm_modules-';
			$prefixMeta = 'module-';

			switch ( $wm_modulesCol ) {
				case $prefix . "thumb":

					$image = ( ! has_post_thumbnail() ) ? ( '' ) : ( get_the_post_thumbnail( null, 'widget' ) );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					$iconStyles = '';
					if ( 'icon' == wm_meta_option( $prefixMeta . 'type' ) && wm_meta_option( $prefixMeta . 'icon-box-color' ) ) {
						$iconStyles  = ' style="background-color: ';
						$iconStyles .= ( wm_meta_option( $prefixMeta . 'icon-box-color' ) ) ? ( wm_meta_option( $prefixMeta . 'icon-box-color',$post->ID , 'color' ) ) : ( wm_option( 'design-accent-color', 'color' ) );
						$iconStyles .= ';"';
					}

					echo '<span class="wm-image-container' . $hasThumb . '"' . $iconStyles . '>';

					if ( get_edit_post_link() )
						edit_post_link( $image );
					else
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';

					echo '</span>';

					if ( 'icon' == wm_meta_option( $prefixMeta . 'type' ) )
						echo ' <small>' . __( '[Icon module]', 'atlantes_domain_adm' ) . '</small>';

				break;
				case $prefix . "link":

					$wm_modulesLink = esc_url( stripslashes( wm_meta_option( $prefixMeta . 'link' ) ) );
					echo '<a href="' . $wm_modulesLink . '" target="_blank">' . $wm_modulesLink . '</a>';

				break;
				case $prefix . "shortcode":

					$wm_modulesLink = esc_url( stripslashes( wm_meta_option( $prefixMeta . 'link' ) ) );
					echo '<input type="text" onfocus="this.select();" readonly="readonly" style="width:100%" value="[content_module module=&quot;' . $post->post_name . '&quot; /]" class="shortcode-in-list-table">';

				break;
				case $prefix . "tag":

					$terms = get_the_terms( $post->ID , 'content-module-tag' );
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				default:
				break;
			}
		}
	} // /wm_modules_cp_custom_column

?>