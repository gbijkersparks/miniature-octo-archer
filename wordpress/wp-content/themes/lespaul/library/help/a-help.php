<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Contextual help texts
*****************************************************
*/





/*
* Generate shortcode help
*
* $shortcodes - ARRAY [shortcodes description array]
*
* example of $shortcodes info:
* array(
*   'titleDesc'   => 'Shortcode_title_description',
*   'title'       => 'Shortcode_title',
*   'example'     => 'Shortcode_example_usage',
*   'description' => array( 'Shortcode_description_each_paragraph_separate_array_item' ),
*   'parameters'  => array(
*     'Parameter_name' => array(
*       'Parameter_type',
*       'Parameter_description'
*     ),
*   ),
* )
*/
if ( ! function_exists( 'wm_help_shortcodes' ) ) {
	function wm_help_shortcodes( $shortcodes ) {

		if ( ! is_array( $shortcodes ) || empty( $shortcodes ) )
			return '';

		$out = '';

		$replaceArray = array(
			'desc' => array(
				'[' => '<code>[',
				']' => ']</code>',
				'{' => '<code>',
				'}' => '</code>',
			),
			'param' => array(
				'{'  => '<code>',
				'}'  => '</code>',
				'=d' => '<sup title="' . __( 'Default value', 'lespaul_domain_help' ) . '">*</sup>',
			),
		);

		foreach ( $shortcodes as $shortcode ) {

			$titleDesc   = ( isset( $shortcode['titleDesc'] ) ) ? ( $shortcode['titleDesc'] ) : ( 'SHORTCODE DESCRIPTION' );
			$title       = ( isset( $shortcode['title'] ) ) ? ( $shortcode['title'] ) : ( 'SHORTCODE' );
			$example     = ( isset( $shortcode['example'] ) ) ? ( $shortcode['example'] ) : ( 'EXAMPLE' );
			$description = ( isset( $shortcode['description'] ) ) ? ( $shortcode['description'] ) : ( array( 'DESCRIPTION' ) );
			$description = implode( '</p><p>', $description );
			$description = strtr( $description, $replaceArray['desc'] );
			$parameters  = ( isset( $shortcode['parameters'] ) ) ? ( $shortcode['parameters'] ) : ( false );

			$out .= '<div class="shortcode-help">';

				//title and description
				$out .= '<h3 title="' . esc_attr( $titleDesc ) . '">' . $title . '</h3>';
				$out .= '<div class="shortcode-help-content">';

					$out .= '<p>' . __( 'Example:', 'lespaul_domain_help' ) . '<br /><input type="text" onfocus="this.select();" readonly="readonly" value="' . esc_attr( $example ) . '" class="example" /></p>';
					$out .= '<p>' . $description . '</p>';

					//parameters
					if ( $parameters ) {
						$out .= '<table class="attributes" cellspacing="0"><tbody>';
						foreach ( $parameters as $parameterName => $parameter ) {
							$parameterDesc = strtr( $parameter[1], $replaceArray['param'] );
							$out .= '<tr>';
								$out .= '<th class="parameter-name"><code>' . $parameterName . '</code></th>'; //parameter name
								$out .= '<td class="parameter-type"><small>' . $parameter[0] . '</small></td>'; //parameter type
								$out .= '<td class="parameter-desc">' . $parameterDesc . '</td>'; //parameter description
							$out .= '</tr>';
						}
						$out .= '</tbody></table><p><small>* ' . __( 'Default value of predefined parameter values set', 'lespaul_domain_help' ) . '</small></p>';
					} else {
						$out .= '<p><em>' . __( 'There are no parameters for this shortcode.', 'lespaul_domain_help' ) . '</em></p>';
					}

			$out .= '</div></div>';

		}

		return $out;
	}
} // /wm_help_shortcodes





$fontFile  = ( ! file_exists( WM_FONT . 'custom/config.json' ) ) ? ( WM_FONT . 'fontello/config.json' ) : ( WM_FONT . 'custom/config.json' );
$fontIcons = wm_fontello_classes( $fontFile );

$prefix = 'wm-help-';

/* Repeatable texts */
	$predefinedSentences = array(
		'noclose'    => __( 'No closing tag required, please close the shortcode with slash before the closing square bracket.', 'lespaul_domain_help' ),
		'close'      => __( 'Place the content between opening and closing shortcode tag.', 'lespaul_domain_help' ),
		'predefined' => __( 'One of these values (leave blank for default):', 'lespaul_domain_help' ),
		);
	$widgetAreas = wm_widget_areas();
	$widgetAreas = implode( '}, {', array_filter( array_flip( $widgetAreas ) ) );

	$shortcodesHelp = array(
			//access shortcodes
			'access' => array(
				//login form
				array(
					'titleDesc'   => __( 'Displays login form', 'lespaul_domain_help' ),
					'title'       => __( 'Login Form', 'lespaul_domain_help' ),
					'example'     => '[login stay="1" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'stay' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Leave empty to redirect to homepage after successful login or set {1} to stay on the current page.', 'lespaul_domain_help' )
						),
					),
				),

				//user group access
				array(
					'titleDesc'   => __( 'Displays content just for specific user group', 'lespaul_domain_help' ),
					'title'       => __( 'User groups', 'lespaul_domain_help' ),
					'example'     => '[administrator]TEXT[/administrator]',
					'description' => array( $predefinedSentences['close'], __( 'The available shortcodes are: [administrator]TEXT[/administrator], [author]TEXT[/author], [contributor]TEXT[/contributor], [editor]TEXT[/editor], [subscriber]TEXT[/subscriber].', 'lespaul_domain_help' ) ),
				),
			),

			//media shortcodes
			'media' => array(
				//gallery
				array(
					'titleDesc'   => __( 'Inserts post/page image gallery', 'lespaul_domain_help' ),
					'title'       => __( 'Gallery', 'lespaul_domain_help' ),
					'example'     => '[gallery columns="4" flexible="1" frame="1" remove="1,3,5" sardine="1" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'This is basically the native WordPress gallery shortcode enhanced with some cool features. For default gallery parameters check the <a href="http://codex.wordpress.org/Gallery_Shortcode" target="_blank">WordPress codex</a>. Parameters below are just theme enhancements. The theme also improves gallery HTML markup and CSS styling.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'flexible' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to keep image proportions and display a gallery in masonry style.', 'lespaul_domain_help' )
						),
						'frame' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} display frame around gallery images.', 'lespaul_domain_help' )
						),
						'remove' => array(
							__( 'numbers', 'lespaul_domain_help' ),
							__( 'Insert numbers separated with commas. For default "exclude" gallery parameter you would need to insert the actual image IDs. This makes the process simpler. You just insert a numerical position of the image in gallery to remove. For example {1,3,5} will remove first, third and fifth image from gallery.', 'lespaul_domain_help' )
						),
						'sardine' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to display images without margins.', 'lespaul_domain_help' )
						),
					),
				),

				//video
				array(
					'titleDesc'   => __( 'Inserts YouTube, Vimeo or Screenr video', 'lespaul_domain_help' ),
					'title'       => __( 'Video', 'lespaul_domain_help' ),
					'example'     => '[video url="URL" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . sprintf( __( '<a%s>Supported video portals</a> and Screenr videos only.', 'lespaul_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ) ),
					'parameters'  => array(
						'url' => array(
							__( 'URL', 'lespaul_domain_help' ),
							__( 'Full video URL (not embed URL).', 'lespaul_domain_help' )
						),
					),
				),
			),

			//special shortcodes
			'special' => array(
				//accordion
				array(
					'titleDesc'   => __( 'Creates interactive accordion', 'lespaul_domain_help' ),
					'title'       => __( 'Accordion', 'lespaul_domain_help' ),
					'example'     => '[accordion auto="1"][accordion_item title="TEXT"]TEXT[/accordion_item][/accordion]',
					'description' => array( __( 'Place the accordion item content between [accordion_item] and [/accordion_item] shortcodes and wrap them all in [accordion] and [/accordion] shortcode. You can create as many accordion items as needed, just remember to enclose them in [accordion_item] shortcode.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'auto' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to make accordion automatically animated or leave empty to use normal accordion.', 'lespaul_domain_help' )
						),
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Required accordion section (item) title. Clicking the title reveals the accordion section.', 'lespaul_domain_help' )
						),
					),
				),

				//content module
				array(
					'titleDesc'   => __( 'Display a specific content module', 'lespaul_domain_help' ),
					'title'       => __( 'Content modules', 'lespaul_domain_help' ),
					'example'     => '[content_module module="slug" layout="" no_thumb="" no_title="" randomize="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Content modules can be used to inject a content into a page or post or to be displayed as an icon module (which can be usefull for services presentation, for example).', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'layout' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Sets the layout - either normal or centered one.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {normal}=d, {centered}.',
						),
						'module' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the Content Module to be displayed. You can find the Content Module slug in <strong>Content Modules > Content Modules</strong> in "Shortcode" column of the table.', 'lespaul_domain_help' )
						),
						'no_thumb' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to hide Content Module featured image.', 'lespaul_domain_help' )
						),
						'no_title' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to hide Content Module title.', 'lespaul_domain_help' )
						),
						'randomize' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the tag (the group of Content Modules) where the Content Module will be randomly chosen from. You can find the tag slug in <strong>Content Modules > Tags</strong>.', 'lespaul_domain_help' )
						),
					),
				),

				//countdown
				array(
					'titleDesc'   => __( 'Displays countdown timer', 'lespaul_domain_help' ),
					'title'       => __( 'Countdown timer', 'lespaul_domain_help' ),
					'example'     => '[countdown time="2013-12-31 12:00" size="m" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays countdown timer counting down until specific time.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'size' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {s}, {m}, {l}, {xl}=d.',
						),
						'time' => array(
							__( 'time value (YYYY-MM-DD HH:mm format)', 'lespaul_domain_help' ),
							__( 'Set the time in predefined format: Y = year, M = month, D = day, H = hour, m = minute. Example for noon on December 31st, 2013: {2013-12-31 12:00}.', 'lespaul_domain_help' )
						),
					),
				),

				//faq
				'faq' => array(
					'titleDesc'   => __( 'Display frequently asked questions', 'lespaul_domain_help' ),
					'title'       => __( 'FAQ', 'lespaul_domain_help' ),
					'example'     => '[faq align="" category="slug" order="new"][/faq]',
					'description' => array( __( 'Displays list of frequently asked questions. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'If description set, this will set its alignment.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the FAQ category to be displayed. You can find the FAQ category slug in <strong>FAQ > FAQ categories</strong>.', 'lespaul_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}, {old}, {name}=d, {random}.',
						),
					),
				),

				//logos
				'logos' => array(
					'titleDesc'   => __( 'Display clients/partners logos', 'lespaul_domain_help' ),
					'title'       => __( 'Logos', 'lespaul_domain_help' ),
					'example'     => '[logos align="left" category="" columns="5" count="10" grayscale="1" order="new" scroll="3000"][/logos]',
					'description' => array( __( 'Displays logos. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'If description set, this will set its alignment.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the logo category to be displayed. You can find the logo category slug in <strong>Logos > Categories</strong>.', 'lespaul_domain_help' )
						),
						'columns' => array(
							__( 'number', 'lespaul_domain_help' ) . ' (2-9)',
							__( 'Sets the layout.', 'lespaul_domain_help' ),
						),
						'count' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the number of items displayed.', 'lespaul_domain_help' ),
						),
						'grayscale' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} (by default) to display logos in grayscale (when mouse hovers over they turn to color logos).', 'lespaul_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}, {old}, {name}, {random}=d.',
						),
						'scroll' => array(
							__( 'number (1-999 for manual, 1000+ for automatic)', 'lespaul_domain_help' ),
							__( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_help' ),
						),
						'scroll_stack' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Whether to scroll items one by one (set {0} or leave blank) or the whole stack (set {1}).', 'lespaul_domain_help' ),
						),
					),
				),

				//posts
				array(
					'titleDesc'   => __( 'Displays posts', 'lespaul_domain_help' ),
					'title'       => __( 'Posts', 'lespaul_domain_help' ),
					'example'     => '[posts align="left" category="" columns="5" count="10" excerpt_length="" order="new" scroll="3000"][/posts]',
					'description' => array( __( 'Displays blog posts (except Quote and Status post formats). You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'If description set, this will set its alignment.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the blog category to be displayed. You can find the blog category slug in <strong>Posts > Categories</strong>.', 'lespaul_domain_help' )
						),
						'columns' => array(
							__( 'number', 'lespaul_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'lespaul_domain_help' ),
						),
						'count' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the number of items displayed.', 'lespaul_domain_help' ),
						),
						'excerpt_length' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the length of the excerpt in words.', 'lespaul_domain_help' ),
						),
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {name}, {random}.',
						),
						'scroll' => array(
							__( 'number (1-999 for manual, 1000+ for automatic)', 'lespaul_domain_help' ),
							__( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_help' ),
						),
						'scroll_stack' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Whether to scroll items one by one (set {0} or leave blank) or the whole stack (set {1}).', 'lespaul_domain_help' ),
						),
						'thumb' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'By default the thumbnail image is displayed (set to {1}).', 'lespaul_domain_help' )
						),
					),
				),

				//price table
				'prices' => array(
					'titleDesc'   => __( 'Display a specific pricing table', 'lespaul_domain_help' ),
					'title'       => __( 'Pricing tables', 'lespaul_domain_help' ),
					'example'     => '[prices table="slug" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'table' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the table to be displayed. You can find the price table slug in <strong>Prices > Price tables</strong>.', 'lespaul_domain_help' )
						),
					),
				),

				//projects
				'projects' => array(
					'titleDesc'   => __( 'Displays projects', 'lespaul_domain_help' ),
					'title'       => __( 'Projects', 'lespaul_domain_help' ),
					'example'     => '[projects align="left" category="" columns="5" count="10" filter="1" order="new" scroll=""][/projects]',
					'description' => array( __( 'Displays list of projects. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'If description set, this will set its alignment.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the projects category to be displayed. You can find the projects category slug in <strong>Projects > Project categories</strong>.', 'lespaul_domain_help' )
						),
						'columns' => array(
							__( 'number', 'lespaul_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'lespaul_domain_help' ),
						),
						'count' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the number of items displayed.', 'lespaul_domain_help' ),
						),
						'filter' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to display a filter above projects list.', 'lespaul_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {name}, {random}.',
						),
						'scroll' => array(
							__( 'number (1-999 for manual, 1000+ for automatic)', 'lespaul_domain_help' ),
							__( 'To enable automatic scroll insert a pause time in miliseconds (minimal value is 1000). To enable manual scroll just insert any text or a number from 1 to 999. Please note that "count" parameter should be greater than "columns" parameter for scroll to work.', 'lespaul_domain_help' ) . ' ' . __( 'Filter will be disabled when scroll in use.', 'lespaul_domain_adm' ),
						),
						'scroll_stack' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Whether to scroll items one by one (set {0} or leave blank) or the whole stack (set {1}).', 'lespaul_domain_help' ),
						),
						'thumb' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'By default the thumbnail image is displayed (set to {1}).', 'lespaul_domain_help' )
						),
					),
				),

				//project attributes
				'projectAtts' => array(
					'titleDesc'   => __( 'Displays current project attributes', 'lespaul_domain_help' ),
					'title'       => __( 'Project attributes', 'lespaul_domain_help' ),
					'example'     => '[project_attributes title="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Use on project page only.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'If set, a heading (HTML heading 3) will be applied on the attributes list.', 'lespaul_domain_help' )
						),
					),
				),

				//screen
				array(
					'titleDesc'   => __( 'Displays content on specific screen sizes only.', 'lespaul_domain_help' ),
					'title'       => __( 'Screen', 'lespaul_domain_help' ),
					'example'     => '[screen size="desktop"]TEXT[/screen]',
					'description' => array( __( 'Displays content on specific screen sizes only.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'size' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Choose one of these predefined screen sizes:', 'lespaul_domain_help' ) . ' ' . ' {desktop}=d, {tablet}, {min tablet}, {phone}, {phone landscape}, {min phone landscape}, {phone portrait}.',
						),
					),
				),

				//sections
				array(
					'titleDesc'   => __( 'Splits the "Sections" page template', 'lespaul_domain_help' ),
					'title'       => __( '"Sections" page template section', 'lespaul_domain_help' ),
					'example'     => '[section class="TEXT" style=""]TEXT[/section]',
					'description' => array( __( 'Use this shortcode on "Sections" page template only. It will split the page into sections.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'class' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional section CSS class for styling purposes. You can use "alt" class to apply alternative styling.', 'lespaul_domain_help' )
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
					),
				),

				//social icons
				array(
					'titleDesc'   => __( 'Display specific social icon', 'lespaul_domain_help' ),
					'title'       => __( 'Social icons', 'lespaul_domain_help' ),
					'example'     => '[social icon="Twitter" size="l" title="TEXT" url="URL" rel="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'icon' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Set a specific social network icon here.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {' . implode( '}, {', $socialIconsArray ) . '}.',
						),
						'rel' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional link relation. This sets up the "rel" HTML attribute.', 'lespaul_domain_help' ),
						),
						'size' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {s}, {m}, {l}=d, {xl}.',
						),
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Sets optional text which will be displayed when mouse hovers over the icon.', 'lespaul_domain_help' ),
						),
						'url' => array(
							__( 'URL', 'lespaul_domain_help' ),
							__( 'The actual link URL of the icon. When "icon" parameter left empty, this will be used to determine the icon.', 'lespaul_domain_help' ),
						),
					),
				),

				//staff
				'staff' => array(
					'titleDesc'   => __( 'Displays staff info', 'lespaul_domain_help' ),
					'title'       => __( 'Staff', 'lespaul_domain_help' ),
					'example'     => '[staff align="left" columns="5" count="10" department="" order="new"][/staff]',
					'description' => array( __( 'Displays blog posts. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'If description set, this will set its alignment.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'columns' => array(
							__( 'number', 'lespaul_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'lespaul_domain_help' ),
						),
						'count' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the number of items displayed.', 'lespaul_domain_help' ),
						),
						'department' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'The slug (preferred) or ID of the department to be displayed. You can find the department slug in <strong>Staff > Departments</strong>.', 'lespaul_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {name}, {random}.',
						),
						'thumb' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'By default the thumbnail image is displayed (set to {1}).', 'lespaul_domain_help' )
						),
					),
				),

				//subpages
				array(
					'titleDesc'   => __( 'Display list of subpages', 'lespaul_domain_help' ),
					'title'       => __( 'Subpages', 'lespaul_domain_help' ),
					'example'     => '[subpages depth="1" order="menu" parents="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays list of subpages.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'depth' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Set the depth level of pages hierarchy to display.', 'lespaul_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {title}=d, {menu}.',
						),
						'parents' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to display also page parents. Otherwise only children and siblings will be displayed.', 'lespaul_domain_help' )
						),
					),
				),

				//tabs
				array(
					'titleDesc'   => __( 'Creates interactive tabs', 'lespaul_domain_help' ),
					'title'       => __( 'Tabs', 'lespaul_domain_help' ),
					'example'     => '[tabs type="fullwidth" hover=""][tab title="TEXT" icon=""]TEXT[/tab][/tabs]',
					'description' => array( __( 'Place the tab content between [tab] and [/tab] shortcodes and wrap them all in [tabs] and [/tabs] shortcode. You can create as many tab items as needed, just remember to enclose them in [tab] shortcode.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'icon' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Choose an optional icon to be displayed in tab title.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {' . implode( '}, {', $socialIconsArray ) . '}.',
						),
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Required tab title. Clicking the title reveals the tabbed content.', 'lespaul_domain_help' )
						),
						'type' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {vertical}, {vertical tour}, {fullwidth}.',
						),
					),
				),

				//testimonials
				'testimonials' => array(
					'titleDesc'   => __( 'Display testimonials', 'lespaul_domain_help' ),
					'title'       => __( 'Testimonials', 'lespaul_domain_help' ),
					'example'     => '[testimonials category="slug" count="5" order="random" private="1" speed="3" stack="2" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays quote posts in a list or animated sequence one by one. If featured image of the post set, it will be used as quoted person photo (please upload square images only).', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'category' => array(
							__( 'slug or ID', 'lespaul_domain_help' ),
							__( 'Slug (preferred) or ID of blog category where the quote posts are chosen from. You can find the category slug in <strong>Posts > Categories</strong>.', 'lespaul_domain_help' )
						),
						'count' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Number of quote posts to display.', 'lespaul_domain_help' )
						),
						/*
						'layout' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {normal}=d, {large}.',
						),
						*/
						'order' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {random}.',
						),
						'private' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Should the testimonials shortcode display posts with status of "private" (these are normally displayed to post author only and are hidden for other website visitors)?', 'lespaul_domain_help' )
						),
						'speed' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Duration to display one testimonial in seconds. This will make the testimonials to be displayed in animation one by one. If not set, testimonials will be displayed in simple list.', 'lespaul_domain_help' )
						),
						'stack' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'How many testimonials to display at once. Please use this with animated testimonials only.', 'lespaul_domain_help' )
						),
					),
				),

				//toggles
				array(
					'titleDesc'   => __( 'Creates interactive toggles', 'lespaul_domain_help' ),
					'title'       => __( 'Toggles', 'lespaul_domain_help' ),
					'example'     => '[toggle open="1" title="TEXT"]TEXT[/toggle]',
					'description' => array( __( 'Place the toggle content between [toggle] and [/toggle] shortcode. The content will be displayed after clicking the toggle title.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'open' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Should the toggle be open by default?', 'lespaul_domain_help' )
						),
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Required toggle title. Clicking the title toggles the content.', 'lespaul_domain_help' )
						),
					),
				),

				//widget area
				array(
					'titleDesc'   => __( 'Displays specific widget area', 'lespaul_domain_help' ),
					'title'       => __( 'Widget areas', 'lespaul_domain_help' ),
					'example'     => '[widgets area="default" layout="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'area' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {' . $widgetAreas . '}.',
						),
						'layout' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'By default the widget area will be displayed horizontally and will take maximum of 5 widgets. However, you can change that and set vertical styling of the widget area here.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {horizontal}=d, {vertical}, {sidebar-left} , {sidebar-right}.',
						),
					),
				),
			),

			//text shortcodes
			'text' => array(
				//big text
				array(
					'titleDesc'   => __( 'Enlarges text', 'lespaul_domain_help' ),
					'title'       => __( 'Big text', 'lespaul_domain_help' ),
					'example'     => '[big_text style=""]TEXT[/big_text]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="size-big"&gt;&lt;/span&gt;}.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Sets the icon color. If {colored} set, "Yes" icon will be green, "No" icon will be red.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {black}=d, {colored}, {white}.',
						),
					),
				),

				//boxes
				array(
					'titleDesc'   => __( 'Inserts a message box', 'lespaul_domain_help' ),
					'title'       => __( 'Boxes', 'lespaul_domain_help' ),
					'example'     => '[box color="green" icon="check" hero="" title="TEXT" transparent=""]TEXT[/box]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}=d, {green}, {blue}, {orange}, {red}.',
						),
						'icon' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {info}, {question}, {check}, {warning}, {cancel}.',
						),
						'hero' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to style the box as hero box.', 'lespaul_domain_help' )
						),
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional box title.', 'lespaul_domain_help' )
						),
						'transparent' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to display box with transparent background - only border will be visible.', 'lespaul_domain_help' )
						),
					),
				),

				//buttons
				array(
					'titleDesc'   => __( 'Inserts a button', 'lespaul_domain_help' ),
					'title'       => __( 'Buttons', 'lespaul_domain_help' ),
					'example'     => '[button align="" color="green" icon="" new_window="" size="l" style="" url="URL" id=""]TEXT[/button]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'icon' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Icon image class name. Please use shortcode generator for all possible icons.', 'lespaul_domain_help' )
						),
						'id' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional HTML "id" attribute for additional custom styling or JavaScript actions.', 'lespaul_domain_help' )
						),
						'new_window' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to open button link in new browser window or tab.', 'lespaul_domain_help' )
						),
						'size' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {s}, {m}=d, {l}, {xl}.',
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
						'url' => array(
							__( 'URL', 'lespaul_domain_help' ),
							__( 'Button link URL address.', 'lespaul_domain_help' )
						),
					),
				),

				//call to action
				array(
					'titleDesc'   => __( 'Creates call to action box', 'lespaul_domain_help' ),
					'title'       => __( 'Call to action', 'lespaul_domain_help' ),
					'example'     => '[call_to_action button_color="green" button_text="TEXT" button_url="URL" color="" new_window="" style="" title="TEXT" subtitle="TEXT"]TEXT[/call_to_action]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'button_color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}=d, {blue}, {orange}, {red}.',
						),
						'button_text' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Button text.', 'lespaul_domain_help' )
						),
						'button_url' => array(
							__( 'URL', 'lespaul_domain_help' ),
							__( 'Button link URL address.', 'lespaul_domain_help' )
						),
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'new_window' => array(
							__( 'yes (1) / no (0)', 'lespaul_domain_help' ),
							__( 'Set {1} to open button link in new browser window or tab.', 'lespaul_domain_help' )
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
						'title' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional call to action box title.', 'lespaul_domain_help' )
						),
						'subtitle' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional call to action box subtitle.', 'lespaul_domain_help' )
						),
					),
				),

				//columns
				array(
					'titleDesc'   => __( 'Creates columns', 'lespaul_domain_help' ),
					'title'       => __( 'Columns', 'lespaul_domain_help' ),
					'example'     => '[column size="1/4 last"]TEXT[/column]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'size' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {1/2}=d, {1/2 last}, {1/3}, {1/3 last}, {2/3}, {2/3 last}, {1/4}, {1/4 last}, {3/4}, {3/4 last}, {1/5}, {1/5 last}, {2/5}, {2/5 last}, {3/5}, {3/5 last}, {4/5}, {4/5 last}, {1/6}, {1/6 last}, {5/6}, {5/6 last}. ' . __( 'Set "last" when the column is the last one in row of columns.', 'lespaul_domain_help' ),
						),
					),
				),

				//divider
				array(
					'titleDesc'   => __( 'Inserts a divider (horizontal line)', 'lespaul_domain_help' ),
					'title'       => __( 'Divider', 'lespaul_domain_help' ),
					'example'     => '[divider type="star" space_before="" space_after="" opacity="" style="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'opacity' => array(
							__( 'number', 'lespaul_domain_help' ) . ' (0 - 100)',
							__( 'Opacity of the divider.', 'lespaul_domain_help' ),
						),
						'space_after' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the bottom margin size.', 'lespaul_domain_help' ),
						),
						'space_before' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Sets the top margin size.', 'lespaul_domain_help' ),
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
						'type' => array(
							__( 'predefined', 'lespaul_domain_help' ),
						$predefinedSentences['predefined'] . ' {plain}, {normal}, {dashed}, {diagonal}, {dotted}, {fading}, {star}, {shadow-top}, {shadow-bottom}.',
						),
					),
				),

				//dropcap
				array(
					'titleDesc'   => __( 'Creates a dropcap', 'lespaul_domain_help' ),
					'title'       => __( 'Dropcaps', 'lespaul_domain_help' ),
					'example'     => '[dropcap type="round" style=""]A[/dropcap]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
						'type' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {round}, {square}, {leaf}.',
						),
					),
				),

				//huge text
				array(
					'titleDesc'   => __( 'Enlarges text', 'lespaul_domain_help' ),
					'title'       => __( 'Huge text', 'lespaul_domain_help' ),
					'example'     => '[huge_text style=""]TEXT[/huge_text]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="size-huge"&gt;&lt;/span&gt;}.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Sets the icon color. If {colored} set, "Yes" icon will be green, "No" icon will be red.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {black}=d, {colored}, {white}.',
						),
					),
				),

				//icons
				array(
					'titleDesc'   => __( 'Creates a Font Awesome icon', 'lespaul_domain_help' ),
					'title'       => __( 'Icons', 'lespaul_domain_help' ),
					'example'     => '[icon size="64" type="icon-asterisk" style="" /]',
					'description' => array( $predefinedSentences['noclose'], __( 'Only predefined icons of Font Awesome can be displayed with this shortcode. For the icons list see below or use Shortcode Generator.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'size' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Set the icon size in pixels.', 'lespaul_domain_help' ),
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
						'type' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {' . implode( '}, {', $fontIcons ) . '}.',
						),
					),
				),

				//last update
				array(
					'titleDesc'   => __( 'Displays date and time when the posts or projects were last updated', 'lespaul_domain_help' ),
					'title'       => __( 'Last update', 'lespaul_domain_help' ),
					'example'     => '[last_update format="" item="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'format' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Sets the time format. By default it uses WordPress settings (set it in <strong>Settings > General > Date Format</strong>). You can, however, set any <a href="http://php.net/manual/en/function.date.php" target="_blank">PHP valid value</a> here.', 'lespaul_domain_help' ),
						),
						'item' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Choose which elements should be checked for the last update.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {posts}=d, {projects}.',
						),
					),
				),

				//lists
				array(
					'titleDesc'   => __( 'Styles unordered lists', 'lespaul_domain_help' ),
					'title'       => __( 'Lists (unordered)', 'lespaul_domain_help' ),
					'example'     => '[list bullet="icon-star"]&lt;ul&gt;...&lt;/ul&gt;[/list]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Place unordered list in between opening and closing shortcode tag.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'bullet' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Bullet (icon from icon font) class name. Please use shortcode generator for all possible bullets/icons.', 'lespaul_domain_help' )
						),
					),
				),

				//markers
				array(
					'titleDesc'   => __( 'Marks, highlights the text', 'lespaul_domain_help' ),
					'title'       => __( 'Markers (highlights)', 'lespaul_domain_help' ),
					'example'     => '[marker color="green" style=""]TEXT[/marker]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
					),
				),

				//pullquotes
				array(
					'titleDesc'   => __( 'Displays pullquotes', 'lespaul_domain_help' ),
					'title'       => __( 'Pullquotes', 'lespaul_domain_help' ),
					'example'     => '[pullquote align="left" style=""]TEXT[/pullquote]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
					),
				),

				//raw/pre text
				array(
					'titleDesc'   => __( 'Raw preformated text', 'lespaul_domain_help' ),
					'title'       => __( 'Raw, preformated text', 'lespaul_domain_help' ),
					'example'     => '[raw]TEXT[/raw]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;pre&gt;&lt;/pre&gt;}.', 'lespaul_domain_help' ) ),
				),

				//separator heading
				array(
					'titleDesc'   => __( 'Specially styled separator heading', 'lespaul_domain_help' ),
					'title'       => __( 'Separator heading', 'lespaul_domain_help' ),
					'example'     => '[separator_heading size="2" align="center" type="uniform" id=""]TEXT[/separator_heading]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Insets specially styled heading.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Sets the heading text alignment.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {center}, {right}.',
						),
						'id' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional HTML "id" attribute for additional custom styling or JavaScript actions.', 'lespaul_domain_help' )
						),
						'size' => array(
							__( 'number', 'lespaul_domain_help' ) . ' (1-6, 2*)',
							__( 'Set the heading size. Use one of HTML heading sizes: H1 being the biggest, H6 the smallest.', 'lespaul_domain_help' ),
						),
						'type' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Sets the separator heading type (or styling). Uniform styling is preset value and this will style all heading sizes the same. The normal type will style headings as predefined in the theme.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {uniform}=d, {normal}.',
						),
					),
				),

				//small text
				array(
					'titleDesc'   => __( 'Makes text smaller', 'lespaul_domain_help' ),
					'title'       => __( 'Small text', 'lespaul_domain_help' ),
					'example'     => '[small_text style=""]TEXT[/small_text]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;small&gt;&lt;/small&gt;}.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Sets the icon color. If {colored} set, "Yes" icon will be green, "No" icon will be red.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {black}=d, {colored}, {white}.',
						),
					),
				),

				//table
				array(
					'titleDesc'   => __( 'Creates table', 'lespaul_domain_help' ),
					'title'       => __( 'Table', 'lespaul_domain_help' ),
					'example'     => '[table class="" cols="TEXT" data="TEXT" heading_col="" separator="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'This will display simple data table. Perfectly suitable to display data from CSV files.', 'lespaul_domain_help' ), __( 'If you require more control over your table you can use sub-shortcodes for table row ([trow][/trow] or [trow_alt][/trow_alt] for alternatively styled table row), table cell ([tcell][/tcell]) and table heading cell ([tcell_heading][/tcell_heading]). All wrapped in [table][/table] parent shortcode without any parameter.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'class' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Applies custom CSS class on the table for custom stylings.', 'lespaul_domain_help' ),
						),
						'cols' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Columns headings. This setting is required as it sets the number of columns to which the data will be separated. Separate each column heading (title) with separator character ({;} is used by default). If you do not need the table headings to be displayed, just type in separators required times, such as {;;;} will separate data in the table into 4 (yes, 4 as there would be normally a column title after the last separator character, so basically keep in mind to insert the "columns count minus one" number of separators) columns but without any column heading.', 'lespaul_domain_help' ),
						),
						'data' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'The actual table data. Again, separate with separator character ({;} by default). This text can be as long as you wish as it will be separated into columns by the above setting.', 'lespaul_domain_help' ),
						),
						'heading_col' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'If you need to style any of the table columns as headings, set its position number here (starting with 1).', 'lespaul_domain_help' ),
						),
						'separator' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Separator character used to separate "cols" and "data" datas. Semicolon ({;}) is used by default.', 'lespaul_domain_help' ),
						),
					),
				),

				//uppercase text
				array(
					'titleDesc'   => __( 'Transforms letters of text to uppercase', 'lespaul_domain_help' ),
					'title'       => __( 'Uppercase letters', 'lespaul_domain_help' ),
					'example'     => '[uppercase]TEXT[/uppercase]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="uppercase"&gt;&lt;/span&gt;}.', 'lespaul_domain_help' ) ),
				),
			),

			//menu allowed shortcodes
			'menuAllowed' => array(
				//last update
				array(
					'titleDesc'   => __( 'Displays date and time when the posts or projects were last updated', 'lespaul_domain_help' ),
					'title'       => __( 'Last update', 'lespaul_domain_help' ),
					'example'     => '[last_update format="" item="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'format' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Sets the time format. By default it uses WordPress settings (set it in <strong>Settings > General > Date Format</strong>). You can, however, set any <a href="http://php.net/manual/en/function.date.php" target="_blank">PHP valid value</a> here.', 'lespaul_domain_help' ),
						),
						'item' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							__( 'Choose which elements should be checked for the last update.', 'lespaul_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {posts}=d, {projects}.',
						),
					),
				),

				//icons
				array(
					'titleDesc'   => __( 'Creates a Font Awesome icon', 'lespaul_domain_help' ),
					'title'       => __( 'Icons', 'lespaul_domain_help' ),
					'example'     => '[icon size="64" type="icon-asterisk" style="" /]',
					'description' => array( $predefinedSentences['noclose'], __( 'Only predefined icons of Font Awesome can be displayed with this shortcode. For the icons list see below or use Shortcode Generator.', 'lespaul_domain_help' ) ),
					'parameters'  => array(
						'size' => array(
							__( 'number', 'lespaul_domain_help' ),
							__( 'Set the icon size in pixels.', 'lespaul_domain_help' ),
						),
						'style' => array(
							__( 'text', 'lespaul_domain_help' ),
							__( 'Optional custom CSS styles applied in "style" attribute.', 'lespaul_domain_help' )
						),
						'type' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {' . implode( '}, {', $fontIcons ) . '}.',
						),
					),
				),

				//markers
				array(
					'titleDesc'   => __( 'Marks, highlights the text', 'lespaul_domain_help' ),
					'title'       => __( 'Markers (highlights)', 'lespaul_domain_help' ),
					'example'     => '[marker background_color="" color="green" text_color=""]TEXT[/marker]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'background_color' => array(
							__( 'color code', 'lespaul_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'lespaul_domain_help' )
						),
						'color' => array(
							__( 'predefined', 'lespaul_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'text_color' => array(
							__( 'color code', 'lespaul_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'lespaul_domain_help' )
						),
					),
				),

				//uppercase text
				array(
					'titleDesc'   => __( 'Transforms letters of text to uppercase', 'lespaul_domain_help' ),
					'title'       => __( 'Uppercase letters', 'lespaul_domain_help' ),
					'example'     => '[uppercase]TEXT[/uppercase]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="uppercase"&gt;&lt;/span&gt;}.', 'lespaul_domain_help' ) ),
				),
			),
		);

		//remove shortcodes from array if Custom Posts or Post Formats disabled
			if ( 'disable' === wm_option( 'cp-role-faq' ) )
				unset( $shortcodesHelp['special']['faq'] );
			if ( 'disable' === wm_option( 'cp-role-logos' ) )
				unset( $shortcodesHelp['special']['logos'] );
			if ( 'disable' === wm_option( 'cp-role-prices' ) )
				unset( $shortcodesHelp['special']['prices'] );
			if ( 'disable' === wm_option( 'cp-role-projects' ) ) {
				unset( $shortcodesHelp['special']['projects'] );
				unset( $shortcodesHelp['special']['projectAtts'] );
			}
			if ( 'disable' === wm_option( 'cp-role-staff' ) )
				unset( $shortcodesHelp['special']['staff'] );
			if ( wm_option( 'blog-no-format-quote' ) )
				unset( $shortcodesHelp['special']['testimonials'] );

	$visualEditor = '<h3>' . __( 'The <code>Styles</code> button', 'lespaul_domain_help' ) . '</h3>
		<p>' . sprintf( __( 'As the theme supports the true <abbr title="What You See Is What You Get">WYSIWYG</abbr> content editing, you can use the <code>Styles</code> button to create content elements on the fly. However, due to limitations, it is not possible to replicate all shortcodes with styles, nor can be applied style edited easily afterwards (you have to switch to "Text" (HTML) editor and edit the actual HTML code). If you need to remove all styles from specific element, select the element and click the "Remove formatting" button right from <code>Styles</code> button. For instructions on how to apply specific styles, hover over the question icon (<img src="%s" alt="" />) right from a certain style name in styles dropdown and/or on the styles group heading.', 'lespaul_domain_help' ), WM_ASSETS_ADMIN . 'img/icons/ico-help-inline.png' ) . '</p>
		<hr />
		<h3>' . __( 'The <code>[S]</code> ("Shortcodes Generator") button', 'lespaul_domain_help' ) . '</h3>
		<p>' . __( 'With Shortcode Generator it is very easy to insert any shortcode into post/page content. Simply select the right shortcode from the dropdown, set its options if required and click the "Insert into editor" button (or copy it and insert manually). The shortcode will be included on current cursor position.', 'lespaul_domain_help' ) . '</p>
		<p><strong><em>' . __( 'Note that Shortcode Generator is not compatible with Internet Explorer browsers.', 'lespaul_domain_help' ) . '</em></strong></p>
		<hr />
		<h3>' . __( 'The "New line" buttons', 'lespaul_domain_help' ) . '</h3>
		<p>' . __( 'Sometimes you will need to add a new line above or below certain element in content and sometimes this can be quite tricky to do, as you would have to switch to "Text" (HTML) editor to do so. The theme comes with 2 handy buttons to do this while not leaving the visual editor. Just place the cursor on the element before or after which you need the line to be inserted and click the appropriate button. You can find these 2 buttons left from <code>[S]</code> ("Shortcode Generator") button.', 'lespaul_domain_help' ) . '</p>
		';

	$menuIcons = '
	<div class="sticky-content">
		<h4>' . __( 'Copy the icon class', 'lespaul_domain_help' ) . ' <small class="stick-button" title="' . __( 'This is really usefull when editing long menus. Please keep the contextual help open.', 'lespaul_domain_help' ) . '">' . __( 'Stick table right', 'lespaul_domain_help' ) . '</small></h4>
		<div class="table-wrap">
			<table class="attributes" cellspacing="0">
				<thead>
					<tr>
						<th class="text-center">' . __( 'ID', 'lespaul_domain_help' ) . '</th>
						<th class="text-center">' . __( 'Icon', 'lespaul_domain_help' ) . '</th>
						<th>' . __( 'Icon class', 'lespaul_domain_help' ) . '</th>
					</tr>
				</thead>
				<tbody>';
		$i = 0;
		foreach ( $fontIcons as $icon ) {
			$menuIcons .= '<tr>
						<td class="text-center no-bg"><small>' . ++$i . '</small></td>
						<th class="text-center"><i class="' . $icon . '" title="' . $icon . '"></i></th>
						<td><input type="text" onfocus="this.select();" readonly="readonly" value="' . $icon . '" class="shortcode-in-list-table"></td>
					</tr>';
		}
		$menuIcons .= '</tbody>
			</table>
		</div>
	</div>';

	$pageExcerptText = ( wm_option( 'contents-page-excerpt' ) ) ? ( '<hr /><h3>' . __( 'Page excerpt', 'lespaul_domain_help' ) . '</h3><p>' . __( 'The theme allows you to set additional content area on certain page templates. To find out, whether the specific page template supports displaying of page excerpt content, click the "layout structure" link in "General" tab of page settings. The link will open popup window with an image of design elements layout for the page template.', 'lespaul_domain_help' ) . '</p>' ) : ( '' );





/* Contextual help main text array */
	$helpTexts = array(

		/*
		* PAGES
		*/
		'page' => array(
			array(
				'tabId'      => $prefix . 'page-settings',
				'tabTitle'   => __( 'Page Settings', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Page settings tabs', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please select a page template first. The page settings tabs will be displayed according to page template selected. Go through the available options for specific page template and set required ones to fit your needs.', 'lespaul_domain_help' ) . '</p>' . $pageExcerptText,
			),
			array(
				'tabId'      => $prefix . 'sliders',
				'tabTitle'   => __( 'Slider', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'How to set up a slider', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Click the "Slider" page settings tab. Choose a slider type from "Enable slider" dropdown option.', 'lespaul_domain_help' ) . '</p>
					<p>' . __( 'If you select "Video" slider, a single video will be displayed in the slider area and featured image will be set as video cover image.', 'lespaul_domain_help' ) . '</p>
					<p>' . __( 'For "Static featured image" make sure the featured image is set up. You can set to stretch the image to fit website box width, otherwise the actual image in full size will be displayed.', 'lespaul_domain_help' ) . '</p>
					<p>' . __( 'When "Custom slider" is selected, you can use any slider (plugin) installed. Just prepare the slider shortcode beforehand and insert it into "Custom slider shortcode" field. Basically, this slider type should display any shortcode.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* POSTS
		*/
		'post' => array(
			array(
				'tabId'      => $prefix . 'page-settings',
				'tabTitle'   => __( 'Post Settings', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Post settings tabs', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please select a post format first. Post format description will appear below the visual content editor. You can go through the available post options and set required ones to fit your needs.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Excerpt', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Post excerpt will be displayed in post list. If no excerpt set, a portion of post content will take its place. Post excerpt will also be displayed at the top of the post content on single post page. Please note that you will probably have to enable post excerpt field in "Screen Options" first.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP PROJECTS
		*/
		'wm_projects' => array(
			array(
				'tabId'      => $prefix . 'projects-settings',
				'tabTitle'   => __( 'Project Settings', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Project settings tabs', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available project options in project settings tabs and set required ones to fit your needs.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Excerpt', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'The theme displays project excerpt as basic project info next to project media (please check the "Layout" tab of project settings tabs for more info about project layout in use) and in projects list. By default project attributes will be displayed on top of project excerpt on single project page, but you can change this by inserting a <code>[project_attributes title="Project info" /]</code> shortcode anywhere in the project content or excerpt area.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP CONTENT MODULES
		*/
		'wm_modules' => array(
			array(
				'tabId'      => $prefix . 'content-module-settings',
				'tabTitle'   => __( 'Content Module Settings', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'What is Content Module?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Content Modules can be used as a content injection to various website areas. You can display it in page or post content or in any widget area (custom widget included). Content Modules can be styled as icon boxes, so they are perfect for your services presentation (for example). You can even conveniently group them using tags and then have a module generated randomly just by choosing the Content Module tag group.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Content Module settings tabs', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available Content Module options in Content Module settings tabs and set required ones to fit your needs. If "Icon box" option is checked, you can upload a custom icon as a featured image.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP FAQ
		*/
		'wm_faq' => array(
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP PRICES
		*/
		'wm_price' => array(
			array(
				'tabId'      => $prefix . 'prices-settings',
				'tabTitle'   => __( 'Price Settings', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'How to use prices?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Prices are being displayed in a table. Each price post is displayed as a column in price table. Please, make sure you set the price table (in "Price tables" metabox) for each price post. A price post can be displayed in several different price tables. One price table can display up to 6 prices (columns). Make sure all the price package/column features are displayed as an unordered list (they will be centered automatically in price table).', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Price settings tabs', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available price options in price settings tabs and set required ones to fit your needs.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP STAFF
		*/
		'wm_staff' => array(
			array(
				'tabId'      => $prefix . 'staff-settings',
				'tabTitle'   => __( 'Staff Settings', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Staff profile and Excerpt field', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Excerpts are only displayed when rich staff profiles are enabled. Excerpt will be displayed in staff members list as a basic information about the person but will not be displayed on staff member profile page. You can surely leave it blank, though. When visitors of your website clicks the staff profile image (featured image), they will be taken to staff member profile page.', 'lespaul_domain_help' ) . '</p>
					<p>' . __( 'Otherwise, if rich staff profiles are disabled, the whole content will be displayed in staff members list and clicking the person profile image will just open the image larger.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Staff info tabs', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available staff information options in each tab and set required ones to fit your needs.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'lespaul_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* WIDGETS
		*/
		'widgets' => array(
			array(
				'tabId'      => $prefix . 'widget-colors',
				'tabTitle'   => __( 'Widgets and widget areas', 'lespaul_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Why there are different colors of widgets and widget areas?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'This is to quickly distinguish the special widgets and widget areas. Custom theme widgets are colored dark as oposed to native or other WordPress widgets. Custom widget areas (the ones created in theme admin panel) are blue to separate them from predefined widget areas.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Why the widget area is not displayed on website?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Some widget areas, when displayed horizontally, can take maximum of 5 widgets. If there are more widgets in the area then the amount it can take in horizontal layout, the area will not be displayed. This information can be found in widget area description when you open the widget area. Widgets in these areas will be aligned to columns automatically. You can insert any widget area into a page or post content with <code>[widgets area="ID"]</code> shortcode. Note also that widget area will not be displayed when it contains no widgets.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Can I use shortcodes in widgets?', 'lespaul_domain_help' ) . '</h3>
					<p>' . sprintf( __( 'Yes, you can use shortcodes in Text widget. However, the theme offers much convenient way of inserting a formated content in widget areas just by using the <strong>%s Content Module</strong> widget. You can create a new Content Module custom post and edit it using visual editor and then include this specific content module post into widget area using the widget. You can find shortcode reference in other sections of this contextual help.', 'lespaul_domain_help' ), WM_THEME_NAME ) . '</p>
					<hr />
					<h3>' . __( 'Can I style widget titles?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'The theme allows to use bold (strong) and italic (emphasized) text stylings in widget titles. Just use <code>[s]TEXT[/s]</code> shortcode for strong text and <code>[e]TEXT[/e]</code> for emphasized text.', 'lespaul_domain_help' ) . '</p>',
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* MENUS
		*/
		'nav-menus' => array(
			array(
				'tabId'      => $prefix . 'general',
				'tabTitle'   => __( 'Theme Menu Locations', 'lespaul_domain_help' ),
				'tabContent' =>
					'<p>' . __( 'The theme allows you to create as many menus as you want. However these menus can be placed only into predefined locations. The main predefined menu locations are:', 'lespaul_domain_help' ) . '</p>
					<ol>
					<li><strong>' . __( 'Main navigation', 'lespaul_domain_help' ) . '</strong><br />' . __( 'This is main navigation area in the header of the website. The menu can be nested and hierarchically organised. Subtle animation is applied when revealing submenu items, but the menu will work even with JavaScript disabled.', 'lespaul_domain_help' ) . '</li>
					<li><strong>' . __( 'Footer menu', 'lespaul_domain_help' ) . '</strong><br />' . __( 'Usually you would display the same menu here as in "Main navigation" area is displayed. This menu is displayed without any submenu items in website footer area.', 'lespaul_domain_help' ) . '</li>
					<li><strong>' . __( 'Sitemap links', 'lespaul_domain_help' ) . '</strong><br />' . __( 'Instead of placing a list of pages into sitemap page, this offers a greater control over links. Most of the time you would display a main navigation menu here. <strong><em>Please note that menu title will be used as section title on sitemap page.</em></strong>', 'lespaul_domain_help' ) . '</li>
					</ol>
					<p>' . __( 'Besides these predefined menu locations there will be new ones created for each landing page. This will allow you to completly disable menu on specific landing pages (simply by not assigning any menu to the location) or to use different menu on such pages.', 'lespaul_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'advanced',
				'tabTitle'   => __( 'Advanced Menus', 'lespaul_domain_help' ),
				'tabContent' =>
					'<p>' . __( 'The theme allows you to put icons and description text into main menu items, style them as buttons or align them right. This is all possible by using CSS classes. First, please make sure the "CSS Classes" and "Description" option fields are enabled for menu items. You can check this in "Screen Options" tab after closing this contextual help.', 'lespaul_domain_help' ) . '</p>
					<p>' . __( 'You can also use simple format shortcodes in menu items (such as <code>[marker color="red"][/marker]</code>). For SEO purposes it is also recommended to set "Title Attribute" field.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'How to align a menu item to the right?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'You can align a certain menu item to the right just by adding an <code>alignright</code> class to it.', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'How to make the menu item a button?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please add one of the following CSS classes to the menu item:', 'lespaul_domain_help' ) . '</p>
					<ul>
						<li>' . __( 'Blue button:', 'lespaul_domain_help' ) . ' <code>button-blue</code></li>
						<li>' . __( 'Gray button:', 'lespaul_domain_help' ) . ' <code>button-gray</code></li>
						<li>' . __( 'Green button:', 'lespaul_domain_help' ) . ' <code>button-green</code></li>
						<li>' . __( 'Orange button:', 'lespaul_domain_help' ) . ' <code>button-orange</code></li>
						<li>' . __( 'Red button:', 'lespaul_domain_help' ) . ' <code>button-red</code></li>
					</ul>
					<hr />
					<h3>' . __( 'How to insert an icon into menu item?', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please use the below classes to insert a specific icon.', 'lespaul_domain_help' ) . '</p>'
					. $menuIcons,
			),

			array(
				'tabId'      => $prefix . 'shortcodes',
				'tabTitle'   => __( 'Shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['menuAllowed'] ),
			),
		),



		/*
		* ADMIN PANEL
		*/
		'appearance_page_' . WM_THEME_SHORTNAME . '-options' => array(
			array(
				'tabId'      => $prefix . 'general',
				'tabTitle'   => __( 'Admin Panel', 'lespaul_domain_help' ),
				'tabContent' => '<h4>' . __( 'Welcome to beautiful WebMan Admin Panel. It is as easy to use as it gets and offers several different intuitive options fields and input types which help to set the right option values.', 'lespaul_domain_help' ) . '</h4>
					<p>' . __( 'When you install the theme, you will be presented with <strong>Quickstart Guide</strong>. Please read through the steps in this guide and set what is required for your website. The guide is branded by WebMan, but as soon as you hit the "Save changes" button for the first time, the admin panel will be debranded. You can basically set the branding to your needs - even for WordPress administration.', 'lespaul_domain_help' ) . '</p>
					<p>' . __( 'Many options in this admin panel are predefined with default values. To reset the default value of an option just click the reset button (rounded arrows) right from the option (where applicable).', 'lespaul_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Backing up the theme settings', 'lespaul_domain_help' ) . '</h3>
					<p>' . __( 'Please navigate to <strong>Appearance > Options Export/Import</strong> to make backups of your theme settings or to load previously saved theme settings.', 'lespaul_domain_help' ) . '</p>',
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'lespaul_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),

	);

?>