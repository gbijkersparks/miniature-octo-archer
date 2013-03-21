<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* WebMan Shortcodes Generator
*
* CONTENT:
* - 1) Actions and filters
* - 2) Assets needed
* - 3) TinyMCE button registration
* - 4) Shortcodes array
* - 5) Shortcode generator HTML
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		$wmGeneratorIncludes = array( 'post.php', 'post-new.php' );
		if ( in_array( $pagenow, $wmGeneratorIncludes ) ) {
			add_action( 'admin_enqueue_scripts', 'wm_mce_assets', 1000 );
			add_action( 'init', 'wm_shortcode_generator_button' );
			add_action( 'admin_footer', 'wm_add_generator_popup', 1000 );
		}





/*
*****************************************************
*      2) ASSETS NEEDED
*****************************************************
*/
	/*
	* Assets files
	*/
	if ( ! function_exists( 'wm_mce_assets' ) ) {
		function wm_mce_assets() {
			global $pagenow;

			$wmGeneratorIncludes = array( 'post.php', 'post-new.php' );

			if ( in_array( $pagenow, $wmGeneratorIncludes ) ) {
				//styles
				wp_enqueue_style( 'wm-buttons' );

				//scripts
				wp_enqueue_script( 'wm-shortcodes' );
			}
		}
	} // /wm_mce_assets





/*
*****************************************************
*      3) TINYMCE BUTTON REGISTRATION
*****************************************************
*/
	/*
	* Register visual editor custom button position
	*/
	if ( ! function_exists( 'wm_register_tinymce_buttons' ) ) {
		function wm_register_tinymce_buttons( $buttons ) {
			$wmButtons = array( '|', 'wm_mce_button_line_above', 'wm_mce_button_line_below', '|', 'wm_mce_button_shortcodes' );

			array_push( $buttons, implode( ',', $wmButtons ) );

			return $buttons;
		}
	} // /wm_register_tinymce_buttons



	/*
	* Register the button functionality script
	*/
	if ( ! function_exists( 'wm_add_tinymce_plugin' ) ) {
		function wm_add_tinymce_plugin( $plugin_array ) {
			$plugin_array['wm_mce_button'] = WM_ASSETS_ADMIN . 'js/shortcodes/wm-mce-button.js?ver=' . WM_SCRIPTS_VERSION;

			return $plugin_array;
		}
	} // /wm_add_tinymce_plugin



	/*
	* Adding the button to visual editor
	*/
	if ( ! function_exists( 'wm_shortcode_generator_button' ) ) {
		function wm_shortcode_generator_button() {
			if ( ! ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) )
				return;

			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				//filter the tinymce buttons and add custom ones
				add_filter( 'mce_external_plugins', 'wm_add_tinymce_plugin' );
				add_filter( 'mce_buttons_2', 'wm_register_tinymce_buttons' );
			}
		}
	} // /wm_shortcode_generator_button





/*
*****************************************************
*      4) SHORTCODES ARRAY
*****************************************************
*/
	/*
	* Shortcodes settings for Shortcode Generator
	*/
	if ( ! function_exists( 'wm_shortcode_generator_tabs' ) ) {
		function wm_shortcode_generator_tabs() {
			global $socialIconsArray;

			$fontFile  = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
			$fontIcons = wm_fontello_classes( $fontFile );

			//Get Content Module posts
			$wm_modules_posts = get_posts( array(
				'post_type'   => 'wm_modules',
				'order'       => 'ASC',
				'orderby'     => 'title',
				'numberposts' => -1,
				) );
			$modulePosts = array( '' => '' );
			foreach ( $wm_modules_posts as $post ) {
				$modulePosts[$post->post_name] = $post->post_title;

				$terms = get_the_terms( $post->ID , 'content-module-tag' );
				if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
					$moduleTags = array();
					foreach ( $terms as $term ) {
						if ( isset( $term->name ) )
							$moduleTags[] = $term->name;
					}
					$modulePosts[$post->post_name] .= sprintf( __( ' (tags: %s)', 'lespaul_domain_adm' ), implode( ', ', $moduleTags ) );
				}
			}

			//Get icons
			$menuIcons = array();
			$menuIconsEmpty = array( '' => '' );
			foreach ( $fontIcons as $icon ) {
				$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
			}

			$wmShortcodeGeneratorTabs = array(

				//Accordion
					array(
						'id' => 'accordion',
						'name' => __( 'Accordion', 'lespaul_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[accordion_item title=""][/accordion_item]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[accordion][/accordion]</code> parent shortcode.', 'lespaul_domain_adm' ),
						'settings' => array(
							'auto' => array(
								'label' => __( 'Automatic accordion', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select whether the accordion should automatically animate', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[accordion{{auto}}] [accordion_item title="TEXT"]TEXT[/accordion_item] [/accordion]'
					),

				//Box
					array(
						'id' => 'box',
						'name' => __( 'Box', 'lespaul_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose box color', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'blue'   => __( 'Blue', 'lespaul_domain_adm' ),
									'gray'   => __( 'Gray', 'lespaul_domain_adm' ),
									'green'  => __( 'Green', 'lespaul_domain_adm' ),
									'orange' => __( 'Orange', 'lespaul_domain_adm' ),
									'red'    => __( 'Red', 'lespaul_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Icon', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose an icon for this box', 'lespaul_domain_adm' ),
								'value' => array(
									''         => __( 'No icon', 'lespaul_domain_adm' ),
									'cancel'   => __( 'Cancel icon', 'lespaul_domain_adm' ),
									'check'    => __( 'Check icon', 'lespaul_domain_adm' ),
									'info'     => __( 'Info icon', 'lespaul_domain_adm' ),
									'question' => __( 'Question icon', 'lespaul_domain_adm' ),
									'warning'  => __( 'Warning icon', 'lespaul_domain_adm' ),
									)
								),
							'title' => array(
								'label' => __( 'Optional title', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional box title', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'transparent' => array(
								'label' => __( 'Opacity', 'lespaul_domain_adm' ),
								'desc'  => __( 'Whether box background is colored or not', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Opaque', 'lespaul_domain_adm' ),
									'1' => __( 'Transparent', 'lespaul_domain_adm' ),
									)
								),
							'hero' => array(
								'label' => __( 'Hero box', 'lespaul_domain_adm' ),
								'desc'  => __( 'Specially styled hero box', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Normal box', 'lespaul_domain_adm' ),
									'1' => __( 'Hero box', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[box{{color}}{{title}}{{icon}}{{transparent}}{{hero}}]TEXT[/box]'
					),

				//Big text
					array(
						'id' => 'big_text',
						'name' => __( 'Big text', 'lespaul_domain_adm' ),
						'settings' => array(
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[big_text{{style}}]TEXT[/big_text]'
					),

				//Button
					array(
						'id' => 'button',
						'name' => __( 'Button', 'lespaul_domain_adm' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Link URL', 'lespaul_domain_adm' ),
								'desc'  => __( 'Button link URL address', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'color' => array(
								'label' => __( 'Color', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose button color', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'blue'   => __( 'Blue', 'lespaul_domain_adm' ),
									'gray'   => __( 'Gray', 'lespaul_domain_adm' ),
									'green'  => __( 'Green', 'lespaul_domain_adm' ),
									'orange' => __( 'Orange', 'lespaul_domain_adm' ),
									'red'    => __( 'Red', 'lespaul_domain_adm' ),
									)
								),
							'size' => array(
								'label' => __( 'Size', 'lespaul_domain_adm' ),
								'desc'  => __( 'Button size', 'lespaul_domain_adm' ),
								'value' => array(
									'm'  => __( 'Medium', 'lespaul_domain_adm' ),
									's'  => __( 'Small', 'lespaul_domain_adm' ),
									'l'  => __( 'Large', 'lespaul_domain_adm' ),
									'xl' => __( 'Extra large', 'lespaul_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Align', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									'left'  => __( 'Left', 'lespaul_domain_adm' ),
									'right' => __( 'Right', 'lespaul_domain_adm' ),
									)
								),
							'new_window' => array(
								'label' => __( 'New window', 'lespaul_domain_adm' ),
								'desc'  => __( 'Open URL address in new window when button clicked', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Icon image', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select optional button icon image', 'lespaul_domain_adm' ),
								'value' => array_merge( $menuIconsEmpty, $menuIcons ),
								'image-before' => true,
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							'id' => array(
								'label' => __( 'Optional HTML "id" parameter', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional HTML "id" parameter for additional custom styling or JavaScript actions.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[button{{url}}{{color}}{{size}}{{style}}{{align}}{{new_window}}{{icon}}{{id}}]TEXT[/button]'
					),

				//Call to action
					array(
						'id' => 'cta',
						'name' => __( 'Call to action', 'lespaul_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Optional title', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional call to action title', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'subtitle' => array(
								'label' => __( 'Optional subtitle', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional call to action subtitle', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'button_url' => array(
								'label' => __( 'Button URL', 'lespaul_domain_adm' ),
								'desc'  => __( 'Button link URL address', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'button_text' => array(
								'label' => __( 'Button text', 'lespaul_domain_adm' ),
								'desc'  => __( 'Button text', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'button_color' => array(
								'label' => __( 'Button color', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose button color', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'blue'   => __( 'Blue', 'lespaul_domain_adm' ),
									'gray'   => __( 'Gray', 'lespaul_domain_adm' ),
									'green'  => __( 'Green', 'lespaul_domain_adm' ),
									'orange' => __( 'Orange', 'lespaul_domain_adm' ),
									'red'    => __( 'Red', 'lespaul_domain_adm' ),
									)
								),
							'new_window' => array(
								'label' => __( 'New window', 'lespaul_domain_adm' ),
								'desc'  => __( 'Open URL address in new window when button clicked', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							'color' => array(
								'label' => __( 'Area color', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose call to action area color', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Transparent', 'lespaul_domain_adm' ),
									'blue'   => __( 'Blue', 'lespaul_domain_adm' ),
									'gray'   => __( 'Gray', 'lespaul_domain_adm' ),
									'green'  => __( 'Green', 'lespaul_domain_adm' ),
									'orange' => __( 'Orange', 'lespaul_domain_adm' ),
									'red'    => __( 'Red', 'lespaul_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[call_to_action{{title}}{{subtitle}}{{button_text}}{{button_url}}{{button_color}}{{new_window}}{{color}}{{style}}]TEXT[/call_to_action]'
					),

				//Columns
					array(
						'id' => 'columns',
						'name' => __( 'Columns', 'lespaul_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Column size', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select column size', 'lespaul_domain_adm' ),
								'value' => array(
									'1OPTGROUP'   =>  __( 'Halfs', 'lespaul_domain_adm' ),
										'1/2'      => '1/2',
										'1/2 last' => '1/2' . __( ' last in row', 'lespaul_domain_adm' ),
									'1/OPTGROUP'  => '',
									'2OPTGROUP'   =>  __( 'Thirds', 'lespaul_domain_adm' ),
										'1/3'      => '1/3',
										'1/3 last' => '1/3' . __( ' last in row', 'lespaul_domain_adm' ),
										'2/3'      => '2/3',
										'2/3 last' => '2/3' . __( ' last in row', 'lespaul_domain_adm' ),
									'2/OPTGROUP'  => '',
									'3OPTGROUP'   =>  __( 'Quarters', 'lespaul_domain_adm' ),
										'1/4'      => '1/4',
										'1/4 last' => '1/4' . __( ' last in row', 'lespaul_domain_adm' ),
										'3/4'      => '3/4',
										'3/4 last' => '3/4' . __( ' last in row', 'lespaul_domain_adm' ),
									'3/OPTGROUP'  => '',
									'4OPTGROUP'   =>  __( 'Fifths', 'lespaul_domain_adm' ),
										'1/5'      => '1/5',
										'1/5 last' => '1/5' . __( ' last in row', 'lespaul_domain_adm' ),
										'2/5'      => '2/5',
										'2/5 last' => '2/5' . __( ' last in row', 'lespaul_domain_adm' ),
										'3/5'      => '3/5',
										'3/5 last' => '3/5' . __( ' last in row', 'lespaul_domain_adm' ),
										'4/5'      => '4/5',
										'4/5 last' => '4/5' . __( ' last in row', 'lespaul_domain_adm' ),
									'4/OPTGROUP'  => '',
									)
								),
							),
						'output-shortcode' => '[column{{size}}]TEXT[/column]'
					),

				//Content Modules
					array(
						'id' => 'content_module',
						'name' => __( 'Content Module', 'lespaul_domain_adm' ),
						'settings' => array(
							'module' => array(
								'label' => __( 'Content Module', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select Content Module to display', 'lespaul_domain_adm' ),
								'value' => $modulePosts
								),
							'randomize' => array(
								'label' => __( 'Or randomize from', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a tag from where random content module will be chosen', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => '',
										'allText'      => __( 'Select tag', 'lespaul_domain_adm' ),
										'hierarchical' => '0',
										'tax'          => 'content-module-tag',
									) )
								),
							'no_thumb' => array(
								'label' => __( 'Thumb', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select whether you want the thumbnail image to be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Show', 'lespaul_domain_adm' ),
									'1' => __( 'Hide', 'lespaul_domain_adm' )
									)
								),
							'no_title' => array(
								'label' => __( 'Title', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select whether you want the module title to be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Show', 'lespaul_domain_adm' ),
									'1' => __( 'Hide', 'lespaul_domain_adm' )
									)
								),
							'layout' => array(
								'label' => __( 'Layout', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose which layout to use', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'center' => __( 'Centered', 'lespaul_domain_adm' )
									)
								),
							),
						'output-shortcode' => '[content_module{{module}}{{randomize}}{{no_thumb}}{{no_title}}{{layout}} /]'
					),

				//Countdown timer
					array(
						'id' => 'countdown',
						'name' => __( 'Countdown timer', 'lespaul_domain_adm' ),
						'settings' => array(
							'time' => array(
								'label' => __( 'Time <small>YYYY-MM-DD HH:mm</small>', 'lespaul_domain_adm' ),
								'desc'  => __( 'Insert the time in "YYYY-MM-DD HH:mm" format (Y = year, M = month, D = day, H = hours, m = minutes)', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'size' => array(
								'label' => __( 'Timer size', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select timer size', 'lespaul_domain_adm' ),
								'value' => array(
									'xl' => __( 'Extra large', 'lespaul_domain_adm' ),
									'l'  => __( 'Large', 'lespaul_domain_adm' ),
									'm'  => __( 'Medium', 'lespaul_domain_adm' ),
									's'  => __( 'Small', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[countdown{{time}}{{size}} /]'
					),

				//Divider
					array(
						'id' => 'divider',
						'name' => __( 'Divider', 'lespaul_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Type of divider', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''              => __( 'Default divider', 'lespaul_domain_adm' ),
									'dashed'        => __( 'Dashed border', 'lespaul_domain_adm' ),
									'diagonal'      => __( 'Diagonal stripes border', 'lespaul_domain_adm' ),
									'dotted'        => __( 'Dotted border', 'lespaul_domain_adm' ),
									'fading'        => __( 'Fading on sides', 'lespaul_domain_adm' ),
									'star'          => __( 'Double border with star in the middle', 'lespaul_domain_adm' ),
									'shadow-top'    => __( 'Shadow top', 'lespaul_domain_adm' ),
									'shadow-bottom' => __( 'Shadow bottom', 'lespaul_domain_adm' ),
									'plain'         => __( 'No border (usefull to create a space)', 'lespaul_domain_adm' ),
									)
								),
							'space_before' => array(
								'label' => __( 'Space before divider', 'lespaul_domain_adm' ),
								'desc'  => __( 'Top margin. Insert only number.', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'space_after' => array(
								'label' => __( 'Space after divider', 'lespaul_domain_adm' ),
								'desc'  => __( 'Bottom margin. Insert only number.', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'opacity' => array(
								'label' => __( 'Opacity', 'lespaul_domain_adm' ),
								'desc'  => __( 'Percentual value of divider opacity - 0 = transparent, 100 = opaque', 'lespaul_domain_adm' ),
								'value' => array(
									''    => __( 'Default', 'lespaul_domain_adm' ),
									'5'  => 5,
									'10' => 10,
									'15' => 15,
									'20' => 20,
									'25' => __( '25 = default value', 'lespaul_domain_adm' ),
									'30' => 30,
									'35' => 35,
									'40' => 40,
									'45' => 45,
									'50' => 50,
									'55' => 55,
									'60' => 60,
									'65' => 65,
									'70' => 70,
									'75' => 75,
									'80' => 80,
									'85' => 85,
									'90' => 90,
									'95' => 95,
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[divider{{type}}{{space_before}}{{space_after}}{{opacity}}{{style}} /]'
					),

				//Dropcaps
					array(
						'id' => 'dropcaps',
						'name' => __( 'Dropcaps', 'lespaul_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Dropcap type', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select prefered dropcap styling', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Basic dropcap', 'lespaul_domain_adm' ),
									'round'  => __( 'Rounded dropcap', 'lespaul_domain_adm' ),
									'square' => __( 'Squared dropcap', 'lespaul_domain_adm' ),
									'leaf'   => __( 'Leaf dropcap', 'lespaul_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[dropcap{{type}}{{style}}]A[/dropcap]'
					),

				//FAQ
					'faq' => array(
						'id' => 'faq',
						'name' => __( 'FAQ', 'lespaul_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'lespaul_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'FAQ category', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_faq',
										'allText'      => __( 'All FAQs', 'lespaul_domain_adm' ),
										'tax'          => 'faq-category',
									) )
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'name'   => __( 'By name', 'lespaul_domain_adm' ),
									'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
									'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
									'random' => __( 'Randomly', 'lespaul_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Description text alignement (when used - it will disable the filter)', 'lespaul_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
									'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[faq{{category}}{{order}}{{align}}][/faq]'
					),

				//Gallery
					array(
						'id' => 'gallery',
						'name' => __( 'Gallery', 'lespaul_domain_adm' ),
						'desc' => __( 'Please upload images for the post/page gallery via "Add Media" button above visual editor.', 'lespaul_domain_adm' ),
						'settings' => array(
							'columns' => array(
								'label' => __( 'Columns', 'lespaul_domain_adm' ),
								'desc'  => __( 'Number of gallery columns', 'lespaul_domain_adm' ),
								'value' => array(
									1 => 1,
									2 => 2,
									3 => 3,
									4 => 4,
									5 => 5,
									6 => 6,
									7 => 7,
									8 => 8,
									9 => 9,
									)
								),
							'flexible' => array(
								'label' => __( 'Flexibile layout', 'lespaul_domain_adm' ),
								'desc'  => __( 'Preserves images aspect ratio and uses masonry display', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							'frame' => array(
								'label' => __( 'Framed', 'lespaul_domain_adm' ),
								'desc'  => __( 'Display frame around images', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							'remove' => array(
								'label' => __( 'Remove', 'lespaul_domain_adm' ),
								'desc'  => __( 'Image order numbers separated with commas (like "1,2,5" will remove first, second and fifth image from gallery)', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'sardine' => array(
								'label' => __( 'Sardine', 'lespaul_domain_adm' ),
								'desc'  => __( 'Removes margins around images', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[gallery{{columns}}{{flexible}}{{frame}}{{remove}}{{sardine}} /]'
					),

				//Huge text
					array(
						'id' => 'huge_text',
						'name' => __( 'Huge text', 'lespaul_domain_adm' ),
						'settings' => array(
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[huge_text{{style}}]TEXT[/huge_text]'
					),

				//Icons
					array(
						'id' => 'icon',
						'name' => __( 'Icons', 'lespaul_domain_adm' ),
						'desc' => __( 'Only predefined icons included in icon font can be displayed with this shortcode.', 'lespaul_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Icon type', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select one of predefined icons', 'lespaul_domain_adm' ),
								'value' => $menuIcons,
								'image-before' => true,
								),
							'size' => array(
								'label' => __( 'Icon size in pixels', 'lespaul_domain_adm' ),
								'desc'  => __( 'Insert just a number', 'lespaul_domain_adm' ),
								'value' => '',
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[icon{{type}}{{size}}{{style}} /]'
					),

				//Lists
					array(
						'id' => 'lists',
						'name' => __( 'Lists', 'lespaul_domain_adm' ),
						'settings' => array(
							'bullet' => array(
								'label' => __( 'Bullet type', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select list bullet type', 'lespaul_domain_adm' ),
								'value' => $menuIcons,
								'image-before' => true,
								),
							),
						'output-shortcode' => '[list{{bullet}}]' . __( 'Unordered list goes here', 'lespaul_domain_adm' ) . '[/list]'
					),

				//Last update
					array(
						'id' => 'lastupdate',
						'name' => __( 'Last update', 'lespaul_domain_adm' ),
						'desc' => __( 'Displays the date when most recent blog post or project was added.', 'lespaul_domain_adm' ),
						'settings' => array(
							'item' => array(
								'label' => __( 'Items to watch', 'lespaul_domain_adm' ),
								'desc'  => __( 'What item group will be watched for last update date', 'lespaul_domain_adm' ),
								'value' => array(
									''        => __( 'Blog posts', 'lespaul_domain_adm' ),
									'project' => __( 'Projects', 'lespaul_domain_adm' ),
									)
								),
							'format' => array(
								'label' => __( 'Date format', 'lespaul_domain_adm' ),
								'desc'  => "",
								'value' => array(
									get_option( 'date_format' ) => date( get_option( 'date_format' ) ),
									'F j, Y'                    => date( 'F j, Y' ),
									'M j, Y'                    => date( 'M j, Y' ),
									'jS F Y'                    => date( 'jS F Y' ),
									'jS M Y'                    => date( 'jS M Y' ),
									'j F Y'                     => date( 'j F Y' ),
									'j M Y'                     => date( 'j M Y' ),
									'j. n. Y'                   => date( 'j. n. Y' ),
									'j. F Y'                    => date( 'j. F Y' ),
									'j. M Y'                    => date( 'j. M Y' ),
									'Y/m/d'                     => date( 'Y/m/d' ),
									'm/d/Y'                     => date( 'm/d/Y' ),
									'd/m/Y'                     => date( 'd/m/Y' ),
									)
								),
							),
						'output-shortcode' => '[last_update{{format}}{{item}} /]'
					),

				//Login form
					array(
						'id' => 'login',
						'name' => __( 'Login form', 'lespaul_domain_adm' ),
						'settings' => array(
							'stay' => array(
								'label' => __( 'Redirection', 'lespaul_domain_adm' ),
								'desc'  => __( 'Where the user will be redirected to after successful log in', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Go to homepage', 'lespaul_domain_adm' ),
									'1' => __( 'Stay here', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[login{{stay}} /]'
					),

				//Logos
					'logos' => array(
						'id' => 'logos',
						'name' => __( 'Logos', 'lespaul_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'lespaul_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Logos category', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_logos',
										'allText'      => __( 'All logos', 'lespaul_domain_adm' ),
										'tax'          => 'logos-category',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'lespaul_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'lespaul_domain_adm' ),
									'3' => __( '3 columns', 'lespaul_domain_adm' ),
									'4' => __( '4 columns', 'lespaul_domain_adm' ),
									'5' => __( '5 columns', 'lespaul_domain_adm' ),
									'6' => __( '6 columns', 'lespaul_domain_adm' ),
									'7' => __( '7 columns', 'lespaul_domain_adm' ),
									'8' => __( '8 columns', 'lespaul_domain_adm' ),
									'9' => __( '9 columns', 'lespaul_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Logo count', 'lespaul_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'lespaul_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'name'   => __( 'By name', 'lespaul_domain_adm' ),
									'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
									'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
									'random' => __( 'Randomly', 'lespaul_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'lespaul_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
									'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
									)
								),
							'scroll' => array(
								'label' => __( 'Horizontal scroll', 'lespaul_domain_adm' ),
								'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'scroll_stack' => array(
								'label' => __( 'Scroll method', 'lespaul_domain_adm' ),
								'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'One by one', 'lespaul_domain_adm' ),
									'1' => __( 'Stack', 'lespaul_domain_adm' ),
									)
								),
							'grayscale' => array(
								'label' => __( 'Grayscale', 'lespaul_domain_adm' ),
								'desc'  => __( 'By default logo images are grayscale, turn to color when mouse hovers', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Keep grayscale', 'lespaul_domain_adm' ),
									'0' => __( 'Turn off', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[logos{{category}}{{columns}}{{count}}{{order}}{{align}}{{grayscale}}{{scroll}}{{scroll_stack}}][/logos]'
					),

				//Marker
					array(
						'id' => 'marker',
						'name' => __( 'Marker', 'lespaul_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose marker color', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'blue'   => __( 'Blue', 'lespaul_domain_adm' ),
									'gray'   => __( 'Gray', 'lespaul_domain_adm' ),
									'green'  => __( 'Green', 'lespaul_domain_adm' ),
									'orange' => __( 'Orange', 'lespaul_domain_adm' ),
									'red'    => __( 'Red', 'lespaul_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[marker{{color}}{{style}}]TEXT[/marker]'
					),

				//Posts
					array(
						'id' => 'posts',
						'name' => __( 'Posts', 'lespaul_domain_adm' ),
						'desc' => __( 'Does not display Quote and Status posts. You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'lespaul_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Posts category', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
								'value' => wm_tax_array()
								),
							'columns' => array(
								'label' => __( 'Layout', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'lespaul_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'lespaul_domain_adm' ),
									'3' => __( '3 columns', 'lespaul_domain_adm' ),
									'4' => __( '4 columns', 'lespaul_domain_adm' ),
									'5' => __( '5 columns', 'lespaul_domain_adm' ),
									'6' => __( '6 columns', 'lespaul_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Posts count', 'lespaul_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'lespaul_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'excerpt_length' => array(
								'label' => __( 'Excerpt length', 'lespaul_domain_adm' ),
								'desc'  => __( 'In words', 'lespaul_domain_adm' ),
								'value' => array(
									''  => '',
									'0' => 0,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'name'   => __( 'By name', 'lespaul_domain_adm' ),
									'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
									'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
									'random' => __( 'Randomly', 'lespaul_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'lespaul_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
									'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
									)
								),
							'scroll' => array(
								'label' => __( 'Horizontal scroll', 'lespaul_domain_adm' ),
								'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'scroll_stack' => array(
								'label' => __( 'Scroll method', 'lespaul_domain_adm' ),
								'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'One by one', 'lespaul_domain_adm' ),
									'1' => __( 'Stack', 'lespaul_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'lespaul_domain_adm' ),
									'0' => __( 'No', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[posts{{category}}{{columns}}{{count}}{{excerpt_length}}{{order}}{{align}}{{thumb}}{{scroll}}{{scroll_stack}}][/posts]'
					),

				//Price table
					'prices' => array(
						'id' => 'price_table',
						'name' => __( 'Price Table', 'lespaul_domain_adm' ),
						'settings' => array(
							'table' => array(
								'label' => __( 'Select table', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select price table to display', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => '',
										'allText'      => __( 'Select price table', 'lespaul_domain_adm' ),
										'hierarchical' => '0',
										'tax'          => 'price-table',
									) )
								),
							),
						'output-shortcode' => '[prices{{table}} /]'
					),

				//Projects
					'projects' => array(
						'id' => 'projects',
						'name' => __( 'Projects', 'lespaul_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag. Filter will be disabled when scroll effect in use.', 'lespaul_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Projects category', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_projects',
										'allText'      => __( 'All projects', 'lespaul_domain_adm' ),
										'parentsOnly'  => true,
										'tax'          => 'project-category',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'lespaul_domain_adm' ),
								'value' => array(
									'1' => __( '1 column', 'lespaul_domain_adm' ),
									'2' => __( '2 columns', 'lespaul_domain_adm' ),
									'3' => __( '3 columns', 'lespaul_domain_adm' ),
									'4' => __( '4 columns', 'lespaul_domain_adm' ),
									'5' => __( '5 columns', 'lespaul_domain_adm' ),
									'6' => __( '6 columns', 'lespaul_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Projects count', 'lespaul_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'lespaul_domain_adm' ),
								'value' => array(
									'' => __( 'All projects (in category)', 'lespaul_domain_adm' ),
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'name'   => __( 'By name', 'lespaul_domain_adm' ),
									'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
									'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
									'random' => __( 'Randomly', 'lespaul_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'lespaul_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
									'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
									)
								),
							'filter' => array(
								'label' => __( 'Projects filter', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional projects filter', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'No filter', 'lespaul_domain_adm' ),
									'1' => __( 'Animated filtering', 'lespaul_domain_adm' ),
									)
								),
							'scroll' => array(
								'label' => __( 'Horizontal scroll', 'lespaul_domain_adm' ),
								'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_adm' ) . ' ' . __( 'Filter will be disabled when scroll in use.', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'scroll_stack' => array(
								'label' => __( 'Scroll method', 'lespaul_domain_adm' ),
								'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'One by one', 'lespaul_domain_adm' ),
									'1' => __( 'Stack', 'lespaul_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'lespaul_domain_adm' ),
									'0' => __( 'No', 'lespaul_domain_adm' ),
									)
								),
							'excerpt_length' => array(
								'label' => __( 'Excerpt words count', 'lespaul_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[projects{{align}}{{filter}}{{columns}}{{count}}{{category}}{{order}}{{thumb}}{{scroll}}{{excerpt_length}}{{scroll_stack}}][/projects]'
					),

				//Project attributes
					'projectAtts' => array(
						'id' => 'project_attributes',
						'name' => __( 'Project attributes', 'lespaul_domain_adm' ),
						'desc' => __( 'Use on project page only. Displays table of project attributes.', 'lespaul_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Title', 'lespaul_domain_adm' ),
								'desc'  => __( 'Attributes table title', 'lespaul_domain_adm' ),
								'value' => ''
								)
							),
						'output-shortcode' => '[project_attributes{{title}} /]'
					),

				//Pullquote
					array(
						'id' => 'pullquote',
						'name' => __( 'Pullquote', 'lespaul_domain_adm' ),
						'settings' => array(
							'align' => array(
								'label' => __( 'Align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose pullquote alignment', 'lespaul_domain_adm' ),
								'value' => array(
									'left'  => __( 'Left', 'lespaul_domain_adm' ),
									'right' => __( 'Right', 'lespaul_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[pullquote{{align}}{{style}}]TEXT[/pullquote]'
					),

				//Raw / pre
					array(
						'id' => 'raw',
						'name' => __( 'Raw preformated text', 'lespaul_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'lespaul_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[raw]TEXT[/raw]'
					),

				//Screen
					array(
						'id' => 'screen',
						'name' => __( 'Screen', 'lespaul_domain_adm' ),
						'desc' => __( 'This shortcode will display content on specific screen sizes only.', 'lespaul_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Screen size', 'lespaul_domain_adm' ),
								'value' => array(
									'desktop'             => __( 'Desktop', 'lespaul_domain_adm' ),
									'tablet'              => __( 'Tablet', 'lespaul_domain_adm' ),
									'min tablet'          => __( 'Minimum tablet', 'lespaul_domain_adm' ),
									'phone'               => __( 'Phone', 'lespaul_domain_adm' ),
									'phone landscape'     => __( 'Phone landscape', 'lespaul_domain_adm' ),
									'min phone landscape' => __( 'Minimum phone landscape', 'lespaul_domain_adm' ),
									'phone portrait'      => __( 'Phone portrait', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[screen{{size}}]TEXT[/screen]'
					),

				//Section
					array(
						'id' => 'section',
						'name' => __( 'Section', 'lespaul_domain_adm' ),
						'desc' => __( 'Use on "Sections" page template only! This will split the page into sections. You can set a custom CSS class and then style the sections individually. You can use "alt" class for alternative section styling.', 'lespaul_domain_adm' ),
						'settings' => array(
							'class' => array(
								'label' => __( 'Class', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional CSS class name', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[section{{class}}{{style}}]TEXT[/section]'
					),

				//Separator heading
					array(
						'id' => 'separator_heading',
						'name' => __( 'Separator heading', 'lespaul_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Heading size', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose one of HTML heading sizes', 'lespaul_domain_adm' ),
								'value' => array(
									'' => __( 'Default size (2)', 'lespaul_domain_adm' ),
									1  => 1,
									2  => 2,
									3  => 3,
									4  => 4,
									5  => 5,
									6  => 6,
									)
								),
							'align' => array(
								'label' => __( 'Align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose text alignment', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Left', 'lespaul_domain_adm' ),
									'center' => __( 'Center', 'lespaul_domain_adm' ),
									'right'  => __( 'Right', 'lespaul_domain_adm' ),
									)
								),
							'type' => array(
								'label' => __( 'Type / styling', 'lespaul_domain_adm' ),
								'desc'  => __( 'Choose separator heading styling', 'lespaul_domain_adm' ),
								'value' => array(
									''        => __( 'Default (uniform)', 'lespaul_domain_adm' ),
									'uniform' => __( 'Uniform - each heading is the same', 'lespaul_domain_adm' ),
									'normal'  => __( 'Normal - keeps heading styles', 'lespaul_domain_adm' ),
									)
								),
							'id' => array(
								'label' => __( 'Id attribute', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional HTML id attribute', 'lespaul_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[separator_heading{{size}}{{align}}{{type}}{{id}}]TEXT[/separator_heading]'
					),

				//Small text
					array(
						'id' => 'small_text',
						'name' => __( 'Small text', 'lespaul_domain_adm' ),
						'settings' => array(
							'style' => array(
								'label' => __( 'Optional CSS style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'lespaul_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[small_text{{style}}]TEXT[/small_text]'
					),

				//Social icons
					array(
						'id' => 'social',
						'name' => __( 'Social', 'lespaul_domain_adm' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Link URL', 'lespaul_domain_adm' ),
								'desc'  => __( 'Social icon link URL address', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'icon' => array(
								'label' => __( 'Icon', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select icon to be displayed', 'lespaul_domain_adm' ),
								'value' => array_combine( $socialIconsArray, $socialIconsArray )
								),
							'title' => array(
								'label' => __( 'Title text', 'lespaul_domain_adm' ),
								'desc'  => __( 'This text will be displayed when mouse hovers over the icon', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'size' => array(
								'label' => __( 'Icon size', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select icon size', 'lespaul_domain_adm' ),
								'value' => array(
									's'  => __( 'Small', 'lespaul_domain_adm' ),
									'm'  => __( 'Medium', 'lespaul_domain_adm' ),
									'l'  => __( 'Large', 'lespaul_domain_adm' ),
									'xl' => __( 'Extra large', 'lespaul_domain_adm' ),
									)
								),
							'rel' => array(
								'label' => __( 'Optional link relation', 'lespaul_domain_adm' ),
								'desc'  => __( 'This will set up the link "rel" HTML attribute', 'lespaul_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[social{{url}}{{icon}}{{title}}{{size}}{{rel}} /]'
					),

				//Staff
					'staff' => array(
						'id' => 'staff',
						'name' => __( 'Staff', 'lespaul_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'lespaul_domain_adm' ),
						'settings' => array(
							'department' => array(
								'label' => __( 'Department', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a department from where the list will be populated', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_staff',
										'allText'      => __( 'All staff', 'lespaul_domain_adm' ),
										'tax'          => 'department',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'lespaul_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'lespaul_domain_adm' ),
									'3' => __( '3 columns', 'lespaul_domain_adm' ),
									'4' => __( '4 columns', 'lespaul_domain_adm' ),
									'5' => __( '5 columns', 'lespaul_domain_adm' ),
									'6' => __( '6 columns', 'lespaul_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Staff count', 'lespaul_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'lespaul_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'lespaul_domain_adm' ),
									'name'   => __( 'By name', 'lespaul_domain_adm' ),
									'new'    => __( 'Newest first', 'lespaul_domain_adm' ),
									'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
									'random' => __( 'Randomly', 'lespaul_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'lespaul_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'lespaul_domain_adm' ),
									'right' => __( 'Description text on the right', 'lespaul_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'lespaul_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'lespaul_domain_adm' ),
									'0' => __( 'No', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[staff{{department}}{{columns}}{{count}}{{order}}{{align}}{{thumb}}][/staff]'
					),

				//Subpages
					array(
						'id' => 'subpages',
						'name' => __( 'Subpages', 'lespaul_domain_adm' ),
						'settings' => array(
							'depth' => array(
								'label' => __( 'Hierarchy levels', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select the depth of page hierarchy to display', 'lespaul_domain_adm' ),
								'value' => array(
									'0' => __( 'All levels', 'lespaul_domain_adm' ),
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									'menu'  => __( 'By menu order', 'lespaul_domain_adm' ),
									'title' => __( 'By title', 'lespaul_domain_adm' ),
									)
								),
							'parents' => array(
								'label' => __( 'Display parents?', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[subpages{{depth}}{{order}}{{parents}} /]'
					),

				//Table
					array(
						'id' => 'table',
						'name' => __( 'Table', 'lespaul_domain_adm' ),
						'desc' => __( 'For simple data tables use the shortcode below.', 'lespaul_domain_adm' ) . '<br />' . __( 'However, if you require more control over your table you can use sub-shortcodes for table row (<code>[trow][/trow]</code> or <code>[trow_alt][/trow_alt]</code> for alternatively styled table row), table cell (<code>[tcell][/tcell]</code>) and table heading cell (<code>[tcell_heading][/tcell_heading]</code>). All wrapped in <code>[table][/table]</code> parent shortcode.', 'lespaul_domain_adm' ),
						'settings' => array(
							'cols' => array(
								'label' => __( 'Heading row', 'lespaul_domain_adm' ),
								'desc'  => __( 'Titles of columns, separated with separator character. This is required to determine the number of columns for the table.', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'data' => array(
								'label' => __( 'Table data', 'lespaul_domain_adm' ),
								'desc'  => __( 'Table cells data separated with separator character. Will be automatically aligned into columns (depending on "Heading row" setting).', 'lespaul_domain_adm' ),
								'value' => ''
								),
							'separator' => array(
								'label' => __( 'Separator character', 'lespaul_domain_adm' ),
								'desc'  => __( 'Individual table cell data separator used in previous input fields', 'lespaul_domain_adm' ),
								'value' => ';'
								),
							'heading_col' => array(
								'label' => __( 'Heading column', 'lespaul_domain_adm' ),
								'desc'  => __( 'If you wish to display a whole column of the table as a heading, set its order number here', 'lespaul_domain_adm' ),
								'value' => array(
									''  => '',
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10
									)
								),
							'class' => array(
								'label' => __( 'CSS class', 'lespaul_domain_adm' ),
								'desc'  => __( 'Optional custom css class applied on the table HTML tag', 'lespaul_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[table{{class}}{{cols}}{{data}}{{separator}}{{heading_col}} /]'
					),

				//Tabs
					array(
						'id' => 'tabs',
						'name' => __( 'Tabs', 'lespaul_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[tab title="" icon=""][/tab]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[tabs][/tabs]</code> parent shortcode.', 'lespaul_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Tabs type', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select tabs styling', 'lespaul_domain_adm' ),
								'value' => array(
									''              => __( 'Normal tabs', 'lespaul_domain_adm' ),
									'fullwidth'     => __( 'Full width tabs', 'lespaul_domain_adm' ),
									'vertical'      => __( 'Vertical tabs', 'lespaul_domain_adm' ),
									'vertical tour' => __( 'Vertical tabs - tour', 'lespaul_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Tab icon', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select optional tab icon', 'lespaul_domain_adm' ),
								'value' => array_merge( $menuIconsEmpty, $menuIcons ),
								'image-before' => true,
								),
							),
						'output-shortcode' => '[tabs{{type}}] [tab title="TEXT"{{icon}}]TEXT[/tab] [/tabs]'
					),

				//Testimonials
					'testimonials' => array(
						'id' => 'testimonials',
						'name' => __( 'Testimonials', 'lespaul_domain_adm' ),
						'desc' => __( 'This shortcode will display Quote posts. If featured image of the post set, it will be used as quoted person photo (please upload square images only).', 'lespaul_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Category (required)', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'lespaul_domain_adm' ),
								'value' => wm_tax_array( array( 'all' => false ) )
								),
							'count' => array(
								'label' => __( 'Testimonials count', 'lespaul_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'lespaul_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'lespaul_domain_adm' ),
								'value' => array(
									''       => __( 'Newest first', 'lespaul_domain_adm' ),
									'old'    => __( 'Oldest first', 'lespaul_domain_adm' ),
									'random' => __( 'Randomly', 'lespaul_domain_adm' ),
									)
								),
							'speed' => array(
								'label' => __( 'Speed in seconds', 'lespaul_domain_adm' ),
								'desc'  => __( 'Time to display one testimonial in seconds', 'lespaul_domain_adm' ),
								'value' => array(
									''  => '',
									'3'  => 3,
									'4'  => 4,
									'5'  => 5,
									'6'  => 6,
									'7'  => 7,
									'8'  => 8,
									'9'  => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							/*
							'layout' => array(
								'label' => __( 'Layout', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => __( 'Normal', 'lespaul_domain_adm' ),
									'large' => __( 'Large', 'lespaul_domain_adm' ),
									)
								),
							*/
							'stack' => array(
								'label' => __( 'Animated stack count', 'lespaul_domain_adm' ),
								'desc'  => __( 'How many testimonials to display at once (use with animated testimonials only)', 'lespaul_domain_adm' ),
								'value' => array(
									'' => 1,
									2  => 2,
									3  => 3,
									4  => 4,
									)
								),
							'private' => array(
								'label' => __( 'Display private posts?', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[testimonials{{category}}{{count}}{{order}}{{speed}}{{stack}}{{private}} /]'
					),

				//Toggles
					array(
						'id' => 'toggles',
						'name' => __( 'Toggles', 'lespaul_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Toggle title', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => ''
								),
							'open' => array(
								'label' => __( 'Open by default?', 'lespaul_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'lespaul_domain_adm' ),
									'1' => __( 'Yes', 'lespaul_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[toggle{{title}}{{open}}]TEXT[/toggle]'
					),

				//Uppercase text
					array(
						'id' => 'uppercase',
						'name' => __( 'Uppercase text', 'lespaul_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'lespaul_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[uppercase]TEXT[/uppercase]'
					),

				//Videos
					array(
						'id' => 'video',
						'name' => __( 'Video', 'lespaul_domain_adm' ),
						'desc' => sprintf( __( '<a%s>Supported video portals</a> and Screenr videos.', 'lespaul_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Video URL', 'lespaul_domain_adm' ),
								'desc'  => __( 'Insert video URL address here', 'lespaul_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[video{{url}} /]'
					),

				//Widget areas
					array(
						'id' => 'widgetarea',
						'name' => __( 'Widget area', 'lespaul_domain_adm' ),
						'settings' => array(
							'area' => array(
								'label' => __( 'Area to display', 'lespaul_domain_adm' ),
								'desc'  => __( 'Select a widget area from dropdown menu', 'lespaul_domain_adm' ),
								'value' => wm_widget_areas()
								),
							'style' => array(
								'label' => __( 'Style', 'lespaul_domain_adm' ),
								'desc'  => __( 'Widgets layout of the widget area', 'lespaul_domain_adm' ),
								'value' => array(
									''              => __( 'Horizontal', 'lespaul_domain_adm' ),
									'vertical'      => __( 'Vertical', 'lespaul_domain_adm' ),
									'sidebar-left'  => __( 'Sidebar left', 'lespaul_domain_adm' ),
									'sidebar-right' => __( 'Sidebar right', 'lespaul_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[widgets{{area}}{{style}} /]'
					)

			);

			//remove shortcodes from array if Custom Posts or Post Formats disabled
				if ( 'disable' === wm_option( 'cp-role-faq' ) )
					unset( $wmShortcodeGeneratorTabs['faq'] );
				if ( 'disable' === wm_option( 'cp-role-logos' ) )
					unset( $wmShortcodeGeneratorTabs['logos'] );
				if ( 'disable' === wm_option( 'cp-role-prices' ) )
					unset( $wmShortcodeGeneratorTabs['prices'] );
				if ( 'disable' === wm_option( 'cp-role-projects' ) ) {
					unset( $wmShortcodeGeneratorTabs['projects'] );
					unset( $wmShortcodeGeneratorTabs['projectAtts'] );
				}
				if ( 'disable' === wm_option( 'cp-role-staff' ) )
					unset( $wmShortcodeGeneratorTabs['staff'] );
				if ( wm_option( 'blog-no-format-quote' ) )
					unset( $wmShortcodeGeneratorTabs['testimonials'] );

			return $wmShortcodeGeneratorTabs;
		}
	} // /wm_shortcode_generator_tabs





/*
*****************************************************
*      5) SHORTCODE GENERATOR HTML
*****************************************************
*/
	/*
	* Shortcode generator popup form
	*/
	if ( ! function_exists( 'wm_add_generator_popup' ) ) {
		function wm_add_generator_popup() {
			$shortcodes = wm_shortcode_generator_tabs();

			$out = '
				<div id="wm-shortcode-generator" class="selectable">
				<div id="wm-shortcode-form">
				';

			if ( ! empty( $shortcodes ) ) {

				//tabs
				/*
				$out .= '<ul class="wm-tabs">';
				foreach ( $shortcodes as $shortcode ) {
					$shortcodeId = 'wm-generate-' . $shortcode['id'];
					$out .= '<li><a href="#' . $shortcodeId . '">' . $shortcode['name'] . '</a></li>';
				}
				$out .= '</ul>';
				*/

				//select
				$out .= '<div class="wm-select-wrap"><label for="select-shortcode">' . __( 'Select a shortcode:', 'lespaul_domain_adm' ) . '</label><select id="select-shortcode" class="wm-select">';
				foreach ( $shortcodes as $shortcode ) {
					$shortcodeId = 'wm-generate-' . $shortcode['id'];
					$out .= '<option value="#' . $shortcodeId . '">' . $shortcode['name'] . '</option>';
				}
				$out .= '</select></div>';

				//content
				$out .= '<div class="wm-tabs-content">';
				foreach ( $shortcodes as $shortcode ) {

					$shortcodeId     = 'wm-generate-' . $shortcode['id'];
					$settings        = ( isset( $shortcode['settings'] ) ) ? ( $shortcode['settings'] ) : ( null );
					$shortcodeOutput = ( isset( $shortcode['output-shortcode'] ) ) ? ( $shortcode['output-shortcode'] ) : ( null );
					$close           = ( isset( $shortcode['close'] ) ) ? ( ' ' . $shortcode['close'] ) : ( null );
					$settingsCount   = count( $settings );

					$out .= '
						<div id="' . $shortcodeId . '" class="tab-content">
						<p class="shortcode-title"><strong>' . $shortcode['name'] . '</strong> ' . __( 'shortcode', 'lespaul_domain_adm' ) . '</p>
						';

					if ( isset( $shortcode['desc'] ) && $shortcode['desc'] )
						$out .= '<p class="shortcode-desc">' . $shortcode['desc'] . '</p>';

					$out .= '
						<div class="form-wrap">
						<form method="get" action="">
						<table class="items-' . $settingsCount . '">
						';

					if ( $settings ) {
						$i = 0;
						foreach ( $settings as $id => $labelValue ) {
							$i++;
							$desc      = ( isset( $labelValue['desc'] ) ) ? ( esc_attr( $labelValue['desc'] ) ) : ( '' );
							$maxlength = ( isset( $labelValue['maxlength'] ) ) ? ( ' maxlength="' . absint( $labelValue['maxlength'] ) . '"' ) : ( '' );

							$out .= '<tr class="item-' . $i . '"><td>';
							$out .= '<label for="' . $shortcodeId . '-' . $id . '" title="' . $desc . '">' . $labelValue['label'] . '</label></td><td>';
							if ( is_array( $labelValue['value'] ) ) {
								$imageBefore  = ( isset( $labelValue['image-before'] ) && $labelValue['image-before'] ) ? ( '<div class="image-before"></div>' ) : ( '' );
								$shorterClass = ( $imageBefore ) ? ( ' class="shorter set-image"' ) : ( '' );

								$out .= $imageBefore . '<select name="' . $shortcodeId . '-' . $id . '" id="' . $shortcodeId . '-' . $id . '" title="' . $desc . '" data-attribute="' . $id . '"' . $shorterClass . '>';
								foreach ( $labelValue['value'] as $value => $valueName ) {
									if ( 'OPTGROUP' === substr( $value, 1 ) )
										$out .= '<optgroup label="' . $valueName . '">';
									elseif ( '/OPTGROUP' === substr( $value, 1 ) )
										$out .= '</optgroup>';
									else
										$out .= '<option value="' . $value . '">' . $valueName . '</option>';
								}
								$out .= '</select>';

							} else {

								$out .= '<input type="text" name="' . $shortcodeId . '-' . $id . '" value="' . $labelValue['value'] . '" id="' . $shortcodeId . '-' . $id . '" class="widefat" title="' . $desc . '"' . $maxlength . ' data-attribute="' . $id . '" /><img src="' . WM_ASSETS_ADMIN . 'img/shortcodes/add16.png" alt="' . __( 'Apply changes', 'lespaul_domain_adm' ) . '" title="' . __( 'Apply changes', 'lespaul_domain_adm' ) . '" class="ico-apply" />';

							}
							$out .= '</td></tr>';
						}
					}

					$out .= '<tr><td>&nbsp;</td><td><p><a data-parent="' . $shortcodeId . '" class="send-to-generator button-primary">' . __( 'Insert into editor', 'lespaul_domain_adm' ) . '</a></p></td></tr>';
					$out .= '
						</table>
						</form>
						';
					$out .= '<p><strong>' . __( 'Or copy and paste in this shortcode:', 'lespaul_domain_adm' ) . '</strong></p>';
					$out .= '<form><textarea class="wm-shortcode-output' . $close . '" cols="30" rows="2" readonly="readonly" onfocus="this.select();" data-reference="' . esc_attr( $shortcodeOutput ) . '">' . esc_attr( $shortcodeOutput ) . '</textarea></form>';
					$out .= '<!-- /form-wrap --></div>';
					$out .= '<!-- /tab-content --></div>';

				}
				$out .= '<!-- /wm-tabs-content --></div>';

			}

			$out .= '
				<!-- /wm-shortcode-form --></div>
				<p class="credits"><small>&copy; <a href="http://www.webmandesign.eu" target="_blank">WebMan</a></small></p>
				<!-- /wm-shortcode-generator --></div>
				';

			echo $out;
		}
	} // /wm_add_generator_popup

?>