<?php
if ( !class_exists ( 'WP_Importer' ) ) {
	$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	include_once $wp_importer;
}

if ( !class_exists ( 'PE_WP_Import' ) ) {
	$wp_import = $this->extension_dir . 'demo_content_import/demo_inc/wordpress_importer.php';
	include_once $wp_import;
}

$importer   = new PE_WP_Import($this);
$theme_xml  = $data_xml;

$importer->fetch_attachments = true;

ob_start ();

$importer->import ( $theme_xml );

ob_end_clean ();

update_option('redux_demo_content_import_menus', true);

unset($importer);

