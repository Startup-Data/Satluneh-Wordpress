<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
---------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Register PixelEmu Theme options page hook from ot-functions-admin.php
/*-----------------------------------------------------------------------------------*/

		// Load filters only if we are in admin area
		if( is_admin() ) {

				// Move menu at top level
				add_filter( 'ot_theme_options_parent_slug', '__return_false' );

				// Add menu icon
				add_filter( 'ot_theme_options_icon_url', 'pe_theme_icon');
				function pe_theme_icon(){
						return get_template_directory_uri() .'/images/admin/pe_icon.png';
				}

				// Add menu position
				add_filter( 'ot_theme_options_position', 'pe_menu_position');
				function pe_menu_position(){
					 return '47';
				}

				// Change slug
				add_filter( 'ot_theme_options_menu_slug', 'pe_menu_slug');
				function pe_menu_slug(){
					 return 'pixelemu-options';
				}

				// Change Upload Text
				add_filter( 'ot_upload_text', 'pe_upload_text' );
				function pe_upload_text(){
					 return __( 'Add Image', 'PixelEmu' );
				}

		}

/*-----------------------------------------------------------------------------------*/
/*	Change the Theme Option header list.
/*-----------------------------------------------------------------------------------*/

		add_action( 'ot_header_version_text', 'filter_pixelemu_header_list' );
		function filter_pixelemu_header_list() {
				echo '<li id="theme-version"><span><a href="//www.pixelemu.com/" title="Pixelemu" target="_blank">';
				_e('PE Beauty Center - by Pixelemu.com','PixelEmu');
				echo '</a></span></li>';
		}

		add_action( 'ot_header_logo_link', 'filter_pixelemu_header_logo' );
		function filter_pixelemu_header_logo() {
				echo '<li id="option-tree-logo"><a href="//www.pixelemu.com/" target="_blank">';
				_e('Pixelemu.com','PixelEmu');
				echo '</a></li>';
		}

/*-----------------------------------------------------------------------------------*/
/*	Theme Mode
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_theme_mode', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Child Theme Mode
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_child_theme_mode', '__return_false' );
/*-----------------------------------------------------------------------------------*/
/*	Hide Settings Page
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_show_pages', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Show Theme Options UI Builder
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_show_options_ui', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Show Settings Import
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_show_settings_import', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Show Settings Export
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_show_settings_export', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Hide New Layout
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_show_new_layout', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Hide Documentation
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_show_docs', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Custom Theme Option page
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_use_theme_options', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Meta Boxes
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_meta_boxes', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	Allow Unfiltered HTML in textareas options
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_allow_unfiltered_html', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Loads the meta boxes for post formats
/*-----------------------------------------------------------------------------------*/
		add_filter( 'ot_post_formats', '__return_true' );

/*-----------------------------------------------------------------------------------*/
/*	OptionTree in Theme Mode
/*-----------------------------------------------------------------------------------*/
		include (get_template_directory() . '/option-tree/ot-loader.php' );

/*-----------------------------------------------------------------------------------*/
/*	Theme Options
/*-----------------------------------------------------------------------------------*/
		include (get_template_directory() . '/option-tree-inc/theme-options.php' );

/*-----------------------------------------------------------------------------------*/
/*	Meta Boxes
/*-----------------------------------------------------------------------------------*/
		include (get_template_directory() . '/option-tree-inc/meta-boxes.php' );

/*-----------------------------------------------------------------------------------*/
/*	Theme Customizer
/*-----------------------------------------------------------------------------------*/
		include (get_template_directory() . '/option-tree-inc/customizer.php' );

/*-----------------------------------------------------------------------------------*/
/*	Demo Functions (for demonstration purposes only!)
/*-----------------------------------------------------------------------------------*/
		include (get_template_directory() . '/option-tree-inc/functions.php' );

?>
