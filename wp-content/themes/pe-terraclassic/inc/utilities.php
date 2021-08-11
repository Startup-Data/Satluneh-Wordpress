<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// ---------------------------------------------------------------
// UTILITIES
// ---------------------------------------------------------------

if ( ! class_exists( 'PEutils' ) ) {

	class PEutils {
		static $instance = null;
		public static $wrongdir = null;

		function __construct() {
			add_action( 'after_setup_theme', array( $this, 'backendNotice' ), 5 );
		}

		/**
		 * Get instance
		 * @return object
		 */
		public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new PEutils();
			}

			return self::$instance;
		}

		/**
		 * Returns file suffix
		 * @return string
		 */
		public static function getFileSuffix() {
			if ( ! empty( PEsettings::$default['files_name'] ) ) {
				$file_suffix = '_' . sanitize_file_name( PEsettings::$default['files_name'] );
			} elseif ( is_child_theme() ) {
				$file_suffix = '_' . sanitize_file_name( PEsettings::$default['settings_name'] );
			} else {
				$file_suffix = '';
			}

			return $file_suffix;
		}

		/**
		 * Returns cache prefix
		 * @return string
		 */
		public static function getCachePrefix() {
			$cache_prefix = ( ! empty( PEsettings::$default['files_name'] ) ) ? sanitize_file_name( PEsettings::$default['files_name'] ) : sanitize_file_name( PEsettings::$default['settings_name'] );
			$cache_prefix .= '_';

			return $cache_prefix;
		}

		/**
		 * Method for checking dir permissions
		 *
		 * @param  array $dir Path
		 *
		 * @return boolean
		 */
		public static function checkPermissions( $dir ) {
			if ( ! empty( $dir ) ) {
				if ( ! is_array( $dir ) ) {
					$dir = explode( ',', $dir );
				}
				$output_dir = array();
				foreach ( $dir as $location ) {
					//try to create dir if not available
					if ( ! is_dir( $location ) ) {
						wp_mkdir_p( $location );
					}
					//check dir permissions
					if ( ! is_writable( $location ) ) {
						$writable                = ( is_dir( $location ) ) ? 0 : 1; // 0 not writable ; 1 not exist
						$output_dir[ $location ] = $writable;
					}
				}

				if ( ! empty( $output_dir ) ) {
					//save wrong dir
					self::$wrongdir = $output_dir;

					return false;
				} else {
					return true;
				}

			} else {
				return false;
			}
		}

		/**
		 * Show backend notice
		 */
		public function backendNotice() {
			$check = array(
				PEsettings::$default['cachepath'],
				PEsettings::$default['csspath'],
				PEsettings::$default['mapspath']
			);
			if ( self::checkPermissions( $check ) === false ) {
				$this->show_permission_notice();
			}
		}

		/**
		 * Method for clear cache files
		 *
		 * @param string [$index = true] Select what to clean
		 * @param string [$type = false] Select files to clean (suffix / prefix)
		 */
		public static function clearCache( $index = true ) {

			$lesscache = PEsettings::$default['cachepath'];
			$maps      = PEsettings::$default['mapspath'];
			$css       = PEsettings::$default['csspath'];

			if ( $index === true || $index === 'cache' ) {
				$setting = PEUtils::getCachePrefix();
				$prefix  = ( ! empty( $setting ) ) ? $setting : '';
				foreach ( glob( $lesscache . DIRECTORY_SEPARATOR . $prefix . '*.*' ) as $f ) {
					wp_delete_file( $f );
				}
			}

			if ( $index === true || $index === 'maps' ) {
				$setting = PEUtils::getFileSuffix();
				$suffix  = ( ! empty( $setting ) ) ? $setting : '';
				foreach ( glob( $maps . DIRECTORY_SEPARATOR . '*' . $suffix . '.map' ) as $f ) {
					wp_delete_file( $f );
				}
			}

			if ( $index === 'css' ) {
				$setting = PEUtils::getFileSuffix();
				$suffix  = ( ! empty( $setting ) ) ? $setting : '';
				foreach ( glob( $css . DIRECTORY_SEPARATOR . '*' . $suffix . '.css' ) as $f ) {
					wp_delete_file( $f );
				}
			}

		}

		/**
		 * Show permission notice in backend
		 */
		private function show_permission_notice() {
			add_action( 'admin_notices', array( $this, 'permission_notice' ) );
		}

		/**
		 * Permission notice message
		 */
		public function permission_notice() {
			$class   = 'notice notice-error is-dismissible';
			$message = '<p>' . esc_html__( 'Following directories have permission issues :', 'pe-terraclassic' ) . '</p>';
			if ( is_array( self::$wrongdir ) ) {
				foreach ( self::$wrongdir as $dir_name => $writable ) {
					$error_message = ( $writable == 0 ) ? esc_html__( '(not writable)', 'pe-terraclassic' ) : esc_html__( '(not exist)', 'pe-terraclassic' );
					$message       .= '<p><strong>' . $dir_name . '</strong> - ' . $error_message . '</p>';
				}
			}
			$message .= '<p>' . esc_html__( 'Please make sure directories exist and PHP parser have permissions to write files in.', 'pe-terraclassic' ) . '</p>';
			printf( '<div class="%1$s">%2$s</div>', $class, $message );
		}

		/**
		 * Method for debug
		 *
		 * @param $var Variable for print
		 */
		public static function d( $var ) {
			echo '<pre><h2>' . strval( $var ) . '</h2>';
			print_r( $var );
			echo '</pre>';
		}

	}

	PEutils::instance();
}

?>
