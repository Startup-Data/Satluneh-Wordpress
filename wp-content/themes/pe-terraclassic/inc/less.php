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

// LESS VARS and COMPILER
// ----------------------------------------------------

if ( ! class_exists( 'PEless' ) ) {

	class PEless {

		protected static $instance = null;

		public static $compare = false;

		public static $fallback = false;

		public static $parsed_paths = array();
		public static $parsed_urls = array();

		function __construct() {

			// every CSS file URL gets passed through this filter
			add_filter( 'style_loader_src', array( $this, 'parseStylesheets' ), 100000, 2 );
		}

		public static function instance() {
			null === self:: $instance AND self:: $instance = new self;

			return self:: $instance;
		}

		/**
		 * Parse HEAD Urls and compile LESS files
		 *
		 * @param  string $src    URL from wp_enqueue_style() function
		 * @param  string $handle stylesheet ID
		 *
		 * @return string LESS Compiled CSS file URL
		 */
		public function parseStylesheets( $src, $handle ) {

			// we only want to handle .less files
			if ( ! preg_match( '/\.less(\.php)?$/', preg_replace( '/\?.*$/', '', $src ) ) ) {
				return $src;
			}

			// get file path from $src
			if ( ! strstr( $src, '?' ) ) {
				$src .= '?';
			} // prevent non-existent index warning when using list() & explode()

			// Match the URL schemes between WP_CONTENT_URL and $src,
			// so the str_replace further down will work
			$src_scheme            = parse_url( $src, PHP_URL_SCHEME );
			$wp_content_url_scheme = parse_url( WP_CONTENT_URL, PHP_URL_SCHEME );
			if ( $src_scheme != $wp_content_url_scheme ) {
				$src = set_url_scheme( $src, $wp_content_url_scheme );
			}

			list( $less_path ) = explode( '?', str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $src ) );

			//compile less
			$compile = self::compile( $less_path );

			$url = strtok( $src, '?' ); //remove parameters

			self::$parsed_paths[ $handle ] = $less_path;
			self::$parsed_urls[ $handle ]  = $url;

			//return compiled css URI
			return $compile;

		}

		/**
		 * Compare previous and current settings and clear cache if necessary
		 * @return boolean True if settings are the same and false if not
		 */
		public static function compareSettings() {

			$options_name = PEsettings::$default['settings_name'];

			self::$compare = get_option( 'pe_less_' . $options_name, false ); //get 'old' settings

			$current_settings = PEsettings::$less; //current settings

			if ( self::$compare === false ) {
				self::$compare = $current_settings;
				update_option( 'pe_less_' . $options_name, $current_settings );

				return true;
			} else {
				if ( self::$compare == $current_settings ) { //settings are the same
					return true;
				} else { //settings are NOT the same
					PEutils::clearCache(); //clear cache
					update_option( 'pe_less_' . $options_name, $current_settings ); //save current settings

					return false;
				}
			}

		}

		/**
		 * Compile LESS
		 *
		 * @param  string $source Full path to file (not url)
		 *
		 * @return LESS compiled CSS file URL or fallback CSS URL or false
		 */
		public static function compile( $source ) {

			if ( ! empty( $source ) ) {

				$lessfile = basename( $source );

				//get registered less vars
				$variables = PEsettings::$less;

				$file_suffix  = PEUtils::getFileSuffix();
				$cache_prefix = PEUtils::getCachePrefix();

				//paths
				$cachepath = PEsettings::$default['cachepath'];
				$csspath   = PEsettings::$default['csspath'];
				$mapspath  = PEsettings::$default['mapspath'];

				//css url
				$cssurl  = PEsettings::$default['cssurl'];
				$mapsurl = PEsettings::$default['mapsurl'];

				//fallback css
				$fallbackurl = PEsettings::$default['fallback'];
				$fallbackcss = str_replace( '.less', '.css', $lessfile );

				//filenames
				$cssfile = str_replace( '.less', $file_suffix . '.css', $lessfile );
				$mapfile = str_replace( '.less', $file_suffix . '.map', $lessfile );

				try {

					//default options
					$options = array(
						'output'    => $csspath . DIRECTORY_SEPARATOR . $cssfile,
						'cache_dir' => $cachepath,
					);

					//compress css
					if ( PEsettings::get( 'compress-css' ) ) {
						$options['compress'] = true;
					}

					//source maps
					if ( PEsettings::get( 'source-map' ) ) {
						$options['compress']          = false;
						$options['sourceMap']         = true;
						$options['sourceMapWriteTo']  = $mapspath . DIRECTORY_SEPARATOR . $mapfile;
						$options['sourceMapURL']      = $mapsurl . $mapfile;
						$options['sourceMapFilename'] = $cssurl . $cssfile;
						$options['sourceMapBasepath'] = ABSPATH;
						$options['sourceRoot']        = get_site_url();
					}

					//less file to compile
					$file = array( $source => $cssurl );

					$checkDir = ( is_null( PEutils::$wrongdir ) ) ? true : false;

					if ( class_exists( 'Less_Cache' ) && $checkDir ) { // if compilator enabled and directory permissions are ok
						// remove cache if necessary
						self::compareSettings();
						// prefix for less cache files
						Less_Cache::$prefix      = $cache_prefix;
						Less_Cache::$prefix_vars = $cache_prefix;
						$output_css              = $cssurl . Less_Cache::Get( $file, $options, $variables );
					} else { // fallback css
						self::$fallback = true;
						$output_css     = $fallbackurl . $fallbackcss;
					}

					//return css url
					return $output_css;

				}
				catch ( Exception $e ) {
					throw new Exception( esc_html__( 'LESS ERROR: ', 'pe-terraclassic' ) . $e->getMessage() );
				}
			} else {
				return false;
			}
		}

	}

	PEless::instance();
}

?>
