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
					$modulePosts[$post->post_name] .= sprintf( __( ' (tags: %s)', 'atlantes_domain_adm' ), implode( ', ', $moduleTags ) );
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
						'name' => __( 'Accordion', 'atlantes_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[accordion_item title=""][/accordion_item]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[accordion][/accordion]</code> parent shortcode.', 'atlantes_domain_adm' ),
						'settings' => array(
							'auto' => array(
								'label' => __( 'Automatic accordion', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select whether the accordion should automatically animate', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[accordion{{auto}}] [accordion_item title="TEXT"]TEXT[/accordion_item] [/accordion]'
					),

				//Box
					array(
						'id' => 'box',
						'name' => __( 'Box', 'atlantes_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose box color', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'blue'   => __( 'Blue', 'atlantes_domain_adm' ),
									'gray'   => __( 'Gray', 'atlantes_domain_adm' ),
									'green'  => __( 'Green', 'atlantes_domain_adm' ),
									'orange' => __( 'Orange', 'atlantes_domain_adm' ),
									'red'    => __( 'Red', 'atlantes_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Icon', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose an icon for this box', 'atlantes_domain_adm' ),
								'value' => array(
									''         => __( 'No icon', 'atlantes_domain_adm' ),
									'cancel'   => __( 'Cancel icon', 'atlantes_domain_adm' ),
									'check'    => __( 'Check icon', 'atlantes_domain_adm' ),
									'info'     => __( 'Info icon', 'atlantes_domain_adm' ),
									'question' => __( 'Question icon', 'atlantes_domain_adm' ),
									'warning'  => __( 'Warning icon', 'atlantes_domain_adm' ),
									)
								),
							'title' => array(
								'label' => __( 'Optional title', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional box title', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'transparent' => array(
								'label' => __( 'Opacity', 'atlantes_domain_adm' ),
								'desc'  => __( 'Whether box background is colored or not', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Opaque', 'atlantes_domain_adm' ),
									'1' => __( 'Transparent', 'atlantes_domain_adm' ),
									)
								),
							'hero' => array(
								'label' => __( 'Hero box', 'atlantes_domain_adm' ),
								'desc'  => __( 'Specially styled hero box', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Normal box', 'atlantes_domain_adm' ),
									'1' => __( 'Hero box', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[box{{color}}{{title}}{{icon}}{{transparent}}{{hero}}]TEXT[/box]'
					),

				//Big text
					array(
						'id' => 'big_text',
						'name' => __( 'Big text', 'atlantes_domain_adm' ),
						'settings' => array(
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[big_text{{style}}]TEXT[/big_text]'
					),

				//Button
					array(
						'id' => 'button',
						'name' => __( 'Button', 'atlantes_domain_adm' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Link URL', 'atlantes_domain_adm' ),
								'desc'  => __( 'Button link URL address', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'color' => array(
								'label' => __( 'Color', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose button color', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'blue'   => __( 'Blue', 'atlantes_domain_adm' ),
									'gray'   => __( 'Gray', 'atlantes_domain_adm' ),
									'green'  => __( 'Green', 'atlantes_domain_adm' ),
									'orange' => __( 'Orange', 'atlantes_domain_adm' ),
									'red'    => __( 'Red', 'atlantes_domain_adm' ),
									)
								),
							'size' => array(
								'label' => __( 'Size', 'atlantes_domain_adm' ),
								'desc'  => __( 'Button size', 'atlantes_domain_adm' ),
								'value' => array(
									'm'  => __( 'Medium', 'atlantes_domain_adm' ),
									's'  => __( 'Small', 'atlantes_domain_adm' ),
									'l'  => __( 'Large', 'atlantes_domain_adm' ),
									'xl' => __( 'Extra large', 'atlantes_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Align', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									'left'  => __( 'Left', 'atlantes_domain_adm' ),
									'right' => __( 'Right', 'atlantes_domain_adm' ),
									)
								),
							'new_window' => array(
								'label' => __( 'New window', 'atlantes_domain_adm' ),
								'desc'  => __( 'Open URL address in new window when button clicked', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Icon image', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select optional button icon image', 'atlantes_domain_adm' ),
								'value' => array_merge( $menuIconsEmpty, $menuIcons ),
								'image-before' => true,
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							'id' => array(
								'label' => __( 'Optional HTML "id" parameter', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional HTML "id" parameter for additional custom styling or JavaScript actions.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[button{{url}}{{color}}{{size}}{{style}}{{align}}{{new_window}}{{icon}}{{id}}]TEXT[/button]'
					),

				//Call to action
					array(
						'id' => 'cta',
						'name' => __( 'Call to action', 'atlantes_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Optional title', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional call to action title', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'subtitle' => array(
								'label' => __( 'Optional subtitle', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional call to action subtitle', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'button_url' => array(
								'label' => __( 'Button URL', 'atlantes_domain_adm' ),
								'desc'  => __( 'Button link URL address', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'button_text' => array(
								'label' => __( 'Button text', 'atlantes_domain_adm' ),
								'desc'  => __( 'Button text', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'button_color' => array(
								'label' => __( 'Button color', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose button color', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'blue'   => __( 'Blue', 'atlantes_domain_adm' ),
									'gray'   => __( 'Gray', 'atlantes_domain_adm' ),
									'green'  => __( 'Green', 'atlantes_domain_adm' ),
									'orange' => __( 'Orange', 'atlantes_domain_adm' ),
									'red'    => __( 'Red', 'atlantes_domain_adm' ),
									)
								),
							'new_window' => array(
								'label' => __( 'New window', 'atlantes_domain_adm' ),
								'desc'  => __( 'Open URL address in new window when button clicked', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							'color' => array(
								'label' => __( 'Area color', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose call to action area color', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Transparent', 'atlantes_domain_adm' ),
									'blue'   => __( 'Blue', 'atlantes_domain_adm' ),
									'gray'   => __( 'Gray', 'atlantes_domain_adm' ),
									'green'  => __( 'Green', 'atlantes_domain_adm' ),
									'orange' => __( 'Orange', 'atlantes_domain_adm' ),
									'red'    => __( 'Red', 'atlantes_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[call_to_action{{title}}{{subtitle}}{{button_text}}{{button_url}}{{button_color}}{{new_window}}{{color}}{{style}}]TEXT[/call_to_action]'
					),

				//Columns
					array(
						'id' => 'columns',
						'name' => __( 'Columns', 'atlantes_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Column size', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select column size', 'atlantes_domain_adm' ),
								'value' => array(
									'1OPTGROUP'   =>  __( 'Halfs', 'atlantes_domain_adm' ),
										'1/2'      => '1/2',
										'1/2 last' => '1/2' . __( ' last in row', 'atlantes_domain_adm' ),
									'1/OPTGROUP'  => '',
									'2OPTGROUP'   =>  __( 'Thirds', 'atlantes_domain_adm' ),
										'1/3'      => '1/3',
										'1/3 last' => '1/3' . __( ' last in row', 'atlantes_domain_adm' ),
										'2/3'      => '2/3',
										'2/3 last' => '2/3' . __( ' last in row', 'atlantes_domain_adm' ),
									'2/OPTGROUP'  => '',
									'3OPTGROUP'   =>  __( 'Quarters', 'atlantes_domain_adm' ),
										'1/4'      => '1/4',
										'1/4 last' => '1/4' . __( ' last in row', 'atlantes_domain_adm' ),
										'3/4'      => '3/4',
										'3/4 last' => '3/4' . __( ' last in row', 'atlantes_domain_adm' ),
									'3/OPTGROUP'  => '',
									'4OPTGROUP'   =>  __( 'Fifths', 'atlantes_domain_adm' ),
										'1/5'      => '1/5',
										'1/5 last' => '1/5' . __( ' last in row', 'atlantes_domain_adm' ),
										'2/5'      => '2/5',
										'2/5 last' => '2/5' . __( ' last in row', 'atlantes_domain_adm' ),
										'3/5'      => '3/5',
										'3/5 last' => '3/5' . __( ' last in row', 'atlantes_domain_adm' ),
										'4/5'      => '4/5',
										'4/5 last' => '4/5' . __( ' last in row', 'atlantes_domain_adm' ),
									'4/OPTGROUP'  => '',
									)
								),
							),
						'output-shortcode' => '[column{{size}}]TEXT[/column]'
					),

				//Content Modules
					array(
						'id' => 'content_module',
						'name' => __( 'Content Module', 'atlantes_domain_adm' ),
						'settings' => array(
							'module' => array(
								'label' => __( 'Content Module', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select Content Module to display', 'atlantes_domain_adm' ),
								'value' => $modulePosts
								),
							'randomize' => array(
								'label' => __( 'Or randomize from', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a tag from where random content module will be chosen', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => '',
										'allText'      => __( 'Select tag', 'atlantes_domain_adm' ),
										'hierarchical' => '0',
										'tax'          => 'content-module-tag',
									) )
								),
							'no_thumb' => array(
								'label' => __( 'Thumb', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select whether you want the thumbnail image to be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Show', 'atlantes_domain_adm' ),
									'1' => __( 'Hide', 'atlantes_domain_adm' )
									)
								),
							'no_title' => array(
								'label' => __( 'Title', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select whether you want the module title to be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Show', 'atlantes_domain_adm' ),
									'1' => __( 'Hide', 'atlantes_domain_adm' )
									)
								),
							'layout' => array(
								'label' => __( 'Layout', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose which layout to use', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'center' => __( 'Centered', 'atlantes_domain_adm' )
									)
								),
							),
						'output-shortcode' => '[content_module{{module}}{{randomize}}{{no_thumb}}{{no_title}}{{layout}} /]'
					),

				//Countdown timer
					array(
						'id' => 'countdown',
						'name' => __( 'Countdown timer', 'atlantes_domain_adm' ),
						'settings' => array(
							'time' => array(
								'label' => __( 'Time <small>YYYY-MM-DD HH:mm</small>', 'atlantes_domain_adm' ),
								'desc'  => __( 'Insert the time in "YYYY-MM-DD HH:mm" format (Y = year, M = month, D = day, H = hours, m = minutes)', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'size' => array(
								'label' => __( 'Timer size', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select timer size', 'atlantes_domain_adm' ),
								'value' => array(
									'xl' => __( 'Extra large', 'atlantes_domain_adm' ),
									'l'  => __( 'Large', 'atlantes_domain_adm' ),
									'm'  => __( 'Medium', 'atlantes_domain_adm' ),
									's'  => __( 'Small', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[countdown{{time}}{{size}} /]'
					),

				//Divider
					array(
						'id' => 'divider',
						'name' => __( 'Divider', 'atlantes_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Type of divider', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''              => __( 'Default divider', 'atlantes_domain_adm' ),
									'dashed'        => __( 'Dashed border', 'atlantes_domain_adm' ),
									'diagonal'      => __( 'Diagonal stripes border', 'atlantes_domain_adm' ),
									'dotted'        => __( 'Dotted border', 'atlantes_domain_adm' ),
									'fading'        => __( 'Fading on sides', 'atlantes_domain_adm' ),
									'star'          => __( 'Double border with star in the middle', 'atlantes_domain_adm' ),
									'shadow-top'    => __( 'Shadow top', 'atlantes_domain_adm' ),
									'shadow-bottom' => __( 'Shadow bottom', 'atlantes_domain_adm' ),
									'plain'         => __( 'No border (usefull to create a space)', 'atlantes_domain_adm' ),
									)
								),
							'space_before' => array(
								'label' => __( 'Space before divider', 'atlantes_domain_adm' ),
								'desc'  => __( 'Top margin. Insert only number.', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'space_after' => array(
								'label' => __( 'Space after divider', 'atlantes_domain_adm' ),
								'desc'  => __( 'Bottom margin. Insert only number.', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'opacity' => array(
								'label' => __( 'Opacity', 'atlantes_domain_adm' ),
								'desc'  => __( 'Percentual value of divider opacity - 0 = transparent, 100 = opaque', 'atlantes_domain_adm' ),
								'value' => array(
									''    => __( 'Default', 'atlantes_domain_adm' ),
									'5'  => 5,
									'10' => 10,
									'15' => 15,
									'20' => 20,
									'25' => __( '25 = default value', 'atlantes_domain_adm' ),
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
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[divider{{type}}{{space_before}}{{space_after}}{{opacity}}{{style}} /]'
					),

				//Dropcaps
					array(
						'id' => 'dropcaps',
						'name' => __( 'Dropcaps', 'atlantes_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Dropcap type', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select prefered dropcap styling', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Basic dropcap', 'atlantes_domain_adm' ),
									'round'  => __( 'Rounded dropcap', 'atlantes_domain_adm' ),
									'square' => __( 'Squared dropcap', 'atlantes_domain_adm' ),
									'leaf'   => __( 'Leaf dropcap', 'atlantes_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[dropcap{{type}}{{style}}]A[/dropcap]'
					),

				//FAQ
					'faq' => array(
						'id' => 'faq',
						'name' => __( 'FAQ', 'atlantes_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'atlantes_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'FAQ category', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_faq',
										'allText'      => __( 'All FAQs', 'atlantes_domain_adm' ),
										'tax'          => 'faq-category',
									) )
								),
							'order' => array(
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'name'   => __( 'By name', 'atlantes_domain_adm' ),
									'new'    => __( 'Newest first', 'atlantes_domain_adm' ),
									'old'    => __( 'Oldest first', 'atlantes_domain_adm' ),
									'random' => __( 'Randomly', 'atlantes_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Description text alignement (when used - it will disable the filter)', 'atlantes_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'atlantes_domain_adm' ),
									'right' => __( 'Description text on the right', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[faq{{category}}{{order}}{{align}}][/faq]'
					),

				//Gallery
					array(
						'id' => 'gallery',
						'name' => __( 'Gallery', 'atlantes_domain_adm' ),
						'desc' => __( 'Please upload images for the post/page gallery via "Add Media" button above visual editor.', 'atlantes_domain_adm' ),
						'settings' => array(
							'columns' => array(
								'label' => __( 'Columns', 'atlantes_domain_adm' ),
								'desc'  => __( 'Number of gallery columns', 'atlantes_domain_adm' ),
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
								'label' => __( 'Flexibile layout', 'atlantes_domain_adm' ),
								'desc'  => __( 'Preserves images aspect ratio and uses masonry display', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							'frame' => array(
								'label' => __( 'Framed', 'atlantes_domain_adm' ),
								'desc'  => __( 'Display frame around images', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							'remove' => array(
								'label' => __( 'Remove', 'atlantes_domain_adm' ),
								'desc'  => __( 'Image order numbers separated with commas (like "1,2,5" will remove first, second and fifth image from gallery)', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'sardine' => array(
								'label' => __( 'Sardine', 'atlantes_domain_adm' ),
								'desc'  => __( 'Removes margins around images', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[gallery{{columns}}{{flexible}}{{frame}}{{remove}}{{sardine}} /]'
					),

				//Huge text
					array(
						'id' => 'huge_text',
						'name' => __( 'Huge text', 'atlantes_domain_adm' ),
						'settings' => array(
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[huge_text{{style}}]TEXT[/huge_text]'
					),

				//Icons
					array(
						'id' => 'icon',
						'name' => __( 'Icons', 'atlantes_domain_adm' ),
						'desc' => __( 'Only predefined icons included in icon font can be displayed with this shortcode.', 'atlantes_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Icon type', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select one of predefined icons', 'atlantes_domain_adm' ),
								'value' => $menuIcons,
								'image-before' => true,
								),
							'size' => array(
								'label' => __( 'Icon size in pixels', 'atlantes_domain_adm' ),
								'desc'  => __( 'Insert just a number', 'atlantes_domain_adm' ),
								'value' => '',
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[icon{{type}}{{size}}{{style}} /]'
					),

				//Lists
					array(
						'id' => 'lists',
						'name' => __( 'Lists', 'atlantes_domain_adm' ),
						'settings' => array(
							'bullet' => array(
								'label' => __( 'Bullet type', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select list bullet type', 'atlantes_domain_adm' ),
								'value' => $menuIcons,
								'image-before' => true,
								),
							),
						'output-shortcode' => '[list{{bullet}}]' . __( 'Unordered list goes here', 'atlantes_domain_adm' ) . '[/list]'
					),

				//Last update
					array(
						'id' => 'lastupdate',
						'name' => __( 'Last update', 'atlantes_domain_adm' ),
						'desc' => __( 'Displays the date when most recent blog post or project was added.', 'atlantes_domain_adm' ),
						'settings' => array(
							'item' => array(
								'label' => __( 'Items to watch', 'atlantes_domain_adm' ),
								'desc'  => __( 'What item group will be watched for last update date', 'atlantes_domain_adm' ),
								'value' => array(
									''        => __( 'Blog posts', 'atlantes_domain_adm' ),
									'project' => __( 'Projects', 'atlantes_domain_adm' ),
									)
								),
							'format' => array(
								'label' => __( 'Date format', 'atlantes_domain_adm' ),
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
						'name' => __( 'Login form', 'atlantes_domain_adm' ),
						'settings' => array(
							'stay' => array(
								'label' => __( 'Redirection', 'atlantes_domain_adm' ),
								'desc'  => __( 'Where the user will be redirected to after successful log in', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Go to homepage', 'atlantes_domain_adm' ),
									'1' => __( 'Stay here', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[login{{stay}} /]'
					),

				//Logos
					'logos' => array(
						'id' => 'logos',
						'name' => __( 'Logos', 'atlantes_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'atlantes_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Logos category', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_logos',
										'allText'      => __( 'All logos', 'atlantes_domain_adm' ),
										'tax'          => 'logos-category',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'atlantes_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'atlantes_domain_adm' ),
									'3' => __( '3 columns', 'atlantes_domain_adm' ),
									'4' => __( '4 columns', 'atlantes_domain_adm' ),
									'5' => __( '5 columns', 'atlantes_domain_adm' ),
									'6' => __( '6 columns', 'atlantes_domain_adm' ),
									'7' => __( '7 columns', 'atlantes_domain_adm' ),
									'8' => __( '8 columns', 'atlantes_domain_adm' ),
									'9' => __( '9 columns', 'atlantes_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Logo count', 'atlantes_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'atlantes_domain_adm' ),
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
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'name'   => __( 'By name', 'atlantes_domain_adm' ),
									'new'    => __( 'Newest first', 'atlantes_domain_adm' ),
									'old'    => __( 'Oldest first', 'atlantes_domain_adm' ),
									'random' => __( 'Randomly', 'atlantes_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'atlantes_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'atlantes_domain_adm' ),
									'right' => __( 'Description text on the right', 'atlantes_domain_adm' ),
									)
								),
							'scroll' => array(
								'label' => __( 'Horizontal scroll', 'atlantes_domain_adm' ),
								'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'scroll_stack' => array(
								'label' => __( 'Scroll method', 'atlantes_domain_adm' ),
								'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'One by one', 'atlantes_domain_adm' ),
									'1' => __( 'Stack', 'atlantes_domain_adm' ),
									)
								),
							'grayscale' => array(
								'label' => __( 'Grayscale', 'atlantes_domain_adm' ),
								'desc'  => __( 'By default logo images are grayscale, turn to color when mouse hovers', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Keep grayscale', 'atlantes_domain_adm' ),
									'0' => __( 'Turn off', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[logos{{category}}{{columns}}{{count}}{{order}}{{align}}{{grayscale}}{{scroll}}{{scroll_stack}}][/logos]'
					),

				//Marker
					array(
						'id' => 'marker',
						'name' => __( 'Marker', 'atlantes_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose marker color', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'blue'   => __( 'Blue', 'atlantes_domain_adm' ),
									'gray'   => __( 'Gray', 'atlantes_domain_adm' ),
									'green'  => __( 'Green', 'atlantes_domain_adm' ),
									'orange' => __( 'Orange', 'atlantes_domain_adm' ),
									'red'    => __( 'Red', 'atlantes_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[marker{{color}}{{style}}]TEXT[/marker]'
					),

				//Posts
					array(
						'id' => 'posts',
						'name' => __( 'Posts', 'atlantes_domain_adm' ),
						'desc' => __( 'Does not display Quote and Status posts. You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'atlantes_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Posts category', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'atlantes_domain_adm' ),
								'value' => wm_tax_array()
								),
							'columns' => array(
								'label' => __( 'Layout', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'atlantes_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'atlantes_domain_adm' ),
									'3' => __( '3 columns', 'atlantes_domain_adm' ),
									'4' => __( '4 columns', 'atlantes_domain_adm' ),
									'5' => __( '5 columns', 'atlantes_domain_adm' ),
									'6' => __( '6 columns', 'atlantes_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Posts count', 'atlantes_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'atlantes_domain_adm' ),
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
								'label' => __( 'Excerpt length', 'atlantes_domain_adm' ),
								'desc'  => __( 'In words', 'atlantes_domain_adm' ),
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
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'name'   => __( 'By name', 'atlantes_domain_adm' ),
									'new'    => __( 'Newest first', 'atlantes_domain_adm' ),
									'old'    => __( 'Oldest first', 'atlantes_domain_adm' ),
									'random' => __( 'Randomly', 'atlantes_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'atlantes_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'atlantes_domain_adm' ),
									'right' => __( 'Description text on the right', 'atlantes_domain_adm' ),
									)
								),
							'scroll' => array(
								'label' => __( 'Horizontal scroll', 'atlantes_domain_adm' ),
								'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'scroll_stack' => array(
								'label' => __( 'Scroll method', 'atlantes_domain_adm' ),
								'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'One by one', 'atlantes_domain_adm' ),
									'1' => __( 'Stack', 'atlantes_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'atlantes_domain_adm' ),
									'0' => __( 'No', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[posts{{category}}{{columns}}{{count}}{{excerpt_length}}{{order}}{{align}}{{thumb}}{{scroll}}{{scroll_stack}}][/posts]'
					),

				//Price table
					'prices' => array(
						'id' => 'price_table',
						'name' => __( 'Price Table', 'atlantes_domain_adm' ),
						'settings' => array(
							'table' => array(
								'label' => __( 'Select table', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select price table to display', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => '',
										'allText'      => __( 'Select price table', 'atlantes_domain_adm' ),
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
						'name' => __( 'Projects', 'atlantes_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag. Filter will be disabled when scroll effect in use.', 'atlantes_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Projects category', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_projects',
										'allText'      => __( 'All projects', 'atlantes_domain_adm' ),
										'parentsOnly'  => true,
										'tax'          => 'project-category',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'atlantes_domain_adm' ),
								'value' => array(
									'1' => __( '1 column', 'atlantes_domain_adm' ),
									'2' => __( '2 columns', 'atlantes_domain_adm' ),
									'3' => __( '3 columns', 'atlantes_domain_adm' ),
									'4' => __( '4 columns', 'atlantes_domain_adm' ),
									'5' => __( '5 columns', 'atlantes_domain_adm' ),
									'6' => __( '6 columns', 'atlantes_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Projects count', 'atlantes_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'atlantes_domain_adm' ),
								'value' => array(
									'' => __( 'All projects (in category)', 'atlantes_domain_adm' ),
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
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'name'   => __( 'By name', 'atlantes_domain_adm' ),
									'new'    => __( 'Newest first', 'atlantes_domain_adm' ),
									'old'    => __( 'Oldest first', 'atlantes_domain_adm' ),
									'random' => __( 'Randomly', 'atlantes_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'atlantes_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'atlantes_domain_adm' ),
									'right' => __( 'Description text on the right', 'atlantes_domain_adm' ),
									)
								),
							'filter' => array(
								'label' => __( 'Projects filter', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional projects filter', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'No filter', 'atlantes_domain_adm' ),
									'1' => __( 'Animated filtering', 'atlantes_domain_adm' ),
									)
								),
							'scroll' => array(
								'label' => __( 'Horizontal scroll', 'atlantes_domain_adm' ),
								'desc'  => __( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'atlantes_domain_adm' ) . ' ' . __( 'Filter will be disabled when scroll in use.', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'scroll_stack' => array(
								'label' => __( 'Scroll method', 'atlantes_domain_adm' ),
								'desc'  => __( 'Whether to scroll items one by one or the whole stack', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'One by one', 'atlantes_domain_adm' ),
									'1' => __( 'Stack', 'atlantes_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'atlantes_domain_adm' ),
									'0' => __( 'No', 'atlantes_domain_adm' ),
									)
								),
							'excerpt_length' => array(
								'label' => __( 'Excerpt words count', 'atlantes_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[projects{{align}}{{filter}}{{columns}}{{count}}{{category}}{{order}}{{thumb}}{{scroll}}{{excerpt_length}}{{scroll_stack}}][/projects]'
					),

				//Project attributes
					'projectAtts' => array(
						'id' => 'project_attributes',
						'name' => __( 'Project attributes', 'atlantes_domain_adm' ),
						'desc' => __( 'Use on project page only. Displays table of project attributes.', 'atlantes_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Title', 'atlantes_domain_adm' ),
								'desc'  => __( 'Attributes table title', 'atlantes_domain_adm' ),
								'value' => ''
								)
							),
						'output-shortcode' => '[project_attributes{{title}} /]'
					),

				//Pullquote
					array(
						'id' => 'pullquote',
						'name' => __( 'Pullquote', 'atlantes_domain_adm' ),
						'settings' => array(
							'align' => array(
								'label' => __( 'Align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose pullquote alignment', 'atlantes_domain_adm' ),
								'value' => array(
									'left'  => __( 'Left', 'atlantes_domain_adm' ),
									'right' => __( 'Right', 'atlantes_domain_adm' ),
									)
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[pullquote{{align}}{{style}}]TEXT[/pullquote]'
					),

				//Raw / pre
					array(
						'id' => 'raw',
						'name' => __( 'Raw preformated text', 'atlantes_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'atlantes_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[raw]TEXT[/raw]'
					),

				//Screen
					array(
						'id' => 'screen',
						'name' => __( 'Screen', 'atlantes_domain_adm' ),
						'desc' => __( 'This shortcode will display content on specific screen sizes only.', 'atlantes_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Screen size', 'atlantes_domain_adm' ),
								'value' => array(
									'desktop'             => __( 'Desktop', 'atlantes_domain_adm' ),
									'tablet'              => __( 'Tablet', 'atlantes_domain_adm' ),
									'min tablet'          => __( 'Minimum tablet', 'atlantes_domain_adm' ),
									'phone'               => __( 'Phone', 'atlantes_domain_adm' ),
									'phone landscape'     => __( 'Phone landscape', 'atlantes_domain_adm' ),
									'min phone landscape' => __( 'Minimum phone landscape', 'atlantes_domain_adm' ),
									'phone portrait'      => __( 'Phone portrait', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[screen{{size}}]TEXT[/screen]'
					),

				//Section
					array(
						'id' => 'section',
						'name' => __( 'Section', 'atlantes_domain_adm' ),
						'desc' => __( 'Use on "Sections" page template only! This will split the page into sections. You can set a custom CSS class and then style the sections individually. You can use "alt" class for alternative section styling.', 'atlantes_domain_adm' ),
						'settings' => array(
							'class' => array(
								'label' => __( 'Class', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional CSS class name', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[section{{class}}{{style}}]TEXT[/section]'
					),

				//Separator heading
					array(
						'id' => 'separator_heading',
						'name' => __( 'Separator heading', 'atlantes_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Heading size', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose one of HTML heading sizes', 'atlantes_domain_adm' ),
								'value' => array(
									'' => __( 'Default size (2)', 'atlantes_domain_adm' ),
									1  => 1,
									2  => 2,
									3  => 3,
									4  => 4,
									5  => 5,
									6  => 6,
									)
								),
							'align' => array(
								'label' => __( 'Align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose text alignment', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Left', 'atlantes_domain_adm' ),
									'center' => __( 'Center', 'atlantes_domain_adm' ),
									'right'  => __( 'Right', 'atlantes_domain_adm' ),
									)
								),
							'type' => array(
								'label' => __( 'Type / styling', 'atlantes_domain_adm' ),
								'desc'  => __( 'Choose separator heading styling', 'atlantes_domain_adm' ),
								'value' => array(
									''        => __( 'Default (uniform)', 'atlantes_domain_adm' ),
									'uniform' => __( 'Uniform - each heading is the same', 'atlantes_domain_adm' ),
									'normal'  => __( 'Normal - keeps heading styles', 'atlantes_domain_adm' ),
									)
								),
							'id' => array(
								'label' => __( 'Id attribute', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional HTML id attribute', 'atlantes_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[separator_heading{{size}}{{align}}{{type}}{{id}}]TEXT[/separator_heading]'
					),

				//Small text
					array(
						'id' => 'small_text',
						'name' => __( 'Small text', 'atlantes_domain_adm' ),
						'settings' => array(
							'style' => array(
								'label' => __( 'Optional CSS style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Custom CSS rules inserted into "style" attribute.', 'atlantes_domain_adm' ),
								'value' => '',
								),
							),
						'output-shortcode' => '[small_text{{style}}]TEXT[/small_text]'
					),

				//Social icons
					array(
						'id' => 'social',
						'name' => __( 'Social', 'atlantes_domain_adm' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Link URL', 'atlantes_domain_adm' ),
								'desc'  => __( 'Social icon link URL address', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'icon' => array(
								'label' => __( 'Icon', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select icon to be displayed', 'atlantes_domain_adm' ),
								'value' => array_combine( $socialIconsArray, $socialIconsArray )
								),
							'title' => array(
								'label' => __( 'Title text', 'atlantes_domain_adm' ),
								'desc'  => __( 'This text will be displayed when mouse hovers over the icon', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'size' => array(
								'label' => __( 'Icon size', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select icon size', 'atlantes_domain_adm' ),
								'value' => array(
									's'  => __( 'Small', 'atlantes_domain_adm' ),
									'm'  => __( 'Medium', 'atlantes_domain_adm' ),
									'l'  => __( 'Large', 'atlantes_domain_adm' ),
									'xl' => __( 'Extra large', 'atlantes_domain_adm' ),
									)
								),
							'rel' => array(
								'label' => __( 'Optional link relation', 'atlantes_domain_adm' ),
								'desc'  => __( 'This will set up the link "rel" HTML attribute', 'atlantes_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[social{{url}}{{icon}}{{title}}{{size}}{{rel}} /]'
					),

				//Staff
					'staff' => array(
						'id' => 'staff',
						'name' => __( 'Staff', 'atlantes_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'atlantes_domain_adm' ),
						'settings' => array(
							'department' => array(
								'label' => __( 'Department', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a department from where the list will be populated', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_staff',
										'allText'      => __( 'All staff', 'atlantes_domain_adm' ),
										'tax'          => 'department',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'atlantes_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'atlantes_domain_adm' ),
									'3' => __( '3 columns', 'atlantes_domain_adm' ),
									'4' => __( '4 columns', 'atlantes_domain_adm' ),
									'5' => __( '5 columns', 'atlantes_domain_adm' ),
									'6' => __( '6 columns', 'atlantes_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Staff count', 'atlantes_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'atlantes_domain_adm' ),
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
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'atlantes_domain_adm' ),
									'name'   => __( 'By name', 'atlantes_domain_adm' ),
									'new'    => __( 'Newest first', 'atlantes_domain_adm' ),
									'old'    => __( 'Oldest first', 'atlantes_domain_adm' ),
									'random' => __( 'Randomly', 'atlantes_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'atlantes_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'atlantes_domain_adm' ),
									'right' => __( 'Description text on the right', 'atlantes_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'atlantes_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'atlantes_domain_adm' ),
									'0' => __( 'No', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[staff{{department}}{{columns}}{{count}}{{order}}{{align}}{{thumb}}][/staff]'
					),

				//Subpages
					array(
						'id' => 'subpages',
						'name' => __( 'Subpages', 'atlantes_domain_adm' ),
						'settings' => array(
							'depth' => array(
								'label' => __( 'Hierarchy levels', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select the depth of page hierarchy to display', 'atlantes_domain_adm' ),
								'value' => array(
									'0' => __( 'All levels', 'atlantes_domain_adm' ),
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									'menu'  => __( 'By menu order', 'atlantes_domain_adm' ),
									'title' => __( 'By title', 'atlantes_domain_adm' ),
									)
								),
							'parents' => array(
								'label' => __( 'Display parents?', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[subpages{{depth}}{{order}}{{parents}} /]'
					),

				//Table
					array(
						'id' => 'table',
						'name' => __( 'Table', 'atlantes_domain_adm' ),
						'desc' => __( 'For simple data tables use the shortcode below.', 'atlantes_domain_adm' ) . '<br />' . __( 'However, if you require more control over your table you can use sub-shortcodes for table row (<code>[trow][/trow]</code> or <code>[trow_alt][/trow_alt]</code> for alternatively styled table row), table cell (<code>[tcell][/tcell]</code>) and table heading cell (<code>[tcell_heading][/tcell_heading]</code>). All wrapped in <code>[table][/table]</code> parent shortcode.', 'atlantes_domain_adm' ),
						'settings' => array(
							'cols' => array(
								'label' => __( 'Heading row', 'atlantes_domain_adm' ),
								'desc'  => __( 'Titles of columns, separated with separator character. This is required to determine the number of columns for the table.', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'data' => array(
								'label' => __( 'Table data', 'atlantes_domain_adm' ),
								'desc'  => __( 'Table cells data separated with separator character. Will be automatically aligned into columns (depending on "Heading row" setting).', 'atlantes_domain_adm' ),
								'value' => ''
								),
							'separator' => array(
								'label' => __( 'Separator character', 'atlantes_domain_adm' ),
								'desc'  => __( 'Individual table cell data separator used in previous input fields', 'atlantes_domain_adm' ),
								'value' => ';'
								),
							'heading_col' => array(
								'label' => __( 'Heading column', 'atlantes_domain_adm' ),
								'desc'  => __( 'If you wish to display a whole column of the table as a heading, set its order number here', 'atlantes_domain_adm' ),
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
								'label' => __( 'CSS class', 'atlantes_domain_adm' ),
								'desc'  => __( 'Optional custom css class applied on the table HTML tag', 'atlantes_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[table{{class}}{{cols}}{{data}}{{separator}}{{heading_col}} /]'
					),

				//Tabs
					array(
						'id' => 'tabs',
						'name' => __( 'Tabs', 'atlantes_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[tab title="" icon=""][/tab]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[tabs][/tabs]</code> parent shortcode.', 'atlantes_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Tabs type', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select tabs styling', 'atlantes_domain_adm' ),
								'value' => array(
									''              => __( 'Normal tabs', 'atlantes_domain_adm' ),
									'fullwidth'     => __( 'Full width tabs', 'atlantes_domain_adm' ),
									'vertical'      => __( 'Vertical tabs', 'atlantes_domain_adm' ),
									'vertical tour' => __( 'Vertical tabs - tour', 'atlantes_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Tab icon', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select optional tab icon', 'atlantes_domain_adm' ),
								'value' => array_merge( $menuIconsEmpty, $menuIcons ),
								'image-before' => true,
								),
							),
						'output-shortcode' => '[tabs{{type}}] [tab title="TEXT"{{icon}}]TEXT[/tab] [/tabs]'
					),

				//Testimonials
					'testimonials' => array(
						'id' => 'testimonials',
						'name' => __( 'Testimonials', 'atlantes_domain_adm' ),
						'desc' => __( 'This shortcode will display Quote posts. If featured image of the post set, it will be used as quoted person photo (please upload square images only).', 'atlantes_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Category (required)', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'atlantes_domain_adm' ),
								'value' => wm_tax_array( array( 'all' => false ) )
								),
							'count' => array(
								'label' => __( 'Testimonials count', 'atlantes_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'atlantes_domain_adm' ),
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
								'label' => __( 'Order', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'atlantes_domain_adm' ),
								'value' => array(
									''       => __( 'Newest first', 'atlantes_domain_adm' ),
									'old'    => __( 'Oldest first', 'atlantes_domain_adm' ),
									'random' => __( 'Randomly', 'atlantes_domain_adm' ),
									)
								),
							'speed' => array(
								'label' => __( 'Speed in seconds', 'atlantes_domain_adm' ),
								'desc'  => __( 'Time to display one testimonial in seconds', 'atlantes_domain_adm' ),
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
								'label' => __( 'Layout', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => __( 'Normal', 'atlantes_domain_adm' ),
									'large' => __( 'Large', 'atlantes_domain_adm' ),
									)
								),
							*/
							'stack' => array(
								'label' => __( 'Animated stack count', 'atlantes_domain_adm' ),
								'desc'  => __( 'How many testimonials to display at once (use with animated testimonials only)', 'atlantes_domain_adm' ),
								'value' => array(
									'' => 1,
									2  => 2,
									3  => 3,
									4  => 4,
									)
								),
							'private' => array(
								'label' => __( 'Display private posts?', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[testimonials{{category}}{{count}}{{order}}{{speed}}{{stack}}{{private}} /]'
					),

				//Toggles
					array(
						'id' => 'toggles',
						'name' => __( 'Toggles', 'atlantes_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Toggle title', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => ''
								),
							'open' => array(
								'label' => __( 'Open by default?', 'atlantes_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'atlantes_domain_adm' ),
									'1' => __( 'Yes', 'atlantes_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[toggle{{title}}{{open}}]TEXT[/toggle]'
					),

				//Uppercase text
					array(
						'id' => 'uppercase',
						'name' => __( 'Uppercase text', 'atlantes_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'atlantes_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[uppercase]TEXT[/uppercase]'
					),

				//Videos
					array(
						'id' => 'video',
						'name' => __( 'Video', 'atlantes_domain_adm' ),
						'desc' => sprintf( __( '<a%s>Supported video portals</a> and Screenr videos.', 'atlantes_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Video URL', 'atlantes_domain_adm' ),
								'desc'  => __( 'Insert video URL address here', 'atlantes_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[video{{url}} /]'
					),

				//Widget areas
					array(
						'id' => 'widgetarea',
						'name' => __( 'Widget area', 'atlantes_domain_adm' ),
						'settings' => array(
							'area' => array(
								'label' => __( 'Area to display', 'atlantes_domain_adm' ),
								'desc'  => __( 'Select a widget area from dropdown menu', 'atlantes_domain_adm' ),
								'value' => wm_widget_areas()
								),
							'style' => array(
								'label' => __( 'Style', 'atlantes_domain_adm' ),
								'desc'  => __( 'Widgets layout of the widget area', 'atlantes_domain_adm' ),
								'value' => array(
									''              => __( 'Horizontal', 'atlantes_domain_adm' ),
									'vertical'      => __( 'Vertical', 'atlantes_domain_adm' ),
									'sidebar-left'  => __( 'Sidebar left', 'atlantes_domain_adm' ),
									'sidebar-right' => __( 'Sidebar right', 'atlantes_domain_adm' ),
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
				$out .= '<div class="wm-select-wrap"><label for="select-shortcode">' . __( 'Select a shortcode:', 'atlantes_domain_adm' ) . '</label><select id="select-shortcode" class="wm-select">';
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
						<p class="shortcode-title"><strong>' . $shortcode['name'] . '</strong> ' . __( 'shortcode', 'atlantes_domain_adm' ) . '</p>
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

								$out .= '<input type="text" name="' . $shortcodeId . '-' . $id . '" value="' . $labelValue['value'] . '" id="' . $shortcodeId . '-' . $id . '" class="widefat" title="' . $desc . '"' . $maxlength . ' data-attribute="' . $id . '" /><img src="' . WM_ASSETS_ADMIN . 'img/shortcodes/add16.png" alt="' . __( 'Apply changes', 'atlantes_domain_adm' ) . '" title="' . __( 'Apply changes', 'atlantes_domain_adm' ) . '" class="ico-apply" />';

							}
							$out .= '</td></tr>';
						}
					}

					$out .= '<tr><td>&nbsp;</td><td><p><a data-parent="' . $shortcodeId . '" class="send-to-generator button-primary">' . __( 'Insert into editor', 'atlantes_domain_adm' ) . '</a></p></td></tr>';
					$out .= '
						</table>
						</form>
						';
					$out .= '<p><strong>' . __( 'Or copy and paste in this shortcode:', 'atlantes_domain_adm' ) . '</strong></p>';
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