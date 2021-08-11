<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
---------------------------------------------------------------*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/*-----------------------------------------------------------------------------------*/
/*	Redux
/*-----------------------------------------------------------------------------------*/

if ( ! class_exists( 'PEredux' ) ) {

	class PEredux {

		function __construct() {
			add_action( 'after_setup_theme', array( $this, 'checkRedux' ), 2 );
			add_action( 'after_setup_theme', array( $this, 'clearCache' ), 5 );

			//check if redux exists
			if ( class_exists( 'Redux' ) ) {
				add_action( 'init', array( $this, 'removeDemoModeLink' ) );
				add_action( 'after_setup_theme', array( $this, 'prepareOptions' ), 5 );
			}

		}

		/**
		 * Check Redux framework plugin
		 */
		public function checkRedux() {
			if ( ! $this->is_plugin_exist( 'redux-framework/redux-framework.php' ) && ! class_exists( 'ReduxFramework' ) ) {
				$this->redux_not_installed();
			} elseif ( $this->is_plugin_exist( 'redux-framework/redux-framework.php' ) && ! class_exists( 'ReduxFramework' ) ) {
				$this->redux_not_active();
			}
		}

		/**
		 * Show notice if plugin not installed
		 */
		private function redux_not_installed() {
			if ( ! isset ( $_GET['page'] ) || ( isset ( $_GET['page'] ) && $_GET['page'] != 'install-required-plugins' ) ) {
				add_action( 'admin_notices', array( $this, 'redux_notice_not_exists' ) );
			}
		}

		/**
		 * Show notice if plugin not active
		 */
		private function redux_not_active() {
			if ( ! isset ( $_GET['page'] ) || ( isset ( $_GET['page'] ) && $_GET['page'] != 'install-required-plugins' ) ) {
				add_action( 'admin_notices', array( $this, 'redux_notice_inactive' ) );
			}
		}

		/**
		 * Show cache notice
		 */
		private function show_cache_notice() {
			add_action( 'admin_notices', array( $this, 'cache_notice' ) );
		}

		/**
		 * Check WordPress Network
		 * @return string
		 */
		private function is_network() {
			$network = '';
			if ( is_multisite() ) {
				$network = 'network/';
			}

			return $network;
		}

		/**
		 * Plugin not exist message
		 */
		public function redux_notice_not_exists() {
			echo '<div class="notice notice-error is-dismissible"><p><strong>';
			echo esc_html__( 'Redux Framework installation required.', 'pe-terraclassic' );
			echo '</strong></p><p>';
			echo sprintf( "<a href='%s' class='button-primary'>%s</a>", admin_url( $this->is_network() . 'plugin-install.php?tab=search&type=term&s=redux+framework' ), esc_html__( 'Click here to search for the plugin', 'pe-terraclassic' ) );
			echo '</p></div>';
		}

		/**
		 * Plugin not active message
		 */
		public function redux_notice_inactive() {
			echo '<div class="notice notice-error is-dismissible"><p><strong>';
			echo esc_html__( 'Redux Framework required activation.', 'pe-terraclassic' );
			echo '</strong></p><p>';
			echo sprintf( "<a href='%s' class='button-primary'>%s</a>", admin_url( $this->is_network() . 'plugins.php' ), esc_html__( 'Click here to go to the plugins page and activate it', 'pe-terraclassic' ) );
			echo '</p></div>';
		}

		/**
		 * Cache cleaned message
		 */
		public function cache_notice() {
			$class   = 'notice notice-success is-dismissible';
			$message = '<p>' . esc_html__( 'Cache cleaned !', 'pe-terraclassic' ) . '</p>';
			printf( '<div class="%1$s">%2$s</div>', $class, $message );
		}

		/**
		 * Check if plugin exist
		 *
		 * @param  string $plug plugin file name
		 *
		 * @return boolean
		 */
		public function is_plugin_exist( $plug ) {
			$all_plugins = get_plugins();

			if ( isset( $all_plugins[ $plug ] ) ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Remove Redux demo
		 */
		function removeDemoModeLink() {
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array(
					ReduxFrameworkPlugin::get_instance(),
					'plugin_metalinks'
				), null, 2 );
			}
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
			}
		}

		/**
		 * Clear cache and show notice
		 */
		public function clearCache() {

			if ( isset( PEsettings::$redux['clear-cache'] ) && PEsettings::$redux['clear-cache'] == true ) { //if true clear cache

				PEutils::clearCache();

				//update redux option
				$data                = get_option( PEsettings::$default['settings_name'] );
				$data['clear-cache'] = false;
				update_option( PEsettings::$default['settings_name'], $data );

				//show notice
				$this->show_cache_notice();

			}

		}

		/**
		 * Check cache dir size
		 *
		 * @param  string $directory with path
		 *
		 * @return string with directory size
		 */
		public function dirSize( $directory ) {

			if ( is_writable( $directory ) ) {
				$size = 0;
				foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $directory ) ) as $file ) {
					if ( $file->getFileName() != '..' ) {
						$size += $file->getSize();
					}
				}

				return round( ( $size / 1024 ) / 1024, 2 ) . ' MB';
			} else {
				return esc_html__( 'No directory or wrong permissions', 'pe-terraclassic' );
			}

		}

		/**
		 * Theme Settings
		 */
		public function prepareOptions() {

			$allowed_html_array = array(
				'i'      => array(),
				'br'     => array(),
				'strong' => array(),
			);

			$opt_name = PEsettings::$default['settings_name'];

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$args = array(
				'opt_name'              => $opt_name,
				'display_name'          => $theme->get( 'Name' ),
				'display_version'       => $theme->get( 'Version' ),
				'menu_type'             => 'menu',
				'allow_sub_menu'        => true,
				'menu_title'            => esc_html__( 'Theme Options', 'pe-terraclassic' ),
				'page_title'            => esc_html__( 'Theme Options', 'pe-terraclassic' ),
				'update_notice'         => true,
				'admin_bar'             => true,
				'page_slug'             => 'pixelemu_options',
				'menu_icon'             => get_template_directory_uri() . '/images/admin/pe_icon.png',
				'page_parent_post_type' => 'your_post_type',
				'page_priority'         => '25',
				'customizer'            => false,
				'default_mark'          => '',
				'class'                 => 'pixelemu-options',
				'output'                => true,
				'output_tag'            => true,
				'settings_api'          => true,
				'cdn_check_time'        => '1440',
				'compiler'              => true,
				'page_permissions'      => 'manage_options',
				'save_defaults'         => true,
				'show_import_export'    => true,
				'database'              => '',
				'transient_time'        => '3600',
				'network_sites'         => true,
				'dev_mode'              => false,
				'hints'                 => array(
					'icon_position' => 'left',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color' => 'light',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show' => array(
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'duration' => '500',
							'event'    => 'mouseleave unfocus',
						),
					),
				),
			);

			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
			$args['share_icons'][] = array(
				'url'   => 'http://www.facebook.com/PixelEmu',
				'title' => 'Like us on Facebook',
				'icon'  => 'el el-facebook'
			);
			$args['share_icons'][] = array(
				'url'   => 'https://twitter.com/PixelEmu',
				'title' => 'Follow us on Twitter',
				'icon'  => 'el el-twitter'
			);
			$args['share_icons'][] = array(
				'url'   => 'https://plus.google.com/u/0/+Pixelemu/posts',
				'title' => 'Find us on Google Plus',
				'icon'  => 'el el-icon-googleplus'
			);
			$args['share_icons'][] = array(
				'url'   => 'https://www.youtube.com/channel/UC8gwlTKMLRG21SUo0YvgJIA',
				'title' => 'Find us on Youtube',
				'icon'  => 'el el-icon-youtube'
			);
			$args['share_icons'][] = array(
				'url'   => 'https://www.behance.net/PixelEmu',
				'title' => 'Find us on Behance',
				'icon'  => 'el el-icon-behance'
			);

			Redux::setArgs( $opt_name, $args );

			/*
			 * ---> END ARGUMENTS
			 */

			/*
			 *
			 * ---> START SECTIONS
			 *
			 */

			// -----------------------------------------------------------------------------
			// BASIC SETTINGS
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Basic Settings', 'pe-terraclassic' ),
				'id'     => 'basic-settings',
				'icon'   => 'el el-cogs',
				'fields' => array(
					array(
						'id'       => 'logo',
						'type'     => 'media',
						'operator' => 'and',
						'title'    => esc_html__( 'Logo', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Upload a logo image here.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['logo']['url'],
					),
					array(
						'id'       => 'favicon',
						'type'     => 'media',
						'operator' => 'and',
						'title'    => esc_html__( 'Favicon', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Upload a favicon file here. Please note the WordPress "Site Icon" feature in the Customizer takes priority over this setting.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['favicon']['url'],
					),
					array(
						'id'       => 'back-to-top',
						'type'     => 'switch',
						'title'    => esc_html__( 'Back to top', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable back to top button.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['back-to-top'],
					),
					array(
						'id'       => 'sticky-topbar',
						'type'     => 'switch',
						'title'    => esc_html__( 'Sticky logo and primary menu', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable sticky logo and primary menu.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['sticky-topbar'],
					),
					array(
						'id'       => 'search-bar',
						'type'     => 'switch',
						'title'    => esc_html__('Search form in topbar', 'pe-terraclassic'),
						'subtitle' => esc_html__('Enable / disable search form in topbar section.', 'pe-terraclassic'),
						'default'  => PEsettings::$default['search-bar'],
					),
					array(
						'id'       => 'off-canavs-sidebar',
						'type'     => 'switch',
						'title'    => esc_html__( 'Off-canvas sidebar for desktop', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable the off-canvas sidebar.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['off-canavs-sidebar'],
					),
					array(
						'id'       => 'off-canavs-width',
						'type'     => 'dimensions',
						'height'   => false,
						'units'    => array( 'px' ),
						'title'    => esc_html__( 'Off-canvas width', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the off-canvas sidebar width.', 'pe-terraclassic' ),
						'default'  => array(
							'width' => PEsettings::$default['off-canavs-width']['width'],
						),
					),
					array(
						'id'       => 'off-canavs-position',
						'type'     => 'select',
						'title'    => esc_html__( 'Off-Canvas position', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the position of off-canvas sidebar.', 'pe-terraclassic' ),
						'options'  => array(
							'right' => esc_html__( 'Right', 'pe-terraclassic' ),
							'left'  => esc_html__( 'Left', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['off-canavs-position'],
					),
					array(
						'id'       => 'coming-soon',
						'type'     => 'switch',
						'title'    => esc_html__( 'Coming soon', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable comming soon page.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['coming-soon'],
					),
					array(
						'id'          => 'coming-soon-until-date',
						'type'        => 'date',
						'title'       => esc_html__( 'Coming soon until date', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Coming soon date.', 'pe-terraclassic' ),
						'placeholder' => esc_html__( 'Click to enter a date', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['coming-soon-until-date'],
						'required'    => array( 'coming-soon', '=', true ),
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// LAYOUT
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Layout', 'pe-terraclassic' ),
				'id'     => 'layout',
				'icon'   => 'el el-screen',
				'fields' => array(
					array(
						'id'       => 'theme-width',
						'type'     => 'dimensions',
						'title'    => esc_html__( 'Page width', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enter page width.', 'pe-terraclassic' ),
						'units'    => array( 'px', '%' ),
						'height'   => false,
						'default'  => array(
							'width' => PEsettings::$default['theme-width']['width'],
						),
					),
					array(
						'id'       => 'left-column-width',
						'type'     => 'select',
						'title'    => esc_html__( 'Left column width', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Left column width in percents.', 'pe-terraclassic' ),
						'options'  => array(
							'1'  => '8%',
							'2'  => '17%',
							'3'  => '25%',
							'4'  => '33%',
							'5'  => '42%',
							'6'  => '50%',
							'7'  => '58%',
							'8'  => '67%',
							'9'  => '75%',
							'10' => '83%',
						),
						'default'  => PEsettings::$default['left-column-width'],
					),
					array(
						'id'       => 'right-column-width',
						'type'     => 'select',
						'title'    => esc_html__( 'Right column width', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Right column width in percents.', 'pe-terraclassic' ),
						'options'  => array(
							'1'  => '8%',
							'2'  => '17%',
							'3'  => '25%',
							'4'  => '33%',
							'5'  => '42%',
							'6'  => '50%',
							'7'  => '58%',
							'8'  => '67%',
							'9'  => '75%',
							'10' => '83%',
						),
						'default'  => PEsettings::$default['right-column-width'],
					),
					array(
						'id'       => 'frontpage-layout',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Frontpage layout', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Layout for frontpage - number of columns and arrangement of them.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => array(
								'alt' => esc_html__( '2 Column Left', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/2cl.png',
							),
							'2' => array(
								'alt' => esc_html__( '2 Column Right', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/2cr.png',
							),
							'3' => array(
								'alt' => esc_html__( '1 Column', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/1col.png',
							),
							'4' => array(
								'alt' => esc_html__( '3 Column Middle', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/3cm.png',
							),
							'5' => array(
								'alt' => esc_html__( '3 Column Left', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/3cl.png',
							),
							'6' => array(
								'alt' => esc_html__( '3 Column Right', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/3cr.png',
							)
						),
						'default'  => PEsettings::$default['frontpage-layout'],
					),
					array(
						'id'       => 'subpage-layout',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Other pages layout', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Layout for subpage - number of columns and arrangement of them.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => array(
								'alt' => esc_html__( '2 Column Left', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/2cl.png',
							),
							'2' => array(
								'alt' => esc_html__( '2 Column Right', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/2cr.png',
							),
							'3' => array(
								'alt' => esc_html__( '1 Column', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/1col.png',
							),
							'4' => array(
								'alt' => esc_html__( '3 Column Middle', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/3cm.png',
							),
							'5' => array(
								'alt' => esc_html__( '3 Column Left', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/3cl.png',
							),
							'6' => array(
								'alt' => esc_html__( '3 Column Right', 'pe-terraclassic' ),
								'img' => ReduxFramework::$_url . 'assets/img/3cr.png',
							)
						),
						'default'  => PEsettings::$default['subpage-layout'],
					),
					array(
						'id'       => 'full-screen',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Full screen (100% width)', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Use full screen width instead container width for selected sections.', 'pe-terraclassic' ),
						'options'  => array(
							'bar'        => esc_html__( 'Logo Nav', 'pe-terraclassic' ),
							'header'     => esc_html__( 'Header', 'pe-terraclassic' ),
							'top1'       => esc_html__( 'Top 1', 'pe-terraclassic' ),
							'top2'       => esc_html__( 'Top 2', 'pe-terraclassic' ),
							'top3'       => esc_html__( 'Top 3', 'pe-terraclassic' ),
							'main'       => esc_html__( 'Main', 'pe-terraclassic' ),
							'bottom1'    => esc_html__( 'Bottom 1', 'pe-terraclassic' ),
							'bottom2'    => esc_html__( 'Bottom 2', 'pe-terraclassic' ),
							'footer'     => esc_html__( 'Footer', 'pe-terraclassic' ),
							'copyrights' => esc_html__( 'Copyrights', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['full-screen'],
					),
					
					array(
					    'id'   => 'sections-hide',
						'type'     => 'info',
						'style'    => 'info',
					    'desc' => __('Hide any website section on selected devices. Select a particular device to hide a section on it.<br />
					    Resolutions range: Mobile ( < 768px ), Tablet ( ≥ 768px ), Desktop ( ≥ 992px ), Large ( ≥ 1200px )', 'pe-terraclassic')
					),
					array(
						'id'       => 'logo-nav-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Logo Nav', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'header-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Header', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'top1-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Top 1', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'top2-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Top 2', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'top3-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Top 3', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'main-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Content area', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'It\'s the main content area for displaying e.g. posts, pages.', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'bottom1-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Bottom 1', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'bottom2-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Bottom 2', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'footer-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Footer', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'copyrights-hide',
						'type'     => 'checkbox',
						'title'    => esc_html__( 'Copyrights', 'pe-terraclassic' ),
						'class' => 'pe-hide-section',
						'options'  => array(
							'mobile'        => esc_html__( 'Mobile', 'pe-terraclassic' ),
							'tablet'     => esc_html__( 'Tablet', 'pe-terraclassic' ),
							'desktop'       => esc_html__( 'Desktop', 'pe-terraclassic' ),
							'large'       => esc_html__( 'Large', 'pe-terraclassic' ),
						),
					),
					array(
						'id'       => 'front-page-content',
						'type'     => 'switch',
						'title'    => esc_html__( 'Front page content', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable content section (Static page type only).', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['front-page-content'],
					),
					array(
						'id'       => 'front-page-title',
						'type'     => 'switch',
						'title'    => esc_html__( 'Front page title', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable page title (Static page type only).', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['front-page-title'],
						'required' => array( 'front-page-content', '=', true ),
					),
					array(
						'id'    => 'layout-doc',
						'type'  => 'info',
						'style' => 'info',
						'title' => esc_html__( 'Documentation:', 'pe-terraclassic' ),
						'desc'  => sprintf( '<a href="' . esc_url( 'https://www.pixelemu.com/documentation/wordpress-themes/pe-terraclassic/#pe-other-all-widget-positions' ) . '" target="_blank">%s</a><br>', esc_html__( 'All available widget positions', 'pe-terraclassic' ) )
								   .sprintf( '<a href="' . esc_url('https://www.pixelemu.com/documentation/wordpress-themes/first-steps#pe-theme-elements') . '" target="_blank">%s</a><br>', esc_html__('Get info about sidebars and widgets types', 'pe-terraclassic' ) )
								   . sprintf( '<a href="' . esc_url( 'https://www.pixelemu.com/documentation/wordpress-themes/pe-terraclassic/#pe-other-classes-for-widgets' ) . '" target="_blank">%s</a>', esc_html__( 'All available classes', 'pe-terraclassic' ) ),
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// Main Menu
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Main Menu', 'pe-terraclassic' ),
				'id'     => 'main-menu',
				'icon'   => 'el el-th-list',
				'fields' => array(
					array(
						'id'       => 'main-menu-switch',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Menu type', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Select main menu type.', 'pe-terraclassic' ),
						'options'  => array(
							'standard'  => esc_html__( 'Standard', 'pe-terraclassic' ),
							'offcanvas' => esc_html__( 'Offcanvas', 'pe-terraclassic' ),
							'both'      => esc_html__( 'Both', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['main-menu-switch'],
					),
					array(
						'id'       => 'responsive-breakpoint',
						'type'     => 'dimensions',
						'height'   => false,
						'units'    => 'px',
						'title'    => esc_html__( 'Responsive breakpoint', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Set the width at which the menu turns into a mobile menu.', 'pe-terraclassic' ),
						'default'  => array(
							'width' => PEsettings::$default['responsive-breakpoint']['width'],
						),
						//'required' => array( 'main-menu-switch', '=', true ),
					),
					array(
						'id'             => 'topmenu-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'First level items', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for post titles.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['topmenu-font']['color'],
							'font-weight'    => PEsettings::$default['topmenu-font']['font-weight'],
							'text-transform' => PEsettings::$default['topmenu-font']['text-transform'],
							'font-family'    => PEsettings::$default['topmenu-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['topmenu-font']['font-size'],
							'letter-spacing' => '', //PEsettings::$default['topmenu-font']['letter-spacing']
							'font-style'     => '', //PEsettings::$default['topmenu-font']['font-style']
						),
					),
					array(
						'id'             => 'topmenu-submenu-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Submenu items', 'pe-terraclassic' ),
						'google'         => false,
						'color'          => false,
						'font-size'      => true,
						'font-family'    => false,
						'font-backup'    => false,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => false,
						'font-weight'    => true,
						'letter-spacing' => false,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Font for submenu.', 'pe-terraclassic' ),
						'default'        => array(
							'font-weight'    => PEsettings::$default['topmenu-submenu-font']['font-weight'],
							'font-size'      => PEsettings::$default['topmenu-submenu-font']['font-size'],
							'text-transform' => PEsettings::$default['topmenu-submenu-font']['text-transform'],
						),
					),
					array(
						'id'          => 'topmenuSubmenuFontColor',
						'type'        => 'color',
						'title'       => esc_html__( 'Submenu text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Text for submenu.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['topmenuSubmenuFontColor'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'topmenuSubmenuBackground',
						'type'        => 'color',
						'title'       => esc_html__( 'Submenu background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Background for submenu.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['topmenuSubmenuBackground'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'topmenuBorderColor',
						'type'        => 'color',
						'title'       => esc_html__( 'Hover/Active color', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Color for boder.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['topmenuBorderColor'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'       => 'vertical-main-menu',
						'type'     => 'switch',
						'title'    => esc_html__( 'Additional vertical main menu (only for frontpage)', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable additional vertical main menu in header section.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['vertical-main-menu'],
					),
					array(
						'id'       => 'vertical-main-menu-homepage',
						'type'     => 'switch',
						'title'    => esc_html__( 'Additional vertical main menu (only for homepage)', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable additional vertical main menu in header section.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['vertical-main-menu-homepage'],
					),
					array(
						'id'       => 'vertical-main-menu-absolute',
						'type'     => 'switch',
						'title'    => esc_html__( 'Additional vertical main menu in absolute position', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose if you want to display additional vertical main menu in absolute position (helpful if you want display menu over slider widget). This option is working only if you have at least one widget in sidebar "Header".', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['vertical-main-menu-absolute'],
					),
					array(
						'id'             => 'vertical-topmenu-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Additional vertical main menu - first level items', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for first level items.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['vertical-topmenu-font']['color'],
							'font-weight'    => PEsettings::$default['vertical-topmenu-font']['font-weight'],
							'text-transform' => PEsettings::$default['vertical-topmenu-font']['text-transform'],
							'font-family'    => PEsettings::$default['vertical-topmenu-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['vertical-topmenu-font']['font-size'],
							'letter-spacing' => '',
							'font-style'     => '',
						),
						//'required' => array( 'vertical-main-menu', '=', true ),
					),
					array(
						'id'             => 'vertical-topmenu-submenu-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Additional vertical main menu - submenu items', 'pe-terraclassic' ),
						'google'         => false,
						'color'          => false,
						'font-size'      => true,
						'font-family'    => false,
						'font-backup'    => false,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => false,
						'font-weight'    => true,
						'letter-spacing' => false,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Font for submenu.', 'pe-terraclassic' ),
						'default'        => array(
							'font-weight'    => PEsettings::$default['vertical-topmenu-submenu-font']['font-weight'],
							'font-size'      => PEsettings::$default['vertical-topmenu-submenu-font']['font-size'],
							'text-transform' => PEsettings::$default['vertical-topmenu-submenu-font']['text-transform'],
						),
						//'required' => array( 'vertical-main-menu', '=', true ),
					),
					array(
						'id'          => 'vertical-topmenuSubmenuFontColor',
						'type'        => 'color',
						'title'       => esc_html__( 'Additional vertical main menu - submenu text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Text for submenu.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['vertical-topmenuSubmenuFontColor'],
						'validate'    => 'color',
						'transparent' => false,
						//'required' => array( 'vertical-main-menu', '=', true ),
					),
					array(
						'id'          => 'vertical-topmenuSubmenuBackground',
						'type'        => 'color',
						'title'       => esc_html__( 'Additional vertical main menu - submenu background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Background for submenu.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['vertical-topmenuSubmenuBackground'],
						'validate'    => 'color',
						'transparent' => false,
						//'required' => array( 'vertical-main-menu', '=', true ),
					),
					array(
						'id'          => 'vertical-topmenuSubmenuBackground',
						'type'     => 'color_rgba',
						'title'       => esc_html__( 'Additional vertical main menu - submenu background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Background for submenu.', 'pe-terraclassic' ),
						'default'  => array(
							'color' => PEsettings::$default['vertical-topmenuSubmenuBackground']['color'],
							'alpha' => PEsettings::$default['vertical-topmenuSubmenuBackground']['alpha'],
							'rgba'  => PEsettings::$default['vertical-topmenuSubmenuBackground']['rgba'],
						),
						//'required' => array( 'vertical-main-menu', '=', true ),
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// BLOG
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title' => esc_html__( 'Blog', 'pe-terraclassic' ),
				'id'    => 'blog',
				'icon'  => 'el el-pencil',
			) );

			//GENERAL
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'General', 'pe-terraclassic' ),
				'id'         => 'general-blog',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'blog-style',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Blog style', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Select blog style.', 'pe-terraclassic' ),
						'options'  => array(
							'standard' => esc_html__( 'Standard', 'pe-terraclassic' ),
							'effect'   => esc_html__( 'Intro Effect', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['blog-style'],
					),
					array(
						'id'       => 'blogEffectBackground',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Blog effect background and opacity', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the background color and opacity for blog post with intro effect.', 'pe-terraclassic' ),
						'default'  => array(
							'color' => PEsettings::$default['blogEffectBackground']['color'],
							'alpha' => PEsettings::$default['blogEffectBackground']['alpha'],
							'rgba'  => PEsettings::$default['blogEffectBackground']['rgba'],
						),
						'required' => array( 'blog-style', '=', 'effect' ),
					),
					array(
						'id'          => 'blogEffectText',
						'type'        => 'color',
						'title'       => esc_html__( 'Blog effect text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose blog effect text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['blogEffectText'],
						'validate'    => 'color',
						'transparent' => false,
						'required'    => array( 'blog-style', '=', 'effect' ),
					),
					array(
						'id'       => 'blog-columns',
						'type'     => 'select',
						'title'    => esc_html__( 'Columns number', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the number of columns for blog view.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( '1 column (1 post in a row)', 'pe-terraclassic' ),
							'2' => esc_html__( '2 columns (2 posts in a row)', 'pe-terraclassic' ),
							'3' => esc_html__( '3 columns (3 posts in a row)', 'pe-terraclassic' ),
							'4' => esc_html__( '4 columns (4 posts in a row)', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['blog-columns'],
					),
					array(
						'id'       => 'blog-1column-image-width',
						'type'     => 'dimensions',
						'title'    => esc_html__( 'Max width for image ( 1 column view only )', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enter max width for post image.', 'pe-terraclassic' ),
						'units'    => array( '%' ),
						'height'   => false,
						'default'  => array(
							'width' => PEsettings::$default['blog-1column-image-width']['width'],
						),
						'required' => array( 'blog-columns', '=', '1' ),
					),
					array(
						'id'       => 'blog-breadcrumb',
						'type'     => 'switch',
						'title'    => esc_html__( 'Breadcrumbs', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable breadcrumb navigation.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['blog-breadcrumb'],
					),
					array(
						'id'       => 'blog-details',
						'type'     => 'switch',
						'title'    => esc_html__( 'Post meta', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable post details (blog category, created date).', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['blog-details'],
					),
					array(
						'id'       => 'blog-thumbnails',
						'type'     => 'switch',
						'title'    => esc_html__( 'Post thumbnail', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable post thumbnail.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['blog-thumbnails'],
					),
					array(
						'id'       => 'blog-thumbnails-link',
						'type'     => 'switch',
						'title'    => esc_html__( 'Post thumbnail link', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable link for post thumbnail.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['blog-thumbnails-link'],
						'required'      => array( 'blog-thumbnails', '=', true ),
					),
					array(
						'id'       => 'blog-readmore',
						'type'     => 'switch',
						'title'    => esc_html__( 'Readmore', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable readmore button.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['blog-readmore'],
					),
					array(
						'id'       => 'blog-excerpt',
						'type'     => 'switch',
						'title'    => esc_html__( 'Entry auto excerpt', 'pe-terraclassic' ),
						'subtitle' => wp_kses( __( 'Enable / disable entry auto excerpt (if <i>more</i> tag is not used).', 'pe-terraclassic' ), $allowed_html_array ),
						'default'  => PEsettings::$default['blog-excerpt'],
					),
					array(
						'id'            => 'blog-excerpt-length',
						'type'          => 'slider',
						'title'         => esc_html__( 'Entry excerpt length', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'The number of words to show for the blog entry excerpts.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['blog-excerpt-length'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '500',
						'display_value' => 'text',
						'required'      => array( 'blog-excerpt', '=', true ),
					),
				)
			) );

			//ARCHIVE
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Archive', 'pe-terraclassic' ),
				'id'         => 'archive',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'archive-style',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Archive style', 'pe-terraclassic' ),
						'subtitle' => wp_kses( __( 'Select archive style.<br>You may override those setting in category.', 'pe-terraclassic' ), $allowed_html_array ),
						'options'  => array(
							'standard' => esc_html__( 'Standard', 'pe-terraclassic' ),
							'effect'   => esc_html__( 'Intro Effect', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['archive-style'],
					),
					array(
						'id'       => 'archiveEffectBackground',
						'type'     => 'color_rgba',
						'title'    => esc_html__( 'Archive effect background and opacity', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the background color and opacity for archive post with intro effect.', 'pe-terraclassic' ),
						'default'  => array(
							'color' => PEsettings::$default['archiveEffectBackground']['color'],
							'alpha' => PEsettings::$default['archiveEffectBackground']['alpha'],
							'rgba'  => PEsettings::$default['archiveEffectBackground']['rgba'],
						),
						'required' => array( 'archive-style', '=', 'effect' ),
					),
					array(
						'id'          => 'archiveEffectText',
						'type'        => 'color',
						'title'       => esc_html__( 'Blog effect text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the archive effect text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['archiveEffectText'],
						'validate'    => 'color',
						'transparent' => false,
						'required' => array( 'archive-style', '=', 'effect' ),
					),
					array(
						'id'       => 'archive-columns',
						'type'     => 'select',
						'title'    => esc_html__( 'Columns number', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the number of columns for archive view (can be overridden in category settings).', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( '1 column (1 post in a row)', 'pe-terraclassic' ),
							'2' => esc_html__( '2 columns (2 posts in a row)', 'pe-terraclassic' ),
							'3' => esc_html__( '3 columns (3 posts in a row)', 'pe-terraclassic' ),
							'4' => esc_html__( '4 columns (4 posts in a row)', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['archive-columns'],
					),
					array(
						'id'       => 'archive-1column-image-width',
						'type'     => 'dimensions',
						'title'    => esc_html__( 'Max width for image ( 1 column view only )', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enter max width for post image.', 'pe-terraclassic' ),
						'units'    => array( '%' ),
						'height'   => false,
						'default'  => array(
							'width' => PEsettings::$default['archive-1column-image-width']['width'],
						),
						'required' => array( 'archive-columns', '=', '1' ),
					),
					array(
						'id'       => 'archive-header',
						'type'     => 'switch',
						'title'    => esc_html__( 'Page Header', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable page header (category title).', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['archive-header'],
					),
					array(
						'id'       => 'archive-breadcrumb',
						'type'     => 'switch',
						'title'    => esc_html__( 'Breadcrumbs', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable breadcrumb navigation.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['archive-breadcrumb'],
					),
					array(
						'id'       => 'archive-details',
						'type'     => 'switch',
						'title'    => esc_html__( 'Post meta', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable post details (category, created date).', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['archive-details'],
					),
					array(
						'id'       => 'archive-thumbnails',
						'type'     => 'switch',
						'title'    => esc_html__( 'Post thumbnail', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable post thumbnail.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['archive-thumbnails'],
					),
					array(
						'id'       => 'archive-thumbnails-link',
						'type'     => 'switch',
						'title'    => esc_html__( 'Post thumbnail link', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable link for post thumbnail.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['archive-thumbnails-link'],
						'required'      => array( 'archive-thumbnails', '=', true ),
					),
					array(
						'id'       => 'archive-readmore',
						'type'     => 'switch',
						'title'    => esc_html__( 'Readmore', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable readmore button.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['archive-readmore'],
					),
					array(
						'id'       => 'archive-excerpt',
						'type'     => 'switch',
						'title'    => esc_html__( 'Entry auto excerpt', 'pe-terraclassic' ),
						'subtitle' => wp_kses( __( 'Enable / disable entry auto excerpt (if <i>more</i> tag is not used).', 'pe-terraclassic' ), $allowed_html_array ),
						'default'  => PEsettings::$default['archive-excerpt'],
					),
					array(
						'id'            => 'archive-excerpt-length',
						'type'          => 'slider',
						'title'         => esc_html__( 'Entry excerpt length', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'The number of words to show for the archive entry excerpts.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['archive-excerpt-length'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '500',
						'display_value' => 'text',
						'required'      => array( 'archive-excerpt', '=', true ),
					),
				)
			) );

			//SINGLE POST
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Single post', 'pe-terraclassic' ),
				'id'         => 'single-post',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'post-tags',
						'type'     => 'switch',
						'title'    => esc_html__( 'Tags', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable tags.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['post-tags'],
					),
					array(
						'id'       => 'post-author-info',
						'type'     => 'switch',
						'title'    => esc_html__( 'Author info', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable author info (ex: avatar, bio, website) under content.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['post-author-info'],
					),
					array(
						'id'       => 'post-comments',
						'type'     => 'switch',
						'title'    => esc_html__( 'Comments', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable comments.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['post-comments'],
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// PAGES
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title' => esc_html__( 'Pages', 'pe-terraclassic' ),
				'id'    => 'pages',
				'icon'  => 'el el-tasks',
			) );

			//SINGLE PAGE
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Single page', 'pe-terraclassic' ),
				'id'         => 'single-page',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'page-breadcrumb',
						'type'     => 'switch',
						'title'    => esc_html__( 'Breadcrumbs', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable breadcrumb navigation.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['page-breadcrumb'],
					),
					array(
						'id'       => 'page-comments',
						'type'     => 'switch',
						'title'    => esc_html__( 'Comments', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable comments.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['page-comments'],
					),
				)
			) );

			//MEMBERS
			/*Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Members', 'pe-terraclassic' ),
				'id'         => 'member',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'       => 'member-thumbnail-size',
						'type'     => 'select',
						'title'    => esc_html__( 'Avatar size', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Please choose member image size.', 'pe-terraclassic' ),
						'options'  => array(
							'thumbnail' => esc_html__( 'Thumbnail', 'pe-terraclassic' ),
							'medium'    => esc_html__( 'Medium', 'pe-terraclassic' ),
							'large'     => esc_html__( 'Large', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['member-thumbnail-size'],
					),
					array(
						'id'       => 'member-opening-hours',
						'type'     => 'switch',
						'title'    => esc_html__( 'Working hours', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable working hours.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['member-opening-hours'],
					),
					array(
						'id'       => 'member-opening-hours-label',
						'type'     => 'text',
						'title'    => esc_html__( 'Hours label', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Chose label name for hours section.', 'pe-terraclassic' ),
						'validate' => 'no_special_chars',
						'default'  => PEsettings::$default['member-opening-hours-label'],
					),
					array(
						'id'       => 'member-contact-info',
						'type'     => 'switch',
						'title'    => esc_html__( 'Contact info', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable contact info.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['member-contact-info'],
					),
					array(
						'id'       => 'member-social-links',
						'type'     => 'switch',
						'title'    => esc_html__( 'Social links', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable social links.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['member-social-links'],
					),
				)
			) );*/

			// -----------------------------------------------------------------------------
			// FONTS
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Fonts', 'pe-terraclassic' ),
				'id'     => 'fonts',
				'icon'   => 'el el-font',
			) );
				
			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'General', 'pe-terraclassic' ),
				'id'     => 'fonts-general',
				'subsection' => true,
				'fields' => array(
					array(
						'id'             => 'body-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Body', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for BODY.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['body-font']['color'],
							'font-weight'    => PEsettings::$default['body-font']['font-weight'],
							'text-transform' => PEsettings::$default['body-font']['text-transform'],
							'font-family'    => PEsettings::$default['body-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['body-font']['font-size'],
							'letter-spacing' => '', //PEsettings::$default['body-font']['letter-spacing']
							'font-style'     => '', //PEsettings::$default['body-font']['font-style']
						),
					),
					array(
						'id'             => 'widgets-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Widgets titles', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for widget titles.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['widgets-font']['color'],
							'font-weight'    => PEsettings::$default['widgets-font']['font-weight'],
							'text-transform' => PEsettings::$default['widgets-font']['text-transform'],
							'font-family'    => PEsettings::$default['widgets-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['widgets-font']['font-size'],
							'letter-spacing' => '', //PEsettings::$default['widgets-font']['letter-spacing']
							'font-style'     => '', //PEsettings::$default['widgets-font']['font-style']
						),
					),
				)
			) );
			
			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Classifieds', 'pe-terraclassic' ),
				'id'     => 'fonts-classifieds',
				'subsection' => true,
				'fields' => array(
					array(
						'id'             => 'tcf-category-title-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Category Title', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for classifieds categories titles.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['tcf-category-title-font']['color'],
							'font-weight'    => PEsettings::$default['tcf-category-title-font']['font-weight'],
							'text-transform' => PEsettings::$default['tcf-category-title-font']['text-transform'],
							'font-family'    => PEsettings::$default['tcf-category-title-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['tcf-category-title-font']['font-size'],
							'letter-spacing' => '', //PEsettings::$default['posts-font']['letter-spacing']
							'font-style'     => '', //PEsettings::$default['posts-font']['font-style']
						),
					),
					array(
						'id'             => 'tcf-single-title-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Classified Title', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for classifieds titles.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['tcf-single-title-font']['color'],
							'font-weight'    => PEsettings::$default['tcf-single-title-font']['font-weight'],
							'text-transform' => PEsettings::$default['tcf-single-title-font']['text-transform'],
							'font-family'    => PEsettings::$default['tcf-single-title-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['tcf-single-title-font']['font-size'],
							'letter-spacing' => '', //PEsettings::$default['posts-font']['letter-spacing']
							'font-style'     => '', //PEsettings::$default['posts-font']['font-style']
						),
					),
				)
			) );
			
			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Posts & Pages', 'pe-terraclassic' ),
				'id'     => 'fonts-posts-pages',
				'subsection' => true,
				'fields' => array(
					array(
						'id'             => 'posts-font',
						'type'           => 'typography',
						'title'          => esc_html__( 'Posts & Pages titles', 'pe-terraclassic' ),
						'google'         => true,
						'font-backup'    => true,
						'text-transform' => true,
						'line-height'    => false,
						'font-style'     => true,
						'letter-spacing' => true,
						'text-align'     => false,
						'units'          => 'px',
						'subtitle'       => esc_html__( 'Typography for post titles.', 'pe-terraclassic' ),
						'default'        => array(
							'color'          => PEsettings::$default['posts-font']['color'],
							'font-weight'    => PEsettings::$default['posts-font']['font-weight'],
							'text-transform' => PEsettings::$default['posts-font']['text-transform'],
							'font-family'    => PEsettings::$default['posts-font']['font-family'],
							'font-backup'    => 'Arial, Helvetica, sans-serif',
							'google'         => true,
							'font-size'      => PEsettings::$default['posts-font']['font-size'],
							'letter-spacing' => '', //PEsettings::$default['posts-font']['letter-spacing']
							'font-style'     => '', //PEsettings::$default['posts-font']['font-style']
						),
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// COLORS
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title' => esc_html__( 'Colors', 'pe-terraclassic' ),
				'id'    => 'colors',
				'icon'  => 'el el-brush',
			) );

			//General
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'General', 'pe-terraclassic' ),
				'id'         => 'general-colors',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'mainSchemeColor',
						'type'        => 'color',
						'title'       => esc_html__( 'Scheme color', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Modify primary theme color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['mainSchemeColor'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'mainSchemeColor2',
						'type'        => 'color',
						'title'       => esc_html__( 'Secondary scheme color', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Modify secondary theme color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['mainSchemeColor2'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'schemeInner',
						'type'        => 'color',
						'title'       => esc_html__( 'Scheme inner color', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Alternative color for primary scheme color (font in buttons, paginations etc).', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['schemeInner'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'pageBackground',
						'type'        => 'color',
						'title'       => esc_html__( 'Page background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the page background color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['pageBackground'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'border',
						'type'        => 'color',
						'title'       => esc_html__( 'Border', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the border color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['border'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Header
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Header', 'pe-terraclassic' ),
				'id'         => 'header',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'headerBackground',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Header background color and image.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['headerBackground']['background-color'],
							'background-image'      => PEsettings::$default['headerBackground']['background-image'],
							'background-repeat'     => PEsettings::$default['headerBackground']['background-repeat'],
							'background-size'       => PEsettings::$default['headerBackground']['background-size'],
							'background-attachment' => PEsettings::$default['headerBackground']['background-attachment'],
							'background-position'   => PEsettings::$default['headerBackground']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'       => 'headerBackgroundFrontpage',
						'type'     => 'switch',
						'title'    => esc_html__( 'Background image only for frontpage or homepage', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable background image only for frontpage or homepage.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['headerBackgroundFrontpage'],
					),
					array(
						'id'            => 'headerBackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the header background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['headerBackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'headerText',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the header text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['headerText'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'headerWidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the header widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['headerWidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Top1
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Top 1', 'pe-terraclassic' ),
				'id'         => 'top1',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'top1Background',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Top1 background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['top1Background']['background-color'],
							'background-image'      => PEsettings::$default['top1Background']['background-image'],
							'background-repeat'     => PEsettings::$default['top1Background']['background-repeat'],
							'background-size'       => PEsettings::$default['top1Background']['background-size'],
							'background-attachment' => PEsettings::$default['top1Background']['background-attachment'],
							'background-position'   => PEsettings::$default['top1Background']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'top1BackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the top1 background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['top1BackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'top1Text',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the top1 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['top1Text'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'top1WidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the top1 widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['top1WidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Top2
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Top 2', 'pe-terraclassic' ),
				'id'         => 'top2',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'top2Background',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Top2 background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['top2Background']['background-color'],
							'background-image'      => PEsettings::$default['top2Background']['background-image'],
							'background-repeat'     => PEsettings::$default['top2Background']['background-repeat'],
							'background-size'       => PEsettings::$default['top2Background']['background-size'],
							'background-attachment' => PEsettings::$default['top2Background']['background-attachment'],
							'background-position'   => PEsettings::$default['top2Background']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'top2BackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the top2 background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['top2BackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'top2Text',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the top2 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['top2Text'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'top2WidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the top2 widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['top2WidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Top3
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Top 3', 'pe-terraclassic' ),
				'id'         => 'top3',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'top3Background',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Top3 background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['top3Background']['background-color'],
							'background-image'      => PEsettings::$default['top3Background']['background-image'],
							'background-repeat'     => PEsettings::$default['top3Background']['background-repeat'],
							'background-size'       => PEsettings::$default['top3Background']['background-size'],
							'background-attachment' => PEsettings::$default['top3Background']['background-attachment'],
							'background-position'   => PEsettings::$default['top3Background']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'top3BackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the top3 background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['top3BackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'top3Text',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the top3 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['top3Text'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'top3WidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the top3 widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['top3WidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );
			
			//Bottom1
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Bottom 1', 'pe-terraclassic' ),
				'id'         => 'Bottom1',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'bottom1Background',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Bottom1 background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['bottom1Background']['background-color'],
							'background-image'      => PEsettings::$default['bottom1Background']['background-image'],
							'background-repeat'     => PEsettings::$default['bottom1Background']['background-repeat'],
							'background-size'       => PEsettings::$default['bottom1Background']['background-size'],
							'background-attachment' => PEsettings::$default['bottom1Background']['background-attachment'],
							'background-position'   => PEsettings::$default['bottom1Background']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'bottom1BackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the bottom1 background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['bottom1BackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'bottom1Text',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the bottom1 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['bottom1Text'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'bottom1WidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the bottom1 widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['bottom1WidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Bottom2
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Bottom 2', 'pe-terraclassic' ),
				'id'         => 'Bottom2',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'bottom2Background',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Bottom2 background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['bottom2Background']['background-color'],
							'background-image'      => PEsettings::$default['bottom2Background']['background-image'],
							'background-repeat'     => PEsettings::$default['bottom2Background']['background-repeat'],
							'background-size'       => PEsettings::$default['bottom2Background']['background-size'],
							'background-attachment' => PEsettings::$default['bottom2Background']['background-attachment'],
							'background-position'   => PEsettings::$default['bottom2Background']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'bottom2BackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the bottom2 background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['bottom2BackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'bottom2Text',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the bottom2 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['bottom2Text'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'bottom2WidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the bottom2 widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['bottom2WidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Footer
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Footer', 'pe-terraclassic' ),
				'id'         => 'footer-colors',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'footerBackground',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Footer background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['footerBackground']['background-color'],
							'background-image'      => PEsettings::$default['footerBackground']['background-image'],
							'background-repeat'     => PEsettings::$default['footerBackground']['background-repeat'],
							'background-size'       => PEsettings::$default['footerBackground']['background-size'],
							'background-attachment' => PEsettings::$default['footerBackground']['background-attachment'],
							'background-position'   => PEsettings::$default['footerBackground']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'footerBackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the footer background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['footerBackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'footerText',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the footer text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['footerText'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'footerWidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the footer widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['footerWidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );
			
			//Copyrights
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Copyrights', 'pe-terraclassic' ),
				'id'         => 'copyrights-colors',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'copyrightsBackground',
						'type'        => 'background',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the Copyrights background image and color.', 'pe-terraclassic' ),
						'default'     => array(
							'background-color'      => PEsettings::$default['copyrightsBackground']['background-color'],
							'background-image'      => PEsettings::$default['copyrightsBackground']['background-image'],
							'background-repeat'     => PEsettings::$default['copyrightsBackground']['background-repeat'],
							'background-size'       => PEsettings::$default['copyrightsBackground']['background-size'],
							'background-attachment' => PEsettings::$default['copyrightsBackground']['background-attachment'],
							'background-position'   => PEsettings::$default['copyrightsBackground']['background-position'],
						),
						'transparent' => false,
					),
					array(
						'id'            => 'copyrightsBackgroundOpacity',
						'type'          => 'slider',
						'title'         => esc_html__( 'Background Opacity', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Choose the copyrights background image opacity.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['copyrightsBackgroundOpacity'],
						'min'           => '0',
						'step'          => '1',
						'max'           => '100',
						'display_value' => 'text',
					),
					array(
						'id'          => 'copyrightsText',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the copyrights text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['copyrightsText'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'copyrightsWidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the copyrights widgets title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['copyrightsWidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );

			//Widget styles
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Widget styles', 'pe-terraclassic' ),
				'desc'    => esc_html__( 'Set colors for Custom Widget Classes. Check the manual to check how to use custom widget classes in your theme.', 'pe-terraclassic' ),
				'id'         => 'widget-styles',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'peColorBox1Bg',
						'type'        => 'color',
						'title'       => esc_html__( 'Background for pe-color-box1 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box1 background color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox1Bg'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox1Color',
						'type'        => 'color',
						'title'       => esc_html__( 'Text for pe-color-box1 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box1 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox1Color'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox2Bg',
						'type'        => 'color',
						'title'       => esc_html__( 'Background for pe-color-box2 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box2 background color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox2Bg'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox2Color',
						'type'        => 'color',
						'title'       => esc_html__( 'Text for pe-color-box2 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box2 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox2Color'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox3Bg',
						'type'        => 'color',
						'title'       => esc_html__( 'Background for pe-color-box3 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box3 background color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox3Bg'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox3Color',
						'type'        => 'color',
						'title'       => esc_html__( 'Text for pe-color-box3 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box3 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox3Color'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox4Bg',
						'type'        => 'color',
						'title'       => esc_html__( 'Background for pe-color-box4 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box4 background color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox4Bg'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'peColorBox4Color',
						'type'        => 'color',
						'title'       => esc_html__( 'Text for pe-color-box4 class', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose pe-color-box4 text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['peColorBox4Color'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );
			
			//Offcanvas
			Redux::setSection( $opt_name, array(
				'title'      => esc_html__( 'Off-canvas', 'pe-terraclassic' ),
				'id'         => 'offcanvas',
				'subsection' => true,
				'fields'     => array(
					array(
						'id'          => 'offcanvasBackground',
						'type'        => 'color',
						'title'       => esc_html__( 'Section background', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the offcanvas background color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['offcanvasBackground'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'offcanvasText',
						'type'        => 'color',
						'title'       => esc_html__( 'Section text', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the offcanvas text color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['offcanvasText'],
						'validate'    => 'color',
						'transparent' => false,
					),
					array(
						'id'          => 'offcanvasWidgetTitle',
						'type'        => 'color',
						'title'       => esc_html__( 'Section widgets title', 'pe-terraclassic' ),
						'subtitle'    => esc_html__( 'Choose the offcanvas widget title color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['offcanvasWidgetTitle'],
						'validate'    => 'color',
						'transparent' => false,
					),
				)
			) );
			
			// -----------------------------------------------------------------------------
			// FOOTER
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Footer', 'pe-terraclassic' ),
				'id'     => 'footer',
				'icon'   => 'el el-barcode',
				'fields' => array(
					array(
						'id'       => 'copyright-info',
						'type'     => 'switch',
						'title'    => esc_html__( 'Copyright info', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable copyright info.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['copyright-info'],
					),
					array(
						'id'           => 'copyright-info-text',
						'type'         => 'textarea',
						'title'        => esc_html__( 'Copyright text', 'pe-terraclassic' ),
						'subtitle'     => esc_html__( 'Add text for copyright info at the bottom of the page.', 'pe-terraclassic' ),
						'validate'     => 'html_custom',
						'default'      => PEsettings::$default['copyright-info-text'],
						'allowed_html' => array(
							'a'      => array(
								'href'  => array(),
								'title' => array()
							),
							'br'     => array(),
							'em'     => array(),
							'strong' => array()
						),
						'required'     => array( 'copyright-info', '=', true ),
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// CONTACT / SOCIAL
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Contact', 'pe-terraclassic' ),
				'id'     => 'contact',
				'icon'   => 'el el-phone',
				'fields' => array(
					array(
						'id'       => 'contact-map',
						'type'     => 'switch',
						'title'    => esc_html__( 'Google map', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable google map.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-map'],
					),
					array(
						'id'       => 'contact-map-info',
						'type'     => 'info',
						'notice'   => false,
						'desc'     => wp_kses( __( 'Google Maps API must be <strong>enabled</strong>. Please check Advanced tab.', 'pe-terraclassic' ), $allowed_html_array ),
						'required' => array( 'contact-map', '=', true ),
					),
					array(
						'id'       => 'contact-map-latitiude',
						'type'     => 'text',
						'title'    => esc_html__( 'Latitude', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide google map latitude.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-map-latitiude'],
						'required' => array( 'contact-map', '=', true ),
					),
					array(
						'id'       => 'contact-map-longitude',
						'type'     => 'text',
						'title'    => esc_html__( 'Longitude', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide google map longitude.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-map-longitude'],
						'required' => array( 'contact-map', '=', true ),
					),
					array(
						'id'            => 'contact-map-zoom',
						'type'          => 'slider',
						'title'         => esc_html__( 'Zoom', 'pe-terraclassic' ),
						'subtitle'      => esc_html__( 'Provice google map zoom level.', 'pe-terraclassic' ),
						'default'       => PEsettings::$default['contact-map-zoom'],
						'min'           => 1,
						'step'          => 1,
						'max'           => 21,
						'display_value' => 'label',
						'required'      => array( 'contact-map', '=', true ),
					),
					array(
						'id'       => 'contact-map-tooltip',
						'type'     => 'switch',
						'title'    => esc_html__( 'Tooltip', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Show tooltip with address / coordinates.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-map-tooltip'],
					),
					array(
						'id'       => 'contact-tooltip-content',
						'type'     => 'editor',
						'title'    => esc_html__( 'Tooltip content', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide text that will be displayed in map tooltip.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-tooltip-content'],
						'required' => array( 'contact-map-tooltip', '=', true ),
					),
					array(
						'id'       => 'contact-form',
						'type'     => 'switch',
						'title'    => esc_html__( 'Contact form', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable contact form.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-form'],
					),
					array(
						'id'       => 'contact-email-recipients',
						'type'     => 'text',
						'title'    => esc_html__( 'Email recipients', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide email address that will be used to receive messages.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-email-recipients'],
						'required' => array( 'contact-form', '=', true ),
					),
					array(
						'id'       => 'consent1',
						'type'     => 'switch',
						'title'    => 'Consent 1',
						'subtitle' => __('Require consent 1 to send the form', 'pe-terraclassic'),
						'default'  => PEsettings::$default['consent1'],
					),
					array(
						'id'       => 'consent1-text',
						'type'     => 'textarea',
						'title'    => 'Text for consent 1 label (HTML allowed)',
						'default'  => PEsettings::$default['consent1-text'],
						'required' => array( 'consent1', '=', true ),
					),
					array(
						'id'       => 'consent2',
						'type'     => 'switch',
						'title'    => 'Consent 2',
						'subtitle' => __('Require consent 2 to send the form', 'pe-terraclassic'),
						'default'  => PEsettings::$default['consent2'],
					),
					array(
						'id'       => 'consent2-text',
						'type'     => 'textarea',
						'title'    => 'Text for consent 2 label (HTML allowed)',
						'default'  => PEsettings::$default['consent2-text'],
						'required' => array( 'consent2', '=', true ),
					),
					array(
						'id'       => 'contact-spam-protection',
						'type'     => 'switch',
						'title'    => esc_html__( 'Spam protection', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable spam protection.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-spam-protection'],
						'required' => array( 'contact-form', '=', true ),
					),
					array(
						'id'       => 'contact-spam-info',
						'type'     => 'info',
						'notice'   => false,
						'desc'     => wp_kses( __( 'Google reCaptcha API must be <strong>enabled</strong>. Please check Advanced tab.', 'pe-terraclassic' ), $allowed_html_array ),
						'required' => array( 'contact-spam-protection', '=', true ),
					),
					array(
						'id'       => 'contact-details',
						'type'     => 'switch',
						'title'    => esc_html__( 'Contact details', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable contact details.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-details'],
					),
					array(
						'id'       => 'contact-address',
						'type'     => 'editor',
						'title'    => esc_html__( 'Contact address', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide address.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['contact-address'],
						'required' => array( 'contact-details', '=', true ),
					),

				)
			) );

			// -----------------------------------------------------------------------------
			// WCAG 2.0
			// -----------------------------------------------------------------------------

			/*Redux::setSection( $opt_name, array(
				'title'  => __( 'WCAG 2.0', 'pe-terraclassic' ),
				'desc'   => __( 'Accessibility settings.', 'pe-terraclassic' ),
				'id'     => 'wcag',
				'icon'   => 'el el-wheelchair',
				'fields' => array(
					array(
						'id'       => 'wideSite',
						'type'     => 'switch',
						'title'    => __( 'Wide layout', 'pe-terraclassic' ),
						'subtitle' => __( 'Enable / disable wide layout.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['wideSite'],
					),
					array(
						'id'       => 'fontSizeSwitcher',
						'type'     => 'switch',
						'title'    => __( 'Font sizer', 'pe-terraclassic' ),
						'subtitle' => __( 'Enable / disable font sizer.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['fontSizeSwitcher'],
					),
					array(
						'id'       => 'nightVersion',
						'type'     => 'switch',
						'title'    => __( 'Night mode', 'pe-terraclassic' ),
						'subtitle' => __( 'Enable / disable night mode.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['nightVersion'],
					),
					array(
						'id'       => 'highContrast',
						'type'     => 'switch',
						'title'    => __( 'High contrast mode', 'pe-terraclassic' ),
						'subtitle' => __( 'Enable / disable high contrast mode.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['highContrast'],
					),
					array(
						'id'       => 'wcagAnimation',
						'type'     => 'switch',
						'title'    => __('Disable animations', 'pe-terraclassic'),
						'subtitle' => __('Enable / disable CSS animations and transitions.', 'pe-terraclassic'),
						'default'  => false,
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'wcagFocus',
						'type'     => 'switch',
						'title'    => __( 'Focus border', 'pe-terraclassic' ),
						'subtitle' => __( 'Enable / disable border on focused links.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['wcagFocus'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'          => 'wcagFocusColor',
						'type'        => 'color',
						'title'       => __( 'Focus border color', 'pe-terraclassic' ),
						'subtitle'    => __( 'Choose focus border color.', 'pe-terraclassic' ),
						'default'     => PEsettings::$default['wcagFocusColor'],
						'validate'    => 'color',
						'transparent' => false,
						'required'    => array( 'wcagFocus', '=', true ),
					),
					//aria labels
					array(
						'id'       => 'skip-menu-label',
						'type'     => 'text',
						'title'    => __( 'Skip menu label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['skip-menu-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'menu-label',
						'type'     => 'text',
						'title'    => __( 'Main menu label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['menu-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'header-mod-label',
						'type'     => 'text',
						'title'    => __( 'Header label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['header-mod-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'top1-label',
						'type'     => 'text',
						'title'    => __( 'Top1 label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['top1-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'top2-label',
						'type'     => 'text',
						'title'    => __( 'Top2 label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['top2-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'top3-label',
						'type'     => 'text',
						'title'    => __( 'Top3 label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['top3-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'content-top-label',
						'type'     => 'text',
						'title'    => __( 'Content-Top label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['content-top-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'content-bottom-label',
						'type'     => 'text',
						'title'    => __( 'Content-Bottom label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['content-bottom-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'left-label',
						'type'     => 'text',
						'title'    => __( 'Left-Sidebar label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['left-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'right-label',
						'type'     => 'text',
						'title'    => __( 'Right-Sidebar label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['right-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'bottom1-label',
						'type'     => 'text',
						'title'    => __( 'Bottom1 label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['bottom1-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'bottom2-label',
						'type'     => 'text',
						'title'    => __( 'Bottom2 label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['bottom2-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'footer-mod-label',
						'type'     => 'text',
						'title'    => __( 'Footer label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['footer-mod-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'footer-label',
						'type'     => 'text',
						'title'    => __( 'Copyrights label', 'pe-terraclassic' ),
						'subtitle' => __( 'Section aria-label attribute.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['footer-label'],
						'required' => array( 'highContrast', '=', true ),
					),
					array(
						'id'       => 'post-page-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Post/page title heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for post/page title.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['post-page-heading'],
					),
					array(
						'id'       => 'archive-blog-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Archive/blog title heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for archive/blog title.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['archive-blog-heading'],
					),
					array(
						'id'       => 'archive-blog-post-page-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Post/page title heading level in archive/blog view.', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for post/page in archive/blog view.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['archive-blog-post-page-heading'],
					),
					array(
						'id'       => 'left-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Left heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Left sidebar.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['left-heading'],
					),
					array(
						'id'       => 'right-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Right heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Right sidebar.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['right-heading'],
					),
					array(
						'id'       => 'top-bar-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Top Bar heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Top Bar sidebar.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['top-bar-heading'],
					),
					array(
						'id'       => 'header-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Header heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Header section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['header-heading'],
					),
					array(
						'id'       => 'top1-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Top 1 heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Top 1 section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['top1-heading'],
					),
					array(
						'id'       => 'top2-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Top 2 heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Top 2 section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['top2-heading'],
					),
					array(
						'id'       => 'top3-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Top 3 heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Top 3 section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['top3-heading'],
					),
					array(
						'id'       => 'content-top-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Content top  heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Content top section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['content-top-heading'],
					),
					array(
						'id'       => 'content-bottom-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Content bottom  heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Content bottom section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['content-bottom-heading'],
					),
					array(
						'id'       => 'bottom1-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Bottom 1 heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Bottom 1 section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['bottom1-heading'],
					),
					array(
						'id'       => 'bottom2-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Bottom 2 heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Bottom 2 section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['bottom2-heading'],
					),
					array(
						'id'       => 'footer-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Footer heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Footer section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['footer-heading'],
					),
					array(
						'id'       => 'offcanvas-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Off-canvas heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Off-canvas section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['offcanvas-heading'],
					),
					array(
						'id'       => 'coming-soon-heading',
						'type'     => 'select',
						'title'    => esc_html__( 'Coming-Soon heading level', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Choose the heading level for widets in Coming-Soon section.', 'pe-terraclassic' ),
						'options'  => array(
							'1' => esc_html__( 'h1', 'pe-terraclassic' ),
							'2' => esc_html__( 'h2', 'pe-terraclassic' ),
							'3' => esc_html__( 'h3', 'pe-terraclassic' ),
							'4' => esc_html__( 'h4', 'pe-terraclassic' ),
							'5' => esc_html__( 'h5', 'pe-terraclassic' ),
							'6' => esc_html__( 'h6', 'pe-terraclassic' ),
							'7' => esc_html__( 'paragraph', 'pe-terraclassic' ),
						),
						'default'  => PEsettings::$default['coming-soon-heading'],
					),
				)
			) );*/

			// -----------------------------------------------------------------------------
			// ADVANCED
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Advanced', 'pe-terraclassic' ),
				'id'     => 'advanced',
				'icon'   => 'el el-wrench',
				'fields' => array(
					array(
						'id'       => 'compress-css',
						'type'     => 'switch',
						'title'    => esc_html__( 'Compress CSS', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable compressing CSS.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['compress-css'],
					),
					array(
						'id'       => 'source-map',
						'type'     => 'switch',
						'title'    => esc_html__( 'LESS source maps', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable generating LESS source maps.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['source-map'],
						'required' => array( 'compress-css', '=', false ),
					),
					array(
						'id'       => 'clear-cache',
						'type'     => 'switch',
						'title'    => esc_html__( 'LESS cache', 'pe-terraclassic' ),
						'on'       => esc_html__( 'Clear', 'pe-terraclassic' ),
						'off'      => esc_html__( 'Keep', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable to clear LESS cache (cache will be removed after next page reload).', 'pe-terraclassic' ),
						'desc'     => wp_kses( __( '<b>Size:</b> ', 'pe-terraclassic' ), $allowed_html_array ) . $this->dirSize( PEsettings::$default['cachepath'] ) . ' ' .
									  wp_kses( __( '<b>Path:</b> ', 'pe-terraclassic' ), $allowed_html_array ) . PEsettings::$default['cachepath'],
						'default'  => false,
					),
					array(
						'id'       => 'google-map-api',
						'type'     => 'switch',
						'title'    => esc_html__( 'Google Maps API', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable loading Google Maps API (requred for Map shortcode or Contact Page).', 'pe-terraclassic' ) . ' <a href="' . esc_url( 'http://googlegeodevelopers.blogspot.com.au/2016/06/building-for-scale-updates-to-google.html' ) . '" target="_blank">' . esc_html__( 'More details', 'pe-terraclassic' ) . '</a>,
													<a href="' . esc_url( 'https://developers.google.com/maps/documentation/javascript/get-api-key' ) . '" target="_blank">' . esc_html__( 'get key', 'pe-terraclassic' ) . '</a>.',
						'default'  => PEsettings::$default['google-map-api'],
					),
					array(
						'id'       => 'google-map-api-key',
						'type'     => 'text',
						'title'    => esc_html__( 'Maps API key', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide google map API key', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['google-map-api-key'],
						'required' => array( 'google-map-api', '=', true ),
					),
					array(
						'id'       => 'google-captcha-api',
						'type'     => 'switch',
						'title'    => esc_html__( 'Google reCAPTCHA API', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable loading Google reCaptcha API (requred for spam protection on Contact Page).', 'pe-terraclassic' ) . ' <a href="' . esc_url( 'https://www.google.com/recaptcha/' ) . '" target="_blank">' . esc_html__( 'More details', 'pe-terraclassic' ) . '</a>',
						'default'  => PEsettings::$default['google-captcha-api'],
					),
					array(
						'id'       => 'google-captcha-sitekey',
						'type'     => 'text',
						'title'    => esc_html__( 'reCAPTCHA Site key', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide google reCaptcha site key.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['google-captcha-sitekey'],
						'required' => array( 'google-captcha-api', '=', true ),
					),
					array(
						'id'       => 'google-captcha-secretkey',
						'type'     => 'text',
						'title'    => esc_html__( 'reCAPTCHA Secret key', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Provide google reCaptcha secret key.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['google-captcha-secretkey'],
						'required' => array( 'google-captcha-api', '=', true ),
					),
					//high resolution
					array(
						'id'       => 'retina-display-support',
						'type'     => 'switch',
						'title'    => esc_html__( 'Retina JS', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Enable / disable high resolution support for images.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['retina-display-support'],
					),
					array(
						'id'       => 'retina-info',
						'type'     => 'info',
						'notice'   => false,
						'desc'     => wp_kses( __( 'If you want to use High Resolution option remember to prepare duplicate of your images with higher resolutions and special name @2x.<br />Example: image.png - image@2x.png. Upload images in Media Library or via FTP client. Both images must be stored in the same directory.', 'pe-terraclassic' ), $allowed_html_array ),
						'required' => array( 'retina-display-support', '=', true ),
					),
					array(
						'id'       => 'retina-logo',
						'type'     => 'media',
						'operator' => 'and',
						'title'    => esc_html__( 'Logo', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Upload a high resolution logo image.', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['retina-logo'],
						'required' => array( 'retina-display-support', '=', true ),
					),
					//custom codes
					array(
						'id'       => 'head-custom-code',
						'type'     => 'ace_editor',
						'mode'     => 'html',
						'theme'    => 'chrome',
						'title'    => esc_html__( 'Head custom code', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'Add custom code into the &lt;HEAD&gt; section if needed. Please put Javascript code inside script tags.', 'pe-terraclassic' ),
						'default'  => '',
					),
					array(
						'id'       => 'body-custom-code',
						'type'     => 'ace_editor',
						'mode'     => 'html',
						'theme'    => 'chrome',
						'title'    => esc_html__( 'Body custom code', 'pe-terraclassic' ),
						'subtitle' => esc_html__( 'This code will be inserted right before closing the &lt;/BODY&gt; tag. Please put Javascript code inside script tags. Paste here Google Analytics Scripts, Google Re-marketing Tag, Google Webmaster Tools, etc.', 'pe-terraclassic' ),
						'default'  => '',
					),
					array(
						'id'       => 'dynamic-css',
						'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'chrome',
						'title'    => esc_html__( 'Custom CSS', 'pe-terraclassic' ),
						'subtitle' => wp_kses( __( 'In this field you can add custom CSS to your theme. Please note you can also create file <strong>custom.less</strong> in less directory and use LESS instead plain css.', 'pe-terraclassic' ), $allowed_html_array ),
						'default'  => '',
						'validate' => 'css',
					),
					array(
						'id'       => 'check-updates',
						'type'     => 'switch',
						'title'    => 'Check for updates',
						'on'       => 'Enable',
						'off'      => 'Disable',
						'subtitle' => __( 'Check for theme updates', 'pe-terraclassic' ),
						'default'  => PEsettings::$default['check-updates'],
					),
				)
			) );

			// -----------------------------------------------------------------------------
			// DOCUMENTATION
			// -----------------------------------------------------------------------------

			Redux::setSection( $opt_name, array(
				'title'  => esc_html__( 'Documentation', 'pe-terraclassic' ),
				'id'     => 'documentation',
				'icon'   => 'el el-paper-clip',
				'fields' => array(
					array(
						'id'   => 'doc-general',
						'type' => 'raw',
						'desc' => sprintf( '<a href="' . esc_url( 'https://www.pixelemu.com/documentation/wordpress-themes/pe-simple/' ) . '" target="_blank">%s</a>', esc_html__( 'General documentation', 'pe-terraclassic' ) ),
					),
					array(
						'id'   => 'doc-sidebars',
						'type' => 'raw',
						'desc' => sprintf( '<a href="' . esc_url('https://www.pixelemu.com/documentation/wordpress-themes/first-steps#pe-theme-elements') . '" target="_blank">%s</a>', esc_html__('Get info about sidebars and widgets types', 'pe-terraclassic' ) ),
					),
					array(
						'id'   => 'doc-widget-positions',
						'type' => 'raw',
						'desc' => sprintf( '<a href="' . esc_url( 'https://www.pixelemu.com/documentation/wordpress-themes/pe-simple/#pe-other-all-widget-positions' ) . '" target="_blank">%s</a>', esc_html__( 'All available widget positions', 'pe-terraclassic' ) ),
					),
					array(
						'id'   => 'doc-classes',
						'type' => 'raw',
						'desc' => sprintf( '<a href="' . esc_url( 'https://www.pixelemu.com/documentation/wordpress-themes/pe-simple/#pe-other-classes-for-widgets' ) . '" target="_blank">%s</a>', esc_html__( 'All available classes', 'pe-terraclassic' ) ),
					),
					array(
						'id'   => 'doc-grid',
						'type' => 'raw',
						'desc' => sprintf( '<a href="' . esc_url( 'https://www.pixelemu.com/documentation/wordpress-tutorials/how-to-use-bootstrap-grid-system-with-wordpress-theme' ) . '" target="_blank">%s</a>', esc_html__( 'Site grid (based on Bootstrap 3)', 'pe-terraclassic' ) ),
					),
				)
			) );

			/*
		 * <--- END SECTIONS
		 */

		}

	}

	$pe_redux = new PEredux();
}
