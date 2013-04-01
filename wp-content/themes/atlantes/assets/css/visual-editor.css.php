<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* CSS stylesheet for WordPress visual editor
*****************************************************
*/

	//include WP core
		require_once '../../../../../wp-load.php';





/*
*****************************************************
*      OUTPUT
*****************************************************
*/

	$out = '';

	ob_start(); //This function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.



	$fontFile = ( ! file_exists( '../font/custom/css/fontello-codes.css' ) ) ? ( array( 'icons-font.css', '../font/fontello/css/fontello-codes.css' ) ) : ( array( 'icons-font-custom.css', '../font/custom/css/fontello-codes.css' ) );

	//Start including files and editing output
	@readfile( 'normalize.css' );
	@readfile( 'core.css' );
	@readfile( 'wp-styles.css' );
	@readfile( 'typography.css' );
	@readfile( 'icons-basic.css' );
	@readfile( $fontFile[0] );
	@readfile( $fontFile[1] );
	@readfile( 'columns-content.css' );
	@readfile( 'shortcodes.css' );
	@readfile( 'visual-editor-core.css' );

	//Stop including files and editing output
	$out = ob_get_clean(); //output and clean the buffer





/*
*****************************************************
*      CUSTOM STYLES FROM ADMIN PANEL
*****************************************************
*/

	//fonts
		$basicPrimaryFontElements = '
			body,
			.font-primary,
			.quote-source,
			input, select, textarea,
			.btn, a.btn, button, input[type="button"], input[type="submit"]
			';
		$basicSecondaryFontElements = '
			.font-secondary,
			h1, h2, h3, h4, h5, h6,
			.hero,
			blockquote
			';



	//Array of custom styles from admin panel
		$customStyles = array(

			/* fonts */
				array(
					'selector' => $basicPrimaryFontElements,
					'styles'   => array(
						'font-family' => 'Helvetica, Arial, sans-serif',
						'font-size'   => '13px',
					)
				),
				array(
					'selector' => $basicSecondaryFontElements,
					'styles'   => array(
						'font-family' => 'Georgia, serif',
					)
				),
				array(
					'selector' => 'h1, h2, h3, h4, h5, h6',
					'styles'   => array(
						'font-family' => 'Helvetica, Arial, sans-serif',
						)
				),

		);



	//Generate CSS output
	if ( ! empty( $customStyles ) ) {
		$outStyles = '';

		foreach ( $customStyles as $selector ) {
			if ( isset( $selector['styles'] ) && is_array( $selector['styles'] ) && ! empty( $selector['styles'] ) ) {
				$selectorStyles = '';
				foreach ( $selector['styles'] as $property => $style ) {
					if ( isset( $style ) && $style )
						$selectorStyles .= $property . ': ' . $style . '; ';
				}

				if ( $selectorStyles )
					$outStyles .= $selector['selector'] . ' {' . $selectorStyles . '}' . "\r\n";
			}
		}

		if ( $outStyles )
			$out .= "\r\n\r\n\r\n/* Custom styles */\r\n" . $outStyles;
	}





/*
*****************************************************
*      CSS HEADER
*****************************************************
*/

	header( 'content-type: text/css; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + WM_CSS_EXPIRATION ) . ' GMT' );
	header( 'cache-control: public, max-age=' . WM_CSS_EXPIRATION );

	$out = wm_minimize_css( $out );

	echo $out;

?>