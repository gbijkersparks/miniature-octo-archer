jQuery( function() {

	//Scrolling
	jQuery( 'a[href*=#]' ).click( function() {
		jQuery.scrollTo( jQuery( this ).attr( 'href' ), 600 );
		return false;
	} );



	//FancyBox
	//Supported file extensions
	var thumbnails = 'a:has(img)[href$=".bmp"],a:has(img)[href$=".gif"],a:has(img)[href$=".jpg"],a:has(img)[href$=".jpeg"],a:has(img)[href$=".png"],a:has(img)[href$=".BMP"],a:has(img)[href$=".GIF"],a:has(img)[href$=".JPG"],a:has(img)[href$=".JPEG"],a:has(img)[href$=".PNG"]';

	//Create hook to fire FancyBox
	jQuery(thumbnails).addClass("fancybox").attr('rel', 'gallery');

	//This copies the title of every IMG tag and adds it to its parent A so that fancybox can use it
	var arr = jQuery("a.fancybox");
	jQuery.each(arr, function() {
		var title = jQuery(this).children("img").attr("title");
		jQuery(this).attr('title', title);
	})

	//Call fancybox and apply it on any link
	jQuery("a.fancybox").fancybox({
		'padding'        : 20,
		'width'          : 560,
		'height'         : 340,
		'autoScale'      : false,
		'centerOnScroll' : false,
		'overlayOpacity' : 0.75,
		'overlayColor'   : '#000',
		'titleShow'      : true,
		'titlePosition'  : 'over',
		'transitionIn'   : 'elastic',
		'transitionOut'  : 'elastic'
	});

} );