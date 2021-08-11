<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

// WCAG
if ( ! class_exists( 'PEwcag' ) ) {
	class PEwcag {
		//contrast
		public static function getContrast() {
			$expire = time() + 3600 * 24 * 7;
			$path   = COOKIEPATH;

			if ( ! empty( $_GET['contrast'] ) ) { //check contrast
				switch ( $_GET['contrast'] ) {
					case "normal" : {
						if ( isset( $_COOKIE['contrast'] ) ) {
							setcookie( 'contrast', '', time() - 3600, $path ); //remove cookie
						}
						break;
					}
					case "night" : {
						setcookie( 'contrast', 'night', $expire, $path );
						$contrast = 'night';
						break;
					}
					case "highcontrast" : {
						setcookie( 'contrast', 'highcontrast', $expire, $path );
						$contrast = 'highcontrast';
						break;
					}
					case "highcontrast2" : {
						setcookie( 'contrast', 'highcontrast2', $expire, $path );
						$contrast = 'highcontrast2';
						break;
					}
					case "highcontrast3" : {
						setcookie( 'contrast', 'highcontrast3', $expire, $path );
						$contrast = 'highcontrast3';
						break;
					}
					default: {
						$contrast = '';
						break;
					}
				}
			} else {
				if ( ! empty( $_COOKIE['contrast'] ) ) {
					$contrast = $_COOKIE['contrast'];
				} else {
					$contrast = '';
				}
			}

			return $contrast;
		}

		// width
		public static function getWidth() {
			$expire = time() + 3600 * 24 * 7;
			$path   = COOKIEPATH;

			if ( ! empty( $_GET['width'] ) ) { //check width
				switch ( $_GET['width'] ) {
					case "fixed" : {
						if ( isset( $_COOKIE['pagewidth'] ) ) {
							setcookie( 'pagewidth', '', time() - 3600, $path ); //remove cookie
						}
						break;
					}
					case "wide" : {
						setcookie( 'pagewidth', 'wide', $expire, $path );
						$width = 'wide-page';
						break;
					}
					default: {
						$width = '';
						break;
					}
				}
			} else {
				if ( isset( $_COOKIE['pagewidth'] ) == 'wide' ) {
					$width = 'wide-page';
				} else {
					$width = '';
				}
			}

			return $width;
		}

		// font-size
		public static function getFont() {
			$expire = time() + 3600 * 24 * 7;
			$path   = COOKIEPATH;

			if ( ! empty( $_GET['fontsize'] ) ) { //check fsize
				switch ( $_GET['fontsize'] ) {
					case "70" : {
						setcookie( 'pe-font-size', '70', $expire, $path );
						$fsize = 'fsize70';
						break;
					}
					case "100" : {
						if ( isset( $_COOKIE['pe-font-size'] ) ) {
							setcookie( 'pe-font-size', '', time() - 3600, $path ); //remove cookie
						}
						$fsize = 'fsize100';
						break;
					}
					case "130" : {
						setcookie( 'pe-font-size', '130', $expire, $path );
						$fsize = 'fsize130';
						break;
					}
					default: {
						$fsize = '';
						break;
					}
				}
			} else {
				if ( ! empty( $_COOKIE['pe-font-size'] ) ) {
					$fsize = 'fsize' . $_COOKIE['pe-font-size'];
				} else {
					$fsize = '';
				}
			}

			return $fsize;
		}
	}
}
add_action( 'after_setup_theme', array( 'PEwcag', 'getContrast' ) );
add_action( 'after_setup_theme', array( 'PEwcag', 'getWidth' ) );
add_action( 'after_setup_theme', array( 'PEwcag', 'getFont' ) );
?>
