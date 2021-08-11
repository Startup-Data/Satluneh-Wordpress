<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( !defined ( 'ABSPATH' ) ) {
		exit;
}

if ( !class_exists ( 'Redux' ) ) {
		return;
}

$opt_name   = PE_MainClass::$_opt_name;

$args = array(
		'opt_name'              => $opt_name,
		'display_name'          => PE_MainClass::$_name,
		'display_version'       => PE_MainClass::$_ver,
		'menu_type'             => 'menu',
		'allow_sub_menu'        => false,
		'menu_title'            => PE_MainClass::$_name,
		'page_title'            => PE_MainClass::$_name,
		'async_typography'      => false,
		'admin_bar'             => false,
		'admin_bar_icon'        => 'dashicons-upload',
		'global_variable'       => '',
		'dev_mode'              => false,
		'update_notice'         => false,
		'customizer'            => false,
		'page_priority'         => null,
		'page_parent'           => 'themes.php',
		'page_permissions'      => 'manage_options',
		'menu_icon'             => '',
		'last_tab'              => '',
		'page_icon'             => 'dashicons-upload',
		'menu_icon'             => 'dashicons-upload',
		'page_slug'             => PE_MainClass::$_slug,
		'save_defaults'         => true,
		'default_show'          => false,
		'default_mark'          => '',
		'page_priority'         => 63,
		'show_import_export'    => false,
		'transient_time'        => 60 * MINUTE_IN_SECONDS,
		'output'                => false,
		'output_tag'            => false,
		'database'              => '',
		'show_options_object'   => false,
		'open_expanded'         => true,
		'hide_expand'           => true,
		'hide_reset'            => true,
		'hide_save'             => true,
);

Redux::setArgs ( $opt_name, $args );

Redux::setSection ( $opt_name, array(
		'id'       => 'demo-importer-options',
		'title'    => PE_MainClass::$_name,
		'subtitle' => '',
		'icon'     => 'fa fa-upload',
		'fields'   => array(
				array(
						'id'                  => 'import-demo',
						'type'                => 'demo_content_import',
						'title'               => PE_MainClass::$_title,
						'subtitle'            => PE_MainClass::$_desc,
						'full_width'          => true,
						'timeout_warn'        => false,
						'show_minimum_warn'   => true,
						'minimums'            => array(
							'ini' => array(
								'max_execution_time'    => 60,
								'memory_limit'          => '128M',
								'post_max_size'         => '64M',
								'upload_max_filesize'   => '64M',
							),
							'define' => array(
								'WP_MEMORY_LIMIT'       => '256M',
								'WP_MAX_MEMORY_LIMIT'   => '512M',
							),
						),
						'logging'             => true,
						'log'                 => ReduxFramework::$_upload_dir . 'demo_content_import.log',

						'import_data'         => PE_MainClass::$_import_data,

				),
		),
));

Redux::setExtensions( $opt_name, PE_MainClass::$_dir . 'inc/extensions' );

Redux::init ($opt_name);
