<?php if ( have_posts() ) : the_post(); ?>

<?php wm_before_post(); ?>

<div class="article-content">
	<?php wm_start_post(); ?>

	<?php the_content(); ?>

	<div class="sitemap">

		<?php
		//Custom sitemap menu (instead of list of pages)
		$columns = '11';

		$locations = get_nav_menu_locations();
		$menuObj   = wp_get_nav_menu_object( $locations['sitemap-links'] );
		$menuName  = ( $menuObj ) ? ( $menuObj->name ) : ( '' );
		$outMenu   = wp_nav_menu( array(
				'theme_location'  => 'sitemap-links',
				'menu'            => null,
				'container'       => null,
				'container_class' => null,
				'container_id'    => null,
				'menu_class'      => '',
				'menu_id'         => null,
				'echo'            => false,
				'fallback_cb'     => '',
				'before'          => null,
				'after'           => null,
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '<div class="column col-13 last sitemap-menu"><h3>' . $menuName . '</h3><ul>%3$s</ul></div>',
				'depth'           => 0,
				'walker'          => ( has_nav_menu( 'sitemap-links' ) ) ? ( new wm_widget_walker() ) : ( null )
			) );

		if ( $outMenu )
			$columns = '23';
		?>

		<div class="column col-<?php echo $columns; ?>">
			<?php
			//20 latest blog posts
			query_posts( array(
					'posts_per_page' => 20
				) );

			if ( have_posts() ) {
				$out  = '<div class="column col-12"><h3>' . __( 'Latest blog posts', 'lespaul_domain' ) . '</h3>';
				$out .= '<ul class="no-menu">';
				while ( have_posts() ) :
					the_post();
					$out .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
				endwhile;
				$out .= '</ul></div>';
				echo $out;
			}

			the_widget( 'wm_projects_list', array(
					'title' => __( 'Latest projects', 'lespaul_domain' ),
					'type'  => 'date',
					'count' => 20
				), array(
					'before_widget' => '<div class="column col-12 last widget wm-projects-list">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3>',
					'after_title'   => '</h3>'
				) );
			?>

			<?php echo do_shortcode( '[divider type="dotted" /]' ); ?>

			<div class="column col-12">
				<h3><?php _e( 'Blog categories', 'lespaul_domain' ); ?></h3>
				<ul class="no-menu">
				<?php wp_list_categories( array(
					'orderby'      => 'name',
					'hierarchical' => false,
					'show_count'   => true,
					'title_li'     => null
					) ); ?>
				</ul>
			</div>

			<div class="column col-12 last">
				<h3><?php _e( 'Monthly archives', 'lespaul_domain' ); ?></h3>
				<ul class="no-menu">
				<?php wp_get_archives( 'type=monthly&show_post_count=1' ); ?>
				</ul>
			</div>

		</div>

		<?php
		if ( $outMenu )
			echo do_shortcode( $outMenu );
		?>

	</div> <!-- /sitemap -->

	<?php wm_end_post(); ?>
</div>

<?php wp_reset_query(); wm_after_post(); endif; ?>