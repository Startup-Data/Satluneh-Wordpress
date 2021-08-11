<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('ReduxFramework_Extension_demo_content_import')) {

	class ReduxFramework_Extension_demo_content_import {

		// Protected vars
		protected $parent;
		public $extension_url;
		public $extension_dir;
		public static $theInstance;

		public $add_post   = 0;
		public $tt_post    = 0;
		public $xml        = '';

		public function __construct($parent) {

			$this->parent = $parent;
			if (empty($this->extension_dir)) {
				$this->extension_dir = trailingslashit(str_replace('\\', '/', dirname(__FILE__)));
			}
			$this->field_name = 'demo_content_import';

			self::$theInstance = $this;

			add_filter('redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array(&$this, 'overload_field_path')); // Adds the local field

			add_action( 'wp_ajax_demo_installer',        array($this, 'import_demo') );
			add_action( 'wp_ajax_nopriv_demo_installer', array($this, 'import_demo') );

			add_action( 'wp_ajax_poll_counter',          array($this, 'get_count') );
			add_action( 'wp_ajax_nopriv_poll_counter',   array($this, 'get_count') );

			add_action( 'wp_ajax_get_import_log',        array($this, 'get_log') );
			add_action( 'wp_ajax_nopriv_get_import_log', array($this, 'get_log') );

			add_action( 'wp_ajax_log_js_error',          array($this, 'log_js_error') );
			add_action( 'wp_ajax_nopriv_log_js_error',   array($this, 'log_js_error') );

			include_once 'demo_content_import/demo_inc/redux.class.php';

			PE_ReduxImport::init();

		}

		public function log_js_error() {
			if (  wp_verify_nonce ( $_POST['nonce'], 'redux_demo_content' )) {
				$status = $_POST[ 'status' ];
				$error  = $_POST[ 'errorThrown' ];
				$retry  = $_POST[ 'retry' ];

				PE_ReduxImport::init_log();
				PE_ReduxImport::$_log->logError ('Server AJAX error ' . $status . ' ( ' . $error . ' ) thrown.  Retry: ' . $retry );

				echo 'success';

				die();
			}

			die();
		}

		public function get_log() {
			if (  wp_verify_nonce ( $_POST['nonce'], 'redux_demo_content_import_log' )) {
				$files = glob( ReduxFramework::$_upload_dir . 'demo_content_import/*.txt');

				$data = '';

				foreach($files as $file){
					if(is_file($file) && file_exists($file)) {
						$data = file_get_contents($file);
							continue;
					} else {
						$data = 'There are no entries in the log file to display.';
					}
				}

				echo $data;

			} else {
				echo 'Invalid nonce.  Please reload the page and try again.';
			}
			die();
		}

		public function get_count() {
			$post_count = get_option('redux_demo_content_import_post_count');
			$tt_count   = get_option('redux_demo_content_import_tt_count');
			$loop       = get_option('redux_demo_content_import_loop');

			$message    = false;
			$error      = false;

			$response = array(
				"tt_post"   => $tt_count,
				"add_post"  => $post_count,
				"message"   => $message,
				"error"     => $error,
				'steps'     => true,
				'loop'      => $loop,
			);

			wp_send_json_success ( $response );

			die();
		}

		public function import_demo() {
			if (  wp_verify_nonce ( $_POST['nonce'], 'redux_demo_content' )) {

				delete_option('redux_demo_content_import_post_count');
				delete_option('redux_demo_content_import_tt_count');
				delete_option('redux_demo_content_import_loop');

				$response           = null;
				$error              = null;
				$message            = false;
				$this->tt_post      = 0;
				$this->add_post     = 0;

				$demo               = $_POST['demo'];
				$data_xml           = $_POST['xml'];
				$data_loop          = $_POST['loop'];
				$importer           = $_POST['importer'];
				$type               = $_POST['type'];
				$do_import          = $_POST['process'];
				$log_delete         = $_POST['log'];

				$data_dir           = rawurldecode( $_POST['data_dir'] );
				$data_dir           = trailingslashit( $data_dir );

				$min_data           = json_decode( rawurldecode($_POST['min_data']), true );

				$source_upload_url  = rawurldecode( $_POST['upload_url'] );
				$source_site        = rawurldecode( $_POST['site_url'] );

				$data_file          = $data_xml;
				$data_xml           = $data_dir . $data_xml;

				$args               = array( 'file' => $data_xml, 'map_user_id' => 1 );

				PE_ReduxImport::$_source_site_url   = $source_site;
				PE_ReduxImport::$_source_upload_url = $source_upload_url;

				update_option('redux_demo_content_import_loop', $data_loop);

				$this->xml = basename($data_xml);

				if( $log_delete == 'delete' ) {
					PE_ReduxImport::delete_everything();
				}

				PE_ReduxImport::init_log();

				if( $log_delete == 'delete' ) {
					if (!empty($min_data)) {
						foreach($min_data as $criteria => $val) {
							PE_ReduxImport::$_log->logInfo ($criteria . ': ' . $val);
						}
					}
				}

				PE_ReduxImport::$_log->logInfo ('Begin ' . $importer . ' of ' . $type);

				if( $do_import == 'yes' ) {

					//theme options
					if ( $importer == 'theme_options' ) {
						$this->import_theme_options ( $data_xml, $source_upload_url, $source_site );
					}

					// post, pages, menus and media
					if( $importer == 'content' ) {
						$this->import_content ( $data_xml );
					}

					// settings
					if ( $importer == 'settings' ) {
						$this->import_settings();
					}
					
					// menu
					if ( $importer == 'menu' ) {
						$this->import_menu();
					}

					// widgets
					if ( $importer == 'widgets' ) {
						$this->import_widgets( $data_xml, $source_upload_url, $source_site );
					}

					// megamenu
					if ( $importer == 'megamenu' ) {
						$this->import_megamenu( $data_xml );
					}

					// revolution slider
					if ( $importer == 'revslider' ) {
						$this->import_revslider( $data_dir . '/revslider/' );
					}

					// ninja forms
					if ( $importer == 'ninja_form' ) {
						$this->import_ninja_form( $data_xml );
					}

					// custom files /wp-upload/
					if ( $importer == 'custom_files' ) {
						$upload_dir = wp_upload_dir();
						$destination = $upload_dir['basedir'] . '/' . $data_file;
						$this->recurse_copy($data_xml, $destination);
					}

					$message = false;
					$error = false;

				} elseif ($do_import == 'dupe') {

					$error = true;
					$message = 'dupe';

					PE_ReduxImport::$_log->logInfo ($importer . ' of ' . $type . ' skipped to avoid duplicate content.');

				} else {

					$error = true;
					$message = 'skip';

					PE_ReduxImport::$_log->logInfo ($importer . ' of ' . $type . ' skipped as require plugin is not installed or active.');

				}

				PE_ReduxImport::$_log->logInfo('Finish ' . $type . ' import.');

				$response = array(
					'tt_post'   => $this->tt_post,
					'add_post'  => $this->add_post,
					'message'   => $message,
					'error'     => $error,
					'steps'     => false,
					'loop'      => $data_loop
				);

				wp_send_json_success ( $response );

			} else {
				die(0);
			}
		}

		// theme options
		private function import_theme_options ( $file, $source_upload_url, $source_site ) {
			$theme_options_import = $this->extension_dir . 'demo_content_import/demo_inc/theme_options_import.php';
			include_once $theme_options_import;
		}

		// wp content import
		private function import_content( $data_xml ) {
			$content_import = $this->extension_dir . 'demo_content_import/demo_inc/content_import.php';
			include_once $content_import;
		}

		// widgets import
		private function import_widgets( $data, $source_upload_url, $source_site ) {
			$widgets_import = $this->extension_dir . 'demo_content_import/demo_inc/widgets_import.php';
			include_once $widgets_import;
		}

		// wp settings
		private function import_settings() {
			$update_options = $this->extension_dir . 'demo_content_import/demo_inc/settings_import.php';
			include_once $update_options;
		}
		
		// wp settings
		private function import_menu() {
			$update_options = $this->extension_dir . 'demo_content_import/demo_inc/menu_import.php';
			include_once $update_options;
		}

		// megamenu import
		private function import_megamenu( $data_xml ) {
			$megamenu_import = $this->extension_dir . 'demo_content_import/demo_inc/megamenu_import.php';
			include_once $megamenu_import;
		}

		// revolution slider
		private function import_revslider( $data_dir ) {
			$revslider_import = $this->extension_dir . 'demo_content_import/demo_inc/revslider_import.php';
			include_once $revslider_import;
		}

		// ninja forms import
		private function import_ninja_forms( $data_xml ) {
			$ninja_import = $this->extension_dir . 'demo_content_import/demo_inc/ninja_forms_import.php';
			include_once $ninja_import;
		}

		//custom files
		private function recurse_copy($src, $dst) {

				PE_ReduxImport::$_log->logInfo ('Source ' . $src);
				PE_ReduxImport::$_log->logInfo ('Destination ' . $dst);

				$dir = opendir($src);
				$result = ($dir === false ? false : true);

				if ($result !== false) {
					$result = @mkdir($dst);

					if ($result === true) {
						while(false !== ( $file = readdir($dir)) ) {
							if (( $file != '.' ) && ( $file != '..' ) && $result) {
								if ( is_dir($src . '/' . $file) ) {
									$result = recurse_copy($src . '/' . $file,$dst . '/' . $file);
								} else {
									$result = copy($src . '/' . $file,$dst . '/' . $file);
								}
							}
						}
					}
					closedir($dir);
				}
				$this->add_post++;
				$this->tt_post = 1;

				return $result;
			}

		//other usefull methods
		private function recursive_array_replace($find, $replace, $array){
			if (!is_array($array)) {
				return str_replace($find, $replace, $array);
			}

			$newArray = array();
			foreach ($array as $key => $value) {
				$newArray[$key] = $this->recursive_array_replace($find, $replace, $value);
			}

			return $newArray;
		}

		public function clear_error_in_string ( $m ) {
			return 's:' . strlen ( $m[ 2 ] ) . ':"' . $m[ 2 ] . '";';
		}

		static public function getInstance() {
			return self::$theInstance;
		}

		// Forces the use of the embeded field path vs what the core typically would use
		public function overload_field_path($field) {
			return dirname(__FILE__) . '/' . $this->field_name . '/panel_' . $this->field_name . '.php';
		}

	}
}
