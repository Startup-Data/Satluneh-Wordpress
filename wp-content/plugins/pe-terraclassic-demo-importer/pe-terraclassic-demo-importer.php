<?php

/**
 * Plugin Name:     PE Terraclassic Demo Content Importer
 * Description:     Demo content importer for PE Terraclassic theme.
 * Author:          Pixelemu
 * Author URI:      http://www.pixelemu.com
 * Version:         1.00
 * Text Domain:     pe-terraclassic-demo-importer
 * License:         GPL3+
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) )
{
	die;
}

if ( ! class_exists( 'PE_MainClass' ) )
{

	class PE_MainClass {
		public static $_ver;
		public static $_slug;
		public static $_name;
		public static $_dir;
		public static $_url;
		public static $_opt_name;
		public static $_redux_installed;

		public static $_import_data;

		public static $_demo_ver;

		public static $_title;
		public static $_desc;

		public static $_settings_show_on_front;
		public static $_settings_page_on_front;
		public static $_settings_page_for_posts;
		public static $_settings_posts_per_page;

		public static $_menu_location;
		public static $_skipmenu_location;

		public static $_theme_options_name;

		public static $_first_sidebar;

		private static $instance;

		public static function instance() {
			if ( ! self::$instance )
			{
				self::$instance = new self;

				self::$_dir = plugin_dir_path( __FILE__ );
				self::$_url = plugin_dir_url( __FILE__ );

				self::$_ver      = '1.00';
				self::$_slug     = 'pe-terraclassic-demo-importer';
				self::$_name     = 'PE Terraclassic Demo Content Importer';
				self::$_opt_name = 'pe_import_options';

				self::$_title = 'Important notes, read them before importing demo content:';
				self::$_desc  = '<div class="importer-desc">
									<ol>
										<li>Run Demo Importer on a <strong>clean</strong> WordPress installation.</li>
										<li>We <strong>recommended</strong> to use Wordpress Database Reset plugin if installation is not clean.</li>
										<li>Ensure that <strong>PE Terraclassic</strong> theme is <strong>installed &amp; activated</strong>.</li>
										<li>Ensure that required plugins are <strong>installed &amp; activated</strong>:
											<ul class="pe-plugins">
												<li>Redux Framework</li>
												<li>Display Widgets</li>
												<li>PE Terraclassic plugin</li>
												<li>PE Recent Posts</li>
												<li>Terraclassifieds</li>
											</ul>
										</li>
										<li>Do <strong>not refresh</strong> your browser during the operation.</li>
										<li>Do <strong>not run</strong> the Demo Import option multiple times. This will result in some duplicate content.</li>
									</ol>
									When finished installing demo content, you can disable and remove ' . self::$_name . ' plugin.
								</div>';

				//reading settings
				self::$_settings_show_on_front  = 'page'; // type of front page view
				self::$_settings_page_on_front  = '172';  // front page id
				self::$_settings_page_for_posts = '225';  // blog page id
				self::$_settings_posts_per_page = '4';    // post per page

				self::$_menu_location      = 'main-menu'; // default menu
				self::$_skipmenu_location      = 'skip-menu'; // skip menu
				self::$_theme_options_name = 'onepage';  // redux options
				self::$_first_sidebar      = 'left-column';   // first sidebar slug

				self::$_demo_ver = array(
					'demo1' => array(
						'name'     => 'Demo 1',
						'screen'   => plugin_dir_url( __FILE__ ).'/screen.jpg',
						'data-dir' => self::$_dir . 'demo1',
					),
				);

				self::$_import_data = array(

					// settings (front page, main menu)
					array(
						'importer' => 'settings',
						'type'     => 'WP options',
					),
					
					// theme options
					array(
						'importer' => 'theme_options', // importer method
						'type'     => 'Theme options', // importer name
						'xml'      => 'options.json'   // source
					),

					// post, pages, menus and media
					array(
						'importer' => 'content',
						'type'     => 'Posts, pages, menu and media',
						'xml'      => 'content.xml'
					),

					array(
						'importer' => 'menu',
						'type'     => 'Add menus locations',
					),
					
					// widgets
					array(
						'importer' => 'widgets',
						'type'     => 'Widgets',
						'xml'      => 'widgets.wie'
					),

					// rev slider
					/*array(
						'importer'    => 'revslider',
						'type'        => 'Revolution sliders',
						'class_check' => 'UniteFunctionsRev'
					),*/

					// megamenu
					/*array(
						'importer'    => 'megamenu',
						'type'        => 'Megamenu',
						'xml'         => 'megamenu.json',
						'class_check' => 'Mega_Menu'
					),*/

					// custom files
					/*array(
						'importer'  => 'custom_files',
						'type'      => 'Images for PE Easy Slider (pe-easy-slider-images)',
						'xml'       => 'pe-easy-slider-images'
					),*/

					// ninja forms
					/*array(
						'importer'  => 'ninja_form_import',
						'type'      => 'ninja form xxx',
						'xml'       => 'xxx.nff'
					),*/
				);

				self::$instance->includes();
			}

			return self::$instance;
		}

		private function includes() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'init', array( $this, 'removeDemoModeLink' ) );
		}

		public function init() {
			include_once 'inc/redux-check.php';

			if ( self::$_redux_installed )
			{
				include_once 'inc/redux-config.php';
			}
		}

		public function removeDemoModeLink() { //
			if ( class_exists( 'ReduxFrameworkPlugin' ) )
			{
				remove_filter( 'plugin_row_meta', array(
					ReduxFrameworkPlugin::get_instance(),
					'plugin_metalinks'
				), null, 2 );
			}
			if ( class_exists( 'ReduxFrameworkPlugin' ) )
			{
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
			}
		}
	}
}
PE_MainClass::instance();

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// load Wordpress Database Reset plugin
if ( ! is_plugin_active( 'wordpress-database-reset/wp-reset.php' ) )
{
	require_once( plugin_dir_path( __FILE__ ) . 'wordpress-database-reset/wp-reset.php' );
}

// needed scripts
function pe_demo_content_importer_css() {
	wp_enqueue_style( 'pe_demo_content_importer_css', PE_MainClass::$_url . '/inc/extensions/demo_content_import/demo_content_import/panel_demo_content_import.css', array(), time(), 'all' );
}

function pe_demo_content_importer_js() {
	wp_enqueue_script( 'pe_demo_content_importer_js', PE_MainClass::$_url . '/inc/extensions/demo_content_import/demo_content_import/panel_demo_content_import.js', array( 'jquery' ), time(), true );
	wp_localize_script( 'pe_demo_content_importer_js', 'wp_ajax',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'ajax_nonce' )
		)
	);
}

// load the scripts on only the plugin admin page
if ( isset( $_GET['page'] ) && ( $_GET['page'] == PE_MainClass::$_slug ) )
{
	// if we are on the plugin page, enable the script
	add_action( 'admin_print_styles', 'pe_demo_content_importer_css' );
	add_action( 'admin_print_scripts', 'pe_demo_content_importer_js' );
}

