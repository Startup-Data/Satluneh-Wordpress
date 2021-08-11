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

// ---------------------------------------------------------------
// SETTINGS
// ---------------------------------------------------------------

if ( ! class_exists( 'PEsettings' ) ) {
	class PEsettings {

		static $instance = null;
		public static $default = array();
		public static $redux = array();
		public static $less = array();
		public static $override = null;

		/**
		 * Get instance
		 * @return object
		 */
		public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new PEsettings();
			}

			return self::$instance;
		}

		function __construct() {
			//init after setup theme
			add_action( 'after_setup_theme', array( $this, 'prepareDefault' ), 2 );
			add_action( 'after_setup_theme', array( $this, 'prepareRedux' ), 2 );
			add_action( 'after_setup_theme', array( $this, 'prepareLess' ), 5 );
		}

		/**
		 * Default settings array
		 */
		public function prepareDefault() {

			$upload_dir = wp_upload_dir();
			$theme      = wp_get_theme();

			self::$default = array(

				//unique settings name for Redux
				'settings_name' => 'onepage',
				//less compiler paths and urls
				'files_name'    => '',

				//paths without '/'
				'lesspath'      => get_template_directory() . DIRECTORY_SEPARATOR . 'less',

				'cachepath'                  => $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $theme->template . DIRECTORY_SEPARATOR . 'cache',
				'csspath'                    => $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $theme->template . DIRECTORY_SEPARATOR . 'css',
				'mapspath'                   => $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $theme->template . DIRECTORY_SEPARATOR . 'maps',

				//urls with '/'
				'cssurl'                     => $upload_dir['baseurl'] . '/' . $theme->template . '/css/',
				'mapsurl'                    => $upload_dir['baseurl'] . '/' . $theme->template . '/maps/',

				//fallback css directory
				'fallback'                   => get_template_directory_uri() . '/css/fallback/',

				//DEFAULT VARIABLES
				// exact copy of Redux array

				//basic settings
				'logo'                       => array( 'url' => get_template_directory_uri() . '/images/logo.png' ),
				'favicon'                    => array( 'url' => '' ),
				'back-to-top'                => true,
				'sticky-topbar'              => true,
				'search-bar'              => false,
				'off-canavs-sidebar'         => false,
				'off-canavs-width'           => array( 'width' => '300px' ),
				'off-canavs-position'        => 'right',
				'coming-soon'                => false,
				'coming-soon-until-date'     => '',

				//layout
				'theme-width'                => array( 'width' => '890px', 'units' => 'px' ),
				'left-column-width'          => '3',
				'right-column-width'         => '3',
				'frontpage-layout'           => '3',
				'subpage-layout'             => '4',
				'full-screen'                => '',
				'front-page-content'         => false,
				'front-page-title'           => false,

				//main menu
				'main-menu-switch'           => 'standard',
				'responsive-breakpoint'      => array( 'width' => '991px' ),
				'topmenu-font'               => array(
					'color'          => '#454545',
					'font-weight'    => '700',
					'text-transform' => 'none',
					'font-family'    => 'Lato',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '13px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),
				'topmenu-submenu-font'       => array(
					'font-weight'    => '400',
					'font-size'      => '13px',
					'text-transform' => 'none',
				),
				'topmenuSubmenuFontColor'    => '#039ad2',
				'topmenuSubmenuBackground'   => '#ffffff',
				'topmenuBorderColor'   => '#ac3e35',
				
				//vertical main menu
				'vertical-main-menu'           => false,
				'vertical-main-menu-homepage'           => false,
				'vertical-main-menu-absolute'           => false,
				'vertical-topmenu-font'               => array(
					'color'          => '#039ad2',
					'font-weight'    => '700',
					'text-transform' => 'none',
					'font-family'    => 'Playfair Display',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '36px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),
				'vertical-topmenu-submenu-font'       => array(
					'font-weight'    => '400',
					'font-size'      => '16px',
					'text-transform' => 'none',
				),
				'vertical-topmenuSubmenuFontColor'    => '#ffffff',
				'vertical-topmenuSubmenuBackground'       => array(
					'color' => '#13171d',
					'alpha' => 0.75,
					'rgba'  => 'rgba(19, 23, 29, 0.75)',
				),

				//posts and pages

				//-blog
				'blog-style'                 => 'standard',
				'blogEffectBackground'       => array(
					'color' => '#f85645',
					'alpha' => 0.75,
					'rgba'  => 'rgba(248, 86, 69, 0.75)',
				),
				'blogEffectText'             => '#ffffff',
				'blog-columns'               => 1,
				'blog-1column-image-width'     => array( 'width' => '100', 'units' => '%' ),
				'blog-breadcrumb'            => false,
				'blog-details'               => true,
				'blog-thumbnails'            => true,
				'blog-thumbnails-link'            => false,
				'blog-readmore'              => true,
				'blog-excerpt'               => true,
				'blog-excerpt-length'        => 55,
				//-archive
				'archive-style'              => 'standard',
				'archiveEffectBackground'    => array(
					'color' => '#f85645',
					'alpha' => 0.75,
					'rgba'  => 'rgba(248, 86, 69, 0.75)',
				),
				'archiveEffectText'          => '#ffffff',
				'archive-columns'            => 1,
				'archive-1column-image-width'     => array( 'width' => '44', 'units' => '%' ),
				'archive-header'             => true,
				'archive-breadcrumb'         => false,
				'archive-details'            => true,
				'archive-thumbnails'         => true,
				'archive-thumbnails-link'         => false,
				'archive-readmore'           => false,
				'archive-excerpt'            => true,
				'archive-excerpt-length'     => 52,
				//-single post
				'post-tags'                  => true,
				'post-author-info'           => true,
				'post-comments'              => true,
				//-single page
				'page-breadcrumb'            => true,
				'page-comments'              => true,
				//-members
				'member-thumbnail-size'      => 'medium',
				'member-opening-hours'       => true,
				'member-opening-hours-label' => esc_html__( 'Working hours', 'pe-terraclassic' ),
				'member-contact-info'        => true,
				'member-social-links'        => true,
				//fonts
				'body-font'                  => array(
					'color'          => '#454545',
					'font-weight'    => '400',
					'text-transform' => 'none',
					'font-family'    => 'Lato',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '15px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),
				'posts-font'                 => array(
					'color'          => '#212121',
					'font-weight'    => '400',
					'text-transform' => 'none',
					'font-family'    => 'Montserrat',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '14px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),
				'widgets-font'               => array(
					'color'          => '#212121',
					'font-weight'    => '400',
					'text-transform' => 'none',
					'font-family'    => 'Montserrat',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '16px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),
				'tcf-category-title-font'                 => array(
					'color'          => '#323d4c',
					'font-weight'    => '400',
					'text-transform' => 'none',
					'font-family'    => 'Lato',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '42px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),
				'tcf-single-title-font'                 => array(
					'color'          => '#212121',
					'font-weight'    => '400',
					'text-transform' => 'none',
					'font-family'    => 'Lato',
					'font-backup'    => 'Arial, Helvetica, sans-serif',
					'font-size'      => '20px',
					'letter-spacing' => 'normal',
					'font-style'     => 'normal',
				),

				//colors (all variables are required for less)
				'mainSchemeColor'            => '#039ad2',
				'mainSchemeColor2'           => '#454545',
				'schemeInner'                => '#ffffff',
				'pageBackground'             => '#f7f7f7',
				'border'                     => '#d2d7da',

				'headerBackground'        => array(
					'background-color'      => '#f7f7f7',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
					'background-position'   => 'center center',
				),
				'headerBackgroundFrontpage' => true,
				'headerBackgroundOpacity' => 100,
				'headerText'              => '#454545',
				'headerWidgetTitle'       => '#454545',

				'top1Background'        => array(
					'background-color'      => '#ffffff',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'inherit',
					'background-attachment' => 'inherit',
					'background-position'   => 'right bottom',
				),
				'top1BackgroundOpacity' => 100,
				'top1Text'              => '#323d4c',
				'top1WidgetTitle'       => '#323d4c',

				'top2Background'        => array(
					'background-color'      => '#f5f5f5',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'inherit',
					'background-attachment' => 'inherit',
					'background-position'   => 'left bottom',
				),
				'top2BackgroundOpacity' => 100,
				'top2Text'              => '#444444',
				'top2WidgetTitle'       => '#444444',
				
				'top3Background'        => array(
					'background-color'      => '#ffffff',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'inherit',
					'background-attachment' => 'inherit',
					'background-position'   => 'left top',
				),
				'top3BackgroundOpacity' => 100,
				'top3Text'              => '#323d4c',
				'top3WidgetTitle'       => '#323d4c',

				'bottom1Background'        => array(
					'background-color'      => '#ffffff',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'inherit',
					'background-position'   => 'center center',
				),
				'bottom1BackgroundOpacity' => 100,
				'bottom1Text'              => '#454545',
				'bottom1WidgetTitle'       => '#454545',

				'bottom2Background'        => array(
					'background-color'      => '#ffffff',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'inherit',
					'background-attachment' => 'inherit',
					'background-position'   => 'center center',
				),
				'bottom2BackgroundOpacity' => 100,
				'bottom2Text'              => '#454545',
				'bottom2WidgetTitle'       => '#454545',

				'footerBackground'        => array(
					'background-color'      => '#ffffff',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'inherit',
					'background-attachment' => 'inherit',
					'background-position'   => 'left top',
				),
				'footerBackgroundOpacity' => 100,
				'footerText'              => '#323d4c',
				'footerWidgetTitle'       => '#323d4c',
				
				'copyrightsBackground'        => array(
					'background-color'      => '#1c253a',
					'background-image'      => '',
					'background-repeat'     => 'no-repeat',
					'background-size'       => 'inherit',
					'background-attachment' => 'inherit',
					'background-position'   => 'left top',
				),
				'copyrightsBackgroundOpacity' => 100,
				'copyrightsText'              => '#374870',
				'copyrightsWidgetTitle'       => '#374870',

				'peColorBox1Bg'      => '#0b54ab',
				'peColorBox1Color'      => '#ffffff',
				'peColorBox2Bg'      => '#5aadff',
				'peColorBox2Color'      => '#13171d',
				'peColorBox3Bg'      => '#695331',
				'peColorBox3Color'      => '#ffffff',
				'peColorBox4Bg'      => '#ffce00',
				'peColorBox4Color'      => '#13171d',

				'offcanvasBackground'      => '#333333',
				'offcanvasText'            => '#ffffff',
				'offcanvasWidgetTitle'     => '#ffffff',

				//footer
				'copyright-info'           => true,
				'copyright-info-text'      => esc_html__( 'PE Terraclassic all rights reserved', 'pe-terraclassic' ),

				//contact and social
				'contact-map'              => false,
				'contact-map-latitiude'    => '52.584299',
				'contact-map-longitude'    => '-0.244624',
				'contact-map-zoom'         => 16,
				'contact-map-tooltip'      => false,
				'contact-tooltip-content'  => '',
				'contact-details'          => true,
				'contact-form'             => true,
				'contact-address'          => '',
				'consent1'      => false,
				'consent1-text'      => '',
				'consent2'      => false,
				'consent2-text'      => '',
				'contact-email-recipients' => 'change@me.com',
				'contact-spam-protection'  => false,

				//wcag
				'nightVersion'             => false,
				'highContrast'             => false,
				'wcagFocus'                => false,
				'wcagFocusColor'           => '#ff0000',
				'wideSite'                 => false,
				'fontSizeSwitcher'         => false,
				'skip-menu-label'          => __( 'Skip Content menu', 'pe-terraclassic' ),
				'menu-label'               => __( 'Primary menu', 'pe-terraclassic' ),
				'header-mod-label'         => __( 'Header Widgets', 'pe-terraclassic' ),
				'top1-label'               => __( 'Top1 Widgets', 'pe-terraclassic' ),
				'top2-label'               => __( 'Top2 Widgets', 'pe-terraclassic' ),
				'top3-label'               => __( 'Top3 Widgets', 'pe-terraclassic' ),
				'content-top-label'        => __( 'Content Top Widgets', 'pe-terraclassic' ),
				'content-bottom-label'     => __( 'Content Bottom Widgets', 'pe-terraclassic' ),
				'left-label'               => __( 'Left-Sidebar', 'pe-terraclassic' ),
				'right-label'              => __( 'Right-Sidebar', 'pe-terraclassic' ),
				'bottom1-label'            => __( 'Bottom1 Widgets', 'pe-terraclassic' ),
				'bottom2-label'            => __( 'Bottom2 Widgets', 'pe-terraclassic' ),
				'footer-mod-label'         => __( 'Footer Widgets', 'pe-terraclassic' ),
				'footer-label'             => __( 'Copyrights', 'pe-terraclassic' ),
				'post-page-heading'   => 1,
				'archive-blog-heading'   => 1,
				'archive-blog-post-page-heading'   => 2,
				'left-heading'               => 3,
				'right-heading'               => 3,
				'top-bar-heading'               => 3,
				'header-heading'               => 3,
				'top1-heading'               => 3,
				'top2-heading'               => 3,
				'top3-heading'               => 3,
				'content-top-heading'               => 3,
				'content-bottom-heading'      => 3,
				'bottom1-heading'               => 3,
				'bottom2-heading'               => 3,
				'footer-heading'               => 3,
				'offcanvas-heading'               => 3,
				'coming-soon-heading'               => 3,

				//advanced
				'compress-css'             => false,
				'source-map'               => false,
				'google-map-api'           => true,
				'google-map-api-key'       => '',
				'google-captcha-api'       => false,
				'google-captcha-sitekey'   => '',
				'google-captcha-secretkey' => '',
				'clear-cache'              => false,
				'retina-display-support'   => false,
				'retina-logo'              => array( 'url' => '' ),

				'check-updates' => true,

				//above array is exact copy of Redux array (compatible variables names)

			);

		}

		/**
		 * Redux settings
		 */
		public function prepareRedux() {
			//get redux settings
			if ( class_exists( 'Redux' ) ) {
				self::$redux = get_option( self::$default['settings_name'] );
			}
		}

		/**
		 * Less global variables
		 */
		public function prepareLess() {

			$imgdir = '\'' . get_template_directory_uri() . '/images\'';

			self::$less = array(

				'imgDir'                  => $imgdir,

				//theme width
				'themeWidth'              => self::less( 'theme-width,width' ),
				
				//thumbnails settings
				'thumbnailWidth'          => get_option( 'thumbnail_size_w' ),
				'thumbnailHeight'         => get_option( 'thumbnail_size_h' ),

				//body font
				'bodyFontColor'           => self::less( 'body-font,color' ),
				'bodyFontWeight'          => self::less( 'body-font,font-weight' ),
				'bodyFontLetterSpacing'   => self::less( 'body-font,letter-spacing' ),
				'bodyFontTextTransform'   => self::less( 'body-font,text-transform' ),
				'bodyFontFamily'          => self::less( 'body-font,font-family' ) . ',' . self::less( 'body-font,font-backup' ),
				'bodyFontBackup'          => self::less( 'body-font,font-backup' ),
				'bodyFontSize'            => self::less( 'body-font,font-size' ),
				'bodyFontStyle'           => self::less( 'body-font,font-style' ),

				//post title
				'postFontColor'           => self::less( 'posts-font,color' ),
				'postFontWeight'          => self::less( 'posts-font,font-weight' ),
				'postFontLetterSpacing'   => self::less( 'posts-font,letter-spacing' ),
				'postFontTextTransform'   => self::less( 'posts-font,text-transform' ),
				'postFontFamily'          => self::less( 'posts-font,font-family' ) . ',' . self::less( 'posts-font,font-family' ),
				'postFontBackup'          => self::less( 'posts-font,font-backup' ),
				'postFontSize'            => self::less( 'posts-font,font-size' ),
				'postFontStyle'           => self::less( 'posts-font,font-style' ),

				//widget title
				'widgetFontColor'         => self::less( 'widgets-font,color' ),
				'widgetFontWeight'        => self::less( 'widgets-font,font-weight' ),
				'widgetFontLetterSpacing' => self::less( 'widgets-font,letter-spacing' ),
				'widgetFontTextTransform' => self::less( 'widgets-font,text-transform' ),
				'widgetFontFamily'        => self::less( 'widgets-font,font-family' ) . ',' . self::less( 'widgets-font,font-backup' ),
				'widgetFontBackup'        => self::less( 'widgets-font,font-backup' ),
				'widgetFontSize'          => self::less( 'widgets-font,font-size' ),
				'widgetFontStyle'         => self::less( 'widgets-font,font-style' ),
				
				//classifieds category title
				'tcfCategoryFontColor'           => self::less( 'tcf-category-title-font,color' ),
				'tcfCategoryFontWeight'          => self::less( 'tcf-category-title-font,font-weight' ),
				'tcfCategoryFontLetterSpacing'   => self::less( 'tcf-category-title-font,letter-spacing' ),
				'tcfCategoryFontTextTransform'   => self::less( 'tcf-category-title-font,text-transform' ),
				'tcfCategoryFontFamily'          => self::less( 'tcf-category-title-font,font-family' ) . ',' . self::less( 'tcf-category-title-font,font-family' ),
				'tcfCategoryFontBackup'          => self::less( 'tcf-category-title-font,font-backup' ),
				'tcfCategoryFontSize'            => self::less( 'tcf-category-title-font,font-size' ),
				'tcfCategoryFontStyle'           => self::less( 'tcf-category-title-font,font-style' ),
				
				//classifieds single title
				'tcfSingleFontColor'           => self::less( 'tcf-single-title-font,color' ),
				'tcfSingleFontWeight'          => self::less( 'tcf-single-title-font,font-weight' ),
				'tcfSingleFontLetterSpacing'   => self::less( 'tcf-single-title-font,letter-spacing' ),
				'tcfSingleFontTextTransform'   => self::less( 'tcf-single-title-font,text-transform' ),
				'tcfSingleFontFamily'          => self::less( 'tcf-single-title-font,font-family' ) . ',' . self::less( 'tcf-single-title-font,font-family' ),
				'tcfSingleFontBackup'          => self::less( 'tcf-single-title-font,font-backup' ),
				'tcfSingleFontSize'            => self::less( 'tcf-single-title-font,font-size' ),
				'tcfSingleFontStyle'           => self::less( 'tcf-single-title-font,font-style' ),

				//main menu
				'responsiveBreakpoint'    => self::less( 'responsive-breakpoint,width' ),

				'topmenuFontColor'         => self::less( 'topmenu-font,color' ),
				'topmenuFontWeight'        => self::less( 'topmenu-font,font-weight' ),
				'topmenuFontLetterSpacing' => self::less( 'topmenu-font,letter-spacing' ),
				'topmenuFontTextTransform' => self::less( 'topmenu-font,text-transform' ),
				'topmenuFontFamily'        => self::less( 'topmenu-font,font-family' ) . ',' . self::less( 'topmenu-font,font-backup' ),
				'topmenuFontBackup'        => self::less( 'topmenu-font,font-backup' ),
				'topmenuFontSize'          => self::less( 'topmenu-font,font-size' ),
				'topmenuFontStyle'         => self::less( 'topmenu-font,font-style' ),

				'topmenuSubmenuFontWeight'        => self::less( 'topmenu-submenu-font,font-weight' ),
				'topmenuSubmenuFontSize'          => self::less( 'topmenu-submenu-font,font-size' ),
				'topmenuSubmenuFontTextTransform' => self::less( 'topmenu-submenu-font,text-transform' ),
				'topmenuSubmenuFontColor'         => self::less( 'topmenuSubmenuFontColor' ),
				'topmenuSubmenuBackground'        => self::less( 'topmenuSubmenuBackground' ),
				'topmenuBorderColor'        => self::less( 'topmenuBorderColor' ),
				
				//vertical main menu
				'verticalTopmenuFontColor'         => self::less( 'vertical-topmenu-font,color' ),
				'verticalTopmenuFontWeight'        => self::less( 'vertical-topmenu-font,font-weight' ),
				'verticalTopmenuFontLetterSpacing' => self::less( 'vertical-topmenu-font,letter-spacing' ),
				'verticalTopmenuFontTextTransform' => self::less( 'vertical-topmenu-font,text-transform' ),
				'verticalTopmenuFontFamily'        => self::less( 'vertical-topmenu-font,font-family' ) . ',' . self::less( 'vertical-topmenu-font,font-backup' ),
				'verticalTopmenuFontBackup'        => self::less( 'vertical-topmenu-font,font-backup' ),
				'verticalTopmenuFontSize'          => self::less( 'vertical-topmenu-font,font-size' ),
				'verticalTopmenuFontStyle'         => self::less( 'vertical-topmenu-font,font-style' ),

				'verticalTopmenuSubmenuFontWeight'        => self::less( 'vertical-topmenu-submenu-font,font-weight' ),
				'verticalTopmenuSubmenuFontSize'          => self::less( 'vertical-topmenu-submenu-font,font-size' ),
				'verticalTopmenuSubmenuFontTextTransform' => self::less( 'vertical-topmenu-submenu-font,text-transform' ),
				'verticalTopmenuSubmenuFontColor'         => self::less( 'vertical-topmenuSubmenuFontColor' ),
				//'verticalTopmenuSubmenuBackground'        => self::less( 'vertical-topmenuSubmenuBackground' ),
				'verticalTopmenuSubmenuBackgroundColor'    => self::less( 'vertical-topmenuSubmenuBackground,color' ),
				'verticalTopmenuSubmenuBackgroundRgba'     => self::less( 'vertical-topmenuSubmenuBackground,rgba' ),

				'blog1columnImageWidth'              => self::less( 'blog-1column-image-width,width' ),	
				'archive1columnImageWidth'              => self::less( 'archive-1column-image-width,width' ),	

				//main scheme
				'mainSchemeColor'                 => self::less( 'mainSchemeColor' ),
				'mainSchemeColor2'                => self::less( 'mainSchemeColor2' ),
				'schemeInner'                     => self::less( 'schemeInner' ),

				//general colors
				'pageBackground'                  => self::less( 'pageBackground' ),
				'border'                          => self::less( 'border' ),

				//header colors
				'headerBackground'                => self::less( 'headerBackground,background-color' ),
				'headerBackgroundImage'           => self::less( 'headerBackground,background-image' ),
				'headerBackgroundRepeat'          => self::less( 'headerBackground,background-repeat' ),
				'headerBackgroundSize'            => self::less( 'headerBackground,background-size' ),
				'headerBackgroundAttachment'      => self::less( 'headerBackground,background-attachment' ),
				'headerBackgroundPosition'        => self::less( 'headerBackground,background-position' ),
				'headerBackgroundOpacity'         => ( (int) self::less( 'headerBackgroundOpacity' ) / 100 ),
				'headerText'                      => self::less( 'headerText' ),
				'headerWidgetTitle'               => self::less( 'headerWidgetTitle' ),

				//top colors
				'top1Background'                  => self::less( 'top1Background,background-color' ),
				'top1BackgroundImage'             => self::less( 'top1Background,background-image' ),
				'top1BackgroundRepeat'            => self::less( 'top1Background,background-repeat' ),
				'top1BackgroundSize'              => self::less( 'top1Background,background-size' ),
				'top1BackgroundAttachment'        => self::less( 'top1Background,background-attachment' ),
				'top1BackgroundPosition'          => self::less( 'top1Background,background-position' ),
				'top1BackgroundOpacity'           => ( (int) self::less( 'top1BackgroundOpacity' ) / 100 ),
				'top1Text'                        => self::less( 'top1Text' ),
				'top1WidgetTitle'                 => self::less( 'top1WidgetTitle' ),

				'top2Background'              => self::less( 'top2Background,background-color' ),
				'top2BackgroundImage'         => self::less( 'top2Background,background-image' ),
				'top2BackgroundRepeat'        => self::less( 'top2Background,background-repeat' ),
				'top2BackgroundSize'          => self::less( 'top2Background,background-size' ),
				'top2BackgroundAttachment'    => self::less( 'top2Background,background-attachment' ),
				'top2BackgroundPosition'      => self::less( 'top2Background,background-position' ),
				'top2BackgroundOpacity'       => ( (int) self::less( 'top2BackgroundOpacity' ) / 100 ),
				'top2Text'                    => self::less( 'top2Text' ),
				'top2WidgetTitle'             => self::less( 'top2WidgetTitle' ),
			
				'top3Background'              => self::less( 'top3Background,background-color' ),
				'top3BackgroundImage'         => self::less( 'top3Background,background-image' ),
				'top3BackgroundRepeat'        => self::less( 'top3Background,background-repeat' ),
				'top3BackgroundSize'          => self::less( 'top3Background,background-size' ),
				'top3BackgroundAttachment'    => self::less( 'top3Background,background-attachment' ),
				'top3BackgroundPosition'      => self::less( 'top3Background,background-position' ),
				'top3BackgroundOpacity'       => ( (int) self::less( 'top3BackgroundOpacity' ) / 100 ),
				'top3Text'                    => self::less( 'top3Text' ),
				'top3WidgetTitle'             => self::less( 'top3WidgetTitle' ),

				//bottom colors
				'bottom1Background'           => self::less( 'bottom1Background,background-color' ),
				'bottom1BackgroundImage'      => self::less( 'bottom1Background,background-image' ),
				'bottom1BackgroundRepeat'     => self::less( 'bottom1Background,background-repeat' ),
				'bottom1BackgroundSize'       => self::less( 'bottom1Background,background-size' ),
				'bottom1BackgroundAttachment' => self::less( 'bottom1Background,background-attachment' ),
				'bottom1BackgroundPosition'   => self::less( 'bottom1Background,background-position' ),
				'bottom1BackgroundOpacity'    => ( (int) self::less( 'bottom1BackgroundOpacity' ) / 100 ),
				'bottom1Text'                 => self::less( 'bottom1Text' ),
				'bottom1WidgetTitle'          => self::less( 'bottom1WidgetTitle' ),

				'bottom2Background'            => self::less( 'bottom2Background,background-color' ),
				'bottom2BackgroundImage'       => self::less( 'bottom2Background,background-image' ),
				'bottom2BackgroundRepeat'      => self::less( 'bottom2Background,background-repeat' ),
				'bottom2BackgroundSize'        => self::less( 'bottom2Background,background-size' ),
				'bottom2BackgroundAttachment'  => self::less( 'bottom2Background,background-attachment' ),
				'bottom2BackgroundPosition'    => self::less( 'bottom2Background,background-position' ),
				'bottom2BackgroundOpacity'     => ( (int) self::less( 'bottom2BackgroundOpacity' ) / 100 ),
				'bottom2Text'                  => self::less( 'bottom2Text' ),
				'bottom2WidgetTitle'           => self::less( 'bottom2WidgetTitle' ),

				//footer colors
				'footerBackground'             => self::less( 'footerBackground,background-color' ),
				'footerBackgroundImage'        => self::less( 'footerBackground,background-image' ),
				'footerBackgroundRepeat'       => self::less( 'footerBackground,background-repeat' ),
				'footerBackgroundSize'         => self::less( 'footerBackground,background-size' ),
				'footerBackgroundAttachment'   => self::less( 'footerBackground,background-attachment' ),
				'footerBackgroundPosition'     => self::less( 'footerBackground,background-position' ),
				'footerBackgroundOpacity'      => ( (int) self::less( 'footerBackgroundOpacity' ) / 100 ),
				'footerText'                   => self::less( 'footerText' ),
				'footerWidgetTitle'            => self::less( 'footerWidgetTitle' ),
				
				//copyrights colors
				'copyrightsBackground'             => self::less( 'copyrightsBackground,background-color' ),
				'copyrightsBackgroundImage'        => self::less( 'copyrightsBackground,background-image' ),
				'copyrightsBackgroundRepeat'       => self::less( 'copyrightsBackground,background-repeat' ),
				'copyrightsBackgroundSize'         => self::less( 'copyrightsBackground,background-size' ),
				'copyrightsBackgroundAttachment'   => self::less( 'copyrightsBackground,background-attachment' ),
				'copyrightsBackgroundPosition'     => self::less( 'copyrightsBackground,background-position' ),
				'copyrightsBackgroundOpacity'      => ( (int) self::less( 'copyrightsBackgroundOpacity' ) / 100 ),
				'copyrightsText'                   => self::less( 'copyrightsText' ),
				'copyrightsWidgetTitle'            => self::less( 'copyrightsWidgetTitle' ),

				//widget styles
				'peColorBox1Bg'          => self::less( 'peColorBox1Bg' ),
				'peColorBox1Color'          => self::less( 'peColorBox1Color' ),
				'peColorBox2Bg'          => self::less( 'peColorBox2Bg' ),
				'peColorBox2Color'          => self::less( 'peColorBox2Color' ),
				'peColorBox3Bg'          => self::less( 'peColorBox3Bg' ),
				'peColorBox3Color'          => self::less( 'peColorBox3Color' ),
				'peColorBox4Bg'          => self::less( 'peColorBox4Bg' ),
				'peColorBox4Color'          => self::less( 'peColorBox4Color' ),

				//offcanvas
				'offcanvasWidth'               => self::less( 'off-canavs-width,width' ),
				'offcanvasBackground'          => self::less( 'offcanvasBackground' ),
				'offcanvasText'                => self::less( 'offcanvasText' ),
				'offcanvasWidgetTitle'         => self::less( 'offcanvasWidgetTitle' ),

				//blog effect
				'blogEffectBackgroundColor'    => self::less( 'blogEffectBackground,color' ),
				'blogEffectBackgroundRgba'     => self::less( 'blogEffectBackground,rgba' ),
				'blogEffectText'               => self::less( 'blogEffectText' ),
				'archiveEffectBackgroundColor' => self::less( 'archiveEffectBackground,color' ),
				'archiveEffectBackgroundRgba'  => self::less( 'archiveEffectBackground,rgba' ),
				'archiveEffectText'            => self::less( 'archiveEffectText' ),

				//wcag
				'wcagFocusColor'               => self::less( 'wcagFocusColor' ),

				//if settings below will change -> generate new CSS
				'settingsName'                 => self::less( 'settings_name' ),
				'compressCSS'                  => self::less( 'compress-css' ),
				'lessSourceMap'                => self::less( 'source-map' ),

			);

		}

		/**
		 * Method for changing current default values in arrays
		 *
		 * @param string $index Setting name in array
		 */
		public static function set( $index ) {
			if ( ! empty( $index ) && is_array( $index ) ) {

				self::$override  = $index;
				$current_default = self::$default;
				$current_redux   = self::$redux;

				//merge default and new settings (new settings will override default)
				self::$default = array_merge( $current_default, $index );
				//update redux array (load settings with selected options name)
				self::$redux = get_option( self::$default['settings_name'] );

			}
		}

		/**
		 * Method for getting options
		 *
		 * @param  string  $index      Setting name (coma separated if second array level)
		 * @param  string  $inline     Inline value (override)
		 * @param  boolean $emptycheck Check if var is empty
		 *
		 * @return string or false
		 */
		public static function get( $index = array(), $inline = null, $emptycheck = false ) {

			//merge default and redux settings (redux will override default)
			if ( is_array( self::$redux ) ) {
				$settings_array = array_merge( self::$default, self::$redux );
			}

			//string to array conversion
			$argsArray = explode( ',', $index );
			$count     = count( $argsArray );

			//one argument
			if ( $count == 1 ) {
				$param = $argsArray[0];
				if ( isset( $settings_array[ $param ] ) ) {
					$setting = $settings_array[ $param ];
				}
				if ( isset( self::$default[ $param ] ) ) {
					$default_setting = self::$default[ $param ];
				}
			} //two arguments
			elseif ( $count == 2 ) {
				$param1 = $argsArray[0];
				$param2 = $argsArray[1];
				if ( isset( $settings_array[ $param1 ][ $param2 ] ) ) {
					$setting = $settings_array[ $param1 ][ $param2 ];
				}
				if ( isset( self::$default[ $param1 ][ $param2 ] ) ) {
					$default_setting = self::$default[ $param1 ][ $param2 ];
				}
			} else {
				return false; //too many arguments
			}

			if ( $emptycheck ) {

				//bool to string
				if ( isset( $setting ) && is_bool( $setting ) ) {
					$setting = json_encode( $setting );
				}
				if ( isset( $default_setting ) && is_bool( $default_setting ) ) {
					$default_setting = json_encode( $default_setting );
				}

				//url
				if ( isset( $setting ) && ! filter_var( $setting, FILTER_VALIDATE_URL ) === false ) {
					$setting = '\'' . $setting . '\'';
				}

				if ( ! empty( $setting ) ) {
					$output = $setting;
				} elseif ( isset( $setting ) && is_numeric( $setting ) ) {
					$output = $setting;
				} elseif ( ! is_null( $inline ) ) {
					$output = $inline;
				} elseif ( isset( $default_setting ) ) {
					$output = $default_setting;
				} else {
					$output = 'no_variable';
				}

			} else {

				if ( isset( $setting ) ) {
					$output = $setting;
				} elseif ( ! is_null( $inline ) ) {
					$output = $inline;
				} elseif ( isset( $default_setting ) ) {
					$output = $default_setting;
				} else {
					$output = false;
				}

			}

			return $output;
		}

		/**
		 * Method for less variables
		 *
		 * @param  string $index  Setting name
		 * @param  string $inline Inline value (override)
		 *
		 * @return string value
		 */
		public static function less( $index, $inline = null ) {

			$output = self::get( $index, $inline, true );

			return $output;
		}

		/**
		 * Method for validate data
		 *
		 * @param  function $valid  Function which should be applied to var
		 * @param  string   $index  Setting name
		 * @param  string   $inline Inline value (override)
		 *
		 * @return string value
		 */
		public static function valid( $valid, $index, $inline = null ) {
			//validate output data
			$output = self::get( $index, $inline );

			if ( function_exists( $valid ) ) {
				$output = call_user_func( $valid, $output );
			}

			return $output;
		}

		/**
		 * Method for debug
		 *
		 * @param string $index Setting array
		 *
		 * @return html with array
		 */
		public static function d( $index = null ) {
			if ( $index == 'd' ) {
				echo '<pre><h2>Default</h2>';
				print_r( self::$default );
				echo '</pre>';
			} elseif ( $index == 'r' ) {
				echo '<pre><h2>Redux</h2>';
				print_r( self::$redux );
				echo '</pre>';
			} else {
				echo '<pre><h2>Default</h2>';
				print_r( self::$default );
				echo '</pre><pre><h2>Redux</h2>';
				print_r( self::$redux );
				echo '</pre>';
			}
		}

	}

	PEsettings::instance();

}

?>
