<?php
/*
*****************************************************
*      !LesPaul WordPress Theme
*
*      Author: WebMan - www.webmandesign.eu
*      http://www.webmandesign.eu
*****************************************************
*/



/*
* Translation / Localization
*
* The theme splits translation into 4 sections:
*  1) website front-end
*  2) main WordPress admin extensions (like post metaboxes)
*  3) theme's contextual help texts
*  4) theme admin panel (accessed by administrators only)
* You can find all theme translation .PO files (and place translated .MO files) in "lespaul/langs/" folder and subsequent subfolders.
*
* Theme uses these textdomains:
*  1) lespaul_domain
*  2) lespaul_domain_adm
*  3) lespaul_domain_help
*  4) lespaul_domain_panel
*/


//Getting theme data
	$shortname = get_template();

	//WP 3.4+ only
	$themeData     = wp_get_theme( $shortname );
	$themeName     = $themeData->Name;
	$themeVersion  = $themeData->Version;
	$pageTemplates = wp_get_theme()->get_page_templates();

	if( ! $themeVersion )
		$themeVersion = '';

	$options   = $options_ei = $widgetAreas = array();
	$shortname = str_replace( '-v' . $themeVersion, '', $shortname );



//Theme constants
	//Basic constants
		define( 'WM_THEME_NAME',      $themeName );
		define( 'WM_THEME_SHORTNAME', $shortname );
		define( 'WM_THEME_VERSION',   $themeVersion );

		define( 'WM_THEME_SETTINGS_PREFIX', 'wm-' );
		define( 'WM_THEME_SETTINGS',        WM_THEME_SETTINGS_PREFIX . $shortname );
		define( 'WM_THEME_SETTINGS_META',   '_' . WM_THEME_SETTINGS_PREFIX . 'meta' ); //underscore makes them hidden
		define( 'WM_THEME_SETTINGS_STATIC', WM_THEME_SETTINGS . '-static' );

		define( 'WM_ADMIN_LIST_THUMB',         '64x64' ); //thumbnail size (width x height) on post/page/custom post listings
		define( 'WM_CSS_EXPIRATION',           ( WP_DEBUG || 2 > intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) ? ( 30 ) : ( 1209600 ) ); //60sec * 60min * 24hours * 14days
		define( 'WM_DEFAULT_EXCERPT_LENGTH',   40 ); //words count
		define( 'WM_SCRIPTS_VERSION',          20130306 );
		define( 'WM_TWITTER_CACHE_EXPIRATION', 900 ); //60sec * 15min
		define( 'WM_WP_COMPATIBILITY',         3.5 );

	//Directories
		define( 'WM_CLASSES',    get_template_directory() . '/library/classes/' );
		define( 'WM_CUSTOMS',    get_template_directory() . '/library/custom-posts/' );
		define( 'WM_FONT',       get_template_directory() . '/assets/font/' );
		define( 'WM_HELP',       get_template_directory() . '/library/help/' );
		define( 'WM_HOOKS',      get_template_directory() . '/library/hooks/' );
		define( 'WM_LANGUAGES',  get_template_directory() . '/langs' );
		define( 'WM_LIBRARY',    get_template_directory() . '/library/' );
		define( 'WM_META',       get_template_directory() . '/library/meta/' );
		define( 'WM_OPTIONS',    get_template_directory() . '/library/options/' );
		define( 'WM_SHORTCODES', get_template_directory() . '/library/shortcodes/' );
		define( 'WM_SKINS',      get_template_directory() . '/assets/css/skins/' );
		define( 'WM_STYLES',     get_template_directory() . '/library/styles/' );
		define( 'WM_WIDGETS',    get_template_directory() . '/library/widgets/' );

	//URLs
		define( 'WM_ASSETS_THEME', get_template_directory_uri() . '/assets/' );
		define( 'WM_ASSETS_ADMIN', get_template_directory_uri() . '/library/assets/' );

	//Theme layout constants
		//"left", "right", "none"
		define( 'WM_SIDEBAR_FALLBACK',         'default' ); //fallback sidebar ID
		define( 'WM_SIDEBAR_DEFAULT_POSITION', 'right' );
		define( 'WM_SIDEBAR_WIDTH',            ' three pane; nine pane' );
		//text color switcher treshold
		define( 'WM_COLOR_TRESHOLD', 140 );
		//default logo size
		define( 'WM_DEFAULT_LOGO_SIZE', '218,38' );

	//Others
		define( 'WM_MSG_ACCESS_DENIED', '<article class="main twelve pane">[box color="red" icon="warning"]' . __( 'You do not have sufficient rights to display this page.', 'lespaul_domain' ) . '[/box]</article>' );
		define( 'WM_ONLINE_MANUAL_URL', 'http://www.webmandesign.eu/manual/' . $shortname . '/' );



//Global variables
	//Custom post WordPress admin menu position
		if ( ! isset( $cpMenuPosition ) )
			$cpMenuPosition = array(
					'projects'        => 30,
					'logos'           => 33,
					'content-modules' => 39,
					'faq'             => 42,
					'prices'          => 45,
					'staff'           => 48
				);

	//Get theme options
		$themeOptions = get_option( WM_THEME_SETTINGS );

	//Available social icons
		$socialIconsArray = array( 'Behance', 'Blogger', 'Delicious', 'DeviantART', 'Digg', 'Dribbble', 'Facebook', 'Flickr', 'Forrst', 'GitHub', 'Google+', 'Instagram', 'LinkedIn', 'MySpace', 'Pinterest', 'Reddit', 'RSS', 'Skype', 'SoundCloud', 'StumbleUpon', 'Tumblr', 'Twitter', 'Vimeo', 'WordPress', 'YouTube' );

	//Skin attributes
		$skinAttsStatic = array(
				'package'             => 'Package',
				'skin'                => 'Skin',
				'description'         => 'Description',
				'version'             => 'Version',
				'author'              => 'Author',

				'font-primary-tags'   => 'Font primary elements',
				'font-secondary-tags' => 'Font secondary elements',

				'border-toppanel'     => 'Top panel bordered',
				'border-header'       => 'Header bordered',
				'border-navigation'   => 'Navigation bordered',
				'border-slider'       => 'Slider bordered',
				'border-mainheading'  => 'Main heading bordered',
				'border-pageexcerpt'  => 'Page excerpt bordered',
				'border-content'      => 'Content bordered',
				'border-abovefooter'  => 'Above footer bordered',
				'border-breadcrumbs'  => 'Breadcrumbs bordered',
				'border-footer'       => 'Footer bordered',
				'border-bottom'       => 'Bottom bordered',
			);



//Global functions
require_once( WM_LIBRARY . 'core.php' );
//Theme settings
require_once( WM_LIBRARY . 'setup.php' );
//Admin functions
require_once( WM_LIBRARY . 'admin.php' );
require_once( WM_LIBRARY . 'm_super_dump.php');


?>