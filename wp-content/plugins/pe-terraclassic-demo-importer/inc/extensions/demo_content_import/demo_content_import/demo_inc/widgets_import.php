<?php
if ( !file_exists ( $data ) ) {
		wp_die ();
}

PE_ReduxImport::$_log->logInfo ('Importing: ' . $data);

global $wp_registered_sidebars, $wp_registered_widget_controls;

$widget_controls    = $wp_registered_widget_controls;
$available_widgets  = array();
$widget_instances   = array();
$results            = array();

$data = file_get_contents ( $data );
$data = json_decode ( $data, true );

// Get site upload url and dir
$upload_dir = wp_upload_dir();
$base_url   = $upload_dir['baseurl'];

// Replace upload urls (you never know)
$new_data = $this->recursive_array_replace($source_upload_url, $base_url, $data);

$short_url      = str_replace('www.', '', $source_upload_url);
$new_data = $this->recursive_array_replace($short_url, $base_url, $new_data);

// Replace site URL
$new_data = $this->recursive_array_replace($source_site, site_url(), $new_data);

$short_url      = str_replace('www.', '', $source_site);
$new_options = $this->recursive_array_replace($short_url, site_url(), $new_data);

foreach ( $widget_controls as $widget ) {
		if ( !empty ( $widget[ 'id_base' ] ) && !isset ( $available_widgets[ $widget[ 'id_base' ] ] ) ) {
				$available_widgets[ $widget[ 'id_base' ] ][ 'id_base' ] = $widget[ 'id_base' ];
				$available_widgets[ $widget[ 'id_base' ] ][ 'name' ] = $widget[ 'name' ];
		}
}

foreach ( $available_widgets as $widget_data ) {
		$widget_instances[ $widget_data[ 'id_base' ] ] = get_option ( 'widget_' . $widget_data[ 'id_base' ] );
}

foreach ( $new_data as $sidebar_id => $widgets ) {
		PE_ReduxImport::$_log->logInfo ('Importing sidebar "' . $sidebar_id . '"');

		if ( 'wp_inactive_widgets' == $sidebar_id ) {
				PE_ReduxImport::$_log->logInfo ($sidebar_id . ': Inactive Widgets.');

				continue;
		}

		if ( isset ( $wp_registered_sidebars[ $sidebar_id ] ) ) {
				$sidebar_available = true;
				$use_sidebar_id = $sidebar_id;
				$sidebar_message_type = 'success';
				$sidebar_message = '';

				PE_ReduxImport::$_log->logInfo ('Sidebar "' . $sidebar_id . '" Imported.');
		} else {
				$sidebar_available = false;
				$use_sidebar_id = 'wp_inactive_widgets';
				$sidebar_message_type = 'error';
				$sidebar_message = __ ( 'Sidebar does not exist in theme (using Inactive)', 'pe-services-demo-importer' );

				PE_ReduxImport::$_log->logInfo ($sidebar_id . ': ' . $sidebar_message);
		}

		$results[ $sidebar_id ][ 'name' ]           = !empty ( $wp_registered_sidebars[ $sidebar_id ][ 'name' ] ) ? $wp_registered_sidebars[ $sidebar_id ][ 'name' ] : $sidebar_id;
		$results[ $sidebar_id ][ 'message_type' ]   = $sidebar_message_type;
		$results[ $sidebar_id ][ 'message' ]        = $sidebar_message;
		$results[ $sidebar_id ][ 'widgets' ]        = array();

		foreach ( $widgets as $widget_instance_id => $widget ) {
				$fail = false;
				$id_base = preg_replace ( '/-[0-9]+$/', '', $widget_instance_id );
				$instance_id_number = str_replace ( $id_base . '-', '', $widget_instance_id );

				PE_ReduxImport::$_log->logInfo ('Importing widget "' . $id_base . '" for sidebar "' . $sidebar_id . '".');

				if ( !$fail && !isset ( $available_widgets[ $id_base ] ) ) {
						$fail                   = true;
						$widget_message_type    = 'error';
						$widget_message         = __ ( 'Site does not support widget', 'pe-services-demo-importer' );
						PE_ReduxImport::$_log->logError ($id_base . ': ' . $widget_message);
				}

				$widget = apply_filters ( 'import_widget_settings', $widget );

				if ( !$fail && isset ( $widget_instances[ $id_base ] ) ) {
						$sidebars_widgets = get_option ( 'sidebars_widgets' );
						$sidebar_widgets = isset ( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array();
						$single_widget_instances = !empty ( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();

						// Nuke preinstalled widgets
						if ($use_sidebar_id == PE_MainClass::$_first_sidebar) {
								$search_arr = array(
										'search-2',
										'recent-posts-2',
										'recent-comments-2',
										'archives-2',
										'categories-2',
										'meta-2'
								);

								$arr_count = count($sidebar_widgets);

								foreach($search_arr as $val) {
										$key = array_search($val, $sidebar_widgets );
										if ($key !== false) {
												unset ($sidebar_widgets[$key]);
										}
								}

								if (count($sidebars_widgets) < $arr_count) {
										$sidebars_widgets[ $use_sidebar_id ] = $sidebar_widgets;
										update_option('sidebars_widgets', $sidebars_widgets );
								}
						}

						foreach ( $single_widget_instances as $check_id => $check_widget ) {

								if ( in_array ( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
										$fail                   = true;
										$widget_message_type    = 'warning';
										$widget_message         = __ ( 'Widget already exists', 'pe-services-demo-importer' );
										PE_ReduxImport::$_log->logWarn ($id_base . ' ' . $widget_message);

										break;
								}
						}
				}

				if ( !$fail ) {
						$single_widget_instances = get_option ( 'widget_' . $id_base );
						$single_widget_instances = !empty ( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 );
						$single_widget_instances[] = (array) $widget;
						end ( $single_widget_instances );
						$new_instance_id_number = key ( $single_widget_instances );

						if ( '0' === strval ( $new_instance_id_number ) ) {
								$new_instance_id_number = 1;
								$single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[ 0 ];
								unset ( $single_widget_instances[ 0 ] );
						}

						if ( isset ( $single_widget_instances[ '_multiwidget' ] ) ) {
								$multiwidget = $single_widget_instances[ '_multiwidget' ];
								unset ( $single_widget_instances[ '_multiwidget' ] );
								$single_widget_instances[ '_multiwidget' ] = $multiwidget;
						}

						update_option ( 'widget_' . $id_base, $single_widget_instances );
						$sidebars_widgets = get_option ( 'sidebars_widgets' );
						$new_instance_id = $id_base . '-' . $new_instance_id_number;
						$sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id;
						update_option ( 'sidebars_widgets', $sidebars_widgets );

						if ( $sidebar_available ) {
								$widget_message_type    = 'success';
								$widget_message         = __ ( 'Imported', 'pe-services-demo-importer' );
								PE_ReduxImport::$_log->logInfo ('Widget "' . $id_base . '" ' . $widget_message);
						} else {
								$widget_message_type    = 'warning';
								$widget_message         = __ ( 'Imported to Inactive', 'pe-services-demo-importer' );
								PE_ReduxImport::$_log->logWarn ('Widget "' . $id_base . '" ' . $widget_message);
						}

						$this->add_post++;
				}

//                    $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'name' ]           = isset ( $available_widgets[ $id_base ][ 'name' ] ) ? $available_widgets[ $id_base ][ 'name' ] : $id_base;
//                    $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'title' ]          = $widget['title'] ? $widget['title'] : __ ( 'No Title', 'pe-services-demo-importer' );
//                    $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'message_type' ]   = $widget_message_type;
//                    $results[ $sidebar_id ][ 'widgets' ][ $widget_instance_id ][ 'message' ]        = $widget_message;

				$this->tt_post++;
		}
}
