/**
 * jQuery to modify the Media Library tab in the image uploader. 
 *
 * @package   TGM-Soliloquy
 * @version   1.4.0
 * @author    Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @copyright Copyright (c) 2012, Thomas Griffin
 */
jQuery(document).ready(function($) {

	/** Get all attachment items and determine which ones can be attached to the slider */
	var media_items = $('.media-item');

	/** Loop through the media items and modify the attachment output */
	if ( 0 !== media_items.length ) {
		$.each(media_items, function(i, el){
			/** If the media item is not attached, it will have this class, so pass over it */
			if ( $(this).hasClass('child-of-0') )
				return;
			
			/** If the media item is attached to the current slider, allow users to modify it but remove the "Insert into Slider" button */
			if ( $(this).hasClass('child-of-' + post_id) ) {
				$(this).addClass('soliloquy-currently-attached').find('.savesend input[type="submit"]').attr('disabled', 'disabled');
				return;
			}
			
			/** Now we need to make some modifications so users can't attach already attached media items */
			$(this).prepend('<div class="soliloquy-cannot-attach"></div>');
		});
	}

	/** Output a message letting users know why items are overlayed in red */
	if ( 0 !== media_items.length )
		$('#media-items').before('<div class="soliloquy-attachment-explain updated"><p><strong>' + soliloquy_media.notice + ' <a id="soliloquy-attachment-why" href="#">' + soliloquy_media.why + '</a></strong></p><div class="soliloquy-attachment-learn"><p>' + soliloquy_media.white + '</p><p>' + soliloquy_media.green + '</p><p>' + soliloquy_media.red + '</p></div></div>');
	
	/** Show the "Learn Why" message when users click on the link */
	$('#soliloquy-attachment-why').on('click.soliloquyAttachmentLearn', function(e){
		e.preventDefault();
		$(this).parent().parent().next().fadeToggle();
	});

});