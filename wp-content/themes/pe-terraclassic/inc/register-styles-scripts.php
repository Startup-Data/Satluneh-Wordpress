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
/*	Load Required CSS Styles
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_theme_styles' ) ) {
	/**
	 * Add styles in front-end
	 */
	function pe_theme_styles() {
		if ( ! is_admin() ) {

			//get theme variables
			$theme = wp_get_theme();

			// register styles
			// ----------------------------

			if ( ! ( wp_style_is( 'normalize.min.css' ) ) ) {
				wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.min.css', array(), '5.0.0' );
			}
			if ( ! ( wp_style_is( 'animate.css' ) ) ) {
				wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array( 'normalize' ), '3.5.2' );
			}
			wp_dequeue_style( 'font-awesome' );
			wp_dequeue_style( 'font-awesome-css' );
			if ( ! (wp_style_is('all.css') ) ) {
				wp_enqueue_style( 'font-awesome-all',  get_template_directory_uri() . '/css/font-awesome/all.css', '', '5.12.0' );
			}
			if ( ! (wp_style_is('v4-shims.css') ) ) {
				wp_enqueue_style( 'font-awesome-v4-shims',  get_template_directory_uri() . '/css/font-awesome/v4-shims.css', '', '5.12.0' );
			}

			//theme
			wp_enqueue_style( 'pe-theme', get_template_directory_uri() . '/less/theme.less', array( 'normalize' ), $theme->get( 'Version' ) );

			//offcanvas
			wp_enqueue_style( 'pe-offcanvas', get_template_directory_uri() . '/less/offcanvas.less', array( 'pe-theme' ), $theme->get( 'Version' ) );

			//coming soon
			$future_time  = strtotime( PEsettings::get( 'coming-soon-until-date' ) );
			$current_time = current_time( 'timestamp' );

			if ( ! is_user_logged_in() && PEsettings::get( 'coming-soon' ) && $future_time && $current_time < $future_time ) {
				wp_enqueue_style( 'pe-comingsoon', get_template_directory_uri() . '/less/comingsoon.less', array( 'pe-theme' ), $theme->get( 'Version' ) );
			}

			//wcag
			/*if ( PEsettings::get( 'highContrast' ) ) {
				wp_enqueue_style( 'pe-high-contrast', get_template_directory_uri() . '/less/high-contrast.less', array( 'pe-theme' ), $theme->get( 'Version' ) );
			}
			if ( PEsettings::get( 'nightVersion' ) ) {
				wp_enqueue_style( 'pe-night-version', get_template_directory_uri() . '/less/night-version.less', array( 'pe-theme' ), $theme->get( 'Version' ) );
			}*/

			//rtl
			if ( is_rtl() ) {
				wp_enqueue_style( 'pe-rtl', get_template_directory_uri() . '/less/rtl.less', array( 'pe-theme' ), $theme->get( 'Version' ) );
			}

			//default style.css (parent or child theme)
			wp_enqueue_style( 'pe-style', get_stylesheet_directory_uri() . '/style.css', array( 'pe-theme' ), $theme->get( 'Version' ) );

			//dynamic css (css validation in redux framework)
			if ( PEsettings::get( 'dynamic-css' ) ) {
				$custom_css = wp_strip_all_tags( PEsettings::get( 'dynamic-css' ) );
				wp_add_inline_style( 'pe-style', $custom_css );
			}

			//fallback webfonts
			if ( ! class_exists( 'ReduxFramework' ) ) {
				wp_enqueue_style( 'pe-webfont', pe_fallback_fonts_url(), array(), $theme->get( 'Version' ) );
			}

		}
	}
}
add_action( 'wp_enqueue_scripts', 'pe_theme_styles', 99 );

if ( ! function_exists( 'pe_theme_custom_less' ) ) {
	/**
	 * Add custom.less
	 */
	function pe_theme_custom_less() {
		$customless = get_template_directory() . '/less/custom.less';
		if ( is_file( $customless ) && ! is_admin() ) {
			$theme = wp_get_theme();
			wp_enqueue_style( 'pe-custom', get_template_directory_uri() . '/less/custom.less', array(), $theme->get( 'Version' ) );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'pe_theme_custom_less', 99 );

if ( ! function_exists( 'pe_admin_styles' ) ) {
	/**
	 * Add styles in back-end
	 */
	function pe_admin_styles() {
		//get theme variables
		$theme = wp_get_theme();
		wp_enqueue_style( 'pe-admin', get_template_directory_uri() . '/css/admin.css', array(), $theme->get( 'Version' ), 'all' );
	}
}
add_action( 'admin_enqueue_scripts', 'pe_admin_styles' );

/*-----------------------------------------------------------------------------------*/
/*	Load Required JS Scripts
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'pe_theme_scripts' ) ) {
	/**
	 * Add scripts in front-end
	 */
	function pe_theme_scripts() {

		//get theme variables
		$theme = wp_get_theme();

		wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.6.0', true );
		wp_enqueue_script( 'jqvalidate', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ), '1.15.0', true );
		wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
		wp_enqueue_script( 'form', get_template_directory_uri() . '/js/jquery.form.js', array( 'jquery' ), '3.51', true );
		wp_enqueue_script( 'cookiejs', get_template_directory_uri() . '/js/js.cookie.js', array( 'jquery' ), '2.1.0', true );
		wp_enqueue_script( 'visible', get_template_directory_uri() . '/js/jquery.visible.min.js', array( 'jquery' ), '1.0', true );

		//retina display
		if ( PEsettings::get( 'retina-display-support' ) ) {
			wp_enqueue_script( 'retinajs', get_template_directory_uri() . '/js/retina.min.js', array( 'jquery' ), '1.3', true );
		}

		//wcag
		/*if ( PEsettings::get( 'nightVersion' ) or PEsettings::get( 'highContrast' ) or PEsettings::get( 'wideSite' ) or PEsettings::get( 'fontSizeSwitcher' ) ) {
			wp_enqueue_script( 'pe-wcag', get_template_directory_uri() . '/js/wcag.js', array( 'jquery' ), $theme->get( 'Version' ), true );
			$wcag_array = array(
				'cookiePath' => COOKIEPATH,
			);
			wp_localize_script( 'pe-wcag', 'pe_wcag_vars', $wcag_array );
		}*/

		//theme script
		wp_enqueue_script( 'pe-theme-js', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), $theme->get( 'Version' ), true );

		//google maps
		$googleMapKey = ( PEsettings::get( 'google-map-api-key' ) ) ? '?key=' . esc_attr( PEsettings::get( 'google-map-api-key' ) ) : '';
		if ( PEsettings::get( 'google-map-api' ) ) {
			wp_enqueue_script( 'google-maps-api', '//maps.googleapis.com/maps/api/js' . $googleMapKey, array(), '', false );

			if ( is_page_template( 'page-templates/page-contact.php' ) ) {

				$map_lati        = floatval( PEsettings::get( 'contact-map-latitiude' ) );
				$map_longi       = floatval( PEsettings::get( 'contact-map-longitude' ) );
				$map_zoom        = intval( PEsettings::get( 'contact-map-zoom' ) );
				$contact_address = esc_js( PEsettings::get( 'contact-address' ) );
				$show_tooltip    = ( PEsettings::get( 'contact-map-tooltip' ) ) ? 'true' : 'false';

				if ( PEsettings::get( 'contact-map' ) && $map_lati && $map_longi && $map_zoom ) {

					wp_enqueue_script( 'pe-contact-map', get_template_directory_uri() . '/js/contact-map.js', array( 'google-maps-api' ), $theme->get( 'Version' ), false );

					if ( ! empty( $contact_address ) ) {
						$address = $contact_address;
						$address = str_replace( '\n', '<br>', $address );
					} else {
						$address = $map_lati . '<br>' . $map_longi;
					}

					$map_array = array(
						'zoom'    => $map_zoom,
						'lati'    => $map_lati,
						'longi'   => $map_longi,
						'address' => $address,
						'tooltip' => $show_tooltip,
					);
					wp_localize_script( 'pe-contact-map', 'pe_cm_vars', $map_array );
				}

			}
		}

		//coming soon
		$future_time  = strtotime( PEsettings::get( 'coming-soon-until-date' ) );
		$current_time = current_time( 'timestamp' );

		if ( ! is_user_logged_in() && PEsettings::get( 'coming-soon' ) && $future_time && $current_time < $future_time ) {

			$future_date_formated = date( 'j F Y', $future_time );
			wp_enqueue_script( 'pe-coming-soon', get_template_directory_uri() . '/js/coming-soon.js', array( 'jquery' ), $theme->get( 'Version' ), true );
			// Localize the script with new data
			$cs_array = array(
				'format'  => esc_js( $future_date_formated ),
				'day'     => esc_html__( 'day', 'pe-terraclassic' ),
				'days'    => esc_html__( 'days', 'pe-terraclassic' ),
				'hour'    => esc_html__( 'hour', 'pe-terraclassic' ),
				'hours'   => esc_html__( 'hours', 'pe-terraclassic' ),
				'minute'  => esc_html__( 'minute', 'pe-terraclassic' ),
				'minutes' => esc_html__( 'minutes', 'pe-terraclassic' ),
				'second'  => esc_html__( 'second', 'pe-terraclassic' ),
				'seconds' => esc_html__( 'seconds', 'pe-terraclassic' ),
			);
			wp_localize_script( 'pe-coming-soon', 'pe_cs_vars', $cs_array );

		}

		if ( ! is_user_logged_in() && ( is_page_template( 'page-templates/page-login.php' ) || is_page_template( 'page-templates/page-registration.php' ) || is_active_widget( false, false, 'pe_login_popup' ) ) ) {
			$script = "
			jQuery('.login-username input#user').attr('placeholder', " . json_encode( esc_html__( 'Username or Email', 'pe-terraclassic' ) ) . ");
			jQuery('.login-password input#pass').attr('placeholder', " . json_encode( esc_html__( 'Password', 'pe-terraclassic' ) ) . ");
			";
			wp_add_inline_script( 'pe-theme-js', $script );
		}

	}
}
add_action( 'wp_enqueue_scripts', 'pe_theme_scripts' );

if ( ! function_exists( 'pe_theme_admin_scripts' ) ) {
	function pe_theme_admin_scripts( $hook ) {
		wp_enqueue_script( 'pe-admin-script', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '1.0', true );
			// Localize the script with new data
			$admin_vars_array = array(
				'theme_options'  => __( 'Go to <a href="admin.php?page=pixelemu_options&tab=1"><strong>Theme Options</strong></a> to see theme settings.', 'pe-terraclassic' ),
			);
			wp_localize_script( 'pe-admin-script', 'pe_admin_vars', $admin_vars_array );
	}
	add_action( 'admin_enqueue_scripts', 'pe_theme_admin_scripts' );
}
?>
