<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* List of posts
*****************************************************
*/

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/
add_action( 'widgets_init', 'reg_wm_post_list' );



/*
* Widget registration
*/
function reg_wm_post_list() {
	register_widget( 'wm_post_list' );
} // /reg_wm_contact_info





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_post_list extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'wm-posts-list';
		$prefix = ( wm_option( 'branding-panel-no-logo' ) || ! strpos( wm_option( 'branding-panel-logo' ), 'logo-' . WM_THEME_SHORTNAME . '-admin.png' ) ) ? ( '' ) : ( WM_THEME_NAME . ' ' );
		$name   = '<span>' . $prefix . __( 'Posts', 'lespaul_domain_adm' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'wm-posts-list',
			'description' => __( 'List of recent, popular, random or upcoming posts with thumbnail images', 'lespaul_domain_adm' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
	} // /__construct



	/*
	*****************************************************
	*      widget options form in admin
	*****************************************************
	*/
	public function form( $instance ) {
		extract( $instance );
		$title         = ( isset( $title ) ) ? ( $title ) : ( null );
		$type          = ( isset( $type ) ) ? ( $type ) : ( null );
		$excerptLength = ( isset( $excerptLength ) ) ? ( absint( $excerptLength ) ) : ( 10 );
		$category      = ( isset( $category ) ) ? ( $category ) : ( null );
		$count         = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 5 );
		$date          = ( isset( $date ) ) ? ( $date ) : ( null );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays advanced posts list. You can set multiple post categories, just press [CTRL] key and click the category names.', 'lespaul_domain_adm' ) ?><br /><?php _e( 'Please note that this widget does not display Quote and Status post formats.', 'lespaul_domain_adm' ) ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'lespaul_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'List type:', 'lespaul_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>">
				<?php
				$options = array(
					'date,DESC,publish'          => __( 'Recent posts', 'lespaul_domain_adm' ),
					'comment_count,DESC,publish' => __( 'Popular posts', 'lespaul_domain_adm' ),
					'rand,DESC,publish'          => __( 'Random posts', 'lespaul_domain_adm' ),
					'date,DESC,future'           => __( 'Upcoming posts', 'lespaul_domain_adm' )
					);
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" '; selected( $type, $optId ); ?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'excerptLength' ); ?>"><?php _e( 'Excerpt length in:', 'lespaul_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'excerptLength' ); ?>" id="<?php echo $this->get_field_id( 'excerptLength' ); ?>">
				<?php
				$options = array(
					0  => 0,
					5  => 5,
					10 => 10,
					15 => 15,
					20 => 20,
					25 => 25,
					30 => 30,
					35 => 35,
					40 => 40
					);
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" '; selected( $excerptLength, $optId ); ?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Posts source (category):', 'lespaul_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>[]" id="<?php echo $this->get_field_id( 'category' ); ?>" multiple="multiple">
				<?php
				$options = wm_tax_array( array( 'return' => 'term_id' ) );
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" ';
					if ( is_array( $category ) && in_array( $optId, $category ) )
						echo 'selected="selected"';
					else
						selected( $category, $optId );
					?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
			<small><?php _e( 'Hold down [CTRL] key for multiselection', 'lespaul_domain_adm' ) ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Posts count:', 'lespaul_domain_adm' ) ?></label><br />
			<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $count; ?>" size="5" maxlength="2" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="checkbox" <?php checked( $date, 'on' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Disable publish date', 'lespaul_domain_adm' ); ?></label>
		</p>
		<?php
	} // /form



	/*
	*****************************************************
	*      process and save the widget options
	*****************************************************
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']         = $new_instance['title'];
		$instance['type']          = $new_instance['type'];
		$instance['excerptLength'] = absint( $new_instance['excerptLength'] );
		$instance['category']      = $new_instance['category'];
		$count                     = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 5 );
		$instance['count']         = $count;
		$instance['date']          = $new_instance['date'];

		return $instance;
	} // /update



	/*
	*****************************************************
	*      output the widget content
	*****************************************************
	*/
	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$type          = ( isset( $type ) ) ? ( explode( ',', $type ) ) : ( array( 'date', 'DESC', 'publish' ) );
		$excerptLength = ( isset( $excerptLength ) ) ? ( absint( $excerptLength ) ) : ( 10 );
		$count         = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 5 );

		if ( isset( $category ) && is_array( $category ) )
			$category = implode( ',', $category );
		elseif ( isset( $category ) )
			$category = $category;
		else
			$category = 0;

		$class = '';
		if ( isset( $date ) )
			$class .= ' no-date';
		if ( 0 === $excerptLength )
			$class .= ' no-excerpt';

		echo $before_widget;

		//if the title is not filled, no title will be displayed
		if ( isset( $title ) && '' != $title && ' ' != $title )
			echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;

		wp_reset_query();

		$posts = new WP_Query( array(
				'posts_per_page'      => $count,
				'ignore_sticky_posts' => 1,
				'orderby'             => $type[0],
				'order'               => $type[1],
				'post_status'         => $type[2],
				'cat'                 => $category,
				'tax_query'           => array( array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array( 'post-format-quote', 'post-format-status' ),
					'operator' => 'NOT IN',
					) )
			) );

		if ( $posts->have_posts() ) :
			//HTML to display output
			?>
			<ul class="<?php echo $class; ?>">
			<?php
			$imgSize = 'widget';

			while ( $posts->have_posts() ) : $posts->the_post();
				$out = '<li>';

				$content = $posts->post->post_excerpt . $posts->post->post_content;

				if ( has_post_format( 'audio' ) || has_post_format( 'video' ) ) {
					$mediaURL = '';

					//search for the first URL in content
					preg_match( '/http(.*)/', strip_tags( $content ), $matches );
					if ( isset( $matches[0] ) )
						$mediaURL = trim( $matches[0] );

					//remove <a> tag containing URL
					$content = preg_replace( '/<a(.*?)>http(.*?)<\/a>/', '', $content );
					//remove any video URL left in content
					if ( $mediaURL )
						$content = str_replace( array( $mediaURL, $mediaURL . ' ', ' ' . $mediaURL ), '', $content );
				}

				//image
				$format = ( get_post_format() ) ? ( get_post_format() ) : ( 'pencil' );
				$thumb  = ( has_post_thumbnail() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), $imgSize ) ) : ( array( '' ) );
				$image  = ( $thumb[0] ) ? ( '<img src="' . esc_url( $thumb[0] ) . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" />' ) : '<i class="wmicon-' . $format . '"></i>';

				$out .= '<div class="image-container"><a href="' . get_permalink() . '">' . $image . '</a></div>';

				//title
				$out .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';

				//date
				if ( ! isset( $date ) )
					$out .= '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="date">' . esc_html( get_the_date() ) . '</time>';

				//excerpt
				if ( isset( $excerptLength ) && $excerptLength ) {
					$content = wm_string_length( strip_tags( $content ), $excerptLength, '&hellip;' );
					if ( $content )
						$out .= '<div class="excerpt">' . $content . '</div>';
				}

				echo $out . '</li>';
			endwhile;
			?>
			</ul>
			<?php
		endif;
		wp_reset_query();

		echo $after_widget;
	} // /widget

} // /wm_post_list

?>