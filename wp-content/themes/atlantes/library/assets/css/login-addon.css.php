<?php
//include WP core
require_once '../../../../../../wp-load.php';





/*
*****************************************************
*      CUSTOM STYLES FROM ADMIN PANEL
*****************************************************
*/
	$out = '';

	//$loginError = ( wm_option( 'security-login-error' ) ) ? ( '#login_error {display: none}' ) : ( '' );

	//Array of custom styles from admin panel
		$customStyles = array(

			array(
				'selector' => 'html, body.login',
				'styles' => array(
					'height' => '100%',
					'background' => wm_css_background( 'branding-login-' ),
					)
			),

			array(
				'selector' => 'h1 a, #login h1 a',
				'styles'   => array(
					'background'              => wm_option( 'branding-login-logo', 'bgimg' ),
					'background-repeat'       => 'no-repeat',
					'background-position'     => '50% 50%',
					'-webkit-background-size' => 'auto',
					'-moz-background-size'    => 'auto',
					'background-size'         => 'auto',
					'display'                 => 'block',
					'width'                   => '310px',
					'height'                  => ( wm_option( 'branding-login-logo-height' ) ) ? ( absint( wm_option( 'branding-login-logo-height' ) ) . 'px' ) : ( '100px' ),
					'margin-left'             => '10px',
					'padding'                 => '0',
					'text-indent'             => '-999em',
					'overflow'                => 'hidden',
					)
			),

			array(
				'selector' => '#loginform, #registerform, #lostpasswordform',
				'styles'   => array(
					'padding-bottom'     => '26px',
					'background'         => wm_option( 'branding-login-form-bg-color', 'color' ),
					'border'             => 'none',
					'-webkit-box-shadow' => '0 2px 8px rgba(0,0,0, .5)',
					'-mox-box-shadow'    => '0 2px 8px rgba(0,0,0, .5)',
					'box-shadow'         => '0 2px 8px rgba(0,0,0, .5)',
					)
			),
				array(
					'selector' => 'label',
					'styles'   => array(
						'color' => wm_modify_color( wm_option( 'branding-login-form-bg-color' ), 150, -150, ' !important' ),
						)
				),
				array(
					'selector' => '.login form .forgetmenot',
					'styles'   => array(
						'float' => 'none',
						)
				),
				array(
					'selector' => '#login input',
					'styles'   => array(
						'padding-top'    => '6px',
						'padding-bottom' => '6px',
						)
				),
				array(
					'selector' => '#login input[type=submit]',
					'styles'   => array(
						'display'          => 'block',
						'float'            => 'none',
						'width'            => '100%',
						'height'           => '48px',
						'padding'          => '0px',
						'margin-top'       => '1em',
						'line-height'      => '46px',
						'background-color' => wm_option( 'branding-login-form-button-bg-color', 'color !important' ),
						'background-image' => wm_css3_gradient( wm_option( 'branding-login-form-button-bg-color' ), 32 ),
						'border-color'     => wm_modify_color( wm_option( 'branding-login-form-button-bg-color' ), -17, -17, ' !important' ),
						'color'            => wm_modify_color( wm_option( 'branding-login-form-button-bg-color' ), 150, -150, ' !important' ),
						'text-transform'   => 'uppercase',
						'text-shadow'      => 'none',
						)
				),
					array(
						'selector' => '#login input[type=submit]:hover',
						'styles'   => array(
							'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'branding-login-form-button-bg-color' ), 8, 8 ), 32 ),
							)
					),
					array(
						'selector' => '#login input[type=submit]:active',
						'styles'   => array(
							'background-image' => wm_css3_gradient( wm_modify_color( wm_option( 'branding-login-form-button-bg-color' ), -8, -8 ), 17 ),
							)
					),

			array(
				'selector' => '.login .message, .login #login_error',
				'styles'   => array(
					'background'   => wm_option( 'branding-login-message-bg-color', 'color' ),
					'border-color' => wm_modify_color( wm_option( 'branding-login-message-bg-color' ), 34, -34, ' !important' ),
					'color'        => wm_modify_color( wm_option( 'branding-login-message-bg-color' ), 150, -150, ' !important' ),
					)
			),
				array(
					'selector' => '.login .message a, .login #login_error a',
					'styles'   => array(
						'color' => wm_modify_color( wm_option( 'branding-login-message-bg-color' ), 180, -180, ' !important' ),
						)
				),

			array(
				'selector' => '.login #nav a, .login #backtoblog a, .login #nav a:hover, .login #backtoblog a:hover',
				'styles'   => array(
					'background'  => wm_option( 'branding-login-link-bg-color', 'color' ),
					'color'       => wm_option( 'branding-login-accent-color', 'color !important' ),
					'padding'     => '3px',
					'text-shadow' => 'none',
					)
			)

		);



	//Generate CSS output
		if ( ! empty( $customStyles ) ) {
			$outStyles = '';

			foreach ( $customStyles as $selector ) {
				if ( isset( $selector['styles'] ) && is_array( $selector['styles'] ) && ! empty( $selector['styles'] ) ) {
					$selectorStyles = '';
					foreach ( $selector['styles'] as $property => $style ) {
						if ( isset( $style ) && $style )
							$selectorStyles .=  "\t" . $property . ': ' . $style . ';' . "\r\n";
					}

					if ( $selectorStyles )
						$outStyles .= $selector['selector'] . ' {' . "\r\n" . $selectorStyles . '}' . "\r\n";
				}
			}

			if ( $outStyles )
				$out .= "/* Custom login styles */\r\n" . $outStyles;
		}





/*
*****************************************************
*      CSS HEADER
*****************************************************
*/

	header( 'content-type: text/css; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + WM_CSS_EXPIRATION ) . ' GMT' );
	header( 'cache-control: public, max-age=' . WM_CSS_EXPIRATION );

	if ( ! isset( $_GET['noc'] ) && ( wm_option( 'design-minimize-css' ) ) )
		$out = wm_minimize_css( $out );

	if ( wm_option( 'general-gzip' ) || wm_option( 'design-gzip-cssonly' ) )
		ob_start( 'ob_gzhandler' ); //Enable GZIP

	echo $out;

?>