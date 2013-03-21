<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* List portfolio projects
*****************************************************
*/

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/
add_action( 'widgets_init', 'reg_wm_projects_list' );



/*
* Widget registration
*/
function reg_wm_projects_list() {
	register_widget( 'wm_projects_list' );
} // /reg_wm_contact_info





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_projects_list extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id     = 'wm-projects-list';
		$prefix = ( wm_option( 'branding-panel-no-logo' ) || ! strpos( wm_option( 'branding-panel-logo' ), 'logo-' . WM_THEME_SHORTNAME . '-admin.png' ) ) ? ( '' ) : ( WM_THEME_NAME . ' ' );
		$name   = '<span>' . $prefix . __( 'Projects', 'lespaul_domain_adm' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'wm-projects-list',
			'description' => __( 'List of portfolio projects', 'lespaul_domain_adm' )
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
	function form( $instance ) {
		extract( $instance );
		$title    = ( isset( $title ) ) ? ( $title ) : ( null );
		$type     = ( isset( $type ) ) ? ( $type ) : ( null );
		$category = ( isset( $category ) ) ? ( $category ) : ( null );
		$count    = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 6 );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays list of projects from all or specific categories.', 'lespaul_domain_adm' ); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'lespaul_domain_adm' ); ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'List type:', 'lespaul_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>">
				<?php
				$options = array(
					'rand' => __( 'Random items', 'lespaul_domain_adm' ),
					'date' => __( 'Recent items', 'lespaul_domain_adm' )
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
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Projects source (category):', 'lespaul_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>[]" id="<?php echo $this->get_field_id( 'category' ); ?>" multiple="multiple">
				<?php
				$options = wm_tax_array( array(
						'allCountPost' => 'wm_projects',
						'allText'      => __( 'All projects', 'lespaul_domain_adm' ),
						'parentsOnly'  => true,
						'return'       => 'term_id',
						'tax'          => 'project-category',
					) );
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" ';
					if ( is_array( $category ) && in_array( $optId, $category ) )
						echo 'selected="selected"';
					elseif ( ! is_array( $category ) )
						selected( $category, $optId );
					?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
			<small><?php _e( 'Hold down [CTRL] key for multiselection', 'lespaul_domain_adm' ) ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Projects count:', 'lespaul_domain_adm' ); ?></label><br />
			<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $count; ?>" size="5" maxlength="2" />
		</p>
		<?php
	} // /form



	/*
	*****************************************************
	*      process and save the widget options
	*****************************************************
	*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']    = $new_instance['title'];
		$instance['type']     = $new_instance['type'];
		$instance['category'] = $new_instance['category'];
		$count                = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 6 );
		$instance['count']    = $count;

		return $instance;
	} // /update



	/*
	*****************************************************
	*      output the widget content
	*****************************************************
	*/
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$type     = ( isset( $type ) ) ? ( $type ) : ( 'rand' );
		$count    = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 12 );
		$category = ( isset( $category ) ) ? ( $category ) : ( array() );
		$category = array_filter( $category, 'wm_remove_zero_negative_array' );

		if ( isset( $category ) && is_array( $category ) )
			$category = $category;
		else
			$category = array();

		echo $before_widget;

		//if the title is not filled, no title will be displayed
		if ( isset( $title ) && '' != $title && ' ' != $title )
			echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;

		wp_reset_query();

		$queryArgs = array(
			'post_type'           => 'wm_projects',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $count,
			'orderby'             => $type,
			);
		if ( ! empty( $category ) )
			$queryArgs['tax_query'] = array( array(
				'taxonomy' => 'project-category',
				'field'    => 'id',
				'terms'    => $category
			) );

		$projects = new WP_Query( $queryArgs );
		if ( $projects->have_posts() ) :
			//HTML to display output
			?>
			<div class="portfolio-content">
			<?php
			$imgSize = 'widget';
			while ( $projects->have_posts() ) : $projects->the_post();
				?>
				<article title="<?php echo esc_attr( strip_tags( get_the_title() ) ); ?>" class="frame">
					<?php
					//image
					$image = ( has_post_thumbnail() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), $imgSize ) ) : ( array( WM_ASSETS_THEME . 'img/placeholder/widget.png' ) );
					echo '<div class="image-container"><a href="' . get_permalink() . '"><img src="' . esc_url( $image[0] ) . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" /></a></div>';
					?>
				</article>
				<?php
			endwhile;
			?>
			</div>
		<?php
		endif;
		wp_reset_query();

		echo $after_widget;
	} // /widget
} // /wm_projects_list

?>