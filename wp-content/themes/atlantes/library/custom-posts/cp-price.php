<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Price tables custom post
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
		add_action( 'init', 'wm_price_cp_init' );
		//CP list table columns
		add_action( 'manage_wm_price_posts_custom_column', 'wm_price_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_price_columns', 'wm_price_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_price_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_price_cp_init' ) ) {
		function wm_price_cp_init() {
			global $cpMenuPosition;

			$role = ( wm_option( 'cp-role-pricing' ) ) ? ( wm_option( 'cp-role-pricing' ) ) : ( 'page' );
			$slug = ( wm_option( 'cp-permalink-price' ) ) ? ( wm_option( 'cp-permalink-price' ) ) : ( 'price' );

			$args = array(
				'query_var'           => 'price',
				'capability_type'     => $role,
				'public'              => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['prices'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-price.png',
				'supports'            => array( 'title', 'editor' ),
				'labels'              => array(
					'name'               => __( 'Prices', 'atlantes_domain_adm' ),
					'singular_name'      => __( 'Price', 'atlantes_domain_adm' ),
					'add_new'            => __( 'Add new price', 'atlantes_domain_adm' ),
					'add_new_item'       => __( 'Add new price', 'atlantes_domain_adm' ),
					'new_item'           => __( 'Add new price', 'atlantes_domain_adm' ),
					'edit_item'          => __( 'Edit price', 'atlantes_domain_adm' ),
					'view_item'          => __( 'View price', 'atlantes_domain_adm' ),
					'search_items'       => __( 'Search price', 'atlantes_domain_adm' ),
					'not_found'          => __( 'No price found', 'atlantes_domain_adm' ),
					'not_found_in_trash' => __( 'No price found in trash', 'atlantes_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_price' , $args );
		}
	} // /wm_price_cp_init





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
	if ( ! function_exists( 'wm_price_cp_messages' ) ) {
		function wm_price_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_price'] = array(
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
	} // /wm_price_cp_messages





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
	if ( ! function_exists( 'wm_price_cp_columns' ) ) {
		function wm_price_cp_columns( $wm_priceCols ) {
			$prefix = 'wm_price-';

			$wm_priceCols = array(
				//standard columns
				"cb"                 => '<input type="checkbox" />',
				"title"              => __( 'Price', 'atlantes_domain_adm' ),
				$prefix . "cost"     => __( 'Cost', 'atlantes_domain_adm' ),
				$prefix . "featured" => __( 'Featured', 'atlantes_domain_adm' ),
				$prefix . "color"    => __( 'Color', 'atlantes_domain_adm' ),
				$prefix . "table"    => __( 'Price table', 'atlantes_domain_adm' ),
				$prefix . "order"    => __( 'Order', 'atlantes_domain_adm' ),
				"date"               => __( 'Date', 'atlantes_domain_adm' ),
				"author"             => __( 'Created by', 'atlantes_domain_adm' )
			);

			return $wm_priceCols;
		}
	} // /wm_price_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_price_cp_custom_column' ) ) {
		function wm_price_cp_custom_column( $wm_priceCol ) {
			global $post;
			$prefix     = 'wm_price-';
			$prefixMeta = 'price-';

			switch ( $wm_priceCol ) {
				case $prefix . "cost":

					echo '<span style="font-size: 1.4em">' . stripslashes( wm_meta_option( $prefixMeta . 'cost' ) ) . '</span>';

				break;
				case $prefix . "featured":

					$wm_priceFeatured = ( ' featured' === wm_meta_option( $prefixMeta . 'style' ) ) ? ( '<span style="font-size:1.5em">&#x2713;</span>' ) : ( '' );

					echo $wm_priceFeatured;

				break;
				case $prefix . "color":

					$color = ( wm_meta_option( $prefixMeta . 'color' ) ) ? ( wm_meta_option( $prefixMeta . 'color', $post->ID, 'color' ) ) : ( '#eee' );

					edit_post_link( '<span class="color-display" style="background-color:' . $color . ';"></span>' );

				break;
				case $prefix . "table":

					$terms = get_the_terms( $post->ID , 'price-table' );
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				case $prefix . "order":

					if ( absint( wm_meta_option( $prefixMeta . 'order' ) ) )
						echo absint( wm_meta_option( $prefixMeta . 'order' ) );

				break;
				default:
				break;
			}
		}
	} // /wm_price_cp_custom_column

?>