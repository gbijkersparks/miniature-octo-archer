/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* Google Maps
*****************************************************
*/



function initializeMap() {

	mapName   = ( typeof mapName == 'undefined' ) ? ( 'Custom' ) : ( mapName );
	mapStyle  = ( typeof mapStyle == 'undefined' ) ? ( '' ) : ( mapStyle );
	mapZoom   = ( typeof mapZoom == 'undefined' ) ? ( 10 ) : ( mapZoom );
	mapCoords = ( typeof mapCoords == 'undefined' ) ? ( [[0,0,'']] ) : ( mapCoords ); //lat, long, info bubble text
	mapInfo   = ( typeof mapInfo == 'undefined' ) ? ( '' ) : ( mapInfo );
	mapCenter = ( typeof mapCenter == 'undefined' ) ? ( true ) : ( mapCenter );
	themeImgs = ( typeof themeImgs == 'undefined' ) ? ( './' ) : ( themeImgs );
	styleMap  = ( typeof styleMap == 'undefined' ) ? ( '' ) : ( styleMap );
	imgInvert = ( typeof imgInvert == 'undefined' ) ? ( '' ) : ( imgInvert );
	pinBounce = ( typeof pinBounce == 'undefined' ) ? ( false ) : ( pinBounce );

	//zoom out a bit on mobile devices
		if ( 768 > document.body.clientWidth )
			mapZoom = mapZoom - 2;

	//Set location
		var myCenter = new google.maps.LatLng( mapCoords[0][0], mapCoords[0][1] );

	//Map properties and map object
		var mapProperties = {
				//location and zoom
				center : myCenter,
				zoom   : mapZoom,
				//cursors
				draggableCursor : 'crosshair',
				draggingCursor  : 'crosshair',
				//controls
				panControl            : false,
				zoomControl           : true,
				mapTypeControl        : true,
				scaleControl          : true,
				streetViewControl     : false,
				overviewMapControl    : false,
				rotateControl         : true,
				scrollwheel           : false,
				zoomControlOptions    : {
						style    : google.maps.ZoomControlStyle.SMALL,
						position : google.maps.ControlPosition.LEFT_CENTER
					},
				mapTypeControlOptions : {
						style      : google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
						position   : google.maps.ControlPosition.RIGHT_BOTTOM,
						mapTypeIds : [google.maps.MapTypeId.ROADMAP, 'map_style']
					}
			};

		if ( 'default' == mapStyle )
			mapProperties['mapTypeControl'] = false;

		var map = new google.maps.Map( document.getElementById( 'map' ), mapProperties );



	//Styling map
		if ( ! styleMap )
			styleMap = [
				{
					stylers: [
						{ saturation : -60 },
						{ weight     : 1.5 }
					]
				}
			];

		if ( 'default' == mapStyle )
			styleMap = [ { stylers: [] } ];
		var styledMap = new google.maps.StyledMapType( styleMap, { name: mapName } );
		map.mapTypes.set( 'map_style', styledMap );
		map.setMapTypeId( 'map_style' );



	//Info bubble preparation (displaying is handled in markers)
		var infoBoxOptions = {
				content                : '',
				disableAutoPan         : false,
				maxWidth               : 0,
				pixelOffset            : new google.maps.Size( -60, 17 ),
				zIndex                 : null,
				infoBoxClearance       : new google.maps.Size( 1, 1 ),
				isHidden               : false,
				pane                   : 'floatPane',
				enableEventPropagation : false
			};
		var infowindow = new InfoBox( infoBoxOptions );



	//Location marker customization
	//Custom marker creator: http://powerhut.co.uk/googlemaps/custom_markers.php
	//High DPI / Retina map marker: http://samcroft.co.uk/2011/google-maps-marker-icons-for-iphone-retina-display/
		var image = new google.maps.MarkerImage(
				themeImgs + 'map/marker' + imgInvert + '.png',
				null,
				null,
				null,
				new google.maps.Size( 24, 29 )
			);
		var shadow = new google.maps.MarkerImage(
				themeImgs + 'map/marker-shadow.png',
				new google.maps.Size( 42, 29 ),
				new google.maps.Point( 0, 0 ),
				new google.maps.Point( 12, 29 )
			);
		var shape = {
				coord : [22,0,23,1,23,2,23,3,23,4,23,5,23,6,23,7,23,8,23,9,23,10,23,13,23,14,23,15,23,16,23,17,23,18,23,19,23,20,23,21,23,22,22,23,17,24,16,25,15,26,14,27,13,28,10,28,9,27,8,26,7,25,6,24,1,23,0,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,10,0,9,0,8,0,7,0,6,0,5,0,4,0,3,0,2,0,1,1,0,22,0],
				type  : 'poly'
			};

		//place the markers
			var marker,
			    i = 0;

			for ( item in mapCoords ) {
				if ( ! ( i == 0 && '-' == mapCoords[i][2] ) ) {
					if ( ! pinBounce ) //dropping marker
						marker = new google.maps.Marker({
							map         : map,
							position    : new google.maps.LatLng( mapCoords[i][0], mapCoords[i][1] ),
							animation   : google.maps.Animation.DROP,

							raiseOnDrag : false,
							icon        : image,
							shadow      : shadow,
							shape       : shape,

							cursor      : ( mapCoords[i][2] ) ? ( 'pointer' ) : ( 'crosshair' ),
							html        : mapCoords[i][2]
						});
					else //bouncing marker
						marker = new google.maps.Marker({
							map         : map,
							position    : new google.maps.LatLng( mapCoords[i][0], mapCoords[i][1] ),
							animation   : google.maps.Animation.BOUNCE,

							raiseOnDrag : false,
							icon        : image,
							shadow      : shadow,
							shape       : shape,

							cursor      : ( mapCoords[i][2] ) ? ( 'pointer' ) : ( 'crosshair' ),
							html        : mapCoords[i][2]
						});

					google.maps.event.addListener( marker, 'click', function() {
							if ( this.html ) {
								infowindow.setContent( this.html );
								infowindow.open( map, this );
							}
						} );
				}
				i++;
			}



	//Center map on location
		if ( mapCenter ) {
			google.maps.event.addListener( map, 'center_changed', function() {
					window.setTimeout( function() {
							map.panTo( myCenter );
						}, 2000 );
				});
		}

} // /initializeMap

google.maps.event.addDomListener( window, 'load', initializeMap );