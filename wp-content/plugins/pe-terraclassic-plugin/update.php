<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( !defined ( 'ABSPATH' ) ) {
	die();
}

// ---------------------------------------------------------------
// UPDATES
// ---------------------------------------------------------------

if ( !class_exists( 'PEUpdates' ) ) {

	class PEupdates {
		static $instance = null;
		public static $check = true; //enable or disable checking
		public static $url = 'http://pixelemu.com/updates.xml';
		public static $message = null; //theme update message
		public static $cache = HOUR_IN_SECONDS; // cache time
		public static $dismissed_time = false; //time when clicked on button
		public static $dismissed_period = DAY_IN_SECONDS; //dismissed period;

		function __construct() {

			//$this->clearCache(); //clear cache :)

			self::$dismissed_time = get_option('pe-update-dismissed', false );

			$notice_dismissed = ( !empty(self::$dismissed_time) && ((self::$dismissed_time + self::$dismissed_period) > time()) ) ? true : false;

			if( true === self::$check && !$notice_dismissed ) {
				//add_action( 'admin_init', array( $this, 'check_updates' ) );
			}
		}

		/**
		 * Get instance
		 * @return object
		 */
		public static function instance() {
			if (self::$instance === null) {
				self::$instance = new PEupdates();
			}
			return self::$instance;
		}

		/**
		 * Get content depends on allowed PHP functions
		 */
		public function getRemoteFile($url) {
			$response = false;
			// checking if fopen is possible to be used
			if ( function_exists('fopen') && is_callable('fopen') && ini_get('allow_url_fopen') )
			{
				$response = $this->getRemoteFileFromStream($url);
			} 
			
			// if failed checking if CURL is enabled
			if ( function_exists('curl_version') && curl_version() ) {
				$response = $this->getRemoteFileFromCURL($url);
			}
			
			return $response;
		}
		
		/**
		 * Get content via file_get_contents
		 */
		private function getRemoteFileFromStream($url) {
			$context=array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
				),
			);  
		
			return file_get_contents($url, false, stream_context_create($context));
		}
		
		/**
		 * Get content via cURL
		 */
		private function getRemoteFileFromCURL($url) {
			$ch = curl_init();
	
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
			$curl_content = curl_exec($ch);
			
			if(curl_errno($ch)) {
				@curl_close ($ch);
				return false;
			}
			
			curl_close($ch);
			
			return $curl_content;
		}

		/**
		 * Change Object to Array
		 * @param  object $xmlObject
		 * @param  array
		 * @return array
		 */
		public function xml2array( $xmlObject, $out = array () ) {
			foreach ( (array) $xmlObject as $index => $node ) {
				$out[$index] = ( is_object ( $node ) ||  is_array ( $node ) ) ? $this->xml2array ( $node ) : $node;
			}
			return $out;
		}

		/**
		 * Get themes list
		 * @return array Array contains all themes
		 */
		public function getUpdateList() {
			$xmlContent = $this->getRemoteFile(self::$url);

			$array = array();

			if( !empty($xmlContent) ) {
				libxml_use_internal_errors(true);
				$xml = simplexml_load_string($xmlContent);
				if (trim($xml)) {
				//if ($xml) {
					$info = $xml->xpath('//updates/information');
					if( !empty($info) ) {
						$array['info'] = (string)$info[0];
					}
					$themes = $xml->xpath('//updates/themes/theme');
					$array['themes'] = $this->xml2array($themes);
				} else {
					/*
					$errors = libxml_get_errors();
					foreach ($errors as $error) {
						echo display_xml_error($error, $xml);
					}
					libxml_clear_errors();*/
					$array = false;
				}
			} else {
				$array = false;
			}

			return $array;
		}

		/**
		 * Check for updates and show notice if necessary
		 */
		public function check_updates() {

			if ( class_exists( 'PEsettings' ) ) {
				if( ! PEsettings::get('check-updates') ) {
					return;
				}
			}

			//check cache
			if ( false === ( $data = get_transient( 'pe_update_cache' ) ) ) {
					// It wasn't there, so regenerate the data and save the transient
					$data = $this->getUpdateList();
					if( is_array($data) ) {
							set_transient( 'pe_update_cache', $data, self::$cache );
					} else {
							self::$message = __("Theme update: Can't check XML file.", 'pe-terraclassic-plugin');
							$this->show_update_notice();
							return;
					}
			}

			$my_theme = wp_get_theme(get_template());
			$current_theme = get_template();
			$current_version = $my_theme->get( 'Version' );
			$theme_name = $my_theme->get('Name');

			if( ! function_exists('get_plugins') ) {
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			}

			$plugin_dir  = explode( '/', plugin_basename( __FILE__ ) );
			$plugin_file = $plugin_dir[0] . '.php';

			$plugin_path = plugin_dir_path( __FILE__ ) . $plugin_file;
			$plugin_data = get_plugin_data( $plugin_path );
			$plugin_version = $plugin_data['Version'];

			$xml = ( !empty($data['themes']) ) ? $data['themes'] : false;
			$info = ( !empty($data['info']) ) ? $data['info'] : false;

			if ( !empty($xml) ) { // Checks that the object is created correctly

				$theme = array();

				foreach( $xml as $item ) {
					if( $item['name'] == $current_theme ) {
						$theme = $item;
					}
				}

				if( !empty($theme) ) {

					$update_version = $theme['version'];

					if ( !empty($update_version) && version_compare($update_version, $current_version, '>') ) { //show update notice if there is new version

						$update_name = $theme['name'];
						$update_title = $theme['title'];
						$update_changelog = ( !empty($theme['changelog']) ) ? esc_url($theme['changelog']) : false;
						$update_link = ( !empty($theme['link']) ) ? esc_url($theme['link']) : false;
						$message = '';

						if( !empty($info) ) {
							$message .= '<p>' . $info . '</p>';
						}

						$message .= '<p>' . sprintf(__('Update %1$s for %2$s theme is available', 'pe-terraclassic-plugin'), '<strong>' . $update_version . '</strong>', '<strong>' . $update_title . '</strong>') . '</p>';
						$message .= '<p>';
						if( $update_changelog ) {
							$message .= '<a class="button-primary" href="' . $update_changelog . '" target="_blank">' . __('Check Changelog', 'pe-terraclassic-plugin') . '</a> ';
						}
						if( $update_link ) {
							$message .= '<a class="button-primary" href="' . $update_link .'" target="_blank">' . __('Get Update', 'pe-terraclassic-plugin') . '</a> ';
						}
						$message .= '</p>';

						//add js
						add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_js' ) );
						//show notice
						self::$message = $message;
						$this->show_update_notice();

					} else { // show notice if plugin older than theme
						if ( !empty($plugin_version) && version_compare($current_version, $plugin_version, '>')) {
							//add js
							add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_js' ) );
							//show notice
							$message = '<p><strong>' . $theme_name . '</strong>: ' . __('Theme and Plugin version may not be compatible. Please update the plugin to the latest version.', 'pe-terraclassic-plugin') . '</p>';
							$message .= '<p>' . __('Theme:', 'pe-terraclassic-plugin') . ' ' . $current_version . '<br>' . __('Plugin:', 'pe-terraclassic-plugin') . ' ' . $plugin_version . '</p>';
							$message .= '<p><a class="button-primary" href="https://www.pixelemu.com/my-account/downloads" target="_blank">' . __('Get Update', 'pe-terraclassic-plugin') . '</a></p>';
							self::$message = $message;
							$this->show_update_notice();
						}
					}

				}

			}

		}

		/**
		 * Clear transient and dismissed option
		 */
		public function clearCache() {
			delete_transient( 'pe_update_cache' );
			update_option( 'pe-update-dismissed', false );
		}

		/**
		 * Show update notice in backend
		 */
		private function show_update_notice() {
			add_action ( 'admin_notices', array( $this, 'update_notice' ) );
		}

		/**
		 * Update notice message
		 */
		public function update_notice() {
			$class = 'notice notice-info pe-update-notice is-dismissible';
			$message = self::$message;
			printf( '<div class="%1$s">%2$s</div>', $class, $message );
		}

		/**
		 * Add dismiss button script
		 */
		public function enqueue_js() {
			if( !wp_script_is('jquery', 'done') ) {
				wp_enqueue_script('jquery');
			}
			$code = "(function($) {
								$(document).ready(function() {
									$(document).on( 'click', '.pe-update-notice .notice-dismiss', function () {
										$.ajax( ajaxurl,
											{
												type: 'POST',
												data: {
													action: 'pe_dismissed_notice_handler'
												}
											} );
									});
								});
							})(jQuery);";
			wp_add_inline_script( 'jquery-core', $code );
		}

	}
	PEupdates::instance();
}

add_action( 'wp_ajax_pe_dismissed_notice_handler', 'pe_ajax_notice_handler' );
if( !function_exists('pe_ajax_notice_handler') ) {
	/**
	 * Update option on button click (ajax)
	 */
	function pe_ajax_notice_handler() {
		update_option( 'pe-update-dismissed', time() );
	}
}
