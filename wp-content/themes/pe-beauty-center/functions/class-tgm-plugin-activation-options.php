<?php
/**
 * Register the required plugins for this theme.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function pe_theme_register_plugins() {
		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
				array(
					'name'		=> 'Slider Revolution',
					'slug'		=> 'revslider',
					'source'	=> 'http://demo.pixelemu.com/wp-plugins/revslider.zip',
					'required'	=> false
				),
				array(
						'name'			=> 'PE Beauty Center Plugin',
						'slug'			=> 'pe-beauty-center-plugin',
						'source'		=> 'http://demo.pixelemu.com/wp-plugins/pe-beauty-center/pe-beauty-center-plugin.zip',
						'required'		=> true
				),
				array(
						'name' 			=> 'AH Display Widgets',
						'slug' 			=> 'ah-display-widgets',
						'version'		=> '1.0.3',
						'required'		=> true
				),
				array(
						'name' 		=> 'Max Mega Menu',
						'slug' 		=> 'megamenu',
						'required' 	=> true
				),
				array(
						'name' 		=> 'WP User Avatar',
						'slug' 		=> 'wp-user-avatar',
						'required' 	=> true
				),
				array(
						'name' 		=> 'W3 Total Cache',
						'slug' 		=> 'w3-total-cache',
						'required' 	=> false
				),
				array(
						'name' 		=> 'PE Easy Slider',
						'slug' 		=> 'pe-easy-slider',
						'required' 	=> false
				),
				array(
						'name' 		=> 'PE Recent Posts',
						'slug' 		=> 'pe-recent-posts',
						'required' 	=> false
				)
		);

		// Change this to your theme text domain, used for internationalising strings
		$theme_text_domain = 'PixelEmu';

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
				'domain'		=> $theme_text_domain, // Text domain - likely want to be the same as your theme.
				'default_path'		=> '', // Default absolute path to pre-packaged plugins
				//'parent_menu_slug'	=> 'themes.php', // Default parent menu slug
				//'parent_url_slug'	=> 'themes.php', // Default parent URL slug
				'menu'			=> 'install-required-plugins', // Menu slug
				'has_notices'		=> true, // Show admin notices or not
				'is_automatic'		=> false, // Automatically activate plugins after installation or not
				'message'		=> '', // Message to output right before the plugins table
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'PixelEmu' ),
			'menu_title'                      => __( 'Install Plugins', 'PixelEmu' ),
			'installing'                      => __( 'Installing Plugin: %s', 'PixelEmu' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'PixelEmu' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'PixelEmu'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'PixelEmu'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'PixelEmu'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'PixelEmu'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'PixelEmu' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'PixelEmu' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'PixelEmu' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'PixelEmu' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'PixelEmu' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'PixelEmu' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'PixelEmu' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
		);
		tgmpa( $plugins, $config );
}
?>
