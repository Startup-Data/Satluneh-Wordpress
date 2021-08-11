<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
 Website: https://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

if ( ! class_exists( 'PElayout' ) ) {
	class PElayout {

		public static $page_layout;

		/**
		 * Set layout for page
		 *
		 * @param integer $index Layout ID (from Redux settings)
		 */
		public static function set( $index ) {
			if ( is_int( $index ) && $index > 0 && $index < 7 ) {
				self::$page_layout = $index;
			} else {
				self::$page_layout = false;
			}
		}

		/**
		 * Output grid classes depends on layout and sidebars
		 *
		 * @param  string $index Grid part (left, content, right)
		 *
		 * @return string or boolean  Classes for part or false
		 */
		public static function get( $index ) {

			if ( ! empty( self::$page_layout ) ) {
				$options_layout = self::$page_layout;
			} else {
				$options_layout = ( is_front_page() ) ? PEsettings::get( 'frontpage-layout' ) : PEsettings::get( 'subpage-layout' );
			}

			$layout['current-layout'] = $options_layout;

			switch ( $options_layout ) {
				case 1: // Left + Content
					$layout['span-left']     = ( is_active_sidebar( 'left-column' ) ) ? absint( PEsettings::get( 'left-column-width' ) ) : 0;
					$layout['span-right']    = 0;
					$layout['span-content']  = 12 - $layout['span-left'] - $layout['span-right'];
					$layout['content-class'] = 'col-md-' . $layout['span-content'] . ' col-md-push-' . $layout['span-left'];
					$layout['left-class']    = 'col-md-' . $layout['span-left'] . ' col-md-pull-' . $layout['span-content'];
					$layout['right-class']   = 'hidden';
					break;
				case 2: // Content + Right
					$layout['span-left']     = 0;
					$layout['span-right']    = ( is_active_sidebar( 'right-column' ) ) ? absint( PEsettings::get( 'right-column-width' ) ) : 0;
					$layout['span-content']  = 12 - $layout['span-left'] - $layout['span-right'];
					$layout['content-class'] = 'col-md-' . $layout['span-content'];
					$layout['left-class']    = 'hidden';
					$layout['right-class']   = 'col-md-' . $layout['span-right'];
					break;
				case 3: // Content
					$layout['span-content']  = 12;
					$layout['content-class'] = 'col-md-' . $layout['span-content'];
					$layout['left-class']    = 'hidden';
					$layout['right-class']   = 'hidden';
					break;
				case 4: // Left + Content + Right
					$layout['span-left']     = ( is_active_sidebar( 'left-column' ) ) ? absint( PEsettings::get( 'left-column-width' ) ) : 0;
					$layout['span-right']    = ( is_active_sidebar( 'right-column' ) ) ? absint( PEsettings::get( 'right-column-width' ) ) : 0;
					$layout['span-content']  = 12 - $layout['span-left'] - $layout['span-right'];
					$layout['content-class'] = 'col-md-' . $layout['span-content'] . ' col-md-push-' . $layout['span-left'];
					$layout['left-class']    = 'col-md-' . $layout['span-left'] . ' col-sm-6 col-md-pull-' . $layout['span-content'];
					$layout['right-class']   = 'col-md-' . $layout['span-right'] . ' col-sm-6';
					break;
				case 5: // Left + Right + Content
					$layout['span-left']     = ( is_active_sidebar( 'left-column' ) ) ? absint( PEsettings::get( 'left-column-width' ) ) : 0;
					$layout['span-right']    = ( is_active_sidebar( 'right-column' ) ) ? absint( PEsettings::get( 'right-column-width' ) ) : 0;
					$layout['span-content']  = 12 - $layout['span-left'] - $layout['span-right'];
					$layout['content-class'] = 'col-md-' . $layout['span-content'] . ' col-md-push-' . ( $layout['span-left'] + $layout['span-right'] );
					$layout['left-class']    = 'col-md-' . $layout['span-left'] . ' col-sm-6 col-md-pull-' . $layout['span-content'];
					$layout['right-class']   = 'col-md-' . $layout['span-right'] . ' col-sm-6 col-md-pull-' . $layout['span-content'];
					break;
				case 6: // Content + Left + Right
					$layout['span-left']     = ( is_active_sidebar( 'left-column' ) ) ? absint( PEsettings::get( 'left-column-width' ) ) : 0;
					$layout['span-right']    = ( is_active_sidebar( 'right-column' ) ) ? absint( PEsettings::get( 'right-column-width' ) ) : 0;
					$layout['span-content']  = 12 - $layout['span-left'] - $layout['span-right'];
					$layout['content-class'] = 'col-md-' . $layout['span-content'];
					$layout['left-class']    = 'col-md-' . $layout['span-left'] . ' col-sm-6';
					$layout['right-class']   = 'col-md-' . $layout['span-right'] . ' col-sm-6';
					break;
			}

			if ( ! empty( $layout[ $index ] ) ) {
				return $layout[ $index ];
			} else {
				return false;
			}

		}

	}
}

?>
