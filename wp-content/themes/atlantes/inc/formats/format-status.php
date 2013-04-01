<div <?php post_class( 'article-content' ); ?>>
	<header>
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 180 ); ?>
	</header>
	<div class="status-text">
		<?php echo apply_filters( 'wm_default_content_filters', get_the_content() ); ?>
	</div>
</div>

<?php
wm_meta();

if ( is_single() )
	wm_meta( array( 'tags' ), 'meta-bottom' );
?>