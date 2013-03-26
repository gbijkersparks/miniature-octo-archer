<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Logos custom post
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
		add_action( 'init', 'wm_logos_cp_init' );
		//CP list table columns
		add_action( 'manage_wm_logos_posts_custom_column', 'wm_logos_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_logos_columns', 'wm_logos_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_logos_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_logos_cp_init' ) ) {
		function wm_logos_cp_init() {
			global $cpMenuPosition;

			$role  = ( wm_option( 'cp-role-logos' ) ) ? ( wm_option( 'cp-role-logos' ) ) : ( 'post' );
			$slug  = ( wm_option( 'cp-permalink-logos' ) ) ? ( wm_option( 'cp-permalink-logos' ) ) : ( 'logo' );
			$title = __( 'Logos', 'lespaul_domain_adm' );

			$args = array(
				'query_var'           => 'logos',
				'capability_type'     => $role,
				'public'              => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['logos'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-clients.png',
				'supports'            => array( 'title' ),
				'labels'              => array(
					'name'               => $title,
					'singular_name'      => $title,
					'add_new'            => __( 'Add new', 'lespaul_domain_adm' ),
					'add_new_item'       => __( 'Add new', 'lespaul_domain_adm' ),
					'new_item'           => __( 'Add new', 'lespaul_domain_adm' ),
					'edit_item'          => __( 'Edit', 'lespaul_domain_adm' ),
					'view_item'          => __( 'View', 'lespaul_domain_adm' ),
					'search_items'       => __( 'Search', 'lespaul_domain_adm' ),
					'not_found'          => __( 'No item found', 'lespaul_domain_adm' ),
					'not_found_in_trash' => __( 'No item found in trash', 'lespaul_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_logos' , $args );
		}
	} // /wm_logos_cp_init





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
	if ( ! function_exists( 'wm_logos_cp_messages' ) ) {
		function wm_logos_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_logos'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Updated.', 'lespaul_domain_adm' ),
				2  => __( 'Custom field updated.', 'lespaul_domain_adm' ),
				3  => __( 'Custom field deleted.', 'lespaul_domain_adm' ),
				4  => __( 'Updated.', 'lespaul_domain_adm' ),
				5  => ( isset( $_GET['revision'] ) ) ? ( sprintf(
					__( 'Restored to revision from %s', 'lespaul_domain_adm' ),
						wp_post_revision_title( (int) $_GET['revision'], false )
					) ) : ( false ),
				6  => __( 'Published.', 'lespaul_domain_adm' ),
				7  => __( 'Saved.', 'lespaul_domain_adm' ),
				8  => __( 'Submitted.', 'lespaul_domain_adm' ),
				9  => sprintf(
					__( 'Scheduled for: <strong>%s</strong>.', 'lespaul_domain_adm' ),
						get_the_date() . ', ' . get_the_time()
					),
				10 => __( 'Draft updated.', 'lespaul_domain_adm' ),
				);

			return $messages;
		}
	} // /wm_logos_cp_messages





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
	if ( ! function_exists( 'wm_logos_cp_columns' ) ) {
		function wm_logos_cp_columns( $wm_logosCols ) {
			$prefix = 'wm_logos-';

			$wm_logosCols = array(
				//standard columns
				"cb"                 => '<input type="checkbox" />',
				$prefix . "thumb"    => __( 'Logo', 'lespaul_domain_adm' ),
				"title"              => __( 'Nome', 'lespaul_domain_adm' ),
				$prefix . "category" => __( 'Categoria', 'lespaul_domain_adm' ),
				$prefix . "link"     => __( 'link Personalizado', 'lespaul_domain_adm' ),
				"date"               => __( 'Data', 'lespaul_domain_adm' ),
				"author"             => __( 'Criado por', 'lespaul_domain_adm' )
			);

			return $wm_logosCols;
		}
	} // /wm_logos_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_logos_cp_custom_column' ) ) {
		function wm_logos_cp_custom_column( $wm_logosCol ) {
			global $post;
			$prefix     = 'wm_logos-';
			$prefixMeta = 'client-';

			switch ( $wm_logosCol ) {
				case $prefix . "thumb":

					$size  = explode( 'x', WM_ADMIN_LIST_THUMB );
					//$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, 'widget' ) ) : ( '<img src="' . WM_ASSETS_ADMIN . 'img/no-thumb.png" alt="' . __( 'No image', 'lespaul_domain_adm' ) . '" title="' . __( 'No image', 'lespaul_domain_adm' ) . '" />' );
					$image = ( wm_meta_option( $prefixMeta . 'logo' ) ) ? ( '<img src="' . esc_url( wm_meta_option( $prefixMeta . 'logo' ) ) . '" alt="" />' ) : ( '' );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					echo '<span class="wm-image-container' . $hasThumb . '">';

					if ( get_edit_post_link() )
						edit_post_link( $image );
					else
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';

					echo '</span>';

				break;
				case $prefix . "category":

					$terms = get_the_terms( $post->ID , 'logos-category' );
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				case $prefix . "link":

					$wm_logosLink = esc_url( stripslashes( wm_meta_option( $prefixMeta . 'link' ) ) );
					echo '<a href="' . $wm_logosLink . '" target="_blank">' . $wm_logosLink . '</a>';

				break;
				default:
				break;
			}
		}
	} // /wm_logos_cp_custom_column

?>