<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Custom taxonomies for custom posts
*
* CONTENT:
* - 1) Actions and filters
* - 2) Taxonomies function
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering taxonomies
		add_action( 'init', 'wm_create_taxonomies', 0 );
		/*
		The init action occurs after the theme's functions file has been included, so if you're looking for terms directly in the functions file, you're doing so before they've actually been registered.
		*/





/*
*****************************************************
*      2) TAXONOMIES FUNCTION
*****************************************************
*/
	/*
	* Custom taxonomies registration
	*/
	if ( ! function_exists( 'wm_create_taxonomies' ) ) {
		function wm_create_taxonomies() {
			$slugProjectCategory = ( wm_option( 'cp-permalink-project-category' ) ) ? ( wm_option( 'cp-permalink-project-category' ) ) : ( 'project/category' );
			$slugProjectType     = ( wm_option( 'cp-permalink-project-type' ) ) ? ( wm_option( 'cp-permalink-project-type' ) ) : ( 'project/type' );
			$slugStaffDepartment = ( wm_option( 'cp-permalink-staff-department' ) ) ? ( wm_option( 'cp-permalink-staff-department' ) ) : ( 'staff/department' );

			//Projects categories
			if ( 'disable' != wm_option( 'cp-role-projects' ) ) {
				register_taxonomy( 'project-category', 'wm_projects', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'project-category',
					'rewrite'           => array( 'slug' => $slugProjectCategory ),
					'labels'            => array(
						'name'          => __( 'Project categories', 'lespaul_domain_adm' ),
						'singular_name' => __( 'Project category', 'lespaul_domain_adm' ),
						'search_items'  => __( 'Search categories', 'lespaul_domain_adm' ),
						'all_items'     => __( 'All categories', 'lespaul_domain_adm' ),
						'parent_item'   => __( 'Parent category', 'lespaul_domain_adm' ),
						'edit_item'     => __( 'Edit category', 'lespaul_domain_adm' ),
						'update_item'   => __( 'Update category', 'lespaul_domain_adm' ),
						'add_new_item'  => __( 'Add new category', 'lespaul_domain_adm' ),
						'new_item_name' => __( 'New category title', 'lespaul_domain_adm' )
					)
				) );
				register_taxonomy( 'project-type', 'wm_projects', array(
					'hierarchical'      => false,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'project-type',
					'rewrite'           => array( 'slug' => $slugProjectType ),
					'labels'            => array(
						'name'          => __( 'Project types', 'lespaul_domain_adm' ),
						'singular_name' => __( 'Project type', 'lespaul_domain_adm' ),
						'search_items'  => __( 'Search types', 'lespaul_domain_adm' ),
						'all_items'     => __( 'All types', 'lespaul_domain_adm' ),
						'parent_item'   => __( 'Parent type', 'lespaul_domain_adm' ),
						'edit_item'     => __( 'Edit type', 'lespaul_domain_adm' ),
						'update_item'   => __( 'Update type', 'lespaul_domain_adm' ),
						'add_new_item'  => __( 'Add new type', 'lespaul_domain_adm' ),
						'new_item_name' => __( 'New type title', 'lespaul_domain_adm' )
					)
				) );
			}

			//Staff departments
			if ( 'disable' != wm_option( 'cp-role-staff' ) )
				register_taxonomy( 'department', 'wm_staff', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'department',
					'rewrite'           => array( 'slug' => $slugStaffDepartment ),
					'labels'            => array(
						'name'          => __( 'Departments', 'lespaul_domain_adm' ),
						'singular_name' => __( 'Department', 'lespaul_domain_adm' ),
						'search_items'  => __( 'Search departments', 'lespaul_domain_adm' ),
						'all_items'     => __( 'All departments', 'lespaul_domain_adm' ),
						'parent_item'   => __( 'Parent department', 'lespaul_domain_adm' ),
						'edit_item'     => __( 'Edit department', 'lespaul_domain_adm' ),
						'update_item'   => __( 'Update department', 'lespaul_domain_adm' ),
						'add_new_item'  => __( 'Add new department', 'lespaul_domain_adm' ),
						'new_item_name' => __( 'New department title', 'lespaul_domain_adm' )
					)
				) );

			//Price tables
			if ( 'disable' != wm_option( 'cp-role-prices' ) )
				register_taxonomy( 'price-table', 'wm_price', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'price-table',
					'rewrite'           => array( 'slug' => 'price-table' ),
					'labels'            => array(
						'name'          => __( 'Price tables', 'lespaul_domain_adm' ),
						'singular_name' => __( 'Price table', 'lespaul_domain_adm' ),
						'search_items'  => __( 'Search price table', 'lespaul_domain_adm' ),
						'all_items'     => __( 'All price tables', 'lespaul_domain_adm' ),
						'parent_item'   => __( 'Parent price table', 'lespaul_domain_adm' ),
						'edit_item'     => __( 'Edit price table', 'lespaul_domain_adm' ),
						'update_item'   => __( 'Update price table', 'lespaul_domain_adm' ),
						'add_new_item'  => __( 'Add new price table', 'lespaul_domain_adm' ),
						'new_item_name' => __( 'New price table title', 'lespaul_domain_adm' )
					)
				) );

			//FAQ categories
			if ( 'disable' != wm_option( 'cp-role-faq' ) )
				register_taxonomy( 'faq-category', 'wm_faq', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'faq-category',
					'rewrite'           => array( 'slug' => 'faq-category' ),
					'labels'            => array(
						'name'          => __( 'FAQ categories', 'lespaul_domain_adm' ),
						'singular_name' => __( 'FAQ category', 'lespaul_domain_adm' ),
						'search_items'  => __( 'Search FAQ category', 'lespaul_domain_adm' ),
						'all_items'     => __( 'All FAQ categories', 'lespaul_domain_adm' ),
						'parent_item'   => __( 'Parent FAQ category', 'lespaul_domain_adm' ),
						'edit_item'     => __( 'Edit FAQ category', 'lespaul_domain_adm' ),
						'update_item'   => __( 'Update FAQ category', 'lespaul_domain_adm' ),
						'add_new_item'  => __( 'Add new FAQ category', 'lespaul_domain_adm' ),
						'new_item_name' => __( 'New FAQ category title', 'lespaul_domain_adm' )
					)
				) );

			//Logos categories
			if ( 'disable' != wm_option( 'cp-role-logos' ) )
				register_taxonomy( 'logos-category', 'wm_logos', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'logos-category',
					'rewrite'           => array( 'slug' => 'logo-category' ),
					'labels'            => array(
						'name'          => __( 'Categories', 'lespaul_domain_adm' ),
						'singular_name' => __( 'Category', 'lespaul_domain_adm' ),
						'search_items'  => __( 'Search category', 'lespaul_domain_adm' ),
						'all_items'     => __( 'All categories', 'lespaul_domain_adm' ),
						'parent_item'   => __( 'Parent category', 'lespaul_domain_adm' ),
						'edit_item'     => __( 'Edit category', 'lespaul_domain_adm' ),
						'update_item'   => __( 'Update category', 'lespaul_domain_adm' ),
						'add_new_item'  => __( 'Add new category', 'lespaul_domain_adm' ),
						'new_item_name' => __( 'New category title', 'lespaul_domain_adm' )
					)
				) );

			//Content module tags
			register_taxonomy( 'content-module-tag', 'wm_modules', array(
				'hierarchical'      => false,
				'show_in_nav_menus' => false,
				'show_ui'           => true,
				'query_var'         => 'cmtag',
				'rewrite'           => array( 'slug' => 'cmtag' ),
				'labels'            => array(
					'name'          => __( 'Tags', 'lespaul_domain_adm' ),
					'singular_name' => __( 'Tag', 'lespaul_domain_adm' ),
					'search_items'  => __( 'Search tags', 'lespaul_domain_adm' ),
					'all_items'     => __( 'All tags', 'lespaul_domain_adm' ),
					'edit_item'     => __( 'Edit tag', 'lespaul_domain_adm' ),
					'update_item'   => __( 'Update tag', 'lespaul_domain_adm' ),
					'add_new_item'  => __( 'Add new tag', 'lespaul_domain_adm' ),
					'new_item_name' => __( 'New tag title', 'lespaul_domain_adm' )
				)
			) );
		}
	} // /wm_create_taxonomies

?>