<?php

global $wpdb;

					$updateAnim     = true;
					$updateStatic   = true;

					// Import Revslider
					if ( class_exists ( 'RevSliderFunctions' ) ) {
							$rev_directory = $data_dir;

							if (is_dir($rev_directory)) {
									foreach ( glob ( $rev_directory . '*.zip' ) as $filename ) {
											$filename       = basename ( $filename );
											$rev_files[]    = $rev_directory . $filename;
											$this->tt_post++;
									}
									add_option('redux_demo_content_import_tt_count', $this->tt_post);

									$importZip = false;

									WP_Filesystem();

									global $wp_filesystem;

									$upload_dir = wp_upload_dir();
									$d_path = $upload_dir['basedir'] . '/rstemp/';

									PE_ReduxImport::$_log->logInfo ('Extraction Directory: ' . $d_path);

									foreach ( $rev_files as $rev_file ) {
											PE_ReduxImport::$_log->logInfo ('Importing: ' . $rev_file);

		$sliderID = RevSliderFunctions::getPostVariable("sliderid");
		$sliderExists = !empty($sliderID);

											if ($sliderExists) {
													PE_ReduxImport::$_log->logInfo ('Slider already exists.  Aborting: ' . $rev_file);
													continue;
											}

											$filepath   = $rev_file;
											$unzipfile = unzip_file( $filepath, $d_path);

											if( is_wp_error($unzipfile) ){
													define('FS_METHOD', 'direct'); //lets try direct.
													WP_Filesystem();  //WP_Filesystem() needs to be called again since now we use direct !

													$unzipfile = unzip_file( $filepath, $d_path);

													if( is_wp_error($unzipfile) ){
															PE_ReduxImport::$_log->logInfo ('Unable to unzip file ' . $rev_file . ' due to invalid direwctory permissions.  Aborting.');
															return;
													}
											}

											if( !is_wp_error($unzipfile) ) { //true or integer. If integer, its not a correct zip file
													$importZip = true;

													$content = ( $wp_filesystem->exists( $d_path.'slider_export.txt' ) ) ? $wp_filesystem->get_contents( $d_path.'slider_export.txt' ) : '';
													if($content == ''){
															PE_ReduxImport::$_log->logInfo ('slider_export.txt does not exist!  ABorting.');
															return;
													}

													$animations = ( $wp_filesystem->exists( $d_path.'custom_animations.txt' ) ) ? $wp_filesystem->get_contents( $d_path.'custom_animations.txt' ) : '';
													$dynamic = ( $wp_filesystem->exists( $d_path.'dynamic-captions.css' ) ) ? $wp_filesystem->get_contents( $d_path.'dynamic-captions.css' ) : '';
													$static = ( $wp_filesystem->exists( $d_path.'static-captions.css' ) ) ? $wp_filesystem->get_contents( $d_path.'static-captions.css' ) : '';
													$navigations = ( $wp_filesystem->exists( $d_path.'navigation.txt' ) ) ? $wp_filesystem->get_contents( $d_path.'navigation.txt' ) : '';

													$uid_check = ( $wp_filesystem->exists( $d_path.'info.cfg' ) ) ? $wp_filesystem->get_contents( $d_path.'info.cfg' ) : '';
													$version_check = ( $wp_filesystem->exists( $d_path.'version.cfg' ) ) ? $wp_filesystem->get_contents( $d_path.'version.cfg' ) : '';

													$db = new RevSliderDB();

													//update/insert custom animations
													$animations = @unserialize ( $animations );
													if ( !empty ( $animations ) ) {
															PE_ReduxImport::$_log->logInfo ('Installing animations.');

															foreach ( $animations as $key => $animation ) { //$animation['id'], $animation['handle'], $animation['params']
																	$exist = $db->fetch ( RevSliderGlobals::$table_layer_anims, "handle = '" . $animation[ 'handle' ] . "'" );

																	if ( !empty ( $exist ) ) { //update the animation, get the ID
																			if ( $updateAnim == "true" ) { //overwrite animation if exists
																					$arrUpdate = array();
																					$arrUpdate[ 'params' ] = stripslashes ( json_encode ( str_replace ( "'", '"', $animation[ 'params' ] ) ) );
																					$db->update ( RevSliderGlobals::$table_layer_anims, $arrUpdate, array( 'handle' => $animation[ 'handle' ] ) );

																					$id = $exist[ '0' ][ 'id' ];
																			} else { //insert with new handle
																					$arrInsert = array();
																					$arrInsert[ "handle" ] = 'copy_' . $animation[ 'handle' ];
																					$arrInsert[ "params" ] = stripslashes ( json_encode ( str_replace ( "'", '"', $animation[ 'params' ] ) ) );

																					$id = $db->insert ( RevSliderGlobals::$table_layer_anims, $arrInsert );
																			}
																	} else { //insert the animation, get the ID
																			$arrInsert = array();
																			$arrInsert[ "handle" ] = $animation[ 'handle' ];
																			$arrInsert[ "params" ] = stripslashes ( json_encode ( str_replace ( "'", '"', $animation[ 'params' ] ) ) );

																			$id = $db->insert ( RevSliderGlobals::$table_layer_anims, $arrInsert );
																	}

																	//and set the current customin-oldID and customout-oldID in slider params to new ID from $id
																	$content = str_replace ( array( 'customin-' . $animation[ 'id' ], 'customout-' . $animation[ 'id' ] ), array( 'customin-' . $id, 'customout-' . $id ), $content );
															}
													}

													//overwrite/append static-captions.css
													if ( !empty ( $static ) ) {
															if ( $updateStatic == "true" ) { //overwrite file
																	PE_ReduxImport::$_log->logInfo ('Updating static CSS.');
																	RevSliderOperations::updateStaticCss ( $static );
															} else { //append
																	$static_cur = RevSliderOperations::getStaticCss ();
																	$static = $static_cur . "\n" . $static;
																	RevSliderOperations::updateStaticCss ( $static );
															}
													}

													//overwrite/create dynamic-captions.css
													//parse css to classes
													$dynamicCss = RevSliderCssParser::parseCssToArray ( $dynamic );

													if ( is_array ( $dynamicCss ) && $dynamicCss !== false && count ( $dynamicCss ) > 0 ) {
															PE_ReduxImport::$_log->logInfo ('Updating dynamic captions.');

															foreach ( $dynamicCss as $class => $styles ) {
																	//check if static style or dynamic style
																	$class = trim ( $class );

																	if ( (strpos ( $class, ':hover' ) === false && strpos ( $class, ':' ) !== false) || //before, after
																					strpos ( $class, " " ) !== false || // .tp-caption.imageclass img or .tp-caption .imageclass or .tp-caption.imageclass .img
																					strpos ( $class, ".tp-caption" ) === false || // everything that is not tp-caption
																					(strpos ( $class, "." ) === false || strpos ( $class, "#" ) !== false) || // no class -> #ID or img
																					strpos ( $class, ">" ) !== false ) { //.tp-caption>.imageclass or .tp-caption.imageclass>img or .tp-caption.imageclass .img
																			continue;
																	}

																	//is a dynamic style
																	if ( strpos ( $class, ':hover' ) !== false ) {
																			$class = trim ( str_replace ( ':hover', '', $class ) );
																			$arrInsert = array();
																			$arrInsert[ "hover" ] = json_encode ( $styles );
																			$arrInsert[ "settings" ] = json_encode ( array( 'hover' => 'true' ) );
																	} else {
																			$arrInsert = array();
																			$arrInsert[ "params" ] = json_encode ( $styles );
																	}
																	//check if class exists
																	$result = $db->fetch ( RevSliderGlobals::$table_css, "handle = '" . $class . "'" );

																	if ( !empty ( $result ) ) { //update
																			$db->update ( RevSliderGlobals::$table_css, $arrInsert, array( 'handle' => $class ) );
																	} else { //insert
																			$arrInsert[ "handle" ] = $class;
																			$db->insert ( RevSliderGlobals::$table_css, $arrInsert );
																	}
															}
													}

													//update/insert custom animations
													$navigations = @unserialize($navigations);
													if(!empty($navigations)){
															PE_ReduxImport::$_log->logInfo ('Updating navigations.');

															foreach($navigations as $key => $navigation){
																	$exist = $db->fetch(RevSliderGlobals::$table_navigation, $db->prepare("handle = %s", array($navigation['handle'])));
																	unset($navigation['id']);

																	$rh = $navigation["handle"];

																	if(!empty($exist)){ //create new navigation, get the ID
																			if($updateNavigation == "true"){ //overwrite navigation if exists
																					unset($navigation['handle']);
																					$db->update(RevSliderGlobals::$table_navigation, $navigation, array('handle' => $rh));
																			}else{
																					//insert with new handle
																					$navigation["handle"] = $navigation['handle'].'-'.date('is');
																					$navigation["name"] = $navigation['name'].'-'.date('is');
																					$content = str_replace($rh.'"', $navigation["handle"].'"', $content);
																					$navigation["css"] = str_replace('.'.$rh, '.'.$navigation["handle"], $navigation["css"]); //change css class to the correct new class
																					$navi_id = $db->insert(RevSliderGlobals::$table_navigation, $navigation);
																			}
																	}else{
																			$navi_id = $db->insert(RevSliderGlobals::$table_navigation, $navigation);
																	}
															}
													}
											} else {
													$message = $unzipfile->get_error_message();
													PE_ReduxImport::$_log->logInfo ('Rev Slider Import Failed.  Could not unzip file.  Error: ' . $message );
													return;
											}

											$content = preg_replace_callback ( '!s:(\d+):"(.*?)";!', array( $this, 'clear_error_in_string' ), $content ); //clear errors in string

											$arrSlider = @unserialize ( $content );

											//update slider params
											$sliderParams = $arrSlider[ "params" ];

											if ( isset ( $sliderParams[ "background_image" ] ) ) {
													$sliderParams[ "background_image" ] = RevSliderFunctionsWP::getImageUrlFromPath ( $sliderParams[ "background_image" ] );
											}

											$json_params = json_encode ( $sliderParams );

											//new slider
											$arrInsert              = array();
											$arrInsert[ "params" ]  = $json_params;
											$arrInsert[ "title" ]   = RevSliderFunctions::getVal ( $sliderParams, "title", "Slider1" );
											$arrInsert[ "alias" ]   = RevSliderFunctions::getVal ( $sliderParams, "alias", "slider1" );

											$sliderID = $wpdb->insert ( RevSliderGlobals::$table_sliders, $arrInsert );
											$sliderID = $wpdb->insert_id;

											//-------- Slides Handle -----------
											//create all slides
											$arrSlides = $arrSlider[ "slides" ];

											$alreadyImported = array();

		$content_url = content_url();
		$content_path = ABSPATH . 'wp-content';

											$slide_num = 1;
											foreach ( $arrSlides as $slide ) {
													PE_ReduxImport::$_log->logInfo ('Creating slide #' . $slide_num);

													$params = $slide[ "params" ];
													$layers = $slide[ "layers" ];
													$settings = (isset($slide["settings"])) ? $slide["settings"] : '';

													if($importZip === true){
															if(isset($params['image_id'])) unset($params['image_id']);

															if(isset($params["image"])){
																	$params["image"] = RevSliderBase::check_file_in_zip($d_path, $params["image"], $sliderParams["alias"], $alreadyImported);
																	$params["image"] = RevSliderFunctionsWP::getImageUrlFromPath($params["image"]);

															}

															if(isset($params["background_image"])){
																	$params["background_image"] = RevSliderBase::check_file_in_zip($d_path, $params["background_image"], $sliderParams["alias"], $alreadyImported);
																	$params["background_image"] = RevSliderFunctionsWP::getImageUrlFromPath($params["background_image"]);

															}

															if(isset($params["slide_thumb"])){
																	$params["slide_thumb"] = RevSliderBase::check_file_in_zip($d_path, $params["slide_thumb"], $sliderParams["alias"], $alreadyImported);
																	$params["slide_thumb"] = RevSliderFunctionsWP::getImageUrlFromPath($params["slide_thumb"]);

															}

															if(isset($params["show_alternate_image"])){
																	$params["show_alternate_image"] = RevSliderBase::check_file_in_zip($d_path, $params["show_alternate_image"], $sliderParams["alias"], $alreadyImported);
																	$params["show_alternate_image"] = RevSliderFunctionsWP::getImageUrlFromPath($params["show_alternate_image"]);

															}

															if(isset($params['background_type']) && $params['background_type'] == 'html5'){
																	if(isset($params['slide_bg_html_mpeg']) && $params['slide_bg_html_mpeg'] != ''){
																			$params['slide_bg_html_mpeg'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $params["slide_bg_html_mpeg"], $sliderParams["alias"], $alreadyImported, true));
																	}

																	if(isset($params['slide_bg_html_webm']) && $params['slide_bg_html_webm'] != ''){
																			$params['slide_bg_html_webm'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $params["slide_bg_html_webm"], $sliderParams["alias"], $alreadyImported, true));
																	}

																	if(isset($params['slide_bg_html_ogv'])  && $params['slide_bg_html_ogv'] != ''){
																			$params['slide_bg_html_ogv'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $params["slide_bg_html_ogv"], $sliderParams["alias"], $alreadyImported, true));
																	}
															}
													}

													//convert layers images:
													foreach ( $layers as $key => $layer ) {
															if($importZip === true){
																	if ( isset ( $layer[ "image_url" ] ) ) {
																			$layer["image_url"] = RevSliderBase::check_file_in_zip($d_path, $layer["image_url"], $sliderParams["alias"], $alreadyImported);
																			$layer["image_url"] = RevSliderFunctionsWP::getImageUrlFromPath($layer["image_url"]);
																	}

																	if(isset($layer['type']) && $layer['type'] == 'video'){
																			$video_data = (isset($layer['video_data'])) ? (array) $layer['video_data'] : array();

																			if(!empty($video_data) && isset($video_data['video_type']) && $video_data['video_type'] == 'html5'){
																					if(isset($video_data['urlPoster']) && $video_data['urlPoster'] != ''){
																							$video_data['urlPoster'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $video_data["urlPoster"], $sliderParams["alias"], $alreadyImported));
																					}

																					if(isset($video_data['urlMp4']) && $video_data['urlMp4'] != ''){
																							$video_data['urlMp4'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $video_data["urlMp4"], $sliderParams["alias"], $alreadyImported, true));
																					}

																					if(isset($video_data['urlWebm']) && $video_data['urlWebm'] != ''){
																							$video_data['urlWebm'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $video_data["urlWebm"], $sliderParams["alias"], $alreadyImported, true));
																					}

																					if(isset($video_data['urlOgv']) && $video_data['urlOgv'] != ''){
																							$video_data['urlOgv'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $video_data["urlOgv"], $sliderParams["alias"], $alreadyImported, true));
																					}

																			} elseif(!empty($video_data) && isset($video_data['video_type']) && $video_data['video_type'] != 'html5'){ //video cover image
																					if($video_data['video_type'] == 'audio'){
																							if(isset($video_data['urlAudio']) && $video_data['urlAudio'] != ''){
																									$video_data['urlAudio'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $video_data["urlAudio"], $sliderParams["alias"], $alreadyImported, true));
																							}
																					}else{
																							if(isset($video_data['previewimage']) && $video_data['previewimage'] != ''){
																									$video_data['previewimage'] = RevSliderFunctionsWP::getImageUrlFromPath(RevSliderBase::check_file_in_zip($d_path, $video_data["previewimage"], $sliderParams["alias"], $alreadyImported));
																							}
																					}
																			}

																			$layer['video_data'] = $video_data;
																	}

																	if(isset($layer['type']) && $layer['type'] == 'svg'){
																			if(isset($layer['svg']) && isset($layer['svg']->src)){
																					$layer['svg']->src = $content_url.$layer['svg']->src;
																			}
																	}
															}

															$layer['text'] = stripslashes($layer['text']);
															$layers[ $key ] = $layer;
													}

													//create new slide
													$arrCreate                  = array();
													$arrCreate[ "slider_id" ]   = $sliderID;
													$arrCreate[ "slide_order" ] = $slide[ "slide_order" ];

													$my_layers = json_encode($layers);
													if(empty($my_layers)) {
															$my_layers = stripslashes(json_encode($layers));
													}

													$my_params = json_encode($params);
													if(empty($my_params)) {
															$my_params = stripslashes(json_encode($params));
													}

													$my_settings = json_encode($settings);
													if(empty($my_settings)) {
															$my_settings = stripslashes(json_encode($settings));
													}

													$arrCreate[ "layers" ]      = $my_layers;
													$arrCreate[ "params" ]      = $my_params;
													$arrCreate["settings"]      = $my_settings;

													$wpdb->insert ( RevSliderGlobals::$table_slides, $arrCreate );

													$c_slider = new RevSliderSlider();
													$c_slider->initByID($sliderID);

													$cus_js = $c_slider->getParam('custom_javascript', '');

													if(strpos($cus_js, 'revapi') !== false){
															if(preg_match_all('/revapi[0-9]*/', $cus_js, $results)){
																	if(isset($results[0]) && !empty($results[0])){
																			foreach($results[0] as $replace){
																					$cus_js = str_replace($replace, 'revapi'.$sliderID, $cus_js);
																			}
																	}

																	$c_slider->updateParam(array('custom_javascript' => $cus_js));
															}
													}


													$slide_num++;
											}

											$wp_filesystem->delete($d_path, true);

											$this->add_post++;
											update_option('redux_demo_content_import_post_count', $this->add_post);
									}

									update_option('redux_demo_content_import_rev', true);
							}
					}
