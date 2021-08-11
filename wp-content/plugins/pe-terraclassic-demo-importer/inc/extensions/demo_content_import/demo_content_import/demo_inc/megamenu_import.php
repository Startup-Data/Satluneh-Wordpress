<?php

if ( !file_exists ( $data_xml ) ) {
	wp_die();
}

	PE_ReduxImport::$_log->logInfo ('Importing: ' . $data_xml);

	$data = file_get_contents ( $data_xml );
	$import = json_decode ( $data, true );

	if ( is_array( $import ) ) {

		$saved_themes = get_site_option( "megamenu_themes" );

		$last_id = 0;

		if ( $saved_themes = get_site_option( "megamenu_themes" ) ) {

				foreach ( $saved_themes as $key => $value ) {

						if ( strpos( $key, 'custom_theme' ) !== FALSE ) {

								$parts = explode( "_", $key );
								$theme_id = end( $parts );

								if ($theme_id > $last_id) {
										$last_id = $theme_id;
								}

						}

				}

		}

		$next_id = $last_id + 1;

		$import['title'] = $import['title'] . " " . __('(Imported)', 'megamenu');

		$new_theme_id = "custom_theme_" . $next_id;

		$saved_themes[ $new_theme_id ] = $import;

		update_site_option( "megamenu_themes", $saved_themes );

		PE_ReduxImport::$_log->logInfo ('Megamenu settings imported');

		$location = PE_MainClass::$_menu_location;

		$submitted_settings = array();
		$submitted_settings[$location]['enabled'] = 1; //enable megamenu for menu
		$submitted_settings[$location]['theme'] = $new_theme_id; //set imported theme as default

		if ( ! get_option( 'megamenu_settings' ) ) {

			update_option( 'megamenu_settings', $submitted_settings );

		} else {

			$existing_settings = get_option( 'megamenu_settings' );

			$new_settings = array_merge( $existing_settings, $submitted_settings );

			update_option( 'megamenu_settings', $new_settings );

		}

		PE_ReduxImport::$_log->logInfo ('Megamenu theme ' . $new_theme_id . ' set as default');

	}

	$this->add_post++;
	$this->tt_post++;
