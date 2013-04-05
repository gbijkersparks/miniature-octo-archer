<?php
wp_reset_query();
global $wp_query;

$thisPageId = null;

$user = wp_get_current_user();

$even  = '';
$order = 1;
$page  = ( get_query_var( 'paged' ) ) ? ( get_query_var( 'paged' ) ) : ( 1 );

if ( $page > 1 )
	$order = ( ( $page - 1 ) * get_query_var( 'posts_per_page' ) ) + 1;

$U_S_C_query = new WP_Query( array ( 
									'paged' => $paged,
									'post_type' => array('post', 'page'),
									'orderby' => 'date',
									'meta_key' => 'U_S_C_users',
									//'meta_value_num' => array($user->ID),
								)
						);

$filtered = array(0);
foreach ($U_S_C_query->posts as $key => $_post) {
	$U_S_C_usersMeta = get_post_meta($_post->ID, 'U_S_C_users',true);
	if( in_array($user->ID, $U_S_C_usersMeta)) {
		$filtered[] = $_post->ID;
	}
}

$wp_query = new WP_Query( array ( 
									//'post_type' => array('page', 'post'),
									//'paged' => $paged,
									'posts_per_page' => 10,
									'post__in' => $filtered,
								)
						);

if($user->ID != 0){
	if ( have_posts() ) {
	?>
		<?php wm_before_list(); ?>

		<section id="list-articles" class="list-articles list-search">

			<?php

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
} else {	
    wm_before_post();
	wm_start_post(); ?>

	<div id="login">
		
	<form name="loginform" id="loginform" action="<?php echo get_option('home') ?>/wp-login.php" method="post">
		<label><span><?php _e('Login') ?>:</span><input type="text" name="log" id="log" value="" size="20" tabindex="1" /></label>

		<label><span><?php _e('Senha') ?>:</span><input type="password" name="pwd" id="pwd" value="" size="20" tabindex="2" /></label>

		<p class="submit">
		<input type="submit" name="submit" id="submit" value="Login &raquo;" tabindex="3" />
		<input type="hidden" name="redirect_to" value="wp-admin/" />
		</p>

	</form>
	<ul>
		<li><a href="<?php echo get_option('home') ?>/wp-login.php?action=lostpassword" title="Password Lost and Found">Perdeu a senha?</a></li>
	</ul>
	</div>

	<?php wm_end_post(); 
}
wp_reset_query();
?>