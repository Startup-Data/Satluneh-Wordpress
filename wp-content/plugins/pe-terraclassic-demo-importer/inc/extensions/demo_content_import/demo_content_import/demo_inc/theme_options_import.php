<?php

if ( !file_exists ( $file ) ) {
	wp_die ();
}

PE_ReduxImport::$_log->logInfo ('Importing: ' . $file);

$file_contents  = file_get_contents ( $file );
$options        = json_decode ( $file_contents, true );

// Get site upload url and dir
$upload_dir = wp_upload_dir();
$base_url   = $upload_dir['baseurl'];

// Replace upload urls
$new_options    = $this->recursive_array_replace($source_upload_url, $base_url, $options);

$short_url      = str_replace('www.', '', $source_upload_url);
$new_options    = $this->recursive_array_replace($short_url, $base_url, $new_options);

// Replace site URL
$new_options    = $this->recursive_array_replace($source_site, site_url(), $new_options);

$short_url      = str_replace('www.', '', $source_site);
$new_options    = $this->recursive_array_replace($short_url, site_url(), $new_options);

$redux          = ReduxFrameworkInstances::get_instance ( PE_MainClass::$_theme_options_name );

$redux->set_options ( $new_options );

$this->tt_post = $this->add_post = count ( $options );
