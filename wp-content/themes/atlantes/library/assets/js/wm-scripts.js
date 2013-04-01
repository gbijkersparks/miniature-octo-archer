/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Admin scripts
*
* CONTENT:
* - 1) Widgets
* - 2) Contextual help toggles
* - 3) Page list images
* - 4) Content Modules thumbnail
*****************************************************
*/

jQuery(function() {



//open "View" button in new window
jQuery( '#view-post-btn a, .view a' ).attr( 'target', '_blank' );

//top of page link
jQuery( '.top a' ).click( function() {
		jQuery( 'html, body' ).animate({ scrollTop: 0 }, 400 );
		return false;
	} );




/*
*****************************************************
*      1) WIDGETS
*****************************************************
*/
	jQuery( '#widgets-right div.widgets-holder-wrap' ).addClass( 'closed' );
	jQuery( 'div[id*="wmcs-"]' ).prev( 'div.sidebar-name' ).addClass( 'custom-sidebar-name' );

	var $descriptions = jQuery( "#widgets-right .sidebar-description .description" );

	$descriptions.each( function( item ) {
		var $this     = jQuery( this ),
		    $thisText = $this.text();

		$thisText = $thisText.replace( "[", "<strong>Shortcode:</strong><br /><input type='text' onfocus='this.select();' readonly='readonly' value='[" );
		$thisText = $thisText.replace( "]", "]' class='widefat' /></p><p>" );

		$this.html( $thisText );
	} );



/*
*****************************************************
*      2) CONTEXTUAL HELP TOGGLES
*****************************************************
*/
	jQuery( 'div.contextual-help-tab-content.toggle-content, div.shortcode-help-content' ).hide();
	jQuery( 'div.shortcode-help-content' ).prev( 'h3' ).addClass( 'small-toggle-title' );

	jQuery( 'h2.contextual-help-tab-title.toggle-title, .small-toggle-title' ).click( function() {
		jQuery( this ).toggleClass( 'active' ).next( 'div.contextual-help-tab-content.toggle-content, div.shortcode-help-content' ).slideToggle().toggleClass( 'active' );
	} );

	jQuery( '.stick-button' ).click( function() {
		jQuery( this ).closest( '.sticky-content' ).toggleClass( 'active' );
	} );
	jQuery( '.sticky-content' ).hover( function() {
		var $this = jQuery( this );

		if ( $this.hasClass( 'active' ) )
			$this.stop().animate({ right: 0 }, 250 );
	}, function() {
		var $this = jQuery( this );

		if ( $this.hasClass( 'active' ) )
			$this.stop().animate({ right: -270 }, 250 );
	} );



/*
*****************************************************
*      3) PAGE LIST IMAGES
*****************************************************
*/
	jQuery( '.wm-image-container.has-thumb' ).hover( function() {
			jQuery( this ).find( '.overlay' ).stop( true, true ).fadeOut( 250 );
		}, function() {
			jQuery( this ).find( '.overlay' ).stop( true, true ).fadeIn( 250 );
		} );



/*
*****************************************************
*      4) CONTENT MODULES THUMBNAIL
*****************************************************
*/
	jQuery( '.post-type-wm_modules #wm-module-type, .post-type-wm_modules #wm-module-icon-box-color' ).change( function() {
			if ( jQuery( '.post-type-wm_modules #wm-module-type' ).is(':checked') ) {
				jQuery( '.post-type-wm_modules #postimagediv #set-post-thumbnail' ).css( {
						display    : 'block',
						padding    : '10px',
						textAlign  : 'center',
						background : '#' + jQuery( '.post-type-wm_modules #wm-module-icon-box-color' ).val()
					} );
			}
		} );

});