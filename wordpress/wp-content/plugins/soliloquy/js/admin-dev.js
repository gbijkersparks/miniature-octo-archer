/**
 * jQuery to power image uploads, modifications and removals.
 *
 * The object passed to this script file via wp_localize_script is
 * soliloquy. 
 *
 * @package   TGM-Soliloquy
 * @version   1.0.0
 * @author    Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @copyright Copyright (c) 2012, Thomas Griffin
 */
jQuery(document).ready(function($) {

	/** Prepare formfield variable */
	var formfield;
	
	/** Set the default slider type */
	if ( ! $('input[name="_soliloquy_settings[type]"]').is(':checked') )
		$('#soliloquy-default-slider').attr('checked', 'checked');
	
	/** Show/hide the default area on page load */
	if ( 'default' == $('input[name="_soliloquy_settings[type]"]:checked').val() ) {
		$('.soliloquy-upload-text, #soliloquy-upload, #soliloquy-images').show();
		$('#soliloquy-upload').css('display', 'inline-block');
	} else {
		$('.soliloquy-upload-text, #soliloquy-upload, #soliloquy-images').hide();
	}
		
	/** Show/hide the default area on user selection */
	$('input[name="_soliloquy_settings[type]"]').on('change', function() {
		if ( 'default' == $(this).val() ) {
			$('.soliloquy-upload-text, #soliloquy-upload, #soliloquy-images').fadeIn();
			$('#soliloquy-upload').css('display', 'inline-block');
		} else {
			$('.soliloquy-upload-text, #soliloquy-upload, #soliloquy-images').hide();
		}
	});

	/** Hide elements on page load */
	$('.soliloquy-image-meta').hide();
	
	/** Hide advanced options on page load */
	if ( $('#soliloquy-advanced').is(':checked') ) {
		$('#soliloquy-navigation-box, #soliloquy-control-box, #soliloquy-keyboard-box, #soliloquy-multi-keyboard-box, #soliloquy-mousewheel-box, #soliloquy-pauseplay-box, #soliloquy-random-box, #soliloquy-number-box, #soliloquy-control-box, #soliloquy-loop-box, #soliloquy-action-box, #soliloquy-hover-box, #soliloquy-slider-css-box, #soliloquy-reverse-box, #soliloquy-smooth-box, #soliloquy-touch-box, #soliloquy-delay-box, .soliloquy-advanced').show();
	} else {
		$('#soliloquy-navigation-box, #soliloquy-control-box, #soliloquy-keyboard-box, #soliloquy-multi-keyboard-box, #soliloquy-mousewheel-box, #soliloquy-pauseplay-box, #soliloquy-random-box, #soliloquy-number-box, #soliloquy-control-box, #soliloquy-loop-box, #soliloquy-action-box, #soliloquy-hover-box, #soliloquy-slider-css-box, #soliloquy-reverse-box, #soliloquy-smooth-box, #soliloquy-touch-box, #soliloquy-delay-box, .soliloquy-advanced').hide();
	}
	
	/** Set default post meta fields */
	if ( 0 == $('#soliloquy-width').val().length ) {
		$('#soliloquy-width').val(soliloquy.width);
	}
		
	if ( 0 == $('#soliloquy-height').val().length ) {
		$('#soliloquy-height').val(soliloquy.height);
	}
	
	if ( 'custom' !== $('#soliloquy-default-size option[selected]').val() )
		$('#soliloquy-custom-sizes').hide();
	else
		$('#soliloquy-default-sizes').hide();
		
	if ( 0 == $('#soliloquy-speed').val().length ) {
		$('#soliloquy-speed').val(soliloquy.speed);
	}
		
	if ( 0 == $('#soliloquy-duration').val().length ) {
		$('#soliloquy-duration').val(soliloquy.duration);
	}
	
	/** Process toggle switches for field changes */
	$('#soliloquy-default-size').on('change', function() {
		if ( 'default' !== $(this).val() ) {
			$('#soliloquy-default-sizes').hide();
			$('#soliloquy-custom-sizes').fadeIn('normal');
		} 
		else {
			$('#soliloquy-custom-sizes').hide();
			$('#soliloquy-default-sizes').fadeIn('normal');
		}
	});
	
	$('#soliloquy-advanced').on('change', function() {
		if ( $(this).is(':checked') ) {
			$('#soliloquy-navigation-box, #soliloquy-control-box, #soliloquy-keyboard-box, #soliloquy-multi-keyboard-box, #soliloquy-mousewheel-box, #soliloquy-pauseplay-box, #soliloquy-random-box, #soliloquy-number-box, #soliloquy-control-box, #soliloquy-loop-box, #soliloquy-action-box, #soliloquy-hover-box, #soliloquy-slider-css-box, #soliloquy-reverse-box, #soliloquy-smooth-box, #soliloquy-touch-box, #soliloquy-delay-box, .soliloquy-advanced').fadeIn('normal');
		} else {
			$('#soliloquy-navigation-box, #soliloquy-control-box, #soliloquy-keyboard-box, #soliloquy-multi-keyboard-box, #soliloquy-mousewheel-box, #soliloquy-pauseplay-box, #soliloquy-random-box, #soliloquy-number-box, #soliloquy-control-box, #soliloquy-loop-box, #soliloquy-action-box, #soliloquy-hover-box, #soliloquy-slider-css-box, #soliloquy-reverse-box, #soliloquy-smooth-box, #soliloquy-touch-box, #soliloquy-delay-box, .soliloquy-advanced').fadeOut('normal');
		}
	});
	
	/** Show/hide image link type with appropriate fields */
	$(document).find('.soliloquy-link-type').each(function() {
		if ( 'normal' == $(this).val() ) {
			$(this).next().show();
			$(this).next().next().hide();
		} else if ( 'video' == $(this).val() ) {
			$(this).next().hide();
			$(this).next().next().show();
		} else {
			$(this).next().hide();
			$(this).next().next().hide();
		}
	});
	
	$('#soliloquy-images').on('ajaxStop', function() {
		$(this).find('.soliloquy-link-type').each(function() {
			if ( 'normal' == $(this).val() ) {
				$(this).next().show();
				$(this).next().next().hide();
			} else if ( 'video' == $(this).val() ) {
				$(this).next().hide();
				$(this).next().next().show();
			} else {
				$(this).next().hide();
				$(this).next().next().hide();
			}
		});
	});
	
	$(document).on('change.selectSoliloquyLinkType', '.soliloquy-link-type', function() {
		if ( 'normal' == $(this).val() ) {
			$(this).next().fadeIn();
			$(this).next().next().hide();
		} else if ( 'video' == $(this).val() ) {
			$(this).next().hide();
			$(this).next().next().fadeIn();
		} else {
			$(this).next().hide();
			$(this).next().next().hide();
		}
	})
	
	/** Process fadeToggle for slider size explanation */
	$('.soliloquy-size-more').on('click.soliloquySizeExplain', function(e) {
		e.preventDefault();
		$('#soliloquy-explain-size').fadeToggle();
	});

	/** Process image removals */
	$('#soliloquy-area').on('click.soliloquyRemove', '.remove-image', function(e) {
		e.preventDefault();
		
		/** Bail out if the user does not actually want to remove the image */
		var confirm_delete = confirm(soliloquy.delete_nag);
		if ( ! confirm_delete )
			return;
			
		formfield = $(this).parent().attr('id');
		
		/** Output loading icon and message */
		$('#soliloquy-upload').after('<span class="soliloquy-waiting"><img class="soliloquy-spinner" src="' + soliloquy.spinner + '" width="16px" height="16px" style="margin: 0 5px; vertical-align: bottom;" />' + soliloquy.removing + '</span>');
		
		/** Prepare our data to be sent via Ajax */
		var remove = {
			action: 		'soliloquy_remove_images',
			attachment_id: 	formfield,
			nonce: 			soliloquy.removenonce
		};
		
		/** Process the Ajax response and output all the necessary data */
		$.post(
			soliloquy.ajaxurl, 
			remove, 
			function(response) {	
				$('#' + formfield).fadeOut('normal', function() {
					$(this).remove();
					
					/** Remove the spinner and loading message */
					$('.soliloquy-waiting').fadeOut('normal', function() {
						$(this).remove();
					});
				});
			},
			'json'
		);
	});
	
	/** Use thickbox to handle image meta fields */
	$('#soliloquy-area').on('click.soliloquyModify', '.modify-image', function(e) {
		e.preventDefault();
		$('html').addClass('soliloquy-editing');
		formfield = $(this).next().attr('id');
		tb_show( soliloquy.modifytb, 'TB_inline?width=640&height=500&inlineId=' + formfield );

		/** Close thickbox if they click the actual close button */
		$(document).contents().find('#TB_closeWindowButton').on('click.soliloquyIframe', function() {
			if( $('html').hasClass('soliloquy-editing') ) {
				$('html').removeClass('soliloquy-editing');
				tb_remove();
			}
		});
			
		/** Close thickbox if they click the overlay */
		$(document).contents().find('#TB_overlay').on('click.soliloquyIframe', function() {
			if( $('html').hasClass('soliloquy-editing') ) {
				$('html').removeClass('soliloquy-editing');
				tb_remove();
			}
		});
		
		return false;
	});
	
	/** Save image meta via Ajax */
	$(document).on('click.soliloquyMeta', '.soliloquy-meta-submit', function(e) {
		e.preventDefault();
		
		/** Set default meta values that any addon would need */
		var table 		= $(this).parent().find('.soliloquy-meta-table').attr('id');
		var attach 		= table.split('-');
		var attach_id 	= attach[3];
		
		/** Prepare our data to be sent via Ajax */
		var meta = {
			action: 	'soliloquy_update_meta',
			attach: 	attach_id,
			id: 		soliloquy.id,
			nonce: 		soliloquy.metanonce
		};
		
		/** Loop through each table item and send data for every item that has a usable class */
		$('#' + table + ' td').each(function() {
			/** Grab all the items within each td element */
			var children = $(this).find('*');
			
			/** Loop through each child element */
			$.each(children, function() {
				var field_class = $(this).attr('class');
				var field_val 	= $(this).val();
				
				if ( 'checkbox' == $(this).attr('type') )
					var field_val = $(this).is(':checked') ? 'true' : 'false';
					
				if ( 'radio' == $(this).attr('type') ) {
					if ( ! $(this).is(':checked') ) {
						return;
					}
					var field_val = $(this).val();
				}
				
				/** Store all data in the meta object */
				meta[field_class] = field_val;
			});
		});

		/** Output loading icon and message */
		$(this).after('<span class="soliloquy-waiting"><img class="soliloquy-spinner" src="' + soliloquy.spinner + '" width="16px" height="16px" style="margin: 0 5px; vertical-align: middle;" />' + soliloquy.saving + '</span>');
		
		/** Process the Ajax response and output all the necessary data */
		$.post(
			soliloquy.ajaxurl, 
			meta, 
			function(response) {	
				/** Remove the spinner and loading message */
				$('.soliloquy-waiting').fadeOut('normal', function() {
					$(this).remove();
				});
				
				/** Remove thickbox with a slight delay */
				var metaTimeout = setTimeout(function() {
					$('html').removeClass('soliloquy-editing');
					tb_remove();
				}, 1000);
			},
			'json'
		);
	});
	
	/** Use thickbox to handle image uploads */
	$('#soliloquy-area').on('click.soliloquyUpload', '#soliloquy-upload', function(e) {
		e.preventDefault();
		$('html').addClass('soliloquy-uploading');
		formfield = $(this).parent().prev().attr('name');
 		tb_show( soliloquy.upload, 'media-upload.php?post_id=' + soliloquy.id + '&type=image&context=soliloquy-image-uploads&TB_iframe=true&width=640&height=500' );
 		
 		/** Refresh image list and meta if a user selects to save changes instead of insert into the slider gallery */
		$(document).contents().find('#TB_closeWindowButton').on('click.soliloquyIframe', function() {
			/** Refresh if they click the actual close button */
			if( $('html').hasClass('soliloquy-uploading') ) {
				$('html').removeClass('soliloquy-uploading');
				tb_remove();
				soliloquyRefresh();
			}
		});
			
		/** Refresh if they click the overlay */
		$(document).contents().find('#TB_overlay').on('click.soliloquyIframe', function() {
			if( $('html').hasClass('soliloquy-uploading') ) {
				$('html').removeClass('soliloquy-uploading');
				tb_remove();
				soliloquyRefresh();
			}
		});
		
 		return false;
	});
	
	window.original_send_to_editor = window.send_to_editor;
	
	/** Send out an ajax call to refresh the image attachment list */
	window.send_to_editor = function(html) {
		if (formfield) {
			/** Remove thickbox and extra html class */
			tb_remove();
			$('html').removeClass('soliloquy-uploading');
			
			/** Delay the processing of the refresh until thickbox has closed */
			var timeout = setTimeout(function() {
				soliloquyRefresh();
			}, 1500); // End timeout function
		}
		else {
 			window.original_send_to_editor(html);
 		}
	};
	
	/** Reset variables */
	var formfield 	= '';
	var remove 		= '';
	var table 		= '';
	var attach 		= '';
	var attach_id 	= '';
	var meta 		= '';
	var metaTimeout = '';
	var timeout 	= '';
	var refresh 	= '';
	
	/** Make image uploads sortable */
	var items = $('#soliloquy-images');
	
	/** Use Ajax to update the item order */
	items.sortable({
		containment: '#soliloquy-area',
		update: function(event, ui) {
			/** Show the loading text and icon */
			$('.soliloquy-waiting').show();
			
			/** Prepare our data to be sent via Ajax */
			var opts = {
				url: 		soliloquy.ajaxurl,
                type: 		'post',
                async: 		true,
                cache: 		false,
                dataType: 	'json',
                data:{
                    action: 	'soliloquy_sort_images',
					order: 		items.sortable('toArray').toString(),
					post_id: 	soliloquy.id,
					nonce: 		soliloquy.sortnonce
                },
                success: function(response) {
                    $('.soliloquy-waiting').hide();
                    return; 
                },
                error: function(xhr, textStatus ,e) { 
                    $('.soliloquy-waiting').hide();
                    return; 
                }
            };
            $.ajax(opts);
		}
	});
	
	/** jQuery function for loading the image uploads */	
	function soliloquyRefresh() {
		/** Prepare our data to be sent via Ajax */
		var refresh = {
			action: 'soliloquy_refresh_images',
			id: 	soliloquy.id,
			nonce: 	soliloquy.nonce
		};

		/** Output loading icon and message */
		$('#soliloquy-upload').after('<span class="soliloquy-waiting"><img class="soliloquy-spinner" src="' + soliloquy.spinner + '" width="16px" height="16px" style="margin: 0 5px; vertical-align: bottom;" />' + soliloquy.loading + '</span>');

		/** Process the Ajax response and output all the necessary data */
		$.post(
			soliloquy.ajaxurl, 
			refresh, 
			function(json) {
				/** Load the new HTML with the newly uploaded images */
				$('#soliloquy-images').html(json.images);

				/** Hide the image meta when refreshing the list */
				$('.soliloquy-image-meta').hide();
			},
			'json'
		);

		/** Remove the spinner and loading message */
		$('.soliloquy-waiting').fadeOut('normal', function() {
			$(this).remove();
		});
	}
	
	/** Process internal linking component */
	var delay = (function() {
  		var timer = 0;
  		return function(callback, ms) {
    		clearTimeout (timer);
    		timer = setTimeout(callback, ms);
  		};
	})();
	
	$(document).on('click.soliloquyInternalLinking', '#soliloquy-link-existing', function(e) {
		e.preventDefault();
		$(this).next().fadeToggle();
	});
	
	$(document).on('keyup.soliloquySearchLinks keydown.soliloquySearchLinks', '.soliloquy-search', function() {
		var id 			= $(this).attr('id');
		var text 		= $(this).val();
		var link_output = $(this).next().find('ul').attr('id');
		var search 		= {
			action: 'soliloquy_link_search',
			id: 	soliloquy.id,
			nonce: 	soliloquy.linknonce,
			search: text
		}
		
		/** Send the ajax request with a delay (500ms after the user stops typing */
		delay(function() {
			soliloquySearch(id, link_output, search);
		}, '500');
	});
	
	/** Insert internal link when clicked */
	$(document).on('click.soliloquyInsertLink', '.soliloquy-results-list li', function() {
		/** Remove the old selected class if it exists and add it to the selected item */
		$('.soliloquy-results-list li').removeClass('selected');
		$(this).addClass('selected');
		
		var search_link 	= $(this).find('input').val();
		var search_title 	= $(this).find('.soliloquy-item-title').text();
		var image_link 		= $(this).parent().parent().parent().parent().parent().find('.soliloquy-link').attr('id');
		var image_title 	= $(this).parent().parent().parent().parent().parent().find('.soliloquy-link-title').attr('id');
		
		$('#' + image_link).val(search_link);
		$('#' + image_title).val(search_title);
	});
	
	/** Callback function when searching for internal link matches */
	function soliloquySearch(id, link_output, search) {
		/** Output loading icon and message */
		$('#' + id).after('<span class="soliloquy-waiting"><img class="soliloquy-spinner" src="' + soliloquy.spinner + '" width="16px" height="16px" style="margin: 0 5px; vertical-align: middle;" />' + soliloquy.searching + '</span>');
		
		/** Send the Ajax request and output the returned data */
		$.post(
			soliloquy.ajaxurl,
			search,
			function(json) {
				/** Remove old links to refresh with new ones */
				$('#' + link_output).children().remove();
				
				/** If no results were found, display a message */
				if ( ! json.links ) {
					var output = 
						'<li class="soliloquy-no-results">' +
							'<span>' + soliloquy.noresults + '</span>' +
						'</li>';
						
					/** Display the newly generated link results */
					$('#' + link_output).append(output);
				}
					
				$.each(json.links, function(i, object) {
					/** Store each link and its data into the link variable */
					var link 	= json.links[i];
					var row 	= (i%2 == 0) ? 'even' : 'odd';

					/** Store the output into a variable */
					var output = 
						'<li id="link-id-' + link.ID + '" class="soliloquy-result ' + row + '">' +
							'<input type="hidden" class="soliloquy-item-permalink" value="' + link.permalink + '" />' +
							'<span class="soliloquy-item-title">' + link.title + '</span>' +
							'<span class="soliloquy-item-info">' + link.info + '</span>' +
						'</li>';
						
					/** Display the newly generated link results */
					$('#' + link_output).append(output);
				});	
				
				var output = '';
			},
			'json'
		);
			
		/** Remove the spinner and loading message */
		$('.soliloquy-waiting').fadeOut('normal', function() {
			$(this).remove();
		});
	}

});