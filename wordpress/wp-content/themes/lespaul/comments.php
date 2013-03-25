<?php
if ( post_password_required() )
	return;

if ( ( comments_open() || have_comments() ) && ! is_attachment() ) {
?>
<div id="comments" class="icon-comments">

<?php
//Do not delete these lines
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die ( 'Please do not load this page directly. Thanks!' );
?>

	<h2 id="comments-title">
	<?php printf( __( 'Comments (%s)', 'lespaul_domain' ), get_comments_number() ); ?>
	</h2>

<?php
if ( have_comments() ) :
?>
	<?php if ( ! comments_open() ) echo '<h3 class="comments-closed">' . __( 'Comments are closed. You can not add new comments.', 'lespaul_domain' ) . '</h3>'; ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { //are there comments to navigate through ?>
	<nav id="comment-nav-above" class="comments-nav">
		<h3 class="assistive-text invisible"><?php _e( 'Comment navigation', 'lespaul_domain' ); ?></h3>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older comments', 'lespaul_domain' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer comments &rarr;', 'lespaul_domain' ) ); ?></div>
	</nav>
	<?php } ?>

	<ol class="commentlist">
		<?php
		wp_list_comments( array(
			'type' => 'comment',
			'callback' => 'wm_comment'
			) );
		?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { //are there comments to navigate through ?>
	<nav id="comment-nav-below" class="comments-nav">
		<h3 class="assistive-text invisible"><?php _e( 'Comment navigation', 'lespaul_domain' ); ?></h3>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older comments', 'lespaul_domain' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer comments &rarr;', 'lespaul_domain' ) ); ?></div>
	</nav>
	<?php } ?>

<?php
endif;

if ( have_comments() )
	wm_pings()
?>

<?php
if ( comments_open() ) {
	//Comments form
	require_once( WM_OPTIONS . 'a-comments-form.php' );

	comment_form( $commentFormArgs );
}
?>

</div><!-- #comments -->
<?php } // /if comments open or have comments ?>