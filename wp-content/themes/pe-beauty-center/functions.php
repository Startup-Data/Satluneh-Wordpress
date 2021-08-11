<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Scripts and styles functions
/*-----------------------------------------------------------------------------------*/
	include (get_template_directory() . '/functions/register-scripts.php' );

/*-----------------------------------------------------------------------------------*/
/*	Include base functions
/*-----------------------------------------------------------------------------------*/
	include (get_template_directory() . '/functions/base-functions.php' );

/*-----------------------------------------------------------------------------------*/
/*	Include theme options
/*-----------------------------------------------------------------------------------*/
	include (get_template_directory() . '/functions/option-tree.php' );

/*-----------------------------------------------------------------------------------*/
/*	Include pagination fuction
/*-----------------------------------------------------------------------------------*/
	//include (get_template_directory() . '/functions/pagination.php' );

/*-----------------------------------------------------------------------------------*/
/*	Include contact handler
/*-----------------------------------------------------------------------------------*/
	include (get_template_directory() . '/functions/send-email.php');
/*-----------------------------------------------------------------------------------*/
/*	TGM Activation
/*-----------------------------------------------------------------------------------*/
	require_once dirname( __FILE__ ) . '/functions/class-tgm-plugin-activation.php';
	add_action( 'tgmpa_register', 'pe_theme_register_plugins' );
	include (get_template_directory() . '/functions/class-tgm-plugin-activation-options.php');
/*-----------------------------------------------------------------------------------*/
/*	Include Plugin dir, required to check if megamenu is active
/*-----------------------------------------------------------------------------------*/
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/*-----------------------------------------------------------------------------------*/
/*	Include Bootstrap NacWalker if Megamenu is Inactive or Not Installed
/*-----------------------------------------------------------------------------------*/
	if ( is_plugin_inactive( 'megamenu/megamenu.php' ) ) {

			include (get_template_directory() . '/functions/includes/wp_bootstrap_navwalker.php' );

	}

remove_action('wp_head', 'wp_generator');
