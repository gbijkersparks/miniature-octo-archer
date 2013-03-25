<?php
wp_reset_query();

$thisPageId = null;

if ( have_posts() ) {
?>
	<?php wm_before_list(); ?>

	<section id="list-articles" class="list-articles list-search">

		<?php
		$even  = '';
		$order = 1;
		$page  = ( get_query_var( 'paged' ) ) ? ( get_query_var( 'paged' ) ) : ( 1 );

		if ( $page > 1 )
			$order = ( ( $page - 1 ) * get_query_var( 'posts_per_page' ) ) + 1;

		while ( have_posts() ) :
			the_post();

			$countOK = true;
			$out     = '';

			if ( 10 > $order )
				$orderClass = ' order-1-9';
			elseif ( 10 <= $order && 100 > $order )
				$orderClass = ' order-10-99';
			elseif ( 100 <= $order && 1000 > $order )
				$orderClass = ' order-100-999';

			//check if page allowed to display
			if ( 'page' === $post->post_type ) {
				$allowed = ( wm_option( 'access-client-area' ) ) ? ( wm_restriction_page() ) : ( true );
				if ( ! $allowed )
					$countOK = false;
			}

			$titleWithImage = '';
			if ( has_post_thumbnail()) {
				$titleWithImage .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '" class="alignright frame">';
				$titleWithImage .= get_the_post_thumbnail( null, 'widget' );
				$titleWithImage .= '</a>';
			}
			$titleWithImage .= '<a href="' . get_permalink() . '">';
			$titleWithImage .= get_the_title();
			$titleWithImage .= '</a>';

			$out .= '<article>';
			$out .= '<div class="article-content"><span class="numbering' . $orderClass . '">' . $order . '</span>';
			$out .= '<h2 class="post-title">' . $titleWithImage . '</h2>';
			if ( get_the_excerpt() )
				$out .= '<div class="excerpt"><p>' . strip_tags( apply_filters( 'convert_chars', strip_shortcodes( get_the_excerpt() ) ) ) . '</p><p>' . wm_more( 'nobtn', false ) . '</p></div>';
			$out .= '</div>';
			$out .= ( 'page' === $post->post_type ) ? ( wm_meta( array( 'permalink' ), null, 'footer', false ) ) : ( wm_meta( null, null, 'footer', false ) );
			$out .= '</article>';

			//the actual output
			if ( $out && $countOK ) {
				echo '<div class="search-item' . $even . '">' . $out . '</div>';

				$even = ( $even ) ? ( '' ) : ( ' even' );

				$order++;
			}
		endwhile;
		?>

	</section> <!-- /list-articles -->

	<?php wm_after_list(); ?>

<?php
} else {
	wm_not_found();
}
wp_reset_query();
?>