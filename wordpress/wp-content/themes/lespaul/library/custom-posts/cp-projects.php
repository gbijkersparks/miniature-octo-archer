<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Projects custom post
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
		add_action( 'init', 'wm_projects_cp_init' );
		//CP list table columns
		add_action( 'manage_wm_projects_posts_custom_column', 'wm_projects_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_projects_columns', 'wm_projects_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_projects_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_projects_cp_init' ) ) {
		function wm_projects_cp_init() {
			global $cpMenuPosition;

			$role     = ( wm_option( 'cp-role-projects' ) ) ? ( wm_option( 'cp-role-projects' ) ) : ( 'post' );
			$slug     = ( wm_option( 'cp-permalink-project' ) ) ? ( wm_option( 'cp-permalink-project' ) ) : ( 'project' );
			$supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields' );

			if ( wm_option( 'cp-projects-revisions' ) )
				$supports[] = 'revisions';

			$args = array(
				'query_var'           => 'projects',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['projects'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/custom-posts/ico-portfolio.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Projects', 'lespaul_domain_adm' ),
					'singular_name'      => __( 'Project', 'lespaul_domain_adm' ),
					'add_new'            => __( 'Add new project', 'lespaul_domain_adm' ),
					'add_new_item'       => __( 'Add new project', 'lespaul_domain_adm' ),
					'new_item'           => __( 'Add new project', 'lespaul_domain_adm' ),
					'edit_item'          => __( 'Edit project', 'lespaul_domain_adm' ),
					'view_item'          => __( 'View project', 'lespaul_domain_adm' ),
					'search_items'       => __( 'Search projects', 'lespaul_domain_adm' ),
					'not_found'          => __( 'No project found', 'lespaul_domain_adm' ),
					'not_found_in_trash' => __( 'No project found in trash', 'lespaul_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_projects' , $args );
		}
	} // /wm_projects_cp_init





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
	if ( ! function_exists( 'wm_projects_cp_messages' ) ) {
		function wm_projects_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_projects'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => sprintf(
					__( 'Project updated. <a href="%s">View project</a>', 'lespaul_domain_adm' ),
					esc_url( get_permalink( $post_ID ) )
					),
				2  => __( 'Custom field updated.', 'lespaul_domain_adm' ),
				3  => __( 'Custom field deleted.', 'lespaul_domain_adm' ),
				4  => __( 'Project updated.', 'lespaul_domain_adm' ),
				5  => ( isset( $_GET['revision'] ) ) ? ( sprintf(
					__( 'Project restored to revision from %s', 'lespaul_domain_adm' ),
						wp_post_revision_title( (int) $_GET['revision'], false )
					) ) : ( false ),
				6  => sprintf(
					__( 'Project published. <a href="%s">View project</a>', 'lespaul_domain_adm' ),
						esc_url( get_permalink($post_ID) )
					),
				7  => __( 'Project saved.', 'lespaul_domain_adm' ),
				8  => sprintf(
					__( 'Project submitted. <a target="_blank" href="%s">Preview project</a>', 'lespaul_domain_adm' ),
						esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) )
					),
				9  => sprintf(
					__( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', 'lespaul_domain_adm' ),
						get_the_date() . ', ' . get_the_time(),
						esc_url( get_permalink( $post_ID ) )
					),
				10 => sprintf(
					__( 'Project draft updated. <a target="_blank" href="%s">Preview project</a>', 'lespaul_domain_adm' ),
						esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) )
					),
				);

			return $messages;
		}
	} // /wm_projects_cp_messages





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
	if ( ! function_exists( 'wm_projects_cp_columns' ) ) {
		function wm_projects_cp_columns( $wm_projectsCols ) {
			$prefix = 'wm_projects-';

			$wm_projectsCols = array(
				//standard columns
				"cb"                 => '<input type="checkbox" />',
				$prefix . "thumb"    => __( 'Image', 'lespaul_domain_adm' ),
				"title"              => __( 'Project', 'lespaul_domain_adm' ),
				$prefix . "category" => __( 'Category', 'lespaul_domain_adm' ),
				$prefix . "link"     => __( 'Custom link', 'lespaul_domain_adm' ),
				"date"               => __( 'Date', 'lespaul_domain_adm' ),
				"author"             => __( 'Created by', 'lespaul_domain_adm' ),
				$prefix . "layout"   => __( 'Layout', 'lespaul_domain_adm' )
			);

			return $wm_projectsCols;
		}
	} // /wm_projects_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_projects_cp_custom_column' ) ) {
		function wm_projects_cp_custom_column( $wm_projectsCol ) {
			global $post;
			$prefix     = 'wm_projects-';
			$prefixMeta = 'project-';

			switch ( $wm_projectsCol ) {
				case $prefix . "type":

				break;
				case $prefix . "category":

					$terms = get_the_terms( $post->ID , 'project-category' );
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				case $prefix . "thumb":

					$icon = '';
					$projectIcons = array();
					$terms = get_terms( 'project-type', 'orderby=name&hide_empty=0&hierarchical=0' );
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						foreach ( $terms as $term ) {
							$meta = get_option( 'wm-tax_project-type-' . $term->term_id );
							$projectIcons[$meta['type'] . '[' . $term->slug . ']'] = $meta['icon'];
						}
					}
					if ( empty( $projectIcons ) )
						$projectIcons = array(
								'static-project' => 'wmicon-image',
								'slider-project' => 'wmicon-gallery',
								'video-project'  => 'wmicon-video',
								'audio-project'  => 'wmicon-audio',
							);

					$icon = ( ! wm_meta_option( $prefixMeta . 'type' ) || ! isset( $projectIcons[wm_meta_option( $prefixMeta . 'type' )] ) ) ? ( '<i class="icon wmicon-image"></i>' ) :  ( '<i class="icon ' . $projectIcons[wm_meta_option( $prefixMeta . 'type' )] . '"></i>' );

					$size = explode( 'x', WM_ADMIN_LIST_THUMB );
					$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, 'widget' ) ) : ( '' );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					echo $icon . '<span class="wm-image-container' . $hasThumb . '">';

					if ( get_edit_post_link() )
						edit_post_link( $image );
					else
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';

					echo '</span>';

				break;
				case $prefix . "link":

					$wm_projectsLink = esc_url( stripslashes( wm_meta_option( $prefixMeta . 'link' ) ) );
					echo '<a href="' . $wm_projectsLink . '" target="_blank">' . $wm_projectsLink . '</a>';

				break;
				case $prefix . "layout":

					$layout = ( 'plain' === wm_meta_option( $prefixMeta . 'single-layout' ) ) ? ( __( 'Post', 'lespaul_domain_adm' ) ) : ( __( 'Project', 'lespaul_domain_adm' ) );
					edit_post_link( $layout );

				break;
				default:
				break;
			}
		}
	} // /wm_projects_cp_custom_column

?>