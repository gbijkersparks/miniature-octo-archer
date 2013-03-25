<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* FAQ custom post
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
		add_action( 'init', 'wm_faq_cp_init' );
		//CP list table columns
		add_action( 'manage_wm_faq_posts_custom_column', 'wm_faq_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_faq_columns', 'wm_faq_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_faq_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_faq_cp_init' ) ) {
		function wm_faq_cp_init() {
			global $cpMenuPosition;

			$role     = ( wm_option( 'cp-role-faq' ) ) ? ( wm_option( 'cp-role-faq' ) ) : ( 'post' );
			$slug     = ( wm_option( 'cp-permalink-faq' ) ) ? ( wm_option( 'cp-permalink-faq' ) ) : ( 'faq' );
			$supports = array( 'title', 'editor' );

			if ( wm_option( 'cp-faq-revisions' ) )
				$supports[] = 'revisions';

			$args = array(
				'query_var'           => 'faq',
				'capability_type'     => $role,
				'public'              => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['faq'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-faq.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'FAQ', 'lespaul_domain_adm' ),
					'singular_name'      => __( 'Answer', 'lespaul_domain_adm' ),
					'add_new'            => __( 'Add new answer', 'lespaul_domain_adm' ),
					'add_new_item'       => __( 'Add new answer', 'lespaul_domain_adm' ),
					'new_item'           => __( 'Add new answer', 'lespaul_domain_adm' ),
					'edit_item'          => __( 'Edit answer', 'lespaul_domain_adm' ),
					'view_item'          => __( 'View answer', 'lespaul_domain_adm' ),
					'search_items'       => __( 'Search question', 'lespaul_domain_adm' ),
					'not_found'          => __( 'No question found', 'lespaul_domain_adm' ),
					'not_found_in_trash' => __( 'No question found in trash', 'lespaul_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_faq' , $args );
		}
	} // /wm_faq_cp_init





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
	if ( ! function_exists( 'wm_faq_cp_messages' ) ) {
		function wm_faq_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_faq'] = array(
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
	} // /wm_faq_cp_messages





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
	if ( ! function_exists( 'wm_faq_cp_columns' ) ) {
		function wm_faq_cp_columns( $wm_faqCols ) {
			$prefix = 'wm_faq-';

			$wm_faqCols = array(
				//standard columns
				"cb"                 => '<input type="checkbox" />',
				"title"              => __( 'Question', 'lespaul_domain_adm' ),
				$prefix . "answer"   => __( 'Answer', 'lespaul_domain_adm' ),
				$prefix . "category" => __( 'Category', 'lespaul_domain_adm' ),
				"date"               => __( 'Date', 'lespaul_domain_adm' ),
				"author"             => __( 'Created by', 'lespaul_domain_adm' )
			);

			return $wm_faqCols;
		}
	} // /wm_faq_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_faq_cp_custom_column' ) ) {
		function wm_faq_cp_custom_column( $wm_faqCol ) {
			global $post;
			$prefix = 'wm_faq-';

			switch ( $wm_faqCol ) {
				case $prefix . "answer":

					echo '<em>' . wm_string_length( strip_tags( strip_shortcodes( get_the_excerpt() ) ), $words = 20, $more = '&hellip;' ) . '</em>';

				break;
				case $prefix . "category":

					$terms = get_the_terms( $post->ID , 'faq-category' );
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
	} // /wm_faq_cp_custom_column

?>