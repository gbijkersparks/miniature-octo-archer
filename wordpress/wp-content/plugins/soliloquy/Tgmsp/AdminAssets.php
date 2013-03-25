<?php
/**
 * AdminAseets class for Soliloquy.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy
 * @author	Thomas Griffin
 */
class Tgmsp_AdminAssets {

	/**
	 * Holds a copy of the object for easy reference.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor. Hooks all interactions to initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
	
		self::$instance = $this;
		
		add_image_size( 'soliloquy-thumb', 115, 115, true );
		
		/** Load dev scripts and styles if in Soliloquy dev mode */
		$dev = defined( 'SOLILOQUY_DEV' ) && SOLILOQUY_DEV ? '-dev' : '';
	
		/** Register scripts and styles */
		wp_register_script( 'soliloquy-admin', plugins_url( 'js/admin' . $dev . '.js', dirname( __FILE__ ) ), array( 'jquery' ), '1.0.0', true );
		wp_register_style( 'soliloquy-admin', plugins_url( 'css/admin' . $dev . '.css', dirname( __FILE__ ) ) );
		
		/** Load assets */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
	
	}
	
	/**
	 * Enqueue custom scripts and styles for the Soliloquy post type.
	 *
	 * @since 1.0.0
	 *
	 * @global int $id The current post ID
	 * @global object $post The current post object
	 */
	public function load_assets() {

		global $id, $post;

		/** Load for any Soliloquy screen */
		if ( Tgmsp::is_soliloquy_screen() )
			wp_enqueue_style( 'soliloquy-admin' );

		/** Only load for the Soliloquy post type add and edit screens */
		if ( Tgmsp::is_soliloquy_add_edit_screen() ) {
			/** Send the post ID along with our script */
			$post_id = ( null === $id ) ? $post->ID : $id;

			/** Store script arguments in an array */
			$args = apply_filters( 'tgmsp_slider_object_args', array(
				'alt'			=> Tgmsp_Strings::get_instance()->strings['image_alt'],
				'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
				'caption'		=> Tgmsp_Strings::get_instance()->strings['image_caption'],
				'delete_nag'	=> Tgmsp_Strings::get_instance()->strings['confirm_delete'],
				'duration'		=> 600,
				'existing'		=> Tgmsp_Strings::get_instance()->strings['link_existing'],
				'id'			=> $post_id,
				'height'		=> 300,
				'link'			=> Tgmsp_Strings::get_instance()->strings['image_link'],
				'linknonce'		=> wp_create_nonce( 'soliloquy_linking' ),
				'linknormal'	=> Tgmsp_Strings::get_instance()->strings['image_link_normal'],
				'linktitle'		=> Tgmsp_Strings::get_instance()->strings['image_url_title'],
				'linktype'		=> Tgmsp_Strings::get_instance()->strings['image_link_type'],
				'linkvideo'		=> Tgmsp_Strings::get_instance()->strings['image_link_video'],
				'loading'		=> Tgmsp_Strings::get_instance()->strings['loading'],
				'metadesc'		=> Tgmsp_Strings::get_instance()->strings['image_meta'],
				'metanonce'		=> wp_create_nonce( 'soliloquy_meta' ),
				'metatitle'		=> Tgmsp_Strings::get_instance()->strings['update_meta'],
				'modify'		=> Tgmsp_Strings::get_instance()->strings['modify_image'],
				'modifytb'		=> Tgmsp_Strings::get_instance()->strings['modify_image_tb'],
				'nonce'			=> wp_create_nonce( 'soliloquy_uploader' ),
				'noresults'		=> Tgmsp_Strings::get_instance()->strings['no_results'],
				'remove'		=> Tgmsp_Strings::get_instance()->strings['remove_image'],
				'removenonce'	=> wp_create_nonce( 'soliloquy_remove' ),
				'removing'		=> Tgmsp_Strings::get_instance()->strings['removing'],
				'saving'		=> Tgmsp_Strings::get_instance()->strings['saving'],
				'search'		=> Tgmsp_Strings::get_instance()->strings['search'],
				'searching'		=> Tgmsp_Strings::get_instance()->strings['searching'],
				'sortnonce'		=> wp_create_nonce( 'soliloquy_sortable' ),
				'speed'			=> 7000,
				'spinner'		=> plugins_url( 'css/images/loading.gif', dirname( __FILE__ ) ),
				'savemeta'		=> Tgmsp_Strings::get_instance()->strings['save_meta'],
				'upload'		=> Tgmsp_Strings::get_instance()->strings['upload_images_tb'],
				'tab'			=> Tgmsp_Strings::get_instance()->strings['new_tab'],
				'title'			=> Tgmsp_Strings::get_instance()->strings['image_title'],
				'url'			=> Tgmsp_Strings::get_instance()->strings['image_url'],
				'width'			=> 600
			) );

			wp_enqueue_script( 'soliloquy-admin' );
			wp_localize_script( 'soliloquy-admin', 'soliloquy', $args );
			wp_enqueue_script( 'jquery-ui-sortable' );
			add_thickbox();
		}

	}
	
	/**
	 * Getter method for retrieving the object instance.
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
	
		return self::$instance;
	
	}
	
}