<?php

// Set imported MAIN MENU to registered theme location
$locations  = get_theme_mod ( 'nav_menu_locations' );
$menus      = wp_get_nav_menus ();

if( $menus ) {
	foreach ( $menus as $menu ) {
		if ( $menu->slug == PE_MainClass::$_menu_location ) {
			$locations[ 'main-menu' ] = $menu->term_id;
			PE_ReduxImport::$_log->logInfo ('Setting Main Menu' );
		}
		if ( $menu->slug == PE_MainClass::$_skipmenu_location ) {
			$locations[ 'skip-menu' ] = $menu->term_id;
			PE_ReduxImport::$_log->logInfo ('Setting Skip Menu' );
		}
	}
}
set_theme_mod ( 'nav_menu_locations', $locations );

