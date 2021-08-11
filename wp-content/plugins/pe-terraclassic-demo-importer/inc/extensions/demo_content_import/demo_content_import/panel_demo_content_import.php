<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
		exit;
}

// Don't duplicate me!
if (!class_exists('ReduxFramework_demo_content_import')) {

		/**
		 * Main ReduxFramework_demo_content_import class
		 *
		 * @since       3.1.5
		 */
		class ReduxFramework_demo_content_import {

				function __construct($field = array(), $value = '', $parent) {
						$this->parent = $parent;
						$this->field = $field;
						$this->value = $value;

						if ( empty($this->extension_dir) ) {
							$this->extension_dir = trailingslashit(str_replace('\\', '/', dirname(__FILE__)));
							$this->extension_url = site_url(str_replace(trailingslashit(str_replace('\\', '/', ABSPATH)), '', $this->extension_dir));
						}

						$this->field['import_data']         = isset( $this->field['import_data'] ) ? $this->field['import_data'] : array();

						$this->field['source_upload_url']   = isset( $this->field['source_upload_url'] ) ? $this->field['source_upload_url'] : '';
						$this->field['source_site']         = isset( $this->field['source_site'] ) ? $this->field['source_site'] : '';

						$this->field['timeout_warn']        = isset( $this->field['timeout_warn'] ) ? $this->field['timeout_warn'] : true;
						$this->field['timeout_seconds']     = isset( $this->field['timeout_seconds'] ) ? $this->field['timeout_seconds'] : 30;
				}

				private function let_to_num( $size ) {
						$l   = substr( $size, - 1 );

						if ( !is_numeric ( $l )) {
								$ret = substr( $size, 0, - 1 );

								switch ( strtoupper( $l ) ) {
										case 'P':
												$ret *= 1024;
										case 'T':
												$ret *= 1024;
										case 'G':
												$ret *= 1024;
										case 'M':
												$ret *= 1024;
										case 'K':
												$ret *= 1024;
								}

								return $ret;
						}

						return $size;
				}

				private function searchArrayKeyVal($sKey, $id, $array) {
						foreach ($array as $key => $val) {
								if ($val[$sKey] == $id) {
										return $key;
								}
						}
						return null;
				 }

				 private function set_html ($criteria, $min, $actual, $type, $is_warn = false) {
						$php = '';
						if($type == 'ini') {
								$php = 'PHP ';
						}

						$html =  '';
						$html .= '<tr>';
						$html .= '<td class="warn-block">';
						$html .= $php . $criteria;
						$html .= '</td>';
						$html .= '<td class="size">';

						if( $criteria == 'max_execution_time' ) {
							$html .= $actual . ' sec';
						} else {
							$html .= size_format ( $actual );
						}

						$html .= '</td>';
						$html .= '<td class="required">';

						if( $criteria == 'max_execution_time' ) {
							$html .= $min . ' sec';
						} else {
							$html .= size_format ( $min );
						}

						$html .= '</td>';
						$html .= '</tr>';

						 return $html;
				 }

				/**
				 * Field Render Function.
				 *
				 * Takes the vars and outputs the HTML for the field in the settings
				 *
				 * @since 		1.0.0
				 * @access		public
				 * @return		void
				 */
				public function render() {

					$err_title  = 'Demo Content Importer is unavailable!<br><br>';
					$contact    = 'Please contact the theme developer with this message so they may fix it.';

					// Check for valid import data array
					if (empty($this->field['import_data'])) {
							echo $err_title . 'The <code>data</code> argument is missing or empty. ' . $contact;
							return;
					}

					// Minimum Checks
					$show_warn      = isset($this->field['show_minimum_warn']) ? $this->field['show_minimum_warn'] : false;
					$minimum_data   = isset($this->field['minimums']) ? $this->field['minimums'] : array();

					$js_min = array();
					if ($show_warn) {
						$msg = '';
						if (!empty($minimum_data) && is_array($minimum_data)) {
							foreach ($this->field['minimums'] as $type => $sub) {
								if (isset($sub) && !empty($sub) && is_array($sub)) {
									foreach ($sub as $criteria => $value) {
										if( $type == 'ini' ) {
											$actual_ini = ini_get($criteria);
											$actual = $actual_ini;

											$js_min[$criteria] = $actual_ini;

											$actual = $this->let_to_num($actual);
											$min    = $this->let_to_num($value);

											$js_min[$criteria] = $actual_ini . '*';
											$msg .= $this->set_html($criteria, $min, $actual, $type, true);

										} elseif( $type == 'define' ) {
											if (defined($criteria)) {
												$actual_def = constant($criteria);
												$actual = $actual_def;

												$js_min[$criteria] = $actual_def;

												$actual = $this->let_to_num( $actual);
												$min    = $this->let_to_num($value);

												$js_min[$criteria] = $actual_def . '*';
												$msg .= $this->set_html($criteria, $min, $actual, $type, true);

											}
										}
									}
								}
							}
						}
					}

					// Set class_check as true/false per import_data array
					if (is_array($this->field['import_data'])) {
						// Enum import_data arrays
						foreach($this->field['import_data'] as $idx => $arr) {
							// Enum individual import_data array
							foreach($arr as $arg => $val) {
								// Check for 'class_check' arg
								if ( $arg == 'class_check' ) {
									// It exists, verify passed class name exists.
									if (class_exists($val)) {
										// it does, convert arg to true
										$arr['class_check'] = true;
									} else {
										// it does not, convert arg to false
										$arr['class_check'] = false;
									}
								} else {
									// arg does not exists, set arg to true by default.
									$arr['class_check'] = true;
								}
							}
							// reassign the altered array back to the parent
							$this->field['import_data'][$idx] = $arr;
						}
					}

					$min_data       = rawurlencode( json_encode($js_min) );

					$link           =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					$escaped_link   = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');

					$did_menus      = get_option('redux_demo_content_import_menus', false);
					$did_rev        = get_option('redux_demo_content_import_rev', false);

					$nonce          = wp_create_nonce('redux_demo_content_import_log');


					//echo '<p><strong>Select demo version:</strong></p>';

					echo '<div class="import_version">';

						$demo_array = PE_MainClass::$_demo_ver;
						$default_demo = key($demo_array);
						$default_data = $demo_array[$default_demo]['data-dir'];
						$dcount = 0;

						foreach( $demo_array as $demo => $version ) {

							$active = ( $dcount === 0 ) ? ' checked' : '';
							$dcount++;

							echo '<a href="#" class="demo_version' . $active . '"
										data-demo="' . rawurlencode( json_encode($demo) ) . '"
										data-dir="' . rawurlencode ( $version['data-dir'] ) . '"
										>' . $version['name'] . '<span style="background-image: url(' .  esc_url($version['screen']) . ');"></span>
										</a>';
						}

					echo '</div>';

					echo '<p><strong>Select data:</strong></p>';

					echo '<div class="import_content">';
						echo '<ul>';
							foreach( $this->field['import_data'] as $k => $v ) {
								echo '<li> <input class="checkbox noUpdate" type="checkbox" name="' . $v['importer'] . '" value="' . $k . '" data-content=\'' . rawurlencode( json_encode($this->field['import_data'][$k]) ) . '\' checked> ' . $v['type'] . '  </li>';
							}
						echo '</ul>';
					echo '</div>';


					echo '<div class="button-primary button_data_import">Import Demo Content</div>';
					echo '<a class="button button-primary button_data_log" href="#openModal">Show Logs</a>';
					echo '<a class="button button-primary button_reset" href="' . admin_url ( "tools.php?page=database-reset" ) . '">Reset Database</a>';
					echo '<div id="openModal" class="modalbg" data-nonce="' . $nonce . '">';
					echo     '<div class="dialog">';
					echo         '<a href="#close" title="Close" class="close">X</a>';
					echo         '<h2>Demo Importer Activity Log</h2>';
					echo         '<textarea readonly="readonly" class="log-area">Loading data...</textarea>';
					echo     '</div>';
					echo '</div>';

					$nonce = wp_create_nonce('redux_demo_content');

					echo '<div class="importer-holder"
									data-demo="' . rawurlencode( json_encode($default_demo) ) . '"
									data-dir="' . rawurlencode( $default_data ) . '"
									data-import-array="' . rawurlencode( json_encode($this->field['import_data']) ) . '"
									data-source-upload-url="' . rawurlencode( $this->field['source_upload_url'] ) . '"
									data-source-site="' . rawurlencode( $this->field['source_site'] ) . '"
									data-nonce="' . $nonce . '"
									data-timeout-warn="' . $this->field['timeout_warn'] . '"
									data-timeout-seconds="' . $this->field['timeout_seconds'] . '"
									data-did-menus="' . $did_menus . '"
									data-did-rev="' . $did_rev . '"
									data-min-data="' . $min_data . '"

								>';
					echo '</div>';

					echo '<div class="importer-result">';
					echo   '<div class="importer-result-success">Import completed successfully</div>';
					echo   '<div class="importer-result-fail">Sorry, an error occured. Please try to import again or use standard Worpdress Importer plugin.</div>';
					echo   '<div class="importer-result-warning">WARNING! During import, one or more steps took longer than 30s to process. This might affect the demo content import.</div>';
					echo '</div>';

					if ($show_warn) {
						if (!empty($msg)) {
							echo '<div class="pe-import-warn">';
							echo '<div><strong>Your server settings:</strong></div><br>';
							echo '<table class="pe-server-settings">';
							echo    '<tbody>';
							echo       '<tr>';
							echo          '<th>&nbsp;</th>';
							echo          '<th>Actual</th>';
							echo          '<th>Recommended</th>';
							echo       '</tr>';
							echo       $msg;
							echo    '</tbody>';
							echo '</table>';
							echo '<br>';
							echo '<div class="pe-important-note">Please note that due to the lack of memory on your server the internal errors may appear during the import.<br>';
							echo 'If any problems appear we suggest changing server setting to the recommended values.</div><br>';
							echo '</div>';
						}
					}

				}
		}
}
