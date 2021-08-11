<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/**
 * Plugin Name: PE Beauty Center Plugin
 * Plugin URI: http://pixelemu.com
 * Description: Taxonomies and shortcodes for PE Beauty Center Theme
 * Version: 1.10
 * Author: pixelemu.com
 * Author URI: http://www.pixelemu.com
 * Text Domain: PixelEmu
 * License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
 */

/*-----------------------------------------------------------------------------------*/
/*	Include Custom Post Types
/*-----------------------------------------------------------------------------------*/

include("custom-posts/member-post-type.php");
include("custom-posts/testimonial-post-type.php");
include("custom-posts/service-post-type.php");
include("custom-posts/faq-post-type.php");

/*-----------------------------------------------------------------------------------*/
/*	Include Shortcodes
/*-----------------------------------------------------------------------------------*/

include("shortcodes/accordion.php");
include("shortcodes/animation.php");
include("shortcodes/columns.php");
include("shortcodes/image-gallery.php");
include("shortcodes/pe-box.php");
include("shortcodes/pricing-table.php");
include("shortcodes/tabs.php");
include("shortcodes/testimonials.php");
include("shortcodes/video-gallery.php");

/*-----------------------------------------------------------------------------------*/
/*	Shortcode generator
/*-----------------------------------------------------------------------------------*/

include (plugin_dir_path( __FILE__ ) . 'shortcodes.php');

/*-----------------------------------------------------------------------------------*/
/*	Update checker
/*-----------------------------------------------------------------------------------*/

include (plugin_dir_path( __FILE__ ) . 'update.php');

/*-----------------------------------------------------------------------------------*/
/*	Pixelemu news
/*-----------------------------------------------------------------------------------*/

add_action( 'wp_dashboard_setup', 'pe_addDashboardWidget' );
function pe_addDashboardWidget() {
	// Create the widget
	wp_add_dashboard_widget( 'pixelemu_news', __( 'Pixelemu News', 'PixelEmu' ), 'pe_display_news_dashboard_widget' );

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

function pe_display_news_dashboard_widget() {

	$feeds = array(
		'news' => array(
			'link'         => 'https://pixelemu.com/blog/',
			'url'          => 'http://pixelemu.com/blog?format=feed&type=rss',
			'title'        => __( 'Pixelemu News', 'PixelEmu' ),
			'items'        => 2,
			'show_summary' => 0,
			'show_author'  => 0,
			'show_date'    => 0,
		),
		'basics' => array(
			'link'         => 'https://pixelemu.com/documentation/wordpress-basics/',
			'url'          => 'http://pixelemu.com/documentation/wordpress-basics?format=feed&type=rss',
			'title'        => __( 'Pixelemu WordPress Basics', 'PixelEmu' ),
			'items'        => 2,
			'show_summary' => 0,
			'show_author'  => 0,
			'show_date'    => 0,
		),
		'tutorials' => array(
			'link'         => 'https://pixelemu.com/documentation/wordpress-tutorials/',
			'url'          => 'http://pixelemu.com/documentation/wordpress-tutorials?format=feed&type=rss',
			'title'        => __( 'Pixelemu Tutorials', 'PixelEmu' ),
			'items'        => 2,
			'show_summary' => 0,
			'show_author'  => 0,
			'show_date'    => 0,
		),
	);

	wp_dashboard_primary_output( 'pixelemu_news', $feeds );
}

add_action( 'admin_enqueue_scripts', 'pe_enqueueWidgetsAdmin' );
function pe_enqueueWidgetsAdmin( $hook ) {
	if( $hook != 'widgets.php' ) return;
	wp_enqueue_script( 'pe-multifields-admin', plugin_dir_url( __FILE__ ) . 'js/multifields-admin.js', array('jquery'), false );
}

/*-----------------------------------------------------------------------------------*/
/*	Languages
/*-----------------------------------------------------------------------------------*/
add_action('plugins_loaded', 'pe_beauty_center_plugin_load_textdomain');
function pe_beauty_center_plugin_load_textdomain() {
	load_plugin_textdomain('PixelEmu', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
?>
