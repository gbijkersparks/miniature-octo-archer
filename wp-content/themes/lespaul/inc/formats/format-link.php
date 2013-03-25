<div <?php post_class( 'article-content' ); ?>>
	<?php echo apply_filters( 'wm_default_content_filters', get_the_content() ); ?>
</div>

<?php
wm_meta();

if ( is_single() )
	wm_meta( array( 'tags' ), 'meta-bottom' );
?>