<?php
/**
 * Editor class for Soliloquy.
 *
 * @since 1.0.0
 *
 * @package	Soliloquy
 * @author	Thomas Griffin
 */
class Tgmsp_Editor {

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
	
		add_filter( 'media_buttons_context', array( $this, 'tinymce' ) );
		add_filter( 'post_updated_messages', array( $this, 'messages' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
	
	}
	
	/**
	 * Adds a custom slider insert button beside the media uploader button.
	 *
	 * @since 1.0.0
	 *
	 * @global string $pagenow The current page slug
	 * @global int $wp_version The current version of WordPress for this instance
	 * @param string $context The media buttons context HTML
	 * @return string $context Amended media buttons context HTML
	 */
	public function tinymce( $context ) {

		global $pagenow, $wp_version;
		$output = '';

		/** Only run in post/page creation and edit screens */
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
			if ( version_compare( $wp_version, '3.5', '<' ) ) {
				$img 	= '<img src="' . plugins_url( 'css/images/menu-icon.png', dirname( __FILE__ ) ) . '" width="16px" height="16px" alt="' . Tgmsp_Strings::get_instance()->strings['add_slider'] . '" />';
				$output = '<a href="#TB_inline?width=640&inlineId=choose-soliloquy-slider" class="thickbox" title="' . Tgmsp_Strings::get_instance()->strings['add_slider'] . '">' . $img . '</a>';
			} else {
				$img 	= '<span class="wp-media-buttons-icon" style="background-image: url(' . plugins_url( 'css/images/menu-icon.png', dirname( __FILE__ ) ) . '); margin-top: -1px;"></span>';
				$output = '<a href="#TB_inline?width=640&inlineId=choose-soliloquy-slider" class="thickbox button" title="' . Tgmsp_Strings::get_instance()->strings['add_slider'] . '" style="padding-left: .4em;">' . $img . ' ' . Tgmsp_Strings::get_instance()->strings['add_slider_editor'] . '</a>';
			}
		}

		return $context . $output;

	}
	
	/**
	 * Contextualizes the post updated messages.
	 *
	 * @since 1.0.0
	 *
	 * @global object $post The current Soliloquy post type object
	 * @param array $messages Array of default post updated messages
	 * @return array $messages Amended array of post updated messages
	 */
	public function messages( $messages ) {

		global $post;

		$messages['soliloquy'] = apply_filters( 'tgmsp_slider_messages', array(
			0	=> '',
			1	=> Tgmsp_Strings::get_instance()->strings['pm_general'],
			2	=> Tgmsp_Strings::get_instance()->strings['pm_cf_updated'],
			3	=> Tgmsp_Strings::get_instance()->strings['pm_cf_deleted'],
			4	=> Tgmsp_Strings::get_instance()->strings['pm_general'],
			5	=> isset( $_GET['revision'] ) ? sprintf( Tgmsp_Strings::get_instance()->strings['pm_revision'], wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6	=> Tgmsp_Strings::get_instance()->strings['pm_published'],
			7	=> Tgmsp_Strings::get_instance()->strings['pm_saved'],
			8	=> Tgmsp_Strings::get_instance()->strings['pm_submitted'],
			9	=> sprintf( Tgmsp_Strings::get_instance()->strings['pm_scheduled'], date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
			10	=> Tgmsp_Strings::get_instance()->strings['pm_draft']
		) );

		/** Return the amended array of post updated messages */
		return $messages;

	}
	
	/**
	 * Outputs the jQuery and HTML necessary to insert a slider when the user
	 * uses the button added to the media buttons above TinyMCE.
	 *
	 * @since 1.0.0
	 *
	 * @global string $pagenow The current page slug
	 */
	public function admin_footer() {

		global $pagenow;

		/** Only run in post/page creation and edit screens */
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
			/** Get all published sliders */
			$sliders = get_posts( array( 'post_type' => 'soliloquy', 'posts_per_page' => -1, 'post_status' => 'publish' ) );

			?>
			<script type="text/javascript">
				function insertSlider() {
					var id = jQuery('#select-soliloquy-slider').val();

					/** Return early if no slider is selected */
					if ( '' == id ) {
						alert('<?php echo esc_js( Tgmsp_Strings::get_instance()->strings['slider_select'] ); ?>');
						return;
					}

					/** Send the shortcode to the editor */
					window.send_to_editor('[soliloquy id="' + id + '"]');
				}
			</script>

			<div id="choose-soliloquy-slider" style="display: none;">
				<div class="wrap" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
					<div id="icon-soliloquy" class="icon32" style="background: url(<?php echo plugins_url( 'css/images/title-icon.png', dirname( __FILE__ ) ); ?>) no-repeat scroll 0 50%; height: 36px; width: 36px;"><br></div>
					<h2><?php echo Tgmsp_Strings::get_instance()->strings['slider_choose']; ?></h2>
					<?php do_action( 'tgmsp_before_slider_insertion', $sliders ); ?>
					<p style="font-weight: bold; padding-bottom: 10px;"><?php echo Tgmsp_Strings::get_instance()->strings['slider_select_desc']; ?></p>
					<select id="select-soliloquy-slider" style="clear: both; display: block; margin-bottom: 1em;">
					<?php
						foreach ( $sliders as $slider )
							echo '<option value="' . absint( $slider->ID ) . '">' . esc_attr( $slider->post_title ) . '</option>';
					?>
					</select>

					<input type="button" id="soliloquy-insert-slider" class="button-primary" value="<?php echo esc_attr( Tgmsp_Strings::get_instance()->strings['slider_select_insert'] ); ?>" onclick="insertSlider();" />
					<a id="soliloquy-cancel-slider" class="button-secondary" onclick="tb_remove();" title="<?php echo esc_attr( Tgmsp_Strings::get_instance()->strings['slider_select_cancel'] ); ?>"><?php echo Tgmsp_Strings::get_instance()->strings['slider_select_cancel']; ?></a>
					<?php do_action( 'tgmsp_after_slider_insertion', $sliders ); ?>
					<style type="text/css">@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min--moz-device-pixel-ratio: 1.5), only screen and (min-device-pixel-ratio: 1.5) { #icon-soliloquy[style] { background-image: url(<?php echo plugins_url( 'css/images/title-icon@2x.png', dirname( __FILE__ ) ); ?>) !important; background-size: 36px 36px !important; } }</style>
				</div>
			</div>
			<?php
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