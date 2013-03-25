<?php if ( have_posts() ) : the_post(); ?>
<div class="article-content">
	<?php
	$terms = get_the_terms( $post->ID , 'department' );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$outTerms = $separator = '';
		foreach ( $terms as $term ) {
			$outTerms .= $separator . $term->name;
			$separator = ', ';
		}
		$terms = $outTerms;
	} else {
		$terms = false;
	}

	$out = '<li class="staff-name" title="' . __( 'Name', 'lespaul_domain_adm' ) . '"><strong>' . get_the_title() . '</strong>';
		if ( wm_meta_option( 'staff-position' ) )
			$out .= '<br /><span class="staff-position">' . wm_meta_option( 'staff-position' ) . '</span>';
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) )
			$out .= '<br /><span class="staff-department">' . $terms . '</span>';
	$out .= '</li>';
	if ( wm_meta_option( 'staff-phone' ) )
		$out .= '<li class="staff-phone" title="' . __( 'Phone', 'lespaul_domain_adm' ) . '"><strong>' . __( 'Phone', 'lespaul_domain_adm' ) . ': </strong>' . wm_meta_option( 'staff-phone' ) . '</li>';
	if ( wm_meta_option( 'staff-email' ) )
		$out .= '<li class="staff-email" title="' . __( 'Email', 'lespaul_domain_adm' ) . '"><strong>' . __( 'Email', 'lespaul_domain_adm' ) . ': </strong><a href="#" data-address="' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '" class="email-nospam">' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '</a></li>';
	if ( wm_meta_option( 'staff-phone' ) )
		$out .= '<li class="staff-linkedin" title="' . __( 'LinkedIn', 'lespaul_domain_adm' ) . '"><strong>' . __( 'LinkedIn', 'lespaul_domain_adm' ) . ': </strong><a href="' . esc_url( wm_meta_option( 'staff-linkedin' ) ) . '" target="_blank">' . get_the_title() . '</a></li>';
	if ( wm_meta_option( 'staff-skype' ) )
		$out .= '<li class="staff-skype" title="' . __( 'Skype', 'lespaul_domain_adm' ) . '"><strong>' . __( 'Skype', 'lespaul_domain_adm' ) . ': </strong><a href="skype:' . sanitize_title( wm_meta_option( 'staff-skype' ) ) . '?call">' . wm_meta_option( 'staff-skype' ) . '</a></li>';

	if ( $out )
		echo '<div class="staff-card alignleft">' . wm_thumb( array( 'size' => 'mobile' ) ) . '<ul>' . $out . '</ul></div>';
	?>

	<?php
	if ( is_single() ) {
		the_content();
	} else {
		wm_content_or_excerpt( $post );
	}
	?>
</div>
<?php wp_reset_query(); wm_after_post(); endif; ?>