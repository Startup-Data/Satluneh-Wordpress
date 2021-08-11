<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Plugin Name: PE Terraclassic Plugin
 * Plugin URI: http://pixelemu.com
 * Description: Taxonomies, shortcodes and widgets for PE Terraclassic Theme
 * Version: 1.08
 * Author: pixelemu.com
 * Author URI: http://www.pixelemu.com
 * Text Domain: pe-terraclassic-plugin
 * License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 */

if ( ! class_exists( 'PEplugin' ) ) {
	class PEplugin {

		static $ready;
		static $path;
		static $url;
		static $theme;
		static $name;

		function __construct() {

			self::$path  = plugin_dir_path( __FILE__ );
			self::$url   = plugin_dir_url( __FILE__ );
			self::$theme = 'pe-terraclassic';
			self::$name  = 'PE Terraclassic';

			self::$ready = $this->checkTheme();

			if ( self::$ready === false ) {
				add_action( 'admin_notices', array( $this, 'noThemeNotice' ) );
			} else {
				$this->addCompiler();
				$this->addShortcodes();
				$this->addUpdater();
				$this->addMailer();
				add_action( 'init', array( $this, 'addCustomPosts' ) );
				add_action( 'widgets_init', array( $this, 'addWidgets' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueueWidgetsAdmin' ) );
				add_action( 'after_setup_theme', array( $this, 'addCaptcha' ) );
				add_action( 'wp_head', array( $this, 'customCodeHead' ) );
				add_action( 'wp_footer', array( $this, 'customCodeBody' ), 99 );
				add_action( 'wp_dashboard_setup', array( $this, 'addDashboardWidget' ) );
				add_action('plugins_loaded', array( $this, 'pe_terraclassic_plugin_load_textdomain' ) );
				add_filter( 'the_content', array( $this, 'cleanShortcodes' ) );
				register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
				register_activation_hook( __FILE__, array( $this, 'rewriteFlush' ) );
			}

		}

		/**
		 * Check active theme and fire functions
		 * @return boolean
		 */
		public function checkTheme() {
			$theme = wp_get_theme(); // gets the current theme
			if ( $theme->template == self::$theme ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Notice in backend if theme not active
		 */
		public function noThemeNotice() {
			$class   = 'notice notice-error is-dismissible';
			$message = __( self::$name . ' plugin is inactive. Please first activate the appropriate theme.', 'pe-terraclassic-plugin' );
			printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
		}

		/**
		 * Include LESS compiler
		 */
		public function addCompiler() {
			if ( ! class_exists( 'Less_Autoloader' ) ) {
				include plugin_dir_path( __FILE__ ) . 'less-compiler/Autoloader.php';
				Less_Autoloader::register();
			}
		}

		/**
		 * Include Updater & Shortcodes
		 */
		public function addUpdater() {
			include( self::$path . 'update.php' );
			include( self::$path . 'shortcodes.php' );
		}

		/**
		 * Include shortcodes
		 */
		public function addShortcodes() {
			include self::$path . 'shortcodes/fa.php';
			include self::$path . 'shortcodes/code.php';
			include self::$path . 'shortcodes/anibox.php';
			include self::$path . 'shortcodes/table.php';
			include self::$path . 'shortcodes/accordion.php';
			include self::$path . 'shortcodes/tabs.php';
			include self::$path . 'shortcodes/row.php';
			include self::$path . 'shortcodes/testimonials.php';
			include self::$path . 'shortcodes/pevideo.php';
			include self::$path . 'shortcodes/pegallery.php';
			include self::$path . 'shortcodes/map.php';
			include self::$path . 'shortcodes/headline.php';
			include self::$path . 'shortcodes/readmore.php';
			include self::$path . 'shortcodes/icontext.php';
			include self::$path . 'shortcodes/pricing.php';
			include self::$path . 'shortcodes/counter.php';

			// Enable the use of shortcodes in text widgets.
			add_filter( 'widget_text', 'do_shortcode' );
		}

		/**
		 * Include custom post types
		 */
		public function addCustomPosts() {
			include self::$path . 'custom-posts/faq-post-type.php';
			include self::$path . 'custom-posts/testimonial-post-type.php';
		}

		/**
		 * Flush rewirite rules
		 */
		public function rewriteFlush() {
			$this->addCustomPosts();
			flush_rewrite_rules();
		}

		/**
		 * Register widgets
		 */
		public function addWidgets() {
			include self::$path . 'widgets/pe-social-widget.php';
			include self::$path . 'widgets/pe-contact-widget.php';
			include self::$path . 'widgets/pe-short-info-widget.php';
			include self::$path . 'widgets/pe-testimonial-carousel-widget.php';
			include self::$path . 'widgets/pe-image-carousel.php';
			include self::$path . 'widgets/pe-best-features.php';
			include self::$path . 'widgets/pe-login-popup.php';
			register_widget( 'PE_Social_Icons' );
			register_widget( 'PE_Contact' );
			register_widget( 'PE_Short_Info' );
			register_widget( 'PE_Testimonial_Carousel' );
			register_widget( 'PE_Image_Carousel' );
			register_widget( 'PE_Best_Features' );
			register_widget( 'PE_Login_Popup' );
		}

		/**
		 * Add scripts and styles
		 */
		public function enqueue() {
			if ( ! is_admin() ) {
				//head
				wp_enqueue_script( self::$theme . '-plugin-map', self::$url . 'js/map.js', array( 'jquery' ), false );
				//body
				wp_enqueue_script( self::$theme . '-plugin-countjs', self::$url . 'js/jquery.countTo.js', array( 'jquery' ), true );
				wp_enqueue_script( self::$theme . '-plugin-js', self::$url . 'js/script.js', array( 'jquery' ), true );
				

			}
		}

		public function enqueueWidgetsAdmin( $hook ) {
			if ( $hook != 'widgets.php' ) {
				return;
			}
			wp_enqueue_script( 'pe-multifields-admin', self::$url . 'js/multifields-admin.js', array( 'jquery' ), false );
		}

		/**
		 * Add Google Captcha
		 */
		public function addCaptcha() {
			$reCaptcha = ( PEsettings::get( 'google-captcha-api' ) && PEsettings::get( 'google-captcha-sitekey' ) && PEsettings::get( 'google-captcha-secretkey' ) ) ? true : false;
			if ( $reCaptcha ) {
				require_once( self::$path . 'captcha/autoload.php' );
			}
		}

		/**
		 * Add mailer function related to contact form
		 */
		public function addMailer() {
			include( self::$path . 'send-email.php' );
		}

		/**
		 * Custom code injection
		 */
		public function customCodeHead() {
			if ( ! empty( PEsettings::get( 'head-custom-code' ) ) ) {
				echo PEsettings::get( 'head-custom-code' );
			}
		}

		public function customCodeBody() {
			if ( ! empty( PEsettings::get( 'body-custom-code' ) ) ) {
				echo PEsettings::get( 'body-custom-code' );
			}
		}

		/**
		 * Remove unnecessary html tags from shortcodes
		 */
		function cleanShortcodes( $content ) {
			// array of custom shortcodes requiring the fix (no affect to 3rd party shortcodes)
			$block = join( '|', array(
				'code',
				'accordion',
				'accordion_content',
				'row',
				'col',
				'headline',
				'tabs',
				'tab',
				'table',
				'testimonial',
				'readmore',
				'icontext',
				'fa',
				'pricing',
				'counter',
			) );
			// opening tag
			$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );

			// closing tag
			$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );

			return $rep;
		}

		/**
		 * WP Dashboard widget
		 */
		public function addDashboardWidget() {
			// Create the widget
			wp_add_dashboard_widget( 'pixelemu_news', __( 'Pixelemu News', 'pe-terraclassic-plugin' ), array(
				$this,
				'display_news_dashboard_widget'
			) );

			// Make sure our widget is on top off all others
			global $wp_meta_boxes;

			// Get the regular dashboard widgets array
			$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

			// Backup and delete our new dashboard widget from the end of the array
			$pixelemu_widget_backup = array( 'pixelemu_news' => $normal_dashboard['pixelemu_news'] );
			unset( $normal_dashboard['pixelemu_news'] );

			// Merge the two arrays together so our widget is at the beginning
			$sorted_dashboard = array_merge( $pixelemu_widget_backup, $normal_dashboard );

			// Save the sorted array back into the original metaboxes
			$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
		}

		public function display_news_dashboard_widget() {

			$feeds = array(
				'news'      => array(
					'link'         => 'https://pixelemu.com/blog/',
					'url'          => 'http://pixelemu.com/blog?format=feed&type=rss',
					'title'        => __( 'Pixelemu News', 'pe-terraclassic-plugin' ),
					'items'        => 2,
					'show_summary' => 0,
					'show_author'  => 0,
					'show_date'    => 0,
				),
				'basics'    => array(
					'link'         => 'https://pixelemu.com/documentation/wordpress-basics/',
					'url'          => 'http://pixelemu.com/documentation/wordpress-basics?format=feed&type=rss',
					'title'        => __( 'Pixelemu WordPress Basics', 'pe-terraclassic-plugin' ),
					'items'        => 2,
					'show_summary' => 0,
					'show_author'  => 0,
					'show_date'    => 0,
				),
				'tutorials' => array(
					'link'         => 'https://pixelemu.com/documentation/wordpress-tutorials/',
					'url'          => 'http://pixelemu.com/documentation/wordpress-tutorials?format=feed&type=rss',
					'title'        => __( 'Pixelemu Tutorials', 'pe-terraclassic-plugin' ),
					'items'        => 2,
					'show_summary' => 0,
					'show_author'  => 0,
					'show_date'    => 0,
				),
			);

			wp_dashboard_primary_output( 'pixelemu_news', $feeds );
		}

		/*-----------------------------------------------------------------------------------*/
		/*	Languages
		/*-----------------------------------------------------------------------------------*/
		public function pe_terraclassic_plugin_load_textdomain() {
			load_plugin_textdomain('pe-terraclassic-plugin', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}
	}
}

new PEplugin();
