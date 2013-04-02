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
		/*var image = new google.maps.MarkerImage(
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
			};*/

			var image = new google.maps.MarkerImage(
			  themeImgs + 'map/image.png',
			  new google.maps.Size(56,84),
			  new google.maps.Point(0,0),
			  new google.maps.Point(28,84)
			);

			var shadow = new google.maps.MarkerImage(
			  themeImgs + 'map/shadow.png',
			  new google.maps.Size(102,84),
			  new google.maps.Point(0,0),
			  new google.maps.Point(28,84)
			);

			var shape = {
			  coord: [28,0,33,1,33,2,34,3,34,4,35,5,35,6,36,7,36,8,37,9,49,10,53,11,54,12,55,13,55,14,55,15,55,16,55,17,55,18,55,19,55,20,55,21,55,22,55,23,55,24,55,25,55,26,55,27,55,28,55,29,55,30,55,31,55,32,55,33,55,34,55,35,55,36,55,37,55,38,55,39,55,40,55,41,55,42,55,43,55,44,55,45,55,46,55,47,55,48,55,49,55,50,55,51,55,52,55,53,55,54,55,55,55,56,55,57,55,58,55,59,55,60,55,61,55,62,54,63,53,64,49,65,41,66,40,67,40,68,39,69,39,70,38,71,38,72,37,73,37,74,36,75,36,76,35,77,35,78,34,79,34,80,33,81,33,82,28,83,27,83,22,82,22,81,21,80,21,79,20,78,20,77,19,76,19,75,18,74,18,73,17,72,17,71,16,70,16,69,15,68,15,67,14,66,6,65,2,64,1,63,0,62,0,61,0,60,0,59,0,58,0,57,0,56,0,55,0,54,0,53,0,52,0,51,0,50,0,49,0,48,0,47,0,46,0,45,0,44,0,43,0,42,0,41,0,40,0,39,0,38,0,37,0,36,0,35,0,34,0,33,0,32,0,31,0,30,0,29,0,28,0,27,0,26,0,25,0,24,0,23,0,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,1,12,2,11,6,10,18,9,19,8,19,7,20,6,20,5,21,4,21,3,22,2,22,1,27,0,28,0],
			  type: 'poly'
			};

			/*var marker = new google.maps.Marker({
			  draggable: true,
			  raiseOnDrag: false,
			  icon: image,
			  shadow: shadow,
			  shape: shape,
			  map: map,
			  position: point
			});*/

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